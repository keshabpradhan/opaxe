<?php
class cpta_pdf_scripts {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_style' ) );
	}
	
	public function load_admin_style(){
		wp_register_style( 'style_cpta_admin', plugins_url( CPTA_PLUGIN_DIR . '/css/style_admin.css' ) );
		wp_enqueue_style( 'style_cpta_admin' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery.cookie', plugins_url( CPTA_PLUGIN_DIR . '/js/jquery.cookie.js' ) );
		wp_enqueue_script( 'ap-tabs', plugins_url( CPTA_PLUGIN_DIR . '/js/ap-tabs.js' ) );
	}
	
}