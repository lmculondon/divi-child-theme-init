<?php
/* 
SCRIPTS AND STYLES 
*/ 



//Divi Parent Styles
function theme_enqueue_styles() {
	wp_enqueue_style( 'divi', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'lmcu-style', get_stylesheet_directory_uri() . '/css/style.css', array());
    wp_enqueue_script( 'lmcu-custom', get_stylesheet_directory_uri() . '/js/scripts.min.js', array( 'jquery', 'divi-custom-script' ), true );
	}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function remove_divi_customizer_styles() {
    remove_action( 'wp', 'et_divi_add_customizer_css' );
}
add_action( 'wp', 'remove_divi_customizer_styles', 999 ); 

//TrustPilot
function trustpilot_enqueue_scripts() {
	wp_enqueue_script( 'trustpilot', '//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js', array(),false, true);
}
add_action('wp_enqueue_scripts', 'trustpilot_enqueue_scripts');

/*
WP CLEANUP
*/
function dequeue_redundant_styles() {
    wp_deregister_style( 'dlm-frontend' );
};
add_action( 'wp_print_styles', 'dequeue_redundant_styles', 9999 );	

/**
 * Disable the emoji's
 */
function disable_emojis() {
 remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
 remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
 remove_action( 'wp_print_styles', 'print_emoji_styles' );
 remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
 remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
 remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
 remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
 add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
 add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

function disable_emojis_tinymce( $plugins ) {
 if ( is_array( $plugins ) ) {
 return array_diff( $plugins, array( 'wpemoji' ) );
 } else {
 return array();
 }
}

function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
 if ( 'dns-prefetch' == $relation_type ) {
 /** This filter is documented in wp-includes/formatting.php */
 $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

$urls = array_diff( $urls, array( $emoji_svg_url ) );
 }

return $urls;
}
// Remove dashicons in frontend for unauthenticated users
add_action( 'wp_enqueue_scripts', 'bs_dequeue_dashicons' );
function bs_dequeue_dashicons() {
    if ( ! is_user_logged_in() ) {
        wp_deregister_style( 'dashicons' );
    }
}
// Year shortcode for footer
function year_shortcode () {
$year = date_i18n ('Y');
return $year;
}
add_shortcode ('year', 'year_shortcode');

//Divi adjustments

//hide - not removing - the internal prohect post type.
//By hidign it we prevent any problems as this CPT is deep integrated in divi
add_filter('et_project_posttype_args', 'mytheme_et_project_posttype_args', 10, 1);
function mytheme_et_project_posttype_args($args) {
  return array_merge($args, array(
    'public'              => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => false,
        'show_in_nav_menus'   => false,
        'show_ui'             => false
  ));
}