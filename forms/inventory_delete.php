<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Inventory();
  echo $data->deleteItem($_POST['dataId'], $_SESSION['user_id']);