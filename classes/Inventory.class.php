<?php
  
  
  class Inventory extends Config
  {
    private $auditTrail;
  
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
  
    public function saveItem($data, $user_id)
    {
      if (isset($data['item_id']) && !empty($data['item_id'])) {
        return $this->updateItem($data, $user_id);
      } else {
        return $this->insertItem($data, $user_id);
      }
    }
  
    private function insertItem($data, $user_id)
    {
      $sql    = "INSERT INTO inventory (item_name, quantity, cost_price, selling_price, expiry_date, batch_number, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $params = [
        $data['item_name'],
        $data['quantity'],
        $data['cost_price'],
        $data['selling_price'],
        $data['expiry_date'],
        $data['batch_number'],
        $user_id
      ];
    
      $insertedId = $this->insertQuery($sql, $params);
    
      if ($insertedId) {
        $this->auditTrail->logActivity($user_id, 1, $insertedId, 'Added inventory item', 'Inventory item inserted with ID ' . $insertedId, 'Inventory', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Inventory item inserted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to insert inventory item.']);
      }
    }
  
    private function updateItem($data, $user_id)
    {
      $sql    = "UPDATE inventory SET item_name = ?, quantity = ?, cost_price = ?, selling_price = ?, expiry_date = ?, batch_number = ?, user_id = ? WHERE item_id = ?";
      $params = [
        $data['item_name'],
        $data['quantity'],
        $data['cost_price'],
        $data['selling_price'],
        $data['expiry_date'],
        $data['batch_number'],
        $user_id,
        $data['item_id']
      ];
    
      $updatedRows = $this->updateQuery($sql, $params);
    
      if ($updatedRows) {
        $this->auditTrail->logActivity($user_id,2, $data['item_id'],'Updated inventory item', 'Inventory item updated with ID ' . $data['item_id'], 'Inventory', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Inventory item updated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to update inventory item.']);
      }
    }
  
    public function deleteItem($item_id, $user_id)
    {
      $sql    = "DELETE FROM inventory WHERE item_id = ?";
      $params = [$item_id];
    
      $deletedRows = $this->deleteQuery($sql, $params);
    
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $item_id, 'Deleted Inventory Item', 'Inventory item deleted with ID ' . $item_id, 'Inventory', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Inventory item deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Inventory Item already deleted. Reload to see effect']);
      }
    }
  
    public function getAllInventory()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM inventory ORDER BY item_id DESC";
    
      // Execute the query and fetch the results
      $result = $this->selectQuery($sql);
    
      // Initialize an array to store the fetched data
      $animalsData = [];
    
      // Fetch each row as an associative array
      while ($row = $result->fetch_assoc()) {
        $animalsData[] = $row;
      }
    
      return $animalsData;
    }
  
    public function displayInventoryTable()
    {
      $inventoryData = $this->getAllInventory(); // Assume you have a method to fetch all animals data
    
      // DataTables HTML
      $tableHtml = '<div class="table-responsive">
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        <th>Expiry Date</th>
                        <th>Batch No.</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
      // Populate table rows with data
      foreach ($inventoryData as $inventory) {
        $tableHtml .= '
                <tr>
                    <td>' . $inventory['item_id'] . '</td>
                    <td>' . $this->getItemName($inventory['item_name']) . '</td>
                    <td>' . number_format($inventory['quantity']) . '</td>
                    <td>' . number_format($inventory['cost_price']) . '</td>
                    <td>' . number_format($inventory['selling_price']) . '</td>
                    <td>' . $inventory['expiry_date'] . '</td>
                    <td>' . $inventory['batch_number'] . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-info btn-sm editInventory" data-id="' . $inventory['item_id'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteInventory" data-id="' . $inventory['item_id'] . '">Delete</button>
                    </td>
                </tr>';
      }
    
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table></div>';
    
      return $tableHtml;
    }
  
    public function getItemById($item_id)
    {
      $sql    = "SELECT * FROM inventory WHERE item_id = ?";
      $params = [$item_id];
    
      $result = $this->selectQuery($sql, $params);
    
      return $result->fetch_assoc();
    }
  
    public function displayItemForm($item_id = null)
    {
      if ($item_id !== null) {
        $data = $this->getItemById($item_id);
      } else {
        $data = [
          'item_id' => '',
          'item_name' => '',
          'quantity' => '',
          'cost_price' => '',
          'selling_price' => '',
          'expiry_date' => '',
          'batch_number' => ''
          // Add more fields as needed
        ];
      }
    
      $form = '
        <form class="needs-validation" method="post" id="inventoryForm" novalidate>
            <input type="hidden" name="item_id" value="' . $data['item_id'] . '">
            
            <div class="form-group">
                <label for="item_name">Item Name:</label>
                <select class="custom-select select2" id="item_name" name="item_name" required>
                  '.$this->getItemComboOptions($data['item_name']).'
                </select>
                <div class="invalid-feedback">Please enter the item name.</div>
            </div>
            
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="text" class="form-control" id="quantity" name="quantity" value="' . $data['quantity'] . '" required>
                <div class="invalid-feedback">Please enter the quantity.</div>
            </div>
            
            <div class="form-group">
                <label for="cost_price">Cost Price:</label>
                <input type="text" class="form-control" id="cost_price" name="cost_price" value="' . $data['cost_price'] . '" required>
                <div class="invalid-feedback">Please enter the cost price.</div>
            </div>
            
            <div class="form-group">
                <label for="selling_price">Selling Price:</label>
                <input type="text" class="form-control" id="selling_price" name="selling_price" value="' . $data['selling_price'] . '" required>
                <div class="invalid-feedback">Please enter the selling price.</div>
            </div>
            
            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="' . $data['expiry_date'] . '" required>
                <div class="invalid-feedback">Please enter the expiry date.</div>
            </div>
            
            <div class="form-group">
                <label for="batch_number">Batch Number:</label>
                <input type="text" class="form-control" id="batch_number" name="batch_number" value="' . $data['batch_number'] . '" required>
                <div class="invalid-feedback">Please enter the batch number or receipt number.</div>
            </div>
            
            <!-- Add more form fields as needed -->
            
            <button type="submit" class="btn btn-primary">Save</button>
        </form>';
    
      return $form;
    }
  
  }