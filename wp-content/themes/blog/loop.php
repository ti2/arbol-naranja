<?php
global $cat_query;
?>
<span class="hidden" id="total-posts"><?php echo $cat_query->found_posts; ?></span>
<?php if (is_archive()) { ?>
	<span class="hidden" id="initial-cat"><?php echo get_query_var('cat'); ?></span>
<?php } ?>
<div class="gutter-sizer"></div>

<?php while ( $cat_query->have_posts() ) : $cat_query->the_post(); ?>

	<?php
	$sizes = get_the_terms( $post->ID, 'size' );
	if ($sizes == false) {
		$size_class = 'size-pequeno';
	} else {
		$first_size = reset($sizes);
		$size_class = 'size-'.$first_size->slug;
	}
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post '.$size_class); ?>>
		<a href="<?php the_permalink(); ?>">
			<?php
			if ($first_size->slug == 'completo') {
				$thumb_size = 'full-thumb';
			}elseif ($first_size->slug == 'ancho') {
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

<?php
endwhile;

/* Restore original Post Data */
wp_reset_postdata();
?>
