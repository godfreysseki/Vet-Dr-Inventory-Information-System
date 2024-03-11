<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Inventory();
  echo $data->displayStockMovementForm($_POST['dataId'] ?? null);