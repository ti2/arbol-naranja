<?php
function arbol_setup() {
	add_theme_support( 'custom-background' );

	add_theme_support( 'post-formats', array( 'image', 'video' ) );

	add_theme_support( 'post-thumbnails' );
	//margin between images: 20px;
	set_post_thumbnail_size( 145, 145, true );
	add_image_size( 'wide-thumb', 640, 310, true );
	add_image_size( 'big-thumb', 310, 310, true );

	if (class_exists('MultiPostThumbnails')) {
		new MultiPostThumbnails(
			array(
				'label' => 'Segunda Imagen',
				'id' => 'secondary-image'
			)
		);
		new MultiPostThumbnails(
			array(
				'label' => 'Imagen Grande',
				'id' => 'static-image'
			)
		);
	}

	register_nav_menus( array(
		'footer' => 'Menú para la parte inferior del sitio',
		'social' => 'Enlaces a redes sociales'
	) );
}
add_action( 'after_setup_theme', 'arbol_setup' );

function create_taxonomies()
{
	register_taxonomy(
		'size',
		'post',
		array(
			'label' => 'Tamaño',
			'hierarchical' => true,
			'rewrite' => array(
				'manage_terms' => 'manage_options',
				'edit_terms' => 'manage_options',
				'delete_terms' => 'manage_options'
				)
			)
		);
}
add_action( 'init', 'create_taxonomies' );

//custom fields para los posts
function my_post_fields( $groups ) {

	$my_group = array(
		'post' => array(
			array(
				'id'     => 'custom_fields',
				'title'  => 'Info Adicional',
				'desc'   => '',
				/**
				 * Optional. Uncomment this to only display the metadata settings for
				 * certain user roles.
				 */
				// 'role'   => array( 'administrator', 'editor' ),
				'fields' => array(
					array(
						'id'      => 'video_url',
						'title'   => 'Youtube video url',
						'desc'    => '',
						'type'    => 'text',
						'default' => ''
					)
				)
			)
		)
	);

	$groups[] = $my_group;
	return $groups;
}
add_filter( 'kc_post_settings', 'my_post_fields' );

//opciones del tema, para el home page
function mytheme_options( $settings ) {
	$options = array(
		array(
			'id'     => 'home_options',
			'title'  => 'Contenido Footer',
			'fields' => array(
				array(
					'id'      => 'contact_info',
					'title'   => 'Info de contacto',
					'type'    => 'editor'
				),
			)
		),
		// You can add more sections here...
	);

	$my_settings = array(
		'prefix'        => 'nso',    // Use only alphanumerics, dashes and underscores here!
		'menu_location' => 'themes.php',  // options-general.php | index.php | edit.php | upload.php | link-manager.php | edit-comments.php | themes.php | users.php | tools.php
		'menu_title'    => 'Opciones Generales',
		'page_title'    => 'Opciones Generales',
		'display'       => 'metabox',     // plain|metabox. If you chose to use metabox, don't forget to set their settings too
		'metabox'       => array(
			'context'   => 'normal',  // normal | advanced | side
			'priority'  => 'default', // default | high | low
		),
		'options'       => $options
	);

	$settings[] = $my_settings;
	return $settings;
}
add_filter( 'kc_plugin_settings', 'mytheme_options' );

//wmode para videos de youtube
function modify_youtube_embed_url($html, $url, $args) {
	return str_replace("?feature=oembed", "?feature=oembed&wmode=opaque", $html);
}
add_filter('oembed_result', 'modify_youtube_embed_url', 10, 3);

//agregar category ID al post class
function category_id_class($classes) {
	global $post;
	foreach(get_the_category($post->ID) as $category) {
		$classes[] = 'cat-'.$category->cat_ID;
	}
	return $classes;
}
add_filter('post_class', 'category_id_class');

//
function load_more_button() {
	global $wp_query;
	$total = $wp_query->found_posts;
	$posts_per_page = get_option('posts_per_page');

	$term = get_queried_object();
	if ( ! $term ) {
		$term_id = '';
		$taxonomy = '';
	} else {
		$term_id = $term->term_id;
		$taxonomy = $term->taxonomy;
	}

	$classes = 'hidden';
	if ($total > $posts_per_page) {
		$classes = '';
	}

	echo "<button id='load-more' class='$classes' data-querytax='$taxonomy' data-queryterm='$term_id'>Cargar más artículos</button>";
}

//AJAX
add_action('wp_ajax_load_posts', 'load_posts_callback');
add_action('wp_ajax_nopriv_load_posts', 'load_posts_callback');
function load_posts_callback() {
	$query_args = array('post__not_in' => $_POST['exclude']);

	if ($_POST['taxonomy']) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => $_POST['taxonomy'],
				'field' => 'id',
				'terms' => $_POST['term_id']
			)
		);
	}

	query_posts($query_args);
	get_template_part('loop');

	die(); // this is required to return a proper result
}

add_action('wp_ajax_get_single', 'get_single_callback');
add_action('wp_ajax_nopriv_get_single', 'get_single_callback');
function get_single_callback() {
	$post_id = $_POST['id'];
	$id = substr($post_id, 5);

	query_posts(array( 'p' => $id ));
	get_template_part('loop', 'single');

	die(); // this is required to return a proper result
}

