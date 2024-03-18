<?php
  
  include_once "includes/webHeader.inc.php";

?>
	<style>
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
	</style>
	<main id="main">
		
		<!-- ======= Single Blog Section ======= -->
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
							<div class="col-md-10 text-center hero-text">
								<h1 data-aos="fade-up" data-aos-delay="">Order Tracking</h1>
								<p class="mb-5" data-aos="fade-up" data-aos-delay="100">Track your order status and know when your order will be received.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		</section>
		
		<section class="site-section mb-4">
			<div class="container">
				<div class="row">
					<div class="col-12 mx-auto">
						
						<div class="order-container">
							<form method="post" class="onlineOrderStatusFrom mb-3">
								<input class="form-control online_order_status_number rounded-5" type="text" placeholder="Your Order Number..." aria-label="Order Number">
							</form>
							
							<div class="order-master"></div>
						
						</div>
						
					</div>
				</div>
			</div>
		</section>
	</main>

<?php
  
  include_once "includes/webFooter.inc.php";

?>