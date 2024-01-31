<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new SalesOrder();
  echo $data->cancelSalesOrder($_POST['dataId']);