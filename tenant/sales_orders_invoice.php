<?php
  
  include_once "../includes/config.inc.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sales Receipt</title>
	<link href="../assets/css/adminlte.min.css" rel="stylesheet">
	<style>
		body {
			font-size: 10px;
			margin: 0;
			padding: 0;
			color: #000 !important;
		}
		
		.receipt {
			width: 100%;
			margin: 0 auto;
			padding: 10px;
		}
		
		.receipt-header {
			text-align: left;
			margin-bottom: 5px;
		}
		
		.receipt-table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 5px;
			font-family: 'Courier New', Courier, monospace;
		}
		
		.receipt-table,
		.receipt-table th,
		.receipt-table td {
			border: 1px dashed #ccc !important;
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
			<h6 class="mb-0"><?= COMPANY ?></h6>
			<p><q><?= MOTTO ?></q><br><?= COMPANYPHONE ?> | <?= COMPANYPHONE2 ?> | <?= LOCATION ?></p>
		</div>
    
    <?php
      
      $data = new SalesOrder();
      $data->invoiceOrder($_GET['id']);
      $details = $data->orderDetails($_GET['id']);
    
    ?>
		
		<div class="receipt-header">
			<p class="font-weight-bold">Client : <strong><?= $details['customer_name'] ?></strong><br>
        <?= $details['customer_phone'] ?? null ?> / <?= $details['customer_email'] ?? null ?></p>
			<h6>Sales Receipt</h6>
		</div>
    
    
    <?php
      
      $data  = new SalesOrder();
      $items = $data->getOrderItems($_GET['id']);
      
      $no       = 1;
      $list     = "";
      $subtotal = 0;
      foreach ($items as $item) {
        $list     .= "<tr>
												<td>" . $no . "</td>
												<td>" . $item['product_name'] . "</td>
												<td class='text-right'>" . number_format($item['quantity'], 2) . "</td>
												<td class='text-right'>" . number_format($item['price'], 2) . "</td>
												<td class='text-right'>" . number_format($item['quantity'] * $item['price'], 2) . "</td>
											</tr>";
        $subtotal += ($item['quantity'] * $item['price']);
        $no++;
      }
      echo "<table class='table table-sm table-striped table-bordered receipt-table'>
							    <thead>
							    <tr>
								    <th>#</th>
								    <th>Item</th>
								    <th>Qty</th>
								    <th>Price(UGX)</th>
								    <th>Total(UGX)</th>
							    </tr>
							    </thead>
							    <tbody>
							    " . $list . "
							    </tbody>
						    </table>";
    ?>
		
		
		<div class="receipt-total">
			<p>Total: <?= CURRENCY ?> <?= number_format($subtotal, 2) ?></p>
		</div>
		
		<div class="receipt-footer">
			<p>Thank you for choosing <?= COMPANY ?>. Your recent purchase is greatly appreciated. This receipt confirms your transaction details. If you have any questions or need further assistance, please don't hesitate to contact us. We value your
				trust and look forward to serving you again soon.</p>
		</div>
	</div>
</div>

<script>
	window.alert('Reload the sales order page after finishing with tasks here.');
	window.print();
</script>
</body>
</html>