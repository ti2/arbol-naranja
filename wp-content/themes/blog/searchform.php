<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<span id="searchtoggle">&#xe007;</span>
    <span id="searchfields">
        <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="buscar" />
    </span>
</form>
