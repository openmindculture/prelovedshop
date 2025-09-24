<?php
add_action('after_setup_theme', function () {
  remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
  remove_action('in_admin_header', 'wp_global_styles_render_svg_filters');
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_action('wp_head', 'wp_generator');
  remove_action ('wp_head', 'rsd_link');
  remove_action( 'wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'feed_links_extra', 3 );
  add_theme_support('disable-custom-font-sizes');
  add_theme_support('disable-custom-gradients');
}, 10, 0);

// remove category slug from single post urls e.g. /category/blog/foo => /blog/foo
add_filter( 'get_the_archive_title_prefix', '__return_false' );

add_action( 'wp_print_styles', function() {
  wp_styles()->add_data( 'akismet-widget-style', 'after', '' );
});

/**
 * @param string[] $classes
 * @return string[]
 */
function custom_body_class($classes) {
  $classes[] = 'theme-custom';
  if (get_post_field('post_name', get_post()) == 'kontakt') {
    $classes[] = 'page-kontakt';
  } else if (get_post_field('post_name', get_post()) == 'impressum') {
      $classes[] = 'page-impressum';
  } else if (get_post_field('post_name', get_post()) == 'datenschutz') {
      $classes[] = 'page-datenschutz';
  }
  if (in_category('referenzen') && is_singular(array('post'))) {
    $classes[] = 'in-category-referenzen';
  }
  if (in_category('blog') && is_singular(array('post'))) {
    $classes[] = 'in-category-blog';
  }
  return $classes;
}

add_filter('body_class', 'custom_body_class');

function custom_get_option_or_default($option_key, $default_value) {
  $value = get_theme_mod($option_key);
  if (!$value || empty($value)) {
    $value = get_option($option_key);
  }
  if (!empty($value)) {
    return $value;
  }
  return $default_value;
}
