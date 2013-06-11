<?php get_header(); ?>

<main id="main" role="main">
	<?php if ( function_exists( 'meteor_slideshow' ) ) { meteor_slideshow(); } ?>
</main>

<div id="articles">
	<h1 id="articles-title">
		<?php
		$search_query = get_search_query();
		if ($search_query) {
			echo 'Resultados para: '.$search_query;
		} elseif (is_archive()) {
			single_term_title();
		} else {
			echo 'Últimos artículos';
		}
		?>
	</h1>

	<?php get_search_form(); ?>
	<?php //wp_nav_menu( array('theme_location' => 'social', 'container_class' => 'menu-social' )); ?>


	<?php if ( have_posts() ) : ?>

		<div id="article-list">
			<?php get_template_part('loop'); ?>
		</div>

		<?php load_more_button(); ?>

	<?php else : ?>
		<?php echo '<p>Su busqueda no ha arrojado resultados</p>'; ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
