<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new MedicalRecords();
  echo $data->animalMedicalRecords($_POST['dataId']);