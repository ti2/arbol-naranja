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
		$nav.hide();

		$(window).scroll(function () {
			//display menu on first scroll
			if ($(this).scrollTop() > 0 && $('#main-nav').is(':hidden')) {
				$('#main-nav').slideDown();
			}

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

	var toggleSearch = function()
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

	/* MENU TOGGLE */
	var toggleMenu = function()
	{
		$('#main-nav').slideToggle();
	}

	//after fonts and images are loaded
	$(window).load(function() {
		stickyNav();
		$('.menu-toggle').click(toggleMenu);

		hideSearch();
		$('#seartoggle').click(toggleSearch);
	});

})(jQuery);
