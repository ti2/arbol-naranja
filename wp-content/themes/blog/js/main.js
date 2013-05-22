(function($) {
	var $container = $('#article-list');
	// initialize
	$container.packery({
		itemSelector: 'article',
		gutter: 20
	});

	var stickyNav = function()
	{
		var $nav = $('#main-nav');
		var offset = $nav.offset().top;

		$(window).scroll(function () {
	        if ($(this).scrollTop() > offset) {
	            $nav.addClass("fixed-nav");
	        } else {
	            $nav.removeClass("fixed-nav");
	        }
	    });
	}
	stickyNav();

})(jQuery);
