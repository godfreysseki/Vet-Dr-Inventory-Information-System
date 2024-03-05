<?php
  
  include_once "config.inc.php";
  
  $checkUser = new Users();
  $checkUser->checkRole(ROLE);
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= PAGE ?> | <?= SYSTEM ?></title>
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../assets/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="../assets/plugins/chart.js/Chart.min.css">
  <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../assets/plugins/select2/css/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables/datatables.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../assets/css/custom.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">
<div class="wrapper">
	
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-success navbar-dark">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="javascript:void(0)" role="button"><i class="fas fa-bars"></i></a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="./" class="nav-link">Dashboard</a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="javascript:void(0)" class="nav-link">Contact</a>
			</li>
			<li class="nav-item">
				<a href="" class="nav-link">Reload</a>
			</li>
		</ul>
		
		<!-- Right navbar links -->
		<ul class="navbar-nav ml-auto">
			<!-- Navbar Search -->
			<li class="nav-item">
				<a class="nav-link" data-widget="navbar-search" href="javascript:void(0)" role="button">
					<i class="fas fa-search"></i>
				</a>
				<div class="navbar-search-block">
					<form class="form-inline">
						<div class="input-group input-group-sm">
							<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
							<div class="input-group-append">
								<button class="btn btn-navbar" type="submit">
									<i class="fas fa-search"></i>
								</button>
								<button class="btn btn-navbar" type="button" data-widget="navbar-search">
									<i class="fas fa-times"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</li>
			
			<!-- Messages Dropdown Menu -->
			<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
					<i class="far fa-comments"></i>
					<span class="badge badge-danger navbar-badge">3</span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<a href="javascript:void(0)" class="dropdown-item">
						<!-- Message Start -->
						<div class="media">
							<img src="../assets/img/user.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">
							<div class="media-body">
								<h3 class="dropdown-item-title">
									Brad Diesel
									<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
								</h3>
								<p class="text-sm">Call me whenever you can...</p>
								<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
							</div>
						</div>
						<!-- Message End -->
					</a>
					<div class="dropdown-divider"></div>
					<a href="javascript:void(0)" class="dropdown-item">
						<!-- Message Start -->
						<div class="media">
							<img src="../assets/img/user.png" alt="User Avatar" class="img-size-50 img-circle mr-3">
							<div class="media-body">
								<h3 class="dropdown-item-title">
									John Pierce
									<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
								</h3>
								<p class="text-sm">I got your message bro</p>
								<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
							</div>
						</div>
						<!-- Message End -->
					</a>
					<div class="dropdown-divider"></div>
					<a href="javascript:void(0)" class="dropdown-item">
						<!-- Message Start -->
						<div class="media">
							<img src="../assets/img/user.png" alt="User Avatar" class="img-size-50 img-circle mr-3">
							<div class="media-body">
								<h3 class="dropdown-item-title">
									Nora Silvester
									<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
								</h3>
								<p class="text-sm">The subject goes here</p>
								<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
							</div>
						</div>
						<!-- Message End -->
					</a>
					<div class="dropdown-divider"></div>
					<a href="javascript:void(0)" class="dropdown-item dropdown-footer">See All Messages</a>
				</div>
			</li>
			<!-- Notifications Dropdown Menu -->
			<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
					<i class="far fa-bell"></i>
					<span class="badge badge-warning navbar-badge">15</span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<span class="dropdown-item dropdown-header">15 Notifications</span>
					<div class="dropdown-divider"></div>
					<a href="javascript:void(0)" class="dropdown-item">
						<i class="fas fa-envelope mr-2"></i> 4 new messages
						<span class="float-right text-muted text-sm">3 mins</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="javascript:void(0)" class="dropdown-item">
						<i class="fas fa-users mr-2"></i> 8 friend requests
						<span class="float-right text-muted text-sm">12 hours</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="javascript:void(0)" class="dropdown-item">
						<i class="fas fa-file mr-2"></i> 3 new reports
						<span class="float-right text-muted text-sm">2 days</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="javascript:void(0)" class="dropdown-item dropdown-footer">See All Notifications</a>
				</div>
			</li>
			<li class="nav-item dropdown user-menu">
				<a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown">
					<img src="../assets/img/user.png" class="user-image img-circle elevation-2" alt="User Image">
					<span class="d-none d-md-inline"><?= $_SESSION['user'] ?></span>
				</a>
				<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<!-- User image -->
					<li class="user-header bg-success">
						<img src="../assets/img/user.png" class="img-circle elevation-2" alt="User Image">
						
						<p>
              <?= $_SESSION['user'] ?> - <?= ucwords(strtolower($_SESSION['role'])) ?>
							<small>Member since Nov. 2012</small>
						</p>
					</li>
					<!-- Menu Footer-->
					<li class="user-footer">
						<a href="profile.php" class="btn btn-default btn-flat">Profile</a>
						<a href="../logout.php" class="btn btn-default btn-flat float-right">Sign out</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="dark-mode-toggle" href="javascript:void(0)">
					<i class="fas fa-sun"></i>
				</a>
			</li>
		</ul>
	</nav>
	<!-- /.navbar -->

<?php
  
  include_once strtolower(ROLE) . "Menu.inc.php";

?>