<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Appointments();
  echo $data->saveAppointment($_POST, $_SESSION['user_id']);