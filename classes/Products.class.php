<?php
  
  
  class products extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    // Add a new product to the database
    public function addProduct($productData)
    {
      if (isset($productData['product_id']) && !empty($productData['product_id'])) {
        $productImages = $this->getProductImage($productData['product_id']);
        // Handle image upload
        
        if (!empty($_FILES['image']['name'])) {
          $uploadDir      = '../assets/img/uploads/';
          $uniqueFilename = 'product_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
          $uploadFile     = $uploadDir . $uniqueFilename;
          // Remove Old Image
          if (file_exists($uploadDir . $productImages)) {
            unlink($uploadDir . $productImages);
          }
          
          if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Image uploaded successfully, save the unique filename to the database
            $productImage = $uniqueFilename;
          } else {
            // Image upload failed
            $productImage = $productImages; // or set to a default image
          }
        } else {
          $productImage = $productImages; // No image provided
        }
      } else {
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
          $uploadDir      = '../assets/img/uploads/';
          $uniqueFilename = 'product_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
          $uploadFile     = $uploadDir . $uniqueFilename;
          
          if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Image uploaded successfully, save the unique filename to the database
            $productImage = $uniqueFilename;
          } else {
            // Image upload failed
            $productImage = ''; // or set to a default image
          }
        } else {
          $productImage = ''; // No image provided
        }
      }
      
      if (isset($productData['product_id']) && !empty($productData['product_id'])) {
        // Update Product
        $sql    = 'update products set product_name=?, description=?, unit_price=?, selling_price=?, quantity_in_stock=?, reorder_level=?, image=? where product_id=?';
        $params = [
          $productData['product_name'],
          $productData['description'],
          $productData['unit_price'],
          $productData['selling_price'],
          $productData['quantity_in_stock'],
          $productData['reorder_level'],
          $productImage,
          $productData['product_id']
        ];
        
        $productId = $this->insertQuery($sql, $params);
        
        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($_SESSION['user_id'], 1, $productId, 'Product added', 'Product ID: ' . $productId);
        
        return $productId;
      } else {
        $sql    = 'insert into products (product_name, description, unit_price, selling_price, quantity_in_stock, reorder_level, image)
                values (?, ?, ?, ?, ?, ?, ?)';
        $params = [
          $productData['product_name'],
          $productData['description'],
          $productData['unit_price'],
          $productData['selling_price'],
          $productData['quantity_in_stock'],
          $productData['reorder_level'],
          $productImage
        ];
        
        $productId = $this->insertQuery($sql, $params);
        
        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($_SESSION['user_id'], 1, $productId, 'Product added', 'Product ID: ' . $productId);
        
        return $productId;
      }
    }
    
    // Get the product form for adding a new product or updating an existing one
    public function productForm($productId = null)
    {
      // Define the product data array with empty values for the form
      $productData = [
        'product_id' => '',
        'product_name' => '',
        'description' => '',
        'unit_price' => '',
        'selling_price' => '',
        'quantity_in_stock' => '',
        'reorder_level' => '',
        'image' => '' // Assuming the image filename/path is provided in the product data
      ];
      
      // If $productId is provided, fetch the product data from the database
      if ($productId !== null) {
        $sql         = "select * from products where product_id = ?";
        $params      = [$productId];
        $productData = $this->selectQuery($sql, $params)->fetch_assoc();
      }
      
      // Start building the HTML form
      $form = '<form method="post" enctype="multipart/form-data">
                  <input type="hidden" name="product_id" value="' . $productId . '">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="image">Product Image <small>(' . htmlspecialchars($productData['image']) . ')</small></label>
                        <input type="file" class="form-control-file" id="image" name="image">
                      </div>
                      <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" value="' . htmlspecialchars($productData['product_name']) . '" required>
                      </div>
                      <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4">' . htmlspecialchars($productData['description']) . '</textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="unit_price">Unit Price</label>
                        <input type="number" step="0.01" class="form-control" id="unit_price" name="unit_price" value="' . htmlspecialchars($productData['unit_price']) . '" required>
                      </div>
                      <div class="form-group">
                        <label for="selling_price">Selling Price</label>
                        <input type="number" step="0.01" class="form-control" id="selling_price" name="selling_price" value="' . htmlspecialchars($productData['selling_price']) . '" required>
                      </div>
                      <div class="form-group">
                        <label for="quantity_in_stock">Initial Quantity</label>
                        <input type="number" class="form-control" id="quantity_in_stock" value="' . htmlspecialchars($productData['quantity_in_stock']) . '" name="quantity_in_stock" required>
                      </div>
                      <div class="form-group">
                        <label for="reorder_level">Reorder Level</label>
                        <input type="number" class="form-control" value="' . htmlspecialchars($productData['reorder_level']) . '" id="reorder_level" name="reorder_level">
                      </div>
                      <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary float-right">' . ($productId !== null ? 'Update' : 'Add') . ' Product</button>
                      </div>
                    </div>
                  </div>
                </form>';
      
      return $form;
    }
    
    // Update an existing product in the database
    public function updateProduct($productId, $productData)
    {
      $sql    = 'update products set product_name = ?, description = ?, unit_price = ?, quantity_in_stock = ?,
                reorder_level = ?, image = ? where product_id = ?';
      $params = [
        $productData['product_name'],
        $productData['description'],
        $productData['unit_price'],
        $productData['quantity_in_stock'],
        $productData['reorder_level'],
        $productData['image'],
        $productId
      ];
      
      $this->updateQuery($sql, $params);
      
      // Log the activity in the AuditTrail
      $this->auditTrail->logActivity($_SESSION['user_id'], 2, $productId, 'Product updated', 'Product ID: ' . $productId, 'Products', 'Success');
      
      return true;
    }
    
    // Delete a product from the database
    public function deleteProduct($productId)
    {
      $sql    = 'delete from products where product_id = ?';
      $params = [$productId];
      if ($this->deleteQuery($sql, $params)) {
        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($_SESSION['user_id'], 3, $productId, 'Product deleted', 'Product ID: ' . $productId, 'Products', 'Success');
    
        return json_encode(['status' => 'success', 'message' => 'Product/Item deleted Successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Product/Item already deleted. Reload to see effect.']);
      }
    }
    
    // Example method using the SELECT query template
    public function getProductById($productId)
    {
      $sql    = 'select * from products where product_id = ?';
      $params = [$productId];
      
      $result = $this->selectQuery($sql, $params);
      
      if ($result->num_rows > 0) {
        // Fetch and return the product data
        return $result->fetch_assoc();
      } else {
        return null;
      }
    }
    
    // Get all products from the database
    public function getProducts()
    {
      $sql    = 'select * from products';
      $result = $this->selectQuery($sql);
      
      $products = [];
      while ($row = $result->fetch_assoc()) {
        $products[] = $row;
      }
      
      return $products;
    }
    
    public function productDetails($productId)
    {
      // Get product Details
      $sql = "SELECT * FROM products where product_id=?";
      $params = [$productId];
      $result1 = $this->selectQuery($sql, $params)->fetch_assoc();
      // Get product Sales
      $sqls = "select * from salesorderitems where product_id=?";
      $paramss = [$productId];
      $result2 = $this->selectQuery($sqls, $paramss);
      $data[0] = $result1;
      
      while ($row = $result2->fetch_assoc()) {
        $data[1][] = $row;
      }
      return $data;
    }
    
    public function updateStockQuantities($productId, $movementType, $quantity)
    {
      $sql = "update products set quantity_in_stock = quantity_in_stock ";
      
      if ($movementType === 'in') {
        $sql .= "+ ?";
      } elseif ($movementType === 'out') {
        $sql .= "- ?";
      }
      
      $sql .= " WHERE product_id = ?";
      
      $this->updateQuery($sql, [$quantity, $productId]);
    }
    
    private function getProductImage($product_id)
    {
      $sql  = "select image from products where product_id=?";
      $data = $this->selectQuery($sql, [$product_id])->fetch_assoc();
      return $data['image'];
    }
  
    public function displayProductsToUser()
    {
      $items = '';
      $products = $this->getProducts();
      foreach ($products as $product) {
        $items .= '<!-- Product Card -->
                  <div class="col-lg-2 col-md-4 col-sm-6 mb-4 product">
                    <div class="card">
                      <img src="assets/img/uploads/'.(isset($product['image']) ? $product['image'] : 'noimage.png').'" class="card-img-top" alt="Product Image">
                      <div class="card-body">
                        <h5 class="card-title">'.$product['product_name'].'</h5>
                        <p class="card-text">UGX '.number_format($product['selling_price'],).'</p>
                        <a href="cart_add.php?id='.$product['product_id'].'" class="addToCart btn btn-sm btn-success">Add to Cart</a>
                      </div>
                    </div>
                  </div>
                  <!-- End Product Card -->';
      }
      return $items;
    }
    
  }