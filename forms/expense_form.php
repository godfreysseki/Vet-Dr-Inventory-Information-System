<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Expenses();
  echo $data->displayExpenseForm($_POST['dataId'] ?? null);