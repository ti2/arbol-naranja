<?php
if ( ! isset( $content_width ) ) $content_width = 830;
function embed_responsively($iframe) {
	return '<div class="embed-container">'.$iframe.'</div>';
}
add_filter('oembed_result', 'embed_responsively');

function arbol_setup() {
	add_theme_support( 'custom-background' );

	add_theme_support( 'post-formats', array( 'image', 'video', 'gallery' ) );

	add_theme_support( 'post-thumbnails' );
	//margin between images: 20px;
	set_post_thumbnail_size( 145, 145, true );
	add_image_size( 'full-thumb', 970, 370, true );
	add_image_size( 'wide-thumb', 640, 310, true );
	add_image_size( 'big-thumb', 310, 310, true );
	add_image_size( 'huge', 1280, 960 );

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
		new MultiPostThumbnails(
			array(
				'label' => 'Imagen Grande',
				'id' => 'static-image',
				'post_type' => 'team'
			)
		);
		new MultiPostThumbnails(
			array(
				'label' => 'Imagen Grande',
				'id' => 'static-image',
				'post_type' => 'caso'
			)
		);
		new MultiPostThumbnails(
			array(
				'label' => 'Imagen Grande',
				'id' => 'static-image',
				'post_type' => 'record'
			)
		);
	}

	register_nav_menus( array(
		'footer' => 'Menú para la parte inferior del sitio',
		'social' => 'Enlaces a redes sociales',
		'main' => 'Menú principal'
	) );
}
add_action( 'after_setup_theme', 'arbol_setup' );

/**
 * widgets
 */
function create_widgets_areas() {
	//Header
	register_sidebar( array(
		'name' => 'Widgets footer',
		'id' => 'footer-widget-area',
		'description' => 'Widgets para el footer (formularios)',
		'before_widget' => '<div class="footer-widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="footer-widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'create_widgets_areas' );

/**
 * Custom post types
 */
function arbol_custom_post_types() {
	$args = array(
		'public' => true,
		'label' => 'Miembros del Equipo',
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'post-formats'),
		'hierarchical' => true
	);
	register_post_type('team', $args);

	$args = array(
		'public' => true,
		'label' => 'Casos de Éxito',
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'post-formats'),
		'hierarchical' => true
	);
	register_post_type('caso', $args);

	$args = array(
		'public' => true,
		'label' => 'Discos',
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'post-formats'),
		'hierarchical' => true
	);
	register_post_type('record', $args);
}

add_action('init', 'arbol_custom_post_types');

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
					),
					array(
						'id'      => 'slider_alias',
						'title'   => 'Slider Alias',
						'desc'    => '',
						'type'    => 'text',
						'default' => ''
					),
					array(
						'id'      => 'hide_in_home',
						'title'   => 'Hide in Home',
						'type'    => 'checkbox',
						'options' => array(
							'checkbox_home' => 'Hide'
						),
						'default'	=> 'checkbox_home'
					)
				)
			)
		),
		'caso' => array(
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
		array(
			'id'     => 'home_top_options',
			'title'  => 'Contenido Home',
			'fields' => array(
				array(
					'id'      => 'welcome',
					'title'   => 'Texto de bienvenida',
					'type'    => 'editor'
				),
				array(
					'id'      => 'clients',
					'title'   => 'Nuestros Clientes',
					'type'    => 'editor'
				)
			)
		),
		array(
			'id'     => 'wrapper_background',
			'title'  => 'Fondo contenedor',
			'fields' => array(
				array(
					'id'    => 'wrapper_back_file',
					'title' => 'Imagen de fondo Contenedor',
					'type'  => 'file', // Not supported in theme customizer
					'mode'  => 'single',
					'size'  => 'full'
				),
				array(
					'id'      => 'wrapper_back_color',
					'title'   => 'Color de fondo Contenedor',
					'type'    => 'color',
					'default' => '#ededed',
					'desc'    => 'Format: <code>#ededed</code>'
				)
			)
		)
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

//para poder redirigir al PRIMERO y no al ultimo de la categoria
function category_loop_order( $query ) {
	if ( $query->is_category() && $query->is_main_query() ) {
		$query->set( 'order', 'DESC' );
	}
}
add_action( 'pre_get_posts', 'category_loop_order' );

//shortcode para franja de compartir
function social_share_shortcode( $atts ) {
	return file_get_contents(locate_template('social.php'));
}
add_shortcode('social_share', 'social_share_shortcode');

//shortcode para archivo de equipo
function team_shortcode( $atts ) {
	ob_start();
	get_template_part('loop', 'team');
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('team_gallery', 'team_shortcode');

//shortcode para archivo de casos de éxito
function caso_shortcode( $atts ) {
	ob_start();
	get_template_part('loop', 'caso');
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('casos_exito', 'caso_shortcode');

//shortcode para archivo de discos
function record_shortcode( $atts ) {
	ob_start();
	get_template_part('loop', 'record');
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('records_gallery', 'record_shortcode');
