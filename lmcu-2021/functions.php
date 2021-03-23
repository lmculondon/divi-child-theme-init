<?php
/* 
SCRIPTS AND STYLES 
*/ 



//Divi Parent Styles
function theme_enqueue_styles() {
	//wp_enqueue_style( 'divi', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'lmcu-style', get_stylesheet_directory_uri() .'/css/style.css', array(), filemtime(get_stylesheet_directory() .'/css/style.css'));
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Montserrat:wght@400;600;700&display=swap', false );
   //wp_enqueue_script( 'lmcu-custom', get_stylesheet_directory_uri() . '/js/scripts.min.js', array( 'jquery', 'divi-custom-script' ), true );
	
	}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

//Preconnect Gfonts
function gfont_preload() {
	echo '<link rel="preconnect" href="https://fonts.gstatic.com">';				
}
add_action('wp_head', 'gfont_preload');

// Prevent default font load
function prevent_loading_fonts() {
	remove_action('wp_enqueue_scripts', 'et_divi_load_fonts');
}
add_action( 'init', 'prevent_loading_fonts', 20 );



//TrustPilot
function trustpilot_enqueue_scripts() {
	wp_enqueue_script( 'trustpilot', '//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js', array(),false, true);
}
add_action('wp_enqueue_scripts', 'trustpilot_enqueue_scripts');




/*
WP CLEANUP
*/
function dequeue_redundant_styles() {
    wp_dequeue_style( 'dlm-frontend' );
}
add_action( 'wp_enqueue_scripts', 'dequeue_redundant_styles', 999 );	

//Remove JQuery migrate
function remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        
        if ($script->deps) { // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array(
                'jquery-migrate'
            ));
        }
    }
}

//add_action('wp_default_scripts', 'remove_jquery_migrate');
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
