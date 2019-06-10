<?php 
    get_header();
    global $prk_retina_device;
    $in_cat=true;
    $retina_flag = $prk_retina_device === "prk_retina" ? true : false;
    //OVERRIDE OPTIONS - ONLY FOR PREVIEW MODE
    if (INJECT_STYLE)
    {
        include_once(ABSPATH . 'wp-content/plugins/color-manager-fount/style_header.php');  
    }
    while (have_posts()) : the_post(); 
        if (get_field('featured_color')!="" && $prk_fount_options['use_custom_colors']=="1")
        {
            $featured_color=get_field('featured_color');
            $featured_class='featured_color';
        }
        else
        {
            $featured_color="default";
            $featured_class="";
        }
        $main_layout=$prk_fount_options['portfolio_layout'];
        if (is_array($main_layout))
        {
            $main_layout="half";
        }
        if (get_field('inner_layout')=="half")
            $main_layout="half";
        if (get_field('inner_layout')=="wide")
            $main_layout="wide";
        if (get_field('inner_layout')=="wideout")
            $main_layout="wideout";
        if ($prk_fount_options['autoplay_portfolio']=="1")
        {
            $autoplay="true";
        }
        else
        {
            $autoplay="false";
        }
        $sl_id="single_slider";
        $sl_class="per_init owl-carousel fount_shortcode_slider";
        if (get_field('no_slider')=="1")
        {
            $sl_id="not_slider";
            $sl_class="not_slider_wrapper";
        }
        if ($main_layout=="half")
        {
            ?>
            <div id="centered_block" class="prk_no_change"> 
                <div id="main_block" class="page-<?php echo get_the_ID(); ?>">
                    <div id="content" class="prk_tucked" data-parent="<?php echo get_page_link(prk_get_parent_portfolio()); ?>">
                    <div id="main" class="main_no_sections">
                    <div id="ajaxed_content">
                        <div id="half_wrapper" class="row">
                    <article id="prk_half_folio" <?php post_class($featured_class); ?> data-color="<?php echo $featured_color; ?>">
                        <div class="small-12 zero_side_pad columns prk_inner_block small-centered">
                            <div id="prk_half_size_single" class="row">
                                <h1 id="folio_ttl" class="header_font bd_headings_text_shadow zero_color head_center_text">
                                    <?php the_title(); ?>
                                </h1>
                                <div class="clearfix"></div>
                                <div class="small-8 columns">
                                    <div id="single_spinner" class="spinner-icon"></div>
                                    <div id="<?php echo $sl_id; ?>">
                                        <div class="<?php echo $sl_class; ?>" data-autoplay="<?php echo $autoplay; ?>" data-navigation="true" data-delay="<?php echo $prk_fount_options['delay_portfolio']; ?>" data-color="<?php echo $featured_color; ?>">
                                            <?php
                                                $ext_count=0;
                                                $imgs_width=ceil(($prk_fount_options['custom_width']-48*2)*0.66);
                                                if ($imgs_width<690)
                                                    $imgs_width=690;
                                                if (get_field('skip_featured')=="")
                                                {
                                                    if (has_post_thumbnail( $post->ID ) )
                                                    {
                                                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                                                        //$image[0] = get_image_path($image[0]);
                                                        $in_ttl="";
                                                        $alt_text="";
                                                        if ( $thumb = get_post_thumbnail_id() )
                                                        {
                                                            $in_ttl=get_post($thumb)->post_title;
                                                            $alt_text=get_post_meta($thumb, '_wp_attachment_image_alt', true);
                                                        }
                                                        echo '<div id="slide_1" class="item">';
                                                        $ext_count=1;
                                                        $vt_image = vt_resize( get_post_thumbnail_id( $post->ID ), '' , $imgs_width, '', false , $retina_flag );
                                                        echo '<img class="lazyOwl" src="#" data-src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="'.prk_get_img_alt($image[0]).'" />';
                                                        echo '</div>';
                                                    }
                                                }
                                                if (get_field('use_gallery')!="images_only")
                                                {
                                                    //PLACE THE OTHER NINETEEN IMAGES
                                                    for ($count=2;$count<21;$count++)
                                                    {
                                                        if (get_field('image_'.$count)!="")
                                                        {
                                                            $ext_count++;
                                                            echo '<div id="slide_'.$ext_count.'" class="item">';
                                                            $in_image=wp_get_attachment_image_src(get_field('image_'.$count),'full');
                                                            $vt_image = vt_resize( '', $in_image[0] , $imgs_width, '', false , $retina_flag );
                                                            echo '<img class="lazyOwl" src="#" data-src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="'.prk_get_img_alt($in_image[0]).'" />';
                                                            echo "</div>";
                                                        }
                                                        if (get_field('video_'.$count)!="")
                                                        {
                                                            $ext_count++;
                                                            echo '<div id="slide_'.$ext_count.'" class="item slide_video">';
                                                            $el_class='prk-video-container';
                                                            if (strpos(get_field('video_'.$count),'soundcloud.com') !== false) {
                                                              $el_class= 'soundcloud-container';
                                                            }
                                                            echo "<div class='".$el_class."'>";
                                                            echo get_field('video_'.$count);
                                                            echo "</div></div>";
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $regex = '/(\w+)\s*=\s*"(.*?)"/';
                                                    $pattern = '/\[gallery(.*?)\]/';
                                                    preg_match_all($regex, get_post_meta($post->ID,'image_gallery',true), $matches);
                                                    $stripped_gallery = array();
                                                    for ($i = 0; $i < count($matches[1]); $i++) {
                                                        $stripped_gallery[$matches[1][$i]] = $matches[2][$i];
                                                    }
                                                    if (!empty($stripped_gallery) && $stripped_gallery['ids']!="")
                                                    {
                                                        $array = explode(',', $stripped_gallery['ids']);
                                                        foreach($array as $value)
                                                        {
                                                            $ext_count++;
                                                            echo '<div id="slide_'.$ext_count.'" class="item">';
                                                            $in_image=wp_get_attachment_image_src($value,'full');
                                                            $vt_image = vt_resize( '', $in_image[0] , $imgs_width, '', false , $retina_flag );
                                                            echo '<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="'.prk_get_img_alt($in_image[0]).'" />';
                                                            echo "</div>";
                                                        }
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div id="half-entry-right" class="columns small-4">
                                        <h5 id="project_heading" class="header_font bd_headings_text_shadow zero_color prk_heavier_700">
                                            <?php echo $prk_translations['prj_desc_text']; ?>
                                        </h5>
                                        <div id="single_entry_content" class="prk_no_composer prk_break_word<?php if(!has_shortcode(get_the_content(),'vc_row')) {echo " prk_composer_extra";} ?>">
                                            <?php the_content(); ?>
                                        </div>
                                        <div class="clearfix"></div>
                                        <?php
                                            $line_counter=0;
                                            if ($prk_fount_options['share_portfolio']=="1")
                                            {
                                                echo '<div id="single_folio_sharer" class="fount_sharing_panel clearfix">';
                                                ?>
                                                <div class="prk_sharrre_wrapper left_floated">
                                                        <?php if (isset($prk_fount_options['share_portfolio_fb']) && $prk_fount_options['share_portfolio_fb']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_facebook colorer-facebook" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        <?php if (isset($prk_fount_options['share_portfolio_goo']) && $prk_fount_options['share_portfolio_goo']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_google colorer-google" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        <?php if (isset($prk_fount_options['share_portfolio_lnk']) && $prk_fount_options['share_portfolio_lnk']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_linkedin colorer-linkedin" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        <?php 
                                                            if (isset($prk_fount_options['share_portfolio_pin']) && $prk_fount_options['share_portfolio_pin']=="1") 
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
                                                        <?php if (isset($prk_fount_options['share_portfolio_stu']) && $prk_fount_options['share_portfolio_stu']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_stumbleupon colorer-stumbleupon" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        
                                                        <?php if (isset($prk_fount_options['share_portfolio_twt']) && $prk_fount_options['share_portfolio_twt']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_twitter colorer-twitter" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                </div>
                                              <?php
                                              echo '</div>';
                                            }
                                            if ($prk_fount_options['dateby_port']=="1")
                                            {
                                                echo '<div class="fount_info_block clearfix">';
                                                echo '<div class="left_floated header_font">';
                                                echo '<span class="prk_heavier_700 zero_color">'.$prk_translations['date_text'].':&nbsp;&nbsp;</span>';
                                                echo '<span class="default_color">';
                                                echo the_date();
                                                echo '</span></div></div>';
                                                $line_counter++;
                                            }
                                            if ($prk_fount_options['categoriesby_port']=="1")
                                            {
                                                if (get_the_term_list(get_the_ID(),'pirenko_skills')!="")
                                                {
                                                    $terms = wp_get_object_terms(get_the_ID(),'pirenko_skills');
                                                    $count = count($terms);
                                                    if ($count>0) {
                                                        if ($line_counter>0)
                                                        {
                                                            echo '<div class="simple_line on_folio"></div>';
                                                        }
                                                        $line_counter++;
                                                        echo '<div class="fount_info_block clearfix">';
                                                        echo '<div class="left_floated header_font">';
                                                        echo '<span class="prk_heavier_700 zero_color">'.$prk_translations['skills_text'].':&nbsp;&nbsp;</span>';
                                                        $in_count=0;
                                                        echo '<span class="default_color">';
                                                        foreach ( $terms as $term ) {
                                                            if ($in_count>0)
                                                                echo ", ";
                                                            echo '' . $term->name . '';
                                                            $in_count++;
                                                        }
                                                        echo '<span></div></div>';
                                                    }
                                                }
                                            }
                                            if (wp_get_object_terms(get_the_ID(),'portfolio_tag')!="") {
                                                $terms = wp_get_object_terms(get_the_ID(),'portfolio_tag');
                                                $count = count($terms);
                                                if ($count>0) {
                                                    if ($line_counter>0)
                                                    {
                                                        echo '<div class="simple_line on_folio"></div>';
                                                    }
                                                    $line_counter++;
                                                    echo '<div id="fount_single_tags" class="fount_info_block clearfix">';
                                                    echo '<div class="left_floated header_font">';
                                                    echo '<span class="prk_heavier_700 zero_color">'.$prk_translations['tags_text'].':&nbsp;&nbsp;</span>';
                                                    echo '<span class="default_color">';
                                                    $in_count=0;
                                                    foreach ( $terms as $term ) {
                                                        if ($in_count>0)
                                                            echo ", ";
                                                        echo '' . $term->name . '';
                                                        $in_count++;
                                                    }
                                                    echo '</span></div></div>';
                                                }
                                            }
                                            if (get_field('client_url')!="")
                                            {
                                                if ($line_counter>0)
                                                {
                                                    echo '<div class="simple_line on_folio"></div>';
                                                }
                                                echo '<div class="fount_info_block clearfix">';
                                                echo '<div class="left_floated header_font">';
                                                echo '<span class="prk_heavier_700 zero_color">'.$prk_translations['client_text'].':&nbsp;&nbsp;</span>';
                                                echo '<span class="default_color">'.get_field('client_url').'</span>';
                                                echo '</div></div>';
                                                $line_counter++;
                                            }
                                            if (get_field('ext_url')!="") 
                                            {
                                                //ADD HTTP PREFIX IF NEEDED
                                                if (substr(get_field('ext_url'),0,7)!="http://" && substr(get_field('ext_url'),0,8)!="https://")
                                                    $final_url="http://".get_field('ext_url');
                                                else
                                                    $final_url=get_field('ext_url');
                                                if ($line_counter>0)
                                                {
                                                    echo '<div class="simple_line on_folio"></div>';
                                                }
                                                echo '<div class="fount_info_block clearfix">';
                                                echo '<div class="left_floated header_font">';
                                                echo '<span class="prk_heavier_700 zero_color">'.$prk_translations['project_text'].':&nbsp;&nbsp;</span>';
                                                $popup="_blank";
                                                if (get_field('new_window')=="_self") {
                                                    $popup="_self";
                                                }
                                                echo '<a href="'.$final_url.'" target="'.$popup.'" data-color="'.$featured_color.'">';
                                                if (get_field('ext_url_label')!="") 
                                                {
                                                    echo get_field('ext_url_label');
                                                }
                                                else 
                                                {
                                                    
                                                    echo $prk_translations['launch_text'];
                                                }
                                                echo '</a></div></div>';
                                            }
                                            ?>
                            </div>
                            <div class="clearfix"></div>
                            </div>
                            <div class="fount_navigation_singles hide_now">
                                    <div class="navigation_previous_portfolio">
                                        <?php next_post_link_plus( array(
                                            'order_by' => 'menu_order',
                                            'in_same_cat' => $in_cat,
                                            'format' => '%link',
                                            'link' => '%title',
                                            'loop' => true,
                                            ) );
                                        ?>
                                    </div>
                                    <div class="navigation_next_portfolio">
                                            <?php previous_post_link_plus( array(
                                                'order_by' => 'menu_order',
                                                'in_same_cat' => $in_cat,
                                                'format' => '%link',
                                                'link' => '%title',
                                                'loop' => true,
                                                ) );
                                            ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            <div class="clearfix"></div>
                        </div>
                                </div> 
                                <div class="clearfix"></div>
                        <div id="after_single_folio" class="row">
                            <div class="small-12 columns prk_inner_block small-centered">
                                <?php 
                                    if (comments_open())
                                    {    
                                        comments_template();
                                    }
                                    echo prk_related_projects($post->ID);
                                ?>
                            <div class="clearfix"></div>
                        </div>
                    </article>
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
            $title_class="";
            if (get_field('title_under')==1) {
                $title_class=" fount_title_under";
            }
            ?>
            <div id="centered_block" class="prk_no_change"> 
                <div id="main_block" class="page-<?php echo get_the_ID(); ?>">
                    <div id="content" class="prk_tucked" data-parent="<?php echo get_page_link(prk_get_parent_portfolio()); ?>">
                    <div id="main" class="main_no_sections">
                        <div id="ajaxed_content">
                        <div class="row<?php echo $title_class; ?>">
                        <article id="prk_full_folio" <?php post_class($featured_class); ?> data-color="<?php echo $featured_color; ?>">
                            <h1 id="folio_ttl" class="header_font bd_headings_text_shadow zero_color head_center_text">
                                    <?php the_title(); ?>
                            </h1>
                            <div class="clearfix"></div>
                            <div id="single_spinner" class="spinner-icon"></div>
                            <div id="<?php echo $sl_id; ?>" class="prk_inner_block small-centered columns">
                                    <div class="<?php echo $sl_class; ?>" data-autoplay="<?php echo $autoplay; ?>" data-navigation="true" data-delay="<?php echo $prk_fount_options['delay_portfolio']; ?>" data-color="<?php echo $featured_color; ?>">
                                       <?php
                                            $imgs_width=$prk_fount_options['custom_width']-48*2;
                                            if ($imgs_width<690)
                                                $imgs_width=690;
                                                $ext_count=0;
                                                if (get_field('skip_featured')=="")
                                                {
                                                    if (has_post_thumbnail( $post->ID ) )
                                                    {
                                                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                                                        //$image[0] = get_image_path($image[0]);
                                                        $in_ttl="";
                                                        $alt_text="";
                                                        if ( $thumb = get_post_thumbnail_id() )
                                                        {
                                                            $in_ttl=get_post($thumb)->post_title;
                                                            $alt_text=get_post_meta($thumb, '_wp_attachment_image_alt', true);
                                                        }
                                                        echo '<div id="slide_1" class="item">';
                                                        $ext_count=1;
                                                        $vt_image = vt_resize( get_post_thumbnail_id( $post->ID ), '' , $imgs_width, '', false , $retina_flag );
                                                        echo '<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="'.prk_get_img_alt($image[0]).'" />';
                                                        echo '</div>';
                                                    }
                                                }
                                                if (get_field('use_gallery')!="images_only")
                                                {
                                                    //PLACE THE OTHER NINETEEN IMAGES
                                                    for ($count=2;$count<21;$count++)
                                                    {
                                                        if (get_field('image_'.$count)!="")
                                                        {
                                                            $ext_count++;
                                                            echo '<div id="slide_'.$ext_count.'" class="item">';
                                                            $in_image=wp_get_attachment_image_src(get_field('image_'.$count),'full');
                                                            $vt_image = vt_resize( '', $in_image[0] , $imgs_width, '', false , $retina_flag );
                                                            echo '<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="'.prk_get_img_alt($in_image[0]).'" />';
                                                            echo "</div>";
                                                        }
                                                        if (get_field('video_'.$count)!="")
                                                        {
                                                            $ext_count++;
                                                            echo '<div id="slide_'.$ext_count.'" class="item slide_video">';
                                                            $el_class='prk-video-container';
                                                            if (strpos(get_field('video_'.$count),'soundcloud.com') !== false) {
                                                              $el_class= 'soundcloud-container';
                                                            }
                                                            echo "<div class='".$el_class."'>";
                                                            echo get_field('video_'.$count);
                                                            echo "</div></div>";
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $regex = '/(\w+)\s*=\s*"(.*?)"/';
                                                    $pattern = '/\[gallery(.*?)\]/';
                                                    preg_match_all($regex, get_post_meta($post->ID,'image_gallery',true), $matches);
                                                    $stripped_gallery = array();
                                                    for ($i = 0; $i < count($matches[1]); $i++) {
                                                        $stripped_gallery[$matches[1][$i]] = $matches[2][$i];
                                                    }
                                                    if (!empty($stripped_gallery) && $stripped_gallery['ids']!="")
                                                    {
                                                        $array = explode(',', $stripped_gallery['ids']);
                                                        foreach($array as $value)
                                                        {
                                                            $ext_count++;
                                                            echo '<div id="slide_'.$ext_count.'" class="item">';
                                                            $in_image=wp_get_attachment_image_src($value,'full');
                                                            $vt_image = vt_resize( '', $in_image[0] , $imgs_width, '', false , $retina_flag );
                                                            echo '<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="'.prk_get_img_alt($in_image[0]).'" />';
                                                            echo "</div>";
                                                        }
                                                    }
                                                }
                                            ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div> 
                                <div class="small-12 columns prk_inner_block small-centered"> 
                            <div id="prk_full_size_single" class="row">
                                <?php
                                    if ($main_layout=="wide")
                                    {
                                        echo '<div class="small-9 columns">';
                                    }
                                    else
                                    {
                                        echo '<div class="small-12 columns">';
                                    }
                                ?>
                                <h1 id="folio_ttl_low" class="header_font bd_headings_text_shadow zero_color head_center_text">
                                    <?php the_title(); ?>
                                </h1>
                                <div class="clearfix"></div>
                                <h4 class="project_heading header_font bd_headings_text_shadow zero_color prk_heavier_700">
                                    <?php echo $prk_translations['prj_desc_text']; ?>
                                </h4>
                                <div class="clearfix"></div>
                                    <div id="single_entry_content" class="prk_no_composer prk_break_word<?php if(!has_shortcode(get_the_content(),'vc_row')) {echo " prk_composer_extra";} ?>">
                                        <?php the_content(); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <?php
                                    if ($main_layout=="wide")
                                    {
                                        ?>
                                        <div id="full-entry-right" class="columns small-3">
                                            <div class="simple_line show_later"></div>
                                            <h4 class="project_heading header_font bd_headings_text_shadow zero_color prk_heavier_700 prk_invisible hide_later">
                                                <?php echo "Details" ?>
                                            </h4>
                                            <div class="clearfix"></div>
                                                <?php
                                                    $line_counter=0;
                                                    if ($prk_fount_options['share_portfolio']=="1")
                                                    {
                                                        echo '<div id="single_folio_sharer" class="fount_sharing_panel clearfix">';
                                                        ?>
                                                       <div class="prk_sharrre_wrapper left_floated">
                                                        <?php if (isset($prk_fount_options['share_portfolio_fb']) && $prk_fount_options['share_portfolio_fb']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_facebook colorer-facebook" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        <?php if (isset($prk_fount_options['share_portfolio_goo']) && $prk_fount_options['share_portfolio_goo']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_google colorer-google" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        <?php if (isset($prk_fount_options['share_portfolio_lnk']) && $prk_fount_options['share_portfolio_lnk']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_linkedin colorer-linkedin" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        <?php 
                                                            if (isset($prk_fount_options['share_portfolio_pin']) && $prk_fount_options['share_portfolio_pin']=="1") 
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
                                                        <?php if (isset($prk_fount_options['share_portfolio_stu']) && $prk_fount_options['share_portfolio_stu']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_stumbleupon colorer-stumbleupon" data-url="<?php the_permalink(); ?>" data-text="<?php echo get_the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                        
                                                        <?php if (isset($prk_fount_options['share_portfolio_twt']) && $prk_fount_options['share_portfolio_twt']=="1")  { ?>
                                                        <div class="fount_socialink prk_sharrre_twitter colorer-twitter" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-title="share">
                                                        </div>
                                                        <?php } ?>
                                                </div>
                                                        <?php
                                                      echo '</div>';
                                                    }
                                                    if ($prk_fount_options['dateby_port']=="1")
                                                    {
                                                        echo '<div class="fount_info_block clearfix">';
                                                        echo '<div class="left_floated header_font">';
                                                        echo '<span class="prk_heavier_700 zero_color">'.$prk_translations['date_text'].':&nbsp;&nbsp;</span>';
                                                        echo '<span class="default_color">';
                                                        echo the_date();
                                                        echo '</span></div></div>';
                                                        $line_counter++;
                                                    }
                                                    if ($prk_fount_options['categoriesby_port']=="1")
                                                    {
                                                        if (get_the_term_list(get_the_ID(),'pirenko_skills')!="")
                                                        {
                                                            $terms = $terms = wp_get_object_terms(get_the_ID(),'pirenko_skills');
                                                            $count = count($terms);
                                                            if ($count>0) {
                                                                if ($line_counter>0)
                                                                {
                                                                    echo '<div class="simple_line on_folio"></div>';
                                                                }
                                                                $line_counter++;
                                                                echo '<div class="fount_info_block clearfix">';
                                                                echo '<div class="left_floated header_font">';
                                                                echo '<span class="prk_heavier_700 zero_color">'.$prk_translations['skills_text'].':&nbsp;&nbsp;</span>';
                                                                $in_count=0;
                                                                echo '<span class="default_color">';
                                                                foreach ( $terms as $term ) {
                                                                    if ($in_count>0)
                                                                        echo ", ";
                                                                    echo '' . $term->name . '';
                                                                    $in_count++;
                                                                }
                                                                echo '<span></div></div>';
                                                            }
                                                        }
                                                    }
                                                    if (wp_get_object_terms(get_the_ID(),'portfolio_tag')!="") {
                                                        $terms = wp_get_object_terms(get_the_ID(),'portfolio_tag');
                                                        $count = count($terms);
                                                        if ($count>0) {
                                                            if ($line_counter>0)
                                                            {
                                                                echo '<div class="simple_line on_folio"></div>';
                                                            }
                                                            $line_counter++;
                                                            echo '<div id="fount_single_tags" class="fount_info_block clearfix">';
                                                            echo '<div class="left_floated header_font">';
                                                            echo '<span class="prk_heavier_700 zero_color">'.$prk_translations['tags_text'].':&nbsp;&nbsp;</span>';
                                                            echo '<span class="default_color">';
                                                            $in_count=0;
                                                            foreach ( $terms as $term ) {
                                                                if ($in_count>0)
                                                                    echo ", ";
                                                                echo '' . $term->name . '';
                                                                $in_count++;
                                                            }
                                                            echo '</span></div></div>';
                                                        }
                                                    }
                                                    if (get_field('client_url')!="")
                                                    {
                                                        if ($line_counter>0)
                                                        {
                                                            echo '<div class="simple_line on_folio"></div>';
                                                        }
                                                        echo '<div class="fount_info_block clearfix">';
                                                        echo '<div class="left_floated header_font">';
                                                        echo '<span class="prk_heavier_700 zero_color">'.$prk_translations['client_text'].':&nbsp;&nbsp;</span>';
                                                        echo '<span class="default_color">'.get_field('client_url').'</span>';
                                                        echo '</div></div>';
                                                        $line_counter++;
                                                    }
                                                    if (get_field('ext_url')!="") 
                                                    {
                                                        //ADD HTTP PREFIX IF NEEDED
                                                        if (substr(get_field('ext_url'),0,7)!="http://" && substr(get_field('ext_url'),0,8)!="https://")
                                                            $final_url="http://".get_field('ext_url');
                                                        else
                                                            $final_url=get_field('ext_url');
                                                        if ($line_counter>0)
                                                        {
                                                            echo '<div class="simple_line on_folio"></div>';
                                                        }
                                                        echo '<div class="fount_info_block clearfix">';
                                                        echo '<div class="left_floated header_font">';
                                                        echo '<span class="prk_heavier_700 zero_color">'.$prk_translations['project_text'].':&nbsp;&nbsp;</span>';
                                                        $popup="_blank";
                                                        if (get_field('new_window')=="_self") {
                                                            $popup="_self";
                                                        }
                                                        echo '<a href="'.$final_url.'" target="'.$popup.'" data-color="'.$featured_color.'">';
                                                        if (get_field('ext_url_label')!="") 
                                                        {
                                                            echo get_field('ext_url_label');
                                                        }
                                                        else 
                                                        {
                                                            
                                                            echo $prk_translations['launch_text'];
                                                        }
                                                        echo '</a></div></div>';
                                                    }
                                                    ?>
                                    </div>
                                    <?php
                                    }
                                ?>
                            </div>
                            <div class="clearfix"></div>
                            </div>
                            <div class="fount_navigation_singles hide_now">
                                    <div class="navigation_previous_portfolio">
                                        <?php next_post_link_plus( array(
                                            'order_by' => 'menu_order',
                                            'in_same_cat' => $in_cat,
                                            'format' => '%link',
                                            'link' => '%title',
                                            'loop' => true,
                                            ) );
                                        ?>
                                    </div>
                                    <div class="navigation_next_portfolio">
                                            <?php previous_post_link_plus( array(
                                                'order_by' => 'menu_order',
                                                'in_same_cat' => $in_cat,
                                                'format' => '%link',
                                                'link' => '%title',
                                                'loop' => true,
                                                ) );
                                            ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="after_single_folio" class="row">
                            <div class="small-12 columns prk_inner_block small-centered">
                                <?php if (comments_open())
                                    {    
                                        comments_template();
                                    }
                                    echo prk_related_projects($post->ID);
                                ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </article>
                    </div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>   
            <?php
        }
    endwhile; /* End loop */
?>
<?php get_footer(); ?>
