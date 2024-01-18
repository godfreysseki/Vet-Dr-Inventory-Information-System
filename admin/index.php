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
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar-alt"></i></span>
							
							<div class="info-box-content">
								<a href="appointments.php">
									<span class="info-box-text">New Appointments</span>
								</a>
								<span class="info-box-number">
                  <?= number_format($data->newAppointments()) ?>
                </span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
							
							<div class="info-box-content">
								<a href="sales.php">
									<span class="info-box-text">Today's Sales</span>
								</a>
								<span class="info-box-number">
									<small>UGX</small>
                  <?= number_format($data->totalSales()) ?>
                </span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill"></i></span>
							
							<div class="info-box-content">
								<a href="expenses.php">
									<span class="info-box-text">Today's Expenses</span>
								</a>
								<span class="info-box-number">
                  <small>UGX</small>
									<?= number_format($data->totalExpenses()) ?>
                </span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>
							
							<div class="info-box-content">
								<a href="profit_management.php">
								<span class="info-box-text">Today's Net Earnings</span>
								</a>
								<span class="info-box-number">
                  <small>UGX</small>
									<?= number_format($data->totalSales() - $data->totalExpenses()) ?>
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
								
								<!--<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
									<div class="btn-group">
										<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
											<i class="fas fa-wrench"></i>
										</button>
										<div class="dropdown-menu dropdown-menu-right" role="menu">
											<a href="#" class="dropdown-item">Action</a>
											<a href="#" class="dropdown-item">Another action</a>
											<a href="#" class="dropdown-item">Something else here</a>
											<a class="dropdown-divider"></a>
											<a href="#" class="dropdown-item">Separated link</a>
										</div>
									</div>
									<button type="button" class="btn btn-tool" data-card-widget="remove">
										<i class="fas fa-times"></i>
									</button>
								</div>-->
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
									<!--<div class="col-md-4">-->
										<!--<p class="text-center">
											<strong>Goal Completion</strong>
										</p>-->
										
										<!-- /.progress-group -->
										<!--<div class="progress-group">
											Add Products to Cart
											<span class="float-right"><b>160</b>/200</span>
											<div class="progress progress-sm">
												<div class="progress-bar bg-primary" style="width: 80%"></div>
											</div>
										</div>-->
										
										<!-- /.progress-group -->
										<!--<div class="progress-group">
											<span class="progress-text">Visit Premium Page</span>
											<span class="float-right"><b>480</b>/800</span>
											<div class="progress progress-sm">
												<div class="progress-bar bg-success" style="width: 60%"></div>
											</div>
										</div>-->
										
										<!-- /.progress-group -->
										<!--<div class="progress-group">
											Send Inquiries
											<span class="float-right"><b>250</b>/500</span>
											<div class="progress progress-sm">
												<div class="progress-bar bg-warning" style="width: 50%"></div>
											</div>
										</div>-->
										<!-- /.progress-group -->
										
										<!--<div class="progress-group">
											Complete Purchase
											<span class="float-right"><b>310</b>/400</span>
											<div class="progress progress-sm">
												<div class="progress-bar bg-danger" style="width: 75%"></div>
											</div>
										</div>-->
										<!-- /.progress-group -->
									<!--</div>-->
									<!-- /.col -->
								</div>
								<!-- /.row -->
							</div>
							<!-- ./card-body -->
							<div class="card-footer">
								<div class="row">
									<div class="col-sm-3 col-6">
										<div class="description-block border-right">
											<?= $data->realSales() ?>
											<h5 class="description-header">UGX <?= number_format($data->overallSales(), 2)?></h5>
											<span class="description-text">TOTAL REVENUE</span>
										</div>
										<!-- /.description-block -->
									</div>
									<!-- /.col -->
									<div class="col-sm-3 col-6">
										<div class="description-block border-right">
											<?= $data->realExpenses() ?>
											<h5 class="description-header">UGX <?= number_format($data->overallExpenses(), 2)?></h5>
											<span class="description-text">TOTAL COST</span>
										</div>
										<!-- /.description-block -->
									</div>
									<!-- /.col -->
									<div class="col-sm-3 col-6">
										<div class="description-block border-right">
											<?= $data->realProfit() ?>
											<h5 class="description-header">UGX <?= number_format($data->overallSales() - $data->overallExpenses(), 2) ?></h5>
											<span class="description-text">TOTAL NET EARNINGS</span>
										</div>
										<!-- /.description-block -->
									</div>
									<!-- /.col -->
									<div class="col-sm-3 col-6">
										<div class="description-block">
                      <?= $data->realAnimalsTreated() ?>
											<h5 class="description-header"><?= $data->overallAnimalsTreated() ?></h5>
											<span class="description-text">ANIMALS TREATED</span>
										</div>
										<!-- /.description-block -->
									</div>
								</div>
								<!-- /.row -->
							</div>
							<!-- /.card-footer -->
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