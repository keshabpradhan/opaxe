<?php
	/*
		Plugin Name: Pirenko Recent Custom Post Types
		Plugin URI: http://www.pirenko.com
		Description: A widget to show recent custom post types
		Version: 1.0
		Author: Pirenko
		Author URI: http://www.pirenko.com
	*/
	
	//ADD WIDGET LOADING
	add_action( 'widgets_init', 'load_pirenko_recent_portfolio' );
	//REGISTER WIDGET
	function load_pirenko_recent_portfolio() {
		register_widget( 'pirenko_recent_portfolio_widget' );
	}
	//CREATE CLASS TO CONTROL EVERYTHING
	class pirenko_recent_portfolio_widget extends WP_Widget {
		//SET UP WIDGET
		function __construct() {
			$widget_ops = array( 'classname' => 'pirenko-recent_portfolios-widget', 'description' => ('A widget to show recent custom post types.') );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'pirenko-recent_portfolios-widget' );
			parent::__construct( 'pirenko-recent_portfolios-widget', __('Fount : Recent Custom Post Types', 'pirenko-recent_portfolios-widget'), $widget_ops, $control_ops );
		}

		//SET UP WIDGET OUTPUT
		function widget( $args, $instance ) 
		{
			global $prk_retina_device;
			$retina_flag = $prk_retina_device === "prk_retina" ? true : false;
			extract($args);
			//BEFORE WIDGET CODE
			echo $before_widget;	
			//DISPLAY TITLE IF NECESSARY
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			if ($title!="") {
				echo $before_title . $title. $after_title;
			}
			?>
			<div class="pirenko_recent_portfolios">
                    <?php
						$my_home_query = new WP_Query();
						if (isset($instance['num_items']))
							$num_items = $instance['num_items'];
						else
							$num_items="9";
						if (isset($instance['prk_filter']))
							$prk_filter = $instance['prk_filter'] ;
						else
							$prk_filter="";
						if (isset($instance['layout_type']))
							$layout_type = $instance['layout_type'] ;
						else
							$layout_type="thumbnail_lay";
						if (isset($instance['lightboxed']))
							$lightboxed = $instance['lightboxed'];
						else
							$lightboxed="";
						if (isset($instance['wdg_post_type']))
							$wdg_post_type = $instance['wdg_post_type'] ;
						else
							$wdg_post_type='pirenko_portfolios';
							$args = array (	'post_type' => $wdg_post_type, 
										'showposts' => 99,
										'pirenko_skills'=>$prk_filter
										);
						$my_home_query->query($args);
                        if ($my_home_query->have_posts())
						{
							?>
                       			<ul class="fount_recent_ul<?php echo " ".$layout_type;echo " ".$lightboxed; ?>">
								<?php
									$pst_counter=0;
									while ($my_home_query->have_posts()) : $my_home_query->the_post();
										if ($pst_counter<$num_items)
										{
											if ($layout_type=="thumbnail_lay") {
												if (has_post_thumbnail())
												{
													$pst_counter++;
													$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
													//$image[0] = get_image_path($image[0]);
													$vt_image = vt_resize( get_post_thumbnail_id(), '' , 480, 480, true , $retina_flag );
													?>
													<li class="small-4 medium-4 columns thumbnail_lay left_floated portfolio_entry_li">
														<a href="<?php the_permalink(); ?>" class="fade_anchor" data-mfp-src="<?php echo $image[0]; ?>" data-title="<?php echo get_the_title(); ?>">
														<div class="grid_colored_block"></div>
														<img src="<?php echo $vt_image['url']; ?>" alt="" width="<?php echo $vt_image['width']; ?>" height="<?php echo $vt_image['height']; ?>" />
														</a>
													</li>	
													<?php
												}
											}
											else
											{
												$pst_counter++;
												?>
													<li class="small-12 info_lay">
														<div class="fount_widget_date"><?php the_date(); ?></div>
														<h4 class="small">
															<a href="<?php the_permalink(); ?>" class="small-12 fade_anchor">
																<?php echo get_the_title(); ?>
																<i class="fount_fa-angle-double-right right_floated"></i>
															</a>
														</h4>
														<div class="clearfix"></div>
														<div class="simple_line"></div>
													</li>	
													<?php
											}
										}
									endwhile;
						}
						else
						{
							echo '<div class="clearfix"></div>';
							echo ("No content was found!");	
						}
						wp_reset_query();
                    ?>
                </ul>
                <div class="clearfix"></div>
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
			if (isset($instance['title']))
				$title = $instance['title'] ;
			else
				$title="";
			if (isset($instance['link_type']))
				$link_type = $instance['link_type'];
			else
				$link_type="tags";
			if (isset($instance['num_items']))
				$num_items = $instance['num_items'];
			else
				$num_items="9";
			if (isset($instance['lightboxed']))
				$lightboxed = $instance['lightboxed'];
			else
				$lightboxed="";
			if (isset($instance['prk_filter']))
				$prk_filter = $instance['prk_filter'] ;
			else
				$prk_filter="";
			if (isset($instance['layout_type']))
				$layout_type = $instance['layout_type'] ;
			else
				$layout_type="thumbnail_lay";
			if (isset($instance['wdg_post_type']))
				$wdg_post_type = $instance['wdg_post_type'] ;
			else
				$wdg_post_type='pirenko_portfolios';
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'spw'); ?>:</label><br />
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="pct_89" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('wdg_post_type'); ?>"><?php _e('Post type?', 'spw'); ?></label><br />
				<select id="<?php echo $this->get_field_id('wdg_post_type'); ?>" name="<?php echo $this->get_field_name('wdg_post_type'); ?>" class="possibly_hider pct_69">
				<?php
					$post_types=get_post_types('', 'names'); 
					foreach ($post_types as $post_type) {
						if ($wdg_post_type==$post_type) {
							echo '<option selected="selected" value='.$post_type.'>'.$post_type.'</option>';
						}
						else
							echo '<option value='.$post_type.'>'.$post_type.'</option>';
					}
				?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('layout_type'); ?>"><?php _e('Show thumbnail or title and date?', 'spw'); ?></label><br />
				<select id="<?php echo $this->get_field_id('layout_type'); ?>" name="<?php echo $this->get_field_name('layout_type'); ?>" class="possibly_hider pct_69">
					<?php   
						if ( $layout_type == 'thumbnail_lay' ) // Make default first in list
                        	echo "\n\t<option selected='selected' value='thumbnail_lay'>Thumbnail</option>";
                       	else
                          	echo "\n\t<option value='thumbnail_lay'>Thumbnail</option>";
                      	if ( $layout_type == 'info_lay' ) // Make default first in list
                        	echo "\n\t<option selected='selected' value='info_lay'>Title and date</option>";
                       	else
                         	echo "\n\t<option value='info_lay'>Title and date</option>";
							
                    ?>
              	</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('lightboxed'); ?>"><?php _e('Thumbnails open lightbox?', 'spw'); ?></label><br />
				<select id="<?php echo $this->get_field_id('lightboxed'); ?>" name="<?php echo $this->get_field_name('lightboxed'); ?>" class="possibly_hider pct_69">
					<?php   
						if ( $lightboxed == '' )
                        	echo "\n\t<option selected='selected' value=''>No</option>";
                       	else
                          	echo "\n\t<option value=''>No</option>";
                      	if ( $lightboxed == 'fount_widget_gallery' )
                        	echo "\n\t<option selected='selected' value='fount_widget_gallery'>Yes</option>";
                       	else
                         	echo "\n\t<option value='fount_widget_gallery'>Yes</option>";
							
                    ?>
              	</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('prk_filter'); ?>"><?php _e('Filter (optional)', 'spw'); ?>:</label><br />
				<input id="<?php echo $this->get_field_id('prk_filter'); ?>" name="<?php echo $this->get_field_name('prk_filter'); ?>" value="<?php echo $prk_filter; ?>" class="pct_89" />
				<br />
				<span class="description">Use skills slug (comma separated)</span>
			</p>
            <p>
				<label for="<?php echo $this->get_field_id( 'num_items' ); ?>">Number of entries:</label>
				<input id="<?php echo $this->get_field_id( 'num_items' ); ?>" name="<?php echo $this->get_field_name( 'num_items' ); ?>" value="<?php echo $num_items; ?>" class="pct_89" />
			</p>
			<?php
			
		}
	}
?>