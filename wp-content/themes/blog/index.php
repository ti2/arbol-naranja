<?php get_header(); ?>

<main id="main" role="main">
	<?php putRevSlider('slider1') ?>
</main>

<div id="articles">
	<div class="main-block">
		<h1 class="articles-title">
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

		<div class="article-list">
			<?php if ( have_posts() ) : ?>

				<?php get_template_part('loop'); ?>

			<?php else : ?>
				<div class="gutter-sizer"></div>
				<p class="articles-msg">Su busqueda no ha arrojado resultados</p>
			<?php endif; ?>
		</div>
	</div>

<?php get_footer(); ?>
