<?php
  
  include_once "config.inc.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
		
	<!-- SEO META Tags -->
	<title><?= PAGE ?> | <?= COMPANY ?></title>
	<meta name="description" content="Explore a wide range of veterinary supplies, drugs, equipment, vaccines, hormones, and anesthetics at our one-stop shopping center.">
	<meta name="keywords" content="animal medicine, birds medicine, veterinary doctor, veterinary supplies, veterinary drugs, equipment, vaccines, hormones, anesthetics, UgaSolution, UgaSolutions Pharmaceuticals, UgaSolutions Pharmaceuticals Ltd, Uga Solutions, Uga solutions Pharmaceuticals, Uga Solutions Pharmaceuticals Ltd, Gramaxic">
	<meta name="author" content="Gramaxic">
	<meta name="robots" content="index, follow">
	
	<!-- Open Graph Protocol (OGP) for Social Media -->
	<meta property="og:title" content="<?= PAGE ?> | <?= COMPANY ?>">
	<meta property="og:description" content="Explore a wide range of veterinary supplies, drugs, equipment, vaccines, hormones, and anesthetics at our one-stop shopping center.">
	<meta property="og:image" content="https://ugasolutions.co.ug/assets/img/logo.png">
	<meta property="og:url" content="https://ugasolutions.co.ug">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="<?= COMPANY ?>">
	
	<!-- Twitter Card for Twitter Sharing -->
	<meta name="twitter:card" content="Welcome to our veterinary supply center, where quality meets care. With a wide array of pharmaceuticals, equipment, and vaccines, we cater to the needs of veterinary professionals and animal caregivers. Trust us for reliable products and exceptional service, ensuring the health and well-being of animals everywhere.">
	<meta name="twitter:title" content="<?= PAGE ?> | <?= COMPANY ?>">
	<meta name="twitter:description" content="Explore a wide range of veterinary supplies, drugs, equipment, vaccines, hormones, and anesthetics at our one-stop shopping center.">
	<meta name="twitter:image" content="https://ugasolutions.co.ug/assets/img/logo.png">
	
	<!-- Website Icon -->
	<link rel="icon" href="assets/img/favicon.png" type="image/x-icon">
	<link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
	<!-- Apple Touch Icon (iOS, Android) -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
	
	<!-- Canonical URL -->
	<link rel="canonical" href="https://ugasolutions.co.ug">
	
	<!-- Microsoft Tile for Windows 8 / Windows 10 -->
	<meta name="msapplication-TileImage" content="assets/img/apple-touch-icon.png">
	<meta name="msapplication-TileColor" content="#00ff00">
	
	<!-- Google Site Verification -->
	<meta name="google-site-verification" content="your-google-verification-code">
	
	
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	
	<!-- Vendor CSS Files -->
	<link href="assets/vendor/aos/aos.css" rel="stylesheet">
	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="assets/vendor/mdi/css/materialdesignicons.min.css" rel="stylesheet">
	<link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
	<link href="assets/vendor/venobox/venobox.min.css" rel="stylesheet">
	
	<!-- Template Main CSS File -->
	<link href="assets/css/style.css" rel="stylesheet">

</head>

<body>


<!-- Contacts and Social Media Handles -->
<div class="contacts d-none">
	<ul class="social-media">
		<li><a href="#"><i class="bi bi-facebook"></i></a></li>
		<li><a href="#"><i class="bi bi-twitter"></i></a></li>
		<li><a href="#"><i class="bi bi-instagram"></i></a></li>
		<!-- Add more social media icons and links as needed -->
	</ul>
	<p>Contact us: <a href="tel:+123456789">+123456789</a></p>
</div>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
	<div class="container-fluid d-flex justify-content-between align-items-center">
		
		<div class="header-top d-none d-lg-block">
			<!-- Left side: Quick contacts -->
			<div class="quick-contacts">
				<p><?= email(COMPANYEMAIL) ?> | <?= phone(COMPANYPHONE) ?> , <?= phone(COMPANYPHONE2) ?></p>
			</div>
			
			<!-- Right side: Social media handles -->
			<div class="social-media">
				<!-- Add your social media icons here -->
				<a href="#"><span class="bi bi-twitter"></span></a>
				<a href="#"><span class="bi bi-instagram"></span></a>
				<a href="#"><span class="bi bi-linkedin"></span></a>
				<a href="#"><span class="bi bi-youtube"></span></a>
			</div>
		</div>
		
		<!-- Logo -->
		<div class="logo">
			<h1><a href="./"><?= COMPANY ?></a></h1>
		</div>
		
		<!--<div class="logo">
      <h1><a href="./"><? /*= COMPANY */ ?></a></h1>-->
		<!-- Uncomment below if you prefer to use an image logo -->
		<!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
		<!--</div>-->
		
		<nav id="navbar" class="navbar">
			<ul>
				<li><a href="./">Home</a></li>
				<li><a href="about.php">About Us</a></li>
				<li><a href="shop.php">Shop</a></li>
				<li><a href="events.php">Events & Workshops</a></li>
				<li><a href="blogs.php">Blogs & Articles</a></li>
				<li><a href="contact.php">Contact Us</a></li>
				<li><a href="cart.php" class="cartLink"><i class="d-none d-sm-block d-md-none">Shopping Cart</i><i class="mdi mdi-cart-variant mdi-24px d-sm-none d-md-block" data-bs-toggle="tooltip" title="Shopping Cart"><span
									class="cart_count"></span></i></a></li>
			</ul>
			<i class="bi bi-list mobile-nav-toggle"></i>
		</nav><!-- .navbar -->
	
	</div>
</header><!-- End Header -->