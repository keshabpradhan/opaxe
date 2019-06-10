<?php
	/*
		Plugin Name: Pirenko Recent Posts
		Plugin URI: http://www.pirenko.com
		Description: A widget to show recent blog posts
		Version: 1.0
		Author: Pirenko
		Author URI: http://www.pirenko.com
	*/
	
	//ADD WIDGET LOADING
	add_action( 'widgets_init', 'load_pirenko_recent_posts' );
	//REGISTER WIDGET
	function load_pirenko_recent_posts() {
		register_widget( 'pirenko_recent_posts_widget' );
	}
	//CREATE CLASS TO CONTROL EVERYTHING
	class pirenko_recent_posts_widget extends WP_Widget {
		//SET UP WIDGET
		function __construct() {
			$widget_ops = array( 'classname' => 'pirenko-recent_posts-widget', 'description' => ('A widget to show Recent Posts.') );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'pirenko-recent_posts-widget' );
			parent::__construct( 'pirenko-recent_posts-widget', __('Fount : Recent Posts', 'pirenko-recent_posts-widget'), $widget_ops, $control_ops );
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
				echo $before_title . $title . $after_title;
			}
			?>
			<div class="pirenko_recent_posts">
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
						$args = array (	'post_type' => 'post', 
									'showposts' => 99,
									'category_name'=>$prk_filter
									);
						$my_home_query->query($args);
                        if ($my_home_query->have_posts())
						{
							?>
                       			<ul class="fount_recent_ul <?php echo $layout_type; ?>">
								<?php
									$pst_counter=0;
									while ($my_home_query->have_posts()) : $my_home_query->the_post();
										if ($pst_counter<$num_items)
										{
											if ($layout_type=="thumbnail_lay") 
											{
												if (has_post_thumbnail())
												{
													$pst_counter++;
													$image = wp_get_attachment_image_src( get_post_thumbnail_id(  ), 'full' );
													//$image[0] = get_image_path($image[0]);
													$vt_image = vt_resize( '', $image[0] , 480, 320, true , $retina_flag );
													?>
													<li class="small-12 thumbnail_lay">
														<div class="left_floated img_blogger small-4">
															<a href="<?php the_permalink(); ?>" class="fade_anchor">
																<img src="<?php echo $vt_image['url']; ?>" alt="" width="<?php echo $vt_image['width']; ?>" height="<?php echo $vt_image['height']; ?>" />
															</a>
														</div>
														<div class="left_floated desc_blogger small-8">
															<div class="fount_widget_date small_headings_color">
																<?php echo the_time(get_option('date_format')); ?>
															</div>
															<h6 class="header_font prk_heavier_700">
																<a href="<?php the_permalink(); ?>" class="small-12 fade_anchor">
																	<?php echo get_the_title(); ?>
																</a>
															</h6>
														</div>
														<div class="clearfix"></div>
														<div class="simple_line">
															<a href="<?php the_permalink(); ?>" class="small-12 fade_anchor">
																<i class="fount_fa-angle-double-right right_floated"></i>
															</a>
														</div>
													</li>
													<?php
												}
											}
											else
											{
												$pst_counter++;
												?>
													<li class="small-12 info_lay">
														<div class="fount_widget_date small_headings_color"><?php echo the_time(get_option('date_format')); ?></div>
														<h6 class="header_font prk_heavier_700">
															<a href="<?php the_permalink(); ?>" class="small-12 fade_anchor">
																<?php echo get_the_title(); ?>
																<i class="fount_fa-angle-double-right right_floated"></i>
															</a>
														</h6>
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
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'spw'); ?>:</label><br />
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="pct_89" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('layout_type'); ?>"><?php _e('Show thumbnail or title and date?', 'spw'); ?></label><br />
				<select id="<?php echo $this->get_field_id('layout_type'); ?>" name="<?php echo $this->get_field_name('layout_type'); ?>" class="possibly_hider pct_69">
					<?php   
						if ( $layout_type == 'thumbnail_lay' ) // Make default first in list
                        	echo "\n\t<option selected='selected' value='thumbnail_lay'>Thumbnail, title and date</option>";
                       	else
                          	echo "\n\t<option value='thumbnail_lay'>Thumbnail, title and date</option>";
                      	if ( $layout_type == 'info_lay' ) // Make default first in list
                        	echo "\n\t<option selected='selected' value='info_lay'>Title and date</option>";
                       	else
                         	echo "\n\t<option value='info_lay'>Title and date</option>";
							
                    ?>
              	</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('prk_filter'); ?>"><?php _e('Filter (optional)', 'spw'); ?>:</label><br />
				<input id="<?php echo $this->get_field_id('prk_filter'); ?>" name="<?php echo $this->get_field_name('prk_filter'); ?>" value="<?php echo $prk_filter; ?>" class="pct_89" />
				<br />
				<span class="description">Use categories slug (comma separated)</span>
			</p>
            <p>
				<label for="<?php echo $this->get_field_id( 'num_items' ); ?>">Number of entries:</label>
				<input id="<?php echo $this->get_field_id( 'num_items' ); ?>" name="<?php echo $this->get_field_name( 'num_items' ); ?>" value="<?php echo $num_items; ?>" class="pct_89" />
			</p>
			<?php
			
		}
	}
?>