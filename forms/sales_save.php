<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Sales();
  echo $data->saveSale($_POST, $_SESSION['user_id']);