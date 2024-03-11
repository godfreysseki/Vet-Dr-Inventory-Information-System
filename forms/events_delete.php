<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Events();
  echo $data->deleteEvent($_POST['dataId'], $_SESSION['user_id']);