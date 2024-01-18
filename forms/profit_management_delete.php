<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new ProfitManagement();
  echo $data->deleteProfitRecord($_POST['dataId'], $_SESSION['user_id']);