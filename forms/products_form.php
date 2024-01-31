<?php
  
  include_once "../includes/config.inc.php";
  
  $productManager = new Products();
  echo $productManager->productForm($_POST['dataId'] ?? null);