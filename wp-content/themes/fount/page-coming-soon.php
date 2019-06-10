<?php
/*
Template Name: Page - Coming Soon
*/
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
  <?php
        $count = wp_count_posts('post'); 
        if ($count->publish > 0) 
        {
          echo "\n\t<link rel=\"alternate\" type=\"application/rss+xml\" title=\"". get_bloginfo('name') ." Feed\" href=\"". home_url() ."/feed/\">\n";
        } 
        global $prk_fount_options;
        global $prk_retina_device;
        global $prk_translations;
        prk_fount_header();
        if ($prk_fount_options['buttons_inner_shadow']=="1" && $prk_fount_options['buttons_style']=="solid_buttons") 
            $buttons_class=" shadowed_buttons";
        else
            $buttons_class="";
        wp_head(); 
    ?>
</head>
<body <?php body_class('fount_theme'); ?>>
    <div id="prk_ajax_container" data-ajax_path="<?php echo get_template_directory_uri() ?>/inc/ajax-handler.php" data-retina="<?php echo $prk_retina_device; ?>" class="fount_coming">
        <?
        global $prk_retina_device;
        $retina_flag = $prk_retina_device === "prk_retina" ? true : false;
        $show_title=true;
        if (get_field('hide_title')=="1") {
        $show_title=false;
        }
        //OVERRIDE OPTIONS - ONLY FOR PREVIEW MODE
        if (INJECT_STYLE)
        {
        include_once(ABSPATH . 'wp-content/plugins/color-manager-fount/style_header.php');    
        }
        ?>
        <div id="centered_block"> 
            <div id="main_block" class="row header_font page-<?php echo get_the_ID(); ?>">
                <?php
                    if (get_field('image_logo')!="") {
                        $image_logo=wp_get_attachment_image_src(get_field('image_logo'),'full');
                        ?>
                            <div id="coming_logo">
                                <img src="<?php echo $image_logo[0]; ?>" alt="" />
                            </div>
                        <?php
                    }
                ?>
                <div id="coming_title" class="not_zero_color"><h1><?php the_title(); ?></h1></div>
            </div>
        </div>
        <div id="fount_countdown_wrapper" data-color="<?php echo get_field('text_color'); ?>">
            <?php
                $launch_date=get_field('launch_date');
                if ($launch_date!="") {
                    $year=substr($launch_date, 0, 4);
                    $month=substr($launch_date, 4, 2);
                    $day=substr($launch_date, 6, 2);
                    echo '<div id="fount_countdown"></div>';
                }
                else {
                    $year=$month=$day="0";
                }
            ?>
            <?php
                if (get_field('below_headings_text')!="") {
                    ?>
                        <div id="fount_countdown_text" class="body_font">
                            <?php echo do_shortcode(get_field('below_headings_text')); ?>
                        </div>
                    <?php
                }
            ?>
        </div>
        <?php
            while (have_posts()) : the_post();
            if (get_the_content()!="") {
                ?>
                <div id="fount_countdown_footer">
                    <?php the_content(); ?>
                </div>
                <?php
            }
            endwhile;
            if (get_field('image_back')!="") {
                $image=wp_get_attachment_image_src(get_field('image_back'),'full');
                ?>
                    <div id="fount_full_back" data-image="<?php echo $image[0]; ?>"></div>
                <?php
            }
        ?>
    </div>
    <script>
        jQuery(function () {
            var custom_date = new Date(); 
            custom_date = new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $day; ?>); 
            jQuery('#fount_countdown').countdown({
                until: custom_date
            }); 
        });
    </script>
    <?php 
    if (isset($prk_fount_options['ganalytics_text']) && $prk_fount_options['ganalytics_text']!="") {
        echo $prk_fount_options['ganalytics_text'];
    }
    wp_footer(); 
    ?>
</body>
</html>