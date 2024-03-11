<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Blogs();
  echo $data->displayBlogForm($_POST['dataId'] ?? null);