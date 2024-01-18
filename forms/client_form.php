<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Clients();
  echo $data->displayClientForm($_POST['dataId'] ?? null);