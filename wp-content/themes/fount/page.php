<?php 
  get_header();
  $show_sidebar=$prk_fount_options['right_sidebar'];
  if ($show_sidebar=="1")
      $show_sidebar=true;
  else
      $show_sidebar=false;
  if (get_field('show_sidebar')=="yes") 
  {
      $show_sidebar=true;
  }
  if (get_field('show_sidebar')=="no") 
  {
      $show_sidebar=false;
  }
  $show_title=true;
  if (get_field('show_title')=="no") {
      $show_title=false;
  }
  $show_slider=get_field('featured_slider');
  if (get_field('featured_slider_autoplay')=="1")
    $autoplay="true";
  else
    $autoplay="false";
  $delay=get_field('featured_slider_delay');
  if (get_field('featured_slider_supersize')=="1")
    $fill_height="super_height";
  else
    $fill_height="";
  if (get_field('featured_slider_arrows')=="1")
    $navigation="true";
  else
    $navigation="false";
  if (get_field('featured_slider_parallax')=="1")
    $parallax="owl_parallaxed";
  else
    $parallax="owl_regular";
  if (get_field('featured_slider_dots')=="1")
    $pagination="true";
  else
    $pagination="false";
  if (get_field('featured_header')=="1")
    $featured_style='';
  else
    $featured_style=' class="forced_menu"';
  $inside_filter="";
  if (get_field('slide_filter')!="")
  {
    $filter=get_field('slide_filter');
    foreach ($filter as $child)
    {
      //ADD THE CATEGORIES TO THE FILTER
      $inside_filter.=$child->slug.", ";
    }
  }
  $extra_class="";
?>
<div id="centered_block"<?php echo $featured_style; ?>>
<div id="main_block" class="block_with_sections page-<?php echo get_the_ID(); ?>">
    <?php
      if ($show_title==true)
      {
        echo '<div class="prk_inner_block small-12 small-centered columns">';
        prk_output_title("advanced");
        $extra_class=" with_title";
        echo '</div>';
      }
      else
      {
        if (get_field('featured_header')=="0")
          $extra_class=" untitled_main";
      }
    ?>

    <div id="content">
        <div id="main" role="main" class="row<?php echo $extra_class; ?>">
            <?php
                if ($show_slider=="yes")
                {
                  echo '<div class="featured_owl '.$parallax.'">'; 
                  echo do_shortcode('[prk_slider id="fount_slider-'.get_the_ID().'" category="'.$inside_filter.'" autoplay="'.$autoplay.'" delay="'.$delay.'" sl_size="'.$fill_height.'" pagination="'.$pagination.'" navigation="'.$navigation.'" parallax_effect="'.$parallax.'"]');
                  if (get_field('featured_slider_down_arrow')=="1") {
                    echo '<a href="" class="site_background_colored regular_anchor_menu"><div class="fount_next_arrow fount_sp_arrow"><i class="fount_fa-chevron-down"></i></div></a>';
                  }
                  echo '</div>';
                }
                if ($show_slider=="revolution")
                {
                  echo '<div class="prk_rv">'; 
                  echo do_shortcode('[rev_slider '.get_field('revolution_slider').']');
                  echo '</div><div id="mobile_sizer"></div>';
                }
                if ($show_sidebar)
                {
                  echo '<div class="small-centered columns prk_inner_block small-12">';
                  echo '<div class="row">';
                  echo '<div class="small-9 columns">';
                  echo '<div id="fount_sidebared_sections">';
                }
                else
                {
                  echo '<div id="fount_super_sections" class="row">';
                }
                echo '<div id="fount-fake-anchor"></div>';
                while (have_posts()) : the_post();
                  if(has_shortcode(get_the_content(),'vc_row')) {
                    the_content();
                  }
                  else
                  {
                    if (has_shortcode(get_the_content(),'woocommerce_cart') || has_shortcode(get_the_content(),'woocommerce_checkout') || has_shortcode(get_the_content(),'woocommerce_pay') || has_shortcode(get_the_content(),'woocommerce_thankyou') || has_shortcode(get_the_content(),'woocommerce_order_tracking') || has_shortcode(get_the_content(),'woocommerce_my_account') || has_shortcode(get_the_content(),'woocommerce_edit_address') || has_shortcode(get_the_content(),'woocommerce_view_order') || has_shortcode(get_the_content(),'woocommerce_change_password') || has_shortcode(get_the_content(),'woocommerce_lost_password') || has_shortcode(get_the_content(),'woocommerce_logout'))
                      {
                        ?>
                          <div id="gen_fount-<?php echo rand(1,1000); ?>" class="wpb_row vc_row-fluid prk_full_width prk_section fount_row">
                            <div class="small-12">
                              <div class="extra_pad prk_inner_block columns small-centered clearfix">
                                <div class="row">
                                <div class="vc_span12 wpb_column column_container">
                                  <div class="wpb_wrapper">
                                   <div class="wpb_text_column wpb_content_element ">
                                    <div class="wpb_wrapper">
                                      <?php the_content(); ?>
                                    </div>
                                  </div>
                                  </div> 
                                </div> 
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                      else
                      {
                        echo '<div class="prk_composer_extra prk_inner_block small-12 small-centered columns">';
                        the_content();
                        echo '<div class="clearfix"></div>';
                        echo '</div>';
                      }
                  }
                  wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>'));
                endwhile;
                if ($show_sidebar)
                {
                  echo '</div>';
                  echo '</div>';
                    ?>
                    <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?>" role="complementary">
                      <?php get_sidebar(); ?>
                    </aside>
                  <?php
                  echo '</div>';
                  echo '</div>';
                }
                else
                {
                  echo '</div>';
                }
                ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</div>
<?php get_footer(); ?>