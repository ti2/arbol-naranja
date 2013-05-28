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
