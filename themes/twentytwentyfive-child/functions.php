<?php
/**
 * @package twentytwentyfive-child
 * @author openmindculture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once( get_template_directory() . '/inc/functions/customize-frontend.php' );

add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'twentytwentyfive-child-style', get_stylesheet_uri() );
} );

if (is_admin()) {
    require_once( get_template_directory() . '/inc/functions/customize-backend.php' );
}