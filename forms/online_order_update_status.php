<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new SalesOrder();
  $data->updateOnlineOrderStatus($_POST['orderId'], $_POST['newStatus']);
  
  return $_POST['newStatus'];