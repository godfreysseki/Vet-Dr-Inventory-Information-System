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
            <h1>Sales Orders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Sales Orders</li>
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
            $orderManager = new SalesOrder();
            $id = $orderManager->createSalesOrder($_POST);
            
            echo alert('success', 'Sales Order Added Successfully. Id: '. orderNumbering($id));
          }
        
        ?>
        <!-- Card with Card Tool -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Orders List</h3>
            <div class="card-tools">
	            <button class="addSalesOrderBtn btn btn-sm btn-primary m-0">New Sales Order</button>
            </div>
          </div>
          <div class="card-body">
            <?php
              
              $categoryManager = new SalesOrder();
              $orders      = $categoryManager->getOrders();
            
            ?>
            <div class="table-responsive">
	            <table class="table table-bordered table-sm table-striped dataTable">
		            <thead>
		            <tr>
			            <th>#</th>
			            <th>Order Id</th>
			            <th>Order Date</th>
			            <th>User</th>
			            <th>Customer</th>
			            <th>Phone</th>
			            <th>Location</th>
			            <th>Total Amounts</th>
			            <th>Status</th>
			            <th>Action</th>
		            </tr>
		            </thead>
		            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($orders as $order) : ?>
			            <tr>
				            <td><?= $no ?></td>
				            <td><?= orderNumbering($order['order_id']) ?></td>
				            <td><?= datel($order['order_date']) ?></td>
				            <td><?= esc($order['full_name']); ?></td>
				            <td><?= esc($order['customer_name']) ?></td>
				            <td><?= phone($order['customer_phone']) ?></td>
				            <td><?= $order['customer_email'] ?></td>
				            <td><?= number_format($order['total_amount'], 2) ?></td>
				            <td><?= ucwords(esc($order['status'])) ?></td>
				            <td>
					            <button class="viewSalesOrderBtn btn btn-xs btn-link text-secondary" data-id="<?= esc($order['order_id']); ?>" data-toggle="tooltip" title="View Order Items"><span class="fa fa-eye"></span></button>
                      <?php if (esc($order['status']) === "processing"):?>
						            <a href="sales_orders_invoice.php?id=<?= esc($order['order_id']); ?>" target="_blank" class="btn btn-xs btn-link text-primary" data-toggle="tooltip" title="Print Receipt"><span class="fa
						            fa-print"></span></a>
                      <?php endif; ?>
					            
					            <?php if (esc($order['status']) === "receipted"):?>
						            <a href="sales_orders_complete.php?id=<?= esc($order['order_id']); ?>" class="btn btn-xs btn-link text-success" data-toggle="tooltip" title="Complete Order"><span class="fa
						            fa-check"></span></a>
                      <?php endif; ?>
                      <?php if (esc($order['status']) !== "completed" && esc($order['status']) !== "receipted" && esc($order['status']) !== 'canceled'):?>
						            <button class="btn btn-xs btn-link text-danger" onclick="if (confirm('Are you sure you want to cancel this record?')) {$(this).addClass('cancelSalesOrderBtn');}" data-id="<?= esc($order['order_id']); ?>"
						                    data-toggle="tooltip" title="Cancel Order"><span
									            class="fa fa-times"></span></button>
                      <?php endif; ?>
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