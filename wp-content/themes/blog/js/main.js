(function($) {
	/* PACKERY */
	var $container = $('.article-list');
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
			//display menu on first scroll
			if ($(this).scrollTop() > 0 && $nav.is(':hidden') && window_width > 700) {
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
	$('.article-list .post').hover(toggleImg, toggleImg);

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
				$('#s').focus();
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
		if (window_width <= 700) {
			$('#main-nav, .menu-social').toggleClass('left');
		}
	}

	var resetMenu = function()
	{
		var $nav = $('#main-nav');

		if (window_width <= 700) {
			$nav.addClass('left');
			$('.menu-social').addClass('left');
		}
	}

	var adjustMenu = function()
	{
		window_width = $(window).width();
		if ( ! $('#main-nav').hasClass('left') || ! $('#main-nav').is(':hidden') ) {
			resetMenu();
		}
	}

	var scrollPage = function(position) {
		if (position == 'top') {
			var offset = $('#main').offset().top - $('#main-nav').height();
		} else if (position == 'articles') {
			var offset = $('#articles').offset().top - $('#main-nav').height();
		}

		$('html, body').animate({scrollTop: offset}, 'slow');
	}

	//RESPONSIVE
	var loadLargeImgs = function(window_width) {
		var useFull = ( window_width > 532 );
		$(".responsivize").each(function(){
			var me = $(this);
			var data = me.data();
			if ( useFull ) {
				data.src = data.fullsrc;
			}
			delete data.fullsrc;
			$("<img />", data).insertBefore(me);
			me.remove();
		});
	}

	var window_width = $(window).width();
	loadLargeImgs(window_width);
	stickyNav();
	resetMenu();

	$('.go-to-top').click(function(){
		scrollPage('top');
	});

	$(window).resize(adjustMenu);
	$('.menu-toggle').click(toggleMenu);
	$('#main-nav a').click(function() {
		if (window_width <= 700) {
			toggleMenu();
		}
	});

	//after fonts and images are loaded
	$(window).load(function() {
		hideSearch();
		$('#searchtoggle').click(toggleSearch);
	});

	//footer collapse
	$('#footer').addClass('collapsed');
	$('.footer-block h4').click(function() {
		$('#footer').toggleClass('collapsed');
		$("html, body").animate({ scrollTop: $(document).height()-$(window).height() }, 'slow');
	});

})(jQuery);
