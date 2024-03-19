<?php
  
  class SalesOrder extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function createSalesOrder($data)
    {
      $user = esc($_SESSION['user_id']);
      // Implement the logic to create a sales order
      // Update stock quantities, add stock movements, etc.
      $this->beginTransaction();
      
      try {
        
        // Retrieve the submitted item data
        $customer_name  = $data['customer_name'];
        $customer_email = $data['customer_email'];
        $customer_phone = $data['customer_phone'];
        $productIds     = $data['product'];
        $quantities     = $data['quantity'];
        $unitCosts      = $data['selling_price'];
        $totalAmounts   = $data['total_amount'];
        
        // Create a new sales order
        $sql     = "INSERT INTO salesorders (user_id, customer_name, customer_email, customer_phone, total_amount, status, order_date) VALUES (?, ?, ?, ?, ?, 'processing', NOW())";
        $orderId = $this->insertQuery($sql, [$user, $customer_name, $customer_email, $customer_phone, array_sum($totalAmounts)]);
        
        // Loop through the submitted data and add order items
        for ($i = 0; $i < count($productIds); $i++) {
          $productId   = $productIds[$i];
          $quantity    = $quantities[$i];
          $unitCost    = $unitCosts[$i];
          $totalAmount = $totalAmounts[$i];
          
          // Add item to the salesorderitems table
          $sql = "INSERT INTO salesorderitems (order_id, product_id, quantity, unit_price, total_amount) VALUES (?, ?, ?, ?, ?)";
          $this->insertQuery($sql, [$orderId, $productId, $quantity, $unitCost, $totalAmount]);
        }
        
        // Commit the transaction
        $this->commitTransaction();
        
        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($user, 3, $orderId, 'Sales order created', 'Order ID: ' . $orderId, 'Sales Orders', 'Success');
        
        return $orderId;
      } catch (Exception $e) {
        // Roll back the transaction on error
        $this->rollbackTransaction();
        throw $e;
      }
    }
    
    public function saleOrderForm($orderId = null)
    {
      $productsCombo = '';
      
      // Get all products
      $allProducts = new Products();
      $products    = $allProducts->getProducts();
      
      foreach ($products as $product) {
        $productsCombo .= '<option value="' . $product['product_id'] . '">' . $product['product_name'] . '</option>';
      }
      
      $form = '<div class="orderItems">
                  <form method="post" id="salesOrderForm">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="customer_name">Customer Name</label>
                          <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" required>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="customer_phone">Customer Phone</label>
                          <input type="tel" name="customer_phone" id="customer_phone" class="form-control form-control-sm" required>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="customer_email">Customer Location</label>
                          <input type="text" name="customer_email" id="customer_email" class="form-control form-control-sm" required>
                        </div>
                      </div>
                      <div class="col-sm-11">
                        <h6>Add Order Items</h6>
                      </div>
                      
                     <div class="salesOrderItems w-100"></div>
  
                      <div class="col-sm-4">
                        <div class="form-group">
                          <button type="button" id="addItemBtn" class="btn btn-success">Add Item</button>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <div id="grandTotal"><h4>Grand Total: <span>0.00</span></h4></div>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary float-right">Add Order</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>';
      
      return $form;
    }
    
    public function updateSalesOrder($orderId, $newItems)
    {
      // Implement the logic to update a sales order
      // Update stock quantities, adjust stock movements, etc.
    }
    
    public function invoiceOrder($orderId)
    {
      $sql      = "UPDATE salesorders SET status='receipted' WHERE order_id=? ";
      $params   = [$orderId];
      $order_id = $this->updateQuery($sql, $params);
    }
    
    public function completeOrder($orderId)
    {
      // Implement the logic to mark a purchase order as received
      // Update stock quantities, add stock movements, etc.
      $this->beginTransaction();
      
      try {
        // Mark the purchase order as received (you can implement this logic)
        // Update stock quantities, add stock movements, etc.
        $sql     = "SELECT * FROM salesorderitems WHERE order_id=?";
        $params  = [$orderId];
        $items[] = $this->selectQuery($sql, $params)->fetch_assoc();
        
        // Loop through items and process each one
        foreach ($items as $item) {
          $productId = $item['product_id'];
          $quantity  = $item['quantity'];
          
          // Update stock quantities
          $sql = "UPDATE products SET quantity_in_stock=quantity_in_stock - ? WHERE product_id = ?";
          $this->updateQuery($sql, [$quantity, $productId]);
          
          // Record stock movement
          //$this->recordStockMovement($productId, $warehouseId, 'out', $quantity);
        }
        
        // Update Order status
        $sql      = "UPDATE salesorders SET status='completed' WHERE order_id=?";
        $order_id = $this->updateQuery($sql, [$orderId]);
        
        // Commit the transaction
        $this->commitTransaction();
        
        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($_SESSION['user_id'], 5, $orderId, 'Sales order completed', 'Order ID: ' . $order_id, 'Sales Orders', 'Success');
        
      } catch (Exception $e) {
        // Roll back the transaction on error
        $this->rollbackTransaction();
        throw $e;
      }
    }
    
    public function cancelSalesOrder($orderId)
    {
      $sql      = "UPDATE salesorders SET status='canceled' WHERE order_id=? ";
      $params   = [$orderId];
      $order_id = $this->updateQuery($sql, $params);
      if ($order_id > 0) {
        return alert('success', 'Order Canceled Successfully. Order No.: ' . $order_id);
      } else {
        return alert('warning', 'Order Cancellation Failed. Order No.:' . $order_id);
      }
    }
    
    public function getOrders()
    {
      $sql    = "SELECT * FROM salesorders LEFT JOIN users ON salesorders.user_id = users.user_id ORDER BY order_id DESC";
      $orders = $this->selectQuery($sql);
      
      return $orders;
    }
    
    public function getOrderItems($orderId)
    {
      $sql    = "SELECT salesorderitems.*, products.*, salesorderitems.unit_price AS price FROM salesorderitems INNER JOIN products ON salesorderitems.product_id=products.product_id WHERE order_id = ?";
      $params = [$orderId];
      $result = $this->selectQuery($sql, $params);
      $items  = [];
      while ($row = $result->fetch_assoc()) {
        $items[] = $row;
      }
      return $items;
    }
    
    // Get the products details for the sales items combo
    public function getProducts()
    {
      $sellingPrices = [];
      
      // Fetch the selling price for the selected product from the database
      $sql          = "SELECT * FROM products";
      $sellingPrice = $this->selectQuery($sql);
      if ($sellingPrice->num_rows > 0) {
        while ($row = $sellingPrice->fetch_assoc()) {
          $sellingPrices[] = $row;
        }
      }
      return $sellingPrices;
    }
    
    public function orderDetails($orderId)
    {
      $sql    = "SELECT * FROM salesorders WHERE order_id=?";
      $params = [$orderId];
      return $this->selectQuery($sql, $params)->fetch_assoc();
    }
    
    // Client Side
    
    public function addToCart($product_id)
    {
      if (!isset($_SESSION['orderNo'])) {
        $_SESSION['orderNo'] = randomCode(6);
      }
      $selling_price = $this->getProductSellingPrice($product_id);
      $orderNo       = $_SESSION['orderNo'];
      $product       = $product_id;
      
      // Check if product is already in cart and increment the quantity else add to cart
      $check  = "SELECT * FROM cart WHERE product_id=? && order_number=?";
      $checks = [$product, $orderNo];
      if ($this->selectQuery($check, $checks)->num_rows > 0) {
        // Update Quantity
        if ($this->updateQuery("UPDATE cart SET quantity=quantity+1 WHERE product_id=? && order_number=?", [$product, $orderNo])) {
          return 'Product Quantity has been increased by One(1)';
        } else {
          return 'Product Quantity failed to be increased, use the cart to perform this task.';
        }
      } else {
        // Add to cart
        $sql    = "INSERT INTO cart (order_number, product_id, quantity, selling_price) VALUES (?, ?, ?, ?)";
        $params = [$orderNo, $product, 1, $selling_price];
        if ($this->insertQuery($sql, $params)) {
          return 'Product added to cart successfully.';
        } else {
          return 'Product addition failed';
        }
      }
    }
    
    public function countMyCart()
    {
      if (isset($_SESSION['orderNo'])) {
        // Select and count Items in cart
        $orderNo = $_SESSION['orderNo'];
        $sql     = "SELECT COUNT(product_id) AS num FROM cart WHERE order_number=?";
        $params  = [$orderNo];
        $result  = $this->selectQuery($sql, $params)->fetch_assoc();
        return $result['num'];
      } else {
        return 0;
      }
    }
    
    public function displayMyCart()
    {
      if (isset($_SESSION['orderNo'])) {
        // Display Items
        $items   = '';
        $orderNo = $_SESSION['orderNo'];
        $sql     = "SELECT *, cart.selling_price AS sellingPrice FROM cart INNER JOIN products ON cart.product_id=products.product_id WHERE order_number=?";
        $params  = [$orderNo];
        $result  = $this->selectQuery($sql, $params);
        while ($row = $result->fetch_assoc()) {
          $items .= '<tr>
                      <td><img src="assets/img/uploads/' . $row['image'] . '" alt="Product Image" width="50"></td>
                      <td>' . $row['product_name'] . '</td>
                      <td class="selling_price">' . number_format($row['sellingPrice']) . ' </td>
                      <td>
                        <div class="input-group">
                          <button data-id="' . $row['cart_id'] . '" class="decrementBtn btn btn-outline-secondary" type="button"> -</button>
                          <input type="number" class="qtySpinner form-control" value="' . $row['quantity'] . '">
                          <button data-id="' . $row['cart_id'] . '" class="incrementBtn btn btn-outline-secondary" type="button"> +</button>
                        </div>
                      </td>
                      <td class="sub-total">' . number_format($row['quantity'] * $row['sellingPrice']) . ' </td>
                      <td><button data-product="' . $row['product_name'] . '" data-id="' . $row['cart_id'] . '" class="removeCart btn btn-link text-danger"><i class="bi bi-trash"></i></button></td>
                    </tr>';
        }
        return $items;
      } else {
        return '<p> You need to add products to cart. use the <a href="shop.php"> Shop</a> link on the navigation bar and add some items for your order .</p> ';
      }
    }
    
    private function getProductSellingPrice($product_id)
    {
      $sql    = "SELECT selling_price FROM products WHERE product_id=?";
      $params = [$product_id];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['selling_price'];
    }
    
    public function updateCart($cart_id, $sign)
    {
      if (isset($_SESSION['orderNo'])) {
        if ($sign === "Add") {
          $sql = "UPDATE cart SET quantity=quantity+1 WHERE cart_id=? && order_number=?";
        } else {
          $sql = "UPDATE cart SET quantity=quantity-1 WHERE cart_id=? && order_number=?";
        }
        $params = [$cart_id, $_SESSION['orderNo']];
        $this->updateQuery($sql, $params);
      }
    }
    
    public function removeFromCart($cartId)
    {
      if (isset($_SESSION['orderNo'])) {
        $sql    = "DELETE FROM cart WHERE cart_id=? && order_number=?";
        $params = [$cartId, $_SESSION['orderNo']];
        $this->deleteQuery($sql, $params);
      }
    }
    
    private function getOrderTotal()
    {
      if (isset($_SESSION['orderNo'])) {
        $sql    = "SELECT SUM(quantity * selling_price) AS totals FROM cart WHERE order_number=?";
        $params = [$_SESSION['orderNo']];
        $result = $this->selectQuery($sql, $params)->fetch_assoc();
        return $result['totals'];
      }
    }
    
    public function checkout($full_name, $phone, $address, $payment_method)
    {
      $total = $this->getOrderTotal();
      if (isset($_SESSION['orderNo'])) {
        // Insert into online orders
        $sql    = "INSERT INTO online_orders (order_number, full_name, phone, address, payment_method, total) SELECT order_number, ?, ?, ?, ?, ? FROM cart WHERE order_number=?";
        $params = [$full_name, $phone, $address, $payment_method, $total, $_SESSION['orderNo']];
        $this->insertQuery($sql, $params);
        // Insert into order items
        $sqls    = "INSERT INTO onlineorderitems (order_id, product_id, quantity, unit_price, total_amount) SELECT order_number, product_id, quantity, selling_price, (quantity * selling_price) FROM cart WHERE order_number=?";
        $paramss = [$_SESSION['orderNo']];
        $this->insertQuery($sqls, $paramss);
        // Now delete from cart
        $this->deleteQuery("DELETE FROM cart WHERE order_number=?", [$_SESSION['orderNo']]);
        
        // Get the results and complete the
        return '<p>Your order number is: <b>' . $_SESSION['orderNo'] . '</b></p>
                <p>Thank you for your order! Your purchase has been successfully completed. We are going to call you back once your order processing has started.
                If you have any questions or concerns, please feel free to contact us. We appreciate your business and look forward to serving you again soon!</p>';
      }
    }
    
    public function myOrderSummary()
    {
      if (isset($_SESSION['orderNo'])) {
        $sql    = "SELECT *, cart.selling_price AS sellingPrice FROM cart INNER JOIN products ON cart.product_id=products.product_id WHERE order_number=?";
        $params = [$_SESSION['orderNo']];
        $result = $this->selectQuery($sql, $params);
        if ($result->num_rows > 0) {
          $total = 0;
          echo '<div class="table-responsive">
                  <table class="table table-sm table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th class="text-end">Qty</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Sub Total</th>
                      </tr>
                    </thead>
                    <tbody>';
          while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['product_name'] . '</td>
                    <td class="text-end">' . number_format($row['quantity']) . '</td>
                    <td class="text-end">' . number_format($row['sellingPrice']) . '</td>
                    <td class="text-end">' . number_format($row['quantity'] * $row['sellingPrice']) . '</td>
                  </tr>';
            $total += ($row['quantity'] * $row['sellingPrice']);
          }
          echo '<tfoot><tr><th colspan="3" class="text-end">GRAND TOTAL</th><th class="text-end">UGX ' . number_format($total) . '</th></tr></tfoot></tbody></table></div>';
        } else {
          echo "<p>All Items were removed from cart. Create a new order to proceed.</p>";
        }
      }
    }
    
    // Admin side for online orders
    public function displayOnlineOrders()
    {
      $clientsData = $this->getAllOnlineOrders();
      $no          = 1;
      
      // DataTables HTML
      $tableHtml = '
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Order No.</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Payment</th>
                        <th>Total (UGX)</th>
                        <th>Status</th>
                        <th>Change</th>
                        <!-- Add more columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
      
      // Populate table rows with data
      foreach ($clientsData as $clientsData) {
        $tableHtml .= '
                <tr data-order-id="' . $clientsData['ooid'] . '">
                    <td>' . $no . '</td>
                    <td>' . dates($clientsData['order_date']) . '</td>
                    <td>' . $clientsData['order_number'] . '</td>
                    <td>' . $clientsData['full_name'] . '</td>
                    <td>' . phone($clientsData['phone']) . '</td>
                    <td>' . $clientsData['address'] . '</td>
                    <td>' . $clientsData['payment_method'] . '</td>
                    <td>' . number_format($clientsData['total']) . '</td>
                    <td class="order-status">' . $clientsData['status'] . '</td>
                    <td>
                      <select id="order-status">
                        <option value="Pending" ' . (($clientsData['status'] === "Pending") ? "selected" : "") . '>Pending</option>
                        <option value="Accepted" ' . (($clientsData['status'] === "Accepted") ? "selected" : "") . '>Accepted</option>
                        <option value="Processing" ' . (($clientsData['status'] === "Processing") ? "selected" : "") . '>Processing</option>
                        <option value="Packaged" ' . (($clientsData['status'] === "Packaged") ? "selected" : "") . '>Packaged</option>
                        <option value="Transporting" ' . (($clientsData['status'] === "Transporting") ? "selected" : "") . '>Transporting</option>
                        <option value="Delivered" ' . (($clientsData['status'] === "Delivered") ? "selected" : "") . '>Delivered</option>
                        <option value="Rejected" ' . (($clientsData['status'] === "Rejected") ? "selected" : "") . '>Rejected</option>
                      </select>
                    </td>
                    <td>
                        <button class="btn btn-success btn-sm viewOnlineOrder" data-id="' . $clientsData['order_number'] . '">View</button>
                    </td>
                </tr>';
        $no++;
      }
      
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table>';
      
      return $tableHtml;
    }
    
    private function getAllOnlineOrders()
    {
      // Sample SQL query to select all events ordered by event_id in descending order
      $sql = "SELECT * FROM online_orders ORDER BY ooid DESC";
      
      // Execute the query and fetch the results
      $result = $this->selectQuery($sql);
      
      // Initialize an array to store the fetched data
      $eventsData = [];
      
      // Fetch each row as an associative array
      while ($row = $result->fetch_assoc()) {
        $eventsData[] = $row;
      }
      
      return $eventsData;
      
    }
    
    public function updateOnlineOrderStatus($orderId, $newStatus)
    {
      $sql    = "UPDATE online_orders SET status=? WHERE ooid=?";
      $params = [$newStatus, $orderId];
      $this->updateQuery($sql, $params);
    }
    
    public function getOnlineOrderById($order_id)
    {
      // Sample SQL query to select all events ordered by event_id in descending order
      $sql    = "SELECT * FROM onlineorderitems WHERE order_id=?";
      $params = [$order_id];
      // Execute the query and fetch the results
      $result = $this->selectQuery($sql, $params);
      
      // Initialize an array to store the fetched data
      $eventsData = [];
      
      // Fetch each row as an associative array
      while ($row = $result->fetch_assoc()) {
        $eventsData[] = $row;
      }
      
      return $eventsData;
    }
    
    public function onlineOrderDetails($order_number)
    {
      $items = $this->getOnlineOrderById($order_number);
      
      $no = 1;
      // DataTables HTML
      $tableHtml = '<div class="table-responsive">
            <table class="table table-sm table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Selling Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';
      
      // Populate table rows with data
      foreach ($items as $item) {
        $tableHtml .= '
                <tr>
                    <td>' . $no . '</td>
                    <td>' . $this->getItemName($item['product_id']) . '</td>
                    <td>' . number_format($item['quantity']) . '</td>
                    <td>' . number_format($item['unit_price']) . '</td>
                    <td>' . number_format($item['total_amount']) . '</td>
                </tr>';
        $no++;
      }
      
      // Close table HTML
      $tableHtml .= '
                </tbody>
            </table></div>';
      
      return $tableHtml;
    }
    
    public function getOnlineOrderStatus($order_number)
    {
      $sql    = "SELECT * FROM online_orders WHERE order_number=?";
      $params = [$order_number];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return '<div class="order-header">
                  <h2>Order Tracking</h2>
                  <p class="order-status">' . $row['status'] . '</p>
                </div>
                
                <div class="order-details">
                  <p><strong>Order No.:</strong> ' . strtoupper($order_number) . '</p>
                  <p><strong>Customer:</strong> <span class="tracking-number">' . $row['full_name'] . ' - ' . phone($row['phone']) . '</span></p>
                  <p><strong>Delivery Address:</strong> ' . $row['address'] . '</p>
                  <p><strong>Payment Method:</strong> ' . $row['payment_method'] . '</p>
                  <p><strong>Order Date:</strong> ' . datel($row['order_date']) . '</p>
                </div>';
      }
    }
  
    public function getProductExpiryAndBatchNumber($product_id)
    {
      // SQL query to retrieve expiry date and batch number based on specified conditions
      $sql = "SELECT
                CASE
                    WHEN p.quantity_in_stock < i.quantity THEN i.expiry_date
                    ELSE (
                        SELECT i2.expiry_date
                        FROM inventory i2
                        WHERE i2.item_id = i.item_id AND i2.created_at < i.created_at
                        ORDER BY i2.created_at DESC
                        LIMIT 1
                    )
                END AS expiry_date,
                CASE
                    WHEN p.quantity_in_stock < i.quantity THEN i.batch_number
                    ELSE (
                        SELECT i2.batch_number
                        FROM inventory i2
                        WHERE i2.item_id = i.item_id AND i2.created_at < i.created_at
                        ORDER BY i2.created_at DESC
                        LIMIT 1
                    )
                END AS batch_number
            FROM products p
            INNER JOIN inventory i ON p.product_id = i.item_id
            WHERE p.product_id = ?";
    
      // Parameters for the SQL query
      $params = [$product_id];
    
      // Execute the SQL statement using $this->selectQuery() method
      $results = $this->selectQuery($sql, $params)->fetch_assoc();
    
      // Return the results
      return $results;
    }
    
  }
