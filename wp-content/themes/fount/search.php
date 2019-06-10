<?php 
	get_header(); 
  global $prk_retina_device;
  $retina_flag = $prk_retina_device === "prk_retina" ? true : false;
	$show_sidebar=$prk_fount_options['right_sidebar'];
	if ($show_sidebar=="1")
		$show_sidebar=true;
	else
		$show_sidebar=false;
?>
<div id="centered_block" class="prk_no_change forced_menu">
<div id="main_block" class="small-12">
    <div id="content">
        <div id="main" role="main" class="small-12 row">
          <div class="prk_inner_block small-centered small-12 columns">
            <div class="row">
            <?php
              if ($show_sidebar)
              {
                echo '<div class="small-9 columns">';
              }
              else
              {
                echo '<div class="small-12 columns">';
              }
            ?>
            <div id="headings_wrap" class="bd_headings_text_shadow zero_color">
              <div class="single_page_title small-12">
              <h1 id="single_blog_title" class="header_font bd_headings_text_shadow zero_color prk_break_word <?php echo $prk_fount_options['headings_align']; ?>">
                <?php 
                  if (!have_posts()) 
                    { 
                      echo($prk_translations['submit_search_no_results'] );
                      echo '<span class="zero_color bd_headings_text_shadow"> "'.get_search_query().'"</span>';
                    }
                    else
                    {
                      echo($prk_translations['submit_search_res_title']);
                      echo '<span class="zero_color bd_headings_text_shadow"> "'.get_search_query().'"</span>';
                    }  
                ?>                    
              </h1>
            </div>
            <div class="clearfix"></div>
          </div>
      <?php
        echo '<ul id="search_ul">';
			 	while (have_posts()) : the_post(); 
				?>
            	<li id="post-<?php the_ID(); ?>" <?php post_class('prk_search_res'); ?>>
                <?php
                  $extra_class="";
                  if (has_post_thumbnail( $post->ID ) )
                  {
                    $extra_class="prk_with_featured";
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
                    //$image[0] = get_image_path($image[0]);
                          $vt_image = vt_resize( get_post_thumbnail_id( $post->ID ), '' , 200, 0, false , $retina_flag );
                        ?>
                        <div class="grid_image_wrapper boxed_shadow">
                          <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $vt_image['url']; ?>" width="<?php echo $vt_image['width']; ?>" height="<?php echo $vt_image['height']; ?>" class="custom-img grid_image left_floated" alt="<?php echo prk_get_img_alt($image[0]); ?>" />
                        <div class="grid_colored_block">
                        </div>
                      </a>
                      </div>
                    <?php
                  }
                ?>
                <div class="<?php echo $extra_class; ?>">
              		<h3 class="header_font zero_color small bd_headings_text_shadow">
                  	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </h3>
                  <div class="simple_line titlify_right"></div>
                   </div>
                		<?php //roots_entry_meta(); ?>
              		<div class="<?php echo $extra_class; ?>">
                		<?php if (is_archive() || is_search()) {
                      $cat_helper=$post->ID;
                      echo the_excerpt_dynamic(64,$post->ID);
    								?>
      								  <div class="theme_button tiny">
      									  <a href="<?php echo get_permalink($cat_helper); ?>" class="with_icon">
                              <?php 
                                echo '<div class="text_shifter">'.$prk_fount_options['read_more'].'</div>';
                                echo '<div class="icon_cell"><i class="fount_fa-chevron-right"></i></div>'; 
                              ?>
                          </a>
      								  </div>
                        <div class="clearfix"></div>
                		<?php } else { ?>
                  		<?php the_content(); ?>
                		<?php } ?>
              		</div>
            	</li>
                
        	<?php 
          endwhile; /* End loop */ ?>
        </ul>
            <div class="clearfix"></div>
            <?php fount_paging_nav(); ?>
            </div>
           <?php 
              if ($show_sidebar) 
              {
                ?>   
                <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?> inside right_floated zero_right" role="complementary">
                    <?php get_sidebar(); ?>
                </aside><!-- #sidebar -->
                <?php
              }
            ?>
          </div>
            <div class="clearfix"></div>
          </div>
          </div>
        </div>
    </div>
</div>
</div>
	<?php get_footer(); ?>