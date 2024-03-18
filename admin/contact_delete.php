<?php
  
  include_once "../includes/config.inc.php";
  
  $check = new Users();
  $check->checkUser(ROLE);
  
  $data = new Contacts();
  $data->deleteContact($_POST['dataId']);