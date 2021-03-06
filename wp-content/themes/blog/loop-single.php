<?php while ( have_posts() ) : the_post(); ?>
	<?php
	if ( has_post_format( 'image' )) {
		$large_img = MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'static-image', null, 'huge');
		$mobile_img = MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'static-image', null, 'mobile-first');
		echo '<div class="full-image">';
		echo '<span data-fullsrc="'.$large_img.'" data-src="'.$mobile_img.'" class="responsivize">';
		echo '<noscript><img src="'.$mobile_img.'" /></noscript>';
		echo '</span></div>';
	} elseif ( has_post_format('gallery') ) {
		$slider_alias = get_post_meta( $post->ID, '_slider_alias', true );
		echo do_shortcode('[rev_slider '.$slider_alias.']');
	}
	?>

	<article id="main-post-<?php the_ID(); ?>" <?php post_class('main-post'); ?>>
		<div id="post-media">
		<?php
		if ( has_post_format( 'video' )) {
			$video_url = get_post_meta( $post->ID, '_video_url', true );
			echo wp_oembed_get($video_url, array('width'=>970, 'height'=>546));
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
