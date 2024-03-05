<?php

include_once "includes/config.inc.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log in | <?= COMPANY ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
        <p class="login-box-msg">Sign in to start your session</p>
        <?php
        
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
          $user     = new Users();
          $username = $_POST['username'];
          $pass     = $_POST['password'];
          $userId = $user->loginUser($username, $pass);
          
          if ($userId) {
            echo "Registration done successfully. Your ID: " . $userId;
          } else {
            echo "Error registering User.";
          }
        }
      
      ?>
        <form method="post">
          <div class="form-group mb-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-group mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text visibilityIcon" onclick="togglePasswordVisibility()">
                  <span class="fas fa-eye"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>


        <p class="mb-1">
          <a href="forgot-password.php">I forgot my password</a>
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