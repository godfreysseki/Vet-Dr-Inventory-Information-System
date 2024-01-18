<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new MedicalRecords();
  echo $data->deleteMedicalRecord($_POST['dataId'], $_SESSION['user_id']);