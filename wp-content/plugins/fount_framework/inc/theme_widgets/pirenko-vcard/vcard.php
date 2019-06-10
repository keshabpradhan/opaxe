<?php
	/*
		Plugin Name: Pirenko vCard
		Plugin URI: http://www.pirenko.com
		Description: A widget to show some generic info about an entity.
		Version: 1.5
		Author: Pirenko
		Author URI: http://www.pirenko.com
	*/
	
	//ADD WIDGET LOADING
	add_action( 'widgets_init', 'load_pirenko_vcard' );
	//REGISTER WIDGET
	function load_pirenko_vcard() {
		register_widget('fount_Vcard_Widget');
	}
	class fount_Vcard_Widget extends WP_Widget {
	  	//SET UP WIDGET
	  	function __construct() {
			$widget_ops = array('classname' => 'widget_fount_vcard', 'description' => __('Use this widget to add a vCard', 'fount'));
			parent::__construct('widget_fount_vcard', __('Fount: vCard', 'fount'), $widget_ops);
			$this->alt_option_name = 'widget_fount_vcard';
		
	  	}

	  	function widget($args, $instance) 
		{
			$cache = wp_cache_get('widget_fount_vcard', 'widget');
		
			if (!is_array($cache)) {
			  $cache = array();
			}
		
			if (!isset($args['widget_id'])) {
			  $args['widget_id'] = null;
			}
		
			if (isset($cache[$args['widget_id']])) {
			  echo $cache[$args['widget_id']];
			  return;
			}

			ob_start();
			extract($args, EXTR_SKIP);
		
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			
			if(function_exists('icl_translate')){
				if (!isset($instance['description_text'])) { $instance['description_text'] = ''; } else { $instance['description_text'] = icl_translate( 'fount', 'vcard_widget_description_text', $instance['description_text'] ); }
				if (!isset($instance['company_name'])) { $instance['company_name'] = ''; } else { $instance['company_name'] = icl_translate( 'fount', 'vcard_widget_company_name', $instance['company_name'] ); }
				if (!isset($instance['street_address'])) { $instance['street_address'] = ''; } else { $instance['street_address'] = icl_translate( 'fount', 'vcard_widget_street_address', $instance['street_address'] ); }
				if (!isset($instance['locality'])) { $instance['locality'] = ''; } else { $instance['locality'] = icl_translate( 'fount', 'vcard_widget_locality', $instance['locality'] ); }
				if (!isset($instance['postal_code'])) { $instance['postal_code'] = ''; } else {  $instance['postal_code'] = icl_translate( 'fount', 'vcard_widget_postal_code', $instance['postal_code'] ); }
				if (!isset($instance['tel'])) { $instance['tel'] = ''; } else {  $instance['tel'] = icl_translate( 'fount', 'vcard_widget_company_tel', $instance['tel'] ); }
				if (!isset($instance['fax'])) { $instance['fax'] = ''; } else {  $instance['fax'] = icl_translate( 'fount', 'vcard_widget_company_fax', $instance['fax'] ); }
				if (!isset($instance['hours'])) { $instance['hours'] = ''; } else {  $instance['hours'] = icl_translate( 'fount', 'vcard_widget_company_hours', $instance['hours'] ); }
				if (!isset($instance['email'])) { $instance['email'] = ''; } else {  $instance['email'] = icl_translate( 'fount', 'vcard_widget_company_email', $instance['email'] ); }
			
			} else {
				if (!isset($instance['description_text'])) { $instance['description_text'] = ''; }
				if (!isset($instance['company_name'])) { $instance['company_name'] = ''; }
				if (!isset($instance['street_address'])) { $instance['street_address'] = ''; }
				if (!isset($instance['locality'])) { $instance['locality'] = ''; }
				if (!isset($instance['postal_code'])) { $instance['postal_code'] = ''; }
				if (!isset($instance['tel'])) { $instance['tel'] = ''; }
				if (!isset($instance['fax'])) { $instance['fax'] = ''; }
				if (!isset($instance['hours'])) { $instance['hours'] = ''; }
				if (!isset($instance['email'])) { $instance['email'] = ''; }
			}
			
			echo $before_widget;
			if ($title) {
			  	echo $before_title;
			  	echo $title;
			  	echo $after_title;
	    	}
	  	?>
	    <div class="fount_vcard">
	    	<?php 
				if ($instance['image_path']!="")
				{
					?>
					<img src="<?php echo $instance['image_path']; ?>" alt="" class="fount_vcard_logo" />
					<?php
				}
				if ($instance['description_text']!="")
				{
					echo '<div class="small-12 fount_vcard_description"><div class="wpb_text_column">'.$instance['description_text'].'</div></div>';
				}
			?>
	      	<div class="adr clearfix">
	            <?php 
					if ($instance['company_name']!="")
					{
						?>
						<div class="fount_vcard_title header_font prk_heavier_700 not_zero_color"><?php echo $instance['company_name']; ?></div>
						<?php
					}
					if ($instance['street_address']!="" || $instance['locality']!="" || $instance['postal_code']!="")
					{
						echo '<i class="fount_fa-map-marker fount_address_icon prk_less_opacity"></i>';
					}
					if ($instance['street_address']!="")
					{
						?>
						<div class="street-address fount_after_vcard_icon"><?php echo $instance['street_address']; ?></div>
	                    <?php
					}
					if ($instance['locality']!="")
					{
						?>
						<div class="locality fount_after_vcard_icon"><?php echo $instance['locality'];?></div>
						<?php
					}
					if ($instance['postal_code']!="")
					{
						?>
						<div class="postal-code fount_after_vcard_icon"><?php echo $instance['postal_code']; ?></div>
						<?php
					}
				?>
	      	</div>
			<?php 
				if ($instance['tel']!="")
				{
					?>
		            <div class="fount_vcard_block">
		            	<i class="fount_fa-phone fount_address_icon prk_less_opacity"></i>
		                <div class="fount_after_vcard_icon">
		                	<?php echo $instance['tel']; ?>
		                </div>
		            </div>
		            <div class="clearfix"></div>
		            <?php
				}
				if ($instance['fax']!="")
				{
					?>
		            <div class="fount_vcard_block">
		            	<i class="fount_fa-print fount_address_icon prk_less_opacity"></i>
		                <div class="fount_after_vcard_icon">
		                	<?php echo $instance['fax']; ?>
		                </div>
		            </div>
		            <div class="clearfix"></div>
		            <?php
				}
				if ($instance['hours']!="")
				{
					?>
		            <div class="fount_vcard_block">
		            	<i class="fount_fa-clock-o fount_address_icon prk_less_opacity"></i>
		                <div class="fount_after_vcard_icon">
		                	<?php echo $instance['hours']; ?>
		                </div>
		            </div>
		            <div class="clearfix"></div>
		            <?php
				}
				if ($instance['email']!="")
				{
					?>
		            <div class="fount_vcard_block">
		            	<i class="fount_fa-envelope fount_address_icon prk_less_opacity"></i>
		                <div class="fount_after_vcard_icon">
			                <a href="mailto:<?php echo antispambot($instance['email']); ?>" class="default_color"><?php echo antispambot($instance['email']); ?></a>
			            </div>
		            </div>
		            <div class="clearfix"></div>
		            <?php
				}
	        ?>
	        <div class="clearfix"></div>  
	    </div>
	  	<?php
	    echo $after_widget;
	    $cache[$args['widget_id']] = ob_get_flush();
	    wp_cache_set('widget_fount_vcard', $cache, 'widget');
	}

	function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
	    $instance['title'] = strip_tags($new_instance['title']);
		$instance['image_path'] = strip_tags($new_instance['image_path']);
		$instance['description_text'] = strip_tags($new_instance['description_text']);
		$instance['company_name'] = strip_tags($new_instance['company_name']);
	    $instance['street_address'] = strip_tags($new_instance['street_address']);
	    $instance['locality'] = strip_tags($new_instance['locality']);
	    $instance['postal_code'] = strip_tags($new_instance['postal_code']);
	    $instance['tel'] = strip_tags($new_instance['tel']);
	    $instance['fax'] = strip_tags($new_instance['fax']);
	    $instance['hours'] = $new_instance['hours'];
	    $instance['email'] = strip_tags($new_instance['email']);

	    if (function_exists('icl_translate')) { 
			icl_translate('fount', 'widget_title', $instance['title']); 
		 	icl_translate('fount', 'vcard_widget_description_text', $instance['description_text']);
		 	icl_translate('fount', 'vcard_widget_company_name', $instance['company_name']);
		 	icl_translate('fount', 'vcard_widget_street_address', $instance['street_address']);
		 	icl_translate('fount', 'vcard_widget_locality', $instance['locality']);
		 	icl_translate('fount', 'vcard_widget_postal_code', $instance['postal_code']);
		 	icl_translate('fount', 'vcard_widget_company_tel', $instance['tel']);
		 	icl_translate('fount', 'vcard_widget_company_fax', $instance['fax']);
		 	icl_translate('fount', 'vcard_widget_company_hours', $instance['hours']);
		 	icl_translate('fount', 'vcard_widget_company_email', $instance['email']);
		}

	    return $instance;
	}

	function form($instance) 
  	{
    	$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$image_path = isset($instance['image_path']) ? esc_attr($instance['image_path']) : '';
		$description_text = isset($instance['description_text']) ? esc_attr($instance['description_text']) : '';
    	$company_name = isset($instance['company_name']) ? esc_attr($instance['company_name']) : '';
		$street_address = isset($instance['street_address']) ? esc_attr($instance['street_address']) : '';
    	$locality = isset($instance['locality']) ? esc_attr($instance['locality']) : '';
    	$postal_code = isset($instance['postal_code']) ? esc_attr($instance['postal_code']) : '';
    	$tel = isset($instance['tel']) ? esc_attr($instance['tel']) : '';
    	$fax = isset($instance['fax']) ? esc_attr($instance['fax']) : '';
    	$hours = isset($instance['hours']) ? esc_attr($instance['hours']) : '';
    	$email = isset($instance['email']) ? esc_attr($instance['email']) : '';
  		?>
    	<p>
      		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title (optional):', 'fount'); ?></label>
      		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    	</p>
        <p>
				<label>Image URL Path:</label>
				<input class="widefat" id="prk_vcard_image" name="<?php echo $this->get_field_name( 'image_path' ); ?>" type="text" value="<?php echo $image_path; ?>" />
				<?php
				if ($image_path!="")
				{
					?>
					<br />
					<img id="prk_vcard_image_image" src="<?php echo $image_path; ?>" width="200" />
					<?php
				}
				?>
				<br />
			</p>
		<p>
      		<label for="<?php echo esc_attr($this->get_field_id('description_text')); ?>"><?php _e('Description text (optional):', 'fount'); ?></label>
      		<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description_text')); ?>" name="<?php echo esc_attr($this->get_field_name('description_text')); ?>" type="text"><?php echo esc_attr($description_text); ?></textarea>
    	</p>
        <p>
      		<label for="<?php echo esc_attr($this->get_field_id('company_name')); ?>"><?php _e('Company Name:', 'fount'); ?></label>
      		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('company_name')); ?>" name="<?php echo esc_attr($this->get_field_name('company_name')); ?>" type="text" value="<?php echo esc_attr($company_name); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr($this->get_field_id('street_address')); ?>"><?php _e('Street Address:', 'fount'); ?></label>
      		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('street_address')); ?>" name="<?php echo esc_attr($this->get_field_name('street_address')); ?>" type="text" value="<?php echo esc_attr($street_address); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr($this->get_field_id('locality')); ?>"><?php _e('City/Locality:', 'fount'); ?></label>
      		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('locality')); ?>" name="<?php echo esc_attr($this->get_field_name('locality')); ?>" type="text" value="<?php echo esc_attr($locality); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr($this->get_field_id('postal_code')); ?>"><?php _e('Zipcode/Postal Code:', 'fount'); ?></label>
      		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('postal_code')); ?>" name="<?php echo esc_attr($this->get_field_name('postal_code')); ?>" type="text" value="<?php echo esc_attr($postal_code); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr($this->get_field_id('tel')); ?>"><?php _e('Telephone:', 'fount'); ?></label>
      		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('tel')); ?>" name="<?php echo esc_attr($this->get_field_name('tel')); ?>" type="text" value="<?php echo esc_attr($tel); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr($this->get_field_id('fax')); ?>"><?php _e('Fax:', 'fount'); ?></label>
      		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('fax')); ?>" name="<?php echo esc_attr($this->get_field_name('fax')); ?>" type="text" value="<?php echo esc_attr($fax); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr($this->get_field_id('hours')); ?>"><?php _e('Opening hours:', 'fount'); ?></label>
      		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('hours')); ?>" name="<?php echo esc_attr($this->get_field_name('hours')); ?>" type="text" value="<?php echo esc_attr($hours); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php _e('Email:', 'fount'); ?></label>
      		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="text" value="<?php echo esc_attr($email); ?>" />
    	</p>
  		<?php
  	}
}
?>