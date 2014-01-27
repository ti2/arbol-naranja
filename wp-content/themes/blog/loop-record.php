<div class="team-archive">
<?php
$args = array(
	'post_type' => 'record',
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC'
);
$team_query = new WP_Query( $args );

while ( $team_query->have_posts() ) : $team_query->the_post();
?>

	<span class="team-member">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail('big-thumb'); ?>
			<h2><?php the_title(); ?></h2>
			<?php the_excerpt(); ?>
		</a>
	</span>

<?php
endwhile;

/* Restore original Post Data */
wp_reset_postdata();
?>
</div>
