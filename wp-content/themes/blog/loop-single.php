<?php while ( have_posts() ) : the_post(); ?>
	<article id="main-post-<?php the_ID(); ?>" <?php post_class('main-post'); ?>>
		<div id="post-media">
		<?php
		if ( has_post_format( 'video' )) {
			$video_url = get_post_meta( $post->ID, '_video_url', true );
			echo '<div id="video-wrapper">';
			echo wp_oembed_get($video_url, array('width'=>970, 'height'=>546));
			echo '</div>';
		} elseif ( has_post_format( 'image' )) {
			$large_img = MultiPostThumbnails::get_post_thumbnail_url('post', 'static-image', null, 'large');
			$mobile_img = MultiPostThumbnails::get_post_thumbnail_url('post', 'static-image', null, 'mobile-first');
			echo '<span data-fullsrc="'.$large_img.'" data-src="'.$mobile_img.'" class="responsivize">';
			echo '<noscript><img src="'.$mobile_img.'" /></noscript>';
			echo '</span>';
		}
		?>
		</div>

		<header>
			<h1><?php the_title(); ?></h1>
			<h3><?php the_tags( '', ' - ' ); ?></h3>
		</header>

		<div class="post-content">
			<?php the_content(); ?>
		</div>
	</article>
<?php endwhile; ?>
