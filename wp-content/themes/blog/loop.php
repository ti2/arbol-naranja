<?php while ( have_posts() ) : the_post(); ?>

	<?php
	$sizes = get_the_terms( $post->ID, 'size' );
	if ($sizes == 'false') {
		$size_class = 'size-pequeno';
	} else {
		$first_size = reset($sizes);
		$size_class = 'size-'.$first_size->slug;
	}
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post '.$size_class); ?>>
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