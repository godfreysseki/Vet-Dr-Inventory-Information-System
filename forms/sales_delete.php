<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Sales();
  echo $data->deleteSale($_POST['dataId'], $_SESSION['user_id']);