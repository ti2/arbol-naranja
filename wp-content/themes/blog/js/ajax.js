(function($) {
	var next_page = 2;

	var addPosts = function(posts) {
		$posts = $(posts).filter('article');
		$('#article-list').append($posts).packery('appended', $posts.get());

		next_page++;
		var new_total = $('#article-list .post').length;

		if ( new_total >= $('#load-more').attr('data-total') ) {
			$('#load-more').fadeOut();
		}
	}

	var ajaxRequest = function ajaxRequest() {
		$.ajax({
			type: "POST",
			url: "http://arbolnaranja.blog/wp-admin/admin-ajax.php",
			data: { action: 'load_posts', page: next_page, taxquery: $('#load-more').attr('data-taxquery') }
		}).done(addPosts);
	}

	$('#load-more').click(ajaxRequest);

})(jQuery);
