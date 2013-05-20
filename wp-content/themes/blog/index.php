<?php get_header(); ?>

<main role="main">
	<?php if ( function_exists( 'meteor_slideshow' ) ) { meteor_slideshow(); } ?>
</main>

<div id="articles">
	<h1>Últimos artículos</h1>
	<?php wp_nav_menu( array('theme_location' => 'social' )); ?>
	<?php get_search_form(); ?>

	<ul>
		<?php while ( have_posts() ) : the_post(); ?>
		<li>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<a href="<?php the_permalink(); ?>">
					<h1><?php the_title(); ?></h1>
					<?php the_post_thumbnail(); ?>
				</a>
			</article>
		</li>
		<?php endwhile; ?>

		<?php
		global $wp_query;
		$postsperpage = get_option('posts_per_page');
		if ($wp_query->found_posts > $postsperpage) {
			echo '<button>Cargar más artículos</button>';
		}
		?>
	</ul>
</div>

<?php get_footer(); ?>
