<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new ProfitManagement();
  echo $data->saveProfitRecord($_POST, $_SESSION['user_id']);