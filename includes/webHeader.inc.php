<?php
  
  include_once "config.inc.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  
  <title><?= PAGE .' | '. COMPANY ?></title>
	
	<!-- SEO META Tags -->
	<title>Veterinary Supplies and Products | Your Website Name</title>
	<meta name="description" content="Explore a wide range of veterinary supplies, drugs, equipment, vaccines, hormones, and anesthetics at our one-stop shopping center.">
	<meta name="keywords" content="veterinary supplies, veterinary drugs, equipment, vaccines, hormones, anesthetics">
	<meta name="author" content="Gramaxic">
	<meta name="robots" content="index, follow">
	
	<!-- Open Graph Protocol (OGP) for Social Media -->
	<meta property="og:title" content="Veterinary Supplies and Products | Your Website Name">
	<meta property="og:description" content="Explore a wide range of veterinary supplies, drugs, equipment, vaccines, hormones, and anesthetics at our one-stop shopping center.">
	<meta property="og:image" content="https://example.com/image.jpg">
	<meta property="og:url" content="https://example.com">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="<?= COMPANY ?>">
	
	<!-- Twitter Card for Twitter Sharing -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="Veterinary Supplies and Products | Your Website Name">
	<meta name="twitter:description" content="Explore a wide range of veterinary supplies, drugs, equipment, vaccines, hormones, and anesthetics at our one-stop shopping center.">
	<meta name="twitter:image" content="https://example.com/image.jpg">
	
	<!-- Website Icon -->
	<link rel="icon" href="assets/img/favicon.png" type="image/x-icon">
	<link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
	<!-- Apple Touch Icon (iOS, Android) -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
	
	<!-- Canonical URL -->
	<link rel="canonical" href="https://example.com">
	
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
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
  <div class="container d-flex justify-content-between align-items-center">
    
    <div class="logo">
      <h1><a href="./"><?= COMPANY ?></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
    </div>
    
    <nav id="navbar" class="navbar">
      <ul>
        <li><a class="active " href="./">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href=".html">Events & Workshops</a></li>
        <li class="dropdown"><a href="#"><span>Blogs & Articles</span> <i class="bi bi-chevron-down"></i></a>
	      <ul>
		      <li><a href="blogs.php">Animal Science</a></li>
		      <li><a href="blogs.php">Crop Science</a></li>
	      </ul>
	      </li>
	      <li><a href="shop.php">Shop</a></li>
	      <li><a href="contact.php">Contact Us</a></li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
  
  </div>
</header><!-- End Header -->