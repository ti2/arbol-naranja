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
