<?php
/*
Plugin Name: Mobile First Responsive Images
Description: Serve up smaller images to smaller screens.
Version: 0.1.1
Author: Matt Wiebe
Author URI: http://somadesign.ca/
*/

/**
 * The smaller image is wrapped in a <noscript> tag so 1) it'll show up on non-JS browsers
 * and 2) it won't be partially downloaded on desktop browsers.
 *
 * JS-enabled browsers will sniff the breakpoint for which size of image to sub in
 * Be sure to regenerate thumbnails after starting to use
 * or nothing will happen.
 * @link http://wordpress.org/extend/plugins/regenerate-thumbnails/
 *
 * Won't work very well inside [caption] shortcodes
 * <noscript> concept: @link http://somad.es/5D
 */

class SD_Resonsive_Images {

	function init() {
		// the small image max size
		// define it in your functions.php or wp-config.php to override
		if ( ! defined( 'MOBILE_FIRST_IMG_SIZE') ) {
			define( 'MOBILE_FIRST_IMG_SIZE', 320 );
		}
		// our image size
		add_image_size( 'mobile-first', MOBILE_FIRST_IMG_SIZE, 9999 );
		// where the magic happens
		add_filter( 'the_content', array( __CLASS__, 'responsive_images' ) );
	}

	function responsive_images($content) {
		$regex = '/<img .* wp-image-[0-9]{1,10}.* \/?>/';
		return preg_replace_callback( $regex, array( __CLASS__, 'make_responsive_image' ), $content );
	}

	function make_responsive_image($image) {
		if ( is_array($image) ) {
			$image = array_shift($image);
		}
		preg_match('/wp-image-([0-9]{1,10})/', $image, $matches );
		if ( ! $matches || count($matches) < 2 ) {
			return $image;
		}
		$attachment = get_post($matches[1]);
		if ( ! $attachment || 'attachment' !== $attachment->post_type ) {
			return $image;
		}
		$small = wp_get_attachment_image_src( $attachment->ID, 'mobile-first' );
		$small_url = $small[0];

		// if it's the same as fullsize, this is useless
		if ( $attachment->guid === $small_url ) {
			return $image;
		}

		// if it's the same image, just return it
		if ( false !== strpos($image, $small_url) ) {
			return $image;
		}

		// let's array up the atts
		$new = str_replace(array( '<img ', ' />', ' >' ), '', $image );
		$parts = preg_split( '/[\'"] /', $new );
		$atts = array();
		foreach ( $parts as $part ) {
			$part = explode('=', $part);
			$atts[ $part[0] ] = trim($part[1], '\'" ');
		}

		// No width/height for mobile first responsive
		if ( isset($atts['width']) ) {
			// let's not bother if it's already small-ish
			if ( $atts['width'] <= MOBILE_FIRST_IMG_SIZE ) {
				return $image;
			}
			unset($atts['width']);
		}
		if ( isset($atts['height']) ) unset($atts['height']);
		// I think title attributes on images suck. Goodbye
		if ( isset($atts['title']) ) unset($atts['title']);

		// move old src to data attribute, make small src default
		$atts['fullsrc'] = $atts['src'];
		$atts['src'] = $small_url;

		// put it back together
		$return = $img_atts = $wrapper_atts = '';

		foreach ( $atts as $att => $val ) {
			if ( 'fullsrc' !== $att )
				$img_atts .= $att . '="' . $val . '" ';
			$wrapper_atts .= 'data-' . $att . '="' . $val . '" ';
		}
		$return = "<img {$img_atts}/>";
		// we need to wrap in a span to prevent some occasionally janky behaviour
		// I'm looking at you, iOS
		$return = "<span class=\"responsivize\" {$wrapper_atts}><noscript>{$return}</noscript></span>";
		return $return;
	}
}

add_action( 'init', array( 'SD_Resonsive_Images', 'init') );
