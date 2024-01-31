<?php
  
  include_once "../includes/header.inc.php";
  
  $data = new Dashboard();

?>
	
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Dashboard</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
		
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<!-- Info boxes -->
				<div class="row">
					<div class="col-12 col-sm-3 col-lg-4">
						<div class="info-box">
							<span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
							
							<div class="info-box-content">
								<a href="sales.php">
									<span class="info-box-text">Today's Sales</span>
								</a>
								<span class="info-box-number">
									<small>UGX</small>
                  <?= number_format($data->totalSales($_SESSION['user_id'])) ?>
                </span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-12 col-sm-3 col-lg-4">
						<div class="info-box">
							<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill"></i></span>
							
							<div class="info-box-content">
								<a href="expenses.php">
									<span class="info-box-text">Today's Expenses</span>
								</a>
								<span class="info-box-number">
                  <small>UGX</small>
									<?= number_format($data->totalExpenses($_SESSION['user_id'])) ?>
                </span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-12 col-sm-3 col-lg-4">
						<div class="info-box">
							<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>
							
							<div class="info-box-content">
								<a href="profit_management.php">
								<span class="info-box-text">Today's Net Earnings</span>
								</a>
								<span class="info-box-number">
                  <small>UGX</small>
									<?= number_format($data->totalSales($_SESSION['user_id']) - $data->totalExpenses($_SESSION['user_id'])) ?>
                </span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
				
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Monthly Sales Recap Report</h5>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="chart">
											<!-- Sales Chart Canvas -->
											<canvas id="realTimeSalesChart" height="350" style="height: 350px;"></canvas>
										</div>
										<!-- /.chart-responsive -->
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->
							</div>
							<!-- ./card-body -->
						</div>
						<!-- /.card -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

<?php
  
  include_once "../includes/footer.inc.php";

?>