<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="utf-8">
    <meta name="image" property="og:image" content="">
    <?php
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else
        $link = "http";
    $link .= "://";
    $link .= $_SERVER['HTTP_HOST'];
    $link .= $_SERVER['REQUEST_URI'];
    echo '<meta property="og:url" content="'.$link.'" />';
    ?>

    <!-- Load Google Analytics Universal Code -->
        <script>
               (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                           (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                       m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
               })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                   ga('create', 'UA-23771865-1', 'auto');
               ga('require', 'displayfeatures');
              ga('send', 'pageview');

        </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140815734-1"></script>

    <script>
        window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-140815734-1');
    </script>

    <!--Load JQUERY user interface JS + CSS, used on date picker -->

    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <?php $page=get_the_id();
    if($page==5109 || $page==5088 || $page==7727 || $page==7731 || $page==7733 || $page==2237){
        include 'intel/user_profile_includes.php';
    }
    ?>

  <title> <?php echo get_bloginfo('name'); if (is_front_page()){if (get_bloginfo('description')!="") {echo ' | '.get_bloginfo('description');}}else {wp_title('|') ;} ?> </title>

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
<style>
#single_post_content h1{color: #1e51a4 !important;    margin: 10px 0 20px;}
#single_post_content h2{color: #1e51a4 !important;    margin: 10px 0 20px;}
#single_post_content h3{color: #1e51a4 !important;    margin: 10px 0 20px;}
.sf-menu>li{    line-height: 100% !important;
    padding-top: 33px;
}
.head {
    text-transform: uppercase;
    color: #fff;
    font-size: 15px;
    line-height: 20px;
}
.round{    border-radius: 100%; -webkit-border-radius: 100%; -moz-border-radius: 100%; -o-border-radius: 100%;    margin-top: 0px !IMPORTANT;  margin-bottom: 9px !IMPORTANT;}
.sf-menu span{    font-family: 'Open Sans';
    font-family:'Open Sans' "Source Sans Pro",sans-serif;
    font-size: .85em;
    font-weight: 400;
    font-family: "Open Sans";
    font-size: 12px;
    text-transform: uppercase;
    text-decoration: none;
    letter-spacing: 3px;
    font-weight: 600;
    font-style: normal;
    line-height: 2em;
}
.sub-menu span {
    font-family: 'Open Sans' "Source Sans Pro",sans-serif;
    font-size: .85em;
    font-weight: 400;
    font-family: "Open Sans";
    font-size: 13px;
    text-transform: capitalize;
    text-decoration: none;
    letter-spacing: 0;
    font-weight: normal;
    font-style: normal;
    line-height: 2em;
}
.senior-management{

    position: absolute;
    text-transform: uppercase;
    z-index: 999;
    font-weight: bold;
    color: #333;
    text-decoration: underline;
    font-size: 13px;
       margin-top: 89px;
    left: 166px;
}
h1.page-title {
    font-family: 'dincondensedcregular';
    letter-spacing: 0.03125em;
    font-size: 4.3em;
    font-weight: normal;
    text-transform: uppercase;
}
@media only screen and (min-width: 1281px) {
  #menu_section {
      float: left;
      padding-left: 311px;
  }
}

@media only screen and (min-width: 1024px) {
    .header-menu-search-bar.search-menu {
		position: absolute;
		right: 30px;
	}
	#menu_section {
        float: left;
        padding-left: 311px;
    }
}
@media only screen and (min-width: 1024px) and (max-width:1280px){
  #menu_section {
      float: left;
      padding-left: 190px;
  }
}
@media only screen and (max-width: 1024px) and (min-width: 1000px) {
	#menu_section {
        padding-left: 311px;
    }
    .header-menu-search-bar.search-menu {
		position: absolute;
		right: 5px;
	}
	#prk_menu_els {
		padding-left: 0px!important;
		padding-right: 0px!important;
	}
	a.regular_anchor_menu {
    	padding-left: 5px!important;
    	padding-right: 5px!important;
	}

}

.header-menu-search-bar.search-menu {
    padding-top: 28px;
}
.header-menu-search-bar #searchform .sform_wrapper i{
    position: absolute;
    left: 0;
    color: darkgray;
    background: none;
}
#searchform .pirenko_highlighted.search-query {
    padding: 0 0 0 45px;
    width: 100%;
}
#menu_section.unpad_right .sf-menu>li:nth-child(6)>a {
    display: none;
}
@media only screen and (min-width: 768px) and (max-width:1023px) {
	#searchform .pirenko_highlighted.search-query {
    	padding: 0 0 0 85px;
	}
}


#fount_member_description span{font-family: 'dincondensedcregular';font-weight: normal;color: #4ea7dd;font-size: .66em;}
.SEAN h3{    margin-top: -32px;font-family: 'dincondensedcregular';font-weight: normal;color: #4ea7dd;font-size: 1.66em;}
   /* .sf-menu{  text-transform: uppercase;font-family:'source_sans_proregular';}*/
</style>

<link rel='stylesheet' href='<?php echo site_url(); ?>/wp-content/themes/fount-child/font/stylesheet.css' type='text/css' media='all' />
</head>
<body <?php body_class('fount_theme'); ?>>

	<div id="body_hider" class="hider_flag"></div>
		<div id="body_hider_full" class="hider_flag"></div>
	<div id="fount_wrapper" class="<?php echo $prk_fount_options['thumbs_roll_style'].' '.$prk_fount_options['header_layout'].' '.$prk_fount_options['buttons_style'];echo $buttons_class; ?>">
		<div id="fount_to_top" class="prk_radius" data-color="<?php echo $prk_fount_options['active_color']; ?>">
	  		<i class="fount_fa-arrow-up"></i>
	  	</div>
		<div id="prk_pint" data-media="" data-desc=""></div>
		<div id="prk_mega_wrap" class="ultra_wrapper" data-maxw="<?php echo $prk_fount_options['custom_width']; ?>">
			<div id="fount_ajax_back"></div>
		<?php
			if ($prk_fount_options['right_bar']=="1")
			{
				echo '<div id="prk_hidden_bar" class="small-12">';
				echo '<div id="prk_hidden_bar_scroller">';
				echo '<div id="prk_hidden_bar_inner" class="'.$prk_fount_options['right_bar_align'].'">';
				$hidden_sidebar_id='sidebar-hidden';
	            if (get_field('hidden_sidebar_id')!="")
	                $hidden_sidebar_id=get_field('hidden_sidebar_id');
	            if (isset($prk_fount_options['fount_active_skin']) && (is_single() || $prk_fount_options['fount_active_skin']=="fount_multipage_skin" || $prk_fount_options['fount_active_skin']=="fount_shop_skin"))
				{
					$hidden_sidebar_id=$prk_fount_options['fount_current_sidebar'];
				}
				if (function_exists('dynamic_sidebar') && dynamic_sidebar($hidden_sidebar_id)) :
				endif;
				echo '<div class="clearfix"></div>';
				echo '</div></div>';
				if ($prk_fount_options['right_bar_footer_id']!="")
				{
					$right_bar_footer_id=$prk_fount_options['right_bar_footer_id'];
					if (is_active_sidebar($right_bar_footer_id))
					{
						echo '<div id="hidden_bar_footer" class="small-12 '.$prk_fount_options['right_bar_align'].'">';
						if (function_exists('dynamic_sidebar') && dynamic_sidebar($right_bar_footer_id)) :
						endif;
						echo '<div class="clearfix"></div></div>';
					}
				}
				echo '</div>';
			}
			if ($prk_fount_options['menu_hide_flag']=="1")
			{
			    $offsetter="0";
			}
			else
			{
			    $offsetter=$prk_fount_options['collapsed_menu_vertical'];
			}
		?>
		<div id="wrap" class="container columns zero_side_pad centered" role="document">
			<div id="prk_responsive_menu" class="classic_menu columns small-12" data-height="<?php echo $prk_fount_options['menu_vertical']; ?>" data-collapsed="<?php echo $prk_fount_options['collapsed_menu_vertical']; ?>" data-offsetter="<?php echo $offsetter; ?>" data-opacity="<?php echo $prk_fount_options['header_opacity']; ?>" data-default="<?php echo $prk_fount_options['header_default_opacity']; ?>">
				<?php
					if ($prk_fount_options['header_layout']=="fount_logo_above") {
						?>
						<div id="prk_logos">
							<a href="<?php echo home_url('/'); ?>" class="regular_anchor_menu">
								<div id="fount_logo_holder">
								<?php
									echo prk_output_before_logo($prk_retina_device);
									echo prk_output_after_logo($prk_retina_device);
								?>
								</div>
							</a>
						</div>
				  	<?php
				}
				?>
				<div id="prk_responsive_menu_inner" class="small-12"<?php if ($prk_fount_options['header_layout']=="fount_logo_above") {echo ' data-0-start="position:absolute;" data-0-top="position:fixed;"';} ?>>
					<div id="prk_menu_els" class="columns small-12 prk_inner_block small-centered">
						<?php
							if ($prk_fount_options['header_layout']!="fount_logo_above") {
								?>
								<div id="prk_logos">
									<a href="<?php echo home_url('/'); ?>" class="regular_anchor_menu">
										<div id="fount_logo_holder">
										<?php
											echo prk_output_before_logo($prk_retina_device);
											echo prk_output_after_logo($prk_retina_device);
										?>
										</div>
									</a>
								</div>
						  	<?php
						}
						if ($prk_fount_options['top_search']=="1") {
						  $output='<div id="searchform_top" class="top_sform_wrapper" data-url="'.prk_clean_url().'">';
							$output.='<form role="search" method="get" class="form-search" action="'.home_url('/').'">';
							  $output.='<div class="sform_wrapper">';
								$output.='<input type="text" value="" name="s" id="fount_search_top" class="search-query" placeholder="'.$prk_translations['search_tip_text'].'" />';
								$output.='</div>';
							  $output.='</form>';
							  $output.='<div id="top_form_close" class="fount_fa-times"></div>';
							$output.='</div>';
							$output.='<div id="top_form_hider"></div>';
						  echo $output;
						}
					  	$menu_position_class="";
					  	if ($prk_fount_options['show_extra_nets']=="0" && $prk_fount_options['top_search']=="0" && $prk_fount_options['right_bar']=="0") {
					  		$menu_position_class=' class="unpad_right"';
					  	}
				    ?>
					<div id="menu_section" data-color="<?php echo $prk_fount_options['menu_active_color']; ?>"<?php echo $menu_position_class; ?>>
						<?php
							$trigger_class="";
							if (get_field('dots_navigation')!="1")
							{
								?>
								<nav id="nav-main" role="navigation">
									<div class="nav-wrap header_font">
										<?php
											if (has_nav_menu('prk_main_navigation'))
											{
												?>
											  	<div id="fount_left_floater" class="left_floated">
												  	<div id="prk_menu_left_trigger" class="left_floated" data-color="<?php echo $prk_fount_options['menu_active_color']; ?>">
														<div class="prk_blocks">
															<div class="prk_menu_block prk_bl1"></div>
											                <div class="prk_menu_block prk_bl2"></div>
											                <div class="prk_menu_block prk_bl3"></div>
														</div>
												  	</div>
											  	</div>
											  	<?php
												if(is_404() || (isset($post->ID) && (get_post_meta($post->ID,'top_menu',true)=="" || get_post_meta($post->ID,'top_menu',true)=="null")))
												{
													if (isset($prk_fount_options['fount_active_skin']) && (is_single() || $prk_fount_options['fount_active_skin']=="fount_multipage_skin" || $prk_fount_options['fount_active_skin']=="fount_shop_skin"))
													{
														if ($prk_fount_options['fount_current_menu']!="fount_no_menu")
														{
														wp_nav_menu(array(
															'menu' => $prk_fount_options['fount_current_menu'],
															'menu_class' => 'sf-menu sf-vertical mini-site-header',
															'link_after' => '',
															'walker' => new rc_scm_walker));
														}
														else
														{
															$trigger_class=" fount_alone";
														}
													}
													else
													{
														wp_nav_menu(array(
															'theme_location' => 'prk_main_navigation',
															'menu_class' => 'sf-menu sf-vertical mini-site-header',
															'link_after' => '',
															'walker' => new rc_scm_walker));
													}
											  	}
											  	else
											  	{
											  		if (!isset($post->ID))
											  		{
											  			wp_nav_menu(array(
															'theme_location' => 'prk_main_navigation',
															'menu_class' => 'sf-menu sf-vertical mini-site-header',
															'link_after' => '',
															'walker' => new rc_scm_walker));
											  		}
											  		else
											  		{
												  		if (get_post_meta($post->ID,'top_menu',true)!="fount_no_menu")
												  		{
												  			wp_nav_menu(array(
													  			'menu' => get_post_meta( $post->ID, 'top_menu', true ),
													  			'menu_class' => 'sf-menu sf-vertical mini-site-header',
													  			'link_after' => '',
													  			'walker' => new rc_scm_walker));
												  		}
												  		else
												  		{
												  			$trigger_class=" fount_alone";
												  		}
												  	}
											  	}
											}
										?>
								   </div>
								</nav>
								<?php
							}
							if ($prk_fount_options['show_extra_nets']=="1" || $prk_fount_options['top_search']=="1" || $prk_fount_options['right_bar']=="1")
							{
								echo '<div id="fount_top_floater">';
							}
							if ($prk_fount_options['show_extra_nets']=="1") {
								echo output_mini_nets();
							}
							if ($prk_fount_options['top_search']=="1")
							{
								echo '<div id="prk_menu_loupe" class="fount_fa-search left_floated" data-color="'.$prk_fount_options['menu_active_color'].'"></div>';
							}
							if ($prk_fount_options['right_bar']=="1")
							{
								$output='<div id="prk_menu_right_trigger" class="left_floated'.$trigger_class.'" data-color="'.$prk_fount_options['menu_active_color'].'">';
								$output.='<div class="prk_blocks">';
								$output.='<div class="prk_menu_block prk_bl1"></div>';
								$output.='<div class="prk_menu_block prk_bl2"></div>';
								$output.='<div class="prk_menu_block prk_bl3"></div>';
								$output.='</div>';
								$output.='</div>';
								echo $output;
							}
							if ($prk_fount_options['show_extra_nets']=="1" || $prk_fount_options['top_search']=="1" || $prk_fount_options['right_bar']=="1")
							{
								echo '</div>';
							}
						?>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<?php
				if (get_field('dots_navigation')=="1")
				{
					?>
					<nav id="dotted_navigation" role="navigation" class="nav-wrap header_font">
						<div id="menu_section">
							<?php
							  	$trigger_class="";
								if (has_nav_menu('prk_main_navigation'))
								{
									if(is_404() || (isset($post->ID) && get_post_meta($post->ID,'top_menu',true)=="") || (isset($prk_fount_options['fount_active_skin']) && ($prk_fount_options['fount_active_skin']=="fount_multipage_skin" || $prk_fount_options['fount_active_skin']=="fount_shop_skin" )))
									{
										if (isset($prk_fount_options['fount_active_skin']) && (is_single() || $prk_fount_options['fount_active_skin']=="fount_multipage_skin" || $prk_fount_options['fount_active_skin']=="fount_shop_skin"))
										{
											if ($prk_fount_options['fount_current_menu']!="fount_no_menu")
											{
											wp_nav_menu(array(
												'menu' => $prk_fount_options['fount_current_menu'],
												'menu_class' => 'mini-site-header',
												'link_after' => '',
												'walker' => new rc_scm_walker));
											}
											else
											{
												$trigger_class=" fount_alone";
											}
										}
										else
										{
											wp_nav_menu(array(
												'theme_location' => 'prk_main_navigation',
												'menu_class' => 'mini-site-header',
												'link_after' => '',
												'walker' => new rc_scm_walker));
										}
								  	}
								  	else
								  	{
								  		if (!isset($post->ID))
								  		{
								  			wp_nav_menu(array(
												'theme_location' => 'prk_main_navigation',
												'menu_class' => 'mini-site-header',
												'link_after' => '',
												'walker' => new rc_scm_walker));
								  		}
								  		else
								  		{
									  		if (get_post_meta($post->ID,'top_menu',true)!="fount_no_menu")
									  		{
									  			wp_nav_menu(array(
										  			'menu' => get_post_meta( $post->ID, 'top_menu', true ),
										  			'menu_class' => 'mini-site-header',
										  			'link_after' => '',
										  			'walker' => new rc_scm_walker));
									  		}
									  		else
									  		{
									  			$trigger_class=" fount_alone";
									  		}
									  	}
								  	}
								}
							?>
						</div>
					</nav>
					<?php
				}
			?>
			<div id="fount_ajax_wrapper">
				<div id="fount_ajax_holder"></div>
			</div>
			<div id="top_bar_wrapper">
				<div id="top_bar_nav">
					<div class="squared_button left_floated">
					  <div id="fount_left" class="fount_left_figure left_floated small_headings_color">
					  	<div class="inner_mover">
						    <div class="mover">
						      <i class="fount_fa-arrow-left"></i>
						      <i class="fount_fa-arrow-left second"></i>
						    </div>
						</div>
					  </div>
					</div>
					<div id="squared_close" class="squared_button left_floated">
						<div id="fount_close" class="fount_close_figure left_floated small_headings_color">
					  		<i class="fount_fa-times"></i>
						</div>
					</div>
					<div class="squared_button left_floated">
					  <div id="fount_right" class="fount_right_figure left_floated small_headings_color">
					    <div class="inner_mover">
					    	<div class="mover">
					    		<i class="fount_fa-arrow-right"></i>
					    		<i class="fount_fa-arrow-right second"></i>
					    	</div>
					    </div>
					  </div>
					</div>
				</div>
			</div>
		<div id="prk_ajax_container" data-ajax_path="<?php echo get_template_directory_uri() ?>/inc/ajax-handler.php" data-retina="<?php echo $prk_retina_device; ?>">
<?php include 'intel/modals.php';?>
<?php include 'intel/jQuery_modals.php';?>
<?php include 'intel/report-pdf-modal.php';?>
