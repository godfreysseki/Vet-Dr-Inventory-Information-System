<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Payroll();
  echo $data->displayPayrollForm($_POST['dataId'] ?? null);