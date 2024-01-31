<?php
  
  include_once "../includes/header.inc.php";

?>
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1>Products Management</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="index.php">Home</a></li>
							<li class="breadcrumb-item active">Products & Items</li>
						</ol>
					</div>
				</div>
			</div>
		</section>
		
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<div class="systemMsg"></div>
        <?php
          
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $addProduct = new Products();
            $id = $addProduct->addProduct($_POST);
            
            echo alert('success', 'Product Added Successfully. Id: '.$id);
          }
        
        ?>
				<!-- Card with Card Tool -->
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Product List</h3>
						<div class="card-tools">
							<button class="addProductBtn btn btn-sm btn-primary m-0">New Product</button>
						</div>
					</div>
					<div class="card-body">
						<!-- Your Content Here (Product List Table, etc.) -->
            <?php
              // Create an instance of the Product class
              $productManager = new Products();
              
              // Get all products from the database
              $products = $productManager->getProducts();
              
              // Loop through the products and display them
            ?>
						<div class="table-responsive">
							<table class="table table-bordered table-sm table-striped dataTable">
								<thead>
								<tr>
									<th>#</th>
									<th>Image</th>
									<th>Product Name</th>
									<th>Description</th>
									<th>Unit Price</th>
									<th>Selling Price</th>
									<th>Qty in Stock</th>
									<th>Reorder Level</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody>
								<?php $no = 1; ?>
                <?php foreach ($products as $product) : ?>
									<tr>
										<td><?= $no ?></td>
										<td><img src="../assets/img/uploads/<?= $product['image'] ?>"></td>
										<td><?= htmlspecialchars($product['product_name']); ?></td>
										<td><?= htmlspecialchars($product['description']); ?></td>
										<td>UGX <?= number_format($product['unit_price'], 2); ?></td>
										<td>UGX <?= number_format($product['selling_price'], 2); ?></td>
										<td><?= $product['quantity_in_stock'] ?></td>
										<td><?= $product['reorder_level'] ?></td>
										<td>
											<button class="viewProductBtn btn btn-xs btn-link text-secondary" data-id="<?= esc($product['product_id']); ?>" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></button>
											<button class="editProductBtn btn btn-xs btn-link text-success" data-id="<?= esc($product['product_id']); ?>" data-toggle="tooltip" title="Edit"><span class="fa fa-pen-fancy"></span></button>
											<button class="btn btn-xs btn-link text-danger" onclick="if (confirm('Are you sure you want to delete this record?')) {$(this).addClass('deleteProductBtn');}" data-id="<?= esc($product['product_id']); ?>"
											        data-toggle="tooltip" title="Delete"><span
														class="fa
											fa-trash-alt"></span></button>
										</td>
									</tr>
	                <?php $no++; ?>
                <?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- End Card with Card Tool -->
			</div>
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->


<?php
  
  include_once "../includes/footer.inc.php";

?>