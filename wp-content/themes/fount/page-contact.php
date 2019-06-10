<?php
/*
Template Name: Page - Contact
*/
?>
<?php 
    get_header();
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
<div id="centered_block" class="forced_menu"> 
<div id="main_block" class="row page-<?php echo get_the_ID(); ?>">
    <?php
        if (get_field('content_type')=='map')
        {
            if (get_field('marker_image')!="")
                $in_image=wp_get_attachment_image_src(get_field('marker_image'),'full');
            else
                $in_image[0]="";
            echo '<div id="google-maps-cover"><div id="google_maps_'.rand(1, 1000).'" class="google_maps twelve '.get_field('contact_layout').'" data-type="'.get_field('map_type').'" data-style="'.get_field('map_style').'" data-zoom="'.get_field('zoom_level').'" data-lat="'.get_field('map_latitude').'" data-long="'.get_field('map_longitude').'" data-marker="'.$in_image[0].'" data-marker_image_lat="'.get_field('marker_image_lat').'" data-marker_image_long="'.get_field('marker_image_long').'" data-map_height="'.get_field('map_height').'">';
            echo '<div class="spinner"><div class="spinner-icon"></div></div>';
            echo '</div></div>';
        }
        if (get_field('content_type')=='image')
        {
            if (get_field('map_image')!="")
                $in_image=wp_get_attachment_image_src(get_field('map_image'),'full');
            else
                $in_image[0]="";
            $vt_image = vt_resize( '', $in_image[0] , 1920, 0, false , $retina_flag );
            echo '<div id="contact-image-fth" class="twelve '.get_field('contact_layout').'">';
            echo '<img id="contact-image-cover" src="'.$vt_image['url'].'" data-or_w="'. $vt_image['width'] .'" data-or_h="'. $vt_image['height'] .'" alt="'.prk_get_img_alt($in_image[0]).'" />';
            echo '</div>';
        }
        if ($show_title==true)
        {
            echo '<div class="prk_inner_block small-12 small-centered columns">';
            prk_output_title("advanced");
            echo '</div>';
        }
        else
        {
           echo '<div class="clearfix bt_15gutter"></div>'; 
        }
        ?>
        <div id="content">
            <div id="main">
                <div class="small-12 columns small-centered prk_inner_block">
                    <?php
                        while (have_posts()) : the_post();
                            if (get_the_content()!="")
                            {
                                ?>
                                <div class="single-entry-content">
                                    <?php the_content(); ?>
                                </div>
                                <?php
                            }
                            else
                            {
                                echo '<div class="clearfix bt_40 hide_later"></div>';
                                echo '<div class="clearfix bt_12 show_later"></div>';
                            }
                        endwhile;
                    ?>
                    <div class="clearfix"></div>
                    <div id="contact_lower" class="row">
                        <div id="contact_description" class="small-9 columns">
                            <div id="contact_form">
                                <?php
                                    if (get_field('info_title_form')!="")
                                    {
                                        ?>
                                        <h3 class="header_font bd_headings_text_shadow zero_color small prk_heavier_600">
                                            <?php echo get_field('info_title_form'); ?>
                                        </h3>
                                        <div class="simple_line contacted"></div>
                                        <?php
                                    }
                                    if (get_field('contact-form-teaser')!="")
                                    {
                                        ?>
                                        <div class="small-12 fount_extra_description">
                                            <?php echo get_field('contact-form-teaser'); ?>
                                        </div>
                                        <?php
                                    }
                                    echo '<div class="clearfix"></div>';
                                    if (get_field('contact-shortcode')!="") 
                                    {
                                        echo do_shortcode(get_field('contact-shortcode'));
                                    }
                                    else
                                    {
                                        ?>
                                        <form action="#" id="contact-form" method="post" data-empty='<?php echo esc_attr($prk_translations['empty_text_error']); ?>' data-invalid='<?php echo esc_attr($prk_translations['invalid_email_error']); ?>' data-ok='<?php echo esc_attr($prk_translations['contact_ok_text']); ?>' data-name='<?php bloginfo('name'); ?>'>
                                            <div class="row">
                                                <div class="six columns">
                                                    <input type="text" class="pirenko_highlighted" name="c_name" id="c_name" 
                                                    placeholder="<?php echo esc_attr($prk_translations['comments_author_text']);echo esc_attr($prk_translations['required_text']); ?>"  data-original="<?php echo esc_attr($prk_translations['comments_author_text']);echo esc_attr($prk_translations['required_text']); ?>" />
                                                </div>
                                                <div class="six columns">
                                                        <input type="text" class="pirenko_highlighted" name="c_email" id="c_email" size="28"                           placeholder="<?php echo esc_attr($prk_translations['comments_email_text']);echo esc_attr($prk_translations['required_text']); ?>"/>
                                                </div>
                                                <div class="twelve columns">
                                                    <input type="text" class="pirenko_highlighted" name="c_subject" id="c_subject" size="28"
                                                    placeholder="<?php echo esc_attr($prk_translations['contact_subject_text']); ?>" />
                                                
                                                    <textarea class="pirenko_highlighted" name="c_message" id="c_message" rows="8"
                                                    placeholder="<?php echo esc_attr($prk_translations['contact_message_text']); ?>" data-original="<?php echo esc_attr($prk_translations['contact_message_text']); ?>" ></textarea>
                                               
                                                </div>
                                            </div>
                                            <?php
                                                if (!isset($prk_translations['contact_submit']))
                                                    $prk_translations['contact_submit']='Send Message';
                                            ?>
                                            <input type="hidden" id="full_subject" name="full_subject" value="" />
                                            <input type="hidden" name="rec_email" value="<?php echo antispambot(get_field('prk_email_address')); ?>" />
                                            <div id="contact_ok" class="prk_heavier_600 zero_color header_font bd_headings_text_shadow"><?php echo($prk_translations['contact_wait_text']); ?></div>
                                            <input type="hidden" name="c_submitted" id="c_submitted" value="true" />
                                            <div class="clearfix"></div>
                                            <div id="submit_message_div" class="theme_button">
                                                <a href="#">
                                                    <div class="left_floated">
                                                        <?php echo($prk_translations['contact_submit']); ?>
                                                    </div>
                                                </a>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="contact_side" class="small-3 columns">
                            <div id="contact_address">
                                <?php 
                                    if (get_field('show_contact_information')=="1")
                                    {
                                        if (get_field('contact-info_title')!="")
                                        {
                                            ?>
                                                <h3 class="header_font bd_headings_text_shadow zero_color small prk_heavier_600">
                                                    <?php echo get_field('contact-info_title'); ?>
                                                </h3>
                                                <div class="simple_line contacted"></div>
                                            <?php
                                        }
                                        ?>
                                        <div class="contact_info prk_heavier_600">
                                            <?php
                                                if (get_field('contact-teaser')!="")
                                                {
                                                    ?>
                                                    <div class="small-12 fount_extra_description zero_color prk_heavier_400 default_color">
                                                        <?php echo get_field('contact-teaser'); ?>
                                                    </div>
                                                    <?php
                                                }
                                                if (get_field('contact-company')!="") {
                                                    ?>
                                                        <div class="fount_company_name">
                                                            <h4 class="header_font bd_headings_text_shadow prk_heavier_600 zero_color">
                                                                <?php echo get_field('contact-company'); ?>
                                                            </h4>
                                                        </div>
                                                    <?php
                                                }
                                                if (get_field('contact-address')!="") {
                                                    ?>
                                                    <div class="ctt_address header_font zero_color">
                                                        <?php echo get_field('contact-address'); ?>
                                                    </div>
                                                    <?php
                                                }
                                                if (get_field('contact-company')!="" || get_field('contact-address')!="") {
                                                    ?>
                                                        <div class="simple_line thick membered"></div>
                                                    <?php
                                                }
                                                if (get_field('contact-info_email')!="")
                                                {
                                                    ?>
                                                    <div class="fount_info_block">
                                                        <div class="block_description header_font">
                                                            <a href="mailto:<?php echo antispambot(get_field('contact-info_email')); ?>" class="not_zero_color">
                                                            <?php echo antispambot(get_field('contact-info_email')); ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                if (get_field('contact-info_tel')!="")
                                                {
                                                    ?>
                                                    <div class="fount_info_block">
                                                        <div class="block_description header_font zero_color">
                                                            <?php echo get_field('contact-info_tel'); ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                if (get_field('contact-info_fax')!="")
                                                {
                                                    ?>
                                                    <div class="fount_info_block">
                                                        <div class="block_description header_font zero_color">
                                                            <?php echo get_field('contact-info_fax'); ?>
                                                        
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
</div>
</div>
<?php get_footer(); ?>