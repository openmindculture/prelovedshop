<?php
/**
 * @package twentytwentythree-child
 * @author openmindculture
 */

add_action( 'wp_enqueue_scripts', 'my_child_enqueue_styles' );
function my_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

/*
 * Registering your colors
 * In your theme’s functions.php, add support for the custom color palette by specifying the following for each color option:
 *
 * Name: visible to user
 * Slug: used in CSS class
 * Color: used for rendering elements in the Gutenberg block editor
 */

add_theme_support( 'editor-color-palette', array(
	array(
		'name'  => __( 'Blue', 'ea_genesis_child' ),
		'slug'  => 'blue',
		'color'	=> '#59BACC',
	),
	array(
		'name'  => __( 'Green', 'ea_genesis_child' ),
		'slug'  => 'green',
		'color' => '#58AD69',
	),
	array(
		'name'  => __( 'Orange', 'ea_genesis_child' ),
		'slug'  => 'orange',
		'color' => '#FFBC49',
	),
	array(
		'name'	=> __( 'Red', 'ea_genesis_child' ),
		'slug'	=> 'red',
		'color'	=> '#E2574C',
	),
) );