<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Inventory();
  echo $data->generateStockMovementPrintout($_GET['id']);
  unset($_SESSION['stock_movement_track_number']);