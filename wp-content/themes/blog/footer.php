	<footer id="footer" role="contentinfo">
		<div class="footer-block">
			<h4>Contacto</h4>
			<?php
			$contact_info = kc_get_option( 'nso', 'home_options', 'contact_info' );
			echo wpautop($contact_info);
			?>
		</div>

		<?php dynamic_sidebar( 'footer-widget-area' ); ?>

		<div id="footer-logos" class="footer-block">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="ir footer-logo"><?php bloginfo( 'name' ); ?></a>
			<a href=""><img src="<?php bloginfo('template_directory'); ?>/img/casalogo.png" /></a>
			<a href=""><img src="<?php bloginfo('template_directory'); ?>/img/notlogo.png" /></a>
		</div>
	</footer>

</div>
<?php wp_footer(); ?>

<div id="fb-root"></div><!-- fb needs this -->
<script>(function(d, s) {
  var js, fjs = d.getElementsByTagName(s)[0], load = function(url, id) {
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.src = url; js.id = id;
    fjs.parentNode.insertBefore(js, fjs);
  };
  load('//connect.facebook.net/es_LA/all.js#xfbml=1', 'fbjssdk');
}(document, 'script'));</script>
</body>
</html>
