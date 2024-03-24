<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Resources();
  echo $data->deleteResource($_POST['dataId']);