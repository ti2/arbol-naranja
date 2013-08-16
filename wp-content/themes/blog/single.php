<?php get_header(); ?>

<main id="main" role="main">
	<?php get_template_part('loop', 'single'); ?>
</main>

<div id="articles">
	<h1 id="articles-title">Últimos artículos</h1>

	<?php get_search_form(); ?>
	<?php //wp_nav_menu( array('theme_location' => 'social', 'container_class' => 'menu-social' )); ?>

	<div id="article-list">
		<?php query_posts(''); ?>

		<?php get_template_part('loop'); ?>
	</div>

	<?php
	//load_more_button();

	wp_reset_query();
	?>
</div>

<?php get_footer(); ?>
