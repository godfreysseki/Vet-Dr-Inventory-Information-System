<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Newsletter();
  echo $data->subscribe($_POST['email']);