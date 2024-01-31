<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new SalesOrder();
  $data->completeOrder($_GET['id']);
  
  header('location: sales_orders.php');