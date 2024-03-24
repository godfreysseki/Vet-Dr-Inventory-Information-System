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
        $this->updateQuery("UPDATE products SET quantity_in_stock=quantity_in_stock+? WHERE product_id=?", [$data['quantity'], $data['item_name']]);
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
        $this->auditTrail->logActivity($user_id, 2, $data['item_id'], 'Updated inventory item', 'Inventory item updated with ID ' . $data['item_id'], 'Inventory', 'Success');
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
                  ' . $this->getItemComboOptions($data['item_name']) . '
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
    
    // Stock Movement
    public function saveStockMovement($data, $user_id)
    {
      if (isset($data['movement_id']) && !empty($data['movement_id'])) {
        return $this->updateStockMovement($data, $user_id);
      } else {
        return $this->insertStockMovement($data, $user_id);
      }
    }
    
    private function insertStockMovement($data, $user_id)
    {
      if (!isset($_SESSION['stock_movement_track_number'])) {
        $_SESSION['stock_movement_track_number'] = randomCode(6);
      }
      $track_number = $_SESSION['stock_movement_track_number'];
      $sql          = "INSERT INTO stock_movement (track_number, product_id, movement_type, quantity, remarks, user_id) VALUES (?, ?, ?, ?, ?, ?)";
      $params       = [
        $track_number,
        $data['product_id'],
        $data['movement_type'],
        $data['quantity'],
        $data['remarks'],
        $user_id
      ];
      
      $insertedId = $this->insertQuery($sql, $params);
      
      if ($insertedId) {
        // Update quantity in products
        $this->updateQuery("UPDATE products SET quantity_in_stock=quantity_in_stock-? WHERE product_id=?", [$data['quantity'], $data['product_id']]);
        $this->auditTrail->logActivity($user_id, 1, $insertedId, 'Added a stock movement', 'Stock movement inserted with ID ' . $insertedId, 'Stock Movement', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Stock movement record inserted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Failed to insert stock movement record.']);
      }
    }
    
    private function updateStockMovement($data, $user_id)
    {
      $sql    = "UPDATE stock_movement SET product_id = ?, movement_type = ?, quantity = ?, remarks = ?, user_id = ? WHERE movement_id = ?";
      $params = [
        $data['product_id'],
        $data['movement_type'],
        $data['quantity'],
        $data['remarks'],
        $user_id,
        $data['movement_id']
      ];
      
      $updatedRows = $this->updateQuery($sql, $params);
      
      if ($updatedRows) {
        $this->auditTrail->logActivity($user_id, 2, $data['movement_id'], 'Updated Stock Movement', 'Stock movement updated with ID ' . $data['movement_id'], 'Stock Movement', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Stock movement record updated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'No changes made to the record.']);
      }
    }
    
    public function deleteStockMovement($movement_id, $user_id)
    {
      $sql    = "DELETE FROM stock_movement WHERE movement_id = ?";
      $params = [$movement_id];
      
      $deletedRows = $this->deleteQuery($sql, $params);
      
      if ($deletedRows) {
        $this->auditTrail->logActivity($user_id, 3, $movement_id, 'Deleted Stock Movement', 'Stock Movement deleted with ID ' . $movement_id, 'Stock Movement', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Stock Movement deleted successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Stock Movement already deleted. Reload to see effect']);
      }
    }
    
    public function getAllStockMovements()
    {
      // Sample SQL query to select all animals
      $sql = "SELECT * FROM stock_movement ORDER BY movement_id DESC";
      
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
    
    public function displayStockMovementTable()
    {
      $inventoryData = $this->getAllStockMovements(); // Assume you have a method to fetch all animals data
      $no = 1;
  
      // DataTables HTML
      $tableHtml = '<div class="table-responsive">
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Track No.</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Moved</th>
                        <th>Date</th>
                        <th>Remark</th>
                        <th>Assessed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
      
      // Populate table rows with data
      foreach ($inventoryData as $inventory) {
        $tableHtml .= '
                <tr>
                    <td>' . $no . '</td>
                    <td>' . $inventory['track_number'] . '</td>
                    <td>' . $this->getItemName($inventory['product_id']) . '</td>
                    <td>' . number_format($inventory['quantity']) . '</td>
                    <td>' . $inventory['movement_type'] . '</td>
                    <td>' . datel($inventory['movement_date']) . '</td>
                    <td>' . $inventory['remarks'] . '</td>
                    <td>' . (($inventory['return_quantity'] === null) ? "No" : "Yes") . '</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <button class="btn btn-success btn-sm assessStockMovement" data-id="' . $inventory['movement_id'] . '">Assess</button>
                        <a href="print_stock_movement.php?id=' . $inventory['track_number'] . '" target="_blank" class="btn btn-primary btn-sm printStockMovement" data-id="' . $inventory['movement_id'] . '">Print</a>
                        <button class="btn btn-info btn-sm editStockMovement" data-id="' . $inventory['movement_id'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteStockMovement" data-id="' . $inventory['movement_id'] . '">Delete</button>
                    </td>
                </tr>';
        $no++;
      }
      
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table></div>';
      
      return $tableHtml;
    }
    
    public function getStockMovementById($movement_id)
    {
      $sql    = "SELECT * FROM stock_movement WHERE movement_id = ?";
      $params = [$movement_id];
      
      $result = $this->selectQuery($sql, $params);
      
      return $result->fetch_assoc();
    }
    
    public function displayStockMovementForm($movement_id = null)
    {
      if ($movement_id !== null) {
        $data = $this->getStockMovementById($movement_id);
      } else {
        $data = [
          'movement_id' => '',
          'product_id' => '',
          'movement_type' => '',
          'quantity' => '',
          'remarks' => ''
        ];
      }
      
      $form = '
        <form class="needs-validation" method="post" id="stockMovementForm" novalidate>
            <input type="hidden" name="movement_id" value="' . $data['movement_id'] . '">
            
            <div class="form-group">
                <label for="product_id">Product ID:</label>
                <select class="custom-select select2" id="product_id" name="product_id" required>
                  ' . $this->getItemComboOptions($data['product_id']) . '
                </select>
                <div class="invalid-feedback">Please enter the product ID.</div>
            </div>
            
            <div class="form-group">
                <label for="movement_type">Movement Type:</label>
                <select class="form-control" id="movement_type" name="movement_type" required>
                    <option value="OUT" ' . (($data['movement_type'] === 'OUT') ? "selected" : "") . '>OUT</option>
                    <option value="IN" ' . (($data['movement_type'] === 'IN') ? "selected" : "") . '>IN</option>
                </select>
                <div class="invalid-feedback">Please select the movement type.</div>
            </div>
            
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="text" class="form-control" id="quantity" name="quantity" value="' . $data['quantity'] . '" required>
                <div class="invalid-feedback">Please enter the quantity.</div>
            </div>
            
            <div class="form-group">
                <label for="remarks">Remarks:</label>
                <textarea class="form-control" id="remarks" name="remarks" required>' . $data['remarks'] . '</textarea>
                <div class="invalid-feedback">Please enter remarks.</div>
            </div>
            
            <button type="submit" class="btn btn-primary">Save</button>
        </form>';
      
      return $form;
    }
    
    // Assessing the returns
    public function displayAssessmentForm($movement_id = null)
    {
      if ($movement_id !== null) {
        $data = $this->getStockMovementById($movement_id);
      } else {
        // Set default data if no movement ID is provided
        $data = [
          'movement_id' => '',
          'product_id' => '',
          'return_quantity' => '',
          'selling_price' => '',
          'service_fee' => '',
          'return_remark' => ''
        ];
      }
      
      // Generate the HTML form
      $form = '
        <form class="needs-validation" method="post" id="stockMovementReturnsForm" novalidate>
            <input type="hidden" name="movement_id" value="' . $data['movement_id'] . '">
            <input type="hidden" name="product_id" value="' . $data['product_id'] . '">
            
            <div class="form-group">
                <label for="return_quantity">Return Quantity:</label>
                <input type="number" min="0" class="form-control" id="return_quantity" name="return_quantity" value="' . $data['return_quantity'] . '" required>
                <div class="invalid-feedback">Please enter the return quantity.</div>
            </div>
            
            <div class="form-group">
                <label for="selling_price">Selling Price:</label>
                <input type="number" min="0" class="form-control" id="selling_price" name="selling_price" value="' . $data['selling_price'] . '" required>
                <div class="invalid-feedback">Please enter the selling price.</div>
            </div>
            
            <div class="form-group">
                <label for="service_fee">Service Fee:</label>
                <input type="number" min="0" class="form-control" id="service_fee" name="service_fee" value="' . $data['service_fee'] . '" required>
                <div class="invalid-feedback">Please enter the service fee.</div>
            </div>
            
            <div class="form-group">
                <label for="return_remark">Return Remark:</label>
                <textarea class="form-control" id="return_remark" name="return_remark" required>' . $data['return_remark'] . '</textarea>
                <div class="invalid-feedback">Please enter return remarks.</div>
            </div>
            
            <button type="submit" class="btn btn-primary">Save</button>
        </form>';
      
      return $form;
    }
    
    public function saveStockMovementReturns($data, $user_id)
    {
      $sql    = "UPDATE stock_movement SET return_quantity=?, selling_price=?, service_fee=?, return_remark=? WHERE movement_id=?";
      $params = [
        $data['return_quantity'],
        $data['selling_price'],
        $data['service_fee'],
        $data['return_remark'],
        $data['movement_id']
      ];
      if ($this->updateQuery($sql, $params)) {
        // Update quantity in products
        $this->updateQuery("UPDATE products SET quantity_in_stock=quantity_in_stock+? WHERE product_id=?", [$data['return_quantity'], $data['product_id']]);
        $this->auditTrail->logActivity($user_id, 1, $data['movement_id'], 'Assessed stock movement', 'Stock movement assessed with ID ' . $data['movement_id'], 'Stock Movement', 'Success');
        return json_encode(['status' => 'success', 'message' => 'Stock Movement Assessed Successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Stock Movement Assessment Failed.']);
      }
    }
    
    // Print the stock movement by the user
    public function generateStockMovementPrintout($track_number)
    {
      // Fetch stock movement data for the specified track number
      $sql    = "SELECT sm.*, p.product_id AS prod, p.selling_price AS price, p.product_name
            FROM stock_movement sm
            INNER JOIN products p ON sm.product_id = p.product_id
            WHERE sm.track_number = ?";
      $params = [$track_number];
      $result = $this->selectQuery($sql, $params);
      
      $no = 1;
      
      // Initialize the printout HTML
      $printout = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Stock Movement Printout</title>
        <style>
            /* Add your custom print styles here */
            body {
                font-family: Arial, sans-serif;
            }
            .header {
                padding: 10px;
                text-align: center;
                border-bottom: 2px solid #ccc; /* Add a border for separation */
                overflow: hidden; /* Clear floats */
            }
            .header h1 {
                margin: 0;
                font-size: 24px;
            }
            .header p {
                margin: 5px 0;
                font-size: 16px;
            }
            .logo {
                max-width: 100px; /* Limit the logo size */
                margin-bottom: 10px; /* Add space between logo and text */
                float: left; /* Float the logo to the left */
            }
            .header-text {
                margin-left: 120px; /* Adjust the left margin to accommodate the logo */
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
            }
            .mb-0 {
            margin-bottom: 0 !important;
            }
            .mt-0 {
            margin-top: 0 !important;
            }
        </style>
    </head>
    <body onload="print()">
         <!-- Header section -->
        <div class="header">
            <img src="'. FAVICON .'" alt="Company Logo" class="logo">
            <h1>'. COMPANY .'</h1>
            <p>'. MOTTO .'</p>
            <p>'. LOCATION .'</p>
            <p>Email: '. COMPANYEMAIL .'</p>
            <p>Phone: '. str_replace(", ", " / ", COMPANYPHONE) .' / '. str_replace(", ", " / ", COMPANYPHONE2) .'</p>
        </div>
        <h3 class="mb-0">Stock Movement</h3>
        <h3 class="mt-0">Track #: ' . $track_number . '<small> - By '.$_SESSION['user'].'</small></h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Batch No.</th>
                    <th>Expiry</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Qty Left</th>
                    <th>Charges</th>
                    <th style="width: 25%">Remark</th>
                </tr>
            </thead>
            <tbody>';
      
      // Iterate over each stock movement record and add it to the printout
      while ($row = $result->fetch_assoc()) {
        // Get expiry date and batch number
        $checker = new SalesOrder();
        $daters = $checker->getProductExpiryAndBatchNumber((int)$row['prod']);
        if (count($checker->getProductExpiryAndBatchNumber((int)$row['prod'])) === 2){
          $dates = $daters[1]['expiry_date'];
          $batch = $daters[1]['batch_number'];
        } else {
          $dates = $daters[0]['expiry_date'];
          $batch = $daters[0]['batch_number'];
        }
        
        $printout .= '
            <tr>
                <td>' . $no . '</td>
                <td>' . $dates . '</td>
                <td>' . $batch . '</td>
                <td>' . $row['product_name'] . '</td>
                <td>' . $row['quantity'] . '</td>
                <td>' . number_format($row['price']) . '</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>';
        $no++;
      }
      
      // Close the table and body tags
      $printout .= '
            </tbody>
        </table>
    </body>
    </html>';
      
      return $printout;
    }
    
    
  }