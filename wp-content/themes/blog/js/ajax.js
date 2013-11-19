(function($) {
	var addPosts = function(html) {
		var $posts = $(html).filter('article');

		if ($posts.length > 0) {
			$('.article-list').append($posts).packery('appended', $posts.get());
		}

		$('#load-more').text('Cargar más artículos');

		var total = parseInt( $(html).filter('#total-posts').text() );
		var toggle_load_button = ($posts.length < total) ? 'show' : 'hide';
		toggleLoadButton(toggle_load_button);
	}

	var toggleLoadButton = function(toggle) {
		if ( toggle == 'hide' ) {
			$('#load-more').fadeOut(function() {
				$(this).addClass('hidden');
			});
		} else {
			$('#load-more').removeClass('hidden').fadeIn();
		}
	}

	var getPostsIds = function() {
		var ids = [];
		$('.article-list .post').each(function( index ) {
			var post_html_id = $(this).attr('id');
			var post_id = post_html_id.substr(post_html_id.lastIndexOf('-')+1);
			ids.push(post_id);
		});
		return ids;
	}

	var ajaxRequest = function(req_data) {
		toggleLoadButton('show');
		$('#load-more').text('cargando...');
		$('.articles-msg').fadeOut();

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: req_data
		}).done(addPosts);
	}

	var loadMore= function() {
		var req_data = {
			action: 'load_posts',
			term_id: $('#load-more').attr('data-queryterm'),
			taxonomy: $('#load-more').attr('data-querytax'),
			exclude: getPostsIds()
		};

		ajaxRequest(req_data);
	}

	var changeTitle = function(prefix) {
		var title = 'Árbol Naranja';
		if (prefix) {
			title = prefix + ' | ' + title;
		}
		//$('title').text(title);
		document.title = title;
	}

	var doSearch = function(keywords) {

		var req_data = {
			action: 'load_posts',
			search: keywords
		};

		//remove all elements before search
		$('.article-list').packery('remove', $('.article-list .post').get());
		$('.article-list .post').remove();
		$('.article-list').packery('layout');

		$('.articles-title').text('Resultados para: '+keywords);

		ajaxRequest(req_data);

		changeTitle(keywords+' | Resultados de la búsqueda');
	}

	var searchSubmit = function(event) {
		event.preventDefault();

		var keywords = $('#s').val();

		var url = $(this).attr('action')+'?s='+keywords;
		history.pushState( {search: keywords, page: 'search'}, null, url );

		doSearch(keywords);
	}

	//toca asi, porque estas funciones solo elementan elementos sencillos
	var packery_ignore = function($elems) {
		$elems.each(function( index ) {
			$('.article-list').packery('ignore', $(this).get(0));
		});
		$elems.addClass('hidden');
	}
	var packery_unignore = function($elems) {
		$elems.each(function( index ) {
			$('.article-list').packery('unignore', $(this).get(0));
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

	var filterCats = function(cat_id, cat_title, scroll) {
		if (cat_id == '') {
			var $posts_in_cat = $('.article-list .post');
			changeTitle('');
		} else {
			var $posts_in_cat = $('.article-list .cat-'+cat_id);
			changeTitle(cat_title);
		}
		$('.articles-title').text(cat_title);
		changeLoadButton(cat_id, 'category');

		//if there's at least one post in the category, show it
		//if there's nothing, load more
		if ($posts_in_cat.length > 0) {
			packery_unignore( $posts_in_cat );
		} else {
			loadMore();
		}
		toggleLoadButton('show');

		//hide posts not in category
		if (cat_id != '') {
			packery_ignore( $('.article-list .post').not('.cat-'+cat_id) );
		}
		$('.article-list').packery('layout');

		if (scroll !== false) {
			scrollPage('articles');
		}
	}

	var changeCat = function(event) {
		event.preventDefault();

		//get cat id
		var link_classes = $(this).attr('class');
		var cat_id = link_classes.substr(link_classes.lastIndexOf('-')+1);
		var cat_title = $.trim( $(this).text() );

		history.pushState( {cat_id: cat_id, cat_title: cat_title, page: 'cat'}, null, $(this).children('a').attr('href') );

		filterCats(cat_id, cat_title);
	}

	var addSingle = function(post) {
		$('#main').html(post);
		loadLargeImgs();
	}

	var ajaxPost = function(post_id, title) {
		$.ajax({
			type: "POST",
			url: ajax_url,
			data: { action: 'get_single', id: post_id }
		}).done(addSingle);

		scrollPage('top');

		changeTitle(title);
	}

	var requestPost = function(event) {
		event.preventDefault();

		var post_id = $(this).attr('id');
		var post_title = $(this).find('.title-over-img').text();

		var cats = $(this).attr('class').match(/cat-\S*/g);
		var first_cat_id = cats[0].slice(4);
		var first_cat_title = $.trim( $('.cat-item-'+first_cat_id).text() );

		history.pushState( {post_id: post_id, post_title: post_title, cat_id: first_cat_id, cat_title: first_cat_title, page: 'post'}, null, $(this).children('a').attr('href') );

		filterCats(first_cat_id, first_cat_title, false);
		ajaxPost(post_id, post_title);
	}

	var addHistory = function() {
		var loc = window.location;

		if ($('body').hasClass('home')) {
			history.replaceState( {page: 'home'}, null, loc.href );
		} else if ($('body').hasClass('category')) {
			var cat_id = $('#initial-cat').text();
			var cat_title = $.trim( $('.articles-title').text() );
			history.replaceState( {cat_id: cat_id, cat_title: cat_title, page: 'cat'}, null, loc.href );
		} else if ($('body').hasClass('single')) {
			var html_id = $('#main article').attr('id');
			var post_id = html_id.substr(5);
			var post_title = $('#main article header h1').text();
			var cats = $('#main article').attr('class').match(/cat-\S*/g);
			var first_cat_id = cats[0].slice(4);
			var first_cat_title = $.trim( $('.cat-item-'+first_cat_id).text() );
			history.replaceState( {post_id: post_id, post_title: post_title, cat_id: first_cat_id, cat_title: first_cat_title, page: 'post'}, null, loc.href );
		} else if ($('body').hasClass('search')) {
			var keywords = loc.search.substr(3);
			history.replaceState( {search: keywords, page: 'search'}, null, loc.href );
		}
	}

	var popState = function(event) {
		var loc = history.location || document.location;
		var state = event.originalEvent.state;

		if (state.page == 'post') {
			if (typeof state.cat_id !== 'undefined') {
				filterCats(state.cat_id, state.cat_title, false);
			}
			ajaxPost(state.post_id, state.post_title);
		} else if (state.page == 'cat') {
			filterCats(state.cat_id, state.cat_title);
		} else if (state.page == 'search') {
			doSearch(state.search);
		} else if (state.page == 'home') {
			filterCats('', 'Últimos artículos');
		}
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

	$('#load-more').click(loadMore);
	$('#searchform').submit(searchSubmit);
	$('.cat-item').click(changeCat);
	$('.article-list').on('click', '.post', requestPost);
	addHistory();
	$(window).on('popstate', popState);
	loadLargeImgs();

})(jQuery);
