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
        $sql     = "insert into salesorders (user_id, customer_name, customer_email, customer_phone, total_amount, status, order_date) values (?, ?, ?, ?, ?, 'processing', NOW())";
        $orderId = $this->insertQuery($sql, [$user, $customer_name, $customer_email, $customer_phone, array_sum($totalAmounts)]);
        
        // Loop through the submitted data and add order items
        for ($i = 0; $i < count($productIds); $i++) {
          $productId   = $productIds[$i];
          $quantity    = $quantities[$i];
          $unitCost    = $unitCosts[$i];
          $totalAmount = $totalAmounts[$i];
          
          // Add item to the salesorderitems table
          $sql = "insert into salesorderitems (order_id, product_id, quantity, unit_price, total_amount) values (?, ?, ?, ?, ?)";
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
      $sql = "update salesorders set status='receipted' where order_id=? ";
      $params = [$orderId];
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
        $sql     = "select * from salesorderitems where order_id=?";
        $params  = [$orderId];
        $items[] = $this->selectQuery($sql, $params)->fetch_assoc();
        
        // Loop through items and process each one
        foreach ($items as $item) {
          $productId = $item['product_id'];
          $quantity  = $item['quantity'];
          
          // Update stock quantities
          $sql = "update products set quantity_in_stock=quantity_in_stock - ? where product_id = ?";
          $this->updateQuery($sql, [$quantity, $productId]);
          
          // Record stock movement
          //$this->recordStockMovement($productId, $warehouseId, 'out', $quantity);
        }
        
        // Update Order status
        $sql      = "update salesorders set status='completed' where order_id=?";
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
      $sql      = "update salesorders set status='canceled' where order_id=? ";
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
      $sql    = "select * from salesorders left join users on salesorders.user_id = users.user_id order by order_id desc";
      $orders = $this->selectQuery($sql);
      
      return $orders;
    }
    
    public function getOrderItems($orderId)
    {
      $sql    = "select salesorderitems.*, products.*, salesorderitems.unit_price as price from salesorderitems inner join products on salesorderitems.product_id=products.product_id where order_id = ?";
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
      $sql          = "select * from products";
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
      $sql    = "select * from salesorders where order_id=?";
      $params = [$orderId];
      return $this->selectQuery($sql, $params)->fetch_assoc();
    }
    
    // Client Side
  
    public function addToCart($product_id)
    {
    }
    
  }
