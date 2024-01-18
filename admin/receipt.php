<?php
  
  include_once "../includes/config.inc.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sales Receipt</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-size: 10px;
    }
    
    .receipt {
      width: 100%;
      margin: 0 auto;
      padding: 10px;
    }
    
    .receipt-header {
      text-align: center;
      margin-bottom: 5px;
    }
    
    .receipt-table {
      width: 100%;
      margin-bottom: 5px;
      font-family: 'Courier New', Courier, monospace;
    }
    
    .receipt-table th,
    .receipt-table td {
      border: 1px dashed #ccc;
      padding: 5px;
      text-align: left;
    }
    
    .receipt-total {
      font-weight: bold;
      text-align: right;
    }
    
    .receipt-footer {
      text-align: center;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="receipt">
    <div class="receipt-header">
      <h4 class="mb-0"><?= COMPANY ?></h4>
      <p><?= MOTTO ?><br><?= COMPANYPHONE ?><br><?= LOCATION ?></p>
      <h4>Sales Receipt</h4>
    </div>
    
    <table class="receipt-table">
      <thead>
      <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>Price(<?= CURRENCY ?>)</th>
        <th>Total(<?= CURRENCY ?>)</th>
      </tr>
      </thead>
      <tbody>
      <!-- Insert your sales items dynamically here -->
      <tr>
        <td>Product A</td>
        <td class="text-right">2</td>
        <td class="text-right">10.00</td>
        <td class="text-right">20.00</td>
      </tr>
      <!-- Add more rows as needed -->
      </tbody>
    </table>
    
    <div class="receipt-total">
      <p>Total:  <?= CURRENCY ?> 40.00</p>
    </div>
    
    <div class="receipt-footer">
      <p>We're grateful for your purchase!</p>
    </div>
  </div>
</div>
</body>
</html>
