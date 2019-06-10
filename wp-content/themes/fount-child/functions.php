<?php
    //PLACE YOUR CUSTOM FUNCTIONS HERE

	/*
	UNCOMMENT THIS CODE TO OVERRIDE THE THEME main-min.js FILE
	add_action( 'wp_enqueue_scripts', 'prk_overwrite_scripts', 101 );
	function prk_overwrite_scripts() {
	    wp_deregister_script('fount_main');
	    wp_enqueue_script('fount_main', get_stylesheet_directory_uri() . '/js/main-min.js' );
	    global $prk_fount_options;
	    $prk_fount_options['active_visual_composer']=PRK_FOUNT_COMPOSER;	    
	    wp_localize_script('fount_main', 'theme_options', $prk_fount_options);
	}
	*/

remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'wp_resource_hints', 2);


?>
