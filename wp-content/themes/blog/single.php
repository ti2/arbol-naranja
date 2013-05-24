<?php get_header(); ?>

<main id="main" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
	<article id="main-post-<?php the_ID(); ?>" <?php post_class('main-post'); ?>>
		<?php
		if ( has_post_format( 'video' )) {
			$video_url = get_post_meta( $post->ID, '_video_url', true );
			echo wp_oembed_get($video_url, array('width'=>970, 'height'=>546));
		}
		?>

		<header>
			<h1><?php the_title(); ?></h1>
			<h3><?php the_tags( '', ' - ' ); ?></h3>
		</header>

		<div class="post-content">
			<?php the_content(); ?>
		</div>
	</article>
	<?php endwhile; ?>
</main>

<div id="articles">
	<h1 id="articles-title">Últimos artículos</h1>

	<?php get_search_form(); ?>
	<?php wp_nav_menu( array('theme_location' => 'social', 'container_class' => 'menu-social' )); ?>

	<div id="article-list">
		<?php query_posts(''); ?>

		<?php while ( have_posts() ) : the_post(); ?>

		<?php
			$sizes = get_the_terms( $post->ID, 'size' );
			if ($sizes == 'false') {
				$size_class = 'size-pequeno';
			}else{
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

		wp_reset_query();
		?>
	</div>
</div>

<?php get_footer(); ?>
