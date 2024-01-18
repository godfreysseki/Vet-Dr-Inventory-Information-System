<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new ProfitManagement();
  echo $data->displayProfitRecordForm($_POST['dataId'] ?? null);