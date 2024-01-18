<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new AuditTrail();
  echo $data->clearAllAuditTrails();