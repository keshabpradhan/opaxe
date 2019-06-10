<div class="senior-management"><a href="/senior-management">Senior Management</a></div>
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
    //GET THEME CUSTOM FIELDS INFO
    $show_image="yes";
    if (get_field('show_member_image')!="1")
    {
        $show_image="no";
    }
    $sl_class="not_slider";
    if (get_field('featured_color')!="" && $prk_fount_options['use_custom_colors']=="1")
    {
        $featured_color=get_field('featured_color');
        $featured_class='featured_color';
    }
    else
    {
        $featured_color="default";
        $featured_class="";
    };
    while (have_posts()) : the_post();
        if (get_field('member_layout')=="regular")
        {
            ?>
            <div id="centered_block" class="prk_no_change forced_menu"> 
            <div id="main_block" class="row page-<?php echo get_the_ID(); ?>">   

                <div id="content">
                    <div id="main" role="main">

                            <?php 
                                if ($show_image=="yes")
                                {
                                    echo '<div class="clearfix bt_15gutter"></div>';
					

                                    echo '<div class="small-12 columns prk_inner_block small-centered">';
                                    if ($show_sidebar) {
                                        echo '<div class="row">';
                                        echo '<div class="small-9 columns">';
                                    }
                                ?>
	
                                    <div id="not_slider">
                                        <ul class="slides unstyled">
                                            <?php
                                                if (get_field('image_2')!="")
                                                {
                                                    $in_image=wp_get_attachment_image_src(get_field('image_2'),'full');
                                                    echo '<li class="boxed_shadow"><img src="'.$in_image[0].'" alt="" /></li>';
                                                }
                                                else
                                                {
                                                    if (has_post_thumbnail( $post->ID ) )
                                                    {
                                                        $in_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail' );
                                                        ?>
                                                        <li class="boxed_shadow">
                                                            <img src="<?php echo $in_image[0]; ?>" alt="" />
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>   
                                    <?php
                                }
                                else
                                {
                                    echo '<div class="clearfix bt_15"></div>';
                                }
                            ?>  
                            <div class="clearfix"></div> 

                                <div id="member_full_row" data-color="<?php echo $featured_color; ?>" class="row">
                                <div id="member_resume" class="prk_member small-3 columns">
                                <div id="member_post_title">
                                    <h2 class="header_font bd_headings_text_shadow zero_color small">
                                        <?php the_title(); ?>
                                    </h2>
                                </div>
                                <?php
                                    if (get_field('member_job')!="")
                                    {
                                        echo '<div class="prk_button_like header_font site_background_colored">';
                                        echo get_field('member_job');
                                        echo '</div>';
                                    }
                                    else
                                    {
                                        echo '<div class="clearfix bt_20"></div>';
                                    }
                                ?>           
                                <div class="clearfix"></div>
                                <?php
                                    if (get_field('member_email')!="" || get_field('member_social_1')!="none" || get_field('member_social_2')!="none" || get_field('member_social_3')!="none" || get_field('member_social_4')!="none" || get_field('member_social_5')!="none" || get_field('member_social_6')!="none") {
                                        echo '<div id="in_touch" class="header_font zero_color prk_heavier_600 bd_headings_text_shadow">';
                                        echo($prk_translations['in_touch_text']);
                                        echo '</div>';
                                    }
                                ?>
                                <div class="member_social_wrapper">
                                <?php
                                        if (get_field('member_email')!="")
                                        {
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount_fa-envelope-o colorer-envelope">
                                                <a href="mailto:<?php echo get_field('member_email'); ?>" data-color="#3498db">
                                                    <div class="fount_fa-envelope-o">
                                                        
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="fount_fa-envelope-o"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_1')!="none")
                                        {
                                            if (get_field('member_social_1_link')!="")
                                                $in_link=get_field('member_social_1_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_1'); ?> colorer-<?php echo get_field('member_social_1'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_1')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_1')); ?>">
                                                        
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_1')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_2')!="none")
                                        {
                                            if (get_field('member_social_2_link')!="")
                                                $in_link=get_field('member_social_2_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_2'); ?> colorer-<?php echo get_field('member_social_2'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_2')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_2')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_2')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_3')!="none")
                                        {
                                            if (get_field('member_social_3_link')!="")
                                                $in_link=get_field('member_social_3_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_3'); ?> colorer-<?php echo get_field('member_social_3'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_3')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_3')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_3')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_4')!="none")
                                        {
                                            if (get_field('member_social_4_link')!="")
                                                $in_link=get_field('member_social_4_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_4'); ?> colorer-<?php echo get_field('member_social_4'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_4')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_4')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_4')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_5')!="none")
                                        {
                                            if (get_field('member_social_5_link')!="")
                                                $in_link=get_field('member_social_5_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_5'); ?> colorer-<?php echo get_field('member_social_5'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_5')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_5')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_5')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_6')!="none")
                                        {
                                            if (get_field('member_social_6_link')!="")
                                                $in_link=get_field('member_social_6_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_6'); ?> colorer-<?php echo get_field('member_social_6'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_6')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_6')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_6')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                    <div id="member-<?php the_ID(); ?>" <?php post_class('small-9 columns'); ?>>
                        <div id="fount_member_description">
                            <?php the_content(); ?> 
                            <div class="clearfix"></div>          
                        </div>
                        <div id="single_meta_footer"> 
                            <div class="fount_navigation_singles prk_heavier_600 header_font zero_color bd_headings_text_shadow smoothed_anchor">
                            <div class="simple_line"></div>
                            <div class="navigation-previous-blog left_floated">
                                <?php next_post_link_plus( array(
                                    'order_by' => 'menu_order',
                                    'in_same_cat' => true,
                                    'format' => '%link',
                                    'link' => '<i class="left_floated fount_fa-chevron-left"></i><div class="left_floated">%title</div>'
                                    ) );
                                ?>
                            </div>
                            <div class="navigation-next-blog right_floated">
                                <?php previous_post_link_plus( array(
                                    'order_by' => 'menu_order',
                                    'in_same_cat' => true,
                                    'format' => '%link',
                                    'link' => '<div class="left_floated bf_icon_blog">%title</div>
                                                      <i class="left_floated fount_fa-chevron-right"></i>'
                                    ) );
                                ?>
                            </div>
                            <div class="clearfix"></div> 
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                if ($show_sidebar) 
                {
                    echo '</div>';
                    ?>
                    <div class="small-12 columns show_later">
                        <div class="simple_line on_sidebar"></div>
                    </div>
                    <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?> on_single_member" role="complementary">
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
    </div>
    <?php
    }
    else if (get_field('member_layout')=="big_image")
        {
            ?>
            <div id="centered_block" class="prk_no_change forced_menu"> 
            <div id="main_block" class="row page-<?php echo get_the_ID(); ?>">   
                <div id="content">
                    <div id="main" role="main">
                            <?php 
                                if ($show_image=="yes")
                                {
                                    ?>
                                    <div id="not_slider">
                                        <ul class="slides unstyled">
                                            <?php
                                                if (get_field('image_2')!="")
                                                {
                                                    $in_image=wp_get_attachment_image_src(get_field('image_2'),'full');
                                                    echo '<li class="boxed_shadow"><img src="'.$in_image[0].'" alt="" /></li>';
                                                }
                                                else
                                                {
                                                    if (has_post_thumbnail( $post->ID ) )
                                                    {
                                                        $in_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail' );
                                                        ?>
                                                        <li class="boxed_shadow">
                                                            <img src="<?php echo $in_image[0]; ?>" alt="" />
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>   
                                    <?php
                                }
                                else
                                {
                                    echo '<div class="clearfix bt_15"></div>';
                                }
                            ?>  
                            <div class="clearfix"></div> 
                        <div class="small-12 columns prk_inner_block small-centered">
                            <?php
                                if ($show_sidebar) {
                                    echo '<div class="row">';
                                    echo '<div class="small-9 columns">';
                                    }
                            ?>
                                <div id="member_full_row" data-color="<?php echo $featured_color; ?>" class="row">
                                <div id="member_resume" class="prk_member small-3 columns">
                                <div id="member_post_title">
                                    <h2 class="header_font bd_headings_text_shadow zero_color small">
                                        <?php the_title(); ?>
                                    </h2>
                                </div>
                                <?php
                                    if (get_field('member_job')!="")
                                    {
                                        echo '<div class="prk_button_like header_font site_background_colored">';
                                        echo get_field('member_job');
                                        echo '</div>';
                                    }
                                    else
                                    {
                                        echo '<div class="clearfix bt_20"></div>';
                                    }
                                ?>           
                                <div class="clearfix"></div>
                                <?php 
                                    if (get_field('member_email')!="" || get_field('member_social_1')!="none" || get_field('member_social_2')!="none" || get_field('member_social_3')!="none" || get_field('member_social_4')!="none" || get_field('member_social_5')!="none" || get_field('member_social_6')!="none")
                                    {
                                        echo '<div id="in_touch" class="header_font zero_color prk_heavier_600 bd_headings_text_shadow">';
                                        echo($prk_translations['in_touch_text']);
                                        echo '</div>';
                                        echo '<div class="member_social_wrapper">';
                                        if (get_field('member_email')!="")
                                        {
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount_fa-envelope-o colorer-envelope">
                                                <a href="mailto:<?php echo get_field('member_email'); ?>" data-color="#3498db">
                                                    <div class="fount_fa-envelope-o">
                                                        
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="fount_fa-envelope-o"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_1')!="none")
                                        {
                                            if (get_field('member_social_1_link')!="")
                                                $in_link=get_field('member_social_1_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_1'); ?> colorer-<?php echo get_field('member_social_1'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_1')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_1')); ?>">
                                                        
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_1')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_2')!="none")
                                        {
                                            if (get_field('member_social_2_link')!="")
                                                $in_link=get_field('member_social_2_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_2'); ?> colorer-<?php echo get_field('member_social_2'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_2')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_2')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_2')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_3')!="none")
                                        {
                                            if (get_field('member_social_3_link')!="")
                                                $in_link=get_field('member_social_3_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_3'); ?> colorer-<?php echo get_field('member_social_3'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_3')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_3')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_3')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_4')!="none")
                                        {
                                            if (get_field('member_social_4_link')!="")
                                                $in_link=get_field('member_social_4_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_4'); ?> colorer-<?php echo get_field('member_social_4'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_4')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_4')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_4')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_5')!="none")
                                        {
                                            if (get_field('member_social_5_link')!="")
                                                $in_link=get_field('member_social_5_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_5'); ?> colorer-<?php echo get_field('member_social_5'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_5')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_5')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_5')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_6')!="none")
                                        {
                                            if (get_field('member_social_6_link')!="")
                                                $in_link=get_field('member_social_6_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_6'); ?> colorer-<?php echo get_field('member_social_6'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_6')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_6')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_6')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                            </div>
                    <div id="member-<?php the_ID(); ?>" <?php post_class('small-9 columns'); ?>>
                        <div id="fount_member_description" class="on_colored prk_no_composer prk_break_word<?php if(!has_shortcode(get_the_content(),'vc_row')) {echo " prk_composer_extra";} ?>">
                            <?php the_content(); ?> 
                            <div class="clearfix"></div>          
                        </div>
                        <div id="single_meta_footer"> 
                            <div class="fount_navigation_singles prk_heavier_600 header_font zero_color bd_headings_text_shadow smoothed_anchor">
                            <div class="simple_line"></div>
                            <div class="navigation-previous-blog left_floated">
                                <?php next_post_link_plus( array(
                                    'order_by' => 'menu_order',
                                    'in_same_cat' => true,
                                    'format' => '%link',
                                    'link' => '<i class="left_floated fount_fa-chevron-left"></i><div class="left_floated">%title</div>'
                                    ) );
                                ?>
                            </div>
                            <div class="navigation-next-blog right_floated">
                                <?php previous_post_link_plus( array(
                                    'order_by' => 'menu_order',
                                    'in_same_cat' => true,
                                    'format' => '%link',
                                    'link' => '<div class="left_floated bf_icon_blog">%title</div>
                                                      <i class="left_floated fount_fa-chevron-right"></i>'
                                    ) );
                                ?>
                            </div>
                            <div class="clearfix"></div> 
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                if ($show_sidebar) 
                {
                    echo '</div>';
                    ?>
                    <div class="small-12 columns show_later">
                        <div class="simple_line on_sidebar"></div>
                    </div>
                    <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?> on_single_member" role="complementary">
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
    </div>
    <?php
    }
    else
    {
        ?>
        <div id="centered_block" class="prk_no_change forced_menu"> 
            <div id="main_block" class="row page-<?php echo get_the_ID(); ?>">   
                <div id="content">
                    <div id="main" role="main">
                        <div class="clearfix bt_40"></div>
                        <div class="small-12 columns prk_inner_block small-centered">
                            <div class="row">
                            <?php 
                                if ($show_image=="yes")
                                {
                                    echo '<div class="small-5 columns">';
                                    ?>
                                    <div id="not_slider">
                                        <ul class="slides unstyled">
                                            <?php
                                                if (get_field('image_2')!="")
                                                {
                                                    $in_image=wp_get_attachment_image_src(get_field('image_2'),'full');
                                                    echo '<li class="boxed_shadow"><img src="'.$in_image[0].'" alt="" /></li>';
                                                }
                                                else
                                                {
                                                    if (has_post_thumbnail( $post->ID ) )
                                                    {
                                                        $in_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail' );
                                                        ?>
                                                        <li class="boxed_shadow">
                                                            <img src="<?php echo $in_image[0]; ?>" alt="" />
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>   
                                    <?php
                                    echo '</div>';
                                }
                            ?>  
                        <div class="small-7 columns">
                                <div id="member_full_row" data-color="<?php echo $featured_color; ?>">
                                <div id="member_resume" class="prk_member">
                                <div id="member_post_title">
                                    <h2 class="header_font bd_headings_text_shadow zero_color small">
                                        <?php the_title(); ?>
                                    </h2>
                                </div>
                                <?php
                                    if (get_field('member_job')!="")
                                    {
                                        echo '<div class="prk_button_like header_font site_background_colored">';
                                        echo get_field('member_job');
                                        echo '</div>';
                                    }
                                    else
                                    {
                                        echo '<div class="clearfix bt_20"></div>';
                                    }
                                ?>           
                                <div class="clearfix"></div>
                            </div>
                            <div id="member-<?php the_ID(); ?>" <?php post_class(); ?>>                          
                                <div id="fount_member_description" class="on_colored prk_no_composer prk_break_word<?php if(!has_shortcode(get_the_content(),'vc_row')) {echo " prk_composer_extra";} ?>">
                                    <?php the_content(); ?>           
                                </div>
                                <?php
                                if (get_field('member_email')!="" || get_field('member_social_1')!="none" || get_field('member_social_2')!="none" || get_field('member_social_3')!="none" || get_field('member_social_4')!="none" || get_field('member_social_5')!="none" || get_field('member_social_6')!="none")
                                    {
                                        echo '<div id="member_half_social">';
                                        echo '<div class="header_font small_headings_color smaller_font prk_heavier_500">';
                                        echo($prk_translations['in_touch_text']);                                        
                                        echo '</div>';
                                        echo '<div class="member_social_wrapper">';
                                        if (get_field('member_email')!="")
                                        {
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount_fa-envelope-o colorer-envelope">
                                                <a href="mailto:<?php echo get_field('member_email'); ?>" data-color="#3498db">
                                                    <div class="fount_fa-envelope-o">
                                                        
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="fount_fa-envelope-o"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_1')!="none")
                                        {
                                            if (get_field('member_social_1_link')!="")
                                                $in_link=get_field('member_social_1_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_1'); ?> colorer-<?php echo get_field('member_social_1'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_1')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_1')); ?>">
                                                        
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_1')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_2')!="none")
                                        {
                                            if (get_field('member_social_2_link')!="")
                                                $in_link=get_field('member_social_2_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_2'); ?> colorer-<?php echo get_field('member_social_2'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_2')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_2')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_2')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_3')!="none")
                                        {
                                            if (get_field('member_social_3_link')!="")
                                                $in_link=get_field('member_social_3_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_3'); ?> colorer-<?php echo get_field('member_social_3'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_3')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_3')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_3')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_4')!="none")
                                        {
                                            if (get_field('member_social_4_link')!="")
                                                $in_link=get_field('member_social_4_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_4'); ?> colorer-<?php echo get_field('member_social_4'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_4')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_4')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_4')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_5')!="none")
                                        {
                                            if (get_field('member_social_5_link')!="")
                                                $in_link=get_field('member_social_5_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_5'); ?> colorer-<?php echo get_field('member_social_5'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_5')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_5')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_5')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        if (get_field('member_social_6')!="none")
                                        {
                                            if (get_field('member_social_6_link')!="")
                                                $in_link=get_field('member_social_6_link');
                                            else
                                                $in_link="";
                                            ?>
                                            <div class="fount_socialink prk_bordered member_lnk small_headings_color fount-<?php echo get_field('member_social_6'); ?> colorer-<?php echo get_field('member_social_6'); ?>">
                                                <a href="<?php echo $in_link; ?>" target="_blank" data-color="<?php echo prk_social_color(get_field('member_social_6')); ?>">
                                                    <div class="<?php echo prk_social_icon(get_field('member_social_6')); ?>">
                                                    </div>
                                                    <div class="bg_shifter">
                                                        <i class="<?php echo prk_social_icon(get_field('member_social_6')); ?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        echo '<div class="clearfix"></div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                ?>
                                <div class="clearfix"></div>
                                <div id="single_meta_footer"> 
                                    <div class="fount_navigation_singles prk_heavier_600 header_font zero_color bd_headings_text_shadow smoothed_anchor">
                                        <div class="simple_line"></div>
                                        <div class="navigation-previous-blog fade_anchor left_floated">
                                            <?php next_post_link_plus( array(
                                                'order_by' => 'menu_order',
                                                'in_same_cat' => true,
                                                'format' => '%link',
                                                'link' => '<i class="left_floated fount_fa-chevron-left"></i><div class="left_floated">%title</div>'
                                                ) );
                                            ?>
                                        </div>
                                        <div class="navigation-next-blog right_floated bd_headings_text_shadow zero_color fade_anchor">
                                            <?php previous_post_link_plus( array(
                                                'order_by' => 'menu_order',
                                                'in_same_cat' => true,
                                                'format' => '%link',
                                                'link' => '<div class="left_floated bf_icon_blog">%title</div>
                                                                  <i class="left_floated fount_fa-chevron-right"></i>'
                                                ) );
                                            ?>
                                        </div>
                                        <div class="clearfix"></div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div> 
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        <?php
    }
    endwhile; /* End loop */ ?>
<?php get_footer(); ?>