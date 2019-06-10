<?php

	//-------------------------
	//CREATE PORTFOLIO CUSTOM TYPE
	//-------------------------
	function portfolio_register() 
	{
		global $prk_fount_options;
 		$prk_fount_slug_options=$prk_fount_options;
		if (!isset($prk_fount_slug_options['portfolio_slug']) || $prk_fount_slug_options['portfolio_slug']=="")
			$prk_fount_slug_options['portfolio_slug']="portfolios";
		$labels = array(
			'add_new_item' => __('Add Portfolio Item', 'fount'),
			'edit_item' => __('Edit Portfolio Item', 'fount'),
			'new_item' => __('New Portfolio Item', 'fount'),
			'view_item' => __('Preview Portfolio Item', 'fount'),
			'search_items' => __('Search Portfolio Items', 'fount'),
			'not_found' => __('No Portfolio items found.', 'fount'),
			'not_found_in_trash' => __('No Portfolio items found in Trash.', 'fount')
		);	
		if ( get_bloginfo('version')>='3.8' ) 
		{
			register_post_type('pirenko_portfolios', array(
			'label' => __('Portfolio Items', 'fount'),
			'labels' => array('all_items' => __('All Portfolios', 'fount')),
			'singular_label' => __('Portfolio Item', 'fount'),
			'public' => true,
			'show_ui' => true, 
			'_builtin' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array('slug' => $prk_fount_slug_options['portfolio_slug']),
			'supports' => array('title', 'excerpt', 'editor', 'thumbnail', 'comments','custom-fields'), // Let's use custom fields for debugging purposes only
			'menu_icon' => '',
		));
		}
		else
		{
			register_post_type('pirenko_portfolios', array(
				'label' => __('Portfolio Items', 'fount'),
				'labels' => array('all_items' => __('All Portfolios', 'fount')),
				'singular_label' => __('Portfolio Item', 'fount'),
				'public' => true,
				'show_ui' => true, 
				'_builtin' => false,
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => array('slug' => $prk_fount_slug_options['portfolio_slug']),
				'supports' => array('title', 'excerpt', 'editor', 'thumbnail', 'comments','custom-fields'), // Let's use custom fields for debugging purposes only
				'menu_icon' => PLUGIN_URL . 'images/admin/portfolio.png',
			));
		}

		//ADD TAXONOMIES SIMILAR TO A CATEGORY
		$labels_pir_categories = array(
			'name' => __('Skills', 'post type general name', 'fount'),
			'all_items' => __('All Skills', 'all items', 'fount'),
			'add_new_item' => __('Add New Skill', 'adding a new item', 'fount'),
			'new_item_name' => __('New Skill Name', 'adding a new item', 'fount'),
			'edit_item' => __("Edit Skill", 'fount')
		);

		if (!isset($prk_fount_slug_options['skills_slug']) || $prk_fount_slug_options['skills_slug']=="")
			$prk_fount_slug_options['skills_slug']="skills";
		$args_pir_categories = array(
			'labels' => $labels_pir_categories,
			'rewrite' => array('slug' => $prk_fount_slug_options['skills_slug']),
			'hierarchical' => true
		);	
		register_taxonomy( 'pirenko_skills', 'pirenko_portfolios', $args_pir_categories );

		//ADD TAXONOMIES SIMILAR TO TAGS
		  $labels = array(
			'name' => __( 'Tags', 'taxonomy general name', 'fount' ),
			'singular_name' => __( 'Tag', 'taxonomy singular name', 'fount' ),
			'search_items' =>  __( 'Search Tags', 'fount' ),
			'popular_items' => __( 'Popular Tags', 'fount' ),
			'all_items' => __( 'All Tags', 'fount' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Tag', 'fount' ), 
			'update_item' => __( 'Update Tag', 'fount' ),
			'add_new_item' => __( 'Add New Tag', 'fount' ),
			'new_item_name' => __( 'New Tag Name', 'fount' ),
			'separate_items_with_commas' => __( 'Separate Tags with commas', 'fount' ),
			'add_or_remove_items' => __( 'Add or remove Tags', 'fount' ),
			'choose_from_most_used' => __( 'Choose from the most used Tags', 'fount' ),
			'menu_name' => __( 'Tags', 'fount' ),
		  ); 
		
		if (!isset($prk_fount_slug_options['folio_tags_slug']) || $prk_fount_slug_options['folio_tags_slug']=="")
		{
			$prk_fount_slug_options['folio_tags_slug']="tagged";
		}
		register_taxonomy('portfolio_tag','pirenko_portfolios',array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => $prk_fount_slug_options['folio_tags_slug'] ),
		));
	}
	add_action('init', 'portfolio_register',5);
	//PORTFOLIO ADD MORE COLUMNS FOR THE DASHBOARD VIEW
	//ADD HOOKS
	add_filter('manage_pirenko_portfolios_posts_columns', 'pirenko_columns_head_only_portfolios', 10);
	add_action('manage_pirenko_portfolios_posts_custom_column', 'pirenko_columns_content_only_portfolios', 10, 2);
	//FUNCTION TO RETRIEVE FEATURED IMAGE
	function pirenko_get_featured_image($post_ID) {
		$post_thumbnail_id = get_post_thumbnail_id($post_ID);
		if ($post_thumbnail_id) {
			$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'medium');
			return $post_thumbnail_img[0];
		}
	}
	//RESORT COLUMNS
	function pirenko_columns_head_only_portfolios($defaults) 
	{
		unset($defaults['date']);
		$defaults['set']=__('Skills', 'seven_lang');
		$defaults['featured_image'] = 'Featured Image';
		$defaults['date']="Date";
		return $defaults;
	}
	//FILL SPECIAL COLUMNS
	function pirenko_columns_content_only_portfolios($column_name, $post_ID) 
	{
		global $post;
		if ($column_name == 'featured_image') 
		{  
			$post_featured_image = pirenko_get_featured_image($post_ID);  
			if ($post_featured_image) {  
				// HAS A FEATURED IMAGE  
				echo '<img class="slides_image_preview" src="' . $post_featured_image . '" />';  
			}  
			else {  
				// NO FEATURED IMAGE, SHOW THE DEFAULT ONE  
				echo ("No image");
			}  
		}
		if ($column_name == 'set') 
		{ 
			{
				$terms = get_the_terms( $post_ID, 'pirenko_skills' );
				if ( !empty( $terms ) ) 
				{
					$out = array();
					foreach ( $terms as $term ) 
					{
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'pirenko_skills' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'pirenko_skills', 'display' ) )
						);
					}
					//JOIN THE TERMS SEPARATED BY A COMMA
					echo join( ', ', $out );	
				}
			}
		}
	}
	//MAKE SURE THAT PORTFOLIO HAVE A FEATURED IMAGE
	/*add_action('save_post', 'pu_validate_thumbnail');
	function pu_validate_thumbnail($post_id)
	{
	    // Only validate post type of post
	    if(get_post_type($post_id) != 'pirenko_portfolios')
	        return;
	 	// Check post has a thumbnail
	    if ( !has_post_thumbnail( $post_id ) ) {
	    	// Confirm validate thumbnail has failed
	        set_transient( "pu_validate_thumbnail_failed", "true" );
	        // Remove this action so we can resave the post as a draft and then reattach the post
	        remove_action('save_post', 'pu_validate_thumbnail');
	        wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));
			add_action('save_post', 'pu_validate_thumbnail');
	    } else {
	    	// If the post has a thumbnail delete the transient
	        delete_transient( "pu_validate_thumbnail_failed" );
	    }
	}
	add_action('admin_notices', 'pu_validate_thumbnail_error');
	function pu_validate_thumbnail_error()
	{
	    // check if the transient is set, and display the error message
	    if ( get_transient( "pu_validate_thumbnail_failed" ) == "true" ) 
	    {
	        echo "<div id='message' class='error'>
				<p><strong>A post thumbnail must be set before saving the post. This post will be saved as a draft until a featured image is set.</strong></p>
			</div>";
	        delete_transient( "pu_validate_thumbnail_failed" );
	    }
	}*/
	
	//-------------------------
	//CREATE SLIDES CUSTOM TYPE
	//-------------------------
	function slides_register() 
	{
		global $prk_fount_options;
 		$prk_fount_slug_options=$prk_fount_options;
 		if (!isset($prk_fount_slug_options['slides_slug']) || $prk_fount_slug_options['slides_slug']=="")
 			$prk_fount_slug_options['slides_slug']="slides";
		$labels = array(
			'name' => __('Slides', 'post type general name', 'fount'),
			'all_items' => __('All Slides', 'fount'),
			'singular_name' => __('Slide', 'fount'),
			'add_new' => __('Add New Slide', 'fount'),
			'add_new_item' => __('Add New Slide', 'fount'),
			'edit_item' => __('Edit Slide', 'fount'),
			'new_item' => __('New Slide', 'fount'),
			'view_item' => __('View Slide', 'fount'),
			'search_items' => __('Search Slides', 'fount'),
			'not_found' =>  __('Nothing found', 'fount'),
			'not_found_in_trash' => __('Nothing found in Trash', 'fount'),
			'parent_item_colon' => ''
		);
 		if ( get_bloginfo('version')>='3.8' ) {
 			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => '',
				'rewrite' => array('slug' => $prk_fount_slug_options['slides_slug']),
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array('title','editor','thumbnail')
			);
 		}
 		else
 		{
			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => PLUGIN_URL . 'images/admin/menu.png',
				'rewrite' => array('slug' => $prk_fount_slug_options['slides_slug']),
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array('title','editor','thumbnail')
			);
		} 
		register_post_type( 'pirenko_slides' , $args );
		//ADD TAXONOMIES FOR SLIDES
		$labels_pir_categories = array(
			'name' => __('Groups', 'post type general name', 'fount'),
			'all_items' => __('All Groups', 'all items', 'fount'),
			'add_new_item' => __('Add New Group', 'adding a new item', 'fount'),
			'new_item_name' => __('New Group Name', 'adding a new item', 'fount'),
			'edit_item' => __("Edit Group", "founttheme")
		);

		if (!isset($prk_fount_slug_options['groups_slug']) || $prk_fount_slug_options['groups_slug']=="")
			$prk_fount_slug_options['groups_slug']="group";
		$args_pir_categories = array(
			'labels' => $labels_pir_categories,
			'rewrite' => array('slug' => $prk_fount_slug_options['groups_slug']),
			'hierarchical' => true
		);
		
		register_taxonomy( 'pirenko_slide_set', 'pirenko_slides', $args_pir_categories );
	}
	
	//ADD MORE COLUMNS FOR THE DASHBOARD VIEW
	
	//ADD HOOKS
	add_filter('manage_pirenko_slides_posts_columns', 'pirenko_columns_head_only_slides', 10);
	add_action('manage_pirenko_slides_posts_custom_column', 'pirenko_columns_content_only_slides', 10, 2);
	//RESORT COLUMNS
	function pirenko_columns_head_only_slides($defaults) 
	{
		unset($defaults['date']);
		$defaults['set']="Group";
		$defaults['featured_image'] = 'Featured Image';
		$defaults['date']="Date";
		return $defaults;
	}
	//FILL SPECIAL COLUMNS
	function pirenko_columns_content_only_slides($column_name, $post_ID) 
	{
		global $post;
		if ($column_name == 'featured_image') 
		{  
			$post_featured_image = pirenko_get_featured_image($post_ID);  
			if ($post_featured_image) {  
				// HAS A FEATURED IMAGE  
				echo '<img class="slides_image_preview" src="' . $post_featured_image . '" />';  
			}  
			else {  
				// NO FEATURED IMAGE, SHOW THE DEFAULT ONE  
				echo ("No image");
			}  
		}
		if ($column_name == 'set') 
		{ 
			{
				$terms = get_the_terms( $post_ID, 'pirenko_slide_set' );
				if ( !empty( $terms ) ) 
				{
					$out = array();
					foreach ( $terms as $term ) 
					{
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'pirenko_slide_set' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'pirenko_slide_set', 'display' ) )
						);
					}
					//JOIN THE TERMS SEPARATED BY A COMMA
					echo join( ', ', $out );	
				}
			}
		}
	}

	//CREATE SLIDER ITEMS POST TYPE
	add_action('init', 'slides_register',5);


	//-------------------------
	//CREATE MEMBERS CUSTOM TYPE
	//-------------------------
	function members_register() 
	{
		global $prk_fount_options;
 		$prk_fount_slug_options=$prk_fount_options;
		if (!isset($prk_fount_slug_options['members_slug']) || $prk_fount_slug_options['members_slug']=="")
			$prk_fount_slug_options['members_slug']="member";
		$labels = array(
			'add_new_item' => __('Add Team Member', 'fount'),
			'edit_item' => __('Edit Team Member', 'fount'),
			'new_item' => __('New Team Member', 'fount'),
			'view_item' => __('Preview Team Member', 'fount'),
			'search_items' => __('Search Team Members', 'fount'),
			'not_found' => __('No Team Members found.', 'fount'),
			'not_found_in_trash' => __('No Team Members found in Trash.', 'fount')
		);	
		if ( get_bloginfo('version')>='3.8' )
		{
			register_post_type('pirenko_team_member', array(
				'label' => __('Team Members', 'fount'),
				'labels' => array('all_items' => __('All Members', 'fount')),
				'singular_label' => __('Team Member', 'fount'),
				'public' => true,
				'show_ui' => true, 
				'_builtin' => false,
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => array('slug' => $prk_fount_slug_options['members_slug']),
				'supports' => array('title', 'excerpt', 'editor', 'thumbnail', 'comments','custom-fields'), // Let's use custom fields for debugging purposes only
				'menu_icon' => '',
			));
		}
		else 
		{
			register_post_type('pirenko_team_member', array(
				'label' => __('Team Members', 'fount'),
				'labels' => array('all_items' => __('All Members', 'fount')),
				'singular_label' => __('Team Member', 'fount'),
				'public' => true,
				'show_ui' => true, 
				'_builtin' => false,
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => array('slug' => $prk_fount_slug_options['members_slug']),
				'supports' => array('title', 'excerpt', 'editor', 'thumbnail', 'comments','custom-fields'), // Let's use custom fields for debugging purposes only
				'menu_icon' => PLUGIN_URL . 'images/admin/user.png',
			));
		}
		//ADD TAXONOMIES SIMILAR TO A CATEGORY
		$labels_pir_categories = array(
			'name' => __('Teams', 'post type general name', 'fount'),
			'all_items' => __('All Teams', 'all items', 'fount'),
			'add_new_item' => __('Add New Team', 'adding a new item', 'fount'),
			'new_item_name' => __('New Team Name', 'adding a new item', 'fount'),
			'edit_item' => __("Edit Team", 'fount')
		);

		if (!isset($prk_fount_slug_options['team_slug']) || $prk_fount_slug_options['team_slug']=="")
			$prk_fount_slug_options['team_slug']="team";
		$args_pir_categories = array(
			'labels' => $labels_pir_categories,
			'rewrite' => array('slug' => $prk_fount_slug_options['team_slug']),
			'hierarchical' => true
		);
		register_taxonomy('pirenko_member_group', 'pirenko_team_member', $args_pir_categories );
	}
	add_action('init', 'members_register',5);

	//-------------------------
	//CREATE TESTIMONIALS CUSTOM TYPE
	//-------------------------
	function fount_testimonials_register() 
	{
		global $prk_fount_options;
 		$prk_fount_slug_options=$prk_fount_options;
 		if (!isset($prk_fount_slug_options['testimonials_slug']) || $prk_fount_slug_options['testimonials_slug']=="")
 			$prk_fount_slug_options['testimonials_slug']="testimonials";
		$labels = array(
			'name' => __('Testimonials', 'fount'),
			'all_items' => __('All Testimonials', 'fount'),
			'singular_name' => __('Testimonial', 'fount'),
			'add_new' => __('Add New Testimonial', 'fount'),
			'add_new_item' => __('Add New Testimonial', 'fount'),
			'edit_item' => __('Edit Testimonial', 'fount'),
			'new_item' => __('New Testimonial', 'fount'),
			'view_item' => __('View Testimonial', 'fount'),
			'search_items' => __('Search Testimonials', 'fount'),
			'not_found' =>  __('Nothing found', 'fount'),
			'not_found_in_trash' => __('Nothing found in Trash', 'fount'),
			'parent_item_colon' => ''
		);
 		if ( get_bloginfo('version')>='3.8' ) {
 			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => '',
				'rewrite' => array('slug' => $prk_fount_slug_options['testimonials_slug']),
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array('title','editor','thumbnail')
			);
 		}
 		else
 		{
			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => PLUGIN_URL . 'images/admin/menu.png',
				'rewrite' => array('slug' => $prk_fount_slug_options['testimonials_slug']),
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array('title','editor','thumbnail')
			);
		} 
		register_post_type( 'pirenko_testimonials' , $args );
		//ADD TAXONOMIES FOR SLIDES
		$labels_pir_categories = array(
			'name' => __('Groups', 'post type general name', 'fount'),
			'all_items' => __('All Groups', 'all items', 'fount'),
			'add_new_item' => __('Add New Group', 'adding a new item', 'fount'),
			'new_item_name' => __('New Group Name', 'adding a new item', 'fount'),
			'edit_item' => __("Edit Group", "founttheme")
		);

		if (!isset($prk_fount_slug_options['testimonials_groups_slug']) || $prk_fount_slug_options['testimonials_groups_slug']=="")
			$prk_fount_slug_options['testimonials_groups_slug']="testimonials_group";
		$args_pir_categories = array(
			'labels' => $labels_pir_categories,
			'rewrite' => array('slug' => $prk_fount_slug_options['testimonials_groups_slug']),
			'hierarchical' => true
		);
		
		register_taxonomy( 'pirenko_testimonial_set', 'pirenko_testimonials', $args_pir_categories );
	}

	//CREATE POST TYPE
	add_action('init', 'fount_testimonials_register',5);
	

	//EXECUTE THIS ONLY WHEN THE THEME IS ACTIVATED
	function prk_activate_new_post($oldname, $oldtheme=false) {
		portfolio_register();
		slides_register();
		members_register();
		flush_rewrite_rules();
	}
	add_action("after_switch_theme", "prk_activate_new_post", 10 ,  2);

	//CHECK IF OPTIONS/SLUGS WERE CHANGED
	if (isset($prk_fount_slug_options['just_saved']) && $prk_fount_slug_options['just_saved']=="true")
	{
		add_action('init', 'prk_activate_new_post');
	}
	$nets_array = array (
		'none' => 'None',
		'delicious' => 'Delicious',
		'deviantart' => 'Deviantart',
		'dribbble' => 'Dribbble',
		'facebook' => 'Facebook',
		'flickr' => 'Flickr',
		'gplus' => 'Google Plus',
		'instagram-filled' => 'Instagram',
		'linkedin' => 'Linkedin',
		'pinterest' => 'Pinterest',
		'skype' => 'Skype',
		'twitter' => 'Twitter',
		'vimeo' => 'Vimeo',
		'yahoo' => 'Yahoo',
		'youtube' => 'Youtube',
		'rss-1' => 'RSS',
		'book' => 'vCard',
	);
	include_once(ABSPATH . 'wp-admin/includes/plugin.php'); // Require plugin.php to use is_plugin_active() below
	if (is_plugin_active('revslider/revslider.php')) {
      global $wpdb;
      $rs = $wpdb->get_results( 
        "
        SELECT id, title, alias
        FROM ".$wpdb->prefix."revslider_sliders
        ORDER BY id ASC LIMIT 999
        "
      );
      $fount_rev_slider = array();
      if ($rs) {
        foreach ( $rs as $slider ) {
          $fount_rev_slider[$slider->alias] = $slider->title;
        }
      } else {
        $fount_rev_slider[0] = "No sliders found";
      }
    }
    else {
        $fount_rev_slider[0] = "Plugin is not active";
    }
    
	if(function_exists("register_field_group"))
	{
		register_field_group(array (
			'id' => 'acf_testimonial-options',
			'title' => 'Theme Testimonial Options',
			'fields' => array (
				array (
					'key' => 'field_5286cdc09f9be',
					'label' => 'Sub-heading',
					'name' => 'testimonial_subheading',
					'instructions' => 'Will be shown under the title',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
	                'key' => 'field_528a44c48star',
	                'label' => 'Star rating',
	                'instructions' => 'Optional',
	                'name' => 'rating',
	                'type' => 'select',
	                'choices' => array (
	                    'none' => 'Do not display',
	                    //'0' => 'Zero',
	                    '1' => 'One',
	                    '2' => 'Two',
	                    '3' => 'Three',
	                    '4' => 'Four',
	                    '5' => 'Five',
	                	),
                ),
                array (
                	'key' => 'field_5286cdc09link',
                	'label' => 'Link',
                	'name' => 'testimonial_link',
                	'instructions' => 'Will be conneceted to the testimonial title (optional)',
                	'type' => 'text',
                	'default_value' => '',
                	'placeholder' => '',
                	'prepend' => '',
                	'append' => '',
                	'formatting' => 'none',
                	'maxlength' => '',
                ),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'pirenko_testimonials',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'default',
				'hide_on_screen' => array (
					0 => 'custom_fields',
				),
			),
			'menu_order' => 0,
		));

		register_field_group(array (
			'id' => 'acf_theme-member-options',
			'title' => 'Theme Member Options',
			'fields' => array (
				array (
					'key' => 'field_52877cc65f9d6',
					'label' => 'Featured color',
					'name' => 'featured_color',
					'type' => 'color_picker',
					'instructions' => '(optional)',
					'default_value' => '',
				),
				array (
					'key' => 'field_5286baa09f9be',
					'label' => 'Job',
					'name' => 'member_job',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bb119f9bf',
					'label' => 'Email',
					'name' => 'member_email',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bb2e9f9c0',
					'label' => 'Enable link to single member page?',
					'name' => 'show_member_link',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 1,
				),
				array (
	                'key' => 'field_8320f34a34875',
	                'label' => 'Single member post layout',
	                'name' => 'member_layout',
	                'type' => 'select',
	                'choices' => array (
	                    'regular' => 'Regular size image on top',
	                    'big_image' => 'Full width image on top',
	                    'divided' => 'Image on the left side',
	                ),
	                'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bb2e9f9c0',
								'operator' => '==',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
	                'default_value' => 'regular',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
				array (
					'key' => 'field_5286bb940de2d',
					'label' => 'Show image on single member page?',
					'name' => 'show_member_image',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bb2e9f9c0',
								'operator' => '==',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286bbb60de2e',
					'label' => 'Single post image',
					'name' => 'image_2',
					'type' => 'image',
					'instructions' => '(optional)',
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bb2e9f9c0',
								'operator' => '==',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286bbf848d3b',
					'label' => 'Social network link 1',
					'name' => 'member_social_1',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286bd7aceeda',
					'label' => 'Network link 1',
					'name' => 'member_social_1_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bbf848d3b',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bdc50cbdc',
					'label' => 'Social network link 2',
					'name' => 'member_social_2',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286be1007c5c',
					'label' => 'Network link 2',
					'name' => 'member_social_2_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bdc50cbdc',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bdc40cbdb',
					'label' => 'Social network link 3',
					'name' => 'member_social_3',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286be0f07c5b',
					'label' => 'Network link 3',
					'name' => 'member_social_3_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bdc40cbdb',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bdc30cbda',
					'label' => 'Social network link 4',
					'name' => 'member_social_4',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286be0f07c5a',
					'label' => 'Network link 4',
					'name' => 'member_social_4_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bdc30cbda',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bdc20cbd9',
					'label' => 'Social network link 5',
					'name' => 'member_social_5',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286be0e07c59',
					'label' => 'Network link 5',
					'name' => 'member_social_5_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bdc20cbd9',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286bdc10cbd8',
					'label' => 'Social network link 6',
					'name' => 'member_social_6',
					'type' => 'select',
					'choices' => $nets_array,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_5286be4907c5d',
					'label' => 'Network link 6',
					'name' => 'member_social_6_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286bdc10cbd8',
								'operator' => '!=',
								'value' => 'none',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
                'key' => 'field_528a44c48201d',
                'label' => 'Sidebar display',
                'name' => 'show_sidebar',
                'type' => 'select',
                'choices' => array (
                    'default' => 'Default option',
                    'yes' => 'Show Sidebar',
                    'no' => 'Hide Sidebar',
                ),
                'default_value' => '',
                'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_8320f34a34875',
							'operator' => '!=',
							'value' => 'divided',
						),
					),
					'allorany' => 'all',
				),
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_398a6dab76e59',
                'label' => 'Right custom sidebar selector',
                'name' => 'right_sidebar_id',
                'type' => 'sidebar_selector',
                'instructions' => 'Leave blank for default sidebar',
                'allow_null' => 1,
                'default_value' => '',
                'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_8320f34a34875',
							'operator' => '!=',
							'value' => 'divided',
						),
					),
					'allorany' => 'all',
				),
            ),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'pirenko_team_member',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'default',
				'hide_on_screen' => array (
					0 => 'custom_fields',
				),
			),
			'menu_order' => 0,
		));

		//GRID PORTFOLIO PAGE
	    register_field_group(array (
	        'id' => 'acf_theme-portfolio-grid-options',
	        'title' => 'Theme Portfolio Options',
	        'fields' => array (
	        	array (
	                'key' => 'field_528a999ea4be8',
	                'label' => 'Make page header featured?',
	                'name' => 'featured_header',
	                'type' => 'true_false',
	                'message' => 'The first section of the page content will appear behind the menu. Only the page content will be displayed.',
	                'default_value' => 0,
	            ),
	        	array (
	                'key' => 'field_528a450cef555',
	                'label' => 'Show page title?',
	                'name' => 'show_title',
	                'type' => 'true_false',
	                'message' => '',
	                'default_value' => 0,
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_528a999ea4be8',
	                            'operator' => '!=',
	                            'value' => '1',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	            ),
	            array (
	                'key' => 'field_528c54accc439',
	                'label' => 'Title alignment',
	                'name' => 'header_align',
	                'type' => 'select',
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_528a450cef555',
	                            'operator' => '==',
	                            'value' => '1',
	                        ),
	                        array (
	                            'field' => 'field_528a999ea4be8',
	                            'operator' => '!=',
	                            'value' => '1',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	                'choices' => array (
	                    'head_left' => 'Left',
	                    'head_center' => 'Center',
	                    'head_right' => 'Right'
	                ),
	                'default_value' => '',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_5281127acc438',
	                'label' => 'Header text',
	                'name' => 'below_headings_text',
	                'type' => 'textarea',
	                'instructions' => 'Will be displayed under the page title',
	                'conditional_logic' => array (
	                    'status' => 1,
	                    'rules' => array (
	                        array (
	                            'field' => 'field_528a450cef555',
	                            'operator' => '==',
	                            'value' => '1',
	                        ),
	                        array (
	                            'field' => 'field_528a999ea4be8',
	                            'operator' => '!=',
	                            'value' => '1',
	                        ),
	                    ),
	                    'allorany' => 'all',
	                ),
	                'default_value' => '',
	                'placeholder' => '',
	                'maxlength' => '',
	                'formatting' => 'br',
	            ),
	            array (
	                'key' => 'field_8320f34a75901',
	                'label' => 'General layout',
	                'name' => 'portfolio_layout',
	                'type' => 'select',
	                'choices' => array (
            			'grid' => 'Grid with horizontal rectangular images',
            			'grid_vertical' => 'Grid with vertical rectangular images',
            			'squares' => 'Grid with squared images',
	                    'masonry' => 'Grid without image crop - Masonry',
	                ),
	                'default_value' => 'masonry',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_529732e396c0b',
	                'label' => 'Number of columns',
	                'name' => 'cols_number',
	                'type' => 'number',
	                'instructions' => 'Leave blank for variable number',
	                'default_value' => 3,
	                'placeholder' => '',
	                'prepend' => '',
	                'append' => '',
	                'min' => 2,
	                'max' => '',
	                'step' => '',
	            ),
	            array (
	                'key' => 'field_529730563ba39',
	                'label' => 'Number of posts to load on each event',
	                'name' => 'items_number',
	                'type' => 'number',
	                'required' => 1,
	                'default_value' => 9,
	                'placeholder' => '',
	                'prepend' => '',
	                'append' => '',
	                'min' => 2,
	                'max' => '',
	                'step' => '',
	            ),
	            array (
	                'key' => 'field_529737270f73c',
	                'label' => 'Portfolio skills to be displayed',
	                'name' => 'cat_filter',
	                'type' => 'taxonomy',
	                'instructions' => 'Leave blank for all',
	                'taxonomy' => 'pirenko_skills',
	                'field_type' => 'checkbox',
	                'allow_null' => 0,
	                'load_save_terms' => 0,
	                'return_format' => 'object',
	                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_529738c0624fc',
	                'label' => 'Show filter above thumbnails',
	                'name' => 'show_filter',
	                'type' => 'true_false',
	                'message' => '',
	                'default_value' => 0,
	            ),
	            array (
	                'key' => 'field_8320f34a000723',
	                'label' => 'Thumbnails click behavior?',
	                'name' => 'thumbs_type_folio',
	                'type' => 'select',
	                'choices' => array (
            			'overlayed' => 'Show project with an overlay and hide page content',
            			'aboved' => 'Show project above the thumbnails',
            			'lightboxed' => 'Open lightbox',
            			'classiqued' => 'Open project on a different page',
	                ),
	                'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a450eea432',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
	                'default_value' => 'overlayed',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_529735738ad74',
	                'label' => 'Thumbnails margin',
	                'name' => 'thumbs_mg',
	                'type' => 'number',
	                'required' => 1,
	                'default_value' => 0,
	                'placeholder' => '',
	                'prepend' => '',
	                'append' => '',
	                'min' => 0,
	                'max' => '',
	                'step' => '',
	            ),
	            array (
	                'key' => 'field_529751afeaaa3',
	                'label' => 'Multi-colored thumbs on rollover?',
	                'name' => 'multicolored_thumbs',
	                'type' => 'true_false',
	                'message' => 'If yes the portfolio default color will be applied to each thumb',
	                'default_value' => 1,
	            ),
				array (
	                'key' => 'field_528a450eea432',
	                'label' => 'Always show project info?',
	                'name' => 'titled_portfolio',
	                'type' => 'true_false',
	                'message' => 'Will be shown under the thumbnail.',
	                'default_value' => 0,
	            ),
	            array (
	                'key' => 'field_8320f34a92600',
	                'label' => 'Show project information on rollover?',
	                'name' => 'fount_show_skills',
	                'type' => 'select',
	                'choices' => array (
            			'folio_title_and_skills' => 'Title and skills',
            			'folio_title_only' => 'Title only'
	                ),
	                'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a450eea432',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
	                'default_value' => 'folio_title_and_skills',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
	                'key' => 'field_4387f34a92600',
	                'label' => 'Show icons inside thumbnail?',
	                'name' => 'icons_display',
	                'type' => 'select',
	                'choices' => array (
            			'both_icon' => 'Yes, show lightbox and link',
            			'no' => 'No',
	                ),
	                'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a450eea432',
								'operator' => '!=',
								'value' => '1',
							),
							array (
								'field' => 'field_8320f34a000723',
								'operator' => '!=',
								'value' => 'lightboxed',
							),
						),
						'allorany' => 'all',
					),
	                'default_value' => 'both_icon',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	        ),
	        'location' => array (
	            array (
	                array (
	                    'param' => 'page_template',
	                    'operator' => '==',
	                    'value' => 'template_portfolio.php',
	                    'order_no' => 0,
	                    'group_no' => 0,
	                ),
	            ),
	        ),
	        'options' => array (
	            'position' => 'normal',
	            'layout' => 'default',
	            'hide_on_screen' => array (
	                0 => 'custom_fields',
	            ),
	        ),
	        'menu_order' => 0,
	    ));

		//PORTFOLIO SINGLES
		register_field_group(array (
			'id' => 'acf_theme-portfolio-options',
			'title' => 'Theme Portfolio Options',
			'fields' => array (
				array (
					'key' => 'field_5286a3dcustom',
					'label' => 'Custom Logo (for portfolio feeds)',
					'name' => 'custom_logo',
					'type' => 'image',
					'instructions' => 'Optional. Will be shown inside thumbnails and will be scaled to 50% of the original size (retina support)',
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_528664954175a',
					'label' => 'Featured Color',
					'name' => 'featured_color',
					'type' => 'color_picker',
					'instructions' => '(optional)',
					'default_value' => '',
				),
				array (
	                'key' => 'field_528a5fc30297d',
	                'label' => 'Post layout',
	                'name' => 'inner_layout',
	                'type' => 'select',
	                'choices' => array (
	                    'default' => 'Default option',
	                    'half' => 'Half',
	                    'wide' => 'Wide',
	                    'wideout' => 'Wide without right info panel',
	                ),
	                'default_value' => '',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
	            array (
					'key' => 'field_5286bgatinho',
					'label' => 'Show title under featured media?',
					'name' => 'title_under',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc30297d',
								'operator' => '!=',
								'value' => 'default',
							),
							array (
								'field' => 'field_528a5fc30297d',
								'operator' => '!=',
								'value' => 'half',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b34b1e739',
					'label' => 'Skip featured image on single page and lightbox?',
					'name' => 'skip_featured',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 0,
				),
				array (
					'key' => 'field_52f4c8aca4146',
					'label' => 'Disable slider and stack images vertically?',
					'name' => 'no_slider',
					'type' => 'true_false',
					'default_value' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc30297d',
								'operator' => '!=',
								'value' => 'fullscreen',
							),
							array (
								'field' => 'field_528a5fc30297d',
								'operator' => '!=',
								'value' => 'no_cropping',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b3e53bbb9',
					'label' => 'Client',
					'name' => 'client_url',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b449ec69f',
					'label' => 'Project link',
					'name' => 'ext_url',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b448ec69e',
					'label' => 'Project link text',
					'name' => 'ext_url_label',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_528aa51c449fa',
					'label' => 'Open project link when thumb is clicked?',
					'name' => 'skip_to_external',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 0,
				),
				array (
	                'key' => 'field_528a5fc45neue',
	                'label' => 'Open link in a new window?',
	                'name' => 'new_window',
	                'type' => 'select',
	                'choices' => array (
	                    '_blank' => 'Yes',
	                    '_self' => 'No',
	                ),
	                'default_value' => '_blank',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
				array (
	                'key' => 'field_528a5fc45683d',
	                'label' => 'Use images and videos (maximum 20 entries) or just images with no entries number limitation?',
	                'name' => 'use_gallery',
	                'type' => 'select',
	                'choices' => array (
	                    'both_types' => 'Images and videos (maximum 20)',
	                    'images_only' => 'Images only (bulk selection)',
	                ),
	                'default_value' => 'both_types',
	                'allow_null' => 0,
	                'multiple' => 0,
	            ),
				array (
					'key' => 'field_52f4c8bcf5146',
					'label' => 'Image Gallery',
					'name' => 'image_gallery',
					'type' => 'wysiwyg',
					'default_value' => '',
					'toolbar' => 'basic',
					'media_upload' => 'yes',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'images_only',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286a5b702e6b',
					'label' => 'Position 2: Media Type?',
					'name' => 'position_2_use_video',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286a3d0ccd3d',
					'label' => 'Image 2',
					'name' => 'image_2',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a5b702e6b',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286a6d550bd0',
					'label' => 'Video 2',
					'name' => 'video_2',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a5b702e6b',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286a7b7ef161',
					'label' => 'Position 3: Media Type?',
					'name' => 'position_3_use_video',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286a77eef160',
					'label' => 'Image 3',
					'name' => 'image_3',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a7b7ef161',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286ad24752c2',
					'label' => 'Video 3',
					'name' => 'video_3',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a7b7ef161',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11e8cccf',
					'label' => 'Position 4: Media Type?',
					'name' => 'position_4_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19e9a21e',
					'label' => 'Image 4',
					'name' => 'image_4',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11e8cccf',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b230fdeb5',
					'label' => 'Video 4',
					'name' => 'video_4',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11e8cccf',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11e8ccce',
					'label' => 'Position 5: Media Type?',
					'name' => 'position_5_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19d9a21d',
					'label' => 'Image 5',
					'name' => 'image_5',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11e8ccce',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22ffdeb4',
					'label' => 'Video 5',
					'name' => 'video_5',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11e8ccce',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11d8cccd',
					'label' => 'Position 6: Media Type',
					'name' => 'position_6_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19c9a21c',
					'label' => 'Image 6',
					'name' => 'image_6',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11d8cccd',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22efdeb3',
					'label' => 'Video 6',
					'name' => 'video_6',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11d8cccd',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11c8cccc',
					'label' => 'Position 7: Media Type?',
					'name' => 'position_7_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19c9a21b',
					'label' => 'Image 7',
					'name' => 'image_7',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11c8cccc',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22dfdeb2',
					'label' => 'Video 7',
					'name' => 'video_7',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11c8cccc',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11b8cccb',
					'label' => 'Position 8: Media Type?',
					'name' => 'position_8_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19b9a21a',
					'label' => 'Image 8',
					'name' => 'image_8',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11b8cccb',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22cfdeb1',
					'label' => 'Video 8',
					'name' => 'video_8',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11b8cccb',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b1178ccca',
					'label' => 'Position 9: Media Type?',
					'name' => 'position_9_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b19a9a219',
					'label' => 'Image 9',
					'name' => 'image_9',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1178ccca',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22bfdeb0',
					'label' => 'Video 9',
					'name' => 'video_9',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1178ccca',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b1148ccc9',
					'label' => 'Position 10: Media Type?',
					'name' => 'position_10_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b1999a218',
					'label' => 'Image 10',
					'name' => 'image_10',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1148ccc9',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22afdeaf',
					'label' => 'Video 10',
					'name' => 'video_10',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1148ccc9',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286c7398ccc9',
					'label' => 'Position 11: Media Type?',
					'name' => 'position_11_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286a7878a218',
					'label' => 'Image 11',
					'name' => 'image_11',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286c7398ccc9',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22affdda',
					'label' => 'Video 11',
					'name' => 'video_11',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286c7398ccc9',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_528eeeb702e6b',
					'label' => 'Position 12: Media Type?',
					'name' => 'position_12_use_video',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286a3dcdcd3d',
					'label' => 'Image 12',
					'name' => 'image_12',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528eeeb702e6b',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5255a6d550bd0',
					'label' => 'Video 12',
					'name' => 'video_12',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528eeeb702e6b',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286a665ef161',
					'label' => 'Position 13: Media Type?',
					'name' => 'position_13_use_video',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286aaaeef160',
					'label' => 'Image 13',
					'name' => 'image_13',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a665ef161',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5244ad24752c2',
					'label' => 'Video 13',
					'name' => 'video_13',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286a665ef161',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11123ccf',
					'label' => 'Position 14: Media Type?',
					'name' => 'position_14_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5232b19e9a21e',
					'label' => 'Image 14',
					'name' => 'image_14',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11123ccf',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_52bbb230fdeb5',
					'label' => 'Video 14',
					'name' => 'video_14',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11123ccf',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b89e8ccce',
					'label' => 'Position 15: Media Type?',
					'name' => 'position_15_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286b1769a21d',
					'label' => 'Image 15',
					'name' => 'image_15',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b89e8ccce',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b13ffdeb4',
					'label' => 'Video 15',
					'name' => 'video_15',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b89e8ccce',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11d332cd',
					'label' => 'Position 16: Media Type',
					'name' => 'position_16_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286c66c9a21c',
					'label' => 'Image 16',
					'name' => 'image_16',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11d332cd',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b22efdea8',
					'label' => 'Video 16',
					'name' => 'video_16',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11d332cd',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b11c8c74c',
					'label' => 'Position 17: Media Type?',
					'name' => 'position_17_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_4286b19c9a21b',
					'label' => 'Image 17',
					'name' => 'image_17',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11c8c74c',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_4286b22dfdeb2',
					'label' => 'Video 17',
					'name' => 'video_17',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b11c8c74c',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b1139cccb',
					'label' => 'Position 18: Media Type?',
					'name' => 'position_18_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5285c19b9a21a',
					'label' => 'Image 18',
					'name' => 'image_18',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1139cccb',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5285022cfdeb1',
					'label' => 'Video 18',
					'name' => 'video_18',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b1139cccb',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b9876ccca',
					'label' => 'Position 19: Media Type?',
					'name' => 'position_19_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5284119a9a219',
					'label' => 'Image 19',
					'name' => 'image_19',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b9876ccca',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5281422bfdeb0',
					'label' => 'Video 19',
					'name' => 'video_19',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b9876ccca',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5286b114890c9',
					'label' => 'Position 20: Media Type?',
					'name' => 'position_20_media_type',
					'type' => 'select',
					'choices' => array (
						'image' => 'Image',
						'video' => 'Video',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
				),
				array (
					'key' => 'field_5286baa79a218',
					'label' => 'Image 20',
					'name' => 'image_20',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b114890c9',
								'operator' => '==',
								'value' => 'image',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'save_format' => 'id',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_5286b84ffdeaf',
					'label' => 'Video 20',
					'name' => 'video_20',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_5286b114890c9',
								'operator' => '==',
								'value' => 'video',
							),
							array (
								'field' => 'field_528a5fc45683d',
								'operator' => '==',
								'value' => 'both_types',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'pirenko_portfolios',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'default',
				'hide_on_screen' => array (
					0 => 'custom_fields',
				),
			),
			'menu_order' => 0,
		));
		register_field_group(array (
			'id' => 'acf_theme-slide-options',
			'title' => 'Theme Slide Options',
			'fields' => array (
				array (
					'key' => 'field_528a27f8c2728',
					'label' => 'Hide text on this slide?',
					'name' => 'hide_slide_text',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 0,
				),
				array (
					'key' => 'field_528a2c129a501',
					'label' => 'Rotating text for title',
					'name' => 'pirenko_rotating_text',
					'type' => 'textarea',
					'instructions' => 'Optional. Separate the additional strings with a plus (+) sign.',
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'formatting' => 'html',
				),
				array (
					'key' => 'field_6969jd2867a62',
					'label' => 'Text rotator effect',
					'name' => 'pirenko_rotating_effect',
					'type' => 'select',
					'choices' => array (
						'old_timey' => 'Smooth shift',
						'rotate-1' => '3D effect',
						'rotate-2 letters' => 'Fast character rotation',
						'slide' => 'Slide',
						'zoom' => 'Zoom',
						'rotate-3 letters' => 'Character shift',
						'scale letters' => 'Scale',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_528a92ab22728',
					'label' => 'Limit text width to be the same as the content width?',
					'name' => 'limit_text_width',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 1,
				),
				array (
					'key' => 'field_528a2845c2729',
					'label' => 'Text size',
					'name' => 'slide_text_size',
					'type' => 'select',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'choices' => array (
						'medium' => 'Small',
						'big' => 'Medium',
						'huge' => 'Big',

					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_528a291519de2',
					'label' => 'Text horizontal position',
					'name' => 'slide_text_horz',
					'type' => 'select',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'choices' => array (
						'left' => 'Left',
						'center' => 'Center',
						'right' => 'Right',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_528a2ac019de3',
					'label' => 'Text vertical position',
					'name' => 'slide_text_vert',
					'type' => 'select',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'choices' => array (
						'top' => 'Top',
						'v_center' => 'Center',
						'bottom' => 'Bottom',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_528a2b2c9e31d',
					'label' => 'Title color',
					'name' => 'pirenko_sh_slide_header_color',
					'type' => 'color_picker',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
				),
				array (
					'key' => 'field_528a2be3faca0',
					'label' => 'Title background color',
					'name' => 'pirenko_sh_slide_header_bk_color',
					'type' => 'color_picker',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
				),
				array (
					'key' => 'field_528a3189b5dfd',
					'label' => 'Title background opacity',
					'name' => 'title_background_color_opacity',
					'type' => 'number',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => 90,
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => 0,
					'max' => 100,
					'step' => 5,
				),
				array (
					'key' => 'field_5286434dec69e',
					'label' => 'Title extra CSS classes',
					'name' => 'title_css',
					'type' => 'text',
					'instructions' => '(optional)',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_528a2b539dd5e',
					'label' => 'Body color',
					'name' => 'pirenko_sh_slide_body_color',
					'type' => 'color_picker',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
				),
				array (
					'key' => 'field_528a2c014281d',
					'label' => 'Body background color',
					'name' => 'pirenko_sh_slide_body_bk_color',
					'type' => 'color_picker',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
				),
				array (
					'key' => 'field_528a34adb897f',
					'label' => 'Body background opacity',
					'name' => 'body_background_color_opacity',
					'type' => 'number',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a27f8c2728',
								'operator' => '!=',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => 90,
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => 0,
					'max' => 100,
					'step' => 5,
				),
				array (
					'key' => 'field_528a2c440f501',
					'label' => 'Video HTML code',
					'name' => 'pirenko_sh_video',
					'type' => 'textarea',
					'instructions' => 'optional',
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'formatting' => 'html',
				),
				array (
					'key' => 'field_528a2ccac3848',
					'label' => 'Open this URL when slide/button is clicked',
					'name' => 'pirenko_sh_slide_url',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				array (
					'key' => 'field_528a2c5d0f502',
					'label' => 'Show action button under the text?',
					'name' => 'pirenko_sh_slide_show_button',
					'type' => 'true_false',
					'message' => '',
					'default_value' => 0,
				),
				array (
					'key' => 'field_528a2b2c9d45e',
					'label' => 'Action button background color',
					'name' => 'pirenko_sh_slide_button_color',
					'type' => 'color_picker',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a2c5d0f502',
								'operator' => '==',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
				),
				array (
					'key' => 'field_528a2caac3847',
					'label' => 'Action button text',
					'name' => 'pirenko_sh_slide_button_label',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_528a2c5d0f502',
								'operator' => '==',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_528a2d2867a62',
					'label' => 'Open link in',
					'name' => 'pirenko_sh_slide_wdw',
					'type' => 'select',
					'choices' => array (
						'_self' => 'Same window',
						'_blank' => 'New window',
					),
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_850b2c5d0f502',
					'label' => 'Show scroll button on the lower part of the slide?',
					'name' => 'pirenko_scroll_button',
					'type' => 'true_false',
					'message' => 'Useful for pages with navigation anchors (Mini Sites)',
					'default_value' => 0,
				),
				array (
					'key' => 'field_528a2448a3847',
					'label' => 'Scroll button text',
					'name' => 'pirenko_scroll_button_label',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_850b2c5d0f502',
								'operator' => '==',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_528a22ba5d45e',
					'label' => 'Scroll button color',
					'name' => 'pirenko_scroll_button_color',
					'type' => 'color_picker',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_850b2c5d0f502',
								'operator' => '==',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
				),
				array (
					'key' => 'field_528a22ba5a73b',
					'label' => 'Scroll button lower arrow color',
					'name' => 'pirenko_scroll_button_arrow_color',
					'type' => 'color_picker',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_850b2c5d0f502',
								'operator' => '==',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
				),
				array (
					'key' => 'field_528a02aca3847',
					'label' => 'Scroll button link',
					'name' => 'pirenko_scroll_button_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_850b2c5d0f502',
								'operator' => '==',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'instructions' => 'Example: #about-us',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'pirenko_slides',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'default',
				'hide_on_screen' => array (
					0 => 'custom_fields',
				),
			),
			'menu_order' => 0,
		));
	}

?>