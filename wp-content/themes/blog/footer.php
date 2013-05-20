	<footer role="contentinfo">
		<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<p>
			Dirección: calle 60...<br />
			Bogotá, Cundinamarca...
		</p>
		<?php wp_nav_menu( array('theme_location' => 'footer' )); ?>
		<?php wp_nav_menu( array('theme_location' => 'social' )); ?>
	</footer>

<?php wp_footer(); ?>
</body>
</html>
