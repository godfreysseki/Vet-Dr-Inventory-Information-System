<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Appointments();
  echo $data->deleteAppointment($_POST['dataId'], $_SESSION['user_id']);