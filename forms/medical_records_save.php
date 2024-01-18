<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new MedicalRecords();
  echo $data->saveMedicalRecord($_POST, $_SESSION['user_id']);