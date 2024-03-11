<?php
  include_once "includes/webHeader.inc.php";
  
  $data = new SalesOrder();
  
  $items = $data->countMyCart();
  if ($items < 1) {
	  header('location: shop.php');
  }

?>

<main id="main">
	
	<!-- ======= Blog Section ======= -->
	<section class="hero-section inner-page">
		<div class="wave">
			
			<svg width="1920px" height="265px" viewBox="0 0 1920 265" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
					<g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
						<path
								d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,667 L1017.15166,667 L0,667 L0,439.134243 Z"
								id="Path"></path>
					</g>
				</g>
			</svg>
		
		</div>
		
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12">
					<div class="row justify-content-center">
						<div class="col-md-7 text-center hero-text">
							<h1 data-aos="fade-up" data-aos-delay="">Checkout</h1>
							<p class="mb-5" data-aos="fade-up" data-aos-delay="100">Review your order and adjust when needed before submission.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	</section>
	
	<!-- ======= Checkout Section ======= -->
	<section class="section checkout">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 order-2 order-lg-1 mb-2">
					<!-- Shipping Information -->
					<div class="card mb-4">
						<div class="card-body">
							<h2 class="card-title">Delivery Information</h2>
							<form method="post" action="complete_order.php">
								<div class="mb-3">
									<label for="fullName" class="form-label">Full Name</label>
									<input type="text" class="form-control" name="fullName" id="fullName" required>
								</div>
								<div class="mb-3">
									<label for="telephone" class="form-label">Telephone Number</label>
									<input type="text" class="form-control" name="telephone" id="telephone" placeholder="07..." required>
								</div>
								<div class="mb-3">
									<label for="address" class="form-label">Address</label>
									<input type="text" class="form-control" name="address" id="address" placeholder="Village, Zone, City" required>
								</div>
								<div class="mb-3">
									<label for="payment_method" class="form-label">Payment Method</label>
									<select class="form-select" name="payment_method" id="payment_method" required>
										<option value="" >-- Select a payment method --</option>
										<option value="Cash on Delivery">Cash on Delivery</option>
										<option value="Mobile Money">Mobile Money</option>
									</select>
								</div>
								<div class="mb-3">
									<input type="submit" class="btn btn-primary float-end" name="completeOrder" value="Place Order">
								</div>
							</form>
						</div>
					</div>
					<!-- End Shipping Information -->
				</div>
				<div class="col-lg-5 order-1 order-lg-2 mb-2">
					<!-- Order Summary -->
					<div class="card">
						<div class="card-body">
							<h2 class="card-title section-heading text-center">Your Order Summary</h2>
							<p class="text-muted text-center"><em><small>Please take a moment to review your order details below. Once confirmed, your order will be processed accordingly. This step ensures the accuracy and completeness of your purchase. Thank you
										for verifying your order before finalizing.</small></em></p>
							<!-- Summary details will be displayed here -->
              <?= $data->myOrderSummary() ?>
						</div>
					</div>
					<!-- End Order Summary -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Checkout Section -->

</main><!-- End #main -->

<?php
  include_once "includes/webFooter.inc.php";
?>
