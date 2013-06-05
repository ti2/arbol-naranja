(function($) {
	var addPosts = function(html) {
		$posts = $(html).filter('article');

		if ($posts.length > 0) {
			$('#article-list').append($posts).packery('appended', $posts.get());

			updateOffset($posts.length);
		}

		toggleLoadButton(parseInt( $(html).filter('#total-posts').text() ));
	}

	var updateOffset = function(new_posts_total) {
		var offset = parseInt( $('#load-more').attr('data-offset') );
		var new_offset = offset + new_posts_total;
		$('#load-more').attr('data-offset', new_offset);
	}

	var toggleLoadButton = function(total) {
		//cuando se cambia de categoría, no se sabe cuanto es el total
		if (total == -1) {
			$('#load-more').removeClass('hidden').fadeIn();
			return;
		}

		var loaded = $('#article-list .post').not('.hidden').length;
		if ( loaded >= total ) {
			$('#load-more').fadeOut().addClass('hidden');
		} else {
			$('#load-more').removeClass('hidden').fadeIn();
		}
	}

	var ajaxRequest = function() {
		var req_data = {
			action: 'load_posts',
			offset : parseInt( $('#load-more').attr('data-offset') ),
			term_id : $('#load-more').attr('data-queryterm'),
			taxonomy : $('#load-more').attr('data-querytax')
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
			var offset = $('#articles').offset().top
		}

		$('html, body').animate({scrollTop: offset}, 'slow');
	}

	var changeLoadButton = function(offset, term_id, taxonomy) {
		$('#load-more').attr('data-offset', offset);
		$('#load-more').attr('data-queryterm', term_id);
		$('#load-more').attr('data-querytax', taxonomy);
	}

	var filterCats = function(event) {
		event.preventDefault();

		//get cat id
		var link_classes = $(this).attr('class');
		var cat_id = link_classes.substr(link_classes.lastIndexOf('-')+1);
		console.log(cat_id);

		$('#articles-title').text($(this).text());

		var $posts_in_cat = $('#article-list .cat-'+cat_id);

		changeLoadButton($posts_in_cat.length, cat_id, 'category');

		//if there's at least one post in the category, show it
		//if there's nothing, load more
		if ($posts_in_cat.length > 0) {
			packery_unignore( $posts_in_cat );
			toggleLoadButton(-1);
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
