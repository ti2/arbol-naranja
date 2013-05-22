(function($) {
	var $container = $('#article-list');
	// initialize
	$container.packery({
		itemSelector: 'article',
		gutter: 20
	});
})(jQuery);
