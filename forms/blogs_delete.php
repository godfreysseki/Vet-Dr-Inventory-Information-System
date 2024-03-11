<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Blogs();
  echo $data->deleteBlog($_POST['dataId'], $_SESSION['user_id']);