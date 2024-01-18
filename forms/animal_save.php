<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Animals();
  echo $data->saveAnimal($_POST, $_SESSION['user_id']);