<?php 
    get_header();
    global $prk_retina_device;
    $retina_flag = $prk_retina_device === "prk_retina" ? true : false;
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
    //OVERRIDE OPTIONS - ONLY FOR PREVIEW MODE
    if (INJECT_STYLE)
    {
        include_once(ABSPATH . 'wp-content/plugins/color-manager-fount/style_header.php');  
    }
    while (have_posts()) : the_post();
        //GET THEME CUSTOM FIELDS INFO
        $sl_id="single_slider";
        $sl_class="flexslider boxed_shadow on_blog";
        $slides_class="item";
        if (get_field('no_slider')=="1")
        {
            $sl_id="not_slider";
            $sl_class="";
            $slides_class="boxed_shadow";
        }
        if (get_field('featured_color')!="" && $prk_fount_options['use_custom_colors']=="1")
        {
            $featured_color=get_field('featured_color');
            $featured_class=' featured_color';
        }
        else
        {
            $featured_color="default";
            $featured_class="";
        }
        if ($prk_fount_options['autoplay_blog']=="1")
        {
            $autoplay="true";
        }
        else
        {
            $autoplay="false";
        }
        ?>
        <div id="centered_block" class="prk_no_change forced_menu">
        <div id="main_block" class="small-12">
            <div id="content" data-parent="<?php echo get_page_link(prk_get_parent_blog()); ?>">
                <div id="main" role="main" class="small-12 row">
                    <div id="single_blog_inner" class="small-12 zero_side_pad columns prk_inner_block small-centered">
                        <?php if ($show_sidebar) {echo '<div class="row">'; } ?>
                        <div class="<?php if ($show_sidebar) {echo "small-9 columns"; } else {echo "no_title_page";} ?>">
                            <div id="single_blog_content" class="small-centered columns blog_limited_width<?php echo $featured_class; ?>" data-color="<?php echo $featured_color; ?>">
                                <article <?php post_class(''); ?> id="post-<?php the_ID(); ?>">
                                    <h1 id="single_blog_title" class="<?php echo $prk_fount_options['headings_align']; ?> header_font bd_headings_text_shadow zero_color prk_break_word">
                                        <?php the_title(); ?>
                                    </h1>
                                    <div id="single_post_teaser" class="<?php echo $prk_fount_options['headings_align']; ?>">
                                        <div id="single_blog_meta" class="small_headings_color header_font prk_heavier_500">
                                            <div class="single_blog_meta_div">
                                                <?php
                                                if (is_sticky())
                                                {
                                                    ?>
                                                        <div class="left_floated sticky_text">
                                                            <?php echo($prk_translations['sticky_text']); ?>
                                                        </div>
                                                        <div class="pir_divider">|</div>
                                                    <?php
                                                }
                                                if ($prk_fount_options['show_date_blog']=="1")
                                                {
                                                    echo '<div class="left_floated">';
                                                    echo the_time(get_option('date_format'));
                                                    echo '</div>';
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            if ($prk_fount_options['categoriesby_blog']=="1")
                                            {
                                                ?>
                                                <div class="single_blog_meta_div">
                                                    <div class="pir_divider">|</div>
                                                    <div class="left_floated">
                                                        <?php the_category(', '); //CATS WITH LINKS ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                                if ( comments_open() ) :
                                                    ?>
                                                    <div class="single_blog_meta_div hide_much_later">
                                                        <div class="pir_divider">|</div>
                                                        <div class="left_floated">
                                                            <a href="<?php comments_link(); ?>">        
                                                                <?php 
                                                                    comments_number($prk_translations['comments_no_response'], $prk_translations['comments_one_response'], '% '.$prk_translations['comments_oneplus_response']);
                                                                ?> 
                                                            </a>
                                                        </div>
                                                    </div>
                                                  <?php
                                                endif;
                                            ?>
                                            <div class="clearfix"></div>  
                                        </div> 
                                    </div>
                                    <div class="clearfix"></div> 
                                    <div class="per_init owl-carousel fount_shortcode_slider" data-navigation="true" data-autoplay="<?php echo $autoplay; ?>" data-delay="<?php echo $prk_fount_options['delay_blog']; ?>" data-color="<?php echo $featured_color; ?>">
                                            <?php
                                                $ext_count=0;
                                                if ($show_sidebar) 
                                                {
                                                    $imgs_width=ceil(($prk_fount_options['custom_width']-48*2)*0.75);
                                                }
                                                else
                                                {
                                                    $imgs_width=$prk_fount_options['custom_width_blog'];
                                                }
                                                if ($imgs_width<690)
                                                    $imgs_width=690;
                                                if (get_field('skip_featured')=="")
                                                {
                                                    if (has_post_thumbnail( $post->ID ) )
                                                    {
                                                        $ext_count=1;
                                                        echo "<div id=slide_".$ext_count." class='".$slides_class."'>";
                                                        $vt_image = vt_resize( get_post_thumbnail_id($post->ID),'',$imgs_width, 0, false , $retina_flag );
                                                        echo '<img class="lazyOwl" src="#" data-src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="" />';
                                                        echo"</div>";
                                                    }
                                                }
                                                //PLACE THE OTHER NINE IMAGES
                                                for ($count=2;$count<11;$count++)
                                                {
                                                    if (get_field('image_'.$count)!="")
                                                    {
                                                        $ext_count++;
                                                        echo "<div id=slide_".$ext_count." class='".$slides_class."'>";
                                                                $in_image=wp_get_attachment_image_src(get_field('image_'.$count),'full');
                                                                $vt_image = vt_resize( '', $in_image[0] , $imgs_width, 0, false , $retina_flag);
                                                                echo '<img class="lazyOwl" src="#" data-src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="" />';
                                                        echo "</div>";
                                                    }
                                                    //OTHER MEDIA SUPPORT
                                                    if (get_field('video_'.$count)!="")
                                                    {
                                                        $ext_count++;
                                                        echo "<div id=slide_".$ext_count." class='".$slides_class."'>";
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
                                        <div class="single_post_wp pirenko_box">                          
                                    <div id="single_post_content" class="on_colored prk_no_composer prk_break_word<?php if(!has_shortcode(get_the_content(),'vc_row')) {echo " prk_composer_extra";} ?>">
                                        <?php the_content(); ?>
                                    </div>
                                    <?php wp_link_pages('before=<p class="fade_anchor">&after=</p>'); ?>
                                    <div class="clearfix"></div>
                                    <?php
                                        if (get_the_tags()!="")
                                        {
                                            ?>
                                            <div id="prk_tags" class="twelve prk_heavier_500 header_font">
                                                <?php 
                                                    if ($prk_fount_options['share_blog']=="1")
                                                        echo '<div class="simple_line"></div>';
                                                ?>
                                                <i class="fount_fa-tags fount_fa-lg twelve prk_less_opacity small_headings_color"></i>
                                                <div class="small_headings_color"><?php the_tags(''); ?></div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <?php
                                        } 
                                        if ($prk_fount_options['share_blog']=="1")
                                        {
                                            ?>
                                            <div id="single_post_sharer" class="prk_sharrre_wrapper">
                                                <div class="sharrre_blogger header_font">
                                                    <div class="prk_sharre_btns left_floated">
                                                        <?php if (isset($prk_fount_options['share_blog_fb']) && $prk_fount_options['share_blog_fb']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_facebook colorer-facebook" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        <?php if (isset($prk_fount_options['share_blog_goo']) && $prk_fount_options['share_blog_goo']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_google colorer-google" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        <?php if (isset($prk_fount_options['share_blog_lnk']) && $prk_fount_options['share_blog_lnk']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_linkedin colorer-linkedin" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        <?php 
                                                            if (isset($prk_fount_options['share_blog_pin']) && $prk_fount_options['share_blog_pin']=="1") 
                                                            { 
                                                                if (has_post_thumbnail( $post->ID ) )
                                                                {
                                                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                                                                }
                                                                else
                                                                {
                                                                    $image[0]="";
                                                                }
                                                                ?>
                                                                <div class="fount_socialink prk_sharrre_pinterest colorer-pinterest" data-media="<?php echo $image[0]; ?>" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                                </div>
                                                                <?php 
                                                            } 
                                                        ?>
                                                        <?php if (isset($prk_fount_options['share_blog_stu']) && $prk_fount_options['share_blog_stu']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_stumbleupon colorer-stumbleupon" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        
                                                        <?php if (isset($prk_fount_options['share_blog_twt']) && $prk_fount_options['share_blog_twt']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_twitter colorer-twitter" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                          <?php
                                        }
                                        ?>
                                    <div id="single_meta_footer">
                                    <?php 
                                        if (isset($prk_fount_options['related_blog']) && $prk_fount_options['related_blog']=="1")
                                        {
                                            ?>
                                            <div class="simple_line"></div>
                                            <div class="fount_navigation_singles prk_heavier_600 header_font zero_color bd_headings_text_shadow smoothed_anchor">
                                                <div class="navigation-previous-blog">
                                                        <?php next_post_link_plus( array(
                                                            'order_by' => 'menu_order',
                                                            'in_same_cat' => true,
                                                            'format' => '%link',
                                                            'link' => '<div class="left_floated"><i class="fount_fa-chevron-left"></i>%title</div>'
                                                            ) );
                                                        ?>
                                                </div>
                                                <div class="navigation-next-blog right_floated">
                                                        <?php previous_post_link_plus( array(
                                                            'order_by' => 'menu_order',
                                                            'in_same_cat' => true,
                                                            'format' => '%link',
                                                            'link' => '<div class="left_floated bf_icon_blog">%title<i class="fount_fa-chevron-right"></i></div>
                                                              '
                                                            ) );
                                                        ?>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <?php 
                                        if ($prk_fount_options['related_author']=="1")
                                        {
                                            ?>
                                            <div id="author_area">
                                                <?php 
                                                    if (function_exists('get_avatar')) { 
                                                        echo "<div class='prk_author_avatar'>";
                                                        echo get_avatar( get_the_author_meta('email'), '216' );
                                                        echo "</div>";
                                                    }
                                                ?>
                                                <div class="author_info">
                                                    <div class="header_font">
                                                        <h4 class="bd_headings_text_shadow zero_color prk_heavier_600">
                                                            <?php echo $prk_translations['about_author_text']." ";the_author_posts_link(); ?>
                                                        </h4>
                                                        <?php
                                                            if (get_the_author_meta('prk_subheading')!="") {
                                                                ?>
                                                                    <div class="small_headings_color prk_heavier">
                                                                        <?php echo get_the_author_meta('prk_subheading'); ?>
                                                                    </div>
                                                                <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <?php 
                                                        $auth_array = get_user_by('slug', get_the_author_meta('user_nicename'));
                                                        echo '<div class="author_description default_color">'.nl2br($auth_array->description).'</div>'; 
                                                    ?>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                    <div id="c_wrap_single">
                                        <?php comments_template(); ?>
                                  </div>
                                </article>
                                </div>
                                </div>
                            <?php 
                                if ($show_sidebar) 
                                {
                                    ?>
                                    <div class="small-12 columns show_later">
                                        <div class="simple_line on_sidebar"></div>
                                    </div>
                                    <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?> on_single_post" role="complementary">
                                       <?php get_sidebar(); ?>
                                    </aside>
                                    <?php
                                    echo '</div>';
                               }
                            ?>
                            <div class="clearfix"></div>
                        </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
</div>
<?php endwhile; /* End loop */ ?>
<?php get_footer(); ?>