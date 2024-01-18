<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Animals();
  echo $data->displayAnimalForm($_POST['dataId'] ?? null);