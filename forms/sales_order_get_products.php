<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new SalesOrder();
  $products = $data->getProducts();
  
  header('Content-Type: application/json');
  echo json_encode($products);