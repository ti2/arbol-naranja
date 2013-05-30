(function($) {
	var offset = parseInt( $('#load-more').attr('data-offset') );

	var addPosts = function(posts) {
		$posts = $(posts).filter('article');
		$('#article-list').append($posts).packery('appended', $posts.get());

		offset += $posts.length;
		var new_total = $('#article-list .post').length;

		if ( new_total >= $('#load-more').attr('data-total') ) {
			$('#load-more').fadeOut();
		}
	}

	var ajaxRequest = function ajaxRequest() {
		$.ajax({
			type: "POST",
			url: "http://arbolnaranja.blog/wp-admin/admin-ajax.php",
			data: { action: 'load_posts', offset: offset }
		}).done(addPosts);
	}

	$('#load-more').click(ajaxRequest);

})(jQuery);
