<?php
  
  include_once "includes/webHeader.inc.php";
  
  $data  = new Events();
  $event = $data->getEventById($_GET['id']);

?>
	
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
								<h1 data-aos="fade-up" data-aos-delay=""><?= $event['title'] ?></h1>
								<p class="mb-5" data-aos="fade-up" data-aos-delay="100"><?= dates($event['event_date']) ?> &bullet; By <a href="#" class="text-white"><?= $event['hosts'] ?></a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		</section>
		
		<section class="site-section mb-4">
			<div class="container">
				<div class="row">
					<div class="col-md-12 mb-4 blog-content">
            
            <?= $event['body'] ?>
					
					</div>
					<div class="col-md-12">
						<h2 class="section-heading"><?= $event['types'] ?> Images</h2>
						<div class="row">
              <?php
                
                $images = explode(", ", $event['images']);
                foreach ($images as $image) {
                  echo '<div class="col-sm-3"><img src="assets/img/events/' . $image . '" class="img-fluid"></div>';
                }
              
              ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<!-- ======= CTA Section ======= -->
		<section class="section cta-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 me-auto text-center text-md-start mb-5 mb-md-0">
						<h2>Starts Publishing Your Apps</h2>
					</div>
					<div class="col-md-5 text-center text-md-end">
						<p><a href="#" class="btn d-inline-flex align-items-center"><i class="bx bxl-apple"></i><span>App store</span></a> <a href="#" class="btn d-inline-flex align-items-center"><i class="bx bxl-play-store"></i><span>Google play</span></a></p>
					</div>
				</div>
			</div>
		</section><!-- End CTA Section -->
	
	</main><!-- End #main -->

<?php
  
  include_once "includes/webFooter.inc.php";

?>