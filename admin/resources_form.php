<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Resources();
  echo $data->resourceForm($_POST['dataId'] ?? null);