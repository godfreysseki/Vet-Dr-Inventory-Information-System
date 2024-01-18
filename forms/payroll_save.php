<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Payroll();
  echo $data->generatePayroll($_POST, $_SESSION['user_id']);