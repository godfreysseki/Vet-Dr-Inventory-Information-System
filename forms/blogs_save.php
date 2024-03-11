<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Blogs();
  echo $data->saveBlog($_POST, $_SESSION['user_id']);