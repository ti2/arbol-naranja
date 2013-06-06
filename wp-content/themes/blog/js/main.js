(function($) {
	/* PACKERY */
	var $container = $('#article-list');
	// initialize
	$container.packery({
		itemSelector: 'article',
		gutter: '.gutter-sizer'
	});

	/* STICKY TOP MENU */
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

	/* THUMB IMG HOVER */
	var toggleImg = function()
	{
		var $images = $(this).find('img');
		if ($images.length > 1) {
			var $hidden_img = $images.filter('.hidden');
			var $visible_img = $hidden_img.siblings('img');
			/*$hidden_img.removeClass('hidden');
			$hidden_img.siblings('img').addClass('hidden');*/
			var new_src = $hidden_img.attr('src');
			$hidden_img.attr('src', $visible_img.attr('src'));
			$visible_img.attr('src', new_src);
		}
	}
	$('#article-list .post').hover(toggleImg, toggleImg);

	/* SEARCH FIELD HORIZONTAL SLIDE */
	var search_width;
	var hideSearch = function()
	{
		search_width = $('#searchfields').width();
		$('#searchfields').hide().width(0);
	}

	var toggleSearch = function ()
	{
		if ($('#searchfields').width() == 0) {
			$('#searchfields').show().animate({width: search_width}, function() {
				$(this).width('');
			});
		} else {
			$('#searchfields').animate({width: 0}, function() {
				$(this).hide();
			});
		}
	}

	//after fonts and images are loaded
	$(window).load(function() {
		stickyNav();
		hideSearch();
		$('#seartoggle').click(toggleSearch);
	});

})(jQuery);
