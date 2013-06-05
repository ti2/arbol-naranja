(function($) {
	var addPosts = function(html) {
		var $posts = $(html).filter('article');

		if ($posts.length > 0) {
			$('#article-list').append($posts).packery('appended', $posts.get());
		}

		var total = parseInt( $(html).filter('#total-posts').text() );
		var toggle_load_button = ($posts.length < total) ? 'show' : 'hide';
		toggleLoadButton(toggle_load_button);
	}

	var toggleLoadButton = function(toggle) {
		if ( toggle == 'hide' ) {
			$('#load-more').fadeOut().addClass('hidden');
		} else {
			$('#load-more').removeClass('hidden').fadeIn();
		}
	}

	var getPostsIds = function() {
		var ids = [];
		$('#article-list .post').each(function( index ) {
			var post_html_id = $(this).attr('id');
			var post_id = post_html_id.substr(post_html_id.lastIndexOf('-')+1);
			ids.push(post_id);
		});
		return ids;
	}

	var ajaxRequest = function() {
		var req_data = {
			action: 'load_posts',
			term_id : $('#load-more').attr('data-queryterm'),
			taxonomy : $('#load-more').attr('data-querytax'),
			exclude: getPostsIds()
		};

		$.ajax({
			type: "POST",
			url: "http://arbolnaranja.blog/wp-admin/admin-ajax.php",
			data: req_data
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
			var offset = $('#articles').offset().top - $('#main-nav').height();
		}

		$('html, body').animate({scrollTop: offset}, 'slow');
	}

	var changeLoadButton = function(term_id, taxonomy) {
		$('#load-more').attr('data-queryterm', term_id);
		$('#load-more').attr('data-querytax', taxonomy);
	}

	var filterCats = function(event) {
		event.preventDefault();

		//get cat id
		var link_classes = $(this).attr('class');
		var cat_id = link_classes.substr(link_classes.lastIndexOf('-')+1);

		$('#articles-title').text($(this).text());

		var $posts_in_cat = $('#article-list .cat-'+cat_id);

		changeLoadButton(cat_id, 'category');

		//if there's at least one post in the category, show it
		//if there's nothing, load more
		if ($posts_in_cat.length > 0) {
			packery_unignore( $posts_in_cat );
			toggleLoadButton('show');
		} else {
			ajaxRequest();
		}

		//hide posts not in category
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
