<?php
  
  include_once "includes/webHeader.inc.php";

?>
  
  <main id="main">
    
    <!-- ======= Blog Section ======= -->
    <section class="hero-section inner-page">
      <div class="wave">
        
        <svg width="1920px" height="265px" viewBox="0 0 1920 265" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
              <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,667 L1017.15166,667 L0,667 L0,439.134243 Z" id="Path"></path>
            </g>
          </g>
        </svg>
      
      </div>
      
      <div class="container">
        <div class="row align-items-center">
          <div class="col-12">
            <div class="row justify-content-center">
              <div class="col-md-12 text-center hero-text">
                <h1 data-aos="fade-up" data-aos-delay="">Watch our Informative Videos</h1>
                <p class="mb-5" data-aos="fade-up" data-aos-delay="100">Explore our collection of educational videos covering topics related to agriculture, animal husbandry, and sustainable farming practices.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    
    </section>
  
    <section class="video-section mb-4">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="video-item">
              <div class="video-thumbnail">
                <!-- Embed video thumbnail image -->
                <img src="video_thumbnail_1.jpg" alt="Video Thumbnail" class="img-fluid">
                <!-- Play button overlay -->
                <div class="play-button"></div>
              </div>
              <div class="video-details">
                <h3 class="video-title">Title of Video 1</h3>
                <p class="video-description">Brief description of the video content. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <!-- Embed video link -->
                <a href="video1.mp4" class="btn btn-primary" target="_blank">Watch Video</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <!-- Repeat the structure for additional video items -->
          </div>
          <div class="col-md-4">
            <!-- Repeat the structure for additional video items -->
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

<?php
  
  include_once "includes/webFooter.inc.php";

?>