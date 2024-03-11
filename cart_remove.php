<?php
  
  include_once "includes/config.inc.php";
  
  $data = new SalesOrder();
  $data->removeFromCart($_POST['cartId']);