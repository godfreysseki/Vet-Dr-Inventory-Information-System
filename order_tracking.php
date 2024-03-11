<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">
  <style>
		body {
			background-color: #f8f9fa;
		}
		
		.order-container {
			max-width: 600px;
			margin: 50px auto;
			padding: 20px;
			background-color: #ffffff;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}
		
		.order-header {
			text-align: center;
			margin-bottom: 30px;
		}
		
		.order-status {
			font-size: 18px;
			font-weight: bold;
			color: #007bff;
		}
		
		.order-details {
			margin-top: 20px;
		}
		
		.order-details p {
			margin: 10px 0;
		}
		
		.tracking-number {
			color: #28a745;
		}
		
		.tracking-info {
			margin-top: 20px;
		}
		
		.tracking-info p {
			margin: 5px 0;
		}
  </style>
  <title>Order Tracking</title>
</head>
<body>

<div class="order-container">
  <div class="order-header">
    <h2>Order Tracking</h2>
    <p class="order-status">Order Shipped</p>
  </div>
  
  <div class="order-details">
    <p><strong>Order Number:</strong> #123456</p>
    <p><strong>Tracking Number:</strong> <span class="tracking-number">TRK789012345</span></p>
    <p><strong>Order Date:</strong> January 15, 2024</p>
    <p><strong>Estimated Delivery:</strong> January 25, 2024</p>
  </div>
  
  <div class="tracking-info">
    <h4>Tracking Information</h4>
    <p><strong>Location:</strong> In Transit</p>
    <p><strong>Last Update:</strong> January 20, 2024</p>
  </div>
  
</div>

</body>
</html>
