
		<div class="main-block">
			<h1>Información & Contacto.</h1>
			<?php
			$contact_info = kc_get_option( 'nso', 'home_options', 'contact_info' );
			echo wpautop($contact_info);
			?>

			<?php dynamic_sidebar( 'footer-widget-area' ); ?>
		</div>

	</div><!-- #articles -->

	<footer id="footer" role="contentinfo">
		<div id="footer-logos" class="footer-block">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="ir footer-logo"><?php bloginfo( 'name' ); ?></a>
			<a href="http://zumomag.com/"><img class="logo-zumo" src="<?php bloginfo('template_directory'); ?>/img/zumologogrande.png" /></a>
			<a href="http://notastupidoutfit.com/"><img class="logo-nota" src="<?php bloginfo('template_directory'); ?>/img/noatstupidlogogrande.png" /></a>
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


<script type="text/javascript">

  /*var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39405153-1']);
  _gaq.push(['_setDomainName', 'arbolnaranja.com']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();*/

</script>
</body>
</html>
