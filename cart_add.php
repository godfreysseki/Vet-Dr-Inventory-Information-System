<?php
  
  include_once "includes/config.inc.php";
  
  $data = new SalesOrder();
  echo $data->addToCart($_POST['id']);