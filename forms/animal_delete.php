<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Animals();
  echo $data->deleteAnimal($_POST['dataId'], $_SESSION['user_id']);