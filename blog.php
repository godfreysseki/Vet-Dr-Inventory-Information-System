<?php
  
  include_once "includes/webHeader.inc.php";
  
  $data = new Blogs();
  $blog = $data->getBlogById($_GET['id']);

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
								<h1 data-aos="fade-up" data-aos-delay=""><?= $blog['title'] ?></h1>
								<p class="mb-5" data-aos="fade-up" data-aos-delay="100"><?= dates($blog['regdate']) ?> &bullet; By <a href="#" class="text-white"><?= $blog['author'] ?></a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		</section>
		
		<section class="site-section mb-4">
			<div class="container">
				<div class="row">
					<div class="col-md-8 blog-content text-justify mb-4">
            
            <?= $blog['description'] ?>
						
						<div class="pt-4">
							Tags:
              <?php
                
                $tags = explode(", ", $blog['tags']);
                foreach ($tags as $tag) {
                  echo '<a href="javascript:void(0)" class="tag">' . $tag . '</a>';
                }
              
              ?>
						</div>
					
					</div>
					<div class="col-md-4 sidebar">
						<div class="sidebar-box">
							<img src="assets/img/person_1.jpg" alt="Image placeholder" class="img-fluid mb-4">
							<h3>About The Author</h3>
							<p class="text-justify">With over a decade in veterinary practice, Dr. Kisitu Williams is a dedicated professional devoted to animal well-being. As an esteemed authority in the field, he leverages extensive experience to diagnose and treat
								diverse health
								issues. Driven by a passion for responsible pet ownership and preventive care, Dr. Kisitu stays at the forefront of veterinary science, offering valuable insights to pet owners and colleagues alike.</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	
	</main><!-- End #main -->

<?php
  
  include_once "includes/webFooter.inc.php";

?>