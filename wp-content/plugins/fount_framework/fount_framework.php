<?php
/*
Plugin Name: Fount Framework
Plugin URI: http://themeforest.net/user/Pirenko/portfolio/
Description: Plugin that creates custom post types and shortcodes to work with Fount WordPress Theme
Version: 4.5
Author: Pirenko
Author URI: http://www.pirenko.com/
License: GPLv2
*/
if( !defined('PLUGIN_PATH') ) {
	define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}
if( !defined('PLUGIN_URL') ) {
	define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}


include_once PLUGIN_PATH . '/shortcodes.php' ;
include_once PLUGIN_PATH . '/inc/modules/advanced-custom-fields/acf.php';

include_once PLUGIN_PATH . '/custom_post_types.php';
//include_once PLUGIN_PATH . '/js_composer-fount/js_composer-fount.php';
include_once PLUGIN_PATH . '/inc/theme_widgets/pirenko-twitter/pirenko-twitter.php';
include_once PLUGIN_PATH . '/inc/theme_widgets/pirenko-social-links/social.php';
include_once PLUGIN_PATH . '/inc/theme_widgets/pirenko-vcard/vcard.php';
include_once PLUGIN_PATH . '/inc/theme_widgets/pirenko-advertising/pirenko-ads.php';
include_once PLUGIN_PATH . '/inc/theme_widgets/pirenko-tags/tags.php';
include_once PLUGIN_PATH . '/inc/theme_widgets/pirenko-recent_portfolio/posts.php';
include_once PLUGIN_PATH . '/inc/theme_widgets/pirenko-recent_posts/posts.php';
include_once PLUGIN_PATH . '/inc/theme_widgets/pirenko-tags_portfolio/tags.php';
include_once PLUGIN_PATH . '/inc/theme_widgets/pirenko-video/pirenko-video.php';
include_once PLUGIN_PATH . '/inc/theme_widgets/decent-comments/decent-comments.php';
include_once PLUGIN_PATH . '/inc/modules/vt_resize.php';

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('js_composer/js_composer.php') || is_plugin_active('js_composer-410/js_composer.php') || is_plugin_active('js_composer-1111/js_composer.php')) {
	include_once PLUGIN_PATH . '/inc/builder.php';
}

add_action('acf/register_fields', 'my_register_fields');
function my_register_fields()
{
    include_once PLUGIN_PATH . '/inc/modules/acf-sidebar-selector-field/acf-sidebar_selector.php';
}

//CHECK IF FOUNT THEME IS ACTIVE
if (function_exists('wp_get_theme'))
	$active_theme = wp_get_theme();
else
{
	$active_theme->name="";
	$active_theme->Version="1";
}
if ('Fount' == $active_theme->name || 'Fount' == $active_theme->parent_theme) {
    
}
else {
	//THEME IS NOT ACTIVE. LET'S ADD SOME ELEMENTS
	add_action('admin_print_scripts', 'fount_framework_admin_scripts');
}

//ADD CUSTOM SCRIPTS FOR THE BACKEND
function fount_framework_admin_scripts() 
{
	global $active_theme;
	wp_register_style( 'fount_framework_admin_css', PLUGIN_URL . 'css/admin.css',false,$active_theme->Version );
	wp_enqueue_style('fount_framework_admin_css');
}
?>