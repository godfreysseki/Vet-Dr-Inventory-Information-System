<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Expenses();
  echo $data->deleteExpense($_POST['dataId'], $_SESSION['user_id']);