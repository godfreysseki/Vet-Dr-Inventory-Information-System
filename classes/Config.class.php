<?php
  
  class Config
  {
    private $connection;
    private $data = [];
    
    public function __construct()
    {
      $this->connection            = Database::getInstance()->getConnection();
      $this->data['COMPANY']       = $this->fetchFromDatabase('company_name');
      $this->data['MOTTO']         = $this->fetchFromDatabase('company_slogan');
      $this->data['LOCATION']      = $this->fetchFromDatabase('address');
      $this->data['COMPANYEMAIL']  = $this->fetchFromDatabase('email');
      $this->data['COMPANYPHONE']  = $this->fetchFromDatabase('phone1');
      $this->data['COMPANYPHONE2'] = $this->fetchFromDatabase('phone2');
      $this->data['CURRENCY']      = $this->fetchFromDatabase('currency');
    }
    
    // Function to sanitize user inputs
    private function sanitizeInput($data)
    {
      return $this->connection->real_escape_string($data);
    }
    
    // Template for SELECT query
    public function selectQuery($sql, $params = [])
    {
      $stmt = $this->connection->prepare($sql);
      
      if ($stmt === false) {
        die('Error in SELECT query preparation: ' . $this->connection->error);
      }
      
      if (!empty($params)) {
        $paramTypes = str_repeat('s', count($params));
        $stmt->bind_param($paramTypes, ...$params);
      }
      
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();
      
      return $result;
    }
    
    // Template for INSERT query
    public function insertQuery($sql, $params = [])
    {
      $stmt = $this->connection->prepare($sql);
      
      if ($stmt === false) {
        die('Error in INSERT query preparation: ' . $this->connection->error);
      }
      
      if (!empty($params)) {
        $paramTypes = str_repeat('s', count($params));
        $stmt->bind_param($paramTypes, ...$params);
      }
      
      $stmt->execute();
      $insertedId = $stmt->insert_id;
      $stmt->close();
      
      return $insertedId;
    }
    
    // Template for UPDATE query
    public function updateQuery($sql, $params = [])
    {
      $stmt = $this->connection->prepare($sql);
      
      if ($stmt === false) {
        die('Error in UPDATE query preparation: ' . $this->connection->error);
      }
      
      if (!empty($params)) {
        $paramTypes = str_repeat('s', count($params));
        $stmt->bind_param($paramTypes, ...$params);
      }
      
      $stmt->execute();
      $updatedRows = $stmt->affected_rows;
      $stmt->close();
      
      return $updatedRows;
    }
    
    // Template for DELETE query
    public function deleteQuery($sql, $params = [])
    {
      $stmt = $this->connection->prepare($sql);
      
      if ($stmt === false) {
        die('Error in DELETE query preparation: ' . $this->connection->error);
      }
      
      if (!empty($params)) {
        $paramTypes = str_repeat('s', count($params));
        $stmt->bind_param($paramTypes, ...$params);
      }
      
      $stmt->execute();
      $deletedRows = $stmt->affected_rows;
      $stmt->close();
      
      return $deletedRows;
    }
    
    public function beginTransaction()
    {
      $this->connection->begin_transaction();
    }
    
    public function commitTransaction()
    {
      $this->connection->commit();
    }
    
    public function rollbackTransaction()
    {
      $this->connection->rollback();
    }
    
    public function closeConnection()
    {
      $this->connection->close();
    }
    
    public function recordStockMovement($productId, $warehouseId, $movementType, $quantity)
    {
      // Implement the logic to record a stock movement
      // Update stock quantities, log the movement, etc.
      $sql = "INSERT INTO stockmovements (product_id, warehouse_id, movement_type, quantity, movement_date)
            VALUES (?, ?, ?, ?, NOW())";
      
      $this->insertQuery($sql, [$productId, $warehouseId, $movementType, $quantity]);
      
      // Update stock quantities
      $products = new Products();
      $products->updateStockQuantities($productId, $movementType, $quantity);
    }
    
    public function getStockMovement()
    {
      $sql    = "SELECT stockmovements.*, products.*, warehouses.* FROM stockmovements JOIN products ON stockmovements.product_id=products.product_id JOIN warehouses ON stockmovements.warehouse_id = warehouses.warehouse_id ORDER BY movement_id DESC";
      $result = $this->selectQuery($sql);
      
      $movements = [];
      while ($row = $result->fetch_assoc()) {
        $movements[] = $row;
      }
      
      return $movements;
    }
    
    // Working on constants
    private function fetchFromDatabase($key)
    {
      $sql    = "SELECT * FROM general_settings";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return $result[$key];
    }
    
    public function get($key)
    {
      // Return the configuration value based on the given key
      return isset($this->data[$key]) ? $this->data[$key] : null;
    }
    
    public function getUserName($user_id)
    {
      // Retrieve item name from the database based on item ID
      $sql    = "SELECT full_name FROM users WHERE user_id = ?";
      $params = [$user_id];
      $result = $this->selectQuery($sql, $params);
      
      $row = $result->fetch_assoc();
      
      return ($row) ? $row['full_name'] : '';
    }
    
    public function getItemName($item_id)
    {
      // Retrieve item name from the database based on item ID
      $sql    = "SELECT item_name FROM inventory WHERE item_id = ?";
      $params = [$item_id];
      $result = $this->selectQuery($sql, $params);
      
      $row = $result->fetch_assoc();
      
      return ($row) ? $row['item_name'] : '';
    }
    
    public function getClientName($client_id)
    {
      // Retrieve client name from the database based on client ID
      $sql    = "SELECT name FROM clients WHERE client_id = ?";
      $params = [$client_id];
      $result = $this->selectQuery($sql, $params);
      
      $row = $result->fetch_assoc();
      
      return ($row) ? $row['name'] : '';
    }
    
    public function getAnimalName($animal_id)
    {
      // Retrieve animal details (name and client name) from the database based on animal ID
      $sql    = "SELECT animals.name AS animal_name, clients.name AS client_name
                FROM animals
                INNER JOIN clients ON animals.client_id = clients.client_id
                WHERE animals.animal_id = ?";
      $params = [$animal_id];
      $result = $this->selectQuery($sql, $params);
      
      $row = $result->fetch_assoc();
      return ($row) ? $row['animal_name'] . ' - ' . $row['client_name'] : '';
    }
    
    public function getUsersComboOptions($selectedId = null)
    {
      // Fetch animal data from the database
      $sql    = "SELECT * FROM users";
      $result = $this->selectQuery($sql);
      
      // Generate HTML options
      $options = '';
      while ($row = $result->fetch_assoc()) {
        $selected = ($row['user_id'] == $selectedId) ? 'selected' : '';
        $options  .= '<option value="' . $row['user_id'] . '" ' . $selected . '>' . $row['full_name'] . ' - '.ucwords($row['role']).'</option>';
      }
      
      return $options;
    }
    
    public function getAnimalComboOptions($selectedId = null)
    {
      // Fetch animal data from the database
      $sql    = "SELECT animal_id, animals.name AS animal_name, clients.name AS client_name, address FROM animals INNER JOIN clients ON animals.client_id=clients.client_id";
      $result = $this->selectQuery($sql);
      
      // Generate HTML options
      $options = '';
      while ($row = $result->fetch_assoc()) {
        $selected = ($row['animal_id'] == $selectedId) ? 'selected' : '';
        $options  .= '<option value="' . $row['animal_id'] . '" ' . $selected . '>' . $row['animal_name'] . ' - ' . $row['client_name'] . ' (' . $row['address'] . ')</option>';
      }
      
      return $options;
    }
    
    public function getClientComboOptions($selectedId = null)
    {
      // Fetch client data from the database
      $sql    = "SELECT * FROM clients";
      $result = $this->selectQuery($sql);
      
      // Generate HTML options
      $options = '';
      while ($row = $result->fetch_assoc()) {
        $selected = ($row['client_id'] == $selectedId) ? 'selected' : '';
        $options  .= '<option value="' . $row['client_id'] . '" ' . $selected . '>' . $row['name'] . ' (' . $row['address'] . ') - ' . $row['contact_number'] . '</option>';
      }
      
      return $options;
    }
    
    public function getItemComboOptions($selectedId = null)
    {
      // Fetch item data from the database
      $sql    = "SELECT item_id, item_name, manufacturer FROM inventory";
      $result = $this->selectQuery($sql);
      
      // Generate HTML options
      $options = '';
      while ($row = $result->fetch_assoc()) {
        $selected = ($row['item_id'] == $selectedId) ? 'selected' : '';
        $options  .= '<option value="' . $row['item_id'] . '" ' . $selected . '>' . $row['item_name'] . ' - ' . $row['manufacturer'] . '</option>';
      }
      
      return $options;
    }
    
    // Working on notifications and system alerts and vitals of the system for better performance
    public function checkVitals()
    {
      // Check Stock levels and add stock notification
      $sql    = "SELECT products.*, suppliers.*, if(reorder_level<=quantity_in_stock, 'High', 'Low') AS levels FROM products JOIN suppliers ON products.supplier_id=suppliers.supplier_id";
      $result = $this->selectQuery($sql);
      $items  = [];
      while ($row = $result->fetch_assoc()) {
        $items[] = $row;
      }
      return $items;
    }
    
    public function addAlerts()
    {
      $products = $this->checkVitals();
      foreach ($products as $product) {
        if ($product['levels'] === "Low") {
          // check notification existance
          // 3 Days ago
          $days   = date("Y-m-d H:i:s", strtotime("-3 days", $_SERVER['REQUEST_TIME']));
          $check  = "SELECT * FROM stockalerts WHERE product_id=? && alert_quantity=? && alert_date>=? ";
          $params = [$product['product_id'], $product['quantity_in_stock'], $days];
          $result = $this->selectQuery($check, $params);
          if ($result->num_rows === 0) {
            // Insert if new notification
            $sql    = "INSERT INTO stockalerts (product_id, alert_quantity, alert_date, seen) VALUES (?, ?, ?, ?)";
            $params = [$product['product_id'], $product['quantity_in_stock'], date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']), "No"];
            $this->insertQuery($sql, $params);
          }
        }
      }
    }
    
    public function countNewAlerts()
    {
      $sql    = "SELECT count(alert_id) AS alerts FROM stockalerts WHERE seen='No' ";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return $result['alerts'];
    }
    
    // list a few alerts or count and group them as in 3 products out of stock, 2 new users etc
    public function showAlertCategories()
    {
      $sql    = "SELECT stockalerts.*, products.* FROM stockalerts JOIN products ON stockalerts.product_id = products.product_id WHERE seen='No' ";
      $result = $this->selectQuery($sql);
      $no     = 1;
      $alerts = '';
      while (($row = $result->fetch_assoc()) && ($no <= 5)) {
        $alerts = '<a href="javascript:void(0)" class="dropdown-item">
                    <b>' . $row['product_name'] . '</b> needs restocking.
                  </a>
                  <div class="dropdown-divider"></div>';
        $no++;
      }
      
      return $alerts;
    }
    
    public function showAlerts()
    {
      $sql    = "SELECT stockalerts.*, products.* FROM stockalerts JOIN products ON stockalerts.product_id=products.product_id ORDER BY alert_id DESC, seen ASC ";
      $result = $this->selectQuery($sql);
      
      $alerts = [];
      while ($row = $result->fetch_assoc()) {
        $alerts[] = $row;
      }
      
      return $alerts;
    }
    
    public function markAlertAsSeen($alertId = null)
    {
      if ($alertId !== null) {
        $sql    = "UPDATE stockalerts SET seen='Yes' WHERE alert_id=?";
        $params = [$alertId];
        $id     = $this->updateQuery($sql, $params);
        return alert('success', 'Notification Seen. Id' . $id);
      } else {
        $sql = "UPDATE stockalerts SET seen='Yes' WHERE seen='No' ";
        $this->updateQuery($sql);
        return alert('success', 'All notifications seen successfully.');
      }
    }
    
    // Others for receipt formatting
    public function receiptHeaded()
    {
      $data   = [];
      $sql    = "SELECT * FROM general_settings";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row;
        }
      }
      return $data;
    }
    
    public function signature($person, $fullname)
    {
      $line = "<div class='container-fluid'>
                <div class='row'>
                  <div class='col-sm-3'>
                    <div style='border-bottom: 1px solid darkgrey; padding-top: 30px;'></div>
                    <div>" . ucwords(strtolower($fullname)) . "<br>" . strtoupper($person) . "</div>
                  </div>
                  <div class='col-sm-3'></div>
                  <div class='col-sm-3'></div>
                  <div class='col-sm-3'></div>
                </div>
               </div>";
      
      return $line;
    }
    
  }