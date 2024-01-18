<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Sales();
  echo $data->displaySaleForm($_POST['dataId'] ?? null);