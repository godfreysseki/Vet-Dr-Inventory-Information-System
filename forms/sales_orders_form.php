<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new SalesOrder();
  echo $data->saleOrderForm($_POST['dataId'] ?? null);