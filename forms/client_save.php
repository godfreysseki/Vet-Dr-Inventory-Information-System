<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Clients();
  echo $data->saveClient($_POST, $_SESSION['user_id']);