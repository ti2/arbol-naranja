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
			single_cat_title();
		} else {
			echo 'Últimos artículos';
		}
		?>
	</h1>

	<?php get_search_form(); ?>
	<?php wp_nav_menu( array('theme_location' => 'social', 'container_class' => 'menu-social' )); ?>

	<div id="article-list">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php
			$sizes = get_the_terms( $post->ID, 'size' );
			if ($sizes == false) {
				$size_class = 'size-pequeno';
			} else {
				$first_size = reset($sizes);
				$size_class = 'size-'.$first_size->slug;
			}
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class($size_class); ?>>
			<a href="<?php the_permalink(); ?>">
				<h1 class="title-over-img"><?php the_title(); ?></h1>
				<?php
				if ($first_size->slug == 'ancho') {
					$thumb_size = 'wide-thumb';
				}elseif ($first_size->slug == 'grande') {
					$thumb_size = 'big-thumb';
				}else{
					$thumb_size = 'post-thumbnail';
				}
				the_post_thumbnail($thumb_size);
				MultiPostThumbnails::the_post_thumbnail('post', 'secondary-image', null, $thumb_size, array('class' => 'hidden'));
				?>
			</a>
		</article>

		<?php endwhile; ?>

		<?php
		global $wp_query;
		$postsperpage = get_option('posts_per_page');
		if ($wp_query->found_posts > $postsperpage) {
			echo '<button>Cargar más artículos</button>';
		}
		?>

		<?php else : ?>
			<?php echo 'Su busqueda no ha arrojado resultados'; ?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>
