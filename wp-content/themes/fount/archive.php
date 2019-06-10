<?php 
    get_header();
    //HALF LAYOUT ----------------------------+++----------------------------
   if ($prk_fount_options['archives_type']=="masonry") //MASONRY LAYOUT ----------------------------+++----------------------------
    {
        global $prk_retina_device;
        $retina_flag = $prk_retina_device === "prk_retina" ? true : false;
        //OVERRIDE OPTIONS - ONLY FOR PREVIEW MODE
        if (INJECT_STYLE) {
            include_once(ABSPATH . 'wp-content/plugins/color-manager-fount/style_header.php');  
        }
        $show_sidebar=$prk_fount_options['right_sidebar'];
        if ($show_sidebar=="1")
            $show_sidebar=true;
        else
            $show_sidebar=false;
        $show_title=true;
        if (get_field('hide_title')=="1") 
        {
            $show_title=false;
        }
        $limited_width=true;
        if (get_field('featured_header')=="1")
        {
            $featured_style='';
            $show_title=false;
        }
        else
            $featured_style=' forced_menu';
        $iso_images_max_w=390;
        $iso_images_min_w=340;
    ?>

    <div id="centered_block" class="page-prk-blog-masonry<?php echo esc_attr($featured_style); ?>"> 
    <div id="main_block" class="page-<?php echo get_the_ID(); ?>">

        <?php
            $extra_space="";
            if ($show_title==true)
            {
                if ($limited_width==true)
                {
                    echo '<div class="prk_inner_block small-12 small-centered columns">';
                    prk_output_title("advanced");
                    echo '</div>';
                }
                else
                {
                    echo '<div class="small-12 small-centered columns">';
                    echo '<div class="small-12 small-centered columns">';
                    prk_output_title("advanced");
                    echo '</div></div>';
                }
                echo '<div class="clearfix"></div>';
                if ($show_sidebar==false)
                    $extra_space="prk_more_space";
            }
        ?>
        <div id="content">
            <div id="main" class="<?php echo esc_attr($extra_space); ?>">
                <div class="prk_inner_block small-12 small-centered columns row">
                    <?php
                        if ($show_sidebar==true) 
                        {
                            echo '<div class="row">';
                            echo '<div class="small-9 columns">';
                        }
                        else
                        {
                            echo '<div class="row">';
                        }
                            //APPLY FILTERS FOR CATEGORY IF NEEDED
                            $cat_selector="";
                            if (get_query_var('cat')!="") 
                            {
                                $cat = get_category(get_query_var('cat'));
                                if (!($cat)!=1)
                                {
                                    $cat_selector=$cat->slug;
                                }
                            }
                            //APPLY FILTERS FOR TAG IF NEEDED     
                            $tag_selector="";
                            $tagname = get_query_var('tag');
                            if ($tagname!="")
                            {
                                $tag_selector=$tagname;
                            }
                            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            $monthnum = (get_query_var('monthnum')) ? get_query_var('monthnum') : "";
                            $yearnum = (get_query_var('year')) ? get_query_var('year') : "";
                            if ($paged>1)
                            {
                                $excluder=get_option("sticky_posts");
                            }
                            else
                            {
                                $excluder="";
                            }
                            $args = array( 
                                'post_type'=>'post', 
                                'paged' => $paged,
                                'category_name'=>$cat_selector,
                                "post__not_in" =>$excluder,
                                'tag'=>$tagname,
                                'year'=>$yearnum,
                                'monthnum'=>$monthnum);
                            $my_query = new WP_Query();
                            $my_query->query($args);
                            $post_counter=($paged-1)*$posts_per_page;
                                if ($my_query->have_posts()) : 
                                $ins=0;
                                if (get_field('thumbs_margin')!="") 
                                {
                                    $thumbs_margin=get_field('thumbs_margin');
                                }
                                else
                                {
                                    $thumbs_margin=16;
                                }
                                if (get_field('posts_color_masonry')!="")
                                {
                                    echo '<div id="blog_masonry_father" class="with_backs" data-color="'.get_field('posts_color_masonry').'">';
                                }
                                else
                                {
                                    echo '<div id="blog_masonry_father" class="row">';
                                }
                                ?>
                                <div class="templated masonry_blog per_init prk_section clearfix" data-max-width="<?php echo esc_attr($iso_images_max_w); ?>" data-min-width="<?php echo esc_attr($iso_images_min_w); ?>" data-margin="<?php echo esc_attr($thumbs_margin); ?>">
                                    <?php
                                    while ($my_query->have_posts()) : $my_query->the_post(); 
                                        $post_counter++;
                                        if (get_field('featured_color')!="" && $prk_fount_options['use_custom_colors']=="1")
                                        {
                                            $featured_color=get_field('featured_color');
                                            $featured_class="featured_color ";
                                        }
                                        else
                                        {
                                            $featured_color="default";
                                            $featured_class="";
                                        }
                                        ?>
                                        <div id="post-<?php the_ID(); ?>" class="<?php echo esc_attr($featured_class); ?> blog_entry_li clearfix<?php if ($post_counter == $my_query->post_count) echo " last_li"; ?>" data-type="<?php $category= get_the_category();
                                        foreach($category as $test) 
                                        { 
                                            echo esc_attr($test->slug)." ";
                                        }  ?>" data-id="id-<?php echo esc_attr($post_counter); ?>" data-color="<?php echo esc_attr($featured_color); ?>">
                                        <div class="masonry_inner">
                                            <?php 
                                                $less_size="";
                                                if (has_post_thumbnail( $post->ID ) ):
                                                    //GET THE FEATURED IMAGE
                                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
                                                    //$image[0] = get_image_path($image[0]);
                                                    $p_photo_image=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
                                                    
                                                else :
                                                    //THERE'S NO FEATURED IMAGE
                                                endif; 
                                                if (has_post_thumbnail( $post->ID ) )
                                                { 
                                                    ?>
                                                    <a href="<?php the_permalink() ?>" class="fade_anchor blog_hover" data-color="<?php echo esc_attr($featured_color); ?>">
                                                        <div class="masonr_img_wp boxed_shadow">
                                                            <div class="blog_fader_grid">
                                                                <div class="fount_fa-plus titled_link_icon body_bk_color"></div>
                                                            </div>
                                                            <?php        
                                                                $vt_image = vt_resize( get_post_thumbnail_id( $post->ID ), '' , 680, 0, false , $retina_flag );//620 is for single row on small screens
                                                            ?>
                                                            <img src="<?php echo esc_attr($vt_image['url']); ?>" width="<?php echo esc_attr($vt_image['width']); ?>" height="<?php echo esc_attr($vt_image['height']); ?>" id="home_fader-<?php the_ID(); ?>" class="custom-img grid_image" alt="" />
                                                        </div>
                                                    </a>
                                                    <?php
                                                }
                                                else
                                                {
                                                    //CHECK IF THERE'S A VIDEO TO SHOW
                                                    if (get_field('video_2')!="")
                                                    {
                                                        $el_class='video-container boxed_shadow';
                                                        if (strpos(get_field('video_2'),'soundcloud.com') !== false) {
                                                            $el_class= 'soundcloud-container';
                                                        }
                                                        echo "<div class='".$el_class."'>";
                                                        echo get_field('video_2');
                                                        echo "</div>";
                                                    }
                                                    else
                                                    {
                                                        $less_size=" less_meta_pad";
                                                        ?>
                                                        <div class="blog_top_image zero_margin_bottom">&nbsp;</div> 
                                                        <?php
                                                    }
                                                }
                                            ?>
                                            <div class="header_font prk_heavier_500 prk_mini_meta small_headings_color<?php echo $less_size; ?>">
                                                <?php
                                                    if (is_sticky())
                                                    {
                                                        echo '<div class="left_floated sticky_text">';
                                                        echo $prk_translations['sticky_text'];
                                                        echo '</div>';
                                                        if ($prk_fount_options['show_date_blog']=="1")
                                                        {
                                                            echo '<div class="left_floated"><div class="pir_divider">|</div></div>';
                                                        }
                                                    }
                                                    if ($prk_fount_options['show_date_blog']=="1")
                                                    {
                                                        echo '<div class="left_floated sticky_text">';
                                                        echo the_time(get_option('date_format')); 
                                                        echo '</div>';
                                                    }
                                                ?>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="entry_title">
                                                <h4 class="bd_headings_text_shadow prk_heavier_700 big header_font">
                                                    <a href="<?php the_permalink(); ?>" class="fade_anchor zero_color prk_break_word" data-color="<?php echo esc_attr($featured_color); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h4>
                                                <div class="clearfix"></div>
                                                </div>
                                                <div class="on_colored entry_content prk_break_word">
                                                        <?php 
                                                            $cat_helper=$post->ID;
                                                            echo the_excerpt_dynamic(27,$post->ID); 
                                                        ?>
                                                     <div class="clearfix"></div>
                                                </div>
                                                <div class="blog_lower header_font prk_heavier_500">
                                                    <div class="small-12 columns">
                                                        <?php 
                                                            if ($prk_fount_options['categoriesby_blog']=="1")
                                                            {
                                                                echo '<div class="left_floated blog_categories small_headings_color">';
                                                                the_category(', ');
                                                                echo '</div>';
                                                            }
                                                        ?>
                                                        <div class="single_blog_meta_div right_floated">
                                                            <a href="<?php echo get_permalink($cat_helper); ?>" class="small_headings_color fade_anchor" data-color="<?php echo esc_attr($featured_color); ?>">
                                                                <div class="left_floated">
                                                                    <?php echo($prk_translations['read_more']); ?>
                                                                </div>
                                                                <i class="fount_fa-chevron-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <?php 
                                        $ins++;
                                    endwhile;
                                    ?>  
                        </div>
                    <?php endif; 
                    //SHOW NAVIGATION
                    if ($my_query->max_num_pages>1)
                    {
                        ?>
                        <div id="entries_navigation_blog" class="row">
                            <div class="navigation fade_anchor columns small-12 prk_inner_block small-centered">
                                <div id="prk_nav_inner" class="navigation fade_anchor">
                                    <div class="small-12 prk_heavier_600 header_font zero_color bd_headings_text_shadow smoothed_anchor">
                                        <?php
                                            next_posts_link('<div class="left_floated blog_naver_left prk_heavier_600"><i class="fount_fa-chevron-left"></i>'.$prk_translations['older'].'</div>',$my_query->max_num_pages);
                                            previous_posts_link('<div class="right_floated"><div class="blog_naver_right">'.$prk_translations['newer'].'<i class="fount_fa-chevron-right"></i></div></div>',$my_query->max_num_pages);
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                ?>
        </div>
      </div>
            <?php 
                if ($show_sidebar) 
                {
                    ?>
                    <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?>" role="complementary">
                        <?php get_sidebar(); ?>
                    </aside>
                    <?php
                    echo '</div>';
                                        echo '</div>';
                }
            ?>
            <div class="clearfix"></div>
          </div>
        </div>
    </div>
    </div>
    </div>
    <?php
    }
    else //BIG IMAGES LAYOUT ----------------------------+++----------------------------
    {
        global $prk_retina_device;
        $retina_flag = $prk_retina_device === "prk_retina" ? true : false;
        //OVERRIDE OPTIONS - ONLY FOR PREVIEW MODE
        if (INJECT_STYLE) {
            include_once(ABSPATH . 'wp-content/plugins/color-manager-fount/style_header.php');  
        }
        $show_sidebar=$prk_fount_options['right_sidebar'];
        if ($show_sidebar=="1")
            $show_sidebar=true;
        else
          $show_sidebar=false;
        $show_title=true;
        if (get_field('featured_header')=="1")
        {
            $featured_style='';
            $show_title=false;
        }
        else
            $featured_style=' forced_menu';
        ?>    
        <div id="centered_block" class="page-prk-blog-full<?php echo $featured_style; ?>">
        <div id="main_block" class="row page-<?php echo get_the_ID(); ?>">
            <?php
                if ($show_title==true)
                {
                    echo '<div class="small-12 small-centered columns prk_inner_block">';
                    prk_output_title("blog_page");
                    echo '</div>';
                }
            ?>
          <div id="content">
                <div id="main">
                <?php 
                    if ($show_sidebar) 
                    {
                        echo '<div id="parent_blog_inner" class="small-12 columns small-centered prk_inner_block">';
                        echo '<div class="row">';
                        echo '<div class="small-9 columns">';
                    }
                    else
                    {
                        echo '<div class="berlo">';
                    }
                   //APPLY FILTERS FOR CATEGORY IF NEEDED
                            $cat_selector="";
                            if (get_query_var('cat')!="") 
                            {
                                $cat = get_category(get_query_var('cat'));
                                if (!($cat)!=1)
                                {
                                    $cat_selector=$cat->slug;
                                }
                            }
                            //APPLY FILTERS FOR TAG IF NEEDED     
                            $tag_selector="";
                            $tagname = get_query_var('tag');
                            if ($tagname!="")
                            {
                                $tag_selector=$tagname;
                            }
                            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            $monthnum = (get_query_var('monthnum')) ? get_query_var('monthnum') : "";
                            $yearnum = (get_query_var('year')) ? get_query_var('year') : "";
                            if ($paged>1)
                            {
                                $excluder=get_option("sticky_posts");
                            }
                            else
                            {
                                $excluder="";
                            }
                            $args = array( 
                                'post_type'=>'post', 
                                'paged' => $paged,
                                'category_name'=>$cat_selector,
                                "post__not_in" =>$excluder,
                                'tag'=>$tagname,
                                'year'=>$yearnum,
                                'monthnum'=>$monthnum);
                            $my_query = new WP_Query();
                            $my_query->query($args);
                            $post_counter=($paged-1)*$posts_per_page;
                    if (get_field('alternative_color')!="" && $show_sidebar==false)
                    {
                        echo '<div id="classic_blog_section" class="prk_section prk_evens_grid" data-color="'.get_field('alternative_color').'">';
                    }
                    else
                    {
                        echo '<div id="classic_blog_section" class="prk_section">';
                    }
                    if ($my_query->have_posts()) : 
                    $ins=0;
                    echo '<ul id="blog_entries" class="unstyled">';
                      while ($my_query->have_posts()) : $my_query->the_post(); 
                        $post_counter++;
                        if (get_field('featured_color')!="" && $prk_fount_options['use_custom_colors']=="1")
                        {
                          $featured_color=get_field('featured_color');
                          $featured_class="featured_color ";
                        }
                        else
                        {
                          $featured_color="default";
                          $featured_class="";
                        }
                      ?>
                    <li id="post-<?php the_ID(); ?>" class="<?php echo $featured_class; ?>blog_entry_li clearfix prk_inner_block small-twelve columns small-centered" data-color="<?php echo esc_attr($featured_color); ?>">
                        <div class="per_init owl-carousel fount_shortcode_slider" data-navigation="true">
                        <?php
                            $ext_count=0;
                            $imgs_width=$prk_fount_options['custom_width'];
                            if (has_post_thumbnail( $post->ID ) )
                            {
                                $ext_count=1;
                                //GET THE FEATURED IMAGE
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
                                $p_photo_image=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
                                ?>
                                <div class="item">
                                    <div class="blog_top_image boxed_shadow">
                                        <div class="blog_fader_grid">
                                            <div class="fount_fa-plus titled_link_icon body_bk_color"></div>
                                        </div>
                                        <?php 
                                            $vt_image = vt_resize( get_post_thumbnail_id( $post->ID ), '' , $imgs_width, 0, false , $retina_flag );
                                        ?>
                                        <img class="lazyOwl" src="#" data-src="<?php echo esc_attr($vt_image['url']); ?>" width="<?php echo esc_attr($vt_image['width']); ?>" height="<?php echo esc_attr($vt_image['height']); ?>" id="home_fader-<?php the_ID(); ?>" class="custom-img grid_image boxed_shadow" alt="" />
                                    </div>
                                </div>
                                <?php
                            }
                            //PLACE THE OTHER NINE IMAGES
                            for ($count=2;$count<11;$count++)
                            {
                                if (get_field('image_'.$count)!="")
                                {
                                    $ext_count++;
                                    echo "<div class='item'>";
                                            $in_image=wp_get_attachment_image_src(get_field('image_'.$count),'full');
                                            $vt_image = vt_resize( '', $in_image[0] , $imgs_width, 0, false , $retina_flag);
                                            echo '<img class="lazyOwl" src="#" data-src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="" />';
                                    echo "</div>";
                                }
                                //OTHER MEDIA SUPPORT
                                if (get_field('video_'.$count)!="")
                                {
                                    $ext_count++;
                                    echo "<div class='item'>";
                                        $el_class='prk-video-container';
                                        if (strpos(get_field('video_'.$count),'soundcloud.com') !== false) {
                                            $el_class= 'soundcloud-container';
                                        }
                                        echo "<div class='".$el_class."'>";
                                        echo get_field('video_'.$count);
                                        echo "</div>";
                                    echo "</div>";
                                }
                            }
                            ?>
                            </div>
                            <?php
                            if ($ext_count==0)
                            {
                                echo '<div class="clearfix bt_80"></div>';
                                echo '<div class="simple_line"></div>';
                            }
                            if ($prk_fount_options['postedby_blog']=="1" && function_exists('get_avatar')) 
                            { 
                                echo "<div class='prk_author_avatar small-3 small-centered columns'>";
                                echo get_avatar( get_the_author_meta('email'), '216' );
                                echo '<div class="prk_author_link fade_anchor small_headings_color prk_heavier_600 header_font">';
                                the_author_posts_link();
                                echo '</div>';
                                echo "</div>";
                            }
                        ?>
                            <div class="fount_post_info small-12 prk_inner_block columns small-centered<?php if ($show_sidebar==false) {echo ' blog_limited_width';} ?>">
                                <div class="header_font<?php if ($prk_fount_options['show_date_blog']=="1") {echo ' classic_blog_meta';} ?>">
                                    <h2 class="small">
                                        <a href="<?php the_permalink(); ?>" class="fade_anchor bd_headings_text_shadow zero_color prk_break_word" data-color="<?php echo esc_attr($featured_color); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    <div class="clearfix"></div>
                                    <div class="single_blog_meta_class small_headings_color prk_heavier_500">
                                        <?php
                                            $divide_me=false;
                                            if ($prk_fount_options['show_date_blog']=="1")
                                            {
                                                $divide_me=true;
                                                echo '<div class="blog_date single_blog_meta_div">';
                                                echo '<div class="left_floated">';
                                                echo get_the_time(get_option('date_format'));
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                            if (is_sticky())
                                            {
                                                if ($divide_me==false) 
                                                {
                                                    $divide_me=true;
                                                }
                                                else
                                                {
                                                    echo ('<div class="pir_divider">|</div>');
                                                }
                                                ?>
                                                <div class="single_blog_meta_div">
                                                    <div class="left_floated sticky_text">
                                                        <?php echo($prk_translations['sticky_text']); ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            if ($prk_fount_options['categoriesby_blog']=="1")
                                            {
                                                if ($divide_me==false) 
                                                {
                                                    $divide_me=true;
                                                }
                                                else
                                                {
                                                    echo ('<div class="pir_divider">|</div>');
                                                }
                                                ?>
                                                <div class="single_blog_meta_div">
                                                    <div class="left_floated blog_categories">
                                                        <?php the_category(', '); //CATS WITH LINKS ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            if (comments_open())
                                            {
                                                if ($divide_me==false) 
                                                {
                                                    $divide_me=true;
                                                }
                                                else
                                                {
                                                    echo ('<div class="pir_divider">|</div>');
                                                }
                                                ?>
                                                <div class="single_blog_meta_div">
                                                    <div class="left_floated">
                                                        <a href="<?php comments_link(); ?>" class="fade_anchor">        
                                                            <?php 
                                                                comments_number($prk_translations['comments_no_response'], $prk_translations['comments_one_response'], '% '.$prk_translations['comments_oneplus_response']);
                                                            ?> 
                                                        </a>
                                                    </div>
                                                </div>
                                              <?php
                                            }
                                        ?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="pirenko_box">
                                        <div class="on_colored entry_content prk_break_word">
                                            <?php 
                                                $cat_helper=$post->ID;
                                                echo the_excerpt_dynamic(70,$post->ID);
                                            ?>
                                            <div class="clearfix bt_12"></div> 
                                        </div>
                                        <?php 
                                        if (is_big_excerpt(70,$post->ID))
                                        {
                                            ?>
                                                <div class="theme_button_inverted fade_anchor">
                                                    <a href="<?php echo get_permalink($cat_helper); ?>" class="with_icon">
                                                        <?php 
                                                            echo '<div class="text_shifter">'.$prk_fount_options['read_more'].'</div>';
                                                            echo '<div class="icon_cell"><i class="fount_fa-chevron-right"></i></div>'; 
                                                        ?>
                                                    </a>
                                                </div> 
                                            <?php
                                        }
                                        ?> 
                                    </div>
                                </div>
                    </li>
                    <?php $ins++; ?>
                  <?php 
                    endwhile;
                    echo "</ul>";
                   endif; 
                    //SHOW NAVIGATION
                    if ($my_query->max_num_pages>1)
                    {
                        if ($ins % 2 == 0) 
                        {
                            echo '<div id="entries_navigation_blog" class="columns small-12 prk_whitey">';
                        }
                        else
                        {
                            echo '<div id="entries_navigation_blog" class="columns small-12">';
                        }
                        ?>
                            <div class="navigation fade_anchor columns small-12 prk_inner_block small-centered">
                                <div id="prk_nav_inner" class="navigation fade_anchor">
                                    <div class="small-12 prk_heavier_600 header_font zero_color bd_headings_text_shadow smoothed_anchor">
                                        <?php
                                            next_posts_link('<div class="left_floated blog_naver_left prk_heavier_600"><i class="fount_fa-chevron-left"></i>'.$prk_translations['older'].'</div>',$my_query->max_num_pages);
                                            previous_posts_link('<div class="right_floated"><div class="blog_naver_right">'.$prk_translations['newer'].'<i class="fount_fa-chevron-right"></i></div></div>',$my_query->max_num_pages);
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        <?php
                        echo '</div>';
                    }
                ?>
               </div>  
              </div>
            <?php 
                  if ($show_sidebar) 
                  {
                    ?>
                    <aside id="sidebar" class="prk_blogged <?php echo SIDEBAR_CLASSES; ?> on_single" role="complementary">
                        <div class="simple_line show_later"></div>
                      <?php get_sidebar(); ?>
                    </aside>
                      <?php
                    echo '</div>';
                    echo '</div>';
                  }
              ?>
              </div>
            </div>
            </div>
        
        </div>
        <?php
    }
?>
<?php get_footer(); ?>