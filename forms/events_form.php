<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Events();
  echo $data->displayEventForm($_POST['dataId'] ?? null);