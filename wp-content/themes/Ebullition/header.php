<!DOCTYPE html>
<html <?php language_attributes(); ?>lang="fr">

<head>
	<title>Ebullition marque de vêtements</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--::::::::::::::::::::::: Styles :::::::::::::::::::::::
	::::::::::::::::::::::::::::::::::::::::::::::::::::::-->
	<?php wp_head(); ?>
		<link rel="icon" type="image/jpg" href="<?php echo get_template_directory_uri()?>/images/E.jpg" />
		<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/font-awesome.css">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/font-awesome.min.css" type="text/css">
		<!-- Plugin CSS -->
		<link href="<?php echo get_template_directory_uri()?>/css/magnific-popup.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/style.css">

		<!--::::::::::::::::::::::: Js :::::::::::::::::::::::
	::::::::::::::::::::::::::::::::::::::::::::::::::::::-->
		<!--script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script-->

		<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
		<script src="<?php echo get_template_directory_uri()?>/js/jquery.lettering.min.js"></script>
		<script src="<?php echo get_template_directory_uri()?>/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/jquery.imageLens.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/scripts.js"></script>

</head>

<body>
	<div id="container-fluid">



		<nav class="menu navbar navbar-default navbar-fixed-top" role="navigation">


			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">
		      		<img class="logoH" href="index.php" src="<?php echo get_template_directory_uri()?>/images/logoNav.png">
		      	</a>
			</div>


			<div class="collapse navbar-collapse navbar-right " id="myNavbar">
				<ul class="nav navbar-nav">
					<li>
						<?php  wp_nav_menu(array('menu' => 'navigation', 'theme_location' => 'nav')); ?>
					</li>

				</ul>
			</div>
		</nav>

		<!--::::::::::::::::::::::::::::::::::::::::::::::::::::::
::::::::::::::::::::::: Header :::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::-->

		<header class="row" id="header">

			<div class="text-center logoHeader">

				<?php show_easylogo(); ?>
					<!--<a href="index.html"><img id="imgLogoHeader" src="<?php echo get_template_directory_uri()?>/images/logo.png"></a>
	       <p class="presentation">Vêtements, Accesoires et Décoration</p>-->
			</div>
		</header>