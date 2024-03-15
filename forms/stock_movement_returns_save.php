<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Inventory();
  echo $data->saveStockMovementReturns($_POST, $_SESSION['user_id']);