<!-- ======= Footer ======= -->
<footer class="footer" role="contentinfo">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 mb-4 mb-md-0">
				<img src="assets/img/apple-touch-icon.png" class="img-fluid" style="width: 80px; float: left; margin-right: 10px;">
				<p>
					Welcome to our veterinary supply center, where quality meets care. With a wide array of pharmaceuticals, equipment, and vaccines, we cater to the needs of veterinary professionals and animal caregivers. Trust us for reliable products and
					exceptional service, ensuring the health and well-being of animals everywhere.
				</p>
			</div>
			<div class="col-md-8 ms-auto">
				<div class="row site-section pt-0">
					<div class="col-6 col-md-4 mb-4 mb-md-0">
						<h3 class="mb-1">Important Links</h3>
						<ul class="list-unstyled">
							<li><a href="about.php">About Us</a></li>
							<li><a href="order_tracking.php">Order Tracking</a></li>
							<li><a href="resources.php">Resources</a></li>
							<li><a href="http://ugasolutions.co.ug:2096/" target="_blank">WebMail</a></li>
							<li><a href="login.php">Admin Login</a></li>
						</ul>
					</div>
					<div class="col-6 col-md-4 mb-4 mb-md-0">
						<h3 class="mb-1">We supply: </h3>
						<ul class="list-unstyled">
							<li><a href="#">Veterinary Equipment</a></li>
							<li><a href="#">Veterinary Drugs & Vaccines</a></li>
							<li><a href="#">Hormones</a></li>
							<li><a href="#">Anesthetics & Sedatives</a></li>
						</ul>
					</div>
					<div class="col-md-4 mb-4 mb-md-0">
						<form action="forms/subscribe.php" method="post" class="newsletter_subscription">
							
							<h3 class="mb-2">Newsletter Subscription</h3>
							<p class="m-0 p-0"><small>Subscribe to our weekly newsletter for updates and more.</small></p>
							<div class="input-group mb-3">
								<input type="email" class="form-control" name="email" id="email" placeholder="Your Email Address" aria-label="Your Email Address" aria-describedby="button-addon2">
								<button class="btn btn-sm btn-success" type="submit" id="button-addon2">Subscribe</button>
							</div>
						</form>
						<h3 class="mb-2">Follow Us</h3>
						<p class="social">
							<a href="#"><span class="bi bi-twitter"></span></a>
							<a href="#"><span class="bi bi-instagram"></span></a>
							<a href="#"><span class="bi bi-linkedin"></span></a>
							<a href="#"><span class="bi bi-youtube"></span></a>
						</p>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row justify-content-center text-center">
			<div class="col-md-7">
				<p class="copyright">&copy; 2023 - <?= date('Y', $_SERVER['REQUEST_TIME']) ?> Copyright <?= COMPANY ?>. All Rights Reserved</p>
			</div>
		</div>
	
	</div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/script.js"></script>

</body>

</html>