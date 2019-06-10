<?php
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (!function_exists('register_field_group')) {
        include_once locate_template('/inc/modules/advanced-custom-fields/acf.php');
    }
    function fount_scripts() {
        if (function_exists('wp_get_theme'))
            $prk_theme = wp_get_theme();
        else
        {
            $prk_theme->Version="1";
        }
        global $prk_fount_options;
        global $prk_select_font_options;
        //OVERRIDE OPTIONS - ONLY FOR PREVIEW MODE
        if (INJECT_STYLE)
        {
            include(ABSPATH . 'wp-content/plugins/color-manager-fount/style_header.php');
        }
        //WOOCOMMERCE STUFF
        if (PRK_WOO=="true") 
        {
            if ($prk_fount_options['woo_cart_display']=="1") {
                add_filter( 'wp_nav_menu_items', 'prk_cart_menu_item', 10, 2 );
            }
            function prk_cart_menu_item ( $items, $args ) {
                //CHANGE ONLY THE MAIN MENU
                global $prk_fount_options;
                if($args->theme_location=='prk_main_navigation' || (isset($prk_fount_options['fount_active_skin']) && $prk_fount_options['fount_active_skin']=="fount_shop_skin")) {
                    global $woocommerce;
                    global $prk_fount_options;
                    $cart_url = $woocommerce->cart->get_cart_url();
                    if ($cart_url=="")
                        $cart_url="#";
                    $cart_contents_count = $woocommerce->cart->cart_contents_count;
                    $cart_contents = sprintf(_n('%d Item', '%d Items', $cart_contents_count, 'fount'), $cart_contents_count);
                    $cart_total = $woocommerce->cart->get_cart_total();
                    if ($cart_contents_count>0 || $prk_fount_options['woo_cart_always_display']=="1")
                    {
                        $items.='<li id="prk_hidden_cart"><a href="'.$cart_url.'">';
                        $items.='<div class="prk_cart_label">';
                        $items.='<i class="fount_fa-shopping-cart"></i>';
                        if ($prk_fount_options['woo_cart_info']=="items")
                            $items.=$cart_contents;
                        if ($prk_fount_options['woo_cart_info']=="" || $prk_fount_options['woo_cart_info']=="price")
                            $items.=$cart_total;
                        if ($prk_fount_options['woo_cart_info']=="both")
                            $items.=$cart_contents.' : '. $cart_total;
                        $items .='</div></a></li>';
                    }
                    return $items;
                }
                else
                {
                    //RETURN THE DEFAULT MENU
                    return $items;
                }
            }
        }
        
        wp_enqueue_style('fount_custom_style', get_template_directory_uri() . '/css/main.css', false, $prk_theme->Version);
        if ($prk_fount_options['prk_responsive']=="1") 
        {
            wp_enqueue_style('pirenko_responsive_style', get_template_directory_uri() . '/css/responsive.css', false, $prk_theme->Version);
        }
        if (is_child_theme())
        {
            wp_enqueue_style('fount_child_styles', get_stylesheet_directory_uri() . '/style.css', false, $prk_theme->Version);
        }
        if (is_single() && comments_open() && get_option('thread_comments')) 
        {
            wp_enqueue_script('comment-reply');
        }
        //time()+(7 * 24 * 60 * 60);
        if (1)
        {
            wp_register_script('fount_main', get_template_directory_uri() . '/js/main-min.js', array('jquery'), $prk_theme->Version, true);
            wp_enqueue_script('fount_main');
        }
        wp_register_script('fount_other', get_template_directory_uri() . '/js/other-min.js', array('jquery'), $prk_theme->Version, true);
        wp_enqueue_script('fount_other');
        if(isset($prk_fount_options['google_maps_key']) && $prk_fount_options['google_maps_key']!="") {
            $gapy='&key='.$prk_fount_options['google_maps_key'];
        }
        else {
            $gapy="";
        }
        //wp_register_script('fount_maps','https://maps.googleapis.com/maps/api/js?sensor=false'.$gapy, array('jquery'), $prk_theme->Version, true);
        wp_enqueue_script('fount_maps');
        
        wp_localize_script('fount_main', 'ajax_var', array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ajax-nonce'),
        ));

        global $prk_portfolio_link;
        $prk_portfolio_link="";
        $prk_blog_linked="";
        if ((is_single() && get_post_type()=="post") || (is_archive() && (PRK_WOO=="false" || (PRK_WOO=="true" && !is_woocommerce()) )))
        {
            $prk_blog_linked=get_page_link(prk_get_parent_blog());
        }
        if (get_post_type()=="pirenko_portfolios")
        {
            $prk_portfolio_link=get_page_link(prk_get_parent_portfolio());
        }
        $home_link="";
        $home_slug="";
        if (is_page_template ('template_blog.php') && is_front_page())
        {
            $home_link=get_page_link(get_query_var('page_id'));
            $home_slug=the_slug(get_query_var('page_id'));
        }
        if ($prk_portfolio_link!="")
            $prk_blog_linked="";
        $custom_opacity=floatval($prk_fount_options['custom_opacity']/100);
        $custom_opacity_folio=floatval($prk_fount_options['custom_opacity_folio']/100);
        $custom_shadow=floatval($prk_fount_options['custom_shadow']/100);      

        //FONT MANAGEMENT
        $options = $prk_fount_options;
        foreach ( $prk_select_font_options as $option_header ) 
        {
            if ($prk_fount_options['header_font'] == $option_header['value'])
            {
                $options['header_font']=$option_header;
                break;
            }
        }
        $prk_font_options = get_option('prk_font_plugin_option');
        if ($prk_font_options!="")
        {
            foreach ($prk_font_options as $font) {
                if ($font['erased']=="false") {
                    if ($options['header_font'] == $font['value'])
                    {
                        $options['header_font']=$font;
                    } 
                }
            }
        }
        foreach ( $prk_select_font_options as $option_body ) 
        {
            if ($prk_fount_options['body_font'] == $option_body['value'])
            {
                $options['body_font']=$option_body;
                break;
            }
        }
        $prk_font_options = get_option('prk_font_plugin_option');
        if ($prk_font_options!="")
        {
            foreach ($prk_font_options as $font) {
                if ($font['erased']=="false") {
                    if ($options['body_font'] == $font['value'])
                    {
                        $options['body_font']=$font;
                    } 
                }
            }
        }
        foreach ( $prk_select_font_options as $option_custom ) 
        {
            if ($prk_fount_options['custom_font'] == $option_custom['value'])
            {
                $options['custom_font']=$option_custom;
                break;
            }
            if ($prk_fount_options['custom_font_2'] == $option_custom['value'])
            {
                $options['custom_font_2']=$option_custom;
                break;
            }
            if ($prk_fount_options['custom_font_3'] == $option_custom['value'])
            {
                $options['custom_font_3']=$option_custom;
                break;
            }
        }
        $prk_font_options = get_option('prk_font_plugin_option');
        if ($prk_font_options!="")
        {
            foreach ($prk_font_options as $font) {
                if ($font['erased']=="false") {
                    if ($options['custom_font'] == $font['value'])
                    {
                        $options['custom_font']=$font;
                    }
                    if ($options['custom_font_2'] == $font['value'])
                    {
                        $options['custom_font_2']=$font;
                    } 
                    if ($options['custom_font_3'] == $font['value'])
                    {
                        $options['custom_font_3']=$font;
                    } 
                }
            }
        }
        //FONTS
        $protocol = is_ssl() ? 'https' : 'http';
        //HEADER FONT
        if ($options['header_font']['hosted']=='google')
        {
            wp_enqueue_style( 'prk_header_font', "$protocol://fonts.googleapis.com/css?family=".$options['header_font']['value'] );
        }
        if ($options['header_font']['hosted']=='theme')
        {
                wp_enqueue_style( 'prk_header_font', get_template_directory_uri() . '/inc/fonts/'.$options['header_font']['value'].'/stylesheet.css',false,$prk_theme->Version);
        }
        if ($options['header_font']['hosted']=='plugin')
        {
            wp_enqueue_style( 'prk_header_font', $options['header_font']['value'],false,$prk_theme->Version);
        }
        //BODY FONT
        if ($options['body_font']['hosted']=='google')
        {
            wp_enqueue_style( 'prk_body_font', "$protocol://fonts.googleapis.com/css?family=".$options['body_font']['value'] );
        }
        if ($options['body_font']['hosted']=='theme')
        {
            wp_enqueue_style( 'prk_body_font', get_template_directory_uri() . '/inc/fonts/'.$options['body_font']['value'].'/stylesheet.css',false,$prk_theme->Version);
        }
        if ($options['body_font']['hosted']=='plugin')
        {
            wp_enqueue_style( 'prk_body_font', $options['body_font']['value'],false,$prk_theme->Version);
        }
        //EXTRA FONTS
        if ($options['custom_font']!="")
        {
            if ($options['custom_font']['hosted']=='google')
            {
                wp_enqueue_style('prk_custom_font', "$protocol://fonts.googleapis.com/css?family=".$options['custom_font']['value'] );
            }
            if ($options['custom_font']['hosted']=='theme')
            {
                wp_enqueue_style('prk_custom_font', get_template_directory_uri() . '/inc/fonts/'.$options['custom_font']['value'].'/stylesheet.css',false,$prk_theme->Version);
            }
            if ($options['custom_font']['hosted']=='plugin')
            {
                wp_enqueue_style('prk_custom_font', $options['custom_font']['value'],false,$prk_theme->Version);
            }
        }
        if ($options['custom_font_2']!="")
        {
            if ($options['custom_font_2']['hosted']=='google')
            {
                wp_enqueue_style('prk_custom_font_2', "$protocol://fonts.googleapis.com/css?family=".$options['custom_font_2']['value'] );
            }
            if ($options['custom_font_2']['hosted']=='theme')
            {
                wp_enqueue_style('prk_custom_font_2', get_template_directory_uri() . '/inc/fonts/'.$options['custom_font_2']['value'].'/stylesheet.css',false,$prk_theme->Version);
            }
            if ($options['custom_font_2']['hosted']=='plugin')
            {
                wp_enqueue_style('prk_custom_font_2', $options['custom_font_2']['value'],false,$prk_theme->Version);
            }
        }
        if ($options['custom_font_3']!="")
        {
            if ($options['custom_font_3']['hosted']=='google')
            {
                wp_enqueue_style('prk_custom_font_3', "$protocol://fonts.googleapis.com/css?family=".$options['custom_font_3']['value'] );
            }
            if ($options['custom_font_3']['hosted']=='theme')
            {
                wp_enqueue_style('prk_custom_font_3', get_template_directory_uri() . '/inc/fonts/'.$options['custom_font_3']['value'].'/stylesheet.css',false,$prk_theme->Version);
            }
            if ($options['custom_font_3']['hosted']=='plugin')
            {
                wp_enqueue_style('prk_custom_font_3', $options['custom_font_3']['value'],false,$prk_theme->Version);
            }
        }
        $woo_link="";
        $woo_link_for_cart="";
        //WOOCOMMERCE STUFF
        if (PRK_WOO=="true") {
            $woo_colors = array_map('esc_attr', (array) get_option('woocommerce_frontend_css_colors' ));
        }
        if (!isset($woo_colors['primary']) ) 
            $woo_colors['primary'] = '';
        if (!isset($prk_fount_options['active_skin']) ) 
            $prk_fount_options['active_skin'] = '';

        $prk_fount_options['active_visual_composer']=PRK_FOUNT_COMPOSER;
        if (!isset($prk_fount_options['active_skin']) ) 
            $prk_fount_options['active_skin']='';
        $prk_script_options=$prk_fount_options;
        $prk_script_options['ganalytics_text']='';
        wp_localize_script('fount_main', 'theme_options', $prk_script_options);
        
        $active_color = $prk_fount_options['active_color'];
        $menu_up_color = $prk_fount_options['menu_up_color'];
        $menu_active_color=$prk_fount_options['menu_active_color'];
        $background_color_btns=$prk_fount_options['background_color_btns'];
        $splitted_background_color_btns=html2rgb($background_color_btns,'1');
        $background_color_btns_blog=$prk_fount_options['background_color_btns_blog'];
        $shadow_color=$prk_fount_options['shadow_color'];
        $lines_color=$prk_fount_options['lines_color'];
        $body_color_footer = $prk_fount_options['body_color_footer'];
        $custom_opacity=floatval($prk_fount_options['custom_opacity']/100);
        $custom_opacity_folio=floatval($prk_fount_options['custom_opacity_folio']/100);
        $custom_shadow=floatval($prk_fount_options['custom_shadow']/100);
        $custom_opacity_tips=floatval($prk_fount_options['tips_background_opacity']/100);
        $custom_opacity_header_default=floatval($prk_fount_options['header_default_opacity']/100);
        $custom_opacity_header=floatval($prk_fount_options['header_opacity']/100);
        $custom_opacity_overlayer=floatval($prk_fount_options['overlayer_opacity']/100);

        $background_color_header = $prk_fount_options['background_color_header'];
        $inactive_color = $prk_fount_options['inactive_color'];
        $bd_headings_color = $prk_fount_options['bd_headings_color'];
        $background_color = $prk_fount_options['background_color'];
        $inputs_bordercolor = $prk_fount_options['inputs_bordercolor'];
        $site_background_color = $prk_fount_options['site_background_color'];
        $tips_background_color = $prk_fount_options['tips_background_color'];

        $splitted_active_color= html2rgb($active_color,'1');
        $splitted_menu_up_color= html2rgb($menu_up_color,'1');
        $splitted_menu_up_color_after= html2rgb($prk_fount_options['menu_up_color_after'],'1');
        $splitted_background_color=html2rgb($background_color,'1');
        $splitted_site_background_color=html2rgb($site_background_color,'1');
        $splitted_background_color_btns_blog=html2rgb($background_color_btns_blog,'1');
        $splitted_bd_headings_color = html2rgb($bd_headings_color,'1');
        $splitted_inactive_color=html2rgb($inactive_color,'1');
        $splitted_shadow_color=html2rgb($shadow_color,'1');
        $splitted_lines_color=html2rgb($lines_color,'1');
        $splitted_background_color_header=html2rgb($background_color_header,'1');
        $splitted_menu_active_color = html2rgb($prk_fount_options['menu_active_color'],'1');
        $splitted_menu_active_color_after = html2rgb($prk_fount_options['menu_active_color_after'],'1');
        $splitted_tips_background_color = html2rgb($prk_fount_options['tips_background_color'],'1');
        $splitted_body_color_footer = html2rgb($prk_fount_options['body_color_footer'],'1');
        $splitted_body_color_right_bar = html2rgb($prk_fount_options['body_color_right_bar'],'1');
        $splitted_theme_buttons_color = html2rgb($prk_fount_options['theme_buttons_color'],'1');
        $splitted_background_color_overlayer = html2rgb($prk_fount_options['background_color_overlayer'],'1');
        $splitted_submenu_background_color = html2rgb($prk_fount_options['submenu_background_color'],'1');
        $splitted_bd_smallers_color = html2rgb($prk_fount_options['bd_smallers_color'],'1');
        $splitted_preloader_color = html2rgb($prk_fount_options['preloader_color'],'1');
        $splitted_inputs_bordercolor = html2rgb($prk_fount_options['inputs_bordercolor'],'1');
        $darker_color_footer=alter_brightness($prk_fount_options['body_color_footer'],-120);
        
        //START BUILDING CSS SENTENCE TO CUSTOMIZE CONTENT
        $css = "";
        if ($prk_fount_options['collapsed_menu_vertical']<45)
        {
            $collapsed_menu_vertical=45;
        }
        else
        {
            $collapsed_menu_vertical=$prk_fount_options['collapsed_menu_vertical'];
        }
        if ($prk_fount_options['menu_collapse_flag']==0) {
            $collapsed_menu_vertical=$prk_fount_options['menu_vertical'];
        }
        //$height_sum=$prk_fount_options['menu_vertical'];
        $shifted_logo=$collapsed_menu_vertical-16;
        $reducer=$prk_fount_options['menu_vertical']+6;
        //ADD CUSTOM CSS
        //ADJUT LOGO POSITION
        $content_topper=$prk_fount_options['menu_vertical'];
        if ($prk_fount_options['header_layout']=="fount_logo_above") {
            $css .= "#fount_logo_holder {margin-top:".$options['logo_vertical']."px !important;margin-bottom:".$options['logo_vertical_below']."px !important;}";
            $content_topper=$content_topper+$options['logo_vertical']+$options['logo_vertical_below'];
        }
        $css .= ".fount_forced_menu #prk_ajax_container,.featured_owl .owl-carousel .sld_top {
                    padding-top:".$content_topper."px;
                }.menu_at_top .fount_forced_menu #prk_ajax_container {
                    padding-top: ".$collapsed_menu_vertical."px;
                }.sf-menu ul,.fount_forced_top_bar #top_bar_wrapper {
                    top:".$prk_fount_options['menu_vertical']."px;
                }#prk_responsive_menu_inner {
                    height:".$prk_fount_options['menu_vertical']."px;
                }#fount_left_floater,#top_form_close,#searchform_top input,#fount_top_floater,#prk_menu_loupe, #menu_section .sf-menu>li {
                    height:".$prk_fount_options['menu_vertical']."px;
                    line-height:".$prk_fount_options['menu_vertical']."px;
                }#prk_top_divider_wrapper,#top_form_hider {
                    height:".$prk_fount_options['menu_vertical']."px;
                }.fount_collapsed_menu #prk_responsive_menu_inner #top_form_close,.fount_collapsed_menu #prk_responsive_menu_inner #top_form_hider,.fount_collapsed_menu #fount_left_floater,.menu_at_top #fount_logo_holder,.menu_at_top #prk_responsive_menu #prk_logos,.menu_at_top #fount_left_floater,.menu_at_top #top_form_hider,.menu_at_top #top_form_close,.menu_at_top #searchform_top input,.menu_at_top #fount_top_floater,.menu_at_top #prk_menu_loupe {
                    height:".$collapsed_menu_vertical."px !important;
                    line-height:".$collapsed_menu_vertical."px !important;
                }.menu_at_top .fount_logo_above #centered_block {
                    margin-top:".$collapsed_menu_vertical."px !important;}
                #bottom_bar_wrapper {
                    height:".$collapsed_menu_vertical."px;
                    bottom:-".$collapsed_menu_vertical."px;
                    line-height:".$collapsed_menu_vertical."px;
                }#prk_lower_crumbs {
                    height:".$collapsed_menu_vertical."px;
                }.fount_collapsed_menu .sf-menu ul {
                    top:".$collapsed_menu_vertical."px;
                }#prk_responsive_menu.fount_hidden_menu {
                    margin-top:-".$reducer."px;}";
        //FONTS
        $css .= "body{font-size:".$options['font_size']."px;}body,.search-query,.regular_font,input,textarea {
                    font-family:".$options['body_font']['css'].";
                }.woocommerce .summary h1,.woocommerce .related>h3,.woocommerce .related>h2,#calendar_wrap caption,.prk_composer_title,.wpb_heading,.header_font,.shortcode-title {
                    font-family:".$options['header_font']['css'].";}";
        if ($options['custom_font']!="") {
            $css .= ".custom_font,.custom_font .header_font,.custom_font.header_font,.custom_font-1,.custom_font-1 .header_font,.custom_font-1.header_font {
                    font-family:".$options['custom_font']['css'].";}";
            if ($options['buttons_font']=="custom_f")
            {
                $css .= ".colored_theme_button,.theme_button,.theme_button_inverted,.colored_theme_button input,.theme_button input,.theme_button_inverted input {font-family:".$options['custom_font']['css'].";}";
            }
        }
        if ($options['custom_font_2']!="") {
            $css .= ".custom_font-2,.custom_font-2 .header_font,.custom_font-2.header_font {
                    font-family:".$options['custom_font_2']['css'].";}";
            if ($options['buttons_font']=="custom_f_2")
            {
                $css .= ".colored_theme_button,.theme_button,.theme_button_inverted,.colored_theme_button input,.theme_button input,.theme_button_inverted input {font-family:".$options['custom_f_2']['css'].";}";
            }
        }
        if ($options['custom_font_3']!="") {
            $css .= ".custom_font-3,.custom_font-3 .header_font,.custom_font-3.header_font {
                    font-family:".$options['custom_font_3']['css'].";}";
            if ($options['buttons_font']=="custom_f_3")
            {
                $css .= ".colored_theme_button,.theme_button,.theme_button_inverted,.colored_theme_button input,.theme_button input,.theme_button_inverted input {font-family:".$options['custom_f_3']['css'].";}";
            }
        }
        if ($options['buttons_font']=="headings_f")
        {
            $css .= ".colored_theme_button,.theme_button,.theme_button_inverted,.colored_theme_button input,.theme_button input,.theme_button_inverted input {
                font-family:".$options['header_font']['css'].";}";
        }
        if ($options['buttons_font']=="body_f")
        {
            $css .= ".colored_theme_button,.theme_button,.theme_button_inverted,.colored_theme_button input,.theme_button input,.theme_button_inverted input {font-family:".$options['body_font']['css'].";}";
        }
        //FONT RELATED ADJUSTMENTS
        if ($options['header_font']['value']=="Raleway:300,400,500,600,700" && $options['buttons_font']=="headings_f")
        {
            $css .= ".colored_theme_button a,.theme_button a,.theme_button_inverted a,.colored_theme_button a.with_icon, .theme_button a.with_icon, .theme_button_inverted a.with_icon {
                padding-bottom:6px;
            }.sf-menu a {
                padding-top:1px;}";
        }
        global $prk_retina_device;
        global $post;
        //WIDTH SET MANAGEMENT
        $css .= "#fount_super_sections .fount_super_width #ajaxed_content, #prk_mega_wrap.boxed_fount,.boxed_fount #prk_footer_wrapper,.boxed_fount #prk_responsive_menu,.boxed_fount #bottom_bar_wrapper,.boxed_fount #project_info,.boxed_fount #contact_info,.prk_inner_block,.page-prk-blog-masonry #entries_navigation_blog .prk_inner_block,.vertical_forced_row>div {
            max-width: ".$prk_fount_options['custom_width']."px;}";
        $css .= "#single_blog_content.blog_limited_width {max-width: ".$prk_fount_options['custom_width_blog']."px;}";
        //SET THE BODY BACKGROUND
        $css .=
        "body,#footer_mirror,#prk_ajax_container,#contact_info #contact_form {
            background-color:".$prk_fount_options['site_background_color'].";}";
        $css .="#prk_responsive_menu_inner,.fount_logo_above #prk_logos {
                background-color:$background_color_header;
                background-color:rgba($splitted_background_color_header[0], $splitted_background_color_header[1], $splitted_background_color_header[2], ".$custom_opacity_header_default.");
            }.fount_logo_above.fount_forced_menu #prk_logos,.menu_at_top.fount_forced_menu #prk_logos,.menu_at_top #prk_responsive_menu_inner,.fount_forced_menu #prk_responsive_menu_inner,.fount_collapsed_menu.fount_logo_above #prk_logos,.fount_collapsed_menu #prk_responsive_menu_inner {
                background-color:$background_color_header;
                background-color:rgba($splitted_background_color_header[0], $splitted_background_color_header[1], $splitted_background_color_header[2], ".$custom_opacity_header.");}";
        if (isset($prk_fount_options['pattern'])) {
            $path_parts = pathinfo($prk_fount_options['pattern']);
            if (isset($path_parts['filename']) && $path_parts['filename']!="" && $path_parts['filename']!="prk_no_pattern")
            {
                if ($prk_retina_device=="prk_retina")
                {
                    $vt_image = vt_resize( '', get_template_directory_uri() . "/images/patterns/".$path_parts['filename']."_@2X.".$path_parts['extension'] , 2000, 2000, false );
                    //CHECK IF RETINA PATTERN EXISTS
                    if (isset($vt_image['not_found']) && $vt_image['not_found']!="true") {
                        $half_width=$vt_image['width']/2;
                        $css .=
                        "body.boxed_fount,#prk_ajax_container {
                            background-image: url(" . get_template_directory_uri() . "/images/patterns/".$path_parts['filename']."_@2X.".$path_parts['extension'].");
                            background-size:".$half_width."px auto;}";
                    }
                    else
                    {
                        $css .=
                        "body.boxed_fount,#prk_ajax_container {
                            background-image: url(" . $prk_fount_options['pattern'].");}";
                    }
                }
                else
                {
                    $css .=
                    "body.boxed_fount,#prk_ajax_container {
                        background-image: url(" . $prk_fount_options['pattern'].");}";
                }
            }
            
        }
        if (isset($prk_fount_options['pattern_footer'])) {
        $path_parts = pathinfo($prk_fount_options['pattern_footer']);
            if (isset($path_parts['filename']) && $path_parts['filename']!="" && $path_parts['filename']!="prk_no_pattern")
            {
                if ($prk_retina_device=="prk_retina")
                {
                    $vt_image = vt_resize( '', get_template_directory_uri() . "/images/patterns/".$path_parts['filename']."_@2X.".$path_parts['extension'] , 2000, 2000, false );
                    //CHECK IF RETINA PATTERN EXISTS
                    if (isset($vt_image['not_found']) && $vt_image['not_found']!="true") {
                        $half_width=$vt_image['width']/2;
                        $css .=
                        "#prk_footer {
                            background-image: url(" . get_template_directory_uri() . "/images/patterns/".$path_parts['filename']."_@2X.".$path_parts['extension'].");
                            background-size:".$half_width."px auto;}";
                    }
                    else
                    {
                        $css .=
                        "#prk_footer {background-image: url(" . $prk_fount_options['pattern_footer'].");}";
                    }
                }
                else
                {
                    $css .=
                    "#prk_footer {background-image: url(" . $prk_fount_options['pattern_footer'].");}";
                }
            }
        }
        if ($prk_fount_options['background_image_right_bar']['url']!="")
        {
            $bar_image=wp_get_attachment_image_src($prk_fount_options['background_image_right_bar']['id'],'full');
            $css .=
            "#prk_hidden_bar {background-image: url(".$bar_image['0'].");}";
        }
        if ($prk_fount_options['footer_reveal']=="1") {
            $css.="#prk_footer_wrapper {position:fixed;}";
        }
        else 
        {
            $css.="#footer_in .widget-title,#footer_in .widget_inner {-webkit-backface-visibility: hidden;}";
        }
        if ($prk_fount_options['uppercase_buttons']=="1") {
            $css.=".colored_theme_button input,.colored_theme_button a,.theme_button input,.theme_button a,.theme_button_inverted input, .theme_button_inverted a {text-transform:uppercase;}";
        }
        //COLOR MANAGEMENT
        $css.=".member_colored_block_in,.grid_colored_block,.related_fader_grid {
            background-color:$background_color_btns;
            background-color: rgba($splitted_background_color_btns[0], $splitted_background_color_btns[1], $splitted_background_color_btns[2], ".$custom_opacity_folio.");
        }.lone_linker a {
            background-color:$site_background_color;
            color:$background_color_btns;
        }.lone_linker a:hover {
            background-color:$background_color_btns;}";   
        $css.="a,a:hover, #prk_hidden_bar a:hover,.contact_error,#main .member_ul_slider.owl-theme .owl-controls div:hover,#main .recentposts_ul_slider.owl-theme .owl-controls div:hover,.post_meta_single #previous_button:hover .after_icon,.post_meta_single #next_button:hover .bf_icon,#nav-main.resp_mode li > a:hover,.a_colored a:hover,.recentposts_ul_shortcode .blog_meta a:hover,.classic_meta .post-categories li a:hover,.headings_top,.tiny_bullet,.not_zero_color,.prk_service:hover .colored_link_icon,#prk_footer .copy a:hover,#prk_footer #footer_bk a:hover,#fount_to_top,.fount_button_arrow,#top_bar_wrapper #fount_close.small_headings_color:hover,#top_bar_wrapper #fount_left.small_headings_color:hover .inner_mover,#top_bar_wrapper #fount_right.small_headings_color:hover .inner_mover,#folio_nav_wrapper .fount_close_folio.small_headings_color:hover,#folio_nav_wrapper .fount_left_folio.small_headings_color:hover .inner_mover,#folio_nav_wrapper .fount_right_folio.small_headings_color:hover .inner_mover,.prk_accordion.ui-accordion .ui-accordion-header.ui-state-active,.prk_accordion.ui-accordion .ui-accordion-header.ui-state-active a,.wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header.ui-state-active,.wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header.ui-state-active a,.ui-tabs .ui-tabs-nav li.ui-tabs-active a,.fount_theme .vc_tta-container .vc_tta-tab.vc_active a {
                color: $active_color;
            }.sod_select .sod_option.active,.sod_select,.fount_folio_filter .active a,.fount_folio_filter a:hover,#main .member_ul_slider.owl-theme .owl-controls div,#main .recentposts_ul_slider.owl-theme .owl-controls div,.titled_portfolio .grid_single_title .body_bk_color,.wpb_heading,.zero_color,.zero_color a,a.zero_color {
                color: $bd_headings_color;
            }.sod_select {
                border-color: $bd_headings_color;
            }#after_widgets,#prk_footer #footer_bk .small_headings_color,#prk_footer #footer_bk .default_color,#prk_footer #footer_bk a.small_headings_color,#prk_footer #footer_bk .small_headings_color a,#prk_footer #footer_bk a.default_color,#prk_footer #footer_bk .default_color a,#prk_footer,#footer_in .pirenko_highlighted {
                color:$body_color_footer;
            }#prk_footer .zero_color,#prk_footer .fount_active_icon,#prk_footer .fount_address_icon,#prk_footer .prk_footer_menu a,#prk_footer .copy a,#prk_footer #footer_bk a,#footer_in .theme_button input,#footer_in .widget-title,#prk_footer #footer_bk .prk_twt_body .twt_in a.default_color {
                color:".$prk_fount_options['titles_color_footer'].";
            }#prk_footer .prk_footer_menu a .lower_divider {
                color:".$prk_fount_options['titles_color_footer']." !important;
            }.bordered_buttons #prk_footer .theme_button a,.bordered_buttons #prk_footer .theme_button input {
                border-color:".$prk_fount_options['titles_color_footer'].";
            }.fount_theme .mfp-bg,#fount_ajax_back {
                background-color:".$prk_fount_options['background_color_overlayer'].";
            }.my-mfp-zoom-in.mfp-ready.mfp-bg {
                filter: alpha(opacity=".$prk_fount_options['overlayer_opacity'].");
                opacity:".$custom_opacity_overlayer.";
            }#fount_ajax_holder,#fount_ajax_holder .default_color,#top_bar_wrapper .default_color,#top_bar_wrapper .zero_color,.fount_theme .mfp-counter,.fount_theme .mfp-title {
                color:".$prk_fount_options['body_color_overlayer'].";
            }#top_bar_wrapper .small_headings_color,#fount_ajax_holder .small_headings_color {
                color:".$prk_fount_options['smallers_color_overlayer'].";
            }#fount_ajax_holder .zero_color,.fount_theme .mfp-arrow-left,.fount_theme .mfp-arrow-right {
                color:".$prk_fount_options['active_color_overlayer'].";
            }#top_bar_wrapper .fount_close_inner:before,#top_bar_wrapper .fount_close_inner:after {
                background-color:".$prk_fount_options['smallers_color_overlayer'].";
            }.mfp-close_inner:before,.mfp-close_inner:after {
                background-color:".$prk_fount_options['active_color_overlayer'].";
            }#fount_ajax_holder .simple_line {
                border-color:".$prk_fount_options['lines_color_overlayer'].";
            }.summary .cart:after {
                background-color:$lines_color;
            }#fount_wrapper .colored_theme_button input,#fount_wrapper .colored_theme_button a,#fount_wrapper .theme_button input,#fount_wrapper .theme_button a,#fount_wrapper .theme_button_inverted input,#fount_wrapper .theme_button_inverted a,#fount_wrapper .prk_radius {
                -webkit-border-radius: ".$prk_fount_options['buttons_radius']."px;
                border-radius: ".$prk_fount_options['buttons_radius']."px;
            }.owl-prev {
                -webkit-border-bottom-left-radius: ".$prk_fount_options['buttons_radius']."px;
                border-bottom-left-radius: ".$prk_fount_options['buttons_radius']."px;
                -webkit-border-top-left-radius: ".$prk_fount_options['buttons_radius']."px;
                border-top-left-radius: ".$prk_fount_options['buttons_radius']."px;
            }.owl-next {
                -webkit-border-bottom-right-radius: ".$prk_fount_options['buttons_radius']."px;
                border-bottom-right-radius: ".$prk_fount_options['buttons_radius']."px;
                -webkit-border-top-right-radius: ".$prk_fount_options['buttons_radius']."px;
                border-top-right-radius: ".$prk_fount_options['buttons_radius']."px;
            }#footer_in .simple_line {
                border-bottom:1px solid $body_color_footer;
                border-bottom:1px solid rgba($splitted_body_color_footer[0], $splitted_body_color_footer[1], $splitted_body_color_footer[2],0.2);
            }#footer_in .pirenko_highlighted {
                border:1px solid $body_color_footer;
                border:1px solid rgba($splitted_body_color_footer[0], $splitted_body_color_footer[1], $splitted_body_color_footer[2],0.2);
            }#prk_hidden_bar .pirenko_highlighted:focus,#footer_in .pirenko_highlighted:focus {
                border-color: $active_color;
                border-color: rgba($splitted_active_color[0], $splitted_active_color[1], $splitted_active_color[2],0.65);
            }.woocommerce .woocommerce-message {
                border-top-color:$active_color;
            }#after_widgets.not_plain,#prk_footer_menu,.copy {
                border-top:1px solid $body_color_footer;
                border-top:1px solid rgba($splitted_body_color_footer[0], $splitted_body_color_footer[1], $splitted_body_color_footer[2],0.2);
            }.copy {
                box-shadow: 0px -1px 0px $darker_color_footer;
                -webkit-box-shadow: 0px -1px 0px $darker_color_footer;
                -moz-box-shadow: 0px -1px 0px $darker_color_footer;
            }#fount_wrapper #dotted_navigation a span,#fount_wrapper #dotted_navigation a.active span {
                color:".$prk_fount_options['background_color_dots'].";
            }#fount_wrapper #dotted_navigation a:before {
                background-color:".$prk_fount_options['background_color_dots'].";
            }#prk_footer {
                background-color:".$prk_fount_options['background_color_footer'].";
            }body,.prk_tags_ul a,.blog_meta>p>a,
            .flexslider .headings_body,.shortcode_slider .headings_body,.padded_text a,.post_meta_single .after_icon,.post_meta_single .bf_icon,.post_meta_single a,.blog_meta a,.default_color,.default_color a,.default_color a:hover,a.default_color,a.default_color:hover,.titled_block .grid_single_title span a,.contact_address_right_single a,#fount_search,.masonr_read_more a,.blog_meta a,#nav-main.resp_mode li > a,.ui-tabs .ui-tabs-nav li a,.vc_tta-tab a,.pirenko_highlighted,.prk_minimal_button>span,.prk_minimal_button>a,.prk_minimal_button>input,.ui-accordion .ui-accordion-header,.ui-accordion .ui-accordion-header a,.fount_folio_filter a,select {
                color:$inactive_color;
            }.sod_select.open:before,.sod_select .sod_option.selected:before,.sod_select.open,a.small_headings_color,.small_headings_color a,.small_headings_color {
                color:".$prk_fount_options['bd_smallers_color'].";
            }.sod_select .sod_option.active {
                background-color:rgba($splitted_bd_smallers_color[0], $splitted_bd_smallers_color[1], $splitted_bd_smallers_color[2], 0.15);
            }.prk_price_header {
                background-color:rgba($splitted_bd_smallers_color[0], $splitted_bd_smallers_color[1], $splitted_bd_smallers_color[2], 0.5); 
            }.fount_close_inner:before,.fount_close_inner:after {
                background-color:".$prk_fount_options['bd_smallers_color'].";
            }::-webkit-input-placeholder {
               color: $inactive_color;
            }:-moz-placeholder {
               color: $inactive_color;  
            }::-moz-placeholder { 
               color: $inactive_color;  
            }:-ms-input-placeholder {  
               color: $inactive_color;  
            }:focus::-webkit-input-placeholder {
               color: rgba($splitted_inactive_color[0], $splitted_inactive_color[1], $splitted_inactive_color[2], 0.2); 
            }:focus:-moz-placeholder {
               color: rgba($splitted_inactive_color[0], $splitted_inactive_color[1], $splitted_inactive_color[2], 0.2); 
            }:focus::-moz-placeholder { 
               color: rgba($splitted_inactive_color[0], $splitted_inactive_color[1], $splitted_inactive_color[2], 0.2); 
            }:focus:-ms-input-placeholder {  
               color: rgba($splitted_inactive_color[0], $splitted_inactive_color[1], $splitted_inactive_color[2], 0.2);  
            }
            .vc_progress_bar .vc_single_bar .vc_label,.entry-title a,.related_post a,.prk_folio_control,.prk_price_featured,.menu_bk_color {
                color:$background_color;
            }.slider_scroll_button i,.owl-controls .owl-buttons div,.site_background_colored a,a.site_background_colored,.site_background_colored,.prk_blockquote.colored_background .in_quote,.prk_sharrre_button a,.colored_theme_button input,.colored_theme_button a,.colored_theme_button a:hover,.theme_button input,.theme_button a,.theme_button a:hover,.theme_button_inverted input,.theme_button_inverted a,.theme_button_inverted a:hover,#pages_static_nav a,.sform_wrapper i,.fount_paging_navigation a:hover,.lone_linker a:hover,.prk_minimal_button>span.current {
                color:$site_background_color;
            }.body_bk_color {
                color:".$prk_fount_options['thumbs_text_color'].";
            }.sod_select:after,.sod_select,.sod_select .sod_list_wrapper,.titled_portfolio .grid_single_title,.squared_button:hover .fount_close_inner:before, .squared_button:hover .fount_close_inner:after {
                background-color:$site_background_color;
            }.titled_portfolio .grid_single_title .body_bk_text_shadow,.bd_headings_text_shadow {
                text-shadow:0px 0px 1px rgba($splitted_bd_headings_color[0], $splitted_bd_headings_color[1], $splitted_bd_headings_color[2],0.2);
            }.body_text_shadow {
                text-shadow:0px 0px 1px rgba($splitted_inactive_color[0], $splitted_inactive_color[1], $splitted_inactive_color[2],0.2);
            }.owl-controls .owl-buttons div,.flexslider .theme_button_inverted a,.navigation-previous,.navigation-next {
                background-color:".$prk_fount_options['buttons_color'].";
            }#nprogress .bar {
                background-color:".$prk_fount_options['preloader_color'].";
            }#folio_spinner.spinner-icon,.multi_spinner.spinner-icon,#single_spinner.spinner-icon {
                border: 3px solid rgba($splitted_preloader_color[0], $splitted_preloader_color[1], $splitted_preloader_color[2],0.3);
                border-right-color:".$prk_fount_options['preloader_color'].";
                border-left-color:".$prk_fount_options['preloader_color'].";
            }#nprogress .spinner-icon {
                border: 5px solid rgba($splitted_preloader_color[0], $splitted_preloader_color[1], $splitted_preloader_color[2],0.3);
                border-right-color:".$prk_fount_options['preloader_color'].";
                border-left-color:".$prk_fount_options['preloader_color'].";
            }.prk_blockquote.colored_background .in_quote:after {
                border-color: $site_background_color rgba($splitted_site_background_color[0], $splitted_site_background_color[1], $splitted_site_background_color[2],0.35) $site_background_color rgba($splitted_site_background_color[0], $splitted_site_background_color[1], $splitted_site_background_color[2],0.35);
            }.headings_top,.active_text_shadow {
                text-shadow:0px 0px 1px rgba($splitted_active_color[0], $splitted_active_color[1], $splitted_active_color[2],0.3);
            }#footer_in ::-webkit-input-placeholder {
               color: $body_color_footer;
            }#footer_in :-moz-placeholder {
               color: $body_color_footer;  
            }#footer_in ::-moz-placeholder {
               color: $body_color_footer;  
            }#footer_in :-ms-input-placeholder {  
               color: $body_color_footer;
            }.menu_at_top #prk_responsive_menu .sf-menu>li.mega_menu>ul>li>a {
                background-color:$background_color_header !important;
            }#searchform_top input,.menu_at_top #prk_menu_els,#contact_info,#project_info,#outerSliderWrapper,#pages_static_nav a,#bottom_bar_wrapper,#top_form_hider {
                background-color:$background_color_header;
            }#fount_wrapper .member_colored_block .fount_member_links .fount_socialink {
                border-color:".$prk_fount_options['members_social_colors'].";
                color:".$prk_fount_options['members_social_colors'].";
            }#fount_wrapper .member_colored_block .fount_member_links .fount_socialink.fount_fa-envelope-o {
                border-color:".$prk_fount_options['members_social_colors']." !important;
                color:".$prk_fount_options['members_social_colors']." !important;
            }#mini_social_nets a,#menu_section,.sf-menu>li>a,.prk_gallery_title {
                color: $menu_up_color;
            }#prk_top_divider,#menu_section #prk_menu_left_trigger .prk_menu_block,#menu_section #prk_menu_right_trigger .prk_menu_block {
                background-color: $menu_up_color;
                background-color: rgba($splitted_menu_up_color[0], $splitted_menu_up_color[1], $splitted_menu_up_color[2],0.88);
            }#mini_social_nets a:hover,#mini_social_nets a:hover,#menu_section .sf-menu>li>a:hover,#menu_section .sf-menu>li.active>a {
                color:$menu_active_color;
            }#menu_section #prk_menu_left_trigger.hover_trigger .prk_menu_block,#menu_section #prk_menu_right_trigger.hover_trigger .prk_menu_block {
                background-color: ".$prk_fount_options['menu_active_color'].";
                background-color: rgba($splitted_menu_active_color[0], $splitted_menu_active_color[1], $splitted_menu_active_color[2],0.88);
            }#menu_section .sf-menu a:hover::after {
                background-color:$menu_active_color;
            }.fount_forced_menu #mini_social_nets a,.fount_collapsed_menu #mini_social_nets a,#top_form_close,.menu_at_top #menu_section,.menu_at_top .sf-menu li a,#searchform_top input,#searchform_top input:focus,.fount_forced_menu #menu_section,.fount_forced_menu .sf-menu>li>a,.fount_forced_menu #searchform_top input,.fount_collapsed_menu #top_form_close,.fount_collapsed_menu #menu_section,.fount_collapsed_menu .sf-menu>li>a,.fount_collapsed_menu #searchform_top input {
                color: ".$prk_fount_options['menu_up_color_after'].";
            }.menu_at_top #menu_section #prk_menu_left_trigger .prk_menu_block,.menu_at_top #menu_section #prk_menu_right_trigger .prk_menu_block,.fount_forced_menu #menu_section #prk_menu_left_trigger .prk_menu_block,.fount_forced_menu #menu_section #prk_menu_right_trigger .prk_menu_block,.fount_collapsed_menu #menu_section #prk_menu_left_trigger .prk_menu_block,.fount_collapsed_menu #menu_section #prk_menu_right_trigger .prk_menu_block {
                background-color: ".$prk_fount_options['menu_up_color_after'].";
                background-color: rgba($splitted_menu_up_color_after[0], $splitted_menu_up_color_after[1], $splitted_menu_up_color_after[2],0.88);
            }.fount_forced_menu #mini_social_nets a:hover,.fount_collapsed_menu #mini_social_nets a:hover,.fount_forced_menu #menu_section .sf-menu>li.active>a.sf-with-ul,.menu_at_top #menu_section .sub-menu li a:hover,.menu_at_top .fount_forced_menu #menu_section .sf-menu>li.fount_hover_sub>a.active.sf-with-ul:hover,.menu_at_top .fount_forced_menu #menu_section .sf-menu>li.fount_hover_sub>a.sf-with-ul:hover,.menu_at_top #menu_section .sf-menu>li.fount_hover_sub>a.active.sf-with-ul:hover,.menu_at_top #menu_section .sf-menu>li.fount_hover_sub>a.sf-with-ul:hover,.menu_at_top #menu_section .sf-menu>li.fount_hover_sub>a.active.sf-with-ul,.menu_at_top #menu_section .sf-menu>li.fount_hover_sub>a.sf-with-ul,.menu_at_top #menu_section .sf-menu>li>a:hover,.menu_at_top #menu_section .sf-menu>li.active>a,.fount_forced_menu #menu_section .sf-menu>li>a:hover,.fount_forced_menu #menu_section .sf-menu>li.active>a,.fount_collapsed_menu #menu_section .sf-menu>li>a:hover,.fount_collapsed_menu #menu_section .sf-menu>li.active>a {
                color:".$prk_fount_options['menu_active_color_after'].";
            }.menu_at_top #menu_section #prk_menu_left_trigger.hover_trigger .prk_menu_block,.menu_at_top #menu_section #prk_menu_right_trigger.hover_trigger .prk_menu_block,.fount_forced_menu #menu_section #prk_menu_left_trigger.hover_trigger .prk_menu_block,.fount_forced_menu #menu_section #prk_menu_right_trigger.hover_trigger .prk_menu_block,.fount_collapsed_menu #menu_section #prk_menu_left_trigger.hover_trigger .prk_menu_block,.fount_collapsed_menu #menu_section #prk_menu_right_trigger.hover_trigger .prk_menu_block {
                background-color: ".$prk_fount_options['menu_active_color_after'].";
                background-color: rgba($splitted_menu_active_color_after[0], $splitted_menu_active_color_after[1], $splitted_menu_active_color_after[2],0.88);
            }.menu_at_top #menu_section .sf-menu a:hover::after,.fount_forced_menu #menu_section .sf-menu a:hover::after,.fount_collapsed_menu #menu_section .sf-menu a:hover::after {
                background-color:".$prk_fount_options['menu_active_color_after'].";
            }#copy {
                color: ".$prk_fount_options['body_color_footer'].";
            }.theme_button_inverted a {
                background-color: ".$prk_fount_options['theme_buttons_color'].";
            }.bordered_buttons .theme_button_inverted input,.bordered_buttons .theme_button_inverted a,.bordered_buttons .theme_button_inverted a:hover {
                color: ".$prk_fount_options['theme_buttons_color'].";
                border-color: ".$prk_fount_options['theme_buttons_color'].";
            }.bordered_buttons .theme_button input,.bordered_buttons .theme_button a,.bordered_buttons .theme_button a:hover {
                color: $active_color;
                border-color: $active_color;
            }.fount_folio_filter .p_filter a:after,.classic_meta .post-categories li a,.prk_sharrre_button {
                background-color: $bd_headings_color;
            }.small_underline .prk_vc_title,.large_underline .prk_vc_title {
                border-bottom-color: rgba($splitted_bd_headings_color[0], $splitted_bd_headings_color[1], $splitted_bd_headings_color[2],0.9);
            }.fount_socialink.fount_fa-envelope-o,.fount_socialink.colorer-envelope {
                border-color:$active_color !important;
                color:$active_color !important;
            }.fount_socialink.fount_fa-envelope-o .bg_shifter,.fount_socialink.colorer-envelope .bg_shifter {
                background-color:$active_color !important;
            }.blog_fader_grid {
                background-color:$background_color_btns_blog;
                background-color: rgba($splitted_background_color_btns_blog[0], $splitted_background_color_btns_blog[1], $splitted_background_color_btns_blog[2], ".$custom_opacity.");
            }.owl-theme .owl-controls .owl-page.active span,.colored_theme_button a,.colored_theme_button input,.theme_button input,.theme_button a,.prk_blockquote.colored_background,.tiny_line,.sform_wrapper i,.fount_paging_navigation a:hover,.prk_minimal_button>span.current {
                background-color:$active_color;
            }.theme_button_inverted.active a {
                background-color:$active_color !important;
            }.wpb_tour .ui-state-active,.wpb_tour .ui-widget-content .ui-state-active,.wpb_tour .ui-widget-header .ui-state-active,.wpb_tour .ui-tabs .ui-tabs-nav li.ui-state-active,.fount_theme .vc_tta-container .vc_tta-tab.vc_active,.wpb_tabs .ui-tabs-nav .ui-state-hover,.wpb_tabs .ui-tabs-nav .ui-state-active,.wpb_tabs .ui-tabs-nav .ui-widget-content .ui-state-active,.wpb_tabs .ui-tabs-nav .ui-widget-header .ui-state-active,.wpb_tabs .ui-tabs-nav .ui-tabs .ui-tabs-nav li.ui-state-active,.prk_accordion .ui-accordion-content,.wpb_accordion_content,.wpb_tour .wpb_tour_tabs_wrapper .wpb_tab,.wpb_content_element.wpb_tabs .wpb_tour_tabs_wrapper .wpb_tab,.prk_speech,.small_squared,.prk_price_table,.vc_progress_bar .vc_single_bar,.cart-collaterals table,.shop_table,.woocommerce #payment,.liner,.es-nav span,.btn-primary,.prk_minimal_button>span,.prk_minimal_button>a,.prk_minimal_button>input,.pirenko_highlighted,#nav-main.resp_mode,.prk_inner_tip,.prk_blockquote,.colored_bg,.plain .tip_top_hide,.prk_speech .tip_top_hide {
                background-color:$background_color;
            }.wpb_tabs .ui-tabs-nav .ui-state-active,.wpb_tabs .ui-tabs-nav .ui-widget-content .ui-state-active,.wpb_tabs .ui-tabs-nav .ui-widget-header .ui-state-active,.wpb_tabs .ui-tabs-nav .ui-tabs .ui-tabs-nav li.ui-state-active,.fount_theme .vc_tta-container .vc_tta-tab.vc_active {
                border-bottom:1px solid $background_color;
            }input:focus, textarea:focus,select:focus {
                background-color: rgba($splitted_active_color[0], $splitted_active_color[1], $splitted_active_color[2],0.1);
                border-color: rgba($splitted_active_color[0], $splitted_active_color[1], $splitted_active_color[2],0.65);
                color: $active_color;
            }.prk_cropped_blockquote:before,.prk_cropped_blockquote:after {
                background-color:".$prk_fount_options['site_background_color']."; 
            }.comments_special_button a {
                color:$background_color !important;
            }#menu_section .sf-menu .fount_hover_sub .sub-menu li a,.sf-menu>li.fount_hover_sub>a.sf-with-ul,.sf-menu>li.mega_menu>ul>li>a {
                background-color:".$prk_fount_options['submenu_background_color']."; 
            }#menu_section .sf-menu .sub-menu li,.sf-menu>li>a.sf-with-ul {
                background-color: rgba($splitted_submenu_background_color[0], $splitted_submenu_background_color[1], $splitted_submenu_background_color[2],0);
            }.sf-menu .prk_regular_menu li a {
                border-top:1px solid ".$prk_fount_options['submenu_lines_color'].";
            }.sf-menu>li.mega_menu>ul>li {
                border-right:1px dashed ".$prk_fount_options['submenu_lines_color'].";
            }.sf-menu>li.fount_hover_sub>a.sf-with-ul {
                color:".$prk_fount_options['submenu_active_color'].";
            }.sf-menu>li.fount_hover_sub>a.active.sf-with-ul:hover,.sf-menu>li.fount_hover_sub>a.sf-with-ul:hover,#menu_section .sf-menu>li.fount_hover_sub>a.sf-with-ul:hover,#menu_section .sf-menu>li.fount_hover_sub>a.active.sf-with-ul:hover,.fount_collapsed_menu #menu_section .sf-menu>li.fount_hover_sub>a.active.sf-with-ul,.fount_collapsed_menu #menu_section .sf-menu>li.fount_hover_sub>a.sf-with-ul,.fount_forced_menu #menu_section .sf-menu>li.fount_hover_sub>a.sf-with-ul,.fount_forced_menu #menu_section .sf-menu>li.fount_hover_sub>a.active.sf-with-ul,#menu_section .sf-menu .fount_hover_sub .sub-menu li a:hover {
                color:".$prk_fount_options['submenu_active_color'].";
                background-color:".$prk_fount_options['submenu_active_background_color'].";
            }.sf-menu .sub-menu a {
                color:".$prk_fount_options['submenu_text_color']."; 
            }#prk_hidden_bar{
                width:".$prk_fount_options['right_bar_width']."px;
            }#body_hider {
                right:".$prk_fount_options['right_bar_width']."px;
            }.prk_shifted #prk_hidden_bar {
                margin-right: 0px;
            }.prk_shifted #contact_info,.prk_shifted #top_bar_wrapper,.prk_shifted #prk_ajax_container,.prk_shifted #bottom_bar_wrapper,.prk_shifted #prk_responsive_menu,.prk_shifted #footer_mirror,.prk_shifted #prk_footer {
                margin-left: -".$prk_fount_options['right_bar_width']."px;
            }.prk_shifted #fount_to_top {
                margin-right: ".$prk_fount_options['right_bar_width']."px;
            }#prk_hidden_bar .default_color a,#prk_hidden_bar a.default_color,#prk_hidden_bar .default_color,#prk_hidden_bar {
                color: ".$prk_fount_options['body_color_right_bar']."; 
            }.bordered_buttons #prk_hidden_bar .theme_button a,.bordered_buttons #prk_hidden_bar .theme_button input,#prk_hidden_bar .fount_active_icon,#prk_hidden_bar .fount_address_icon,#prk_hidden_bar a,#prk_hidden_bar .widget-title,#prk_hidden_bar .not_zero_color,#prk_hidden_bar .not_zero_color a,#prk_hidden_bar a.not_zero_color {
                color: ".$prk_fount_options['active_color_right_bar']."; 
            }.bordered_buttons #prk_hidden_bar .theme_button a,.bordered_buttons #prk_hidden_bar .theme_button input {
                border-color:".$prk_fount_options['active_color_right_bar'].";
            }#prk_hidden_bar .simple_line {
                border-bottom:1px solid ".$prk_fount_options['body_color_right_bar'].";
                border-bottom:1px solid rgba($splitted_body_color_right_bar[0], $splitted_body_color_right_bar[1], $splitted_body_color_right_bar[2],0.2);
            }#prk_hidden_bar .pirenko_highlighted {
                border:1px solid ".$prk_fount_options['body_color_right_bar'].";
                border:1px solid rgba($splitted_body_color_right_bar[0], $splitted_body_color_right_bar[1], $splitted_body_color_right_bar[2],0.2);
            }#prk_hidden_bar .mCSB_scrollTools .mCSB_draggerRail {
                background-color: ".$prk_fount_options['body_color_right_bar'].";
                background-color: rgba($splitted_body_color_right_bar[0], $splitted_body_color_right_bar[1], $splitted_body_color_right_bar[2],0.3);
            }#prk_hidden_bar .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
                background-color: ".$prk_fount_options['active_color_right_bar']."; 
            }#prk_hidden_bar {
                background-color: ".$prk_fount_options['background_color_right_bar'].";
                border-left: 1px solid ".$prk_fount_options['background_color_right_bar'].";
            }#portfolio_info {
                border-left:1px solid $inactive_color;
                border-left:1px solid rgba($splitted_inactive_color[0], $splitted_inactive_color[1], $splitted_inactive_color[2],0.25);
            }.prk_author_avatar img {
                border:6px solid $site_background_color;
            }#main .recentposts_ul_slider.msnr .blog_lower,#main .masonry_blog .blog_lower,#prk_nav_inner,#author_area,#single_meta_footer,.single_blog_meta_class:before, .single_blog_meta_class:after,.prk_vc_title:before, .prk_vc_title:after,.page-prk-blog-full .blog_lower,.wpb_separator, .vc_text_separator,.post_meta_single,.simple_line,.fount_theme .testimonials_stack .item {
                border-bottom: 1px solid $lines_color;
            }#author_area img,ol.commentlist img.avatar {
                box-shadow: 0px 0px 3px $lines_color;
                -webkit-box-shadow: 0px 0px 3px $lines_color;
                -moz-box-shadow: 0px 0px 3px $lines_color;
            }.prk_prices_specs li,.underp {
                border-bottom: 1px solid $lines_color;
                border-bottom: 1px solid rgba($splitted_lines_color[0], $splitted_lines_color[1], $splitted_lines_color[2],0.65);
            }.menu_at_top #prk_responsive_menu .sf-menu>li.mega_menu>ul>li>a,.menu_at_top #prk_responsive_menu #menu_section .sf-menu>li,.menu_at_top #prk_responsive_menu .sf-menu .prk_regular_menu li,.menu_at_top #prk_responsive_menu .sf-menu .prk_regular_menu li:first-child {
                border-top:1px solid ".$prk_fount_options['submenu_lines_color'].";
            }.menu_at_top #prk_responsive_menu #menu_section .sf-menu>li:last-child {
                border-bottom: 1px solid ".$prk_fount_options['submenu_lines_color'].";
            }.prk_prices_specs {
                border-top: 1px solid $lines_color !important;
                border-top:1px solid rgba($splitted_lines_color[0], $splitted_lines_color[1], $splitted_lines_color[2],0.65) !important;
            }.recentposts_ul_shortcode .blog_lower,.masonry_blog .blog_lower,.recentposts_ul_slider .blog_lower,#prk_nav_inner,.prk_price_header,.post_meta_single,#prk_gallery_footer {
                border-top:1px solid $lines_color;
            }.wpb_row .wpb_column:last-child .wpb_wrapper .prk_price_table .prk_prices_specs,.wpb_row .wpb_column:last-child .wpb_wrapper .prk_price_table .prk_price_header{
                border-right:1px solid $lines_color;
            }.prk_prices_specs,.prk_price_header{
                border-left:1px solid $lines_color;
            }.sod_select:hover,.sod_select.open,.sod_select .sod_list_wrapper,.wpb_tabs .ui-tabs .ui-tabs-panel,.ui-accordion .ui-accordion-header,.ui-tabs .ui-tabs-nav li,.wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header,.vc_tta-panel-heading,.wpb_content_element .wpb_tour_tabs_wrapper .wpb_tab,.wpb_content_element .wpb_accordion_wrapper .wpb_accordion_content,.prk_minimal_button>span,.prk_minimal_button>a,.prk_minimal_button>input,.tagcloud a,.pirenko_highlighted,.pk_contact_highlighted,.prk_cropped_blockquote:before,.prk_cropped_blockquote:after,.prk_bordered,.vc_tta-panel-body,.fount_theme .vc_tta-container .vc_tta-tab,.fount_theme .vc_tta-container .vc_tta-tabs-position-left .vc_tta-tab.vc_active {
                border:1px solid $inputs_bordercolor;
            }.ui-accordion .ui-accordion-header,.ui-tabs .ui-tabs-nav li,.fount_theme .vc_tta-container .vc_tta-tab,.wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header,.vc_tta-panel-heading {
                background-color:$inputs_bordercolor;
                background-color:rgba($splitted_inputs_bordercolor[0], $splitted_inputs_bordercolor[1], $splitted_inputs_bordercolor[2], 0.50);}";
            if ($prk_fount_options['prk_responsive']=="1") {
                $css .= "@media only screen and (max-width: 767px) {.prk_price_table .prk_prices_specs,.prk_price_table .prk_price_header {
                        border-right:1px solid $lines_color;}}";
            }
            //RESPONSIVE RULES
            if ($prk_fount_options['right_bar_width']>480) {
                $css .= "@media only screen and (max-width: 767px) { 
                    #prk_hidden_bar {
                        width:420px;
                    }#body_hider {
                        right:420px;
                    }.prk_shifted #contact_info,.prk_shifted #prk_ajax_container,.prk_shifted #bottom_bar_wrapper,.prk_shifted #prk_responsive_menu,.prk_shifted #footer_mirror,.prk_shifted #prk_footer {
                        margin-left: -420px;
                    }.prk_shifted #fount_to_top {
                        margin-right: 420px;
                    }}";
            }
            if ($prk_fount_options['right_bar_width']>300) {
                $css .= "@media(max-width:480px) { 
                    #prk_hidden_bar{
                        width:280px;
                    }#body_hider {
                        right:280px;
                    }.prk_shifted #contact_info,.prk_shifted #prk_ajax_container,.prk_shifted #bottom_bar_wrapper,.prk_shifted #prk_responsive_menu,.prk_shifted #footer_mirror,.prk_shifted #prk_footer {
                        margin-left: -280px;
                    }.prk_shifted #fount_to_top {
                        margin-right: 280px;
                    }}";
            }
            //SHADOWS
            if (($custom_shadow)>0) {
                $css .= 
                "#prk_mega_wrap.boxed_fount,.boxed_shadow,.titled_portfolio .portfolio_entry_li,.woocommerce .boxed_shadow {
                    -webkit-box-shadow:0px 0px 2px rgba($splitted_shadow_color[0], $splitted_shadow_color[1], $splitted_shadow_color[2],".$custom_shadow.");
                    box-shadow:0px 0px 2px rgba($splitted_shadow_color[0], $splitted_shadow_color[1], $splitted_shadow_color[2],".$custom_shadow.");
                }";
                if ($custom_opacity_header>0)
                {
                    $css .= ".menu_at_top #prk_responsive_menu_inner,.fount_forced_menu #prk_responsive_menu_inner,#fount_wrapper.fount_collapsed_menu #prk_responsive_menu_inner {
                            -webkit-box-shadow:0px 0px 4px rgba($splitted_shadow_color[0], $splitted_shadow_color[1], $splitted_shadow_color[2],".$custom_shadow.");
                            box-shadow:0px 0px 4px rgba($splitted_shadow_color[0], $splitted_shadow_color[1], $splitted_shadow_color[2],".$custom_shadow.");}";
                }
            }
            $css .= "#fount_wrapper #content .cart-collaterals table,#fount_wrapper #content .shop_table,#fount_wrapper .woocommerce textarea, #fount_wrapper .woocommerce input,.woocommerce #fount_wrapper div.product .woocommerce-tabs .tabs li,.woocommerce-tabs .panel,.woocommerce .quantity input.qty,.woocommerce #content .quantity input.qty,.woocommerce-page .quantity input.qty,.woocommerce-page #content .quantity input.qty,.shop_table,.woocommerce #payment,.woocommerce .widget_product_search #s {
                border:1px solid $inputs_bordercolor;
            }.woocommerce table.shop_table tbody th, .woocommerce table.shop_table tfoot td, .woocommerce table.shop_table tfoot th,#fount_wrapper #content .cart-collaterals .cart_totals tr th,#fount_wrapper #content .cart-collaterals .cart_totals tr td,#fount_wrapper #content table.shop_table td {
                border-top:1px solid $inputs_bordercolor;
            }#fount_wrapper #content .woocommerce .button.alt,#fount_wrapper #content .woocommerce .button,#fount_wrapper .woocommerce .button,.woocommerce .widget_product_search #searchsubmit {
                background: ".$prk_fount_options['theme_buttons_color'].";
            }#fount_wrapper #content .woocommerce .button:hover,#fount_wrapper .woocommerce .button:hover,.woocommerce span.onsale,.woocommerce .widget_product_search #searchsubmit:hover {
                background:$active_color;
            }#fount_wrapper #content .woocommerce .button.alt,#fount_wrapper #content .woocommerce .button,#fount_wrapper .woocommerce .button, .fount_woo_add_button,.woocommerce .widget_product_search #searchsubmit {
                color:$site_background_color;
            }.woocommerce #fount_wrapper #content div.product .woocommerce-tabs ul.tabs li.active {
                background:$site_background_color;
                border-bottom-color: $site_background_color;
            }.fount_woo_add_button {
                background:".$prk_fount_options['buttons_color'].";
            }html .woocommerce .star-rating span,html .woocommerce .woocommerce-message:before {
                color: $active_color;
            }#fount_wrapper #sidebar ul.product_list_widget li a,.woocommerce .fount_woo_checkout h3,.woocommerce .customer_details dt,.shipping_calculator h2 a,.woocommerce-checkout ul.order_details,.woocommerce-checkout table.order_details tfoot>tr:last-child,.woocommerce-checkout .addresses h3,.woocommerce #order_review_heading, .woocommerce #customer_details h3,.woocommerce .order-total,.woocommerce-result-count,.pp_woocommerce .pp_description,.woocommerce #fount_wrapper .woocommerce-tabs .tabs li a,#fount_wrapper .woocommerce #content .price,#fount_wrapper .woocommerce .price,#fount_wrapper .woocommerce .product_title,#fount_wrapper .woocommerce .product_meta,#fount_wrapper .woocommerce h2 {
                color: $bd_headings_color;  
            }.woocommerce .fount_woo_thankyou header h2,.woocommerce .simple_line,.woocommerce-checkout #fount_wrapper h3,.woocommerce table.shop_table th,.woocommerce #fount_wrapper .woocommerce-tabs ul.tabs:before {
                border-bottom-color:$inputs_bordercolor;
            }.woocommerce #fount_wrapper .woocommerce-tabs .tabs li.active {
                border-bottom-color:$site_background_color;
            }.woocommerce #payment div.payment_box:after, .woocommerce-page #payment div.payment_box:after {
                border:8px solid $inputs_bordercolor;
                border:8px solid rgba($splitted_inputs_bordercolor[0], $splitted_inputs_bordercolor[1], $splitted_inputs_bordercolor[2], 0.50);
                border-right-color: transparent;
                border-left-color: transparent;
                border-top-color: transparent;
            }#fount_wrapper .price del, #fount_wrapper .woocommerce .price del, .woocommerce #fount_wrapper .price del {
                color:".$prk_fount_options['bd_smallers_color'].";
            }.fount_woo_el_wrapper,#fount_wrapper #sidebar ul.product_list_widget li {
                border-bottom:1px solid $lines_color;
            }.woocommerce .woocommerce-error,.woocommerce .woocommerce-info,.woocommerce #payment div.payment_box, .woocommerce-page #payment div.payment_box,.woocommerce .woocommerce-message,.woocommerce #fount_wrapper #content div.product .woocommerce-tabs ul.tabs li {
                background:$inputs_bordercolor;
                background:rgba($splitted_inputs_bordercolor[0], $splitted_inputs_bordercolor[1], $splitted_inputs_bordercolor[2], 0.50);}";
            //EXTRA STYLES IF VC IS OFF
            if (!PRK_FOUNT_COMPOSER)
            {
                $css .= ".prk_no_composer {
                        margin-bottom:32px;
                        margin-left:0px !important;
                        margin-right:0px !important;
                    }";
            }
            if (isset($prk_fount_options['css_text']) && $prk_fount_options['css_text']!="")
            {
                $css.=htmlspecialchars_decode($prk_fount_options['css_text']);
            }
        //OUTPUT THE CUSTOM STYLES WE JUST BUILT                
        wp_add_inline_style( 'fount_custom_style', $css );
    }
    //ADD CUSTOM SCRIPTS FOR THE BACKEND
    function fount_admin_scripts() 
    {
        if (function_exists('wp_get_theme'))
            $prk_theme = wp_get_theme();
        else
        {
            $prk_theme->Version="1";
        }
        wp_register_style( 'prk_admin_css', get_template_directory_uri() . '/css/admin.css',false,$prk_theme->Version );
        wp_enqueue_style('prk_admin_css');
        wp_register_script('prk_admin_js',  get_template_directory_uri(). '/js/admin-min.js', array('jquery', 'jquery-ui-core'), NULL, TRUE);
        wp_enqueue_script('prk_admin_js');
    }

    include_once locate_template('/inc/activation.php'); // Activations functions
    include_once locate_template('/inc/config.php'); // Configuration and constants
    include_once locate_template('/inc/cleanup.php'); // Cleanup
    include_once locate_template('/inc/helper.php'); // Various functions
    include_once locate_template('/inc/modules/vt_resize.php'); //Image Resize Script
    include_once locate_template('/inc/widgets.php'); // Sidebars and widgets
    include_once locate_template('/inc/modules/sweet-custom-menu/sweet-custom-menu.php'); // Menu Walkers
    

    if(!class_exists('ReduxFramework')){
        include_once('inc/modules/ReduxCore/framework.php');
    }
    include_once('inc/modules/ReduxCore/theme/options.php');

    
    add_action('wp_enqueue_scripts', 'fount_scripts', 100);
    add_action('admin_enqueue_scripts', 'fount_admin_scripts');
    add_action('after_setup_theme', 'fount_setup');
    add_action('wp_footer','jquery_sender');

    if (PRK_WOO=="true") {
        if (INJECT_STYLE) {
            include(ABSPATH . 'wp-content/plugins/color-manager-fount/style_header.php');
            if ($prk_fount_options['fount_active_skin']!="" && $prk_fount_options['fount_active_skin']!="fount_shop_skin") {
                function woocommerce_de_script() {
                    if (function_exists( 'is_woocommerce' )) {
                     if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() ) { // if we're not on a Woocommerce page, dequeue all of these scripts
                        wp_dequeue_script('wc-add-to-cart');
                        wp_dequeue_script('jquery-blockui');
                        wp_dequeue_script('jquery-placeholder');
                        wp_dequeue_script('woocommerce');
                        wp_dequeue_script('jquery-cookie');
                        wp_dequeue_script('wc-cart-fragments');
                        wp_dequeue_script('wc-chosen');

                      }
                    }
                }
                add_action( 'wp_print_scripts', 'woocommerce_de_script', 100 );

                add_action( 'wp_enqueue_scripts', 'remove_woocommerce_generator', 99 );
                function remove_woocommerce_generator() {
                    if (function_exists( 'is_woocommerce' )) {
                    if (!is_woocommerce()) { // if we're not on a woo page, remove the generator tag
                        remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
                    }
                    }
                }
                add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
            }
        }
        add_theme_support('woocommerce');
        add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
        function jk_dequeue_styles( $enqueue_styles ) {
            unset( $enqueue_styles['woocommerce-smallscreen'] );    // Remove the smallscreen optimisation
            return $enqueue_styles;
        }
        /**
         * WooCommerce Extra Feature
         * --------------------------
         *
         * Change number of related products on product page
         * Set your own value for 'posts_per_page'
         *
         */ 
        function woo_related_products_limit() {
          global $product;
            
            $args['posts_per_page'] = 3;
            return $args;
        }
        add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
          function jk_related_products_args( $args ) {
            $args['posts_per_page'] = 3; // 3 related products
            $args['columns'] = 3; // arranged in 3 columns
            return $args;
        }

    }

    if (!function_exists('fount_output')) {
        function fount_output() {
            return;
        }
    }

    //ENABLE SHORTCODES ON SIDEBARS
    add_filter('widget_text', 'do_shortcode');

    //SEND EMAIL FUNCTION
    add_action('wp_ajax_mail_before_submit', 'prk_mail_before_submit');
    add_action('wp_ajax_nopriv_mail_before_submit', 'prk_mail_before_submit');

    //BETTER QTRANSLATE SUPPORT
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (is_plugin_active('qtranslate/qtranslate.php')) {
        function qtranslate_edit_taxonomies(){
           $args=array(
              'public' => true ,
              '_builtin' => false
           );
           $output = 'object'; // or objects
           $operator = 'and'; // 'and' or 'or'

           $taxonomies = get_taxonomies($args,$output,$operator); 

           if  ($taxonomies) {
             foreach ($taxonomies  as $taxonomy ) {
                 add_action( $taxonomy->name.'_add_form', 'qtrans_modifyTermFormFor');
                 add_action( $taxonomy->name.'_edit_form', 'qtrans_modifyTermFormFor');        

             }
           }
        }
        add_action('admin_init', 'qtranslate_edit_taxonomies');
    }

    //JETPACK RETINA SCRIPT REMOVE
    function dequeue_devicepx() {
        wp_dequeue_script( 'devicepx' );
    }
    add_action('wp_enqueue_scripts', 'dequeue_devicepx', 20);

    //FACEBOOK EXTRA INFO
    if (!defined('WPSEO_VERSION')) {
        function prk_facebook() {
            global $post;
            if (!is_singular()) {
                return;
            }
            echo '<meta property="og:title" content="'.get_the_title().'" />';
            echo '<meta property="og:type" content="article"/>';
            echo '<meta property="og:url" content="'.get_permalink().'" />';
            echo '<meta property="og:site_name" content="'.get_bloginfo('name').'" />';
            echo '<meta property="og:description" content="'.get_post_field('post_excerpt',$post->ID).'" />';
            if(has_post_thumbnail( $post->ID )) {
                $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ),'full');
                echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '" />';
            }
        }
        add_action('wp_head', 'prk_facebook', 5);
    }

    //VISUAL COMPOSER STUFF
    if (PRK_FOUNT_COMPOSER) {

        function prk_vc_disable_update() {
            if (function_exists('vc_license') && function_exists('vc_updater') && ! vc_license()->isActivated()) {
                remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ), 10);
                remove_filter( 'pre_set_site_transient_update_plugins', array(
                    vc_updater()->updateManager(),
                    'check_update'
                ) );
            }
        }
        add_action( 'admin_init', 'prk_vc_disable_update', 9 );

        add_filter('wpb_widget_title', 'override_widget_title', 10, 2);
        function override_widget_title($output = '', $params = array('')) {
          $extraclass = (isset($params['extraclass'])) ? " ".$params['extraclass'] : "";
          return '<div class="prk_shortcode-title"><div class="header_font sizer_small bd_headings_text_shadow zero_color '.$extraclass.'">'.$params['title'].'</div></div>';
        }
        function fount_vcSetAsTheme() {
            if (function_exists('vc_set_as_theme')) {
                vc_set_as_theme(true);
                if (function_exists('vc_editor_set_post_types')) {
                    vc_editor_set_post_types(array('page','post','pirenko_team_member','pirenko_slides','pirenko_portfolios'));
                }
            }
        }
        add_action('init','fount_vcSetAsTheme');

        //ENQUEUE THE THEME TWEAKED JS AND CSS FILES
        function fount_vc_scripts() {
            global $prk_fount_options;
            if ( defined('WPB_VC_VERSION')) {
                wp_deregister_style('js_composer_custom_css');
                wp_deregister_style('js_composer_front');
                wp_deregister_style('flexslider');
                wp_deregister_style('prettyphoto');
                wp_deregister_script('nivo-slider');
                wp_deregister_script('isotope');
                wp_deregister_script('waypoints');
                wp_deregister_script('vc_accordion_script');
                wp_deregister_script('vc_tabs_script');
                wp_deregister_script('vc_tta_autoplay_script');
                wp_deregister_script('wpb_composer_front_js');
                wp_deregister_script('jquery_ui_tabs_rotate');
                
                wp_register_script('wpb_composer_front_js',get_template_directory_uri().'/js/js_composer_front-min.js', array('jquery'), WPB_VC_VERSION, true );
                wp_enqueue_script('wpb_composer_front_js');

                add_filter( 'vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2 );
                function custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
                  /*if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
                    $class_string = str_replace( 'vc_row-fluid', 'my_row-fluid', $class_string ); // This will replace "vc_row-fluid" with "my_row-fluid"
                  }*/
                  if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
                    $class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'vc_span$1', $class_string ); // This will replace "vc_col-sm-%" with "my_col-sm-%"
                  }
                  return $class_string; // Important: you should always return modified or original $class_string
                }
            }
        }
        add_action('wp_enqueue_scripts', 'fount_vc_scripts', 10);//WAS 100
        function vc_remove_wp_admin_bar_button() {
            remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
        }
        add_action( 'vc_after_init', 'vc_remove_wp_admin_bar_button' );
        /*function vc_remove_frontend_links() {
            vc_disable_frontend(); // this will disable frontend editor
        }
        add_action( 'vc_after_init', 'vc_remove_frontend_links' );*/
    }
    if (function_exists('wp_get_theme'))
        $prk_theme = wp_get_theme();
    else
    {
        $prk_theme->Version="1";
    }

    /**
     * Include the TGM_Plugin_Activation class.
     */
    require_once dirname( __FILE__ ) . '/inc/modules/tgm-plugin-activation/class-tgm-plugin-activation.php';

    add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
    /* Register the required plugins for this theme. */
    function my_theme_register_required_plugins() {

        $plugins = array(
            array(
                'name'                  => 'Fount Framework',
                'slug'                  => 'fount_framework',
                'source'                => get_template_directory_uri() . '/external_plugins/fount_framework.zip', 
                'required'              => true, // If false, the plugin is only 'recommended' instead of required
                'version'               => '4.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'                  => 'WPBakery Visual Composer',
                'slug'                  => 'js_composer',
                'source'                => get_template_directory_uri() . '/external_plugins/js_composer.zip', 
                'required'              => true, // If false, the plugin is only 'recommended' instead of required
                'version'               => '4.12', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'                  => 'Envato toolkit - Useful to keep the theme updated',
                'slug'                  => 'envato-wordpress-toolkit',
                'source'                => get_template_directory_uri() . '/external_plugins/envato-wordpress-toolkit.zip', 
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
                'version'               => '1.7.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
        );
        $config = array(
            'domain'            => 'fount',            // Text domain - likely want to be the same as your theme.
            'default_path'      => '',                          // Default absolute path to pre-packaged plugins
            'menu'              => 'install-required-plugins',  // Menu slug
            'has_notices'       => true,                        // Show admin notices or not
            'is_automatic'      => true,                        // Automatically activate plugins after installation or not
            'message'           => '',                         // Message to output right before the plugins table
            'strings'           => array(
                'page_title'                                => __( 'Install Required Plugins', 'fount' ),
                'menu_title'                                => __( 'Install Plugins', 'fount' ),
                'installing'                                => __( 'Installing Plugin: %s', 'fount' ), // %1$s = plugin name
                'oops'                                      => __( 'Something went wrong with the plugin API.', 'fount' ),
                'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin (self-hosted): %1$s.', 'This theme requires the following plugins (self-hosted): %1$s.' ), // %1$s = plugin name(s)
                'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin (self-hosted): %1$s.', 'This theme recommends the following plugins (self-hosted): %1$s.' ), // %1$s = plugin name(s)
                'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
                'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
                'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
                'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
                'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.<br>The update is located on the theme root folder inside the external_plugins folder.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.<br>The updates are located on the theme root folder inside the external_plugins folder.' ), // %1$s = plugin name(s)
                'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
                'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
                'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
                'return'                                    => __( 'Return to Required Plugins Installer', 'fount' ),
                'plugin_activated'                          => __( 'Plugin activated successfully.', 'fount' ),
                'complete'                                  => __( 'All plugins installed and activated successfully. %s', 'fount' ), // %1$s = dashboard link
                'nag_type'                                  => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
            )
        );
        tgmpa( $plugins, $config );
    }

    function rewrite_photo_url(){
        add_rewrite_rule('^report/([^/]*)/?','index.php?page_id=2671&value=$matches[1]','top');
        add_rewrite_rule('^intel/([^/]*)/?','index.php?page_id=2237&url=$matches[1]','top');
        add_rewrite_rule('^reset-password-request/([^/]*)/?','index.php?page_id=7733&reset-pass-param=$matches[1]','top');
    }

    function register_custom_query_vars($query_vars){
        $query_vars[] = 'value';
        $query_vars[] = 'url';
        $query_vars[] = 'reset-pass-param';
        return $query_vars;
    }

    add_action( 'template_redirect', function(){
        if ( is_front_page() ) {
            remove_action( 'template_redirect', 'redirect_canonical' );
        }
    }, 0 );

    add_action('init','rewrite_photo_url');
    add_filter('query_vars','register_custom_query_vars');

    add_filter('wpseo_title','custom_title');

    function custom_title( $title ){
        $url_name =get_query_var('value');
        $pag_id = get_query_var('page_id');
        $url=get_template_directory_uri();
        $username = 'Opaxe';
        $password = 'Vaybeydvek8BalCiWang2';
        if($pag_id==2671)
        {
            // Get cURL resource
            $curl = curl_init();
    // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => "$url/intel/lib/all.php?action=getreportDetailbyName&name=$url_name",
                CURLOPT_USERPWD => $username . ":" . $password
            ));

            $resp = curl_exec($curl);
            $someArray = json_decode($resp, true);
            $company= $someArray['reportdata'][0]['company'];
            $project= $someArray['reportdata'][0]['project'];
            $type= $someArray['reportdata'][0]['type'];
            $date= $someArray['reportdata'][0]['date'];
            $new_title= "$company: $project $type $date";
            curl_close($curl);
            $title=$new_title;
            return $title;
        }
        else
        {
            return $title;
        }
    }

    add_filter('wpseo_metadesc','custom_meta');
    function custom_meta( $desc )
    {

    $url_name =get_query_var('value');
    $pag_id = get_query_var('page_id');
    $url=get_template_directory_uri();

        $username = 'Opaxe';
        $password = 'Vaybeydvek8BalCiWang2';

    if($pag_id==2671)
    {
    // Get cURL resource
    $curl = curl_init();
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => "$url/intel/lib/all.php?action=getreportDetailbyName&name=$url_name",
        CURLOPT_USERPWD => $username . ":" . $password
    ));

    $resp = curl_exec($curl);
        $someArray = json_decode($resp, true);
        $meta_desc= $someArray['reportdata'][0]['meta_desc'];
        curl_close($curl);

        $desc=$meta_desc;
        return $desc;
    }
    else
    {
        return $desc;
     }
    }

    function design_canonical($url) {
    $url_name =get_query_var('value');
    $pag_id = get_query_var('page_id');
    $temp_url=get_template_directory_uri();

        $username = 'Opaxe';
        $password = 'Vaybeydvek8BalCiWang2';

    if($pag_id==2671)
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "$temp_url/intel/lib/all.php?action=getreportDetailbyName&name=$url_name",
            CURLOPT_USERPWD => $username . ":" . $password
        ));

        $resp = curl_exec($curl);
        $someArray = json_decode($resp, true);
        $meta_desc= $someArray['reportdata'][0]['meta_desc'];
        curl_close($curl);

        return site_url( '/report/' . $url_name );
    } else
    {
    // Do nothing and Yoast SEO will use default canonical for posts/pages
        return $url;
    }
    }

    add_filter( 'wpseo_canonical', 'design_canonical' );

    wp_enqueue_style('myglobalcss',('/wp-content/themes/fount/intel/css/opaxe.css'));
?>

