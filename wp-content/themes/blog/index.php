<?php get_header(); ?>

<main id="main" role="main">
	<?php putRevSlider('slider1') ?>
</main>

<div id="articles">
	<div class="main-block">
		<?php
			$welcome = kc_get_option( 'nso', 'home_top_options', 'welcome' );
			echo wpautop($welcome);
		?>
	</div>

	<?php
	//para que no le ponga alto y ancho en el html
	add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
	function remove_width_attribute( $html ) {
		$html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
		return $html;
	}

	$categories = get_categories();
	foreach ( $categories as $category ):
	?>

		<div class="main-block">
			<h1 class="articles-title">
				<?php
				echo $category->name;
				?>
			</h1>
			<h2 class="cat-subtitle"><?php echo $category->description; ?></h2>

			<?php
			$args = array('cat' => $category->term_id, );
			global $cat_query;
			$cat_query = new WP_Query( $args );
			?>

			<div class="article-list">
				<?php if ( $cat_query->have_posts() ) : ?>

					<?php get_template_part('loop'); ?>

				<?php else : ?>
					<div class="gutter-sizer"></div>
					<p class="articles-msg">Su busqueda no ha arrojado resultados</p>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>

<?php get_footer(); ?>
