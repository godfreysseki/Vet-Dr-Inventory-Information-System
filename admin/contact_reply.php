<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Contact();
  echo $data->displayContactReplyForm($_POST['dataId']);