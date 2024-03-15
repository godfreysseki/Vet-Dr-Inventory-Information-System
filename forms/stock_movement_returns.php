<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Inventory();
  echo $data->displayAssessmentForm($_POST['dataId'] ?? null);