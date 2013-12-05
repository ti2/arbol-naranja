<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />

	<title><?php wp_title( '|', true, 'right' ); ?> <?php bloginfo('name'); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<link href='http://fonts.googleapis.com/css?family=Enriqueta:400,700' rel='stylesheet' type='text/css'>
	<link href="<?php bloginfo('template_directory'); ?>/css/normalize.css" rel="stylesheet" media="all">
	<link href="<?php bloginfo('template_directory'); ?>/css/main.css" rel="stylesheet" media="all">

	<!--[if lt IE 9]><script src="<?php bloginfo('template_directory'); ?>/js/html5shiv-printshiv.js" media="all"></script><![endif]-->

	<?php
	wp_enqueue_script( 'prefixfree', get_bloginfo('template_directory').'/js/prefixfree.min.js', array(), '1.0.7');
	wp_enqueue_script( 'packery', get_bloginfo('template_directory').'/js/packery.pkgd.min.js', array('jquery'), '1.0.5', true);
	wp_enqueue_script( 'main', get_bloginfo('template_directory').'/js/main.js', array('jquery'), '', true);
	wp_head();
	?>
</head>

<body <?php body_class(); ?>>
	<header id="header" role="banner">
		<div id="header-wrapper">
			<h1 id="header-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="ir logo"><?php bloginfo( 'name' ); ?></a>
			</h1>

			<?php wp_nav_menu( array('theme_location' => 'social', 'container_class' => 'menu-social' )); ?>

			<h3 class="menu-toggle">Secciones</h3>

			<nav id="main-nav" role="navigation">
				<ul class="menu-main">
				<?php wp_list_categories('orderby=ID&title_li='); ?>
				</ul>
			</nav>

		</div>
	</header>

	<?php
	$wrapper_back_img_id = kc_get_option( 'nso', 'wrapper_background', 'wrapper_back_file' );
	$wrapper_back_img_url = wp_get_attachment_url($wrapper_back_img_id);
	$wrapper_back_color = kc_get_option( 'nso', 'wrapper_background', 'wrapper_back_color' );
	$wrapper_inline_style = "background-image: url('$wrapper_back_img_url'); background-color: $wrapper_back_color;";
	?>

	<div id="wrapper" style="<?php echo $wrapper_inline_style; ?>">
