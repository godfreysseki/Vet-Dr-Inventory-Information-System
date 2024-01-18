<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Appointments();
  echo $data->displayAppointmentForm($_POST['dataId'] ?? null);