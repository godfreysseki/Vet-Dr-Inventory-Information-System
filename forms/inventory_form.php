<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Inventory();
  echo $data->displayItemForm($_POST['dataId'] ?? null);