<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Payroll();
  echo $data->deletePayroll($_POST['dataId'], $_SESSION['user_id']);