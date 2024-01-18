<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Payroll();
  echo $data->getUserPayrollTable($_POST['dataId']);