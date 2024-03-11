<?php
  
  include_once "includes/config.inc.php";
  
  $data = new SalesOrder();
  $data->updateCart($_POST['cartId'], $_POST['signs']);