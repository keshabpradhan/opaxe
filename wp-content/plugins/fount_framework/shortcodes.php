<?php
add_action( 'init', 'prk_fount_scodes' );

function prk_fount_scodes() {
	if (!function_exists('html2rgb')) {
		function html2rgb($color,$alpha)
	    {
	        if ($color[0] == '#')
	            $color = substr($color, 1); 
	        if (strlen($color) == 6)
	            list($r, $g, $b) = array($color[0].$color[1],$color[2].$color[3],$color[4].$color[5]);
	                elseif (strlen($color) == 3)
	                    list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
	                else
	                    return false;
	        $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

	        return array($r, $g, $b ,$alpha);
	    }
	}
	//SHORTCODES MANAGEMENT
	//INTAGRAM FEED
	//According to https://gist.github.com/cosmocatalano/4544576
	function fnt_instafeed( $username, $slice = 9 ) {

	    $username = strtolower( $username );

	    if ( false === ( $instagram = get_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ) ) ) ) {

	        $remote = wp_remote_get( 'http://instagram.com/'.trim( $username ) );

	        if ( is_wp_error( $remote ) )
	            return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'fount_theme' ) );

	        if ( 200 != wp_remote_retrieve_response_code( $remote ) )
	            return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'fount_theme' ) );

	        $shards = explode( 'window._sharedData = ', $remote['body'] );
	        $insta_json = explode( ';</script>', $shards[1] );
	        $insta_array = json_decode( $insta_json[0], TRUE );

	        if ( !$insta_array )
	            return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'fount_theme' ) );

	        // old style
	        if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
	            $images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
	            $type = 'old';
	        // new style
	        } else if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
	            $images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
	            $type = 'new';
	        } else {
	            return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'fount_theme' ) );
	        }

	        if ( !is_array( $images ) )
	            return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'fount_theme' ) );

	        $instagram = array();

	        switch ( $type ) {
	            case 'old':
	                foreach ( $images as $image ) {

	                    if ( $image['user']['username'] == $username ) {

	                        $image['link']                        = preg_replace( "/^http:/i", "", $image['link'] );
	                        $image['images']['thumbnail']          = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
	                        $image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );
	                        $image['images']['low_resolution']    = preg_replace( "/^http:/i", "", $image['images']['low_resolution'] );

	                        $instagram[] = array(
	                            'description'   => $image['caption']['text'],
	                            'link'          => $image['link'],
	                            'time'          => $image['created_time'],
	                            'comments'      => $image['comments']['count'],
	                            'likes'         => $image['likes']['count'],
	                            'thumbnail'     => $image['images']['thumbnail'],
	                            'large'         => $image['images']['standard_resolution'],
	                            'small'         => $image['images']['low_resolution'],
	                            'type'          => $image['type']
	                        );
	                    }
	                }
	            break;
	            default:
	                foreach ( $images as $image ) {

	                    $image['display_src'] = preg_replace( "/^http:/i", "", $image['display_src'] );

	                    if ( $image['is_video']  == true ) {
	                        $type = 'video';
	                    } else {
	                        $type = 'image';
	                    }

	                    $instagram[] = array(
	                        'description'   => esc_html__( 'Instagram Image', 'fount_theme' ),
	                        'link'          => '//instagram.com/p/' . $image['code'],
	                        'time'          => $image['date'],
	                        'comments'      => $image['comments']['count'],
	                        'likes'         => $image['likes']['count'],
	                        'thumbnail'     => $image['display_src'],
	                        'type'          => $type
	                    );
	                }
	            break;
	        }

	        // do not set an empty transient - should help catch private or empty accounts
	        if ( ! empty( $instagram ) ) {
	            $instagram = base64_encode( serialize( $instagram ) );
	            set_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
	        }
	    }

	    if ( ! empty( $instagram ) ) {

	        $instagram = unserialize( base64_decode( $instagram ) );
	        return array_slice( $instagram, 0, $slice );

	    } else {
	        return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'fount_theme' ) );

	    }
	}
	function prk_instagram_func( $atts, $content = null ) {
		$atts=shortcode_atts(array(
			'user'    	 => '',
			'items'    	 => '4',
			'title'    	 => '',
			'rows'    	 => '1',
			'title_color' => '',
			'gen_display' => 'fnt_insta_grid',
			'img_margin' => '0',
			'css_animation' => '',
			'el_class' => '',
		), $atts);
		global $prk_fount_options;
		$out="";
		$items=$atts['items'];
		$rows=$atts['rows'];
		$images_count=$items*$rows;
		if ($atts['user']!="") {
			$media_array = fnt_instafeed($atts['user'],$images_count);
			if ( is_wp_error( $media_array ) ) {
			    $out.=$media_array->get_error_message();
			} else {
				$main_classes="fnt_insta_wrapper ".$atts['gen_display'];
				if ($atts['css_animation']!="")
					$main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
				if ($atts['el_class']!="")
					$main_classes.=" ".$atts['el_class'];
				$out.='<div class="'.$main_classes.'">';
				if ($atts['title']!="") {
					if ($atts['title_color']!="") {
						$out.='<div class="fnt_insta_title header_font prk_left_floated zero_color" style="color:'.$atts['title_color'].'"><a href="https://instagram.com/'.$atts['user'].'/" target="_blank" data-color="'.$prk_fount_options['active_color'].'" data-forced-color="'.$atts['title_color'].'" style="color:'.$atts['title_color'].'"><i class="fount_fa-instagram"></i><h4>'.$atts['title'].'</h4></a></div>';
					}
					else {
						$out.='<div class="fnt_insta_title header_font prk_left_floated zero_color"><a href="https://instagram.com/'.$atts['user'].'/" target="_blank"><i class="fount_fa-instagram"></i><h4>'.$atts['title'].'</h4></a></div>'; 
					}
				}
				$inline_out=$inline_in="";
				if ($atts['gen_display']=="fnt_insta_slider") {
					$items.=" owl-carousel";
				}
				else {
					if ($atts['img_margin']!="0") {
						$inline_out=' style="margin-left:-'.$atts['img_margin'].'px;margin-right:-'.$atts['img_margin'].'px;"';
						$inline_in=' style="padding:'.$atts['img_margin'].'px;"';
					}
				}
				$out.='<ul class="fnt_instagram unstyled cols-'.$items.'" data-autoplay="true" data-delay="3000" data-anim="fade"'.$inline_out.'>';
				$i=0;
	            foreach ($media_array as $item) {
	            	//print_r ($item);
		            $out.='<li class="item"'.$inline_in.'><a href="'. esc_url( $item['link'] ) .'" target="_blank"><div style="background-image:url('. esc_url( $item['thumbnail'] ) .');"><div class="insta_overlay"></div><i class="fount_fa-instagram"></i>';
		            $out.='<img src="'.get_template_directory_uri().'/images/instaholder.png" width="1080" height="1080"  alt="'. esc_attr( $item['description'] ) .'" data-title="'. esc_attr( $item['description'] ).'" />';
		            $out.='</div></a></li>';
		            $i++;
		            if ($i%$items==0 && $atts['gen_display']=="fnt_insta_grid") {
		            	$out.='<li class="clearfix"></li>';
		            }
	            }
	            $out.='</ul>';
	            $out.='<div class="clearfix"></div></div>';
			}
		}
		return $out;
	}
	add_shortcode('prk_instagram', 'prk_instagram_func');
	//SOCIAL NETWORK LINKS
	function pirenko_social_nets_shortcode( $atts, $content = null ) 
	{
		$main_classes="";
		if (isset($atts['el_class']) && $atts['el_class']!="")
			$main_classes=" ".$atts['el_class'];
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
			$main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		$out='<div class="social_links_shortcode">';
		if (isset($atts['net_1']) && $atts['net_1']!="none")
        {
            $out.='<div class="fount_socialink prk_bordered member_lnk fount-'.$atts['net_1'].' colorer-'.$atts['net_1'].'">';
            $out.='<a href="'.$atts['link_1'].'" target="_blank" data-color="'.prk_social_color($atts['net_1']).'">';
            $out.='<div class="'.prk_social_icon($atts['net_1']).'">';
			$out.='</div>';
            $out.='<div class="bg_shifter">';
            $out.='<i class="'.prk_social_icon($atts['net_1']).'"></i>';
            $out.='</div>';
            $out.='</a>';
            $out.='</div>';
        }
        if (isset($atts['net_2']) && $atts['net_2']!="none")
        {
            $out.='<div class="fount_socialink prk_bordered member_lnk fount-'.$atts['net_2'].' colorer-'.$atts['net_2'].'">';
            $out.='<a href="'.$atts['link_2'].'" target="_blank" data-color="'.prk_social_color($atts['net_2']).'">';
            $out.='<div class="'.prk_social_icon($atts['net_2']).'">';
			$out.='</div>';
            $out.='<div class="bg_shifter">';
            $out.='<i class="'.prk_social_icon($atts['net_2']).'"></i>';
            $out.='</div>';
            $out.='</a>';
            $out.='</div>';
        }
        if (isset($atts['net_3']) && $atts['net_3']!="none")
        {
            $out.='<div class="fount_socialink prk_bordered member_lnk fount-'.$atts['net_3'].' colorer-'.$atts['net_3'].'">';
            $out.='<a href="'.$atts['link_3'].'" target="_blank" data-color="'.prk_social_color($atts['net_3']).'">';
            $out.='<div class="'.prk_social_icon($atts['net_3']).'">';
			$out.='</div>';
            $out.='<div class="bg_shifter">';
            $out.='<i class="'.prk_social_icon($atts['net_3']).'"></i>';
            $out.='</div>';
            $out.='</a>';
            $out.='</div>';
        }
        if (isset($atts['net_4']) && $atts['net_4']!="none")
        {
            $out.='<div class="fount_socialink prk_bordered member_lnk fount-'.$atts['net_4'].' colorer-'.$atts['net_4'].'">';
            $out.='<a href="'.$atts['link_4'].'" target="_blank" data-color="'.prk_social_color($atts['net_4']).'">';
            $out.='<div class="'.prk_social_icon($atts['net_4']).'">';
			$out.='</div>';
            $out.='<div class="bg_shifter">';
            $out.='<i class="'.prk_social_icon($atts['net_4']).'"></i>';
            $out.='</div>';
            $out.='</a>';
            $out.='</div>';
        }
        if (isset($atts['net_5']) && $atts['net_5']!="none")
        {
            $out.='<div class="fount_socialink prk_bordered member_lnk fount-'.$atts['net_5'].' colorer-'.$atts['net_5'].'">';
            $out.='<a href="'.$atts['link_5'].'" target="_blank" data-color="'.prk_social_color($atts['net_5']).'">';
            $out.='<div class="'.prk_social_icon($atts['net_5']).'">';
			$out.='</div>';
            $out.='<div class="bg_shifter">';
            $out.='<i class="'.prk_social_icon($atts['net_5']).'"></i>';
            $out.='</div>';
            $out.='</a>';
            $out.='</div>';
        }
        if (isset($atts['net_6']) && $atts['net_6']!="none")
        {
            $out.='<div class="fount_socialink prk_bordered member_lnk fount-'.$atts['net_6'].' colorer-'.$atts['net_6'].'">';
            $out.='<a href="'.$atts['link_6'].'" target="_blank" data-color="'.prk_social_color($atts['net_6']).'">';
            $out.='<div class="'.prk_social_icon($atts['net_6']).'">';
			$out.='</div>';
            $out.='<div class="bg_shifter">';
            $out.='<i class="'.prk_social_icon($atts['net_6']).'"></i>';
            $out.='</div>';
            $out.='</a>';
            $out.='</div>';
        }
        if (isset($atts['net_7']) && $atts['net_7']!="none")
        {
            $out.='<div class="fount_socialink prk_bordered member_lnk fount-'.$atts['net_7'].' colorer-'.$atts['net_7'].'">';
            $out.='<a href="'.$atts['link_7'].'" target="_blank" data-color="'.prk_social_color($atts['net_7']).'">';
            $out.='<div class="'.prk_social_icon($atts['net_7']).'">';
			$out.='</div>';
            $out.='<div class="bg_shifter">';
            $out.='<i class="'.prk_social_icon($atts['net_7']).'"></i>';
            $out.='</div>';
            $out.='</a>';
            $out.='</div>';
        }
        if (isset($atts['net_8']) && $atts['net_8']!="none")
        {
            $out.='<div class="fount_socialink prk_bordered member_lnk fount-'.$atts['net_8'].' colorer-'.$atts['net_8'].'">';
            $out.='<a href="'.$atts['link_8'].'" target="_blank" data-color="'.prk_social_color($atts['net_8']).'">';
            $out.='<div class="'.prk_social_icon($atts['net_8']).'">';
			$out.='</div>';
            $out.='<div class="bg_shifter">';
            $out.='<i class="'.prk_social_icon($atts['net_8']).'"></i>';
            $out.='</div>';
            $out.='</a>';
            $out.='</div>';
        }
        $out.='<div class="clearfix"></div>';
        $out.='</div>';
        return $out;
	}
	add_shortcode('pirenko_social_nets', 'pirenko_social_nets_shortcode');
	//SPACER
	function spacer_shortcode( $atts, $content = null ) 
	{
		if (isset($atts['size']) && $atts['size']!="")
		{
			$size=$atts['size'];
		}
		else
		{
			$size=10;
		}
		$main_classes="";
		if (isset($atts['el_class']) && $atts['el_class']!="")
			$main_classes=" ".$atts['el_class'];
		if ($size>0)
			return '<div class="clearfix'.$main_classes.'" style="height:' .$size. 'px;"></div>';
		else
	   		return '<div class="clearfix'.$main_classes.'" style="margin-top:' .$size. 'px;"></div>';
	}
	add_shortcode('pirenko_spacer', 'spacer_shortcode');

	//THEME ICON
	function pirenko_theme_icon_shortcode( $atts, $content = null ) 
	{
		if (isset($atts['icon']) && $atts['icon']!="")
		{
			if (isset($atts['icon_size']) && $atts['icon_size']!="")
			{
				$inline='style="font-size:'.$atts['icon_size'].';';
			}
			else
			{
				$inline='style="font-size:14px;';
			}
			if (isset($atts['text_color']) && $atts['text_color']!="")
			{
				$inline.='color:'.$atts['text_color'].';';
			}
			$inline_wrapper="";
			if (isset($atts['align']) && $atts['align']!="")
			{
				$inline_wrapper=' style="text-align:'.$atts['align'].';"';
			}
			$inline.='"';
			$main_classes="";
			$icon=str_replace('fa fa', 'fount_fa', $atts['icon']);
			if (isset($atts['css_animation']) && $atts['css_animation']!="")
				$main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
			if (isset($atts['el_class']) && $atts['el_class']!="")
				$main_classes.=" ".$atts['el_class'];
			return '<div class="theme_icon_shortcoded'.$main_classes.'"'.$inline_wrapper.'><i class="'.$icon.'" '.$inline.'></i></div>';
		}
		else
		{
			return;
		}
	}
	add_shortcode('pirenko_theme_icon', 'pirenko_theme_icon_shortcode');
	
	//BLOCKQUOTES
	function blockquotes_shortcode( $atts, $content = null ) 
	{
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
		{
			if (isset($atts['el_class']) && $atts['el_class']!="")
				$atts['css_animation']=$atts['css_animation']." ".$atts['el_class'];
			$output='<div class="fount_bquote_wrapper wpb_animate_when_almost_visible wpb_'.$atts['css_animation'].'">';
		}
		else
			$output='<div class="fount_bquote_wrapper">';
		if ($atts['type']=="plain") {
			$output.='<div class="prk_bordered prk_blockquote ' . $atts['type'].'">';
			$output.='<div class="in_quote"><div class="prk_inner_tip prk_bordered"></div><div class="tip_top_hide"></div>' . $content . '</div></div><div class="pirenko_author prk_heavier">' . $atts['author'] . '<span class="after_author">' . $atts['after_author']. '</span>';
			$output.='</div>';
	   	
		}
	   	else if ($atts['type']=="cropped_corners") {
			$output.='<div class="prk_bordered prk_blockquote prk_cropped_blockquote ' . $atts['type']. '">';
			if ($atts['author']!="" || $atts['after_author'] !="")
	   		{
	   			$output.='<div class="in_quote">' . $content . '<div class="pirenko_author prk_heavier cropped_corners">' . $atts['author'] . '<span class="after_author">' . $atts['after_author']. '</span></div></div>';
	   		}
	   		else
	   		{
	   			$output.='<div class="in_quote">' . $content . '</div>';
	   		}
			$output.='</div>';
	   	
		}
		else
	   	{
	   		if ($atts['author']!="" || $atts['after_author'] !="")
	   		{
	   			$author_html='<div class="pirenko_author prk_heavier">' . $atts['author'] . '<span class="after_author">' . $atts['after_author']. '</span></div>';
	   		}
	   		else
	   		{
	   			$author_html="";
	   		}
	   		$output.='<div class="prk_blockquote ' . $atts['type']. '">';
	   		$output.='<div class="in_quote">'.$content.$author_html.'</div>';
	   		$output.='</div>';
	   	}
	   	$output.='</div>';
	   	return $output;
	}
	add_shortcode('pirenko_blockquote', 'blockquotes_shortcode');

	function pirenko_sh_styled_title( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'type' => '',
			'align' =>''
		), $atts));
		$main_classes="";
		if ($atts['underlined']!="")
			$main_classes.=" ".$atts['underlined'];
		if (isset($atts['use_italic']) && $atts['use_italic']=="yes")
			$classes="fount_italic";
		else
			$classes="header_font";

		$inline="";
		if (isset($atts['text_color']) && $atts['text_color']=="") 
		{
			$classes.=" bd_headings_text_shadow";
		}
		else 
		{
			$splitted_shadow=html2rgb($atts['text_color'],"1");
			$inline="color:".$atts['text_color'].";";
			$inline.="border-bottom-color:rgba(".$splitted_shadow[0].", ".$splitted_shadow[1].", ".$splitted_shadow[2].",0.9);";
			$inline.="text-shadow:0px 0px 1px rgba(".$splitted_shadow[0].", ".$splitted_shadow[1].", ".$splitted_shadow[2].",0.2);";
		}
		if (isset($atts['align'])) {
			if (strtolower($atts['align'])=="left")
			{
				$main_classes.=" fount_lefted_text";
			}
			if (strtolower($atts['align'])=="center")
			{
				$main_classes.=" fount_centered_text";
			}
			if (strtolower($atts['align'])=="right")
			{
				$main_classes.=" fount_righted_text";
			}
		}
		else {
			$main_classes.=" fount_centered_text";
		}
		$h_tag="h1";
		if (isset($atts['title_size']) && $atts['title_size']!="")
			$h_tag=$atts['title_size'];
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
			$main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		if (isset($atts['el_class']) && $atts['el_class']!="")
			$main_classes.=" ".$atts['el_class'];
		$main_classes.=" ".$h_tag.'_sized';
		if ($atts['fount_show_line']=="double_lined")
			$main_classes.=" ".$atts['fount_show_line'];
		if (isset($atts['line_color']) && $atts['line_color']!="")
		{
			$inline_line=' style="border-bottom-color:'.$atts['line_color'].';"';
		}
		else
		{
			$inline_line='';
		}
		$out='';
		$out.='<div class="prk_shortcode-title'.$main_classes.'">';
		if ($atts['fount_show_line']=="above thin" || $atts['fount_show_line']=="above thick" || $atts['fount_show_line']=="above thicker")
		{
			$out.='<div class="simple_line colored '.$atts['fount_show_line'].' columns small-2 medium-1 small-centered forced_mobile"'.$inline_line.'></div>';
		}
		if ($inline!="")
		{
			$out.='<div class="'.$classes.' zero_color prk_vc_title" style="'.$inline.'"><'.$h_tag.'>' . $content . '</'.$h_tag.'></div>';
		}
		else
		{
			$out.='<div class="'.$classes.' zero_color prk_vc_title"><'.$h_tag.'>' . $content . '</'.$h_tag.'></div>';
		}
		if ($atts['fount_show_line']=="thin" || $atts['fount_show_line']=="thick" || $atts['fount_show_line']=="thicker")
		{
			$out.='<div class="simple_line colored '.$atts['fount_show_line'].' columns small-2 medium-1 small-centered forced_mobile"'.$inline_line.'></div>';
		}
		$out.='<div class="clearfix"></div></div>';
		return do_shortcode($out);

	}
	add_shortcode('prk_styled_title', 'pirenko_sh_styled_title');

	//TEXT ROTATOR
	function pirenko_sh_prk_text_rotator( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'type' => '',
			'align' =>'',
			'effect' =>'',
		), $atts));
		$main_classes="";
		$inline="";
		if (isset($atts['text_color'])) { 
			if ($atts['text_color']=="") 
			{
				$main_classes.=" bd_headings_text_shadow";
			}
			else 
			{
				$splitted_shadow=html2rgb($atts['text_color'],"1");
				$inline="color:".$atts['text_color'].";";
				$inline.="text-shadow:0px 0px 1px rgba(".$splitted_shadow[0].", ".$splitted_shadow[1].", ".$splitted_shadow[2].",0.2);";
			}
		}
		/*if (isset($atts['align'])) {
			if (strtolower($atts['align'])=="left")
			{
				$main_classes.=" fount_lefted_text";
			}
			if (strtolower($atts['align'])=="center")
			{
				$main_classes.=" fount_centered_text";
			}
			if (strtolower($atts['align'])=="right")
			{
				$main_classes.=" fount_righted_text";
			}
		}
		else {
			$main_classes.=" fount_centered_text";
		}*/
		$h_tag="h1";
		if (isset($atts['title_size']) && $atts['title_size']!="")
			$h_tag=$atts['title_size'];
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
			$main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		if (isset($atts['el_class']) && $atts['el_class']!="")
			$main_classes.=" ".$atts['el_class'];
		$main_classes.=" ".$h_tag.'_sized';
		$out='';
		if ($content!="") {
			if ($inline!="")
				$out.='<div class="prk_text_rotator'.$main_classes.'" style="'.$inline.'">';
			else 
				$out.='<div class="prk_text_rotator'.$main_classes.'">';
			if (isset($effect) && $effect!="") {
				$effect_in=$effect;
			}
			else {
				$effect_in="old_timey";
			}
			$out.='<div class="cd-headline '.$effect_in.'">';
			$out.='<span></span>';
			$out.='<span class="cd-words-wrapper">';
			$words_array=explode('+', $content);
			if ($words_array && count($words_array)>0) {
				$i=0;
				foreach ($words_array as $word) {
					if ($i==0)
						$out.='<b class="is-visible">'.$word.'</b>';
					else
						$out.='<b>'.$word.'</b>';
					$i++;
				}
			}
			$out.='</span>';
			$out.='</div>';
			$out.='</div>';
		}
		/*$out.='<div class="prk_shortcode-title'.$main_classes.'">';
		if ($inline!="")
		{
			$out.='<div class="'.$classes.' zero_color prk_vc_title" style="'.$inline.'"><'.$h_tag.'>' . $content . '</'.$h_tag.'></div>';
		}
		else
		{
			$out.='<div class="'.$classes.' zero_color prk_vc_title"><'.$h_tag.'>' . $content . '</'.$h_tag.'></div>';
		}
		$out.='<div class="clearfix"></div></div>';*/
		return do_shortcode($out);

	}
	add_shortcode('prk_text_rotator', 'pirenko_sh_prk_text_rotator');

	//COUNTDOWN
	function pirenko_sh_prk_countdown( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'text_color' => '',
			'year' => '',
			'month' => '',
			'day' => '',
			'hour' => '',
			'minute' => '',
			'css_animation' => '',
			'el_class' => ''
		), $atts));
		$main_classes="";
		$inline="";
		if (isset($atts['text_color'])) { 
			if ($atts['text_color']!="") {
				//$splitted_shadow=html2rgb($atts['text_color'],"1");
				$inline=' style="color:'.$atts['text_color'].';"';
				//$inline.="text-shadow:0px 0px 1px rgba(".$splitted_shadow[0].", ".$splitted_shadow[1].", ".$splitted_shadow[2].",0.2);";
			}
		}
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
			$main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		if (isset($atts['el_class']) && $atts['el_class']!="")
			$main_classes.=" ".$atts['el_class'];
		$out='<div class="fount_countdown'.$main_classes.'" data-year="'.$atts['year'].'" data-month="'.$atts['month'].'" data-day="'.$atts['day'].'" data-hour="'.$atts['hour'].'" data-minute="'.$atts['minute'].'"'.$inline.'></div>';
		return do_shortcode($out);

	}
	add_shortcode('prk_countdown', 'pirenko_sh_prk_countdown');

	//SLIDERS
	function pirenko_sh_slider( $atts, $content = null ) 
	{
		extract(shortcode_atts(array(
			'category'  => '',
			'autoplay'	=> '',
			'delay'	=> '',
			'sl_size' => '',
			'hover' => '',
			'f_color' => '',
			'navigation' => '',
			'pagination' => '',
			'parallax_effect' => ''
		), $atts));
		global $prk_fount_options;
		wp_reset_query();
		if ($category=="show_all")
			$category="";
		$args=array(	'post_type' => 'pirenko_slides',
						'showposts' => 99,
						'pirenko_slide_set' => $category
					);
		$loop = new WP_Query( $args );
		$out = '';
		$slide_number=0;
		if (!isset($autoplay) || $autoplay=="" || $autoplay=="yes" || $autoplay=="true")
			$autoplay="true";
		else
			$autoplay="false";
		if (isset($pagination) && $pagination=="false")
			$pagination="false";
		else
			$pagination="true";
		if (isset($navigation) && $navigation=="false")
			$navigation="false";
		else
			$navigation="true";
		if (!isset($delay) || $delay=="")
			$delay="5500";
		if (!isset($sl_size) || $sl_size=="")
			$sl_size="";
		if (!isset($f_color) || $f_color=="")
			$f_color=$prk_fount_options['active_color'];
		$pirenko_sh_slide_button_color=$prk_fount_options['active_color'];
		$touch_enable="false";
		if (isset($prk_fount_options['touch_enable']) && $prk_fount_options['touch_enable']=="1") {
			$touch_enable="true";
		}
		$id="prk_slider_". rand(1, 1000);
		$out.='<div id="'.$id.'" class="per_init owl-carousel fount_shortcode_slider '.$sl_size.'"  data-autoplay="'.$autoplay.'" data-navigation="'.$navigation.'" data-pagination="'.$pagination.'" data-delay="'.$delay.'" data-hover="'.$hover.'" data-color="'.$f_color.'" data-touch='.$touch_enable.'>';
				while ( $loop->have_posts() ) : $loop->the_post();
                $use_txt = 1;
                if (get_field('hide_slide_text')=="1")
                	$use_txt = 0;
                $limit_width = true;
                if (get_field('limit_text_width')!="1")
                	$limit_width = false;
                if (get_field('slide_text_size')!="")
                	$text_size = get_field('slide_text_size');
                else
                	$text_size="medium";
            	if (get_field('slide_text_horz'))
                	$h_align = get_field('slide_text_horz');
               	else
               		$h_align="left";
            	if (get_field('slide_text_vert'))
                	$v_align = get_field('slide_text_vert');
                else
                	$v_align="top";
                if (get_field('pirenko_sh_slide_button_color'))
                {
                	$pirenko_sh_slide_button_color=get_field('pirenko_sh_slide_button_color');
				}
                $pirenko_sh_slide_header_color="";
                $inline="";
                if (get_field('pirenko_sh_slide_header_color'))
                {
					$pirenko_sh_slide_header_color=get_field('pirenko_sh_slide_header_color');
					$splitted_shadow=html2rgb(get_field('pirenko_sh_slide_header_color'),'1');
					$inline="text-shadow:0px 0px 1px rgba(".$splitted_shadow[0].", ".$splitted_shadow[1].", ".$splitted_shadow[2].",0.2);";
				}
				$pirenko_sh_slide_header_bk_color="";
                if (get_field('pirenko_sh_slide_header_bk_color')!="")
                {
					$pirenko_sh_slide_header_bk_color=html2rgba(get_field('pirenko_sh_slide_header_bk_color'),get_field('title_background_color_opacity'));
				}
				else
				{
					$text_size.=" fount_noback";
				}
				$pirenko_sh_slide_body_color="";
                if (get_field('pirenko_sh_slide_body_color'))
					$pirenko_sh_slide_body_color=get_field('pirenko_sh_slide_body_color');
				$pirenko_sh_slide_body_bk_color="";
                if (get_field('pirenko_sh_slide_body_bk_color'))
					$pirenko_sh_slide_body_bk_color=html2rgba(get_field('pirenko_sh_slide_body_bk_color'),get_field('body_background_color_opacity'));
				
				$pos_class="sld_".$h_align." "."sld_".$v_align;

				if (has_post_thumbnail(get_the_ID())) 
				{
					$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'single-post-thumbnail');
					$vt_image = vt_resize( '', $image[0] , 0, 0, true );
				}
				else 
				{
					$image[0]="";
				}
				$parallaxy="";
				if ($parallax_effect=="owl_parallaxed" && $image[0]!="")
				{
					$parallaxy=' data-0-top-top="background-position: 50% 0px;" data-0-top-bottom="background-position: 50% 200%;" style="background-image: url('.$image[0].');"';
				}
				$out.='<div id="fount_slide_'.$slide_number.'" class="item '.$text_size.'"'.$parallaxy.'>';
				if (get_field('pirenko_sh_slide_url')!="" && get_field('pirenko_sh_slide_show_button')=="")
				{
					$out.='<a href="'.get_field('pirenko_sh_slide_url') .'" target="'.get_field('pirenko_sh_slide_wdw').'" class="fade_anchor">';
				}
				if (get_the_title()=="" || $use_txt==0)
				{
					$sl_title="&nbsp;";
					$title_class="inv_el";
				}
				else
				{
					if (get_field('pirenko_rotating_text')!="")
					{
						if (get_field('pirenko_rotating_effect')!="") {
							$effect=get_field('pirenko_rotating_effect');
						}
						else {
							$effect="old_timey";
						}
						$sl_title='<div class="cd-headline '.$effect.'">';
						$sl_title.='<span></span>';
						$sl_title.='<span class="cd-words-wrapper">';
						$sl_title.='<b class="is-visible">'.get_the_title().'</b>';
						$words_array=explode('+', get_field('pirenko_rotating_text'));
						if ($words_array && count($words_array)>0) {
							foreach ($words_array as $word) {
								$sl_title.='<b>'.$word.'</b>';
							}
						}
						$sl_title.='</span>';
						$sl_title.='</div>';
					}
					else {
						$sl_title=get_the_title();
					}
					
					$title_class="";
				}
				if (get_field('title_css')!="")
				{
					$extra_title_class=' '.get_field('title_css');
				}
				else
				{
					$extra_title_class="";
				}
				if (get_the_content()=="" || $use_txt==0)
				{
					$sl_body="&nbsp;";
					$body_class="inv_el";
				}
				else
				{
					$sl_body=get_the_content();
					$body_class="";
				}
				
				if (get_field('pirenko_sh_video')=="")
				{
					if ($use_txt==1)
					{
						
						$out.='<div class="slider_text_holder header_font '.$pos_class.'">';
						if ($limit_width==true)
							$out.='<div class="small-12 prk_inner_block columns small-centered">';
						$out.='<div id="'.$id.'top_'.$slide_number.'" class="prk_heavier_600 left_floated headings_top '.$title_class.'" style="color:'.$pirenko_sh_slide_header_color.';'.$inline.'">';
						$out.='<div class="prk_colored_slider'.$extra_title_class.'" style="background-color:'.$pirenko_sh_slide_header_bk_color.'">';
						$out.=''. $sl_title .'';
						$out.='<div class="clearfix"></div>';
						$out.='</div>';
						$out.='</div>';
						$out.='<div class="clearfix"></div>';
						$out.='<div id="'.$id.'body_'. $slide_number .'" class="prk_heavier_500 headings_body '.$body_class.'" style="color:'. $pirenko_sh_slide_body_color.';background-color:'.$pirenko_sh_slide_body_bk_color.';">';
						$out.='<div>';
						$out.=do_shortcode($sl_body);
						$out.='<div class="clearfix"></div>';
						$out.='</div>';
						$out.='</div>';
						$out.='<div class="clearfix"></div>';
						if (get_field('pirenko_sh_slide_url')!="" && get_field('pirenko_sh_slide_show_button')=="1")
                        {   
                            $out.='<div id="'.$id.'slidebtn_'.$slide_number.'" class="slider_action_button theme_button small '.$text_size.'">';
                                $out.='<a href="'.get_field('pirenko_sh_slide_url').'" target="'.get_field('pirenko_sh_slide_wdw').'" class="fade_anchor" data-color="'.$pirenko_sh_slide_button_color.'">';
                                    $out.=get_field('pirenko_sh_slide_button_label');
                                $out.='</a>';
                            $out.='</div>';
                        }
                        if ($limit_width==true)
							$out.='</div>';
						$out.='</div>';
					}
					$out.='<img class="lazyOwl fount_vsbl" src="#" data-src="'. $image[0] .'" alt="" width="'.$vt_image['width'].'" height="'.$vt_image['height'].'" data-or_w="'.$vt_image['width'].'" data-or_h="'.$vt_image['height'].'" />';
				}
				else
				{
					if ($use_txt==1)
					{
						//IT's A VIDEO SLIDE
						$out.='<div class="slider_text_holder '. $pos_class .'">';
						if ($limit_width==true)
							$out.='<div class="small-12 prk_inner_block columns small-centered">';
						$out.='<div id="'.$id.'top_'. $slide_number .'" class="prk_heavier_600 left_floated headings_top '.$title_class.'" style="color:'. $pirenko_sh_slide_header_color .';">';
						$out.='<span class="prk_colored_slider" style="background-color:'.$pirenko_sh_slide_header_bk_color.'">';
						$out.=''. $sl_title .'';
						$out.='<div class="clearfix"></div>';
						$out.='</span>';
						$out.='</div>';
						$out.='<div class="clearfix"></div>';
						$out.='<div id="'.$id.'body_'. $slide_number .'" class="prk_heavier_500 headings_body '.$body_class.'" style="color:'. $pirenko_sh_slide_body_color.';background-color:'.$pirenko_sh_slide_body_bk_color.';">';
						$out.='<span>';
						$out.=''. $sl_body .'';
						$out.='<div class="clearfix"></div>';
						$out.='</span>';
						$out.='</div>';
						$out.='<div class="clearfix"></div>';
						if (get_field('pirenko_sh_slide_url')!="" && get_field('pirenko_sh_slide_show_button')=="1")
                        {   
                            $out.='<div id="'.$id.'slidebtn_'.$slide_number.'" class="slider_action_button theme_button '.$text_size.'">';
                                $out.='<a href="'.get_field('pirenko_sh_slide_url').'" target="'.get_field('pirenko_sh_slide_wdw').'" class="fade_anchor" data-color="'.$pirenko_sh_slide_button_color.'">';
                                    $out.=get_field('pirenko_sh_slide_button_label');
                                $out.='</a>';
                            $out.='</div>';
                        }
                        if ($limit_width==true)
							$out.='</div>';
						$out.='</div>';
					}
					$out.=get_field('pirenko_sh_video');
				}
				if (get_field('pirenko_sh_slide_url')!="" && get_field('pirenko_sh_slide_show_button')=="")
				   $out.='</a>';
				if (get_field('pirenko_scroll_button')=="1")
				{
					if (get_field('pirenko_scroll_button_link')=="")
						$linker="#";
					else
						$linker=get_field('pirenko_scroll_button_link');
					if (get_field('pirenko_scroll_button_label')=="")
						$labeler="Default";
					else
						$labeler=get_field('pirenko_scroll_button_label');
					if (get_field('pirenko_scroll_button_color')=="")
						$colorer="default";
					else
						$colorer=get_field('pirenko_scroll_button_color');
					$out.='<div class="slider_scroll_button">';
					$out.='<div class="theme_button">';
					$out.='<a href="'.$linker.'" class="regular_anchor_menu" data-color="'.$colorer.'">';
					$out.=$labeler;
					$out.='</a>';
					$out.='<div class="clearfix"></div>';
					$inline_arrow="";
	                if (get_field('pirenko_scroll_button_arrow_color'))
	                {
						$inline_arrow=' style="color:'.get_field('pirenko_scroll_button_arrow_color').'"';
					}
					$out.='<i class="fount_fa-chevron-down"'.$inline_arrow.'></i>';
					$out.='</div>';
					$out.='</div>';
				}
				$out.='</div>';
				$slide_number++;
			endwhile;
	 	$out.='</div>';
		wp_reset_query();
	  	return $out;
	}
	add_shortcode('prk_slider', 'pirenko_sh_slider');	
	if (function_exists('WC')) {
		//WOO FEATURED PORDUCTS
		function prk_woo_featured_shortcode( $atts, $content = null ) {
			global $prk_translations;
			global $prk_fount_options;
			global $prk_retina_device;
			$retina_flag = $prk_retina_device === "prk_retina" ? true : false;
			extract(shortcode_atts(array(
				'category'    	=> '',
				'columns'		=>'columns',
			), $atts));
			if (isset($atts['items_number']) && $atts['items_number']!="")
				$items_number=$atts['items_number'];
			else
				$items_number=12;
			//DEFAULT VALUES
			$columns=4;
			$fluid="small-3 columns";
		    if ($atts['columns']==2) {
		      $fluid="small-6 columns";
		      $columns=$atts['columns'];
		  	}
		    if ($atts['columns']==3){
		      $fluid="small-4 columns";
		      $columns=$atts['columns'];
		  	}
		    if ($atts['columns']==4){
		      $fluid="small-3 columns";
		      $columns=$atts['columns'];
		  	}
		    if ($atts['columns']==6){
		      $fluid="small-2 columns";
		      $columns=$atts['columns'];
		  	}
		  	if (isset($atts['css_animation']) && $atts['css_animation']!="")
				$fluid.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
			if (isset($atts['el_class']) && $atts['el_class']!="")
				$fluid.=" ".$atts['el_class'];
			$out = '';
			$i=0;
			if (isset($atts['general_style']) && $atts['general_style']!="")
				$general_style=$atts['general_style'];
			else
				$general_style='classic';
			if (isset($atts['content_amount']) && $atts['content_amount']!="")
				$content_amount=$atts['content_amount'];
			else
				$content_amount='compressed';
			if (isset($atts['icons_position']) && $atts['icons_position']!="")
				$icons_position=$atts['icons_position'];
			else
				$icons_position='under';
			$args = array(
	            'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'posts_per_page' => $items_number,
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array( 'catalog', 'visible' ),
						'compare' => 'IN'
					),
				),
	        );
			if ($atts['order_by']=="best_sellers") {
				$args = array(
		            'post_type' => 'product',
					'post_status' => 'publish',
					'ignore_sticky_posts'   => 1,
					'meta_key' => 'total_sales',
					'orderby' => 'meta_value_num',
					'posts_per_page' => $items_number,
					'meta_query' => array(
						array(
							'key' => '_visibility',
							'value' => array( 'catalog', 'visible' ),
							'compare' => 'IN'
						),
					),
		        );
			}
			if ($atts['order_by']=="sale_only") {
				$product_ids_on_sale = woocommerce_get_product_ids_on_sale();
				$args = array(
		            'post_type' => 'product',
					'post_status' => 'publish',
					'ignore_sticky_posts'   => 1,
					'meta_key' => 'total_sales',
					'orderby' => 'meta_value_num',
					'posts_per_page' => $items_number,
					'post__in'		=> $product_ids_on_sale,
					'meta_query' => array(
						array(
							'key' => '_visibility',
							'value' => array( 'catalog', 'visible' ),
							'compare' => 'IN'
						),
					),
		        );
			}
			if ($atts['order_by']=="rating") {
	        	add_filter('posts_clauses', array( WC()->query,'order_by_rating_post_clauses'));
	        }
	        $products = new WP_Query( $args );
	        remove_filter('posts_clauses', array( WC()->query,'order_by_rating_post_clauses'));
	        if ( $products->have_posts() ) {
				if ($general_style=='classic')
				{
					$out.='<div class="row prk_row woocommerce fount_woo_grider">';
					$out.='<ul class="products">';
						$i=0;
						while ( $products->have_posts() ) : $products->the_post();
								$out.='<li class="'.$fluid.'">';
								$out.='<ul>';
		                    	ob_start();
		                    	woocommerce_get_template_part( 'content', 'product' );
		                    	$out.= ob_get_clean();
		                    	$out.='</ul>';
		                    	$out.='</li>';
		                    	$i++;
								if ($i%$columns==0)
								{
									$out.='<li class="columns small-12 clearfix bt_40"></li>';
								}
		                endwhile;
				 	$out.='</ul></div>';
				}
				else 
				{
					$out.='<div class="row prk_row woocommerce fount_woo_grider">';
					$touch_enable="false";
					if (isset($prk_fount_options['touch_enable']) && $prk_fount_options['touch_enable']=="1") {
						$touch_enable="true";
					}
					$out.='<ul class="products_ul_slider products" data-navigation="true" data-touch='.$touch_enable.'>';
						while ( $products->have_posts() ) : $products->the_post();							
							$out.='<div class="item fount_woo_slide">';
								ob_start();
		                    	woocommerce_get_template_part( 'content', 'product' );
		                    	$out.= ob_get_clean();
							$out.='</div>';
							$i++;
						endwhile;
				 	$out.='</ul></div>';
				}
			}
			wp_reset_query();
		  	return $out;
		}
		add_shortcode('prk_woo_featured', 'prk_woo_featured_shortcode');

		//WOO WIDGET PORDUCTS
		function prk_woo_widget_shortcode( $atts, $content = null ) {
			global $prk_translations;
			global $prk_fount_options;
			global $prk_retina_device;
			$retina_flag = $prk_retina_device === "prk_retina" ? true : false;
			extract(shortcode_atts(array(
				'category'    	=> '',
				'columns'		=>'columns',
			), $atts));
			if (isset($atts['items_number']) && $atts['items_number']!="")
				$items_number=$atts['items_number'];
			else
				$items_number=12;
			//DEFAULT VALUES
			$columns=1;
			$fluid="small-12 columns";
		  	if (isset($atts['css_animation']) && $atts['css_animation']!="")
				$fluid.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
			if (isset($atts['el_class']) && $atts['el_class']!="")
				$fluid.=" ".$atts['el_class'];
			$out='';
			$i=0;
			if (isset($atts['content_amount']) && $atts['content_amount']!="")
				$content_amount=$atts['content_amount'];
			else
				$content_amount='compressed';
			if (isset($atts['icons_position']) && $atts['icons_position']!="")
				$icons_position=$atts['icons_position'];
			else
				$icons_position='under';
			$args = array(
	            'post_type' => 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'   => 1,
				'posts_per_page' => $items_number,
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array( 'catalog', 'visible' ),
						'compare' => 'IN'
					),
				),
	        );
			if ($atts['order_by']=="best_sellers") {
				$args = array(
		            'post_type' => 'product',
					'post_status' => 'publish',
					'ignore_sticky_posts'   => 1,
					'meta_key' => 'total_sales',
					'orderby' => 'meta_value_num',
					'posts_per_page' => $items_number,
					'meta_query' => array(
						array(
							'key' => '_visibility',
							'value' => array( 'catalog', 'visible' ),
							'compare' => 'IN'
						),
					),
		        );
			}
			if ($atts['order_by']=="sale_only") {
				$product_ids_on_sale = woocommerce_get_product_ids_on_sale();
				$args = array(
		            'post_type' => 'product',
					'post_status' => 'publish',
					'ignore_sticky_posts'   => 1,
					'meta_key' => 'total_sales',
					'orderby' => 'meta_value_num',
					'posts_per_page' => $items_number,
					'post__in'		=> $product_ids_on_sale,
					'meta_query' => array(
						array(
							'key' => '_visibility',
							'value' => array( 'catalog', 'visible' ),
							'compare' => 'IN'
						),
					),
		        );
			}
			$extra_class="";
			if ($atts['order_by']=="rating") {
	        	add_filter('posts_clauses', array( WC()->query,'order_by_rating_post_clauses'));
	        	$extra_class=" by_rating";
	        }
	        $products = new WP_Query( $args );
	        remove_filter('posts_clauses', array( WC()->query,'order_by_rating_post_clauses'));
	        if ( $products->have_posts() ) {
				$out.='<div class="row prk_row woocommerce fount_woo_grider fount_woo_widget'.$extra_class.'">';
				$out.='<ul class="products">';
					while ( $products->have_posts() ) : $products->the_post();
						$out.='<li class="'.$fluid.'">';
						$out.='<ul class="fount_woo_el_wrapper">';
	                	ob_start();
	                	woocommerce_get_template_part( 'content', 'product' );
	                	$out.= ob_get_clean();
	                	$out.='</ul>';
	                	$out.='</li>';
	                endwhile;
			 	$out.='</ul></div>';
			}
			wp_reset_query();
		  	return $out;
		}
		add_shortcode('prk_woo_widget', 'prk_woo_widget_shortcode');
	}

	//TEAM MEMBER
	function prk_member_shortcode( $atts, $content = null ) 
	{
		global $prk_translations;
		global $prk_fount_options;
		global $prk_retina_device;
		$retina_flag = $prk_retina_device === "prk_retina" ? true : false;
		extract(shortcode_atts(array(
			'category'    	=> '',
			'columns'		=>'columns',
		), $atts));
		if ($category=="show_all")
			$category="";
		if (isset($atts['items_number']) && $atts['items_number']!="")
			$items_number=$atts['items_number'];
		else
			$items_number=999;
		//DEFAULT VALUES
		if (!isset($atts['columns']) || (isset($atts['columns']) && $atts['columns']=="")) {
			$atts['columns']=3;
		}
	    if ($atts['columns']==2) {
	      $fluid="small-6 columns";
	      $columns=$atts['columns'];
	  	}
	    if ($atts['columns']==3){
	      $fluid="small-4 columns";
	      $columns=$atts['columns'];
	  	}
	    if ($atts['columns']==4){
	      $fluid="small-3 columns";
	      $columns=$atts['columns'];
	  	}
	    if ($atts['columns']==6){
	      $fluid="small-2 columns";
	      $columns=$atts['columns'];
	  	}
	  	$forced_w=ceil($prk_fount_options['custom_width']/$atts['columns']);
	  	if ($forced_w<780);
	  		$forced_w=780;
	  	if (isset($atts['css_animation']) && $atts['css_animation']!="")
			$fluid.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		if (isset($atts['el_class']) && $atts['el_class']!="")
			$fluid.=" ".$atts['el_class'];

		$args=array(	'post_type' => 'pirenko_team_member',
			'showposts' => $items_number,
			'order_by' => 'menu_order',
			'pirenko_member_group' => $category
		);
		$loop = new WP_Query( $args );
		$out = '';
		$i=0;
		if (isset($atts['general_style']) && $atts['general_style']!="")
			$general_style=$atts['general_style'];
		else
			$general_style='classic';
		if (isset($atts['text_align']) && $atts['text_align']!="")
			$main_css=' '.$atts['text_align'];
		else
			$main_css=' text_center';
		if (isset($atts['content_amount']) && $atts['content_amount']!="")
			$content_amount=$atts['content_amount'];
		else
			$content_amount='compressed';
		if (isset($atts['icons_position']) && $atts['icons_position']!="")
			$icons_position=$atts['icons_position'];
		else
			$icons_position='under';
		if ($general_style=='classic')
		{
			$out.='<div class="row prk_row'.$main_css.'">';
			$out.='<ul class="member_ul">';
				while ( $loop->have_posts() ) : $loop->the_post();
					if (get_field('member_job')!="")
						$member_job = get_field('member_job');
					else
						$member_job="";
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
						if (has_post_thumbnail( get_the_ID() ) ):
							//GET THE FEATURED IMAGE
								//$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
								$vt_image = vt_resize( get_post_thumbnail_id( get_the_ID()), '' ,$forced_w ,0 , false , $retina_flag );
								else :
									//THERE'S NO FEATURED IMAGE SO LET'S LOAD A DEFAULT IMAGE
									$container="".get_bloginfo('template_directory')."/images/sample/user.jpg";
									$image[0]=get_image_path($container);
								endif; 
								
								$out.='<li class="'.$fluid.' sh_member_wrapper" data-color="'.$featured_color.'">';
									if (get_field('show_member_link')=="1")
									{
										$out.='<a href="'.get_permalink().'" class="sh_member_link fade_anchor">';
										$out.='<div class="member_colored_block">';
									}
									else
									{
										$out.='<div class="member_colored_block no_link">';
									}
										
									$out.='<div class="member_colored_block_in">';
	                                $out.='<div class="fount_fa-plus sh_member_link_icon body_bk_color"></div>';
									$out.='</div>';
									$out.='<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="" class="mb_in_img" />';
									if ($icons_position=="inside")
									{
										$out.='<div class="fount_member_links zero_color">';
										if (get_field('member_email')!="")
										{
										$out.='<div class="member_lnk">';
											$out.='<a href="mailto:'.antispambot(get_field('member_email')).'">';
												$out.= '<div class="fount_socialink prk_bordered fount_fa-envelope-o">';
													$out.='<div class="bg_shifter"><i class="fount_fa-envelope-o"></i></div>';
		                                        $out.='</div>';
											$out.=' </a>';
										$out.='</div>';
										}
										if (get_field('member_social_1')!="none" && get_field('member_social_1')!="")
		                                {
		                                    if (get_field('member_social_1_link')!="")
		                                        $in_link=get_field('member_social_1_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_1')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_1')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_1')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
		                                if (get_field('member_social_2')!="none" && get_field('member_social_2')!="")
		                                {
		                                    if (get_field('member_social_2_link')!="")
		                                        $in_link=get_field('member_social_2_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_2')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_2')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_2')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
		                                if (get_field('member_social_3')!="none" && get_field('member_social_3')!="")
		                                {
		                                    if (get_field('member_social_3_link')!="")
		                                        $in_link=get_field('member_social_3_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_3')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_3')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_3')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
		                                if (get_field('member_social_4')!="none" && get_field('member_social_4')!="")
		                                {
		                                    if (get_field('member_social_4_link')!="")
		                                        $in_link=get_field('member_social_4_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_4')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_4')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_4')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
		                                if (get_field('member_social_5')!="none" && get_field('member_social_5')!="")
		                                {
		                                    if (get_field('member_social_5_link')!="")
		                                        $in_link=get_field('member_social_5_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_5')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_5')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_5')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
		                                if (get_field('member_social_6')!="none" && get_field('member_social_6')!="")
		                                {
		                                    if (get_field('member_social_6_link')!="")
		                                        $in_link=get_field('member_social_6_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_6')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_6')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_6')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
										$out.='</div>';
									}
									$out.='</div>';
									if (get_field('show_member_link')=="1")
									{
										$out.=' </a>';
									}
									$out.='<div class="sh_member_name zero_color header_font bd_headings_text_shadow">';
									if (get_field('show_member_link')=="1")
									{
										$out.='<a href="'.get_permalink().'" class="fade_anchor">';
											$out.=get_the_title();
										$out.=' </a>';
									}
									else
									{
										$out.=get_the_title();
									}
									$out.='</div>';
									$out.='<div class="clearfix"></div>';
									$out.='<div class="sh_member_function small_headings_color prk_heavier_600">';
									$out.=$member_job;
									$out.='</div>';
									$out.='<div class="clearfix"></div>';
									$out.='<div class="simple_line membered"></div>';
									$out.='<div class="sh_member_desc default_color wpb_text_column">';
									if ($content_amount=="compressed")
										$out.=the_excerpt_dynamic(24,$loop->post->ID);
									else {
										if (!has_shortcode(get_the_content(),'vc_row')) {
											$out.=do_shortcode(get_the_content());
										}
										else {
											$out.='<div class="sh_member_desc_inner">'.do_shortcode(get_the_content()).'</div>';
										}
									}
									$out.='</div>';
									$out.='<div class="clearfix"></div>';
									if (get_field('show_member_link')=="1")
									{
										$out.='<div class="theme_button_inverted small fade_anchor">';
										$out.='<a href="'.get_permalink().'" class="fount_profile_link with_icon">';
											$out.='<div class="text_shifter">'.esc_attr($prk_translations["profile_text"]).'</div>';
											$out.='<div class="icon_cell"><i class="fount_fa-chevron-right"></i></div>';
										$out.=' </a>';
										$out.='</div>';
										$out.='<div class="clearfix"></div>';
									}
									else if ($icons_position=="under")
									{
										$out.='<div class="fount_member_links zero_color">';
										if (get_field('member_email')!="")
										{
										$out.='<div class="member_lnk">';
											$out.='<a href="mailto:'.antispambot(get_field('member_email')).'">';
												$out.= '<div class="fount_socialink prk_bordered fount_fa-envelope-o">';
													$out.='<div class="bg_shifter"><i class="fount_fa-envelope-o"></i></div>';
	                                            $out.='</div>';
											$out.=' </a>';
										$out.='</div>';
										}
										if (get_field('member_social_1')!="none" && get_field('member_social_1')!="")
		                                {
		                                    if (get_field('member_social_1_link')!="")
		                                        $in_link=get_field('member_social_1_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_1')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_1')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_1')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
		                                if (get_field('member_social_2')!="none" && get_field('member_social_2')!="")
		                                {
		                                    if (get_field('member_social_2_link')!="")
		                                        $in_link=get_field('member_social_2_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_2')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_2')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_2')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
		                                if (get_field('member_social_3')!="none" && get_field('member_social_3')!="")
		                                {
		                                    if (get_field('member_social_3_link')!="")
		                                        $in_link=get_field('member_social_3_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_3')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_3')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_3')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
		                                if (get_field('member_social_4')!="none" && get_field('member_social_4')!="")
		                                {
		                                    if (get_field('member_social_4_link')!="")
		                                        $in_link=get_field('member_social_4_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_4')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_4')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_4')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
		                                if (get_field('member_social_5')!="none" && get_field('member_social_5')!="")
		                                {
		                                    if (get_field('member_social_5_link')!="")
		                                        $in_link=get_field('member_social_5_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_5')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_5')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_5')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
		                                if (get_field('member_social_6')!="none" && get_field('member_social_6')!="")
		                                {
		                                    if (get_field('member_social_6_link')!="")
		                                        $in_link=get_field('member_social_6_link');
		                                    else
		                                        $in_link="";            
		                                    $out.='<div class="member_lnk">';
		                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_6')).'">';
		                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_6')).'">';
		                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_6')).'"></i></div>';
		                                            $out.='</div>';
		                                        $out.='</a>';
		                                    $out.='</div>';
		                                }
										$out.='</div>';
										$out.='<div class="clearfix"></div>';
									}
								$out.='</li>';
								$i++;
								if ($i%$atts['columns']==0)
								{
									$out.='<li class="clearfix"></li>';
								}
				endwhile;
		 	$out.='</ul></div>';
		}
		else 
		{
			$out.='<div class="row prk_row'.$main_css.'">';
			$touch_enable="false";
			if (isset($prk_fount_options['touch_enable']) && $prk_fount_options['touch_enable']=="1") {
				$touch_enable="true";
			}
			$out.='<div class="member_ul_slider" data-navigation="true" data-touch='.$touch_enable.'>';
				while ( $loop->have_posts() ) : $loop->the_post();
					if (get_field('member_job')!="")
						$member_job = get_field('member_job');
					else
						$member_job="";
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
					if (has_post_thumbnail( get_the_ID() ) ):
						//GET THE FEATURED IMAGE
						//$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
						$vt_image = vt_resize( get_post_thumbnail_id( get_the_ID()), '' ,$forced_w ,0 , false , $retina_flag );
						else :
							//THERE'S NO FEATURED IMAGE SO LET'S LOAD A DEFAULT IMAGE
							$container="".get_bloginfo('template_directory')."/images/sample/user.jpg";
							$image[0]=get_image_path($container);
						endif; 
						
						$out.='<div class="item sh_member_wrapper" data-color="'.$featured_color.'">';
							if (get_field('show_member_link')=="1")
							{
								$out.='<a href="'.get_permalink().'" class="sh_member_link fade_anchor">';
								$out.='<div class="member_colored_block">';
							}
							else
							{
								$out.='<div class="member_colored_block no_link">';
							}
								
							$out.='<div class="member_colored_block_in">';
                            $out.='<div class="fount_fa-plus sh_member_link_icon body_bk_color"></div>';
							$out.='</div>';
							$out.='<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="" class="mb_in_img" />';
							if ($icons_position=="inside")
							{
								$out.='<div class="fount_member_links zero_color">';
								if (get_field('member_email')!="")
								{
								$out.='<div class="member_lnk">';
									$out.='<a href="mailto:'.antispambot(get_field('member_email')).'">';
										$out.= '<div class="fount_socialink prk_bordered fount_fa-envelope-o">';
											$out.='<div class="bg_shifter"><i class="fount_fa-envelope-o"></i></div>';
                                        $out.='</div>';
									$out.=' </a>';
								$out.='</div>';
								}
								if (get_field('member_social_1')!="none" && get_field('member_social_1')!="")
                                {
                                    if (get_field('member_social_1_link')!="")
                                        $in_link=get_field('member_social_1_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_1')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_1')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_1')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
                                if (get_field('member_social_2')!="none" && get_field('member_social_2')!="")
                                {
                                    if (get_field('member_social_2_link')!="")
                                        $in_link=get_field('member_social_2_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_2')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_2')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_2')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
                                if (get_field('member_social_3')!="none" && get_field('member_social_3')!="")
                                {
                                    if (get_field('member_social_3_link')!="")
                                        $in_link=get_field('member_social_3_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_3')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_3')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_3')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
                                if (get_field('member_social_4')!="none" && get_field('member_social_4')!="")
                                {
                                    if (get_field('member_social_4_link')!="")
                                        $in_link=get_field('member_social_4_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_4')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_4')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_4')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
                                if (get_field('member_social_5')!="none" && get_field('member_social_5')!="")
                                {
                                    if (get_field('member_social_5_link')!="")
                                        $in_link=get_field('member_social_5_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_5')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_5')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_5')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
                                if (get_field('member_social_6')!="none" && get_field('member_social_6')!="")
                                {
                                    if (get_field('member_social_6_link')!="")
                                        $in_link=get_field('member_social_6_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_6')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_6')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_6')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
								$out.='</div>';
							}
							$out.='</div>';
							if (get_field('show_member_link')=="1")
							{
								$out.=' </a>';
							}
							$out.='<div class="sh_member_name zero_color header_font bd_headings_text_shadow">';
							if (get_field('show_member_link')=="1")
							{
								$out.='<a href="'.get_permalink().'" class="fade_anchor">';
									$out.=get_the_title();
								$out.=' </a>';
							}
							else
							{
								$out.=get_the_title();
							}
							$out.='</div>';
							$out.='<div class="clearfix"></div>';
							$out.='<div class="sh_member_function small_headings_color prk_heavier_600">';
							$out.=$member_job;
							$out.='</div>';
							$out.='<div class="clearfix"></div>';
							$out.='<div class="simple_line membered"></div>';
							$out.='<div class="sh_member_desc default_color wpb_text_column">';
							if ($content_amount=="compressed")
								$out.=the_excerpt_dynamic(24,$loop->post->ID);
							else {
								if (!has_shortcode(get_the_content(),'vc_row')) {
									$out.=do_shortcode(get_the_content());
								}
								else {
									$out.='<div class="sh_member_desc_inner">'.do_shortcode(get_the_content()).'</div>';
								}
							}
							$out.='</div>';
							$out.='<div class="clearfix"></div>';
							if (get_field('show_member_link')=="1")
							{
								$out.='<div class="theme_button_inverted small fade_anchor">';
								$out.='<a href="'.get_permalink().'" class="fount_profile_link with_icon">';
									$out.='<div class="text_shifter">'.esc_attr($prk_translations["profile_text"]).'</div>';
									$out.='<div class="icon_cell"><i class="fount_fa-chevron-right"></i></div>';
								$out.=' </a>';
								$out.='</div>';
								$out.='<div class="clearfix"></div>';
							}
							else if ($icons_position=="under")
							{
								$out.='<div class="fount_member_links zero_color">';
								if (get_field('member_email')!="")
								{
								$out.='<div class="member_lnk">';
									$out.='<a href="mailto:'.antispambot(get_field('member_email')).'">';
										$out.= '<div class="fount_socialink prk_bordered fount_fa-envelope-o">';
											$out.='<div class="bg_shifter"><i class="fount_fa-envelope-o"></i></div>';
                                        $out.='</div>';
									$out.=' </a>';
								$out.='</div>';
								}
								if (get_field('member_social_1')!="none" && get_field('member_social_1')!="")
                                {
                                    if (get_field('member_social_1_link')!="")
                                        $in_link=get_field('member_social_1_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_1')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_1')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_1')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
                                if (get_field('member_social_2')!="none" && get_field('member_social_2')!="")
                                {
                                    if (get_field('member_social_2_link')!="")
                                        $in_link=get_field('member_social_2_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_2')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_2')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_2')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
                                if (get_field('member_social_3')!="none" && get_field('member_social_3')!="")
                                {
                                    if (get_field('member_social_3_link')!="")
                                        $in_link=get_field('member_social_3_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_3')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_3')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_3')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
                                if (get_field('member_social_4')!="none" && get_field('member_social_4')!="")
                                {
                                    if (get_field('member_social_4_link')!="")
                                        $in_link=get_field('member_social_4_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_4')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_4')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_4')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
                                if (get_field('member_social_5')!="none" && get_field('member_social_5')!="")
                                {
                                    if (get_field('member_social_5_link')!="")
                                        $in_link=get_field('member_social_5_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_5')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_5')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_5')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
                                if (get_field('member_social_6')!="none" && get_field('member_social_6')!="")
                                {
                                    if (get_field('member_social_6_link')!="")
                                        $in_link=get_field('member_social_6_link');
                                    else
                                        $in_link="";            
                                    $out.='<div class="member_lnk">';
                                        $out.='<a href="'.$in_link.'" target="_blank" data-color="'.prk_social_color(get_field('member_social_6')).'">';
                                            $out.='<div class="fount_socialink prk_bordered '.prk_social_icon(get_field('member_social_6')).'">';
                                            	$out.='<div class="bg_shifter"><i class="'.prk_social_icon(get_field('member_social_6')).'"></i></div>';
                                            $out.='</div>';
                                        $out.='</a>';
                                    $out.='</div>';
                                }
								$out.='</div>';
								$out.='<div class="clearfix"></div>';
							}
						$out.='</div>';
						$i++;
				endwhile;
		 	$out.='</div></div>';
		}
		wp_reset_query();
	  	return $out;
	}
	add_shortcode('prk_members', 'prk_member_shortcode');
	
	//PRICING TABLES
	function prk_price_table_shortcode($atts,$content = null) 
	{
		$featured="&nbsp;";
		$extra_class="";
		$header="";
		if (isset($atts['header']))
			$header=$atts['header'];
		$color="";
		if (isset($atts['color']))
			$color=$atts['color'];
		$price="";
		if (isset($atts['price']))
			$price=$atts['price'];
		$button_label="";
		if (isset($atts['button_label']))
			$button_label=$atts['button_label'];
		$button_link="#";
		if (isset($atts['button_link']))
			$button_link=$atts['button_link'];
		if (isset($atts['featured']) && $atts['featured']!="")
		{
			$featured=$atts['featured'];
		}
		$under_price="";
		if (isset($atts['under_price']))
			$under_price=$atts['under_price'];
		$extra_inline="";
		if ($color!="") {
			$extra_inline=' style="background-color:'.$color.';"';
			$extra_class=" featured";
		}
		if (isset($atts['featured_text']) && $atts['featured_text']!="")
		{
			$ribbon='<div class="fount_tables_ribbon"><span class="inner_ribbon">'.$atts['featured_text'].'</span></div>';
		}
		else
		{
			$ribbon='';
		}
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
		{
			$extra_class.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		}
		if (isset($atts['el_class']) && $atts['el_class']!="")
		{
			$extra_class.=" ".$atts['el_class'];
		}

		$output='<div class="prk_price_table'.$extra_class.'">'.$ribbon.'<div class="prk_price_header zero_color"'.$extra_inline.'>';
		$output.='<div class="small_headings_color">'.$featured.'</div><h3 class="header_font big">'.$header.'</h3></div>';
		$output.='<div class="prk_prices_specs"><div class="prk_price not_zero_color">'.$price.'</div><div class="underp zero_color prk_heavier_700">'.$under_price.'</div>'.$content;
		if ($button_label!="")
		$output.='<div class="small-12"'.$extra_inline.'><div class="prk_price_button theme_button small"><a href="'.$button_link.'" class="fade_anchor">'.$button_label.'</a></div></div>';
		$output.='<div class="clearfix"></div></div></div>';

		return $output;
	}
	add_shortcode('prk_price_table', 'prk_price_table_shortcode');
	
	//SITEMAP
	function prk_sitemap_shortcode( $atts, $content = null ) 
	{
		//start building output string
		$output="<div class='prk_sitemap_wrapper fade_anchor'>";
		$txt_pages="Pages";
		if (isset($atts['txt_pages']) && $atts['txt_pages']!="")
			$txt_pages=$atts['txt_pages'];
		$show_pages="yes";
		if (isset($atts['show_pages']) && $atts['show_pages']!="")
			$show_pages=$atts['show_pages'];
		if ($show_pages=="yes")
		{
			$output.="<h4 class='zero_color bd_headings_text_shadow prk_heavier_600'>".$txt_pages."</h4>";
			$output.="<ul class='sitemap_block default_color'>".wp_list_pages('title_li=&echo=0')."</ul>";
		}
		$txt_blog_cats="Blog categories";
		if (isset($atts['txt_blog_cats']) && $atts['txt_blog_cats']!="")
			$txt_blog_cats=$atts['txt_blog_cats'];
		$show_blog_cats="yes";
		if (isset($atts['show_blog_cats']) && $atts['show_blog_cats']!="")
			$show_blog_cats=$atts['show_blog_cats'];
		if ($show_blog_cats=="yes")
		{
			$output.="<h4 class='zero_color bd_headings_text_shadow prk_heavier_600'>".$txt_blog_cats."</h4>";
			$output.="<ul class='sitemap_block default_color'>".wp_list_categories('title_li=&echo=0&sort_column=name&optioncount=1&hierarchical=0')."</ul>";
		}
		$txt_blog_posts="Blog posts";
		if (isset($atts['txt_blog_posts']) && $atts['txt_blog_posts']!="")
			$txt_blog_posts=$atts['txt_blog_posts'];
		$show_posts="yes";
		if (isset($atts['show_posts']) && $atts['show_posts']!="")
			$show_posts=$atts['show_posts'];
		if ($show_posts=="yes")
		{
			global $month, $wpdb, $wp_version;
			$sql = 'SELECT
				DISTINCT YEAR(post_date) AS year,
				MONTH(post_date) AS month,
				count(ID) as posts
			FROM ' . $wpdb->posts . '
			WHERE post_status="publish"
				AND post_type="post"
				AND post_password=""
			GROUP BY YEAR(post_date),
				MONTH(post_date)
			ORDER BY post_date DESC';
			$archiveSummary = $wpdb->get_results($sql);
			if ($archiveSummary) 
			{
				$output.="<h4 class='zero_color bd_headings_text_shadow prk_heavier_600'>".$txt_blog_posts."</h4></div>";
				$output.= "<ul class='sitemap_block default_color'>";
				foreach ($archiveSummary as $date) 
				{
					// reset the query vastroble
					unset ($bmWp);
					$bmWp = new WP_Query('year=' . $date->year . '&monthnum=' . zeroise($date->month, 2) . '&posts_per_page=-1');
					if ($bmWp->have_posts()) 
					{
						$url = get_month_link($date->year, $date->month);
						$text = $month[zeroise($date->month, 2)] . ' ' . $date->year;
						$output.= get_archives_link($url, $text, '', '<li>', '</li>'); 
						$output.= '<ul class="children">';
						while ($bmWp->have_posts()) 
						{
							$bmWp->the_post();
							$output.= '<li><a href="' . get_permalink($bmWp->post) . '" title="' . esc_html($text, 1) . '" class="fade_anchor">' . wptexturize($bmWp->post->post_title) . '</a></li>';
						}
						$output.= '</ul>';			
					}
				}
				$output.= '</ul>';	
			}
		}
		$txt_port_posts="Portfolio";
		if (isset($atts['txt_port_posts']) && $atts['txt_port_posts']!="")
			$txt_port_posts=$atts['txt_port_posts'];
		$show_port_posts="yes";
		if (isset($atts['show_port_posts']) && $atts['show_port_posts']!="")
			$show_port_posts=$atts['show_port_posts'];
		if ($show_port_posts=="yes")
		{
			$output.="<h4 class='zero_color bd_headings_text_shadow prk_heavier_600'>".$txt_port_posts."</h4>";
			$output.= "<ul class='sitemap_block default_color'>";
			$terms = get_terms( 'pirenko_skills', 'orderby=name' );
			foreach ($terms as $term) {
			$output.= "<li><a href='".get_term_link($term->slug, 'pirenko_skills')."' class='fade_anchor'>".$term->name."</a>";
			$output.= "<ul class='children'>";
			$args = array(
				'post_type' => 'pirenko_portfolios',
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
					'taxonomy' => 'pirenko_skills',
					'field' => 'slug',
					'terms' => $term->slug
					)
				)
			);
			$new = new WP_Query($args);
			while ($new->have_posts()) {
			$new->the_post();
			$output.= '<li><a href="'.get_permalink().'" class="fade_anchor">'.get_the_title().'</a></li>';
			}
			$output.= "</ul>";
			$output.= "</li>";
			} 
			$output.= "</ul>";
		}
		$output.="</div>";
		return $output;
	}
	add_shortcode('prk_sitemap', 'prk_sitemap_shortcode');

	//COUNTER
	function prk_counter_shortcode( $atts, $content = null ) 
	{
		$name="";
		if (isset($atts['name']))
			$name=$atts['name'];
		$image="";
		if (isset($atts['image']))
			$image=$atts['image'];
		$link="";
		if (isset($atts['link']))
			$link=$atts['link'];
		$counter_origin=0;
		if (isset($atts['counter_origin']) && is_numeric($atts['counter_origin']))
			$counter_origin=$atts['counter_origin'];
		$counter_number=100;
		if (isset($atts['counter_number']) && is_numeric($atts['counter_number']))
			$counter_number=$atts['counter_number'];
		global $prk_translations;
		$link_text=$prk_translations['read_more'];
		if (isset($atts['link_text']) && $atts['link_text']!="")
			$link_text=$atts['link_text'];
		$align="";
		$extra="";
		if (isset($atts['align']))
			$align.=" ".$atts['align'];
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
		{
			$align.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		}
		if (isset($atts['el_class']) && $atts['el_class']!="")
		{
			$align.=" ".$atts['el_class'];
		}
		global $prk_fount_options;
		$serv_image="";
		if (isset($atts['serv_image']))
			$serv_image=$atts['serv_image'];
		global $prk_retina_device;
		if ($serv_image!="") 
		{
			if ($prk_retina_device=="prk_retina") {
				$path_parts = pathinfo($serv_image);
				$vt_image = vt_resize( '', $path_parts['dirname'] . "/".$path_parts['filename']."_@2X.".$path_parts['extension'] , 2000, 2000, false );
				$half_width=$vt_image['width']/2;
				$half_height=$vt_image['height']/2;
				//CHECK IF RETINA FILE EXISTS
				if ($half_width!=1000) {
					$imager ="<div><img alt='' src='" . $path_parts['dirname'] . "/".$path_parts['filename']."_@2X.".$path_parts['extension']."' width='".$half_width."' height='".$half_height."'/></div>";
				}
				else
				{
					$imager='<div><img alt="" src="'.$serv_image.'" /></div>';
				}
			}
			else
			{
				$imager='<div><img alt="" src="'.$serv_image.'" /></div>';
			}
		}
		else
		{
			$image=str_replace('fa fa', 'fount_fa', $image);
			$imager='<i class="'.$image.' colored_link_icon"></i>';
		}
		$out='<div class="prk_counter_wrapper'.$align.'">';
		$out.=$imager.'<div class="clearfix"></div>';
		$out.='<div id="fount_counter_'. rand(1, 1000) .'" class="header_font fount_counter prk_heavier_600" data-origin="'.$counter_origin.'" data-counter="'.$counter_number.'" data-duration="3800">&nbsp;</div><div class="fount_counter_desc header_font prk_heavier_600">'.$content.'</div></div>';
		return $out;
	}
	add_shortcode('prk_counter', 'prk_counter_shortcode');

	//SERVICES
	function prk_service_shortcode( $atts, $content = null ) 
	{
		$name="";
		if (isset($atts['name']))
			$name=$atts['name'];
		$image="";
		if (isset($atts['image']))
			$image=$atts['image'];
		$image=str_replace('fa fa', 'fount_fa', $image);
		$link="";
		if (isset($atts['link']))
			$link=$atts['link'];
		global $prk_translations;
		$link_text=$prk_translations['read_more'];
		if (isset($atts['link_text']) && $atts['link_text']!="")
			$link_text=$atts['link_text'];
		$align="";
		$extra="";
		if (isset($atts['bk_color']) && $atts['bk_color']!="") {
			$align.=" serv_with_color";
			$extra=' style="background-color:'.$atts['bk_color'].';"';
		}
		$inline_icon=$inline="";
		$default_color="default";
		if (isset($atts['text_color']) && $atts['text_color']!="") {
			$inline_icon=$inline=' style="color:'.$atts['text_color'].'"';
			$default_color=$atts['text_color'];
		}
		else
		{
			if (isset($atts['icon_up_color']) && $atts['icon_up_color']!="") {
				$inline_icon=' style="color:'.$atts['icon_up_color'].'"';
				$default_color=$atts['icon_up_color'];
			}
		}
		if (isset($atts['align']))
			$align.=" ".$atts['align'];
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
		{
			$align.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		}
		if (isset($atts['el_class']) && $atts['el_class']!="")
		{
			$align.=" ".$atts['el_class'];
		}
		if (isset($atts['icon_color']) && $atts['icon_color']!="")
	    {
	        $featured_color=$atts['icon_color'];
	    }
	    else
	    {
	        $featured_color="default";
	    }
		global $prk_fount_options;
		$serv_image="";
		if (isset($atts['serv_image']))
			$serv_image=$atts['serv_image'];
		global $prk_retina_device;
		if ($serv_image!="") 
		{
			$vt_image = vt_resize('',$serv_image,2000,2000,false);
			$imager='<div><img alt="" src="'.$serv_image.'" width="'.$vt_image['width'].'" height="'.$vt_image['height'].'" /></div>';
		}
		else
		{
			$imager='<div class="'.$image.' colored_link_icon small_headings_color"'.$inline_icon.'></div>';
		}
		if ($link=="")		
			return '<div class="prk_service'.$align.'"'.$extra.' data-color="'.$featured_color.'" data-default="'.$default_color.'">'.$imager.'<div class="clearfix"></div><div class="prk_service_ctt"><h4 class="big zero_color bd_headings_text_shadow header_font"'.$inline.'>'.$name.'</h4><div class="clearfix"></div><div class="fount_service_desc wpb_text_column"'.$inline.'>'.$content.'</div></div></div>';
		else
			return '<div class="prk_service'.$align.'"'.$extra.' data-color="'.$featured_color.'" data-default="'.$default_color.'">'.$imager.'<div class="clearfix"></div><div class="prk_service_ctt"><h4 class="big zero_color bd_headings_text_shadow header_font"'.$inline.'>'.$name.'</h4><div class="clearfix"></div><div class="service_inner_desc fount_service_desc wpb_text_column"'.$inline.'>'.$content.'</div><div class="simple_line thick special_size"></div><div class="service_lnk prk_heavier_600 header_font"><a class="zero_color fade_anchor" href="'.$link.'"'.$inline.'>'.$link_text.'</a></div></div></div>';
	}
	add_shortcode('prk_service', 'prk_service_shortcode');
	
	//SIMPLE LINE
	function simple_line_shortcode( $atts, $content = null ) 
	{
		global $prk_fount_options;
		$custom_color=$custom_icon=$custom_icon_color="";
		$out="";
		if (!isset($atts['icon_bk_color']))
		{
			
			$atts['icon_bk_color']="#FFFFFF";
		}
		if (!isset($atts['icon_color']))
		{
			$atts['icon_color']=$prk_fount_options['lines_color'];
		}
		if (isset($atts['color']) && $atts['color']!="")
		{
			$custom_color=' style="border-bottom: 1px solid '.$atts['color'].'"';
		}
		$main_classes="";
		if (isset($atts['el_class']) && $atts['el_class']!="")
			$main_classes=" ".$atts['el_class'];
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
			$main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		if (isset($atts['icon']) && $atts['icon']!="")
		{
			$out.='<div class="simple_line shortcoded iconized'.$main_classes.'"'.$custom_color.'>';
			$custom_icon_color=' style="color:'.$atts['icon_color'].';background-color:'.$atts['icon_bk_color'].'"';
			$atts['icon']=str_replace('fa fa', 'fount_fa', $atts['icon']);
			$out.='<i class="'.$atts['icon'].'"'.$custom_icon_color.'></i>';
		}
		else
		{
			$out.='<div class="simple_line shortcoded'.$main_classes.'"'.$custom_color.'>';
		}
		$out.='</div>';
		return $out;
	}
	add_shortcode('prk_line', 'simple_line_shortcode');

	//LISTS
	function list_with_icons_shortcode( $atts, $content = null ) 
	{
		$custom_icons="";
		if (isset($atts['icon']))
			$custom_icons=$atts['icon'];
		return '<div class="list_with_icons '. $custom_icons .'">' . $content . '</div>';
	}
	add_shortcode('list_with_icons', 'list_with_icons_shortcode');

	//TOGGLE CHILDNODES RETRIEVAL - LEGACY
	function prk_ac_single( $atts, $content = null ) {
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );
		//MAKE TAB ID MATCH THE CONTENT TAB ID
		return '<div class="prk_ac_single">'. do_shortcode( $content ) .'</div>';
	}
	add_shortcode( 'prk_ac_single', 'prk_ac_single' );


	//TOGGLE - DEPRECATED
	/*function prk_accordion( $atts, $content = null ) 
	{
		$defaults = array( 'type' => '' );
		extract( shortcode_atts( $defaults, $atts ) );
		if (isset($atts['type']) && $atts['type']!="")
			$type=$atts['type'];
		else
			$type="";
		if (isset($atts['title']) && $atts['title']!="")
			$title=$atts['title'];
		else
			$title="No title was set";
		$main_classes="";
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
			$main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		if (isset($atts['el_class']) && $atts['el_class']!="")
			$main_classes.=" ".$atts['el_class'];
		$output = '';
	    $output .= '<div id="accordion_'. rand(1, 1000) .'" class="prk_accordion'.$main_classes.'">';
	    $output .= '<div class=""><a href="#">'.$title;
	    $output .= '</a></div>';
		$output .= '<div class="prk_ac_single">'. do_shortcode( $content ) .'</div>';
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'prk_accordion', 'prk_accordion' );*/
	
	//CAROUSEL
	//CHILDNODES RETRIEVAL
	function prk_carousel_single( $atts, $content = null ) {
		$defaults = array( 'path' => '' );
		extract( shortcode_atts( $defaults, $atts ) );
		$path="";
		if (isset($atts['path']))
			$path=$atts['path'];
		//MAKE TAB ID MATCH THE CONTENT TAB ID
		return '<img src="'.$path.'" '.prk_dims($path,1,'both').'/>';
	}
	add_shortcode( 'prk_carousel_single', 'prk_carousel_single' );
	//MAIN CAROUSEL BAR SECTION RETRIEVAL
	function prk_carousel( $atts, $content = null ) 
	{
		extract(shortcode_atts(array(
			'title'    	 => ''
		), $atts));
		if (isset($atts['title']) && $atts['title']!="")
			$title=$atts['title'];
		else
			$title="";
		$output = '';
		if ($title!="")
        	$output.=do_shortcode('[prk_styled_title align="left" text_color="" show_lines="no" use_italic="" title_size="small"]'.$title.'[/prk_styled_title]');
		$output .= '<div class="prk_list_carousel">';
		$output .= '<ul class="prk_rousel">';
		$output .= do_shortcode( $content );
		$output .= '</ul>';
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'prk_carousel', 'prk_carousel' );
	
	//THEME BUTTONS
	function button_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'caption'    	 => 'This is my text',
			'icon'		 => 'heart',
			'button_bk_color' =>'',
			'button_icon' =>'',
			'el_class' => '',
			'css_animation' => ''
		), $atts));
		global $prk_fount_options;
		$link="";
		if (isset($atts['link']))
			$link=$atts['link'];
		$type="theme_button large";
		if (isset($atts['type']) && $atts['type']!="")
			$type=$atts['type'];
		$window="_self";
		if (isset($atts['window']))
			$window=$atts['window'];
		$custom_style="";
		if (isset($atts['button_bk_color']) && $atts['button_bk_color']!="") {
			$type.=" fount_custom_button";
			if ($prk_fount_options['buttons_style']=="solid_buttons")
				$custom_style=' style="background-color:'.$atts['button_bk_color'].'" data-color="'.$atts['button_bk_color'].'"';
			else
				$custom_style=' style="background-color:'.$atts['button_bk_color'].'" data-color="'.$atts['button_bk_color'].'" data-forced-color="true"';
		}
		else
		{
			$custom_style='';
		}
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
		{
			$type.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		}
		if (isset($atts['el_class']) && $atts['el_class']!="")
		{
			$type.=" ".$atts['el_class'];
		}
		$icon="";
		$classer="";
		if (isset($atts['button_icon']) && $atts['button_icon']!="")
		{
			$icon_tweak=str_replace('fa fa', 'fount_fa', $atts['button_icon']);
			$icon='<div class="icon_cell"><i class="'.$icon_tweak.'"></i></div>';
			$classer=" with_icon";
			$content='<div class="text_shifter">'.$content.'</div>';
		}
		$out="";
	   	$out.='<div class="'.$type.'"><a href="'.$link.'" target="'.$window.'" class="fade_anchor'.$classer.'"'.$custom_style.'>'.$content.$icon.'</a></div>';
	   	return $out;
	}
	add_shortcode('theme_button', 'button_shortcode');	
	
	//LATEST PORTFOLIOS
	function pirenko_last_portfolios_shortcode( $atts, $content = null ) 
	{
		global $prk_fount_options;
		global $prk_retina_device;
		global $prk_translations;
		$retina_flag = $prk_retina_device === "prk_retina" ? true : false;
		if (isset($atts['title']) && $atts['title']!="")
			$title=$atts['title'];
		else
			$title="";
		if (isset($atts['button_url']) && $atts['button_url']!="")
			$button_url=$atts['button_url'];
		else
			$button_url="";
		if (isset($atts['button_label']) && $atts['button_label']!="")
			$button_label=$atts['button_label'];
		else
			$button_label="";
		if (isset($atts['cols_number']) && $atts['cols_number']!="0")
			$cols_number = $atts['cols_number'];
		else
			$cols_number="3";
		if (isset($atts['items_number']) && $atts['items_number']!="")
			$items_number = $atts['items_number'];
		else
			$items_number="9";
		if (isset($atts['cat_filter']) && $atts['cat_filter']!="")
			$cat_filter = $atts['cat_filter'];
		else
			$cat_filter="";
		if (isset($atts['show_filter']) && $atts['show_filter']!="")
			$show_filter = $atts['show_filter'];
		else
			$show_filter="yes";
		if (isset($atts['layout_type_folio']) && $atts['layout_type_folio']!="")
			$layout_type_folio = $atts['layout_type_folio'];
		else
			$layout_type_folio="grid";
		if (isset($atts['thumbs_mg']) && $atts['thumbs_mg']!="")
			$thumbs_mg = $atts['thumbs_mg'];
		else
			$thumbs_mg="10";
		if (isset($atts['thumbs_type_folio']) && $atts['thumbs_type_folio']!="")
			$thumbs_type_folio = $atts['thumbs_type_folio'];
		else
			$thumbs_type_folio="overlayed";
		if (!isset($atts['icons_display']) || (isset($atts['icons_display']) && $atts['icons_display']=="")) {
			$atts['icons_display']="both_icon";
		}
		if(!isset($atts['fount_show_skills']) || isset($atts['fount_show_skills']) && $atts['fount_show_skills']=="") {
			$atts['fount_show_skills']="folio_title_and_skills";
		}
		switch ($thumbs_type_folio) {
            case 'aboved':
                $anchor_type="fount_ajax_above";
            break;
            case 'lightboxed':
                $anchor_type="lightboxed";
            break;
            case 'classiqued':
                $anchor_type="classiqued";
            break;
            default:
                $anchor_type="fount_ajax_anchor";
            break;
        }
		if (isset($atts['fount_show_skills']) && ($atts['fount_show_skills']=="yes" || $atts['fount_show_skills']=="" || $atts['fount_show_skills']=="folio_title_and_skills"))
		{
			$fount_show_skills=true;
		}
		else
		{
			$fount_show_skills=false;
		}
		$my_home_query = new WP_Query();
		if (isset($atts['tag_filter']) && $atts['tag_filter']!="")
		{
			$args = array (	'post_type' => 'pirenko_portfolios', 
			'posts_per_page' => 999,
			'portfolio_tag'=>$atts['tag_filter'],
			);
		}
		else
		{
			$args = array (	'post_type' => 'pirenko_portfolios', 
			'posts_per_page' => 999,
			'pirenko_skills'=>$cat_filter,
			);
		}
		$my_home_query->query($args);
		$alt_flag=true;
		$out = '';
		if ($my_home_query->have_posts())
		{
			$extra_class_content="";
			if ($atts['fount_show_skills']!="yes")
			{
				$extra_class_content.=' '.$atts['fount_show_skills'];
			}
			if (isset($atts['titled_portfolio']) && $atts['titled_portfolio']=="yes")
			{
				$extra_class_content.=' titled_portfolio';
			}
            $out.='<div id="folio_father" class="recentfolio_ul_wp prk_shorts small-12'.$extra_class_content.'" data-items="'.$items_number.'">';
            	if ($anchor_type=="fount_ajax_above")
            	{
            		$out.='<div id="folio_nav_wrapper">';
            			$out.='<div id="folio_nav_inner">';
            				$out.='<div class="squared_button left_floated">';
            					$out.='<div class="fount_left_folio fount_left_figure left_floated small_headings_color">';
				  					$out.='<div class="inner_mover">';
										$out.='<div class="mover">';
											$out.='<i class="fount_fa-arrow-left"></i>';
											$out.='<i class="fount_fa-arrow-left second"></i>';
										$out.='</div>';
									$out.='</div>';
								$out.='</div>';
							$out.='</div>';
							$out.='<div id="squared_close" class="squared_button left_floated">';
								$out.='<div class="fount_close_folio fount_close_figure left_floated small_headings_color">';
				  					$out.='<i class="fount_fa-times"></i>';
								$out.='</div>';
							$out.='</div>';
							$out.='<div class="squared_button left_floated">';
								$out.='<div class="fount_right_figure fount_right_folio left_floated small_headings_color">';
								  	$out.='<div class="inner_mover">';
										$out.='<div class="mover">';
											$out.='<i class="fount_fa-arrow-right"></i>';
											$out.='<i class="fount_fa-arrow-right second"></i>';
										$out.='</div>';
									$out.='</div>';
								$out.='</div>';
							$out.='</div>';
						$out.='</div>';
					$out.='</div>';
            		$out.='<div class="fount_ajax_portfolio">';
				    $out.='</div>';
            		$out.='<div class="fount_ajax_portfolio_wrapper"></div>';
            		$out.='<div class="multi_spinner spinner-icon"></div>';
            	}
            	$shifted="";
            	$ins=0;
				if ($show_filter=="yes" || $button_url!="")
				{
					$terms = get_terms("pirenko_skills");
					$count = count($terms);
					$filter_array=explode(",",$cat_filter);
					$filter_array=array_filter(array_map('trim', $filter_array));
                        $out.='<div class="filter_shortcodes">';
                            $out.='<ul class="fount_folio_filter header_font fount_uppercased clearfix">';
                            	if ($show_filter=="yes")
                            	{
	                                $out.='<li class="active small p_filter">';
	                                    $out.='<a class="all" data-filter="p_all" href="javascript:void(0)">'.$prk_translations['all_text'].'</a>';
	                                $out.='</li>';
	                            }
                                if ($show_filter=="yes" && $count > 0)
                                {
	                            	foreach ( $terms as $term ) {
										if (in_array($term->slug, $filter_array) !== false || $cat_filter=="")
	                               		$out.='<li class="small p_filter"><a class="'.$term->slug.'" data-filter="'.$term->slug.'" href="javascript:void(0)">'.$term->name.'</a></li>';
	                            	}
	                            }
                            	if ($button_url!="")
				            	{
				            		$out.='<li class="small right_floated">';
				                    $out.='<a href="'.$button_url.'" class="pf_link fade_anchor">';
				                    $out.=$button_label;
				                    $out.='</a>';
				                    $out.='</li>';
				                }
                            $out.='</ul>';
							$out.='</div>';
					}
					if (isset($atts['multicolored_thumbs']) && $atts['multicolored_thumbs']=="no")
						$multicolored_thumbs=" default_colored_th";
					else
						$multicolored_thumbs="";
					if ($anchor_type=="lightboxed")
						$multicolored_thumbs.=" lightboxed";
	                $out.='<div id="folio_masonry-'.rand(1, 500).'" class="per_init per_show folio_masonry iso_folio shortcoded'.$multicolored_thumbs.'" data-columns="'.$cols_number.'" style="margin-right:-'.$thumbs_mg.'px;" data-margin='.$thumbs_mg.'>';
	                        while ($my_home_query->have_posts()) : $my_home_query->the_post();
								$skills_links="";
								$skills_names="";
								$skills_yo="";
								$skills_output="";
								$terms = get_the_terms (get_the_ID(), 'pirenko_skills');
								if (!empty($terms))
								{
									foreach ($terms as $term) {
										$skills_links[] = $term->slug;
										$skills_names[] = $term->name;
									}
									$skills_yo = join(" ", $skills_links);
									$skills_output = join(", ", $skills_names);
								}
                                $magnific_image=$image = wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
                                //$magnific_image[0] = $image[0] = get_image_path($image[0]);
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
				                if ($atts['icons_display']=="both_icon")
                                {
                                	$featured_class.="iconized ";
                                }
								$extra_mfp="";
								if (get_field('skip_featured')==1)
								{
									//CHECK IF THERE'S A SECOND IMAGE
									if (get_field('image_2')!="")
									{
										$in_image=wp_get_attachment_image_src(get_field('image_2'),'full');
										$magnific_image[0]=$in_image[0];
									}
									else if (get_field('video_2')) {
										$magnific_image[0]=get_iframe_src(get_field('video_2'));
										$extra_mfp=" mfp-iframe";
									}
								}
								if ($ins<$items_number) 
								{
	                                $out.='<div id="post-'.get_the_ID().'" class="'.$featured_class.'portfolio_entry_li hidden_by_css '.$skills_yo.' p_all" style="margin-bottom:'.$thumbs_mg.'px;" data-color="'.$featured_color.'">';
	                                    $out.='<div class="grid_image_wrapper">';
	                                    $target="";
	                                    $href_val=get_permalink();
	                                    if (get_field('skip_to_external')==1 && get_field('ext_url')!="") {
											$href_val=get_field('ext_url');
											//ADD HTTP PREFIX IF NEEDED
											if (substr($href_val,0,7)!="http://")
												$href_val="http://".$href_val;
											$target=' target="_blank"';
											if (get_field('new_window')=="_self") {
											    $target=' target="_self"';
											}
										}
										$out.='<a href="'.$href_val.'" class="'.$anchor_type.'" data-mfp-src="'.$magnific_image[0].'" data-title="'.get_the_title().'" data-pos="'.$ins.'"'.$target.'>';
	                                    
	                                    $out.='<div class="grid_colored_block">';
	                                    $out.='</div>';
	                                    $forced_w=480;
	                                    if ($cols_number!="variable" && is_numeric($cols_number))
	                                    	$forced_w=1920/$cols_number;
	                                    if ($forced_w<480)
	                                    	$forced_w=480;
										if ($layout_type_folio=="masonry") {
												$forced_h=0;
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, false , $retina_flag );
											}
											else if ($layout_type_folio=="squares")
											{
												$forced_h=$forced_w;
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
											}
											else if ($layout_type_folio=="grid_vertical")
											{
												$forced_h=floor($forced_w*3/2);
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
											}
											else 
											{
												$forced_h=floor($forced_w*2/3);
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
											}

	                                        $out.='<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" id="home_fader-'.get_the_ID().'" class="custom-img grid_image" alt="" data-featured="no" />';
	                                        $out.='<div class="grid_single_title fount_animated">';
			                                    $out.='<div class="prk_ttl">';
			                                    	if (get_field('custom_logo',$my_home_query->post->ID)!="") {
		                                				$in_image=wp_get_attachment_image_src(get_field('custom_logo',$my_home_query->post->ID),'full');
		                                				$vt_image = vt_resize('', $in_image[0] , $forced_w, '', false , true);
		                                				$out.='<img class="stamp_folio_th" src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="" />';
		                                			}
		                                			else {
		                            					$out.='<h3 class="header_font body_bk_color body_bk_text_shadow small">'.the_title("","",false).'</h3>';
		                            				}
			                                    $out.='</div>';
			                                    if ($skills_output!="" && $fount_show_skills==true)
												{
													$out.='<div class="inner_skills body_bk_color">';
													$out.=$skills_output;
													$out.='</div>';
												}
												$out.='<div class="prk_break_word entry_content default_color">';
													$out.=the_excerpt_dynamic(12,$my_home_query->post->ID);
													$out.='<div class="clearfix"></div>';
											$out.='</div>';
	                                    $out.='</div>';
	                               		$out.='<div class="revealed_link zero_color prk_heavier_700 bd_headings_text_shadow">';
			                                $out.='<div class="left_floated">';
			                                $out.=$prk_translations['prj_info_text'];
			                                $out.='</div>';
	                               			$out.='<i class="fount_fa-chevron-right"></i>';
		                                $out.='</div>';
		                                $out.='</a>';
	                                    $out.='</div>';
	                                    $out.='<div class="folio_icons_wrap">';
	                                    if ($atts['icons_display']=="both_icon")
	                                    {
	                                    	$out.='<div class="lone_linker prk_first">';
	                                    	$out.='<a href="'.$href_val.'" class="'.$anchor_type.' ic_lnk body_bk_color" data-pos="'.$ins.'"'.$target.'>';
	                                    	$out.='<i class="fount_fa-link"></i>';
	                                    	$out.='</a>';
	                                    	$out.='</div>';
	                                    	$out.='<div class="lone_linker prk_second">';
	                                    	$out.='<a href="'.get_permalink().'" class="lone_link ic_exp body_bk_color" data-mfp-src="'.$magnific_image[0].'" data-title="'.get_the_title().'" data-pos="'.$ins.'">';
	                                    	$out.='<i class="fount_fa-arrows-alt"></i>';
	                                    	$out.='</a>';
	                                    	$out.='</div>';
	                                    }
	                                    $out.='</div>';
	                                    // FOR IE NO DISPLAY BUG
	                                    $out.='<img src='. $vt_image['url'] .' width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="" class="hide_now">';
	                                $out.='</div>';
	                            }
	                            else
	                            {
	                            	if ($alt_flag==true)
	                            	{
	                            		$out.='</div>';
	                            		$out.='<div class="folio_appender">';
	                            		$alt_flag=false;
	                            	}
	                                $out.='<div id="post-'.get_the_ID().'" class="'.$featured_class.'portfolio_entry_li hidden_by_css '.$skills_yo.' p_all" style="margin-bottom:'.$thumbs_mg.'px;" data-color="'.$featured_color.'">';
	                                    $out.='<div class="grid_image_wrapper">';
										$out.='<a href="'.get_permalink().'" class="'.$anchor_type.'" data-mfp-src="'.$magnific_image[0].'" data-title="'.get_the_title().'" data-pos="'.$ins.'">';
	                                    
	                                    $out.='<div class="grid_colored_block">';
	                                    $out.='</div>';
	                                    $forced_w=480;
	                                    if ($cols_number!="variable" && is_numeric($cols_number))
	                                    	$forced_w=1920/$cols_number;
	                                    if ($forced_w<480)
	                                    	$forced_w=480;
										if ($layout_type_folio=="masonry") {
												$forced_h=0;
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, false , $retina_flag );
											}
											else if ($layout_type_folio=="squares")
											{
												$forced_h=$forced_w;
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
											}
											else if ($layout_type_folio=="grid_vertical")
											{
												$forced_h=floor($forced_w*3/2);
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
											}
											else 
											{
												$forced_h=floor($forced_w*2/3);
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
											}

	                                        $out.='<img data-src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" class="custom-img grid_image" alt="" data-featured="no" src="#" />';
	                                        $out.='<div class="grid_single_title fount_animated">';
	                                    	$out.='<div class="prk_ttl">';
			                                    	if (get_field('custom_logo',$my_home_query->post->ID)!="") {
		                                				$in_image=wp_get_attachment_image_src(get_field('custom_logo',$my_home_query->post->ID),'full');
		                                				$vt_image = vt_resize('', $in_image[0] , $forced_w, '', false , true);
		                                				$out.='<img class="stamp_folio_th" src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" alt="" />';
		                                			}
		                                			else {
		                            					$out.='<h3 class="header_font body_bk_color body_bk_text_shadow small">'.the_title("","",false).'</h3>';
		                            				}
			                                    $out.='</div>';
	                                    if ($skills_output!="" && $fount_show_skills==true)
										{
											$out.='<div class="inner_skills body_bk_color">';
											$out.=$skills_output;
											$out.='</div>';
										}
										$out.='<div class="prk_break_word entry_content default_color">';
											$out.=the_excerpt_dynamic(12,$my_home_query->post->ID);
											$out.='<div class="clearfix"></div>';

										$out.='</div>';
	                                    $out.='</div>';
	                               		$out.='<div class="revealed_link zero_color prk_heavier_700 bd_headings_text_shadow">';
			                                $out.='<div class="left_floated">';
			                                $out.=$prk_translations['prj_info_text'];
			                                $out.='</div>';
	                               			$out.='<i class="fount_fa-chevron-right"></i>';
		                                $out.='</div>';
		                                $out.='</a>';
	                                    $out.='</div>';
	                                    $out.='<div class="folio_icons_wrap">';
	                                    if ($atts['icons_display']=="both_icon")
	                                    {
	                                    	$out.='<div class="lone_linker prk_first">';
	                                    	$out.='<a href="'.get_permalink().'" class="'.$anchor_type.' ic_lnk body_bk_color" data-pos="'.$ins.'">';
	                                    	$out.='<i class="fount_fa-link"></i>';
	                                    	$out.='</a>';
	                                    	$out.='</div>';
	                                    	$out.='<div class="lone_linker prk_second">';
	                                    	$out.='<a href="'.get_permalink().'" class="lone_link ic_exp body_bk_color" data-mfp-src="'.$magnific_image[0].'" data-title="'.get_the_title().'" data-pos="'.$ins.'">';
	                                    	$out.='<i class="fount_fa-arrows-alt"></i>';
	                                    	$out.='</a>';
	                                    	$out.='</div>';
	                                    }
	                                    $out.='</div>';
	                                $out.='</div>';
	                            }
                            $ins++;
                        endwhile;
	            $out.='</div>';
	            if ($alt_flag==false)
            	{
            		$out.='<div class="pf_load_more_wrapper">';
            		$out.='<div class="pf_load_more theme_button with_arrow wpb_animate_when_almost_visible wpb_fount_fade_waypoint">';
                    $out.='<a href="#" class="pf_link fade_anchor">';
                    $out.=$prk_translations['load_more'];
                    $out.='</a>';
                    $out.='<i class="fount_button_arrow fount_fa-chevron-down"></i>';
                    $out.='<div id="folio_spinner" class="spinner-icon"></div>';
                    $out.='</div>';
                    $out.='</div>';
                }
                $out.='<div class="clearfix"></div>';
			$out.='</div>';
       	}
        else
        {
			$out.= '<h2 class="fount_shortcode_warning">No portfolio posts were found!</h2>';	
		}
		$out.='<div class="clearfix"></div>';
		wp_reset_query();
		return $out;
	}
	add_shortcode('pirenko_last_portfolios', 'pirenko_last_portfolios_shortcode'); 

	//LATEST POSTS
	function pirenko_last_posts_shortcode( $atts, $content = null ) 
	{
		global $prk_fount_options;
		global $prk_retina_device;
		global $prk_translations;
		$retina_flag = $prk_retina_device === "prk_retina" ? true : false;
		extract(shortcode_atts(array(
			'title'    	 => '',
			'items_number'		 => '',
			'rows_number'		 => '',
			'cat_filter'	=> '',
			'css_animation' => '',
			'el_class' => ''
		), $atts));
		if (isset($atts['title']) && $atts['title']!="")
			$title=$atts['title'];
		else
			$title="";
		if (isset($atts['items_number']) && $atts['items_number']!="")
			$items_number = $atts['items_number'];
		else
			$items_number="3";
		if (isset($atts['rows_number']) && $atts['rows_number']!="")
			$rows_number = $atts['rows_number'];
		else
			$rows_number="1";
		if (isset($atts['cat_filter']) && $atts['cat_filter']!="")
			$cat_filter = $atts['cat_filter'];
		else
			$cat_filter="";
		if (isset($atts['bg_color']) && $atts['bg_color']!="")
			$bg_color = ' style="background-color:'.$atts['bg_color'].'"';
		else
			$bg_color="";
		if (isset($atts['general_style']) && $atts['general_style']!="")
			$general_style = $atts['general_style'];
		else
			$general_style="classic";
		wp_reset_query();
		$my_home_query = new WP_Query();
		$args = array (	'post_type=posts', 
			'showposts' => $items_number,
			'category_name'=>$cat_filter,
		);
		$my_home_query->query($args);
		$cols_number=floor($items_number/$rows_number);
		$columnizer=floor(12/$cols_number);
		$rand_nbr=rand(1, 500);
		$i=0;
		$out = '';
		if ($my_home_query->have_posts())
		{
			if ($cols_number>=$my_home_query->post_count) 
				$extra_a="";
			else
				$extra_a=" extra_spaced";
			if (isset($atts['css_animation']) && $atts['css_animation']!="")
			{
				$extra_a.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
			}
			if (isset($atts['el_class']) && $atts['el_class']!="")
			{
				$extra_a.=" ".$atts['el_class'];
			}
			if ($general_style=="slider")
			{
				$touch_enable="false";
				if (isset($prk_fount_options['touch_enable']) && $prk_fount_options['touch_enable']=="1") {
					$touch_enable="true";
				}
				$out.='<div class="clearfix"></div>';
	            $out.='<div id="prk_shortcode_latest_posts_'.rand(1, 500).'" class="classy_slider recentposts_ul_wp '.$extra_a.'">';
	                $out.='<div id="recent_blog-'.$rand_nbr.'" class="recentposts_ul_slider" data-navigation="true" data-touch='.$touch_enable.'>';
	                    while ($my_home_query->have_posts()) : $my_home_query->the_post();
	                    if ($i<$items_number)
	                    {
                            if (get_field('featured_color')!="" && $prk_fount_options['use_custom_colors']=="1")
		                  	{
		                    	$featured_color=get_field('featured_color');
		                    	$featured_class=" featured_color ";
		                  	}
		                  	else
		                  	{
		                  		$featured_color="default";
		                    	$featured_class="";
		                  	}
		                	$out.='<div class="blog_entry_li item clearfix'.$featured_class.'" data-color="'.$featured_color.'">';
		                	$out.='<div class="masonry_inner">';
		                	if (has_post_thumbnail())
							{
								$image = wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
		                    	$out.='<a href="'.get_permalink().'" class="fade_anchor blog_hover">';
		                            $out.='<div class="masonr_img_wp boxed_shadow">';
		                            	$out.='<div class="blog_fader_grid">';
		                                	$out.='<div class="fount_fa-plus titled_link_icon body_bk_color"></div>';
		                             	$out.='</div>';
		                                $vt_image = vt_resize( '', $image[0] , 700 , 436, false , $retina_flag );
		                                $out.='<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" class="custom-img grid_image" alt="" />';
		                            $out.='</div>';
		                        $out.='</a>';
							}
							else
							{
								//CHECK IF THERE'S A VIDEO TO SHOW
		                       	if (get_field('video_2')!="")
		                        {
		                        	$out.= "<div class='video-container boxed_shadow'>";
		                           	$out.= get_field('video_2');
									$out.= "</div>";
		                      	}
							}
							$out.='<div class="owl_classic_blog">';
							$out.='<div class="prk_mini_meta small_headings_color header_font prk_heavier_500">';
		            		$out.='<div class="left_floated">';
		        			if (is_sticky())
		                    {
		                        $out.='<div class="left_floated sticky_text">';
		                        $out.=$prk_translations['sticky_text'];
		                        $out.='</div>';
		                        $out.='<div class="left_floated"><div class="pir_divider">|</div></div>';
		                    }
		                    if ($prk_fount_options['show_date_blog']=="1")
		                    {
		            			$out.='<div class="left_floated">';
		            				$out.=get_the_time(get_option('date_format'));
		            			$out.='</div>';
		            		}
		            		$out.='</div>';
		            		$out.='<div class="clearfix"></div>';
		            		$out.='</div>';
							$out.='<div class="entry_title">';
							$out.='<h4 class="bd_headings_text_shadow prk_heavier_700 big header_font">';
									$out.='<a href="'.get_permalink().'" class="prk_break_word zero_color fade_anchor">'.the_title("","",false).'</a>'; 
		            		$out.='</h4>';
		            		$out.='</div>';  
		            		$out.='<div class="on_colored prk_break_word entry_content">';
							$out.=the_excerpt_dynamic(30,$my_home_query->post->ID);
							$out.='<div class="clearfix"></div>';
							$out.='</div>';
							if (is_big_excerpt(30,$my_home_query->post->ID))
							{
								$out.='<div class="theme_button_inverted tiny left_floated">';
                                $out.='<a href="'.get_permalink().'" class="with_icon fade_anchor" data-color="'.$featured_color.'">';
                                $out.='<div class="text_shifter">';
                                $out.=$prk_translations['read_more'];
                                $out.='</div>';
                                $out.='<div class="icon_cell"><i class="fount_fa-chevron-right"></i></div>';
                                $out.='</a>';
                                $out.='</div>';
                             	$out.='<div class="clearfix"></div>';   
							}
				            $out.='</div>';
				            $out.='</div>';
				            $out.='</div>';
	                    }
	                    $i++;
	                    endwhile;
	                $out.='</div>';
	            $out.='</div>';
	        } 
	        else if ($general_style=="slider_ms")
			{
				$touch_enable="false";
				if (isset($prk_fount_options['touch_enable']) && $prk_fount_options['touch_enable']=="1") {
					$touch_enable="true";
				}
				$out.='<div id="prk_shortcode_latest_posts_'.rand(1, 500).'" class="recentposts_ul_wp '.$extra_a.'">';
	                $out.='<div id="recent_blog-'.$rand_nbr.'" class="recentposts_ul_slider msnr" data-navigation="true" data-touch='.$touch_enable.'>';
	                    while ($my_home_query->have_posts()) : $my_home_query->the_post();
	                    if ($i<$items_number)
	                    {
                            if (get_field('featured_color')!="" && $prk_fount_options['use_custom_colors']=="1")
		                  	{
		                    	$featured_color=get_field('featured_color');
		                    	$featured_class=" featured_color ";
		                  	}
		                  	else
		                  	{
		                  		$featured_color="default";
		                    	$featured_class="";
		                  	}
		                	$out.='<div class="blog_entry_li item clearfix'.$featured_class.'" data-color="'.$featured_color.'">';
		                	$out.='<div class="masonry_inner boxed_shadow"'.$bg_color.'>';
		                	if (has_post_thumbnail())
							{
								$image = wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
		                    	$out.='<a href="'.get_permalink().'" class="fade_anchor blog_hover">';
		                            $out.='<div class="masonr_img_wp boxed_shadow">';
		                            	$out.='<div class="blog_fader_grid">';
		                                	$out.='<div class="fount_fa-plus titled_link_icon body_bk_color"></div>';
		                             	$out.='</div>';
		                                $vt_image = vt_resize( '', $image[0] , 680 , 0, false , $retina_flag );
		                                $out.='<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" class="custom-img grid_image" alt="" />';
		                            $out.='</div>';
		                        $out.='</a>';
							}
							else
							{
								//CHECK IF THERE'S A VIDEO TO SHOW
		                       	if (get_field('video_2')!="")
		                        {
		                        	$out.= "<div class='video-container boxed_shadow'>";
		                           	$out.= get_field('video_2');
									$out.= "</div>";
		                      	}
							}
							$out.='<div class="header_font prk_heavier_500 prk_mini_meta small_headings_color">';
		            		$out.='<div class="left_floated">';
		        			if (is_sticky())
		                    {
		                        $out.='<div class="left_floated sticky_text">';
		                        $out.=$prk_translations['sticky_text'];
		                        $out.='</div>';
		                        $out.='<div class="left_floated"><div class="pir_divider">|</div></div>';
		                    }
		                    if ($prk_fount_options['show_date_blog']=="1")
		                    {
		            			$out.='<div class="left_floated">';
		            				$out.=get_the_time(get_option('date_format'));
		            			$out.='</div>';
		            		}
		            		$out.='</div>';
		            		$out.='<div class="clearfix"></div>';
		            		$out.='</div>';
							$out.='<div class="entry_title">';
							$out.='<h4 class="bd_headings_text_shadow prk_heavier_700 big">';
									$out.='<a href="'.get_permalink().'" class="prk_break_word zero_color fade_anchor">'.the_title("","",false).'</a>'; 
		            		$out.='</h4>';
		            		$out.='</div>';  
		            		$out.='<div class="on_colored prk_break_word entry_content">';
							$out.=the_excerpt_dynamic(28,$my_home_query->post->ID);
							$out.='<div class="clearfix"></div>';
							$out.='</div>';
							$out.='<div class="blog_lower header_font prk_heavier_500">';
							$out.='<div class="small-12 columns">';
							if ($prk_fount_options['categoriesby_blog']=="1")
				            {
				            	$arra=get_the_category( get_the_ID());
						        if(!empty($arra)) 
						        {
						        	$out.='<div class="left_floated blog_categories small_headings_color">';
						        	$count=0;
						            foreach($arra as $s_cat) 
						            {
						            	if ($count>0)
						            		$out.=', ';
						                $out.='<a href="'.get_category_link( $s_cat->term_id ).'" title="View all posts">'.$s_cat->cat_name.'</a>';
						                $count++;
						            }
						            $out.='</div>';
						        }
				            }
							$out.='<div class="single_blog_meta_div right_floated">';
		                    $out.='<a href="'.get_permalink().'" class="small_headings_color fade_anchor">';
		                    $out.='<div class="left_floated">';
		                    $out.=$prk_translations['read_more'];
		                    $out.='</div>';
		                    $out.='<i class="fount_fa-chevron-right"></i>';
		                    $out.='</a>';
		                    $out.='</div>';
		                    $out.='<div class="clearfix"></div>';
		                    $out.='</div>';
				            $out.='</div>';
				            $out.='</div>';
				            $out.='</div>';
	                    }
	                    $i++;
	                    endwhile;
	                $out.='</div>';
	            $out.='</div>';
	        } 
	        else if ($general_style=="classic")
			{
	            $out.='<div id="prk_shortcode_latest_posts_'.rand(1, 500).'" class="recentposts_ul_wp row'.$extra_a.'">';
	                $out.='<ul id="recent_blog-'.$rand_nbr.'" class="recentposts_ul_shortcode" data-columns='.$cols_number.' data-rows='.$rows_number.'>';
	                    while ($my_home_query->have_posts()) : $my_home_query->the_post();
	                    if ($i<$items_number)
	                    {
	                            $image = wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
	                            //$image[0] = get_image_path($image[0]);
	                            if (get_field('featured_color')!="" && $prk_fount_options['use_custom_colors']=="1")
	                          	{
	                            	$featured_color=get_field('featured_color');
	                            	$featured_class=' class="featured_color"';
	                          	}
	                          	else
	                          	{
	                          		$featured_color="default";
	                            	$featured_class="";
	                          	}

	                            $out.='<li class="columns small-'.$columnizer.'">';
	                            $out.='<div'.$featured_class.' data-color="'.$featured_color.'">';
								if (has_post_thumbnail())
								{	
	                            	$out.='<a href="'.get_permalink().'" class="fade_anchor blog_hover">';
	                                    $out.='<div class="masonr_img_wp boxed_shadow">';
	                                    	$out.='<div class="blog_fader_grid">';
	                                        	$out.='<div class="fount_fa-plus titled_link_icon body_bk_color"></div>';
	                                     	$out.='</div>';
	                                        $vt_image = vt_resize( '', $image[0] , 700 , 436, true , $retina_flag );
	                                        $out.='<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" class="custom-img grid_image" alt="" />';
	                                    $out.='</div>';
	                                $out.='</a>';
								}
								else
								{
									//CHECK IF THERE'S A VIDEO TO SHOW
	                               	if (get_field('video_2')!="")
	                                {
	                                	$out.= "<div class='video-container boxed_shadow'>";
	                                   	$out.= get_field('video_2');
										$out.= "</div>";
	                              	}
								}
								$out.='<div class="prk_mini_meta small_headings_color header_font prk_heavier_500">';
	                    			if (is_sticky())
	                                {
                                        $out.='<div class="left_floated sticky_text">';
                                        $out.=$prk_translations['sticky_text'];
                                        $out.='</div>';
	                                    $out.='<div class="left_floated"><div class="pir_divider">|</div></div>';
	                                }
	                                if ($prk_fount_options['show_date_blog']=="1")
	                                {
		                    			$out.='<div class="left_floated">';
		                    				$out.=get_the_time(get_option('date_format'));
		                    			$out.='</div>';
		                    		}
		                    		$out.='<div class="clearfix"></div>';
	                    		$out.='</div>';
								$out.='<div class="entry_title">';
								$out.='<h4 class="bd_headings_text_shadow prk_heavier_700 big header_font">';
										$out.='<a href="'.get_permalink().'" class="prk_break_word zero_color fade_anchor">'.the_title("","",false).'</a>'; 
	                    		$out.='</h4>';
	                    		$out.='</div>';  
	                    		$out.='<div class="on_colored prk_break_word entry_content">';
									$out.=the_excerpt_dynamic(30,$my_home_query->post->ID);
									$out.='<div class="clearfix"></div>';
								$out.='</div>';
								$out.='<div class="theme_button_inverted tiny left_floated">';
                                $out.='<a href="'.get_permalink().'" class="with_icon fade_anchor" data-color="'.$featured_color.'">';
                                $out.='<div class="text_shifter">';
                                $out.=$prk_translations['read_more'];
                                $out.='</div>';
                                $out.='<div class="icon_cell"><i class="fount_fa-chevron-right"></i></div>';
                                $out.='</a>';
                                $out.='</div>';
								$out.='<div class="clearfix"></div>';
	                        $out.='</li>';
	                    }
	                    $i++;
						if ($i%$cols_number==0 && $i<$items_number)
						{
							$out.='<li class="clearfix small-12 bt_40"></li>';
						}
	                    endwhile;
	                $out.='</ul>';
	            $out.='</div>';
	        }
	        else
	        {
	        	$iso_images_max_w=390;
        		$iso_images_min_w=340;
	        	$out.='<div id="prk_shortcode_latest_posts_'.rand(1, 500).'" class="recentposts_ul_wp row'.$extra_a.'">';
                $out.='<div class="row">';
                $out.='<div id="recent_blog-'.$rand_nbr.'" class="masonry_blog per_init" data-max-width="'.$iso_images_max_w.'" data-min-width="'.$iso_images_min_w.'" data-margin="16">';
	        	while ($my_home_query->have_posts()) : $my_home_query->the_post();
                if ($i<$items_number)
                {
                	if (get_field('featured_color')!="" && $prk_fount_options['use_custom_colors']=="1")
                  	{
                    	$featured_color=get_field('featured_color');
                    	$featured_class=" featured_color ";
                  	}
                  	else
                  	{
                  		$featured_color="default";
                    	$featured_class="";
                  	}
                	$out.='<div class="blog_entry_li clearfix'.$featured_class.'" data-color="'.$featured_color.'">';
                	$out.='<div class="masonry_inner boxed_shadow"'.$bg_color.'>';
                	if (has_post_thumbnail()) {
						$image = wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
                    	$out.='<a href="'.get_permalink().'" class="fade_anchor blog_hover">';
                            $out.='<div class="masonr_img_wp boxed_shadow">';
                            	$out.='<div class="blog_fader_grid">';
                                	$out.='<div class="fount_fa-plus titled_link_icon body_bk_color"></div>';
                             	$out.='</div>';
                                $vt_image = vt_resize( '', $image[0] , 680 , 0, false , $retina_flag );
                                $out.='<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" class="custom-img grid_image" alt="" />';
                            $out.='</div>';
                        $out.='</a>';
					}
					else
					{
						//CHECK IF THERE'S A VIDEO TO SHOW
                       	if (get_field('video_2')!="")
                        {
                        	$out.= "<div class='video-container boxed_shadow'>";
                           	$out.= get_field('video_2');
							$out.= "</div>";
                      	}
					}
					$out.='<div class="header_font prk_heavier_500 prk_mini_meta small_headings_color">';
            		$out.='<div class="left_floated">';
        			if (is_sticky())
                    {
                        $out.='<div class="left_floated sticky_text">';
                        $out.=$prk_translations['sticky_text'];
                        $out.='</div>';
                        $out.='<div class="left_floated"><div class="pir_divider">|</div></div>';
                    }
                    if ($prk_fount_options['show_date_blog']=="1")
                    {
            			$out.='<div class="left_floated">';
            				$out.=get_the_time(get_option('date_format'));
            			$out.='</div>';
            		}
            		$out.='</div>';
            		$out.='<div class="clearfix"></div>';
            		$out.='</div>';
					$out.='<div class="entry_title">';
					$out.='<h4 class="bd_headings_text_shadow prk_heavier_700 big">';
							$out.='<a href="'.get_permalink().'" class="prk_break_word zero_color fade_anchor">'.the_title("","",false).'</a>'; 
            		$out.='</h4>';
            		$out.='</div>';  
            		$out.='<div class="on_colored prk_break_word entry_content">';
					$out.=the_excerpt_dynamic(28,$my_home_query->post->ID);
					$out.='<div class="clearfix"></div>';
					$out.='</div>';
					$out.='<div class="blog_lower header_font prk_heavier_500">';
					$out.='<div class="small-12 columns">';
					if ($prk_fount_options['categoriesby_blog']=="1")
		            {
		            	$arra=get_the_category( get_the_ID());
				        if(!empty($arra)) 
				        {
				        	$out.='<div class="left_floated blog_categories small_headings_color">';
				        	$count=0;
				            foreach($arra as $s_cat) 
				            {
				            	if ($count>0)
				            		$out.=', ';
				                $out.='<a href="'.get_category_link( $s_cat->term_id ).'" title="View all posts">'.$s_cat->cat_name.'</a>';
				                $count++;
				            }
				            $out.='</div>';
				        }
		            }
					$out.='<div class="single_blog_meta_div right_floated">';
                    $out.='<a href="'.get_permalink().'" class="small_headings_color fade_anchor">';
                    $out.='<div class="left_floated">';
                    $out.=$prk_translations['read_more'];
                    $out.='</div>';
                    $out.='<i class="fount_fa-chevron-right"></i>';
                    $out.='</a>';
                    $out.='</div>';
                    $out.='<div class="clearfix"></div>';
                    $out.='</div>';
		            $out.='</div>';
		            $out.='</div>';
		            $out.='</div>';
				}
				endwhile;
            	$out.='</div>';
            	$out.='</div>';
            	$out.='</div>';
	        }
       	}
        else
        {
			$out.='<div id="prk_shortcode_latest_posts" class="recentposts_ul_wp small-12">';
                $out.='<div class="shortcode-title">'.$title.'</div>';
                $out.='<div class="simple_line"></div>';
			 $out.= '<h2 class="fount_shortcode_warning">No posts were found!</h2>';	
			 $out.='</div>';	
		}
		wp_reset_query();
		return $out;
	}
	add_shortcode('pirenko_last_posts', 'pirenko_last_posts_shortcode');

	//LAST CPT's
	function pirenko_last_cpts_shortcode( $atts, $content = null ) {
		global $prk_fount_options;
		global $prk_retina_device;
		global $prk_translations;
		$retina_flag = $prk_retina_device === "prk_retina" ? true : false;
		extract(shortcode_atts(array(
			'type'    	=> '',
			'thumbs_mg'	=> '',
			'images' => '',
			'cpt' => ''
		), $atts));
		if (isset($atts['items_number']) && $atts['items_number']!="")
			$items_number = $atts['items_number'];
		else
			$items_number="3";
		if (isset($atts['cpt']) && $atts['cpt']!="")
			$wdg_post_type=$atts['cpt'] ;
		else
			$wdg_post_type='post';
		if (isset($atts['cols_number']) && $atts['cols_number']!="0")
			$cols_number = $atts['cols_number'];
		else
			$cols_number="3";
		if (isset($atts['thumbs_mg']) && $atts['thumbs_mg']!="")
			$thumbs_mg = $atts['thumbs_mg'];
		else
			$thumbs_mg="10";
		if (isset($atts['layout_type_folio']) && $atts['layout_type_folio']!="")
			$layout_type_folio = $atts['layout_type_folio'];
		else
			$layout_type_folio="masonry";
		if (isset($atts['thumbs_type_folio']) && $atts['thumbs_type_folio']!="")
			$thumbs_type_folio = $atts['thumbs_type_folio'];
		else
			$thumbs_type_folio="lightboxed";
		if ($atts['thumbs_low_type']=="");
			$atts['thumbs_low_type']="fount_low_both";
		if ($atts['thumbs_roll_type']=="");
			$atts['thumbs_roll_type']="fount_roll_both";
		switch ($thumbs_type_folio) {
            case 'lightboxed':
                $anchor_type="lightboxed";
            break;
            case 'classiqued':
                $anchor_type="classiqued";
            break;
        }
		$titles_class="";
		wp_reset_query();
		$my_home_query = new WP_Query();
		$args = array(
			'post_type' => $wdg_post_type,
			'showposts' => 9999,
		);
		$my_home_query->query($args);
		if ($my_home_query->have_posts()) {
			$rand_nbr=rand(1, 5000);
			$out = '';
            $out.='<div class="small-12 fount_cpts '.$anchor_type.' '.$atts['thumbs_roll_type'].' '.$atts['thumbs_low_type'].' cpt-'.$wdg_post_type.'" data-items="'.$items_number.'">';
	                $out.='<div id="iso_gallery-'.$rand_nbr.'" class="iso_folio shortcoded per_init fount_iso_gallery'.$titles_class.'" data-columns="'.$cols_number.'" style="margin-right:-'.$thumbs_mg.'px;" data-margin='.$thumbs_mg.'>';
	                	$ins=0;
	                	$alt_flag=true;
                        while ($my_home_query->have_posts()) : $my_home_query->the_post();
                        	if ($ins<$items_number) {
	                        	if (has_post_thumbnail()) {
	                                $magnific_image=$image=wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
									$extra_mfp="";
	                                $out.='<div class="portfolio_entry_li without_skills" style="margin-bottom:'.$thumbs_mg.'px;" data-mfp-src="'.$magnific_image[0].'" data-title="'.get_the_title().'">';
	                                    $out.='<div class="grid_image_wrapper">';
	                                    	$out.='<a href="'.get_permalink().'" data-mfp-src="'.$magnific_image[0].'" data-title="'.get_the_title().'">';
	                                        $out.='<div class="grid_single_title zero_color bd_headings_text_shadow">';
	                                        $out.='<div class="prk_ttl"><h3 class="header_font body_bk_color body_bk_text_shadow small">'.get_the_title().'</h3></div> ';
	                                        $out.='</div>';
	                                            $out.='<div class="grid_colored_block">';
	                                           $out.='</div>';
												$forced_w=480;
												if ($layout_type_folio=="masonry") {
													$forced_h=0;
													$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, false , $retina_flag );
												}
												else if ($layout_type_folio=="squares")
												{
													$forced_h=480;
													$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
												}
												else 
												{
													$forced_h=300;
													$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
												}
	                                            $out.='<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" class="custom-img grid_image" alt="" data-featured="no" />';
	                                            $out.='</a>';
	                                    $out.='</div>';
	                                    $out.='<a href="'.get_permalink().'">';
	                                    	$out.='<div class="ft_lower_title zero_color bd_headings_text_shadow"><h3 class="header_font small">'.get_the_title().'</h3></div> ';
	                                    $out.='</a>';
	                                    $out.='<div class="ft_lower_excerpt">'.the_excerpt_dynamic(30,$my_home_query->post->ID).'</div> ';
	                                $out.='</div>';
	                                $ins++;
	                            }
                        }
                        else {
                        	if ($alt_flag==true) {
                        		$out.='</div>';
                        		$out.='<div class="folio_appender">';
                        		$alt_flag=false;
                        	}
                        	if (has_post_thumbnail()) {
                                $magnific_image=$image=wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
								$extra_mfp="";
                                $out.='<div class="portfolio_entry_li without_skills hidden_by_css" style="margin-bottom:'.$thumbs_mg.'px;" data-mfp-src="'.$magnific_image[0].'" data-title="'.get_the_title().'">';
                                    $out.='<div class="grid_image_wrapper">';
                                    	$out.='<a href="'.get_permalink().'" data-mfp-src="'.$magnific_image[0].'" data-title="'.get_the_title().'">';
                                        $out.='<div class="grid_single_title zero_color bd_headings_text_shadow">';
                                        $out.='<div class="prk_ttl"><h3 class="header_font body_bk_color body_bk_text_shadow small">'.get_the_title().'</h3></div> ';
                                        $out.='</div>';
                                            $out.='<div class="grid_colored_block">';
                                           $out.='</div>';
											$forced_w=480;
											if ($layout_type_folio=="masonry") {
												$forced_h=0;
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, false , $retina_flag );
											}
											else if ($layout_type_folio=="squares")
											{
												$forced_h=480;
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
											}
											else 
											{
												$forced_h=300;
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
											}
                                            $out.='<img data-src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" class="custom-img grid_image" alt="" data-featured="no" src="#" />';
                                            $out.='</a>';
                                    $out.='</div>';
                                    $out.='<a href="'.get_permalink().'">';
                                    	$out.='<div class="ft_lower_title zero_color bd_headings_text_shadow"><h3 class="header_font small">'.get_the_title().'</h3></div> ';
                                    $out.='</a>';
                                    $out.='<div class="ft_lower_excerpt">'.the_excerpt_dynamic(30,$my_home_query->post->ID).'</div> ';
                                $out.='</div>';
                                $ins++;
                            }
                        }
                        endwhile;
	            $out.='</div>';
	            if ($alt_flag==false) {
            		$out.='<div class="pf_load_more_wrapper">';
            		$out.='<div class="pf_load_more theme_button with_arrow wpb_animate_when_almost_visible wpb_fount_fade_waypoint">';
                    $out.='<a href="#" class="pf_link fade_anchor">';
                    $out.=$prk_translations['load_more'];
                    $out.='</a>';
                    $out.='<i class="fount_button_arrow fount_fa-chevron-down"></i>';
                    $out.='<div id="folio_spinner" class="spinner-icon"></div>';
                    $out.='</div>';
                    $out.='</div>';
                }
			$out.='</div>';
			$out.='<div class="clearfix"></div>';
       	}
        else
        {
			$out.= '<h2 class="fount_shortcode_warning">No content was found!</h2>';		
		}
		wp_reset_query();
		return $out;
	}
	add_shortcode('pirenko_last_cpts', 'pirenko_last_cpts_shortcode'); 

	//THEME GALLERY
	function pirenko_gallery_shortcode( $atts, $content = null ) {
		global $prk_fount_options;
		global $prk_retina_device;
		global $prk_translations;
		$retina_flag = $prk_retina_device === "prk_retina" ? true : false;
		if (!isset($prk_translations['all_text']))
			$prk_translations['all_text']='All';
		extract(shortcode_atts(array(
			'type'    	=> '',
			'thumbs_mg'	=> '',
			'images' => ''
		), $atts));
		if (isset($atts['cols_number']) && $atts['cols_number']!="0")
			$cols_number = $atts['cols_number'];
		else
			$cols_number="variable";
		$items_number="999";
		if (isset($atts['type']) && $atts['type']!="")
			$layout_type_folio = $atts['type'];
		else
			$layout_type_folio="masonry";
		if (isset($atts['thumbs_mg']) && $atts['thumbs_mg']!="")
			$thumbs_mg = $atts['thumbs_mg'];
		else
			$thumbs_mg="10";
		if (isset($atts['show_titles']) && $atts['show_titles']=="no")
			$titles_class=' no_titles_gallery';
		else
			$titles_class="";
		if (isset($atts['onclick']) && $atts['onclick']!="")
			$onclick=$atts['onclick'];
		else
			$onclick="fount_link_image";
		$arr=explode(",",$images);
    	if (count($arr)>0)
		{
			$rand_nbr=rand(1, 5000);
			$out = '';
            $out.='<div class="small-12 fount_gallery '.$onclick.'">';	
	                $out.='<div id="iso_gallery-'.$rand_nbr.'" class="iso_folio shortcoded per_init fount_iso_gallery'.$titles_class.'" data-columns="'.$cols_number.'" style="margin-right:-'.$thumbs_mg.'px;" data-margin='.$thumbs_mg.'>';
	                        foreach ($arr as $single) {
                                $magnific_image=$image = wp_get_attachment_image_src( $single,'full' );
								$extra_mfp="";
                                $out.='<div class="portfolio_entry_li without_skills" style="margin-bottom:'.$thumbs_mg.'px;" data-mfp-src="'.$magnific_image[0].'" data-title="'.get_post($single)->post_title.'">';
                                    $out.='<div class="grid_image_wrapper">';
                                        $out.='<div class="grid_single_title zero_color bd_headings_text_shadow">';
                                        $out.='<div class="prk_ttl"><h3 class="header_font body_bk_color body_bk_text_shadow small">'.get_post($single)->post_title.'</h3></div> ';
                                        $out.='</div>';
                                            $out.='<div class="grid_colored_block">';
                                           $out.='</div>';
											$forced_w=480;
											if ($layout_type_folio=="masonry") {
												$forced_h=0;
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, false , $retina_flag );
											}
											else if ($layout_type_folio=="squares")
											{
												$forced_h=480;
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
											}
											else 
											{
												$forced_h=300;
												$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $retina_flag );
											}
                                            $out.='<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" class="custom-img grid_image" alt="" data-featured="no" />';
                                    $out.='</div>';
                                $out.='</div>';
	                            
	                        }
	            $out.='</div>';
			$out.='</div>';
			$out.='<div class="clearfix"></div>';
       	}
        else
        {
			$out.= '<h2 class="fount_shortcode_warning">No content was found!</h2>';		
		}
		wp_reset_query();
		return $out;
	}
	add_shortcode('pirenko_gallery', 'pirenko_gallery_shortcode'); 

	//LATEST COMMENTS
	function pirenko_comments_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'title'    	 => 'Latest Work',
			'items_number'		 => ''
		), $atts));
		if (isset($atts['title']) && $atts['title']!="")
			$title=$atts['title'];
		else
			$title="";
		if (isset($atts['items_number']) && $atts['items_number']!="")
			$items_number = $atts['items_number'];
		else
			$items_number="4";
		$temp_str='[decent-comments number="'.$items_number.'" show_avatar="false" max_excerpt_words="80" /]';
		$out = '';
        $out.='<div id="prk_shortcode_latest_cmts" class="prk_shorts small-12">';
        if ($title!="") {
			$out.=do_shortcode('[prk_styled_title align="left" text_color="" show_lines="no" use_italic="" title_size="medium"]'.$title.'[/prk_styled_title]');
		};
        $out.=do_shortcode($temp_str);
        $out.='</div>';
		return $out;
	}
	add_shortcode('pirenko_comments', 'pirenko_comments_shortcode');

	//TESTIMONIALS
	function pirenko_testimonials_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'items_number' => '',
			'category' =>'',
			'align' =>'',
			'autoplay' =>'',
			'delay' => '',
			'css_animation' => '',
			'el_class' => ''
		), $atts));
		global $prk_retina_device;
		global $prk_fount_options;
		$retina_flag = $prk_retina_device === "prk_retina" ? true : false;
		if (isset($atts['items_number']) && $atts['items_number']!="")
			$items_number = $atts['items_number'];
		else
			$items_number="999";
		if (isset($atts['category']) && $atts['category']!="")
			$category = $atts['category'];
		else
			$category="";
		$extra_class="";
		if (isset($atts['align']) && $atts['align']=="Center")
			$extra_class .= ' tm_centered';
		wp_reset_query();
		$args=array(	'post_type' => 'pirenko_testimonials',
						'showposts' => $items_number,
						'pirenko_testimonial_set' => $category
					);
		$loop = new WP_Query( $args );
		$out = '';
		if (isset($atts['layout']) && $atts['layout']=="testimonials_stack") {
			$mainer="testimonials_stack";
		}
		else {
			$mainer="per_init owl-carousel testimonials_slider";
		}
		if (isset($atts['autoplay']) && $atts['autoplay']=="no")
			$autoplay="false";
		else
			$autoplay="true";
		if (isset($atts['delay']) && $atts['delay']!="")
			$delay = $atts['delay'];
		else
			$delay="5500";
		if (isset($atts['show_controls']) && $atts['show_controls']=="no")
			$navigation='false';
		else
		{
			$navigation="true";
			$extra_class.=" with_nav";
		}
		$inline="";
		if (isset($atts['color']) && $atts['color']!="") 
		{
			$inline=" style=color:".$atts['color'].";";
		}
		$id="prk_slider_". rand(1, 1000);
		if (isset($atts['css_animation']) && $atts['css_animation']!="")
		{
			if (isset($atts['el_class']) && $atts['el_class']!="")
				$atts['css_animation']=$atts['css_animation']." ".$atts['el_class'];
			$out='<div class="fount_tm_wrapper wpb_animate_when_almost_visible wpb_'.$atts['css_animation'].'">';
		}
		else
			$out='<div class="fount_tm_wrapper">';
		$touch_enable="false";
		if (isset($prk_fount_options['touch_enable']) && $prk_fount_options['touch_enable']=="1") {
			$touch_enable="true";
		}
		$out.='<div class="'.$mainer.$extra_class.'" data-autoplay="'.$autoplay.'" data-delay="'.$delay.'" data-pagination="'.$navigation.'"  data-touch='.$touch_enable.'>';
		while ( $loop->have_posts() ) : $loop->the_post();
        $out.='<div class="item"'.$inline.'>';
        if (has_post_thumbnail(get_the_ID())) {
        	$image = wp_get_attachment_image_src(get_post_thumbnail_id(),'');
            $vt_image = vt_resize('', $image[0] , '' , '', false , $retina_flag );
            $out.='<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" class="testimonial_image" alt="" />';
        }
        else {
			$out.='<div class="icon-users"></div>';
		}
		$out.='<div class="tm_content">';
		$out.='<h4>'.get_the_content().'</h4>';
		$out.='<div class="tm_title not_zero_color header_font prk_heavier_600">';
		if (get_field('testimonial_link')!="") {
			$out.='<a href="'.get_field('testimonial_link').'" target=_blank">'.get_the_title().'</a>';
		}
		else {
			$out.=get_the_title();
		}
		$out.='</div>';
		if (get_field('testimonial_subheading')!="") {
			$out.='<div class="tm_subheading header_font">';
			$out.=get_field('testimonial_subheading');
			$out.='</div>';
		}
		if (get_field('rating')!="" && get_field('rating')!="none") {
			$out.='<div class="tm_stars">';
				for ($count=1;$count<=5;$count++) {
					if ($count<=get_field('rating'))
						$out.='<i class="fount_fa-star not_zero_color"></i>';
					else
						$out.='<i class="fount_fa-star"></i>';
				}
			$out.='</div>';
		}
		$out.='</div>';
		$out.='</div>';
		endwhile;
        $out.='</div>';
        $out.='</div>';
        wp_reset_query();
		return $out;
	}
	add_shortcode('prk_testimonials', 'pirenko_testimonials_shortcode');

	//THEME CONTACT FORM
	function prk_contact_form_shortcode( $atts, $content = null ) {
		global $prk_translations;
		if (!isset($atts['email_adr'])) {
			$atts['email_adr']="sample@email.com";
		}
        $out='<div class="prk_shorts small-12">
        <form action="#" id="contact-form" method="post" data-empty="'.esc_attr($prk_translations['empty_text_error']).'" data-invalid="'.esc_attr($prk_translations['invalid_email_error']).'" data-ok="'.esc_attr($prk_translations['contact_ok_text']).'" data-name="'.get_bloginfo('name').'">
            <div class="small-12">
                <input type="text" class="pirenko_highlighted" name="c_name" id="c_name" 
                placeholder="'.esc_attr($prk_translations['comments_author_text']).esc_attr($prk_translations['required_text']).'"  data-original="'.esc_attr($prk_translations['comments_author_text']).esc_attr($prk_translations['required_text']).'" />
            </div>
            <div class="small-12">
                    <input type="text" class="pirenko_highlighted" name="c_email" id="c_email" size="28"                           placeholder="'.esc_attr($prk_translations['comments_email_text']).esc_attr($prk_translations['required_text']).'"/>
            </div>
            <div class="small-12">
                <input type="text" class="pirenko_highlighted" name="c_subject" id="c_subject" size="28"
                placeholder="'.esc_attr($prk_translations['contact_subject_text']).'" />
            </div>
            <div class="small-12">
                <textarea class="pirenko_highlighted" name="c_message" id="c_message" rows="8"
                placeholder="'.esc_attr($prk_translations['contact_message_text']).'" data-original="'.esc_attr($prk_translations['contact_message_text']).'" ></textarea>
           
            </div>
            <div class="clearfix"></div>
        <input type="hidden" id="full_subject" name="full_subject" value="" />
        <input type="hidden" name="rec_email" value="'.antispambot($atts['email_adr']).'" />
        <div id="contact_ok" class="prk_heavier_600 zero_color header_font bd_headings_text_shadow">'.$prk_translations['contact_wait_text'].'</div>
        <input type="hidden" name="c_submitted" id="c_submitted" value="true" />
        <div class="clearfix"></div>
        <div id="submit_message_div" class="theme_button">
        <div>
            <a href="#" class="with_icon"><div class="text_shifter">'.$prk_translations['contact_submit'].'</div>
                <div class="icon_cell"><i class="fount_fa-chevron-right"></i></div>
            </a>
           </div>
        </div></form></div><div class="clearfix"></div>';
		return $out;
	}
	add_shortcode('prk_contact_form', 'prk_contact_form_shortcode');

	//THEME VCARD
	function prk_vcard_shortcode( $atts, $content = null ) {
		$extra_class=$inline="";
		if (isset($atts['text_color']) && $atts['text_color']!="") {
			$inline=' style="color:'.$atts['text_color'].'"';
			$extra_class=" forced_color";
		}
		if (isset($atts['el_class']) && $atts['el_class']!="")
			$extra_class.=" ".$atts['el_class'];
        $out='<div class="fount_vcard shortcoded'.$extra_class.'"'.$inline.'>';
		if (isset($atts['autoplay']) && $atts['image_path']!="")
		{
			$in_image=wp_get_attachment_image_src( $atts['image_path'],'');
			$out.='<img src="'.$in_image[0].'" alt="" class="fount_vcard_logo" />';
			
		}
		if (isset($content) && $content!="")
		{
			$out.='<div class="small-12 fount_vcard_description"><div class="wpb_text_column">'.$content.'</div></div>';
		}
  		$out.='<div class="adr small-12 prk_heavier_600 default_color header_font">';
		if (isset($atts['company_name']) && $atts['company_name']!="")
		{
			$out.='<div class="fount_vcard_title">'.$atts['company_name'].'</div>';
		}
		if ((isset($atts['street_address']) && $atts['street_address']!="") || (isset($atts['locality']) && $atts['locality']!="") || (isset($atts['postal_code']) && $atts['postal_code']!=""))
		{
			$out.='<i class="fount_fa-map-marker fount_address_icon zero_color"></i>';
		}
		if (isset($atts['street_address']) && $atts['street_address']!="")
		{
			$out.='<div class="street-address fount_after_vcard_icon"><div class="wpb_text_column">'.$atts['street_address'].'</div></div>';
		}
		if (isset($atts['locality']) && $atts['locality']!="")
		{
			$out.='<div class="locality fount_after_vcard_icon"><div class="wpb_text_column">'.$atts['locality'].'</div></div>';
		}
		if (isset($atts['postal_code']) && $atts['postal_code']!="")
		{
			$out.='<div class="postal-code fount_after_vcard_icon"><div class="wpb_text_column">'.$atts['postal_code'].'</div></div>';
		}
		$out.='</div>';
		if (isset($atts['tel']) && $atts['tel']!="")
		{
            $out.='<div class="fount_vcard_block small-12">';
            $out.='<i class="fount_fa-phone fount_address_icon zero_color"></i>';
            $out.='<div class="fount_after_vcard_icon prk_heavier_600 default_color header_font"><div class="wpb_text_column">';
            $out.=$atts['tel'];
            $out.='</div></div>';
            $out.='</div>';
		}
		if (isset($atts['fax']) && $atts['fax']!="")
		{
			$out.='<div class="fount_vcard_block small-12">';
			$out.='<i class="fount_fa-print fount_address_icon zero_color"></i>';
			$out.='<div class="fount_after_vcard_icon prk_heavier_600 default_color header_font"><div class="wpb_text_column">';
			$out.=$atts['fax'];
			$out.='</div></div>';
			$out.='</div>';
		}
		if (isset($atts['hours']) && $atts['hours']!="")
		{
			$out.='<div class="fount_vcard_block small-12">';
			$out.='<i class="fount_fa-clock-o fount_address_icon zero_color"></i>';
			$out.='<div class="fount_after_vcard_icon prk_heavier_600 default_color header_font"><div class="wpb_text_column">';
			$out.=$atts['hours'];
			$out.='</div></div>';
			$out.='</div>';
		}
		if (isset($atts['email']) && $atts['email']!="")
		{
			$out.='<div class="fount_vcard_block small-12">';
			$out.='<i class="fount_fa-envelope fount_address_icon zero_color"></i>';
			$out.='<div class="fount_after_vcard_icon prk_heavier_600 header_font"><div class="wpb_text_column">';
			$out.='<a class="default_color" href="mailto:'.antispambot($atts['email']).'">'.antispambot($atts['email']).'</a>';
			$out.='</div></div>';
			$out.='</div>';
		}
		$out.='<div class="clearfix"></div>';
    	$out.='</div>';
		return $out;
	}
	add_shortcode('pirenko_contact_info', 'prk_vcard_shortcode');
}

