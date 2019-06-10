<?php
	/*
		Plugin Name: Fount Social Links 
		Plugin URI: http://www.pirenko.com/
		Description: A widget to add social network links to your website.
		Version: 1.0
		Author: Pirenko
		Author URI: http://www.pirenko.com/
	*/
	
	//ADD WIDGET LOADING
	add_action( 'widgets_init', 'load_pirenko_social' );
	//REGISTER WIDGET
	function load_pirenko_social() {
		register_widget( 'pirenko_social_widget' );
	}
	//CREATE CLASS TO CONTROL EVERYTHING
	class pirenko_social_widget extends WP_Widget {
		//SET UP WIDGET
		function __construct() {
			$widget_ops = array( 'classname' => 'pirenko-social-widget', 'description' => ('A widget to add social network links to your website.') );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'pirenko-social-widget' );
			parent::__construct( 'pirenko-social-widget', __('Fount : Social Links ', 'fount'), $widget_ops, $control_ops );
		}

		
		var $imgs_url;
		var $z_social_title;
		var $pir_icons;
		var $tips;
		function fields_array( $instance = array() ) 
		{
			$this->imgs_url = plugins_url( '/icons/colored/' , __FILE__ );
			return array(			
				'behance' => array(
					'title' => __('Behance URL', 'astro_lang'),
					'img' => sprintf( '%sbehance.png', '' ),
					'img_widget' => sprintf( '%sbehance.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'behance',
					'img_color' => '#2d9ad2',
					'img_title' => __('Behance', 'astro_lang')
				),
				'digg' => array(
					'title' => __('Digg URL', 'fount'),
					'img' => sprintf( '%sdigg.png', '' ),
					'img_widget' => sprintf( '%sdigg.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'digg',
					'img_color' => '#24578e',
					'img_title' => __('Digg', 'fount')
				),
				'dribbble' => array(
					'title' => __('Dribbble URL', 'fount'),
					'img' => sprintf( '%sdribbble.png', '' ),
					'img_widget' => sprintf( '%sdribbble.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'dribbble',
					'img_color' => '#ea4c89',
					'img_title' => __('Dribbble', 'fount')
				),
				'facebook' => array(
					'title' => __('Facebook URL', 'fount'),
					'img' => sprintf( '%sfacebook.png', '' ),
					'img_widget' => sprintf( '%sfacebook.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'facebook',
					'img_color' => '#1f69b3',
					'img_title' => __('Facebook', 'fount')
				),
				'flickr' => array(
					'title' => __('Flickr URL', 'fount'),
					'img' => sprintf( '%sflickr.png', '' ),
					'img_widget' => sprintf( '%sflickr.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'flickr',
					'img_color' => '#fd0083',
					'img_title' => __('Flickr', 'fount')
				),
				'google_plus' => array(
					'title' => __('Google Plus URL', 'fount'),
					'img' => sprintf( '%sgoogle_plus.png', '' ),
					'img_widget' => sprintf( '%sgoogle_plus.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'google-plus',
					'img_color' => '#333333',
					'img_title' => __('Google Plus', 'fount')
				),
				'instagram' => array(
					'title' => __('Instagram URL', 'fount'),
					'img' => sprintf( '%sinstagram.png', '' ),
					'img_widget' => sprintf( '%sinstagram.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'instagram',
					'img_color' => '#3f729b',
					'img_title' => __('Instagram', 'fount')
				),
				'linkedin' => array(
					'title' => __('Linkedin URL', 'fount'),
					'img' => sprintf( '%slinkedin.png', '' ),
					'img_widget' => sprintf( '%slinkedin.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'linkedin',
					'img_color' => '#1a7696',
					'img_title' => __('Linkedin', 'fount')
				),
				'pinterest' => array(
					'title' => __('Pinterest URL', 'fount'),
					'img' => sprintf( '%spinterest.png', '' ),
					'img_widget' => sprintf( '%spinterest.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'pinterest',
					'img_color' => '#df2126',
					'img_title' => __('Pinterest', 'fount')
				),
				'skype' => array(
					'title' => __('Skype URL', 'fount'),
					'img' => sprintf( '%sskype.png', '' ),
					'img_widget' => sprintf( '%sskype.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'skype',
					'img_color' => '#28a9ed',
					'img_title' => __('Skype', 'fount')
				),
				'soundcloud' => array(
					'title' => __('Soundlcloud URL', 'fount'),
					'img' => sprintf( '%ssoundcloud.png', '' ),
					'img_widget' => sprintf( '%ssoundcloud.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'soundcloud',
					'img_color' => '#ef4e23',
					'img_title' => __('Soundlcloud', 'fount')
				),
				'tumblr' => array(
					'title' => __('Tumblr URL', 'fount'),
					'img' => sprintf( '%stumblr.png', '' ),
					'img_widget' => sprintf( '%stumblr.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'tumblr',
					'img_color' => '#374a61',
					'img_title' => __('Tumblr', 'fount')
				),
				'twitter' => array(
					'title' => __('Twitter URL', 'fount'),
					'img' => sprintf( '%stwitter.png', '' ),
					'img_widget' => sprintf( '%stwitter.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'twitter',
					'img_color' => '#43b3e5',
					'img_title' => __('Twitter', 'fount')
				),
				'vimeo' => array(
					'title' => __('Vimeo URL', 'fount'),
					'img' => sprintf( '%svimeo.png', '' ),
					'img_widget' => sprintf( '%svimeo.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'vimeo-square',
					'img_color' => '#4ab2d9',
					'img_title' => __('Vimeo', 'fount')
				),
				'youtube' => array(
					'title' => __('YouTube URL', 'fount'),
					'img' => sprintf( '%syoutube.png', '' ),
					'img_widget' => sprintf( '%syoutube.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'youtube',
					'img_color' => '#fb2d39',
					'img_title' => __('Youtube', 'fount')
				),
				'feedburner' => array(
					'title' => __('RSS/Feedburner URL', 'fount'),
					'img' => sprintf( '%srss.png', '' ),
					'img_widget' => sprintf( '%srss.png', $this->imgs_url . esc_attr( $instance['icon_set'] ) ),
					'img_class' => 'rss',
					'img_color' => '#ed8333',
					'img_title' => __('RSS Feed', 'fount')
				),	
			);
		}
		//SET UP WIDGET OUTPUT
		function widget( $args, $instance ) 
		{
			extract($args);
			//GRAB CURRENT VALUES
			$instance = wp_parse_args($instance, array(
				'title' => '',
				'new_window' => 0,
				'icon_set' => '',
				'size' => '24x24'
			) );
			//BEFORE WIDGET CODE
			echo $before_widget;	
			//DISPLAY TITLE IF NECESSARY
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			if ($title!="") {
				echo $before_title . $title . $after_title;
			}
			//DISPLAY LINKS
			$c_color="";
			?>
			<div class="pirenko_social <?php echo $instance['pir_icons']; ?>">
				<div class="pirenko_social_inner">
				<?php
				$tips_class="";
				//if (isset($instance['tips']) && $instance['tips']=="yes")
					//$tips_class='class="tipped"';
				$big_icons="";
				if ($instance['pir_icons']=="rounded_large")
					$big_icons="big_icons";	
				$new_window="target='_blank'";
				$inside_counter=1;
				$sizer=34;
				if ($instance['pir_icons'] == 'minimal') 
				{
					$sizer=24;
					foreach ( $this->fields_array( $instance ) as $key => $data ) 
					{
						if ( ! empty ( $instance[$key] ) ) 
						{
							printf( '<div class="social_img_wrp fount_socialink prk_bordered fount-%s"><a href="%s" title="%s" %s %s data-color="%s"><div class="prk_minimal_icon zocial fount-icon fount-%s fount_fa-%s"></div><div class="bg_shifter"><i class="fount_fa-%s"></i></div></a></div>',$data['img_class'],$instance[$key], esc_attr( $data['img_title'] ), $new_window , $tips_class,$data['img_color'],$data['img_class'],$data['img_class'],$data['img_class']);
							$inside_counter++;
						}
					}
				}
				if ($instance['pir_icons'] == 'colored') 
				{
					$sizer=24;
					foreach ( $this->fields_array( $instance ) as $key => $data ) 
					{
						if ( ! empty ( $instance[$key] ) ) 
						{
							printf( '<div class="social_img_wrp"><a href="%s" title="%s" %s %s><div class="prk_with_back zocial fount-icon fount-%s fount_fa fount_fa-%s"></div></a></div>',( $instance[$key] ), esc_attr( $data['img_title'] ), $new_window , $tips_class,$data['img_class'],$data['img_class']);
							$inside_counter++;
						}
					}
				}
				if ($instance['pir_icons'] == 'rounded') 
				{
					$sizer=34;
					foreach ( $this->fields_array( $instance ) as $key => $data ) 
					{
						if ( ! empty ( $instance[$key] ) ) 
						{
							printf( '<div class="social_img_wrp" style="width:%spx;height:%spx;float:left;"><a href="%s" title="%s" %s %s><img src="%s" class="pir_icons %s" width="%s" height="%s" alt="" /></a></div>', $sizer,$sizer,( $instance[$key] ), esc_attr( $data['img_title'] ), $new_window , $tips_class, plugins_url( '/icons/' , __FILE__ ).$instance['pir_icons'].'/'.$data['img'], $big_icons,$sizer,$sizer );
							$inside_counter++;
						}
					}
				}
				if ($instance['pir_icons'] == 'squared') 
				{
					$sizer=34;
					foreach ( $this->fields_array( $instance ) as $key => $data ) 
					{
						if ( ! empty ( $instance[$key] ) ) 
						{
							printf( '<div class="social_img_wrp" style="width:%spx;height:%spx;float:left;"><a href="%s" title="%s" %s %s><img src="%s" class="pir_icons %s" width="%s" height="%s" alt="" /></a></div>', $sizer,$sizer,( $instance[$key] ), esc_attr( $data['img_title'] ), $new_window , $tips_class, plugins_url( '/icons/' , __FILE__ ).$instance['pir_icons'].'/'.$data['img'], $big_icons,$sizer,$sizer );
							$inside_counter++;
						}
					}
				}
				?>
				</div>
			</div>
			<?php
			//AFTER WIDGET CODE
			echo $after_widget;
		}
		//UPDATE WIDGET SETTINGS
		function update( $new_instance, $old_instance ) 
		{
			return $new_instance;
		}
		//SET UP WIDGET FORM ON THE CONTROL PANEL
		function form( $instance ) 
		{
			
			$instance = wp_parse_args($instance, array(
				'title' => '',
				'new_window' => 0,
				'icon_set' => '',
				'size' => '24x24',
				'c_color' => ''
			) ); 
			if (isset($instance['tips']))
				$tips=$instance['tips'];
			else
				$tips="yes";
			$instance['tips']=$tips;
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'fount'); ?>:</label><br />
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" class="pct_89" />
			</p>
            <p>
				<label for="<?php echo $this->get_field_id('pir_icons'); ?>"><?php _e('Icons style', 'fount'); ?>:</label><br />
				<select id="<?php echo $this->get_field_id('pir_icons'); ?>" name="<?php echo $this->get_field_name('pir_icons'); ?>" class="pct_69">
					<?php    
							if ( $instance['pir_icons'] == 'colored' ) // Make default first in list
                                echo "\n\t<option selected='selected' value='colored'>Squared</option>";
                            else
                                echo "\n\t<option value='colored'>Squared</option>";

							if ( $instance['pir_icons'] == 'rounded' ) // Make default first in list
                                echo "\n\t<option selected='selected' value='rounded'>Rounded flat</option>";
                            else
                                echo "\n\t<option value='rounded'>Rounded flat</option>";

							if ( $instance['pir_icons'] == 'squared' ) // Make default first in list
                                echo "\n\t<option selected='selected' value='squared'>Squared flat</option>";
                            else
                                echo "\n\t<option value='squared'>Squared flat</option>";

							if ( $instance['pir_icons'] == 'minimal' ) // Make default first in list
                                echo "\n\t<option selected='selected' value='minimal'>Minimal</option>";
                            else
                                echo "\n\t<option value='minimal'>Minimal</option>";
                    ?>
              	</select>
			</p>
			<?php
			foreach ( $this->fields_array( $instance ) as $key => $data ) 
			{
				$inner_c="";
				if (isset($instance[$key] ))
					$inner_c= $instance[$key] ;
				echo '<p>';
				printf( '<img class="socials_icns" src="%s" title="%s" />', $data['img_widget'], $data['img_title'] );
				printf( '<label for="%s"> %s:</label><br>', esc_attr( $this->get_field_id($key) ), esc_attr( $data['title'] ) );
				if ($data['img_title']!='Skype') {
					printf( '<input id="%s" name="%s" value="%s" style="%s" class="pct_75" />', esc_attr( $this->get_field_id($key) ), esc_attr( $this->get_field_name($key) ), esc_url( $inner_c ), 'width:75%;' );
				}
				else
				{
					printf( '<input id="%s" name="%s" value="%s" style="%s" class="pct_75" />', esc_attr( $this->get_field_id($key) ), esc_attr( $this->get_field_name($key) ), ( $inner_c ), 'width:75%;' );
				}
				echo '</p>' . "\n";
			}
		}
	}
?>