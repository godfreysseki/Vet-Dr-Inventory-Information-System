<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Contact();
  echo $data->deleteContact($_POST['dataId'], $_SESSION['user_id']);