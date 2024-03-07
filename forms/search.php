<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Search();
  echo $data->searchProduct();