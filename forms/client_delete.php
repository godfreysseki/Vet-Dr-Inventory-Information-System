<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Clients();
  echo $data->deleteClient($_POST['dataId'], $_SESSION['user_id']);