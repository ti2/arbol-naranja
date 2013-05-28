<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />

	<title><?php wp_title( '|', true, 'right' ); ?> <?php bloginfo('name'); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<link href="<?php bloginfo('template_directory'); ?>/css/normalize.css" rel="stylesheet" media="all">
	<link href="<?php bloginfo('template_directory'); ?>/css/main.css" rel="stylesheet" media="all">

	<!--[if lt IE 9]><script src="js/html5shiv-printshiv.js" media="all"></script><![endif]-->

	<?php
	wp_enqueue_script( 'packery', get_bloginfo('template_directory').'/js/packery.pkgd.min.js', array('jquery'), '1.0.5', true);
	wp_enqueue_script( 'main', get_bloginfo('template_directory').'/js/main.js', array('jquery'), '', true);
	wp_head();
	?>
</head>

<body <?php body_class(); ?>>
	<header id="header" role="banner">
		<h1 id="header-logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="ir logo"><?php bloginfo( 'name' ); ?></a>
		</h1>

		<h3 id="company-web-link"><a href="">Nuestra empresa</a></h3>

		<h3 class="menu-toggle">Secciones</h3>
	</header>

	<nav id="main-nav" role="navigation">
		<ul>
		<?php wp_list_categories('orderby=ID&title_li='); ?>
		</ul>
	</nav>
