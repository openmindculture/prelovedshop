<?php
/**
 * @package twentytwentythree-child
 * @author openmindculture
 */

add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'twentytwentythree-child-style', get_stylesheet_uri() );
} );