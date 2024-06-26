<?php
  
  include_once "includes/config.inc.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Forgot Password</title>
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="./"><b><?= COMPANY ?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Recover your account with a new password.</p>
      
      <form method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="username / email / phone number">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
	      <div class="input-group mb-3">
		      <input type="password" class="form-control" placeholder="Password">
		      <div class="input-group-append">
			      <div class="input-group-text visibilityIcon" onclick="togglePasswordVisibility()">
				      <span class="fas fa-eye"></span>
			      </div>
		      </div>
	      </div>
	      <div class="input-group mb-3">
		      <input type="password" class="form-control" placeholder="Confirm Password">
		      <div class="input-group-append">
			      <div class="input-group-text visibilityIcon" onclick="togglePasswordVisibility()">
				      <span class="fas fa-eye"></span>
			      </div>
		      </div>
	      </div>
	      <div class="input-group mb-3">
		      <input type="text" class="form-control" placeholder="Your Pin">
		      <div class="input-group-append">
			      <div class="input-group-text visibilityIcon" onclick="togglePasswordVisibility()">
				      <span class="fas fa-user-shield"></span>
			      </div>
		      </div>
	      </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change Password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      
      <p class="mt-3 mb-1">
        <a href="./">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/adminlte.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
