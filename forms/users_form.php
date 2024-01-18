<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Users();
  echo $data->addUserForm($_POST['dataId'] ?? null);