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

		<?php get_template_part('loop'); ?>
	</div>

	<?php
	load_more_button();

	wp_reset_query();
	?>
</div>

<?php get_footer(); ?>
