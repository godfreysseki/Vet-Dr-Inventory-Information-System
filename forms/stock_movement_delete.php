<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Inventory();
  echo $data->deleteStockMovement($_POST['dataId'], $_SESSION['user_id']);