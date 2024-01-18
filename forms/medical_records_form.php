<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new MedicalRecords();
  echo $data->displayMedicalRecordForm($_POST['dataId'] ?? null);