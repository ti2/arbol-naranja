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

	var toggleImg = function()
	{
		var $images = $(this).find('img');
		if ($images.length > 1) {
			var $hidden_img = $images.filter('.hidden');
			$hidden_img.removeClass('hidden');
			$hidden_img.siblings('img').addClass('hidden');
		}
	}
	$('#article-list .post').hover(toggleImg, toggleImg);

})(jQuery);
