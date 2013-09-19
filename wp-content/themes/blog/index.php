<?php get_header(); ?>

<main id="main" role="main">
	<?php putRevSlider('slider1') ?>
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
			echo 'Menú';
		}
		?>
	</h1>

	<?php get_search_form(); ?>
	<?php //wp_nav_menu( array('theme_location' => 'social', 'container_class' => 'menu-social' )); ?>


	<div id="article-list">
		<?php if ( have_posts() ) : ?>

			<?php get_template_part('loop'); ?>

		<?php else : ?>
			<div class="gutter-sizer"></div>
			<p class="articles-msg">Su busqueda no ha arrojado resultados</p>
		<?php endif; ?>
	</div>

	<?php //load_more_button(); ?>
</div>

<?php get_footer(); ?>
