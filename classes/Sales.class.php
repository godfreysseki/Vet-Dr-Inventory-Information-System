<?php
  
  
  class Sales extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function saveSale($data, $user_id)
    {
      if (isset($data['sale_id']) && !empty($data['sale_id'])) {
        return $this->updateSale($data, $user_id);
      } else {
        return $this->insertSale($data, $user_id);
      }
    }
    
    private function insertSale($data, $user_id)
    {
      $sql = "INSERT INTO sales (sale_date, item_id, quantity_sold, sale_amount, user_id) VALUES (?, ?, ?, ?, ?)";
      $params = [
        $data['date'],
        $data['item_id'],
        $data['quantity_sold'],
        $data['sale_amount'],
        $user_id
      ];
      
      $insertedId = $this->insertQuery($sql, $params);
      
      if ($insertedId) {
        $this->auditTrail->logActivity($user_id, 1, $insertedId, 'Added Sales Record', 'Sale record inserted with ID ' . $insertedId, 'Sales', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Sale record inserted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to insert sale record.']);
      }
    }
    
    private function updateSale($data, $user_id)
    {
      $sql = "UPDATE sales SET date = ?, item_id = ?, quantity_sold = ?, sale_amount = ?, user_id = ? WHERE sale_id = ?";
      $params = [
        $data['sale_date'],
        $data['customer_name'],
        $data['total_amount'],
        $user_id,
        $data['sale_id']
      ];
  
      $updatedRows = $this->updateQuery($sql, $params);
  
      if ($updatedRows) {
        $this->auditTrail->log('Sale updated with ID ' . $data['sale_id'], $user_id);
        return json_encode(['status' => 'success', 'message' => 'Sale updated successfully.']);
      } else {
        return json_encode([
          'status' => 'warning',
          'message' => 'Failed to update sale record.'
        ]);
      }
    }
  
    public function deleteSale($sale_id, $user_id)
    {
      $sql = "DELETE FROM sales WHERE sale_id = ?";
      $params = [$sale_id];
    
      $deletedRows = $this->deleteQuery($sql, $params);
    
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $sale_id, 'Deleted Sales Record', 'Sale record deleted with ID ' . $sale_id, 'Sales', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Sale record deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Sales Record already deleted. Reload page to see effects.']);
      }
    }
  
    public function getAllSales()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM sales";
    
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
  
    public function displaySalesTable()
    {
      $salesData = $this->getAllSales(); // Assume you have a method to fetch all animals data
  
      // Generate HTML table
      $htmlTable = '<table class="table table-sm table-hover table-striped dataTable">';
      $htmlTable .= '<thead><tr><th>Sale ID</th><th>Date</th><th>Item ID</th><th>Quantity</th><th>Total Price</th><th>Tenant</th><th>Action</th></tr></thead><tbody>';
  
      foreach ($salesData as $sale) {
        $htmlTable .= '<tr>';
        $htmlTable .= '<td>' . $sale['sale_id'] . '</td>';
        $htmlTable .= '<td>' . $sale['sale_date'] . '</td>';
        $htmlTable .= '<td>' . $this->getItemName($sale['item_id']) . '</td>';
        $htmlTable .= '<td>' . $sale['quantity_sold'] . '</td>';
        $htmlTable .= '<td>' . $sale['sale_amount'] . '</td>';
        $htmlTable .= '<td>' . $this->getUserName($sale['user_id']) . '</td>';
        $htmlTable .= '<td>
                        <button class="btn btn-info btn-sm editSales" data-id="' . $sale['sale_id'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteSales" data-id="' . $sale['sale_id'] . '">Delete</button>
                      </td>';
        $htmlTable .= '</tr>';
      }
  
      $htmlTable .= '</tbody></table>';
  
      return $htmlTable;
    }
  
    public function getSaleById($sale_id)
    {
      $sql = "SELECT * FROM sales WHERE sale_id = ?";
      $params = [$sale_id];
    
      $result = $this->selectQuery($sql, $params);
    
      return $result->fetch_assoc();
    }
  
    public function displaySaleForm($sale_id = null)
    {
      if ($sale_id !== null) {
        $data = $this->getSaleById($sale_id);
      } else {
        $data = [
          'sale_id' => '',
          'sale_date' => '',
          'item_id' => '',
          'quantity_sold' => '',
          'sale_amount' => ''
          // Add more fields as needed
        ];
      }
    
      $form = '
        <form class="needs-validation" method="post" id="salesForm" novalidate>
            <input type="hidden" name="sale_id" value="' . $data['sale_id'] . '">
            
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" value="' . $data['sale_date'] . '" required>
                <div class="invalid-feedback">Please enter the date.</div>
            </div>
            
            <div class="form-group">
                <label for="item_id">Item ID:</label>
                <select class="custom-select select2" id="item_id" name="item_id" required>
                  ' . $this->getItemComboOptions($data['item_id']) . '
                </select>
                <div class="invalid-feedback">Please enter the item ID.</div>
            </div>
            
            <div class="form-group">
                <label for="quantity_sold">Quantity:</label>
                <input type="text" class="form-control" id="quantity_sold" name="quantity_sold" value="' . $data['quantity_sold'] . '" required>
                <div class="invalid-feedback">Please enter the quantity.</div>
            </div>
            
            <div class="form-group">
                <label for="sale_amount">Total Price:</label>
                <input type="text" class="form-control" id="sale_amount" name="sale_amount" value="' . $data['sale_amount'] . '" required>
                <div class="invalid-feedback">Please enter the total price.</div>
            </div>
            
            <!-- Add more form fields as needed -->
            
            <button type="submit" class="btn btn-primary">Save</button>
        </form>';
    
      return $form;
    }
  
  }
