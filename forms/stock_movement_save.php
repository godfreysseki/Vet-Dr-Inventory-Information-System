<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Inventory();
  echo $data->saveStockMovement($_POST, $_SESSION['user_id']);