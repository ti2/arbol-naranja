<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<img id="seartoggle" src="<?php bloginfo('template_directory'); ?>/img/instagram.png" />
    <span id="searchfields">
        <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
        <input type="submit" id="searchsubmit" value="Buscar" />
    </span>
</form>
