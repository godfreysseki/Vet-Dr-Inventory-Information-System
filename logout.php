<?php
  
  include_once "includes/config.inc.php";
  
  $user = new Users();
  $user->logoutUser();