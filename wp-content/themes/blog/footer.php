	<footer id="footer" role="contentinfo">
		<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="ir big-logo"><?php bloginfo( 'name' ); ?></a></h1>

		<?php
		$contact_info = kc_get_option( 'nso', 'home_options', 'contact_info' );
		echo wpautop($contact_info);
		?>

		<?php wp_nav_menu( array('theme_location' => 'footer', 'container_class' => 'menu-footer' )); ?>
		<?php wp_nav_menu( array('theme_location' => 'social', 'container_class' => 'menu-social' )); ?>
	</footer>

<?php wp_footer(); ?>
</body>
</html>
