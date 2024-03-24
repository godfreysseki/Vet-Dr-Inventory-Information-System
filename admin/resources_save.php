<?php
  
  header('Content-header: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Resources();
  echo $data->addResource($_POST);