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

	var ajaxRequest = function() {
		$.ajax({
			type: "POST",
			url: "http://arbolnaranja.blog/wp-admin/admin-ajax.php",
			data: { action: 'load_posts', page: next_page, taxquery: $('#load-more').attr('data-taxquery') }
		}).done(addPosts);
	}

	//toca asi, porque estas funciones solo elementan elementos sencillos
	var packery_ignore = function($elems) {
		$elems.each(function( index ) {
			$('#article-list').packery('ignore', $(this).get(0));
		});
		$elems.addClass('hidden');
	}
	var packery_unignore = function($elems) {
		$elems.each(function( index ) {
			$('#article-list').packery('unignore', $(this).get(0));
		});
		$elems.removeClass('hidden');
	}

	var scrollPage = function(position) {
		if (position == 'top') {
			var offset = $('#main').offset().top - $('#main-nav').height();
		} else if (position == 'articles') {
			var offset = $('#articles').offset().top
		}

		$('html, body').animate({scrollTop: offset}, 'slow');
	}

	var filterCats = function(event) {
		event.preventDefault();

		var link_classes = $(this).attr('class');
		var cat_id = link_classes.substr(link_classes.lastIndexOf('-')+1);
		console.log(cat_id);

		$('#articles-title').text($(this).text());

		var $posts_in_cat = $('#article-list .cat-'+cat_id);

		packery_unignore( $posts_in_cat );
		packery_ignore( $('#article-list .post').not('.cat-'+cat_id) );
		$('#article-list').packery('layout');

		scrollPage('articles');
	}

	var addSingle = function(post) {
		$('#main').html(post);
	}

	var requestPost = function(event) {
		event.preventDefault();

		var post_id = $(this).attr('id');
		$.ajax({
			type: "POST",
			url: "http://arbolnaranja.blog/wp-admin/admin-ajax.php",
			data: { action: 'get_single', id: post_id }
		}).done(addSingle);

		scrollPage('top');
	}

	$('#load-more').click(ajaxRequest);
	$('.cat-item').click(filterCats);
	$('#article-list').on('click', '.post', requestPost);

})(jQuery);
