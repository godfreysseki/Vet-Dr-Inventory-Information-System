<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Expenses();
  echo $data->saveExpense($_POST, $_SESSION['user_id']);