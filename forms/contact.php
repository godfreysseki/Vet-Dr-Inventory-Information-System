<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Contact();
  echo $data->sendContact($_POST);