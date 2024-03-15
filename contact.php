<?php
  
  include_once "includes/webHeader.inc.php";

?>
	
	<main id="main">
		
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
								<h1 data-aos="fade-up" data-aos-delay="">Get in touch</h1>
								<p class="mb-5" data-aos="fade-up" data-aos-delay="100">Feel free to reach out to us for any inquiries, feedback, or assistance. We're here to help!</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		</section>
		
		<section class="section">
			<div class="container">
				<div class="row mb-5 align-items-end">
					<div class="col-md-6" data-aos="fade-up">
						
						<h2>Contact Form</h2>
						<p class="mb-0">Feel free to reach out to us using the provided details or send us an email using the form below.</p>
					</div>
				
				</div>
				
				<div class="row">
					<div class="col-md-4 ms-auto order-2" data-aos="fade-up">
						<ul class="list-unstyled">
							<li class="mb-3">
								<strong class="d-block mb-1">Address</strong>
								<span>Along Kampala Road, Semuto, Semuto TC, Nakaseke, Uganda</span>
							</li>
							<li class="mb-3">
								<strong class="d-block mb-1">Phone</strong>
								<span><?= phone(COMPANYPHONE) ?>, <?= phone(COMPANYPHONE2) ?></span>
							</li>
							<li class="mb-3">
								<strong class="d-block mb-1">Email</strong>
								<span><?= email(COMPANYEMAIL) ?></span>
							</li>
						</ul>
					</div>
					
					<div class="col-md-6 mb-5 mb-md-0" data-aos="fade-up">
						<form action="forms/contact.php" method="post" role="form" class="php-email-form">
							
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="name">Name</label>
									<input type="text" name="name" class="form-control" id="name" required>
								</div>
								<div class="col-md-6 form-group mt-3 mt-md-0">
									<label for="name">Email</label>
									<input type="email" class="form-control" name="email" id="email" required>
								</div>
								<div class="col-md-12 form-group mt-3">
									<label for="name">Subject</label>
									<input type="text" class="form-control" name="subject" id="subject" required>
								</div>
								<div class="col-md-12 form-group mt-3">
									<label for="name">Message</label>
									<textarea class="form-control" name="message" required></textarea>
								</div>
								
								<div class="col-md-12 mb-3">
									<div class="loading">Loading</div>
									<div class="error-message"></div>
									<div class="sent-message">Your message has been sent. Thank you!</div>
								</div>
								
								<div class="col-md-6 form-group">
									<input type="submit" class="btn btn-primary d-block w-100" value="Send Message">
								</div>
							</div>
						
						</form>
					</div>
				
				</div>
			</div>
		</section>
		
		<!-- ======= CTA Section ======= -->
		<section class="section cta-section p-0 pt-1">
			<div class="container p-0">
				<div class="row align-items-center p-0">
					<div class="col-md-12 mx-auto text-center text-md-start p-0">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3298.679638810832!2d32.32538207398313!3d0.6205552634879612!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13
						.1!3m3!1m2!1s0x177cf83f55a01e45%3A0x24157830f97a814e!2sJ8CH%2B64C%20retail%20shops%2C%20Semuto!5e1!3m2!1sen!2sug!4v1709823329443!5m2!1sen!2sug" width="100%" height="450" style="border:0; width:100%" allowfullscreen="" loading="lazy"
						        referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
				</div>
			</div>
		</section><!-- End CTA Section -->
	
	</main><!-- End #main -->

<?php
  
  include_once "includes/webFooter.inc.php";

?>