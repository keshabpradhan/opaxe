<?php
	/*
		Plugin Name: Pirenko Advertising Widget
		Plugin URI: http://www.pirenko.com
		Description: A widget to diplay one advertisement
		Version: 1.2
		Author: Pirenko
		Author URI: http://www.pirenko.com
	*/
	
	//ADD WIDGET LOADING
	add_action( 'widgets_init', create_function( '', 'return register_widget( "Pirenko_Advertising_Widget" );' ) );
	
	//CREATE CLASS TO CONTROL EVERYTHING
	class pirenko_advertising_widget extends WP_Widget {
		//SET UP WIDGET
		function __construct() {
			$widget_ops = array( 'classname' => 'pirenko-advertising-widget', 'description' => ('A widget to diplay one advertisement.') );
			$control_ops = array( 'width' => 255, 'height' => 460, 'id_base' => 'pirenko-advertising-widget' );
			parent::__construct( 'pirenko-advertising-widget', __('Stamp: Advertising Widget ', 'stamp_lang'), $widget_ops, $control_ops );
		}
		function update($new_instance, $old_instance) 
		{
			$instance = $old_instance;
		    $instance['title'] = strip_tags($new_instance['title']);
			$instance['advert_url'] = strip_tags($new_instance['advert_url']);
			$instance['image_path'] = strip_tags($new_instance['image_path']);
			$instance['advert_body'] = strip_tags($new_instance['advert_body']);

		    if (function_exists('icl_translate')) { 
				icl_translate('stamp_lang', 'widget_title', $instance['title']); 
			 	icl_translate('stamp_lang', 'ads_advert_url', $instance['advert_url']);
			 	icl_translate('stamp_lang', 'ads_widget_image_path', $instance['image_path']);
			 	icl_translate('stamp_lang', 'ads_widget_advert_body', $instance['advert_body']);
			}
		    return $instance;
		}
		//SET UP WIDGET FORM ON THE CONTROL PANEL
		function form( $instance ) 
		{
			if (isset($instance['title']))
				$title=$instance['title'];
			else
				$title="";
			if (isset($instance['advert_body']))
				$advert_body=$instance['advert_body'];
			else
				$advert_body="";
			if (isset($instance['image_path']))
				$image_path=$instance['image_path'];
			else
				$image_path="";
			if (isset($instance['advert_url']))
			$advert_url=$instance['advert_url'];
			else
				$advert_url="";
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
            <p>
				<label for="<?php echo $this->get_field_id( 'advert_body' ); ?>">Advertisement Text:</label>
				<textarea class="widefat" rows="12" id="<?php echo $this->get_field_id( 'advert_body' ); ?>" name="<?php echo $this->get_field_name( 'advert_body' ); ?>" type="text"><?php echo esc_attr($advert_body); ?></textarea>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'advert_url' ); ?>">Advertisement Link:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'advert_url' ); ?>" name="<?php echo $this->get_field_name( 'advert_url' ); ?>" type="text" value="<?php echo esc_attr($advert_url); ?>" />
			</p>
			<p>
				<label>Advertisement Image URL Path:</label>
				<input class="widefat" id="prk_ads_image" name="<?php echo $this->get_field_name( 'image_path' ); ?>" type="text" value="<?php echo $image_path; ?>" />
				<?php
				if ($image_path!="")
				{
					?>
					<br />
					<br />
					<label for="<?php echo $this->get_field_id( 'image_path' ); ?>">Advertisement Image:</label>
					<img id="zuper_ads_image_image" src="<?php echo $image_path; ?>" width="200" />
					<?php
				}
				?>
				<br /><br />
			</p>
			
			<?php
		}
		//RENDER WIDGET IN THE SIDEBAR
		function widget( $args, $instance ) {
			extract($args);
			echo $args['before_widget'];
			echo ("<div id='pirenko_ads'>");
			//DISPLAY TITLE IF NECESSARY
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			if ($title!="") {
				echo $before_title . $title . $after_title;
			}
			if(function_exists('icl_translate')) {
				if (!isset($instance['advert_url'])) { 
					$instance['advert_url'] = ''; 
				} 
				else { 
					$instance['advert_url'] = icl_translate( 'stamp_lang', 'ads_advert_url', $instance['advert_url'] ); 
				}
				if (!isset($instance['image_path'])) { 
					$instance['image_path'] = ''; 
				} 
				else { 
					$instance['image_path'] = icl_translate( 'stamp_lang', 'ads_widget_image_path', $instance['image_path'] ); 
				}
				if (!isset($instance['advert_body'])) { 
					$instance['advert_body'] = ''; 
				} 
				else { 
					$instance['advert_body'] = icl_translate( 'stamp_lang', 'ads_widget_advert_body', $instance['follow_text'] ); 
				}
			} else {
				if (!isset($instance['advert_url'])) { 
					$instance['advert_url'] = ''; 
				}
				if (!isset($instance['image_path'])) { 
					$instance['image_path'] = ''; 
				}
				if (!isset($instance['advert_body'])) { 
					$instance['advert_body'] = ''; 
				}
			}
			if ($instance['image_path']!='')
			{
				printf( '<a href="%s" target="_blank" class="small-12"><img src="%s" title="advertisement" class="boxed_shadow adv_img" alt="" /></a>', esc_attr($instance['advert_url']), esc_attr($instance['image_path']) );
				
				if( function_exists('icl_translate')){
					echo "<p>";
					echo icl_translate( 'stamp_lang', 'advertising_widget_body', $instance['advert_body'] );
					echo "</p>";
				} else {
					echo "<p>".$instance['advert_body']."</p>";
				}
			}
			else
			{
				echo "<p>". __('No image was specified!', 'stamp_lang') ."</p>";
				
				if( function_exists('icl_translate')){
					echo "<p>";
					echo icl_translate( 'stamp_lang', 'advertising_widget_body', $instance['advert_body'] );
					echo "</p>";
				} else {
					echo "<p>".$instance['advert_body']."</p>";
				}
			}
			//CLOSE SUBDIV FOR WIDGET
			echo ('<div class="clearfix"></div></div>');
			echo $args['after_widget'];
		}
	};
?>