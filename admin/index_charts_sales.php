<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $dashboard = new Dashboard();
  $salesData = $dashboard->getRealTimeSalesData();
  
  echo json_encode($salesData);