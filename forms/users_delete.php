<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Users();
  echo $data->deleteUser($_POST['dataId']);