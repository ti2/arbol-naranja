(function($) {
	var scrollPage = function(position) {
		if (position == 'top') {
			var offset = $('#main').offset().top - $('#main-nav').height();
		} else if (position == 'articles') {
			var offset = $('#articles').offset().top - $('#main-nav').height();
		}

		$('html, body').animate({scrollTop: offset}, 'slow');
	}

	//RESPONSIVE
	var loadLargeImgs = function() {
		window_width = $(window).width();
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

	$('.go-to-top').click(function(){
		scrollPage('top');
	});
	loadLargeImgs();

})(jQuery);
