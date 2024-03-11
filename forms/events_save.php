<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Events();
  echo $data->saveEvent($_POST, $_SESSION['user_id']);