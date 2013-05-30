<?php
function arbol_setup() {
	add_theme_support( 'post-formats', array( 'video' ) );

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

//
function load_more_button() {
	global $wp_query;
	$total = $wp_query->found_posts;
	$posts_per_page = get_option('posts_per_page');
	$tax_query = serialize($wp_query->tax_query->queries);
	if ($total > $posts_per_page) {
		echo "<button id='load-more' data-offset='$posts_per_page' data-total='$total' data-taxquery='$tax_query'>Cargar más artículos</button>";
	}
	//print_r($wp_query);
}

//AJAX
add_action('wp_ajax_load_posts', 'load_posts_callback');
add_action('wp_ajax_nopriv_load_posts', 'load_posts_callback');
function load_posts_callback() {
	$offset = $_POST['offset'];
	$taxquery = unserialize( stripslashes($_POST['taxquery']) );
	query_posts(array( 'offset' => $offset, 'tax_query' => $taxquery ));
	get_template_part('loop');
	die(); // this is required to return a proper result
}
