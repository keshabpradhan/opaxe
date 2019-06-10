<?php
/*
Plugin Name: Custom Post Type Attachment ( PDF )
Plugin URI: https://wordpress.org/plugins/custom-post-type-pdf-attachment/
Description: This plugin will allow you to upload pdf files to your post or pages or any other custom post types. You can either use shortcodes or functions to display attachments. You can upload at most 10 PDF files as attachments. :)
Version: 3.3.6
Text Domain: custom-post-type-pdf-attachment
Domain Path: /languages
Author: aviplugins.com
Author URI: https://www.aviplugins.com/
*/

/**
	  |||||   
	<(`0_0`)> 	
	()(afo)()
	  ()-()
**/

define( 'CPTA_PLUGIN_DIR', 'custom-post-type-pdf-attachment' );
define( 'CPTA_PLUGIN_PATH', dirname( __FILE__ ) );

function plug_install_custom_post_type_attachment(){
	include_once CPTA_PLUGIN_PATH . '/includes/class_form.php';
	include_once CPTA_PLUGIN_PATH . '/includes/class_settings.php';
	include_once CPTA_PLUGIN_PATH . '/includes/class_scripts.php';
	include_once CPTA_PLUGIN_PATH . '/includes/class_attachment.php';
	include_once CPTA_PLUGIN_PATH . '/shortcode_functions.php';
	
	new cpta_pdf_settings;
	new cpta_pdf_scripts;
	new cpta_attachments_init;
}

class wp_custom_post_type_attachment_pre_checking {
	function __construct() {
		plug_install_custom_post_type_attachment();
	}
}

new wp_custom_post_type_attachment_pre_checking;

add_shortcode( 'pdf_attachment', 'custom_pdf_attachment_shortcode' );
add_shortcode( 'pdf_all_attachments', 'custom_pdf_all_attachments_shortcode' );

add_action( 'plugins_loaded', 'cpta_load_plugin_textdomain' );

function cpta_load_plugin_textdomain() {
	load_plugin_textdomain( 'custom-post-type-pdf-attachment', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}