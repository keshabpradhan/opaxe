/* jshint ignore:start */ 
//GLOBAL VARIABLES DECLARATION
var buttons;
var first_load=true;
var loading_page=true;
var sidebar_is_open=false;
function fount_init() {
	"use strict";
	var mini_site_mode=true;
	var stop_verification=false;
	var logo_margin=Math.floor((parseInt(jQuery('#prk_responsive_menu').attr('data-height'),10)-parseInt(jQuery('#fount_logo_before img').attr('height'),10))/2);
	if (jQuery('.fount_forced_menu').length) {
		logo_margin=Math.floor((parseInt(jQuery('#prk_responsive_menu').attr('data-height'),10)-parseInt(jQuery('#fount_logo_after img').attr('height'),10))/2);
	}
	jQuery('#fount_logo_holder').css({'margin-top':logo_margin+'px'});
	var on_top=true;
	var mn_normal=jQuery('#prk_responsive_menu').attr('data-height');
	var mn_collapsed=jQuery('#prk_responsive_menu').attr('data-collapsed');
	var rows_offset=parseInt(jQuery('#prk_responsive_menu').attr('data-collapsed'),10)+4;
	if (jQuery('#prk_responsive_menu').attr('data-opacity')==="0") {
		rows_offset=4;
	}
	var mn_collapsed_margin=(mn_collapsed-parseInt(jQuery('#prk_alt_logo_image').attr('height'),10))/2;
	var mn_collapsed_logo_height=mn_collapsed-16;
	if (mn_collapsed_logo_height>jQuery('#prk_alt_logo_image').attr('height')) {
		mn_collapsed_logo_height=parseInt(jQuery('#prk_alt_logo_image').attr('height'),10);
	}
	if (mn_collapsed_margin<8) {
		mn_collapsed_margin=8;
	}
	var menu_bar_height=0;
	var last_scroll_position=0; 
	var height_fix=0;
	var mirror_offset=0;
	var first_cross=true;
	var ajax_in_pos=0;
	var $inner_blog;
	var scrollbar_width=window.innerWidth-jQuery("body").width();
	if (jQuery.browser.msie) {
		scrollbar_width=scrollbar_width+1;
	}
	//var fount_on_iPad = navigator.userAgent.match(/iPad/i) != null;
	var fount_on_mobile = is_mobile()===true ? true : false;
	if (fount_on_mobile) {
		jQuery('html').addClass('fount_on_mobile');
		jQuery('.slider_scroll_button').remove();
		//jQuery('#fount_to_top').remove(); - 1.9
	}
	else {
		jQuery('html').addClass('fount_on_desktop');
	}
	if (mn_normal===mn_collapsed ) {
		var collapse_onscroll=false;
	}
	else {
		var collapse_onscroll=true;
	}
	if (theme_options.menu_hide_flag==="0") {
		var hide_onscroll=false;
	}
	else {
		var hide_onscroll=true;
	}
	//SIDEBAR MENU STUFF
	jQuery('#prk_hidden_bar_inner .menu>li>a').each(function() {
		jQuery(this).addClass('regular_anchor_menu header_font prk_heavier_700 default_color');
	});
	jQuery('#prk_hidden_bar_inner .menu .sub-menu a').each(function() {
		jQuery(this).addClass('regular_anchor_menu header_font prk_heavier_600 default_color');
	});
	jQuery('#prk_hidden_bar_inner .menu>li>a').click(function() {
		prk_toggle_sidebar();
	});
	var force_menu_hide=false;
	//TOP BAR MENU STUFF
	jQuery('#nav-main ul.sf-menu').supersubs({ 
        minWidth:    1,
        maxWidth:    12, 
        extraWidth:  2 
    }).superfish({
    	hoverClass:'fount_hover_sub', 
		delay:100,
		animation: {color:'show'},
		cssArrows:    false, 
		speed:         250, 
		speedOut:      250, 
		dropShadows:   false,
		onBeforeShow:function(){
			jQuery(this).css({'visibility':'visible'});
		},
		onHide:function(){
			jQuery(this).css({'visibility':'hidden'});
		}
	});
	var responsive_menu_is_open=false;
	jQuery('#prk_menu_left_trigger').click(function() {
		if (responsive_menu_is_open===true) {
			responsive_menu_is_open=false;
			jQuery('#menu_section .sf-menu').stop().slideUp(300, function() {
				jQuery('#fount_top_floater').css({'display':''});
			});
		}
		else {
			responsive_menu_is_open=true;
			jQuery('html, body').animate({scrollTop:0}, 0);
			jQuery('#fount_top_floater').css({'display':'none'});
			jQuery('#menu_section .sf-menu').stop().slideDown(900, function() {
			});
		}
	});
	function is_on_viewport(elem) {
		var docViewTop = jQuery(window).scrollTop();
		var docViewBottom = docViewTop + jQuery(window).height();
	
		var elemTop = jQuery(elem).offset().top;
		var elemBottom = elemTop + jQuery(elem).height();
	
		return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom));
	}
	//SHARING FUNCTIONS
	function prk_init_sharrre() {
		jQuery('.prk_sharrre_twitter').sharrre({
			share: {
			twitter: true
			},
			template: '<a class="box social_tipped" href="#" data-color="#43b3e5"><div class="share"><div class="fount_fa-twitter"></div></div><div class="bg_shifter"><i class="fount_fa-twitter"></i></div></a><div class="count prk_sharrre_count" href="#">{total}</div>',
			enableHover: false,
			enableTracking: false,
			//buttons: { twitter: {via: 'username'}},
			click: function(api) {
				api.simulateClick();
				api.openPopup('twitter');
			},
			render: function(api){
			}
		});
		jQuery('.prk_sharrre_facebook').sharrre({
			share: {
				facebook: true
			},
			template: '<a class="box social_tipped" href="#" data-color="#1f69b3"><div class="share"><div class="fount_fa-facebook"></div></div><div class="bg_shifter"><i class="fount_fa-facebook"></i></div></a><div class="count prk_sharrre_count" href="#">{total}</div>',
			enableHover: false,
			enableTracking: false,
			click: function(api) {
				api.simulateClick();
				api.openPopup('facebook');
			},
			render: function(api){
			}
		});
		jQuery('.prk_sharrre_google').sharrre({
			share: {
				googlePlus: true
			},
			template: '<a class="box social_tipped" href="#" data-color="#222222"><div class="share"><div class="fount_fa-google-plus"></div></div><div class="bg_shifter"><i class="fount_fa-google-plus"></i></div></a><div class="count prk_sharrre_count" href="#">{total}</div>',
			enableHover: false,
			enableTracking: false,
			click: function(api) {
				api.simulateClick();
				api.openPopup('googlePlus');
			},
			render: function(api){
			}
		});
		var pinterestMedia="";
		jQuery('.prk_sharrre_pinterest').sharrre({
			share: {
				pinterest: true
			},
			buttons: {
				pinterest: {
				media: pinterestMedia,
				description: ''
				}
			},
			template: '<a class="box social_tipped" href="#" data-color="#df2126"><div class="share"><div class="icon-pinterest"></div></div><div class="bg_shifter"><i class="icon-pinterest"></i></div></a><div class="count prk_sharrre_count" href="#">{total}</div>',
			enableHover: false,
			enableTracking: false,
			click: function(api) {
				api.simulateClick();
				api.openPopup('pinterest');
			},
			render: function(api){
			}
		});
		jQuery('.prk_sharrre_linkedin').sharrre({
			share: {
				linkedin: true
			},
			template: '<a class="box social_tipped" href="#" data-color="#1a7696"><div class="share"><div class="fount_fa-linkedin"></div></div><div class="bg_shifter"><i class="fount_fa-linkedin"></i></div></a><div class="count prk_sharrre_count" href="#">{total}</div>',
			enableHover: false,
			enableTracking: false,
			click: function(api) {
				api.simulateClick();
				api.openPopup('linkedin');
			},
			render: function(api){
			}
		});
		jQuery('.prk_sharrre_stumbleupon').sharrre({
			share: {
				stumbleupon: true
			},
			template: '<a class="box social_tipped" href="#" data-color="#ef4e23"><div class="share"><div class="fount_fa-stumbleupon"></div></div><div class="bg_shifter"><i class="fount_fa-stumbleupon"></i></div></a><div class="count prk_sharrre_count" href="#">{total}</div>',
			enableHover: false,
			enableTracking: false,
			click: function(api) {
				api.simulateClick();
				api.openPopup('stumbleupon');
			},
			render: function(api){
			}
		});
		jQuery('.prk_sharrre_pinterest').live('mouseover', function() { 
			jQuery('#prk_pint').attr('data-media',jQuery(this).attr('data-media'));
		});
	}
	function check_top_menu(resize_flag) {
		if ((!jQuery('body').hasClass('menu_at_top') || resize_flag===true) && theme_options.menu_collapse_flag==="1") {
			if(jQuery(window).scrollTop()>=theme_options.menu_collapse_pixels || resize_flag===true || jQuery('#bottom_bar_wrapper').hasClass('prk_tweaked') || (jQuery(window).scrollTop()>=120 && jQuery('.fount_forced_menu').length))
			{
				if (on_top===true || resize_flag===true) {
					jQuery.waypoints('refresh');
					on_top=false;
					jQuery('#fount_wrapper').addClass('fount_collapsed_menu');
					if (jQuery('#prk_responsive_menu').attr('data-pattern')==="false") {
						jQuery('#prk_responsive_menu_inner').stop().animate({
							'height': mn_collapsed,
						}, 
						{
							duration:350
						});
					}
					else {
						jQuery('#prk_responsive_menu_inner').stop().animate({
							'height': mn_collapsed,
						}, 
						{
							duration:350
						});
					}
					jQuery('#fount_header_bar').stop().animate({
						'margin-top': -jQuery('#fount_header_bar').attr('data-size'),
					}, 
					{
						duration:350
					});
					if (collapse_onscroll) {
						jQuery('#searchform_top input,#prk_top_divider_wrapper,#fount_top_floater, #prk_menu_loupe, #menu_section .sf-menu>li').stop().animate({
							'height': mn_collapsed,
							'line-height': mn_collapsed,
						}, 
						{
							duration:350
						});
						jQuery('#fount_logo_holder').animate({
							'margin-top':mn_collapsed_margin
						}, 
						{
							duration:350
						});
					}
				}
			}
			else {
				if (on_top===false) {
					on_top=true;
					jQuery('#fount_wrapper').removeClass('fount_collapsed_menu');
					if (jQuery('#prk_responsive_menu').attr('data-pattern')==="false") {
						jQuery('#prk_responsive_menu_inner').stop().animate({
							'height': mn_normal,
							'margin-top':0,
						}, 
						{
							duration:350
						});
						jQuery('#fount_header_bar').stop().animate({
							'margin-top': 0,
						}, 
						{
							duration:350
						});
						if (collapse_onscroll) {
							jQuery('#searchform_top input,#prk_top_divider_wrapper,#fount_top_floater, #prk_menu_loupe, #menu_section .sf-menu>li').stop().animate({
								'height': mn_normal,
								'line-height': mn_normal,
							}, 
							{
								duration:350
							});
							jQuery('#fount_logo_holder').stop().animate({
								'margin-top':logo_margin
							}, 
							{
								duration:350
							});
						}
					}
					else {
						jQuery('#prk_responsive_menu_inner').stop().animate({
							'height': mn_normal,
							'margin-top':0,
						}, 
						{
							duration:80
						});
						jQuery('#fount_header_bar').stop().animate({
							'margin-top': 0,
						}, 
						{
							duration:80
						});
						if (collapse_onscroll) {
							jQuery('#searchform_top input,#prk_top_divider_wrapper,#fount_top_floater, #prk_menu_loupe, #menu_section .sf-menu>li').stop().animate({
								'height': mn_normal,
								'line-height': mn_normal,
							}, 
							{
								duration:80
							});
							jQuery('#fount_logo_holder').stop().animate({
								'margin-top':logo_margin
							}, 
							{
								duration:80
							});
						}
					}
				}
			}
		}
	}//CHECK TOP MENU
	//TOP BAR SEARCH FORM
	jQuery('#prk_menu_loupe').click(function() {
		jQuery('#searchform_top,#top_form_hider').css({'opacity':0,'display':'block'});
		jQuery('#searchform_top,#top_form_hider').stop().animate({
			opacity:1
		}, 
		{
			easing:'linear',
			duration:200
		});
		if (!jQuery('html').hasClass('fount_ie')) {
			jQuery('#searchform_top input').focus();
		}
	});
	function fount_close_search() {
		if (jQuery('#top_form_hider').css('display')==='block') {
			jQuery('#searchform_top,#top_form_hider').stop().animate({
				opacity:0
			}, 
			{
				easing:'linear',
				duration:200,
				complete:function() {
					jQuery('#searchform_top,#top_form_hider').css({'display':'none'});
				}
			});
		}
	}
	jQuery('#top_form_close').click(function() {
		fount_close_search();
	});
	jQuery('.sform_wrapper .fount_fa-search').click(function() {
		jQuery(this).parent().parent().submit();
	});
	//SCROLLING FUNCTIONS
	if (!fount_on_mobile) {
		jQuery(window).scroll(function() {
			var st = jQuery(this).scrollTop();
			if (force_menu_hide && hide_onscroll || (hide_onscroll && jQuery(window).scrollTop()>=theme_options.menu_hide_pixels && st > last_scroll_position)){
			   jQuery('#prk_responsive_menu').addClass('fount_hidden_menu');
			} else {
			  jQuery('#prk_responsive_menu').removeClass('fount_hidden_menu');
			}
			last_scroll_position = st;
			jQuery('#footer_revealer').css({'opacity':jQuery('#footer_mirror').css('opacity')});
			//SKROLLR FIX IF NEEDED
			if (stop_verification===false) {
				stop_verification=true;
			 	if ((parseInt(jQuery('body')[0].style.height,10)-jQuery('#prk_mega_wrap').outerHeight())>100) {
					jQuery(window).trigger("debouncedresize");
				}
			}
		});
	}
	jQuery(window).scroll(function() {
		check_top_menu(false);
		//BACK TO TOP BUTTON
		if(jQuery(window).scrollTop() >= 180) {
			jQuery('#fount_to_top').addClass('fount_shown');
		}
		else {
			jQuery('#fount_to_top').removeClass('fount_shown');
		}
		check_and_load();
	});
	//BACK TO TOP BUTTON
	jQuery('#fount_to_top').click(function() {
		jQuery('body,html').animate({scrollTop:0},600);
	});
	//CALL A SCROLL EVENT TO INITIALIZE CONTENT
	jQuery(window).scroll();
	//MINISITE FUNCTIONS
	//MENU HIGHLIGHT SYSTEM
	function deactivate_menu_links() {
		jQuery('#menu_section ul li.active').removeClass('active');
	}
    if (mini_site_mode) {
    	if(jQuery('#dotted_navigation').length) {
    		jQuery('#menu_section>ul>li>a').each(function() {
				jQuery(this).parent().removeClass('active');
			});
			jQuery('#menu_section a').each(function() {
				jQuery(this).addClass('regular_anchor_menu');
			});
	    	jQuery.waypoints('refresh');
	    	var rows = jQuery('#fount_super_sections>div');
			var menu_anchors = jQuery('#menu_section li');
			rows.waypoint({
				handler: function(direction) {
					if (!jQuery('body').hasClass('menu_at_top')) {
						var pos=jQuery.inArray(this,rows);
						var visible_row = rows.eq(direction === "up" ? pos-1 : pos);
						if (pos<0) {
							pos=0;
						}
						if (visible_row.attr("id")!==undefined && visible_row.attr("id").substring(0,9)!=="gen_fount") {
							var high_link = jQuery('#menu_section a[href$="#'+visible_row.attr("id")+'"]');
							//IF THE ROW HAS NO ID HIGHLIGHT THE HOME LINK
							if (pos===0 || visible_row.attr("id")===undefined) {
								//HIGHLIGH SOMETHING IF NEEDED
								if (!jQuery('#menu_section ul li.active').length) {
									deactivate_menu_links();
									//HIGHLIGHT HOME LINK
									high_link = jQuery('#menu_section>ul>li:first-child>a[href$="#"]');
									high_link.parent().addClass('active');
								}
							}
							else {
								deactivate_menu_links();
								high_link.parent().addClass('active');
							}
							//BUG FIX WHEN PAGE LOADS NOTHING IS HIGHLIGHTED
							if (!jQuery('#menu_section ul li.active').length) {
								var founded=false;
								jQuery('#menu_section>ul>li>a').each(function() {
									if(window.location.href===jQuery(this).attr('href')) {
										high_link=jQuery(this);
										founded=true;
									}
								});
								if (founded===false) {
									high_link = jQuery('#menu_section>ul>li:first-child>a[href$="#"]');
								}
								high_link.parent().addClass('active');
							}
						}
					}
				},
				offset: rows_offset+'px'
			});
    	}
    	else {
	    	jQuery('#menu_section .sf-menu>li>a').each(function() {
				jQuery(this).addClass('regular_anchor_menu');
				jQuery(this).parent().removeClass('active');
			});
			jQuery('#menu_section .sf-menu .sub-menu a').each(function() {
				jQuery(this).addClass('regular_anchor_menu');
			});
	    	jQuery.waypoints('refresh');
	    	var rows = jQuery('#fount_super_sections>div');
			var menu_anchors = jQuery('#menu_section .sf-menu li');
			rows.waypoint({
				handler: function(direction) {
					if (!jQuery('body').hasClass('menu_at_top')) {
						var pos=jQuery.inArray(this,rows);
						var visible_row = rows.eq(direction === "up" ? pos-1 : pos);
						if (pos<0) {
							pos=0;
						}
						if (visible_row.attr("id")!==undefined && visible_row.attr("id").substring(0,9)!=="gen_fount") {
							var high_link = jQuery('#menu_section .sf-menu a[href$="#'+visible_row.attr("id")+'"]');
							//IF THE ROW HAS NO ID HIGHLIGHT THE HOME LINK
							if (pos===0 || visible_row.attr("id")===undefined) {
								//HIGHLIGH SOMETHING IF NEEDED
								if (!jQuery('#menu_section ul li.active').length) {
									deactivate_menu_links();
									//HIGHLIGHT HOME LINK
									high_link = jQuery('#menu_section .sf-menu>li:first-child>a[href$="#"]');
									high_link.parent().addClass('active');
								}
							}
							else {
								deactivate_menu_links();
								high_link.parent().addClass('active');
							}
							//BUG FIX WHEN PAGE LOADS NOTHING IS HIGHLIGHTED
							if (!jQuery('#menu_section ul li.active').length) {
								var founded=false;
								jQuery('#menu_section .sf-menu>li>a').each(function() {
									if(window.location.href===jQuery(this).attr('href')) {
										high_link=jQuery(this);
										founded=true;
									}
								});
								if (founded===false) {
									high_link = jQuery('#menu_section .sf-menu>li:first-child>a[href$="#"]');
								}
								high_link.parent().addClass('active');
							}
						}
					}
				},
				offset: rows_offset+'px'
			});
		}			
    	jQuery("a.regular_anchor_menu,.theme_button.regular_anchor_menu>a,.theme_button_inverted.regular_anchor_menu>a").live('click', function(event) {
    		jQuery.waypoints('refresh');
			var offsetter="";
			var fragment=jQuery(this).attr('href').split('#');
			if (jQuery(this).attr('href')==="#" || window.location.href===jQuery(this).attr('href') || (window.location.href===fragment[0] && !fragment[1].length)) {
				offsetter=0;
				target="";
			}
			else {
				var target = this.hash;
				var $target = jQuery(target);
					//IS IT AN ANCHOR LINK
				    if (target!=="") {
					//IS IT AN EXISITNG ID
				    if ($target.offset()!==undefined) {
				    	if (jQuery('body').hasClass('menu_at_top')){
				    		responsive_menu_is_open=false;
				    		jQuery('.sf-menu').slideUp(0);
				    	}
				    	jQuery.waypoints('refresh');
				    	offsetter=$target.offset().top;
				    }
				}
			}
		    if (offsetter!=="" && !jQuery(this).parent().hasClass('sidebar_opener')) {
		   		event.preventDefault();
		   		var adjuster=-2;
		   		if (!jQuery('body').hasClass('menu_at_top')) {
		   			adjuster=parseInt(rows_offset,10);
		   		}
		   		jQuery('#prk_responsive_menu').addClass('fount_shown_menu');
			    jQuery('html, body').stop().animate({
			        'scrollTop': offsetter-adjuster+4
			    }, 900, 'swing', function () {
			    	jQuery('#prk_responsive_menu').removeClass('fount_shown_menu');
			    	setTimeout(function() {
						jQuery('#prk_responsive_menu').removeClass('fount_hidden_menu');
					},15);
			    });
			}
			if (jQuery('#dotted_navigation').length) {
				if (jQuery(this).parent().children('.sub-menu').length) {
					jQuery(this).parent().children('.sub-menu').slideToggle({
						'duration':250,
						easing:'linear'
					});
				}
			}
		});
    }//END MINISITE FUNCTIONS
    //AJAX PAGE LOAD FUNCTIONS
    var fount_ajax_content=jQuery("#fount_ajax_holder");
    function show_new_page(ajax_page,text,regular_holder) {
    	force_menu_hide=false;
		fount_ajax_content.html('');
		var loaded_html = jQuery(text);
		var new_inner = loaded_html.find('#ajaxed_content');
		//IS THE OVERLAY OPEN?
		if (regular_holder===true) {
			fount_ajax_content.append(new_inner);
			ended_loading(false);
		}
		else {
			jQuery('.fount_active_above .fount_ajax_portfolio').html('');
			jQuery('.fount_active_above .fount_ajax_portfolio').append(new_inner);
			jQuery('.fount_active_above .fount_ajax_portfolio').removeClass('prk_tweaked');
		    jQuery('.fount_active_above .fount_ajax_portfolio').css({'visibility':'visible','display':'block'});
			ended_loading(true);
		}
		
	}
	function load_ajax_link(ajax_page,change_history,regular_holder) {
		//AJAX ABOVE ELEMENTS
		jQuery('.fount_active_above .multi_spinner').css({'opacity':'1'});
		jQuery('.fount_active_above .fount_ajax_portfolio_wrapper').slideDown(250);
		jQuery.ajax({
			url: ajax_page,
			dataType: 'html',
			async: true,
			success: function (text) {
				//CHANGE HISTORY IF NEEDED
				if (change_history===true && window.history.pushState) {
					var pageurl = ajax_page;
					if (pageurl !== window.location) {
						window.history.pushState({
						path: pageurl
						}, '', pageurl);
					}
				}
				show_new_page(ajax_page,text,regular_holder);
			},
			error: function () {
				//SHOW 404 ERROR PAGE IF NEEDED
				window.location.replace(ajax_page);
			}
		});
	}
	//AJAX PORTFOLIO LINKS
	jQuery("a.fount_ajax_anchor,.fount_ajax_anchor a").live('click', function(event) {
		if (jQuery(this).attr('target')==="_blank") {
		}
		else {
			event.preventDefault();
			if (!jQuery(this).parents('.portfolio_entry_li.hover_trigger').length) {
	        	jQuery(this).parent().parent().addClass('hover_trigger');
	    	}
	    	else {
				var next_page=jQuery(this).attr("href");
				//ARE WE UNDER CLASSIC NAVIGATION
				if (jQuery('.single-pirenko_portfolios').length) {
					window.location.href=next_page;
				}
				else {
					//IS THE OVERLAY OPEN
					ajax_in_pos=parseInt(jQuery(this).attr('data-pos'),10);
					if (!jQuery('#fount_ajax_back.fount_tweaked').length) {
						jQuery('#fount_ajax_back').css({'z-index':'4'});
						jQuery('#fount_ajax_back').addClass('fount_tweaked');
						jQuery('#prk_responsive_menu').removeClass('prk_first_anim');
						setTimeout(function() {
							jQuery('#fount_ajax_wrapper').css({'display':'block'});
						},225);
						setTimeout(function() {
							load_ajax_link(next_page,false,true);
						},250);
					}
					else {
						jQuery("#prk_half_size_single,#after_single_folio,#prk_full_folio").removeClass('prk_first_anim');
						setTimeout(function() {
							jQuery('.portfolio_entry_li').removeClass('hover_trigger');
							load_ajax_link(next_page,false,true);
						},300);
					}
				}
			}
		}
	});
	jQuery("a.blog_hover").live('click', function(event) {
		if (!jQuery(this).hasClass('hover_trigger')) {
			event.preventDefault();
        	jQuery(this).addClass('hover_trigger');
    	}
	});
	jQuery("a.fount_ajax_above,.fount_ajax_above a").live('click', function(event) {
		if (jQuery(this).attr('target')==="_blank") {
		}
		else {
			event.preventDefault();
			if (!jQuery(this).parents('.portfolio_entry_li.hover_trigger').length) {
	        	jQuery(this).parent().parent().addClass('hover_trigger');
	    	}
	    	else {
				var next_page=jQuery(this).attr("href");
				ajax_in_pos=jQuery(this).attr("data-pos");
				//IS THE PORTFOLIO ALREADY OPEN
				if (jQuery(this).closest('.fount_ajax_portfolio #ajaxed_content').length) {
					var $target = jQuery('#folio_nav_wrapper');
				    var offsetter=$target.offset().top;
					var adjuster=-2;
					if (!jQuery('body').hasClass('menu_at_top')) {
						adjuster=parseInt(jQuery('#prk_responsive_menu').attr('data-offsetter'),10);
					}
					force_menu_hide=true;
					jQuery('html').stop().animate({
				        'scrollTop': offsetter-adjuster
				    }, 
				    500, 'swing');
				    jQuery('body').stop().animate({
				        'scrollTop': offsetter-adjuster
				    }, 500, 'swing', 
				    function () {
				    	jQuery('.portfolio_entry_li').removeClass('hover_trigger');
			    		jQuery('.fount_ajax_portfolio').addClass('prk_tweaked');
			    		jQuery('.multi_spinner').css({'opacity':'1'});
			    		jQuery('.fount_ajax_portfolio').slideUp(250, function() {
							load_ajax_link(next_page,false,false);
						});
				    });
				}
				else {
					var $thister=jQuery(this);
					var timer=0;
					//CHECK IF THERE'S AN OPENED PORTFOLIO
					if (jQuery('#folio_father.fount_active_above').length) {
						if (loading_page===false) {
							timer=350;
							jQuery('.fount_active_above #folio_nav_wrapper').slideUp(250);
							jQuery('.fount_active_above .fount_ajax_portfolio_wrapper').slideUp(250);
							jQuery('.fount_active_above .fount_ajax_portfolio').slideUp(250, function() {
								jQuery('.fount_active_above .fount_ajax_portfolio').html('');
								jQuery('.fount_active_above #folio_nav_wrapper').removeClass('prk_first_anim');
								jQuery('.fount_active_above #folio_nav_wrapper').css({'display':'block'});
								jQuery('.recentfolio_ul_wp').removeClass('fount_active_above');
							});
							setTimeout(function() {
								stop_verification=false;
							},500);
						}
					}
					setTimeout(function() {
						$thister.closest('#folio_father').addClass('fount_active_above');
						var $target=$thister.closest('#folio_father').children('#folio_nav_wrapper');
					    var offsetter=$target.offset().top;
						var adjuster=-2;
						if (!jQuery('body').hasClass('menu_at_top')) {
							adjuster=parseInt(jQuery('#prk_responsive_menu').attr('data-offsetter'),10);
						}
						force_menu_hide=true;
					    jQuery('html, body').stop().animate({
					        'scrollTop': offsetter-adjuster
					    }, 500, 'swing', 
					    	function () {
				    		jQuery('.portfolio_entry_li').removeClass('hover_trigger');
					    });
						load_ajax_link(next_page,false,false);
					},timer);
				}
			}
		}
	});
	function init_member() {
		if (jQuery('#member_full_row').length && jQuery('#member_full_row').attr('data-color')!=="default") {
			jQuery('#member_full_row .prk_button_like,#member_full_row .prk_blockquote.colored_background').css({'background-color':jQuery('#member_full_row').attr('data-color')});
			jQuery('#member_full_row .fount_navigation_singles a').attr({'data-color':jQuery('#member_full_row').attr('data-color')});
		}
	}
	//BLOG ISOTOPE FUNCTIONS
	function rearrange_cols() {
		jQuery('.masonry_blog').each(function() {
			var $inner_blog=jQuery(this);
			var columns = Math.ceil(($inner_blog.width())/parseInt($inner_blog.attr('data-max-width'),10));
			var entry_width = $inner_blog.width()/columns;
			entry_width = Math.floor(entry_width);
			//FORCE COLUMNS TO HAVE A MINIMUM SIZE
			if (entry_width<parseInt($inner_blog.attr('data-min-width'),10)) {
				columns--;	
			}
			if (columns===0) {
				columns=1;
			}
			entry_width = ($inner_blog.width())/columns;
			entry_width = Math.floor(entry_width);
			$inner_blog.find(".blog_entry_li").each(function() {
				jQuery(this).css({"width":entry_width});
			});
		});
	}
	function rearrange_layout() {
		var winWidth = jQuery(window).width();
		rearrange_cols();
		jQuery('.masonry_blog').each(function() {
			var $inner_blog=jQuery(this);
			if (!$inner_blog.hasClass('per_init')) {
				$inner_blog.isotope('reLayout',function(){
					//DELAY CALCULATIONS IF WE ARE SCALING DOWN THE STAGE
					if(jQuery(window).width() !== winWidth) {
						setTimeout(function(){rearrange_layout();},10);
					}
				});
			}
		});
	}
    function init_blog() {
    	if (jQuery('#classic_blog_section').length) {
			jQuery('#classic_blog_section').fitVids();
			jQuery('#classic_blog_section .featured_color').each(function() {
				jQuery(this).find('.not_zero_color').css({'color':jQuery(this).attr('data-color')});
				jQuery(this).find('.theme_button_inverted a,.zero_color a,a.zero_color,.default_color a,.small_headings_color a').attr('data-color',jQuery(this).attr('data-color'));
				jQuery(this).find('.blog_fader_grid').css({'background-color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity)});
			});
			if (jQuery('#classic_blog_section.prk_evens_grid').length) {
				jQuery('#blog_entries>li:odd').css({'background-color':jQuery('#classic_blog_section.prk_evens_grid').attr('data-color')});
			}
			var img_load=imagesLoaded('#classic_blog_section');
			img_load.on('always', function() {
				NProgress.done();
				setTimeout(function() {
					jQuery("#classic_blog_section,#sidebar").addClass('prk_first_anim');
		    	},180);
			});
		}
		if (jQuery('#single_blog_content').length) {
			jQuery('#single_blog_content').fitVids();
			jQuery('#single_blog_content.featured_color').each(function() {
				jQuery(this).find('.not_zero_color,.not_zero_color a').css({'color':jQuery(this).attr('data-color')});
				jQuery(this).find('.pirenko_highlighted,.theme_button a,.theme_button_inverted a,.zero_color a,a.zero_color,.default_color a,.small_headings_color a').attr('data-color',jQuery(this).attr('data-color'));
				if (jQuery('#fount_wrapper').hasClass('solid_buttons')) {
					jQuery(this).find('.theme_button a').css({'background-color':jQuery(this).attr('data-color')});
				}
				else {
					jQuery(this).find('.theme_button a').css({'border-color':jQuery(this).attr('data-color'),'color':jQuery(this).attr('data-color')});
				}
			});
		}
		jQuery('.masonry_blog').each(function() {
			$inner_blog=jQuery(this);
			$inner_blog.fitVids();
			var minus_sm=parseInt($inner_blog.attr('data-margin'),10)-4;
			if (jQuery('.sidebarized').length) {
				$inner_blog.css({'margin':'-'+$inner_blog.attr('data-margin')+'px -'+$inner_blog.attr('data-margin')+'px '+$inner_blog.attr('data-margin')+'px -'+$inner_blog.attr('data-margin')+'px'});
			}
			else {
				$inner_blog.css({'margin':'-'+$inner_blog.attr('data-margin')+'px '+minus_sm+'px '+$inner_blog.attr('data-margin')+'px '+$inner_blog.attr('data-margin')+'px'});
			}
			var img_load=imagesLoaded($inner_blog);
			img_load.on('always', function() {
				NProgress.done();
				$inner_blog.removeClass('per_init');
				if ($inner_blog.hasClass('templated')) {
					$inner_blog.addClass('trigger_anim');
					$inner_blog.removeClass('templated');
					check_and_load();
				}
				$inner_blog.isotope({
					itemSelector : '.blog_entry_li',
					resizable: false,
					transformsEnabled: false,
					animationEngine : "jquery",
					animationOptions: {
						duration: 0,
					}
				},
				function() {
					setTimeout(function() { 
						jQuery(window).trigger("debouncedresize");
					},50);
					setTimeout(function(){
						$inner_blog.addClass('prk_first_anim');
						jQuery("#sidebar").addClass('prk_first_anim');
					},200);
				});
				$inner_blog.find('.featured_color').each(function() {
					jQuery(this).find('a.zero_color,.small_headings_color a,a.small_headings_color').attr('data-color',jQuery(this).attr('data-color'));
					jQuery(this).find('.blog_fader_grid').stop().css({'background-color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity)});
				});
			});
			if ($inner_blog.hasClass('with_backs')) {
				$inner_blog.find('.blog_entry_li .masonry_inner').css({'background-color':$inner_blog.attr('data-color')});
			}
		});
		jQuery('.recentposts_ul_wp').each(function() {
			var $inner_blog=jQuery(this);
			$inner_blog.fitVids();
			$inner_blog.find('.featured_color').each(function() {
				jQuery(this).find('a.zero_color,.small_headings_color a,a.small_headings_color').attr('data-color',jQuery(this).attr('data-color'));
				jQuery(this).find('.blog_fader_grid').stop().css({'background-color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity)});
			});
		});
    }
    //PORTFOLIO ISOTOPE FUNCTIONS
    function load_more_posts(parent_wrapper) {
		var $newEls = [];
		var $appender=jQuery(parent_wrapper).children('.folio_appender');
		if(jQuery(parent_wrapper).children('.folio_masonry').length) {
			var $appended=jQuery(parent_wrapper).children('.folio_masonry');
		}
		else {
			var $appended=jQuery(parent_wrapper).children('.iso_folio');
		}
		jQuery(parent_wrapper).append('<div id="dumper"></div>');
		var $dumper=jQuery('#dumper');
		var pos=1;
		while (pos<=jQuery(parent_wrapper).attr('data-items')) { 
			$appender.children('.portfolio_entry_li:nth-child('+1+')').find('.grid_image').each(function(){
				jQuery(this).attr('src',jQuery(this).attr('data-src'));
			});
			$dumper.append($appender.children('.portfolio_entry_li:nth-child('+1+')'));
			pos++;
		}
		$newEls=$dumper.children();
		setTimeout(function() {
			var img_load=imagesLoaded($appender);
			img_load.on('always', function() {
				setTimeout(function(){jQuery(window).trigger("smartresize");},10);
				$appended.append($newEls).isotope('appended',$newEls,function() {
					var ctr=1;
					var counter=100;
					setTimeout(function() {
						$appended.find('.hidden_by_css').each(function() {
							var $current_child=jQuery(this);
							setTimeout(function() {
								$current_child.removeClass('hidden_by_css');
								$current_child.css({'opacity':0});
								$current_child.addClass('animate');
								$current_child.animate({
									opacity:1
								}, 
								{
									easing:'linear',
								});
								jQuery(window).trigger("smartresize");
							},counter);
							counter=counter+200;
						});
					},10);
					//UPDATE CONTENT
					jQuery('#folio_father').addClass('dyn_loaded');
					calculate_filters();
					thumbs_roll();
					jQuery(parent_wrapper).find('.pf_load_more').removeClass('loading_posts');
					jQuery('#dumper').remove();
					if($appender.is(':empty')) {
						setTimeout(function(){
							jQuery(parent_wrapper).find('.pf_load_more').addClass("fount_animated bounceOut");
						},1200);
						setTimeout(function(){
							jQuery(parent_wrapper).find('.pf_load_more_wrapper').slideUp(500);
						},2600);
					}
				});
			});
		},10);
	}
	jQuery('.pf_load_more a').live().click(function(e) {
		e.preventDefault();
		if (!jQuery(this).hasClass('loading_posts')) {
			jQuery(this).parent().removeClass('hover_trigger');
			jQuery(this).parent().addClass('loading_posts');
			if (jQuery('#fount_wrapper').hasClass('solid_buttons')) {
				jQuery(this).css({'background-color':theme_options.active_color});
			}
			else {
				jQuery(this).css({'background-color':'transparent','color':theme_options.active_color,'border-color':theme_options.active_color});
			}
			load_more_posts(jQuery(this).parent().parent().parent());
		}
	});
	var jq_paged=-1;
	var jq_max=0;
	var jq_load=false;
	var delayed_counter=2;
	function load_more_multi_posts(parent_wrapper) {
		var link;
		var new_url;
		var items_nr_before;
		var $appended=jQuery(parent_wrapper);
		//MASONRY BLOG
		if (jQuery(parent_wrapper).hasClass('masonry_blog')) {
			jQuery('#prk_ajax_container').append('<div id="dumper"></div>');
			jq_load=true;
			jQuery("#pir_loader_wrapper").css({'visibility':'visible','opacity':'1'});
			if (jq_paged===-1) {
				jq_paged=parseInt(jQuery('#nbr_helper').attr('data-pir_curr'),10)+1;
			}
			items_nr_before=$inner_blog.children('div').length;
			jq_max=jQuery('#nbr_helper').attr('data-pir_max');
			jQuery('#nbr_helper').addClass('loading_posts');
			link = jQuery('.nx_lnk_wp>a').attr('href');
			jQuery('#dumper').append('<div id=more_content_'+jq_paged+'></div>');
			jQuery('#more_content_'+jq_paged+'').load(link+' #main_block > *',function() {
				//APPLY SPECIAL JQUERY METHODS TO ELEMENTS THAT WERE JUST LOADED
				var $newEls = jQuery('#more_content_'+delayed_counter+' .masonry_blog > *');
				new_url=jQuery('#more_content_'+delayed_counter+' .nx_lnk_wp>a').attr('href');
				jQuery('#prk_ajax_container .nx_lnk_wp>a').attr('href',new_url);
				var img_load=imagesLoaded($newEls);
				img_load.on('always', function() {
					$appended.append($newEls).isotope('appended',$newEls,function() {
						jQuery('#dumper').remove();
						var ctr=1;
						var adjusted_mg=parseInt(jQuery('#blog_entries_masonr').attr('data-margin'),10)-7;
						var counter=100;
						$appended.find('.blog_entry_li').each(function() {
							if (ctr>items_nr_before) {
								var $new_item=jQuery(this);
								setTimeout(function() {
									$new_item.css({'opacity':'','padding':$appended.attr('data-margin')+'px'});
									//$new_item.removeClass('hidden_by_css');
									$new_item.addClass('animate');
								},counter);
								counter=counter+250;
							}
							ctr++;
						});
						thumbs_roll();
						init_blog();
						jQuery('#nbr_helper').removeClass('loading_posts');
					});
					jQuery(window).trigger("debouncedresize");
					//INCREASE COUNTER
					delayed_counter++;
					if (delayed_counter<=jq_max) {
						jq_load=false;
					}
					else {
						jQuery('#nbr_helper').css({'visibility':'hidden','margin-top':'0px'});
					}
				});		
			});
			//INCREASE COUNTER
			jq_paged++;
		}
	}
	jQuery("#load_more_blog").live('click', function(event) { 
		event.preventDefault();
		load_more_multi_posts(jQuery('.'+jQuery(this).attr('data-holder')));
	});
	var $container="";
	var grid_helper="";
	var portfolio_gutter=0;
	var curr_filter="p_all";
	//FILTER FUNCTIONS
	function calculate_filters() {
		jQuery('.folio_masonry').each(function() {
			var $thisa=jQuery(this);
			portfolio_gutter=parseInt($thisa.attr('data-margin'),10);
			$thisa.find('.portfolio_entry_li').css({'margin-bottom':portfolio_gutter});
			$thisa.parent().find('.filter_shortcodes .p_filter>a').each(function() {
				var classes = jQuery(this).attr("data-filter").split(" "); 
				var in_counter=0;
				$thisa.children('.portfolio_entry_li').each(function() {
					if (jQuery(this).hasClass(classes)) {
						in_counter++;
					}
				});
				jQuery(this).attr("data-q_counter",in_counter);
			});
		});
	}
	calculate_filters();
	function init_portfolio() {
		if (jQuery('#fount_ajax_wrapper #prk_half_folio,#fount_ajax_wrapper #prk_full_folio').length) {
			jQuery ('body').addClass('fount_showing_lightbox');
			jQuery('body,html').animate({scrollTop:0},0);
			setTimeout(function(){ 
				jQuery('#fount_ajax_holder').addClass('prk_first_anim');
				jQuery('#top_bar_wrapper').addClass('prk_first_anim');
			},75);
		}
		if (jQuery('.navigation_previous_portfolio>a').length) {
			jQuery('#fount_left').removeClass('prk_tweaked');
		}
		else {
			jQuery('#fount_left').addClass('prk_tweaked');
		}
		if (jQuery('.navigation_next_portfolio>a').length) {
			jQuery('#fount_right').removeClass('prk_tweaked');
		}
		else {
			jQuery('#fount_right').addClass('prk_tweaked');
		}
		jQuery('.filter_shortcodes .p_filter>a').live().click(function(e) {
			e.preventDefault();
			jQuery(this).parent().parent().children('.p_filter').removeClass('active');
			curr_filter = jQuery(this).attr('data-filter').split(' ');
			jQuery(this).parent().addClass('active');
			setTimeout(function(){ jQuery(window).trigger("smartresize");},5);
			var $thisa=jQuery(this).parent().parent().parent().parent().children('.folio_masonry');
			$thisa.isotope({
				filter: '.'+curr_filter
			});
		});
		jQuery('.folio_masonry.per_init').each(function() {
			var $container = jQuery(this);
			$container.removeClass('per_init');
			//$container.css({'margin-left':portfolio_gutter});
			if (portfolio_gutter!==0) {
				$container.css({'margin-right':-portfolio_gutter});
			}
			else {
				$container.css({'margin-right':''});
			}
			if (!jQuery('#filter_top').length) {
				$container.css({'margin-top':portfolio_gutter});
			}
			$container.find('.portfolio_entry_li').css({'margin-bottom':portfolio_gutter});
			var img_load=imagesLoaded($container);
			img_load.on('always', function() {
				NProgress.done();
				first_cross=true;
				if (!$container.hasClass('default_colored_th')) {
					jQuery('.portfolio_entry_li').each(function() {
						if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default" ) {
							jQuery(this).find('.grid_colored_block').css({'background-color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity_folio)});
							jQuery(this).find('.lone_linker a').css({'color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity_folio)});
							jQuery(this).find('.lone_linker a').attr('data-color',jQuery(this).attr('data-color'));
							
						}
	                });
				}
				$container.css({'display':'block'});
				var img_nr=2;
				if ($container.attr('data-columns')==="variable") {
					img_nr=Math.ceil($container.width()/430);
				}
				else {	
					img_nr=$container.attr('data-columns');
				}
				var helper= Math.floor($container.width() / img_nr);
				$container.isotope({
					itemSelector : '.portfolio_entry_li',
					resizable: false, // disable normal resizing
					// set columnWidth to a percentage of container width
					masonry: { columnWidth: $container.width() / img_nr },
					transformsEnabled : false,
					animationEngine : "jquery",
					onLayout: function( $elems, instance ) {
					    setTimeout(function(){ 
					    	$container.height($container.height()-1);
					    },10);
					 }
				},
				function() {
					$container.find('.portfolio_entry_li').css({'width':helper});
					//NO 1 PIXEL SPACING SOMETIMES!
					setTimeout(function(){ 
						jQuery(window).trigger( "smartresize");
					},10);
					setTimeout(function(){ 
						jQuery('#folio_father').css({'opacity':1});
					},100);
				});
			});
			jQuery(window).smartresize(function() {
				//SET THE NUMBER OF IMAGES TO SHOW
				var img_nr=2;
				if (jQuery(window).width()<(768 - scrollbar_width)) {
					if (jQuery(window).width()<(420 - scrollbar_width)) {
						img_nr=1;
					}
				}
				else 
				{
					if ($container.attr('data-columns')==="variable") {
						img_nr=Math.ceil($container.width()/430);
					}
					else {	
						img_nr=$container.attr('data-columns');
					}
				}
				$container.find('.portfolio_entry_li').css({'width':'auto'});
				var helper=Math.floor($container.width() / img_nr);

				if (helper<180)
				{
					img_nr--;
					helper=Math.floor($container.width() / img_nr);
					if (helper<180)
					{
						img_nr--;
						helper=Math.floor($container.width() / img_nr);
					}
				} 
				$container.find('.portfolio_entry_li').css({'width':helper});
				$container.find('.portfolio_entry_li .grid_image').css({'width':helper-portfolio_gutter});
				$container.find('.portfolio_entry_li .grid_image').each(function() {
					if (jQuery(this).attr('data-featured')==="yes") {
						jQuery(this).height(parseInt(jQuery('#'+grid_helper).height()*2+portfolio_gutter,10));
					}
                });
				$container.isotope({
					animationOptions: {
						duration: first_cross === true ? 10 : 450,
						easing:'linear',
					},
					masonry: { columnWidth: Math.floor($container.width() / img_nr) },
					onLayout: function( $elems, instance ) {
					    setTimeout(function(){ 
					    	$container.height($container.height()-1);
					    },10);
					}
				});
				//TRICK TO MAKE SURE THE FILTER WORKS
				if (curr_filter!=="p_all" && jQuery('#folio_father.dyn_loaded').length) {
					$container.isotope({
						filter: '.p_all'
					});
					$container.isotope({
						filter: '.'+curr_filter
					});
				}
				setTimeout(function(){
					check_and_load();
				},10);
				$container.find('.portfolio_entry_li').css({'width':helper-portfolio_gutter});
				first_cross=false;
			});
		});
		jQuery('.fount_iso_gallery.per_init').each(function() {
			var $container_gals = jQuery(this);
			var iso_gallery_gutter=parseInt(jQuery(this).attr('data-margin'),10);
			$container_gals.removeClass('per_init');
			//$container_gals.css({'margin-left':iso_gallery_gutter});
			if (iso_gallery_gutter!==0) {
				$container_gals.css({'margin-right':-iso_gallery_gutter});
			}
			else {
				$container_gals.css({'margin-right':''});
			}
			if (!jQuery('#filter_top').length) {
				$container_gals.css({'margin-top':iso_gallery_gutter});
			}
			$container_gals.find('.portfolio_entry_li').css({'margin-bottom':iso_gallery_gutter});
			var img_load=imagesLoaded($container_gals);
			img_load.on('always', function() {
				NProgress.done();
				first_cross=true;
				jQuery('.portfolio_entry_li .grid_image').each(function() {
					if (grid_helper==="" && jQuery(this).attr('data-featured')==="no") {
						grid_helper=jQuery(this).parent().parent().parent().attr('id');
					}
                });
				$container_gals.css({'display':'block'});
				var img_nr=2;
				if ($container_gals.attr('data-columns')==="variable") {
					img_nr=Math.ceil($container_gals.width()/430);
				}
				else {	
					img_nr=$container_gals.attr('data-columns');
				}
				var helper= Math.floor($container_gals.width() / img_nr);
				$container_gals.isotope({
					itemSelector : '.portfolio_entry_li',
					resizable: false, // disable normal resizing
					// set columnWidth to a percentage of container_gals width
					masonry: { columnWidth: $container_gals.width() / img_nr },
					transformsEnabled : false,
					animationEngine : "jquery"
					},
					function() {
						$container_gals.find('.portfolio_entry_li').css({'width':helper});
						//NO 1 PIXEL SPACING SOMETIMES!
						setTimeout(function(){ 
							jQuery(window).trigger( "smartresize");
						},10);
						setTimeout(function(){ 
							jQuery('#folio_father').css({'opacity':1});
						},100);
					});
			});
			jQuery(window).smartresize(function() {
				//SET THE NUMBER OF IMAGES TO SHOW
				var img_nr=2;
				if (jQuery(window).width()<(768 - scrollbar_width)) {
					if (jQuery(window).width()<(420 - scrollbar_width)) {
						img_nr=1;
					}
				}
				else 
				{
					if ($container_gals.attr('data-columns')==="variable") {
						img_nr=Math.ceil($container_gals.width()/430);
					}
					else {	
						img_nr=$container_gals.attr('data-columns');
					}
				}
				$container_gals.find('.portfolio_entry_li').css({'width':'auto'});
				var helper=Math.floor($container_gals.width() / img_nr);

				if (helper<180 && false)
				{
					img_nr--;
					helper=Math.floor($container_gals.width() / img_nr);
					if (helper<180)
					{
						img_nr--;
						helper=Math.floor($container_gals.width() / img_nr);
					}
				}
				$container_gals.find('.portfolio_entry_li').css({'width':helper});
				$container_gals.find('.portfolio_entry_li img').css({'width':helper-iso_gallery_gutter});
				$container_gals.find('.portfolio_entry_li img').each(function() {
					if (jQuery(this).attr('data-featured')==="yes") {
						jQuery(this).height(parseInt(jQuery('#'+grid_helper).height()*2+iso_gallery_gutter,10));
					}
                });
				$container_gals.isotope({
					animationOptions: {
						duration: first_cross === true ? 10 : 450,
						easing:'linear',
					},
						// update columnWidth to a percentage of container_gals width
						masonry: { columnWidth: Math.floor($container_gals.width() / img_nr) }
				});
				//TRICK TO MAKE SURE THE FILTER WORKS
				if (curr_filter!=="p_all" && jQuery('#folio_father.dyn_loaded').length) {
					$container_gals.isotope({
						filter: '.p_all'
					});
					$container_gals.isotope({
						filter: '.'+curr_filter
					});
				}
				setTimeout(function(){
					check_and_load();
				},10);
				$container_gals.find('.portfolio_entry_li').css({'width':helper-iso_gallery_gutter});
				first_cross=false;
			});
		});
		jQuery('#fount_left,#fount_right,#fount_close,.fount_left_folio,.fount_right_folio,.fount_close_folio').attr('data-color','default');
		jQuery('#prk_half_folio.featured_color').each(function() {
			jQuery(this).find('#half-entry-right a').not(jQuery(this).find('#single_folio_sharer a')).css({'color':jQuery('#prk_half_folio.featured_color').attr('data-color')});
			jQuery('#fount_left,#fount_right,#fount_close,.fount_left_folio,.fount_right_folio,.fount_close_folio').attr('data-color',jQuery('#prk_half_folio.featured_color').attr('data-color'));
			jQuery('#after_single_folio').find('.pirenko_highlighted,.theme_button a,.theme_button_inverted a').attr('data-color',jQuery(this).attr('data-color'));
			if (jQuery('#fount_wrapper').hasClass('solid_buttons')) {
				jQuery('#after_single_folio').find('.theme_button a').css({'background-color':jQuery(this).attr('data-color')});
			}
			else {
				jQuery('#after_single_folio').find('.theme_button a').css({'border-color':jQuery(this).attr('data-color'),'color':jQuery(this).attr('data-color')});
			}
			
		});
		jQuery('#prk_full_folio.featured_color').each(function() {
			jQuery('#prk_full_folio.featured_color a').css({'color':jQuery('#prk_full_folio.featured_color').attr('data-color')});
			jQuery('#fount_left,#fount_right,#fount_close,.fount_left_folio,.fount_right_folio,.fount_close_folio').attr('data-color',jQuery('#prk_full_folio.featured_color').attr('data-color'));
			jQuery('#after_single_folio').find('.pirenko_highlighted,.theme_button a,.theme_button_inverted a').attr('data-color',jQuery(this).attr('data-color'));
			if (jQuery('#fount_wrapper').hasClass('solid_buttons')) {
				jQuery('#after_single_folio').find('.theme_button a').css({'background-color':jQuery(this).attr('data-color')});
			}
			else {
				jQuery('#after_single_folio').find('.theme_button a').css({'border-color':jQuery(this).attr('data-color'),'color':jQuery(this).attr('data-color')});
			}
		});
		jQuery('#fount_related_grid .featured_color').each(function() {
			jQuery(this).find('.grid_colored_block').css({'background-color':hex2rgb(jQuery(this).attr('data-color'),theme_options.custom_opacity_folio)});
		});
		jQuery('.fount_close_folio').click(function(e) {
			if (loading_page===false) {
				jQuery('.fount_active_above #folio_nav_wrapper').slideUp(250);
				jQuery('.fount_active_above .fount_ajax_portfolio_wrapper').slideUp(250);
				jQuery('.fount_active_above .fount_ajax_portfolio').slideUp(250, function() {
					jQuery('.fount_active_above .fount_ajax_portfolio').html('');
					jQuery('.fount_active_above #folio_nav_wrapper').removeClass('prk_first_anim');
					jQuery('.fount_active_above #folio_nav_wrapper').css({'display':'block'});
					jQuery('.recentfolio_ul_wp').removeClass('fount_active_above');
				});
				setTimeout(function() {
					stop_verification=false;
				},500);
			}
		});
		jQuery('.fount_left_folio').click(function(e) {
			if (loading_page===false) {
				loading_page=true;
				if (ajax_in_pos>0) {
					ajax_in_pos=parseInt(ajax_in_pos,10)-1;
				}
				else {
					ajax_in_pos=parseInt(jQuery(this).parent().parent().parent().parent().find('.folio_masonry>div').length-1);
				}
				jQuery('.fount_active_above .fount_ajax_portfolio').slideUp(350, function() {
					load_ajax_link(jQuery(this).parent().parent().parent().parent().find('.folio_masonry>div:nth-child('+parseInt((ajax_in_pos+1),10)+') a.fount_ajax_above').attr('href'),false,false);
				});
			}
		});
		jQuery('.fount_right_folio').click(function(e) {
			if (loading_page===false) {
				loading_page=true;
				if (ajax_in_pos<(jQuery(this).parent().parent().parent().parent().find('.folio_masonry>div').length-1)) {
					ajax_in_pos=parseInt(ajax_in_pos,10)+1;
				}
				else {
					ajax_in_pos=0;
				}
				jQuery('.fount_active_above .fount_ajax_portfolio').slideUp(350, function() {
					load_ajax_link(jQuery(this).parent().parent().parent().parent().find('.folio_masonry>div:nth-child('+parseInt((ajax_in_pos+1),10)+') a.fount_ajax_above').attr('href'),false,false);
				});
			}
		});
	}
	function check_and_load() {
		if (jQuery('.folio_masonry.shortcoded.per_show').length || fount_on_mobile) {
			jQuery('.folio_masonry.shortcoded.per_show').each(function() {
				var $elemeter=jQuery(this);
				if (is_on_viewport($elemeter) || fount_on_mobile) {
					$elemeter.removeClass('per_show');
					$elemeter.addClass('fount_effect');
					var counter=100;
					$elemeter.find('.portfolio_entry_li').each(function() {
						var $new_item=jQuery(this);
						setTimeout(function() { 
							$new_item.removeClass('hidden_by_css');
							$new_item.addClass('animate');
						},counter);
						counter=counter+250;
		            });
				}
			});
		}
		if (jQuery('.masonry_blog.trigger_anim').length && (is_on_viewport(jQuery('.masonry_blog.trigger_anim')) || fount_on_mobile)) {
			var $elemeter=jQuery('.masonry_blog.trigger_anim');
			if (!$elemeter.hasClass('fount_effect')) {
				$elemeter.addClass('fount_effect')
				var counter=250;
				$elemeter.find('.blog_entry_li').each(function() {
					var $new_item=jQuery(this);
					setTimeout(function() { 
						$new_item.removeClass('hidden_by_css');
						$new_item.addClass('animate');
						$elemeter.isotope({
							itemSelector : '.blog_entry_li',
							resizable: false,
							transformsEnabled: false
						});
					},counter);
					counter=counter+250;
	            });
			}
		}
	}
    function thumbs_roll() {
    	//NEXT ARROW CLICK
    	jQuery('.fount_next_arrow').each(function() {
    		if (jQuery(this).hasClass('fount_sp_arrow')) {
	    		jQuery(this).parent().attr('href','#'+jQuery('#fount_super_sections>.fount_row').attr('id'));
	    	}
    		else if (!jQuery(this).hasClass('fount_at_slider')) {
	    		jQuery(this).parent().attr('href','#'+jQuery(this).parent().parent().next().next().attr('id'));
	    		jQuery(this).parent().css({'color':jQuery(this).parent().parent().css('color')});
	    	}
    	});
    	jQuery('.solid_buttons .theme_button a,.solid_buttons .theme_button input').live('mouseover', function() {
			jQuery(this).stop().css({'background-color':theme_options.theme_buttons_color});
		});
		jQuery('.bordered_buttons .theme_button a,.bordered_buttons .theme_button input').live('mouseover', function() {
			if (jQuery(this).attr('data-forced-color')===undefined && jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default" && jQuery(this).attr('data-color')!=="") {
					jQuery(this).css({'background-color':jQuery(this).attr('data-color'),'border-color':jQuery(this).attr('data-color'),'color':theme_options.site_background_color});
			}
			else {
				jQuery(this).css({'background-color':theme_options.active_color,'border-color':theme_options.active_color,'color':theme_options.site_background_color});
			}
		});
		jQuery('.solid_buttons .theme_button a,.solid_buttons .theme_button input').live('mouseout', function() {
			if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default" && jQuery(this).attr('data-color')!=="") {
					jQuery(this).css({'background-color':jQuery(this).attr('data-color')});
			}
			else
			{
				jQuery(this).css({'background-color':theme_options.active_color});
			}
		});
		jQuery('.bordered_buttons .theme_button a,.bordered_buttons .theme_button input').live( 'mouseout', function() {
			if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default" && jQuery(this).attr('data-color')!=="") {
					jQuery(this).css({'background-color':'transparent','color':jQuery(this).attr('data-color'),'border-color':jQuery(this).attr('data-color')});
			}
			else
			{
				jQuery(this).css({'background-color':'transparent','color':theme_options.active_color,'border-color':theme_options.active_color});
			}
		});
    	jQuery('.theme_button_inverted a,.theme_button_inverted input').live('mouseover', function() {
			if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default"  && jQuery(this).attr('data-color')!=="") {
				jQuery(this).css({'background-color':jQuery(this).attr('data-color'),'color':theme_options.site_background_color,'border-color':jQuery(this).attr('data-color')});
			}
			else {
				jQuery(this).css({'background-color':theme_options.active_color,'border-color':theme_options.active_color,'color':theme_options.site_background_color});
			}
		});
		jQuery('.solid_buttons .theme_button_inverted a,.solid_buttons .theme_button_inverted input').live( 'mouseout', function() {
			jQuery(this).css({'background-color':theme_options.theme_buttons_color});
		});
		jQuery('.bordered_buttons .theme_button_inverted a,.bordered_buttons .theme_button_inverted input').live( 'mouseout', function() {
			jQuery(this).css({'background-color':'transparent','color':theme_options.theme_buttons_color,'border-color':theme_options.theme_buttons_color});
		});
		jQuery('#prk_full_folio.featured_color a, #prk_half_folio.featured_color #half-entry-right a').not('#single_folio_sharer a').live('mouseover', function() {
			if (fount_on_mobile===false) {
				jQuery(this).css({'color':theme_options.bd_headings_color});
			}
		});
		jQuery('#prk_half_folio.featured_color #half-entry-right a').not('#single_folio_sharer a').live('mouseout', function() {
			if (fount_on_mobile===false) {
				jQuery(this).css({'color':jQuery('#prk_half_folio.featured_color').attr('data-color')});
			}
		});
		jQuery('#prk_full_folio.featured_color a').not('#single_folio_sharer a').live('mouseout', function() {
			if (fount_on_mobile===false) {
				jQuery(this).css({'color':jQuery('#prk_full_folio.featured_color').attr('data-color')});
			}
		});
		jQuery('.owl-next,.owl-prev').live('mouseover', function() {
			if (fount_on_mobile===false) {
				if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default" && jQuery(this).attr('data-color')!=="") {
					jQuery(this).css({'background-color': jQuery(this).attr('data-color')});
				}
				else {
					jQuery(this).css({'background-color': theme_options.active_color});
				}
			}
		});
		jQuery('.owl-next,.owl-prev').live('mouseout', function() {
			if (fount_on_mobile===false) {
				jQuery(this).css({'background-color': theme_options.buttons_color});
			}
		});
		jQuery('.lone_linker a').live('mouseover', function() {
			if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default" && jQuery(this).attr('data-color')!=="") {
				jQuery(this).css({'background-color': jQuery(this).attr('data-color'),'color':theme_options.site_background_color});
			}
		});
		jQuery('.lone_linker a').live('mouseout', function() {
			if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default" && jQuery(this).attr('data-color')!=="") {
				jQuery(this).css({'color': jQuery(this).attr('data-color'),'background-color':theme_options.site_background_color});
			}
		});
		jQuery('.small_headings_color a,a.zero_color,a.small_headings_color,a.default_color,.sitemap_block.default_color a,.member_lnk>a,.smoothed_anchor a,a.smoothed_anchor').live('mouseover', function() {
			if (fount_on_mobile===false) {
				if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default"  && jQuery(this).attr('data-color')!=="") {
					jQuery(this).css({'color':jQuery(this).attr('data-color')});
				}
				else {
					jQuery(this).css({'color':theme_options.active_color});
				}
				jQuery(this).children('.prk_theme_arrows').addClass('fount_hover_arrow');
			}
		});
		jQuery('.small_headings_color a,a.zero_color,a.small_headings_color,a.default_color,.sitemap_block.default_color a,.member_lnk>a,.smoothed_anchor a,a.smoothed_anchor').live( 'mouseout', function() {
			jQuery(this).css({'color':''});
			jQuery(this).children('.prk_theme_arrows').removeClass('fount_hover_arrow');
		});
		jQuery('#fount_left,#fount_right,#fount_close,.fount_left_folio,.fount_right_folio,.fount_close_folio').live('mouseover', function() {
			if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default") {
				jQuery(this).css({'color':jQuery(this).attr('data-color')});
				jQuery(this).find('.inner_mover').css({'color':jQuery(this).attr('data-color')});
			}
		});
		jQuery('#fount_left,#fount_right,#fount_close,.fount_left_folio,.fount_right_folio,.fount_close_folio').live('mouseout', function() {
			jQuery(this).css({'color':''});
			jQuery(this).find('.inner_mover').css({'color':''});
		});
		jQuery('#fount_left,#fount_right,#fount_close,.fount_left_folio,.fount_right_folio,.fount_close_folio')
		jQuery('.prk_service').live('mouseover', function() {
			if (jQuery(this).attr('data-color')!=="default") {
				jQuery(this).find('.colored_link_icon').css({'color':jQuery(this).attr('data-color')});
			}
		});
		jQuery('.prk_service').live( 'mouseout', function() {
			if (jQuery(this).attr('data-default')!=="default") {
				jQuery(this).find('.colored_link_icon').css({'color':jQuery(this).attr('data-default')});
			}
			else {
				jQuery(this).find('.colored_link_icon').css({'color':''});
			}
		});
		jQuery('.pf_load_more,.portfolio_entry_li,.blog_hover,.simple_scale,.simple_fade').hover(function() {
			if (fount_on_mobile===false) {
				jQuery(this).addClass('hover_trigger');
			}
		},
		function() {
			if (fount_on_mobile===false) {
				jQuery(this).removeClass('hover_trigger');
			}
		});
		jQuery('.fount_recent_ul.thumbnail_lay .img_blogger').hover(function() {
			if (fount_on_mobile===false) {
				jQuery(this).stop().animate({
					opacity:0.55
				},250);
			}
		},
		function() {
			if (fount_on_mobile===false) {
				jQuery(this).stop().animate({
					opacity:1
				},250);
			}
		});
    }
    function go_hash(timing,closed_folio) {
    	var offsetter="";
    	//TRY TO MOVE TO PORTFOLIO IF NEEDED AND POSSIBLE
    	if (closed_folio) {
    		var $target = jQuery('.fount_row:has(#folio_father)');
		    if (target!=="") {
				//IS IT AN EXISITNG ID
			    if ($target.offset()!==undefined) {
			    	offsetter=$target.offset().top;
			    }
			    else {
					//event.preventDefault();
			    }
			}
    	}
    	else {
    		if (window.location.hash==="#" || window.location.hash==="") {
				offsetter=0;
				target="";
			}
			else {
				var target = window.location.hash;
				var $target = jQuery(target);
					//IS IT AN ANCHOR LINK
				    if (target!=="") {
						//IS IT AN EXISITNG ID
				    if ($target.offset()!==undefined) {
				    	offsetter=$target.offset().top;
				    }
				    else {
						//event.preventDefault();
				    }
				}
			}
    	}
	    if (offsetter!=="") {
	   		var adjuster=-2;
	   		if (!jQuery('body').hasClass('menu_at_top')) {
	   			adjuster=parseInt(rows_offset,10);
	   		}
	   		jQuery('#prk_responsive_menu').addClass('fount_shown_menu');
		    jQuery('html, body').stop().animate({
		        'scrollTop': offsetter-adjuster+4
		    }, timing, 'swing', function () {
		    	jQuery('#prk_responsive_menu').removeClass('fount_shown_menu');
		    	setTimeout(function() {
					jQuery('#prk_responsive_menu').removeClass('fount_hidden_menu');
				},15);
				//CLEAR HASHTAGS FROM URL IF NEEDED
				var fragment=window.location.href.split('#');
				if(fragment[1]!==undefined) {
					if (history.pushState) {
					    history.pushState(null, null, fragment[0]);
					}
					else {
					    location.hash = fragment[0];
					}
				}
		    });
		}
    }
    //ANIMATED HEADLINES FUNCTIONS
    //set animation timing
    var animationDelay = 2500,
    	//loading bar effect
    	barAnimationDelay = 3800,
    	barWaiting = barAnimationDelay - 3000, //3000 is the duration of the transition on the loading bar - set in the scss/css file
    	//letters effect
    	lettersDelay = 50,
    	//type effect
    	typeLettersDelay = 150,
    	selectionDuration = 500,
    	typeAnimationDelay = selectionDuration + 800,
    	//clip effect 
    	revealDuration = 600,
    	revealAnimationDelay = 1500;

    function initHeadline() {
    	jQuery('.prk_text_rotator').each(function() {
    		var $thisi=jQuery(this);
	    	//insert <i> element for each letter of a changing word
	    	singleLetters($thisi.find('.cd-headline.letters').find('b'));
	    	//initialise headline animation
	    	animateHeadline($thisi.find('.cd-headline'));
	    });
    }

    function singleLetters($words) {
    	$words.each(function(){
    		var word = jQuery(this),
    			letters = word.text().split(''),
    			selected = word.hasClass('is-visible');
    			var i="";
    		for (i in letters) {
    			//if(word.parents('.rotate-2').length > 0) letters[i] = '<em>' + letters[i] + '</em>';
    			if (letters[i]===" ") {

    				letters[i] = (selected) ? '<i class="in hidenize">i</i>': '<i class="hidenize">i</i>';
    			}
    			else {
    				letters[i] = (selected) ? '<i class="in">' + letters[i] + '</i>': '<i>' + letters[i] + '</i>';
    			}
    		}
    	    var newLetters = letters.join('');
    	    word.html(newLetters);
    	});
    }

    function animateHeadline($headlines) {
    	var duration = animationDelay;
    	$headlines.each(function(){
    		var headline = jQuery(this);
    		
    		if(headline.hasClass('loading-bar')) {
    			duration = barAnimationDelay;
    			setTimeout(function(){ headline.find('.cd-words-wrapper').addClass('is-loading') }, barWaiting);
    		} else if (headline.hasClass('clip')){
    			var spanWrapper = headline.find('.cd-words-wrapper'),
    				newWidth = spanWrapper.width() + 10
    			spanWrapper.css('width', newWidth);
    		} else if (!headline.hasClass('type') ) {
    			//assign to .cd-words-wrapper the width of its longest word
    			var words = headline.find('.cd-words-wrapper b'),
    				width = 0;
    			words.each(function(){
    				var wordWidth = jQuery(this).width();
    			    if (wordWidth > width) width = wordWidth;
    			});
    			headline.find('.cd-words-wrapper').css('width', width);
    		};

    		//trigger animation
    		setTimeout(function(){ hideWord( headline.find('.is-visible').eq(0) ) }, duration);
    	});
    }

    function hideWord($word) {
    	var nextWord = takeNext($word);
    	
    	if($word.parents('.cd-headline').hasClass('type')) {
    		var parentSpan = $word.parent('.cd-words-wrapper');
    		parentSpan.addClass('selected').removeClass('waiting');	
    		setTimeout(function(){ 
    			parentSpan.removeClass('selected'); 
    			$word.removeClass('is-visible').addClass('is-hidden').children('i').removeClass('in').addClass('out');
    		}, selectionDuration);
    		setTimeout(function(){ showWord(nextWord, typeLettersDelay) }, typeAnimationDelay);
    	
    	} else if($word.parents('.cd-headline').hasClass('letters')) {
    		var bool = ($word.children('i').length >= nextWord.children('i').length) ? true : false;
    		hideLetter($word.find('i').eq(0), $word, bool, lettersDelay);
    		showLetter(nextWord.find('i').eq(0), nextWord, bool, lettersDelay);

    	}  else if($word.parents('.cd-headline').hasClass('clip')) {
    		$word.parents('.cd-words-wrapper').animate({ width : '2px' }, revealDuration, function(){
    			switchWord($word, nextWord);
    			showWord(nextWord);
    		});

    	} else if ($word.parents('.cd-headline').hasClass('loading-bar')){
    		$word.parents('.cd-words-wrapper').removeClass('is-loading');
    		switchWord($word, nextWord);
    		setTimeout(function(){ hideWord(nextWord) }, barAnimationDelay);
    		setTimeout(function(){ $word.parents('.cd-words-wrapper').addClass('is-loading') }, barWaiting);

    	} else {
    		switchWord($word, nextWord);
    		setTimeout(function(){ hideWord(nextWord) }, animationDelay);
    	}
    }

    function showWord($word, $duration) {
    	if($word.parents('.cd-headline').hasClass('type')) {
    		showLetter($word.find('i').eq(0), $word, false, $duration);
    		$word.addClass('is-visible').removeClass('is-hidden');

    	}  else if($word.parents('.cd-headline').hasClass('clip')) {
    		$word.parents('.cd-words-wrapper').animate({ 'width' : $word.width() + 10 }, revealDuration, function(){ 
    			setTimeout(function(){ hideWord($word) }, revealAnimationDelay); 
    		});
    	}
    }

    function hideLetter($letter, $word, $bool, $duration) {
    	$letter.removeClass('in').addClass('out');
    	
    	if(!$letter.is(':last-child')) {
    	 	setTimeout(function(){ hideLetter($letter.next(), $word, $bool, $duration); }, $duration);  
    	} else if($bool) { 
    	 	setTimeout(function(){ hideWord(takeNext($word)) }, animationDelay);
    	}

    	if($letter.is(':last-child') && jQuery('html').hasClass('no-csstransitions')) {
    		var nextWord = takeNext($word);
    		switchWord($word, nextWord);
    	} 
    }

    function showLetter($letter, $word, $bool, $duration) {
    	$letter.addClass('in').removeClass('out');
    	
    	if(!$letter.is(':last-child')) { 
    		setTimeout(function(){ showLetter($letter.next(), $word, $bool, $duration); }, $duration); 
    	} else { 
    		if($word.parents('.cd-headline').hasClass('type')) { setTimeout(function(){ $word.parents('.cd-words-wrapper').addClass('waiting'); }, 200);}
    		if(!$bool) { setTimeout(function(){ hideWord($word) }, animationDelay) }
    	}
    }

    function takeNext($word) {
    	return (!$word.is(':last-child')) ? $word.next() : $word.parent().children().eq(0);
    }

    function takePrev($word) {
    	return (!$word.is(':first-child')) ? $word.prev() : $word.parent().children().last();
    }

    function switchWord($oldWord, $newWord) {
    	$oldWord.removeClass('is-visible').addClass('is-hidden');
    	$newWord.removeClass('is-hidden').addClass('is-visible');
    }
    //END ANIMATED HEADLINES FUNCTIONS
	function ended_loading(folio_flag) {
		setTimeout(function(){
			if (!jQuery('#classic_blog_section,.masonry_blog,#centered_blog_section').length) {
				NProgress.done();
			}
			jQuery(window).trigger("debouncedresize");
		},100);
		jQuery('#nprogress .spinner').addClass('prk_tweaked');
		if (jQuery('#not_slider').length) {
			jQuery('#not_slider').fitVids();
			jQuery('#not_slider').find('.lazyOwl').each(function() {
				jQuery(this).attr('src',jQuery(this).attr('data-src'));
			});
			var img_load=imagesLoaded('#not_slider');
			img_load.on('always', function() {
				jQuery('#single_spinner.spinner-icon').removeClass('prk_first_anim');
			});
		}
		jQuery('.fount_shortcode_slider.super_height.per_init').each(function() {
			var $this_slider=jQuery(this);
			$this_slider.removeClass('per_init');
			$this_slider.addClass('just_init');
			jQuery(window).on("debouncedresize", function( event ) {
				setTimeout(function(){
					if (jQuery('body').hasClass('menu_at_top')) {
						$this_slider.find('.owl-wrapper-outer,.owl-item').css({'height':height_fix-(jQuery('#prk_logos').height())});
					}
					else {
						$this_slider.find('.owl-wrapper-outer,.owl-item').css({'height':height_fix-(parseInt(jQuery('#prk_ajax_container').css('padding-top'),10))+2});
					}
					var min_width=jQuery(window).width();
					var min_height=height_fix-(parseInt(jQuery('#prk_ajax_container').css('padding-top'),10))+2;
					$this_slider.find('.owl-item img.fount_vsbl').each(function() {
						var $this_image=jQuery(this);
						var or_width=parseInt($this_image.attr('data-or_w'),10); 
						var or_height=parseInt($this_image.attr('data-or_h'),10);
						var ratio=min_height / or_height;
						//FILL HEIGHT
						$this_image.css("height", min_height);  
						$this_image.css("width", or_width * ratio);
						//UPDATE VARS
						or_width=$this_image.width(); 
						or_height=$this_image.height(); 
						//FILL WIDTH IF NEEDED
						if(or_width<min_width) {
							ratio=min_width/or_width;
							$this_image.css("width", min_width);
							$this_image.css("height", or_height * ratio);
						}
						//ADJUST MARGINS
						$this_image.css({"margin-left":-($this_image.width()-min_width)/2});
						if (jQuery(window).width()<780) {
							$this_image.css("margin-top",0);
						}
						else {
							$this_image.css("margin-top",-($this_image.height()-$this_slider.find('.owl-wrapper-outer').height())/2);
						}
					});
					$this_slider.find('.sld_v_center').each(function() {
						jQuery(this).css({'margin-top':-parseInt(jQuery(this).height()/2,10)});
					});
				},50); 
			});
			if ($this_slider.find('.item').length>1 && $this_slider.attr('data-autoplay') === "true") {
				var autoplayer=$this_slider.attr('data-delay');
				if (fount_on_mobile && theme_options.autoplay_enable!=="1") {
					autoplayer=false;
				}
			}
			else {
				var autoplayer=false;
			}
			$this_slider.fitVids().owlCarousel({
				autoPlay:autoplayer,
				navigation : $this_slider.attr('data-navigation') === "true" ? true : false,
				navigationText:	['<i class="icon-left-open-big"></i>','<i class="icon-right-open-big"></i>'],
				pagination:$this_slider.attr('data-pagination') === "true" ? true : false,
				slideSpeed : 300,
				paginationSpeed : 400,
				items : 1,
				lazyLoad : true,
       			itemsDesktop : false,
                itemsDesktopSmall : false,
                itemsTablet: false,
                itemsMobile : false,
				itemsScaleUp:true,
				transitionStyle : "fade",
				touchDrag:$this_slider.attr('data-touch') === "true" ? true : false,
				addClassActive:true,
				afterInit: function(){
					setTimeout(function() {
						singleLetters($this_slider.find('.cd-headline.letters').find('b'));
						animateHeadline($this_slider.find('.cd-headline'));
						setTimeout(function() {
							$this_slider.find('.sld_v_center').each(function() {
								jQuery(this).css({'margin-top':-parseInt(jQuery(this).height()/2,10)});
							});
						},10);
						//LOAD ALL OTHER IMAGES NOW
						$this_slider.find('.lazyOwl').each(function() {
							jQuery(this).attr('src',jQuery(this).attr('data-src'));
							jQuery(this).css({'display':'block'});
						});
					},750);
					$this_slider.find('.owl-pagination').css({'margin-top':-$this_slider.find('.owl-pagination').height()/2});
					jQuery(window).trigger("debouncedresize");
				},
				afterAction : function() {
					$this_slider.find('.headings_top,.headings_body,.slider_action_button').removeClass('fount_animate_slide');
					var slide_id='#fount_slide_'+this.owl.currentItem+'';
					if ($this_slider.hasClass('just_init')) {
						var in_count=750;
						$this_slider.removeClass('just_init');
					}
					else {
						var in_count=0;
					}
					setTimeout(function() {
						if ($this_slider.find(slide_id).find('.slider_action_button a').attr('data-color')!=="default") {
							if (jQuery('#fount_wrapper').hasClass('solid_buttons')) {
								$this_slider.find(slide_id).find('.slider_action_button a').css({'background-color':$this_slider.find(slide_id).find('.slider_action_button a').attr('data-color')});
							}
							else {
								$this_slider.find(slide_id).find('.slider_action_button a').css({'border-color':$this_slider.find(slide_id).find('.slider_action_button a').attr('data-color'),'color':$this_slider.find(slide_id).find('.slider_action_button a').attr('data-color')});
							}
						}
						if ($this_slider.find(slide_id).find('.slider_scroll_button a').attr('data-color')!=="default") {
							if (jQuery('#fount_wrapper').hasClass('solid_buttons')) {
								$this_slider.find(slide_id).find('.slider_scroll_button a').css({'background-color':$this_slider.find(slide_id).find('.slider_scroll_button a').attr('data-color')});
							}
							else {
								$this_slider.find(slide_id).find('.slider_scroll_button a').css({'border-color':$this_slider.find(slide_id).find('.slider_scroll_button a').attr('data-color'),'color':$this_slider.find(slide_id).find('.slider_scroll_button a').attr('data-color')});
							}
						}
						$this_slider.find(slide_id).find('.headings_top').addClass('fount_animate_slide');
						$this_slider.find(slide_id).find('.headings_body').addClass('fount_animate_slide');
						$this_slider.find(slide_id).find('.slider_action_button').addClass('fount_animate_slide');
					},in_count);
				}
		    });
		});
		jQuery('.fount_shortcode_slider.per_init').not(jQuery('.fount_shortcode_slider.super_height')).each(function() {
			var $this_slider=jQuery(this);
			if ($this_slider.find('.item').length===0) {
				$this_slider.removeClass('per_init');
			}
			else {
				if ($this_slider.find('.item').length>1 && $this_slider.attr('data-autoplay') === "true") {
					var autoplayer=$this_slider.attr('data-delay');
					if (fount_on_mobile && theme_options.autoplay_enable!=="1") {
						autoplayer=false;
					}
				}
				else {
					var autoplayer=false;
				}
				$this_slider.fitVids().owlCarousel({
					autoPlay:autoplayer,
					navigation : $this_slider.attr('data-navigation') === "true" ? true : false,
					navigationText:	['<i class="icon-left-open-big"></i>','<i class="icon-right-open-big"></i>'],
					pagination:$this_slider.attr('data-pagination') === "true" ? true : false,
					slideSpeed : 300,
					paginationSpeed : 400,
					items : 1, 
	       			itemsDesktop : false,
	                itemsDesktopSmall : false,
	                lazyLoad : true,
	                itemsTablet: false,
	                itemsMobile : false,
					itemsScaleUp:true,
					transitionStyle : "fade",
					autoHeight : true,
					touchDrag:$this_slider.attr('data-touch') === "true" ? true : false,
					addClassActive:true,
					afterInit: function() {
						$this_slider.removeClass('per_init');
						$this_slider.addClass('just_init');
						setTimeout(function() {
							singleLetters($this_slider.find('.cd-headline.letters').find('b'));
							animateHeadline($this_slider.find('.cd-headline'));
							setTimeout(function() {
								$this_slider.find('.sld_v_center').each(function() {
									jQuery(this).css({'margin-top':-parseInt(jQuery(this).height()/2,10)});
								});
							},10);
							//LOAD ALL OTHER IMAGES NOW
							$this_slider.find('.lazyOwl').each(function() {
								jQuery(this).attr('src',jQuery(this).attr('data-src'));
								jQuery(this).css({'display':'block'});
							});
						},750);
						$this_slider.find('.owl-pagination').css({'margin-top':-$this_slider.find('.owl-pagination').height()/2});
						if ($this_slider.attr('data-color')!=undefined && $this_slider.attr('data-color')!="") {
							$this_slider.find('.owl-next,.owl-prev').attr('data-color',$this_slider.attr('data-color'));
						}
						setTimeout(function() {
							$this_slider.parent().removeClass('prk_first_anim');
							jQuery('#single_spinner.spinner-icon').removeClass('prk_first_anim');
						},1000);
					},
					afterAction : function() {
						$this_slider.find('.headings_top,.headings_body,.slider_action_button').removeClass('fount_animate_slide');
						var slide_id='#fount_slide_'+this.owl.currentItem+'';
						if ($this_slider.hasClass('just_init')) {
							var in_count=750;
							$this_slider.removeClass('just_init');
						}
						else {
							var in_count=0;
						}
						setTimeout(function() {
							$this_slider.find(slide_id).find('.headings_top').addClass('fount_animate_slide');
							$this_slider.find(slide_id).find('.headings_body').addClass('fount_animate_slide');
							$this_slider.find(slide_id).find('.slider_action_button').addClass('fount_animate_slide');
						},in_count);
					}
		    	});
			}
			
		});
		jQuery('.testimonials_slider.per_init,.comments_slider.per_init').each(function() {
			var $this_slider=jQuery(this);
			$this_slider.removeClass('per_init');
			if ($this_slider.find('.item').length>1 && $this_slider.attr('data-autoplay') === "true") {
				var autoplayer=$this_slider.attr('data-delay');
				if (fount_on_mobile && theme_options.autoplay_enable!=="1") {
					autoplayer=false;
				}
			}
			else {
				var autoplayer=false;
			}
			$this_slider.owlCarousel({
				autoPlay:autoplayer,
				navigation : $this_slider.attr('data-navigation') === "true" ? true : false,
				navigationText:	['<i class="icon-left-open-big"></i>','<i class="icon-right-open-big"></i>'],
				pagination:$this_slider.attr('data-pagination') === "true" ? true : false,
				slideSpeed : 300,
				paginationSpeed : 400,
				items : 1, 
       			itemsDesktop : false,
                itemsDesktopSmall : false,
                itemsTablet: false,
                itemsMobile : false,
				itemsScaleUp:true,
				transitionStyle : "fade",
				autoHeight : true,
				touchDrag:$this_slider.attr('data-touch') === "true" ? true : false,
				addClassActive:true,
				afterInit: function() {
					setTimeout(function() {
						$this_slider.parent().removeClass('prk_first_anim');
						jQuery('#single_spinner.spinner-icon').removeClass('prk_first_anim');
					},1000);
				},
	    	});
		});
		jQuery('.recentposts_ul_slider,.member_ul_slider').each(function() {
			var $this_slider=jQuery(this);
			$this_slider.removeClass('per_init');
			  $this_slider.owlCarousel({
				navigation : $this_slider.attr('data-navigation') === "true" ? true : false,
				navigationText:	['<i class="fount_fa-chevron-left"></i>','<i class="fount_fa-chevron-right"></i>'],
				pagination:false,
				touchDrag:$this_slider.attr('data-touch') === "true" ? true : false,
				itemsCustom : [
					[0, 1],
					[450, 2],
					[920, 3],
					[1280, 4],
				],
			});
		});
		jQuery('.products_ul_slider').each(function() {
			var $this_slider=jQuery(this);
			$this_slider.removeClass('per_init');
			  $this_slider.owlCarousel({
				navigation : $this_slider.attr('data-navigation') === "true" ? true : false,
				navigationText:	['<i class="fount_fa-chevron-left"></i>','<i class="fount_fa-chevron-right"></i>'],
				pagination:false,
				touchDrag:$this_slider.attr('data-touch') === "true" ? true : false,
				itemsCustom : [
					[0, 1],
					[400, 2],
					[660, 3],
					[920, 4],
				],
			});
		});
		jQuery('.twitter_slider.per_init').each(function() {
			var $this_slider=jQuery(this);
			$this_slider.removeClass('per_init');
			if (!fount_on_mobile) {
				var autoplayer=true;
			}
			else {
				var autoplayer=false;
			} 
			$this_slider.flexslider({
				animation: "fade",
				useCSS  :false,        
				slideshow: autoplayer,    
				slideshowSpeed: 5000,    
				animationDuration: 300, 
				smoothHeight: true,
				directionNav: true,   
				controlNav: false,   
				keyboardNav: false,
				touchDrag:false,
				prevText: '<i class="fount_fa-chevron-left prk_less_opacity"></i>',
				nextText: '<i class="fount_fa-chevron-right prk_less_opacity"></i>',
				start:function (slider) {
					slider.css({'min-height':0});
					jQuery(window).trigger("debouncedresize");
				}
			});
		});
		jQuery('.folio_masonry.lightboxed,.fount_widget_gallery').magnificPopup({
			delegate: 'a',
			src:'data-src',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			fixedContentPos: false,
			fixedBgPos: true,
			closeOnContentClick: true,
			closeBtnInside: false,
			mainClass: 'mfp-no-margins my-mfp-zoom-in header_font',
			removalDelay: 300,
			closeMarkup:'<button title="%title%" class="mfp-close"><div class="mfp-close_inner"></div></button>',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir% fount_fa-angle-%dir%"></button>',
				preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
				titleSrc: function(item) {
					return item.el.attr('title');
				}
			},
			iframe: {
		     markup: '<div class="mfp-iframe-scaler">'+
                '<div class="mfp-close"></div>'+
                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                '<div class="mfp-title">Some caption</div>'+
              '</div>'
		  	},
			callbacks: {
				open: function() {
				scrollbar_width=window.innerWidth-jQuery("body").width();
				jQuery('html').css({'overflow':'hidden'});
				},
				close: function() {
					jQuery('html').css({'overflow-y':'visible'});
				},
				markupParse: function(template, values, item) {
					values.title = item.el.attr('data-title');
		    	} 
			}
		});
		jQuery('.fount_gallery,.fount_cpts.lightboxed').not('.fount_gallery.fount_no_link').each(function(){
			jQuery(this).magnificPopup({
				delegate: 'div.portfolio_entry_li',
				src:'data-src',
				type: 'image',
				tLoading: 'Loading image #%curr%...',
				fixedContentPos: false,
				fixedBgPos: true,
				closeOnContentClick: true,
				closeBtnInside: false,
				mainClass: 'mfp-no-margins my-mfp-zoom-in header_font',
				removalDelay: 300,
				closeMarkup:'<button title="%title%" class="mfp-close"><div class="mfp-close_inner"></div></button>',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir% fount_fa-angle-%dir%"></button>',
					preload: [0,1] // Will preload 0 - before current, and 1 after the current image
				},
				image: {
					tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
					titleSrc: function(item) {
						return item.el.attr('title');
					}
				},
				iframe: {
			     markup: '<div class="mfp-iframe-scaler">'+
	                '<div class="mfp-close"></div>'+
	                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
	                '<div class="mfp-title">Some caption</div>'+
	              '</div>'
			  	},
				callbacks: {
					open: function() {
					scrollbar_width=window.innerWidth-jQuery("body").width();
					jQuery('html').css({'overflow':'hidden'});
					},
					close: function() {
						jQuery('html').css({'overflow-y':'visible'});
					},
					markupParse: function(template, values, item) {
						values.title = item.el.attr('data-title');
			    	} 
				}
			});
		});
		jQuery('.recentfolio_ul_wp,.fount_shortcode_slider').magnificPopup({
			delegate: 'a.lone_link',
			src:'data-src',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			fixedContentPos: false,
			fixedBgPos: true,
			closeOnContentClick: true,
			closeBtnInside: false,
			mainClass: 'mfp-no-margins my-mfp-zoom-in header_font',
			removalDelay: 300,
			closeMarkup:'<button title="%title%" class="mfp-close"><div class="mfp-close_inner"></div></button>',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir% fount_fa-angle-%dir%"></button>',
				preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			},
			iframe: {
		     markup: '<div class="mfp-iframe-scaler">'+
                '<div class="mfp-close"></div>'+
                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                '<div class="mfp-title">Some caption</div>'+
              '</div>'
		  	},
			callbacks: {
				open: function() {
				scrollbar_width=window.innerWidth-jQuery("body").width();
				jQuery('html').css({'overflow':'hidden'});
				},
				close: function() {
					jQuery('html').css({'overflow-y':'visible'});
				},
				markupParse: function(template, values, item) {
					values.title = item.el.attr('data-title');
		    	} 
			}
		});
		//jQuery('.wpb_single_image a.magnificent').addClass('boxed_shadow');
		jQuery('.wpb_single_image a.magnificent').magnificPopup({
			type: 'image',
			fixedContentPos: false,
			fixedBgPos: true,
			closeOnContentClick: true,
			closeBtnInside: false,
			mainClass: 'mfp-no-margins my-mfp-zoom-in header_font',
			removalDelay: 300,
			closeMarkup:'<button title="%title%" class="mfp-close"><div class="mfp-close_inner"></div></button>',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir% seven_fa-angle-%dir%"></button>',
				preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
				titleSrc: function(item) {
					return item.el.attr('title');
				}
			},
			iframe: {
		     markup: '<div class="mfp-iframe-scaler">'+
                '<div class="mfp-close"></div>'+
                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                '<div class="mfp-title">Some caption</div>'+
              '</div>'
		  	},
			callbacks: {
				open: function() {
				scrollbar_width=window.innerWidth-jQuery("body").width();
				jQuery('html').css({'overflow':'hidden'});
				},
				close: function() {
					jQuery('html').css({'overflow-y':'visible'});
				},
				markupParse: function(template, values, item) {
					values.title = item.el.attr('data-title');
		    	} 
			}
		});
		//WOOCOMMERCE
		jQuery('.woocommerce .woocommerce-ordering .orderby,.woocommerce #calc_shipping_country,.fount_custom_select').selectOrDie({
	        onChange: function(){

	        }
		});
		//BACKGROUND VIDEOS HIDE
		jQuery('.fount_with_video').each(function() {
			if (fount_on_mobile) {
				var $vid_remover=jQuery(this);
				$vid_remover.css("background-image", "url("+$vid_remover.children('.fount_video-bg').attr('poster')+")");
				$vid_remover.children('.fount_video-bg').remove(); 
			}
		});
		jQuery("#single_blog_content,#sidebar,#full-entry-right,#prk_full_folio").addClass('prk_first_anim');
		setTimeout(function() {
			jQuery("#prk_full_size_single,#prk_half_size_single,#after_single_folio").addClass('prk_first_anim');
		},400);
		//SIDEBAR STUFF
		jQuery('#footer_in a,#sidebar a').not('a.button,.pirenko_social a,#footer_in .pirenko_recent_posts a,#sidebar .pirenko_recent_posts a,.product_list_widget a').addClass('default_color'); 
		jQuery('#footer_in .pirenko_recent_posts a,#sidebar .pirenko_recent_posts a').addClass('zero_color'); 
		
		//COUNTDOWN ELEMENTS
		jQuery('.fount_countdown').each(function() {
			var $countas=jQuery(this);
			var custom_date = new Date(); 
			custom_date = new Date($countas.attr('data-year'), parseInt($countas.attr('data-month'),10)-1, $countas.attr('data-day')); 
			$countas.countdown({
			    until: custom_date
			});
		});

		//MAP FUNCTIONS
        function init_map() {
        	jQuery('.google_maps').each(function() {
        		var $this_map=jQuery(this);
	        	if ($this_map.attr('data-type')===undefined || $this_map.attr('data-type')==="") {
	        		$this_map.attr('data-type',"roadmap");
	        	}
	        	if ($this_map.attr('data-style')==='subtle_grayscale') {
		            var mapOptions = {
		                zoom: parseInt($this_map.attr('data-zoom'),10),
		                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
		                styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]/**/},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]/**/},{featureType:"water",elementType:"labels",stylers:[{visibility:"on"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}],
		            	scrollwheel: false,
		            	mapTypeId: $this_map.attr('data-type')
		            };
		        }
		        else if ($this_map.attr('data-style')==='almost_gray') {
		            var mapOptions = {
		                zoom: parseInt($this_map.attr('data-zoom'),10),
		                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
		                styles: [{"stylers":[{"saturation":-100},{"gamma":1}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"saturation":50},{"gamma":0},{"hue":"#50a5d1"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"weight":0.5},{"color":"#333333"}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"gamma":1},{"saturation":50}]}],
		            	scrollwheel: false,
		            	mapTypeId: $this_map.attr('data-type')
		            };
		        }
		        else if ($this_map.attr('data-style')==='cobalt') {
		            var mapOptions = {
		                zoom: parseInt($this_map.attr('data-zoom'),10),
		                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
		                styles: [{"featureType":"all","elementType":"all","stylers":[{"invert_lightness":true},{"saturation":10},{"lightness":30},{"gamma":0.5},{"hue":"#435158"}]}],
		            	scrollwheel: false,
		            	mapTypeId: $this_map.attr('data-type')
		            };
		        }
		        else if ($this_map.attr('data-style')==='midnight') {
		            var mapOptions = {
		                zoom: parseInt($this_map.attr('data-zoom'),10),
		                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
		                styles: [{"featureType":"water","stylers":[{"color":"#021019"}]},{"featureType":"landscape","stylers":[{"color":"#08304b"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#0c4152"},{"lightness":5}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#0b434f"},{"lightness":25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#0b3d51"},{"lightness":16}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#000000"},{"lightness":13}]},{"featureType":"transit","stylers":[{"color":"#146474"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#144b53"},{"lightness":14},{"weight":1.4}]}],
		            	scrollwheel: false,
		            	mapTypeId: $this_map.attr('data-type')
		            };
		        }
		        else if ($this_map.attr('data-style')==='old_timey') {
		            var mapOptions = {
		                zoom: parseInt($this_map.attr('data-zoom'),10),
		                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
		                styles: [{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"simplified"}]},{"featureType":"road","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"visibility":"off"}]},{"featureType":"road.local","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"water","stylers":[{"color":"#84afa3"},{"lightness":52}]},{"stylers":[{"saturation":-77}]},{"featureType":"road"}],
		            	scrollwheel: false,
		            	mapTypeId: $this_map.attr('data-type')
		            };
		        }
		        else if ($this_map.attr('data-style')==='green') {
		            var mapOptions = {
		                zoom: parseInt($this_map.attr('data-zoom'),10),
		                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
		                styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#333739"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2ecc71"}]},{"featureType":"poi","stylers":[{"color":"#2ecc71"},{"lightness":-7}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#2ecc71"},{"lightness":-28}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#2ecc71"},{"visibility":"on"},{"lightness":-15}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#2ecc71"},{"lightness":-18}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#2ecc71"},{"lightness":-34}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#333739"},{"weight":0.8}]},{"featureType":"poi.park","stylers":[{"color":"#2ecc71"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#333739"},{"weight":0.3},{"lightness":10}]}],
		            	scrollwheel: false,
		            	mapTypeId: $this_map.attr('data-type')
		            };
		        }
		        else {
		        	var mapOptions = {
		                zoom: parseInt($this_map.attr('data-zoom'),10),
		                center: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
		           		scrollwheel: false,
		            	mapTypeId: $this_map.attr('data-type')
		            };
		        }
	        	var mapElement = document.getElementById($this_map.attr('id'));
	            var map = new google.maps.Map(mapElement, mapOptions);
	            google.maps.event.addListenerOnce(map, 'idle', function() { });
	            if ($this_map.attr('data-marker_image_lat')!="" && $this_map.attr('data-marker_image_long')!=""){
		            var marker = new google.maps.Marker({
		                  position: new google.maps.LatLng($this_map.attr('data-marker_image_lat'), $this_map.attr('data-marker_image_long')),
		                  map: map,
		                  icon: $this_map.attr('data-marker'),
		                  size: new google.maps.Size(40,52),
		                  clickable: false,
		              });
		        }
		        else {
		        	var marker = new google.maps.Marker({
		                  position: new google.maps.LatLng($this_map.attr('data-lat'), $this_map.attr('data-long')),
		                  map: map,
		                  icon: $this_map.attr('data-marker'),
		                  size: new google.maps.Size(40,52),
		                  clickable: false,
		              });
		        }
		    });
        }
        if (jQuery('.google_maps').length){
        	init_map();
        	pirenko_resize();
    	}
    	jQuery('.fount_maps').click(function () {
		    jQuery('.fount_maps iframe').css("pointer-events", "auto");
		});
		jQuery('.fount_maps').hover(function() {
		},
		function() {
			jQuery('.fount_maps iframe').css("pointer-events", "none");
		});
    	//MAILCHIMP, CONTACT FORM 7 && PROTECTED PAGES
		jQuery('#prk_protected input,.mc_input,.wpcf7-form input[type="password"],.wpcf7-form input[type="tel"],.wpcf7-form input[type="email"],.wpcf7-form input[type="text"],.wpcf7-form textarea').not('.wpcf7-submit').addClass('pirenko_highlighted');
		jQuery('.mc_form_inside').addClass('clearfix');
		jQuery('.mc_signup_submit').addClass('theme_button small clearfix');
		jQuery('.mc_signup_submit>input').removeClass('button');
		jQuery('#prk_footer .mc_signup_submit input,#prk_footer .mc4wp-form-fields .theme_button input').attr('data-color',theme_options.titles_color_footer);
		jQuery('#prk_hidden_bar .mc_signup_submit input,#prk_hidden_bar .mc4wp-form-fields .theme_button input').attr('data-color',theme_options.active_color_right_bar);
		jQuery('#prk_footer .mc_signup_submit input,#prk_footer .mc4wp-form-fields .theme_button input').attr('data-forced-color','true');
		jQuery('#prk_hidden_bar .mc_signup_submit input,#prk_hidden_bar .mc4wp-form-fields .theme_button input').attr('data-forced-color','true');
		jQuery('.wpcf7-submit').parent().addClass('theme_button');
    	//FORMS MANAGEMENT
    	//FORCE TEXTFIELDS BLUR
		jQuery('.pirenko_highlighted,.pk_contact_highlighted').blur(function() {
			jQuery(this).css({'border':'','outline':'none','color':'','background-color':''});
		});
		jQuery('.pirenko_highlighted,.pk_contact_highlighted').not('#footer_in .pirenko_highlighted').focus(function (){
			if (jQuery(this).attr('data-color')!=undefined && jQuery(this).attr('data-color')!="") {
				jQuery(this).css({'border':'1px solid '+hex2rgb(jQuery(this).attr('data-color'),0.65)+'','color':jQuery(this).attr('data-color'),'background-color':hex2rgb(jQuery(this).attr('data-color'),0.1)});
			}
		});
		//EMAIL SEND FEATURE
		jQuery('#submit_message_div a').click(function(e) {
			e.preventDefault();
			//REMOVE PREVIOUS ERRORS IF THEY EXIST
			jQuery("#contact-form .contact_error").remove();
	    
			//ADD THE TEMPLATE NAME TO THE SUBJECT
			var helper=jQuery('#c_subject').attr('value');
			jQuery('#full_subject').attr('value',jQuery('#contact-form').attr('data-name')+' - '+helper);
			var empty_text_error=jQuery('#contact-form').attr('data-empty');
			var invalid_email_error=jQuery('#contact-form').attr('data-invalid');
			var value, theID, error, emailReg;
			error = false;
	        emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;				
			//DATA VALIDATION
			jQuery('#c_name, #c_email, #c_message').each(function()
	        {
				value = jQuery(this).val();
	            theID = jQuery(this).attr('id');
	            if(value === '' || value=== jQuery(this).attr('data-original'))
	            {
	                if (theID === 'c_message') {
	                    jQuery(this).after('<p class="contact_error fount_italic prk_heavier_600 header_font at_messa">'+empty_text_error+'</p>');
	                }
	                else {
						jQuery(this).after('<p class="contact_error fount_italic prk_heavier_600 header_font">'+empty_text_error+'</p>');
					}
	                error = true;
				}
				if(theID === 'c_email' && value !== '' && !emailReg.test(value))
				{
					jQuery(this).after('<p class="contact_error fount_italic prk_heavier_600 header_font">'+invalid_email_error+'</p>');
					error = true;
				}
				jQuery('.contact_error').addClass('fount_animated shake');
			});
					
			//SEND EMAIL IF THERE ARE NO ERRORS
			if(error === false) {
				jQuery("#submit_message_div").addClass("fount_animated bounceOut");	
				setTimeout(function() {
					jQuery('#contact_ok').addClass('fount_animated flash');
					ajaxSubmit();
				},1200);
			}
		});
		function ajaxSubmit() {
			var prk_form_content = jQuery('#contact-form').serialize();
			var data = {
				action: 'mail_before_submit',
				email_wrap: prk_form_content,
				_ajax_nonce:ajax_var.nonce
			};
			jQuery.post(ajax_var.url, data, function(response) {
				jQuery("#contact_ok").removeClass('flash');
				jQuery("#contact_ok").addClass('forced_opacity');
				if(response === 'sent0') {
					jQuery("#contact_ok").html(jQuery('#contact-form').attr('data-ok'));
				}
				else {
					jQuery("#contact_ok").html(response);
				}
			});
			return false;
	    }
	    jQuery('.masonry_blog').each(function(){
	    	jQuery(this).find('.blog_entry_li').css({'padding':jQuery(this).attr('data-margin')+'px'});
		});
		//VARIOUS THEME FUNCTIONS
		initHeadline();
		init_member();
		init_blog();
		init_portfolio();
		thumbs_roll();
		prk_init_sharrre();
		jQuery('.bordered_buttons .theme_button a,.bordered_buttons .theme_button input').each( function() {
			if (jQuery(this).attr('data-color')!==undefined && jQuery(this).attr('data-color')!=="default" && jQuery(this).attr('data-color')!=="") {
					jQuery(this).css({'background-color':'transparent','color':jQuery(this).attr('data-color'),'border-color':jQuery(this).attr('data-color')});
			}
		});
		//ADD ARROWS
		jQuery('.sitemap_block li a,.widget_rss ul li a, .widget_meta a,.widget_recent_entries a,.widget_categories a,.widget_archive a,.widget_pages a,.widget_links a,.widget_nav_menu a').not('#prk_hidden_bar a').each(function() {
			jQuery(this).prepend('<div class="prk_theme_arrows"><div class="tr_wrapper"><div class="fount_fa-angle-double-right"></div></div></div>');
		});
		//VISUAL COMPOSER STUFF
		if (theme_options.active_visual_composer) {
			//console.log ("COMPOSER ON");
			/*var ac_icons = {
				header: "fount_fa-plus",
                activeHeader: "fount_fa-minus"
			};
			jQuery(".prk_accordion").accordion({
				collapsible: true,
				active: false ,
				autoHeight:false,
				heightStyle: "content",
				icons: ac_icons,
				change: function() { 
					//MAKE SURE THE HOVER STATE IS GONE
					jQuery(".prk_accordion h3").each(function(){
						jQuery(this).blur();
					});
				}
			});*/
			vc_tabsBehaviour();
			vc_twitterBehaviour();
			vc_toggleBehaviour();
			vc_accordionBehaviour();
			vc_teaserGrid();
			vc_carouselBehaviour();
			vc_slidersBehaviour();
			vc_prettyPhoto();
			vc_googleplus();
			vc_pinterest();
			vc_progress_bar();
			vc_waypoints();
		}
		//RETINA IMAGES SIZE CHANGE
		jQuery('img.fount_retina,.fount_retina img').each(function() {
			var $imager=jQuery(this);
			$imager.parent().imagesLoaded(function() {
				$imager.addClass('prk_first_anim');
				$imager.width($imager.attr('width')/2);
				//$imager.height($imager.attr('height')/2);
			});
		});
		//FADE IN CONTENT
		if (folio_flag===false) {
			var img_load=imagesLoaded("#prk_ajax_container");
			img_load.on('always', function() {
				setTimeout(function() {
					//GO TO HASHTAG IF POSSIBLE
					go_hash(15,false);
				},200);
				setTimeout(function() {
					jQuery.waypoints('refresh');
					stop_verification=false;
				},450);
			});
			setTimeout(function() {
				jQuery.waypoints('refresh');
				stop_verification=false;
			},450);
			//ENSURE THAT EVERYTHING IS PERFECTLY RENDERED
			setTimeout(function() {
				jQuery.waypoints('refresh');
				stop_verification=false;
			},2500);
		}
		else {
			jQuery('#single_slider,#single_spinner.spinner-icon').addClass('prk_first_anim');
			var img_load=imagesLoaded('.fount_active_above .fount_ajax_portfolio');
			img_load.on('always', function() {
				jQuery('.fount_active_above #folio_nav_wrapper').addClass('prk_first_anim');
				jQuery('.fount_active_above .fount_ajax_portfolio').slideDown(250);
				jQuery('.fount_active_above .multi_spinner').css({'opacity':'0'});
				setTimeout(function() {
					stop_verification=false;
				},2500);
			}); 
		}
		first_load=false;
		loading_page=false;
	}//ENDED LOADING
	//FUNCTIONS EXECUTED ONLY ONCE
	var widgets_counter=0;
	jQuery('#footer_in>.widget').each(function() {
		jQuery(this).addClass(theme_options.widgets_nr);
		widgets_counter++;
		if (widgets_counter>1 && widgets_counter===(12/parseInt(jQuery('#prk_footer').attr('data-layout').replace('small-',''),10))) {
			jQuery(this).after('<div class="clearfix"></div>');
			widgets_counter=0;
		}
	});
	jQuery("#prk_hidden_bar_scroller").mCustomScrollbar({
		scrollInertia:450,
		autoHideScrollbar:true,
		scrollButtons:{
			enable:false
		}
	});
	jQuery('#menu_section').attr('data-width',jQuery('#menu_section').width());
	jQuery('#fount_close').click(function(e) {
		if (loading_page===false) {
			if (jQuery('.single-pirenko_portfolios').length) {
				window.location.href=jQuery('#content').attr('data-parent');
			}
			else {
				loading_page=true;
				jQuery('#fount_ajax_holder').removeClass('prk_first_anim');
				jQuery('#top_bar_wrapper').removeClass('prk_first_anim');
				setTimeout(function() {
					jQuery('#fount_ajax_wrapper').css({'display':''});
					jQuery ('body').removeClass('fount_showing_lightbox');
					jQuery('#prk_responsive_menu').addClass('prk_first_anim');
					jQuery(window).trigger("debouncedresize");
					first_cross=true;
					jQuery(window).trigger("smartresize");
					//GO TO HASHTAG IF POSSIBLE
					go_hash(150,true);
					fount_ajax_content.html('');
				},260);
				setTimeout(function() {
					jQuery('#fount_ajax_back').removeClass('fount_tweaked');
				},620);
				setTimeout(function() {
					jQuery('#fount_ajax_back').css({'z-index':'-1'});
					loading_page=false;
				},880);
			}
		}
	});
	jQuery('#fount_left').click(function(e) {
		if (loading_page===false) {
			if (jQuery('.single-pirenko_portfolios').length) {
				window.location.href=jQuery('.navigation_previous_portfolio>a').attr('href');
			}
			else {
				loading_page=true;
				if (ajax_in_pos>0) {
					ajax_in_pos=parseInt(ajax_in_pos,10)-1;
				}
				else {
					ajax_in_pos=jQuery('.folio_masonry.iso_folio>div').length-1;
				}
				jQuery("#prk_half_size_single,#prk_full_folio,#after_single_folio").removeClass('prk_first_anim');
				setTimeout(function() {
					load_ajax_link(jQuery('.folio_masonry.iso_folio>div:nth-child('+parseInt((ajax_in_pos+1),10)+') a.fount_ajax_anchor').attr('href'),false,true);
				},300);
			}
		}
	});
	jQuery('#fount_right').click(function(e) {
		if (loading_page===false) {
			if (jQuery('.single-pirenko_portfolios').length) {
				window.location.href=jQuery('.navigation_next_portfolio>a').attr('href');
			}
			else {
				loading_page=true;
				if (ajax_in_pos<(jQuery('.folio_masonry.iso_folio>div').length-1)) {
					ajax_in_pos=parseInt(ajax_in_pos,10)+1;	
				}
				else {
					ajax_in_pos=0;
				}
				jQuery("#prk_half_size_single,#prk_full_folio,#after_single_folio").removeClass('prk_first_anim');
				setTimeout(function() {
					load_ajax_link(jQuery('.folio_masonry.iso_folio>div:nth-child('+parseInt((ajax_in_pos+1),10)+') a.fount_ajax_anchor').attr('href'),false,true);
				},300); 
			}
		}
	});
	if (!fount_on_mobile) {
		var fount_skrollr = skrollr.init({
			forceHeight:true,
			smoothScrolling:false,
			keyframe: function(element, name, direction) {
				setTimeout(function() {
		        	jQuery('#footer_revealer').css({'opacity':jQuery('#footer_mirror').css('opacity')});
		        },100); 
		    }
		});
		jQuery(window).trigger("debouncedresize");
		//HIDDEN SIDEBAR FUNCTIONS
		jQuery('#prk_menu_right_trigger,#prk_menu_left_trigger,#dotted_navigation li').hover(function() {
			jQuery(this).addClass('hover_trigger');
		},
		function() {
			jQuery(this).removeClass('hover_trigger');
		});
	}
	function hasParentClass( e, classname ) {
		if(e === document){ 
			return false;
		}
		if( classie.has( e, classname ) ) {
			return true;
		}
		return e.parentNode && hasParentClass( e.parentNode, classname );
	}
	function click_on_body (evt) {
		if (evt==='close_flag' || hasParentClass(evt.target,'hider_flag')) {
			if(sidebar_is_open===true)   {
				prk_toggle_sidebar();
			}
		}
	};
	function init_sidebar() {
		jQuery('#prk_menu_right_trigger,#prk_menu_right_trigger_alt').click(function(e) {
			prk_toggle_sidebar();
		});
		jQuery('.sidebar_opener a').click(function(e) {
			e.preventDefault();
			prk_toggle_sidebar();
		});
	}
	function prk_toggle_sidebar() {
		if (sidebar_is_open===false) {
			jQuery('#prk_menu_right_trigger').removeClass('hover_trigger');
			sidebar_is_open=true;
			jQuery('body').addClass('prk_shifted');
			jQuery('#prk_hidden_bar').css({'visibility':'visible'});
			setTimeout(function() {
				document.addEventListener( 'click', click_on_body );
				jQuery('#body_hider').addClass('prk_shifted_hider');
				jQuery('body').addClass('showing_hidden_sidebar');
			},300); 
		}
		else {
			sidebar_is_open=false;
			jQuery('body').removeClass('prk_shifted');
			jQuery('body').removeClass('showing_hidden_sidebar');
			jQuery('#body_hider').removeClass('prk_shifted_hider');
			setTimeout(function(){
				document.addEventListener( 'click', click_on_body );
				jQuery('#prk_hidden_bar').css({'visibility':'hidden'});
			},300); 
		}
	}
	if (!fount_on_mobile && theme_options.show_sooner!=="yes") {
		var prk_load=imagesLoaded('#prk_ajax_container');
		prk_load.on( 'always', function() {
		  //console.log( imgLoad.images.length + ' images loaded' );
		  // detect which image is broken
		  /*for ( var i = 0, len = imgLoad.images.length; i < len; i++ ) {
		    var image = imgLoad.images[i];
		    var result = image.isLoaded ? 'loaded' : 'broken';
		    console.log( 'image is ' + result + ' for ' + image.img.src );
		  }*/
		  init_sidebar();
		  ended_loading(false);
		  jQuery('.wpb_row,.fount_row').removeClass('per_init');
		  setTimeout(function(){
		  	jQuery(window).trigger("debouncedresize");
		  	jQuery("#wrap").addClass('prk_first_anim');
		  	jQuery('#prk_footer_wrapper').addClass('prk_first_anim');
		  },300);
		});
	}
	else {
		init_sidebar();
		ended_loading(false);
		setTimeout(function(){
			jQuery(window).trigger("debouncedresize");
			jQuery("#wrap").addClass('prk_first_anim');
			jQuery('#prk_footer_wrapper').addClass('prk_first_anim');
		},300);
		var img_load=imagesLoaded('#prk_ajax_container');
		img_load.on('always', function() {
			jQuery('.wpb_row,.fount_row').removeClass('per_init');
			setTimeout(function(){
				jQuery(window).trigger("debouncedresize");
			},300);
		});
	}
	//RESIZE LISTENER
	function pirenko_resize() {
		if (jQuery.browser.msie  && parseInt(jQuery.browser.version, 10) === 8) {
			height_fix = jQuery(window).height();
		}
		else {
			height_fix = window.innerHeight ? window.innerHeight : jQuery(window).height();
		}
		if (jQuery('#wpadminbar').length) {
			height_fix=height_fix-jQuery('#wpadminbar').height();
		}
		jQuery("#prk_hidden_bar,#prk_hidden_bar_scroller").outerHeight(height_fix);
		jQuery("#fount_ajax_holder #ajaxed_content").css({'min-height':height_fix});
		jQuery(".google_maps").height(jQuery(".google_maps").attr('data-map_height'));
	}
	jQuery(window).resize(function() {
		pirenko_resize();
	});
	pirenko_resize();
	//DELAYED RESIZE LISTENTER
	jQuery(window).on("debouncedresize", function() {
		if (!fount_on_mobile) {
			jQuery('.fount_video-bg.parallax_video').each(function() {
				var $par_video=jQuery(this);
				var scrolly=$par_video.height()-$par_video.parent().outerHeight();
				$par_video.attr('data-top-bottom',"bottom: -"+scrolly+"px;");
			});
			fount_skrollr.refresh();
		}
		jQuery('#footer_mirror').css({'height':jQuery('#prk_footer').outerHeight()+mirror_offset});
		if (jQuery('body').hasClass('menu_at_top')) {
			jQuery('.wpb_call_to_action.cta_align_right .wpb_button_a,.wpb_call_to_action.cta_align_left .wpb_button_a,.wpb_call_to_action.cta_align_right .theme_button,.wpb_call_to_action.cta_align_right .theme_button_inverted,.wpb_call_to_action.cta_align_left .theme_button,.wpb_call_to_action.cta_align_left .theme_button_inverted').each(function() {
				jQuery(this).css({'top':'16px'});
			});
		}
		else {
			jQuery('.wpb_call_to_action.cta_align_right .wpb_button_a,.wpb_call_to_action.cta_align_left .wpb_button_a,.wpb_call_to_action.cta_align_right .theme_button,.wpb_call_to_action.cta_align_right .theme_button_inverted,.wpb_call_to_action.cta_align_left .theme_button,.wpb_call_to_action.cta_align_left .theme_button_inverted').each(function() {
				jQuery(this).css({'top':(jQuery(this).parent().parent().height()-jQuery(this).height())/2});
			});
		}
		if ((jQuery(window).width()-jQuery('#menu_section').attr('data-width')-jQuery('#prk_logo_image').attr('data-width'))<120) {
			if (!jQuery('body').hasClass('menu_at_top')) {
				jQuery('body').addClass('menu_at_top');
				jQuery('#menu_section .sf-menu').css({'display':''});
				responsive_menu_is_open=false;
				menu_bar_height=mn_collapsed;
			}
		}
		else {
			if (jQuery('body').hasClass('menu_at_top')) {
				jQuery('body').removeClass('menu_at_top');
				menu_bar_height=0;
				jQuery('#menu_section .sf-menu').css({'display':'block'});
				//ENSURE THAT THE MENU IS RIGHT WHEN WE GO FROM SMALL TO BIG
				if (jQuery('#menu_section').attr('data-width')!==jQuery('#menu_section').width()) {
					jQuery('#menu_section').attr('data-width',jQuery('#menu_section').width());
					jQuery(window).trigger("debouncedresize");
				}
			}
		}
		jQuery('.forced_row').each(function() {
			jQuery(this).css({'height':''});
			if (jQuery(window).height()-menu_bar_height>jQuery(this).height()) {
				jQuery(this).css({'height':jQuery(window).height()-menu_bar_height});
			}
			jQuery(this).find('.fount_video-bg').css({'left':parseInt((jQuery(window).width()-jQuery(this).find('.fount_video-bg').width())/2,10)});
		});
		jQuery('.vertical_forced_row>div').each(function() {
			jQuery(this).css({'height':''});
			if (jQuery(window).height()-100-menu_bar_height>jQuery(this).height()) {
				jQuery(this).css({'height':jQuery(window).height()-100-menu_bar_height});//-100 is because of padding
			}
			jQuery(this).find('.fount_video-bg').css({'left':parseInt((jQuery(window).width()-jQuery(this).find('.fount_video-bg').width())/2,10)});
		});
		if (jQuery('.masonry_blog').length) {
			rearrange_layout();
		}
		jQuery("#prk_hidden_bar_scroller").mCustomScrollbar("update");
		jQuery('.google_maps').css({'max-height':jQuery(window).height()-jQuery("#prk_responsive_menu").height()-100});
		jQuery('.cd-words-wrapper').each(function() {
			jQuery(this).css({'width':''});
			jQuery(this).css({'width':jQuery(this).width()});
		});
		//NO BLURRY ELEMENTS
		/*jQuery('.prk_inner_block').each(function() {
			jQuery(this).css({'margin-left':''});
			var margin_before=parseFloat(jQuery(this).css('margin-left').replace(',','.').replace(' ',''));
			if(Math.floor(margin_before) !== margin_before) {
				jQuery(this).css({'margin-left':Math.floor(margin_before)});
			}
		});*/
	});
}
//FUNCTION TO DETECT IF A TOUCH DEVICE IS IN USE
function is_mobile() {
	"use strict";
	var check = false;
		(function(a){
		if((/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase())) || /(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a.toLowerCase())||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4).toLowerCase())){check = true;}})(navigator.userAgent||navigator.vendor||window.opera);
	return check;
}
//HEXADECIMAL TO RGB:#CCCCCC=>rgb(204,204,204)
function hex2rgb(hexStr,alpha) {
	"use strict";
	var hex = parseInt(hexStr.substring(1), 16);
	var r = (hex & 0xff0000) >> 16;
	var g = (hex & 0x00ff00) >> 8;
	var b = hex & 0x0000ff;
	if (alpha>1) {
		alpha=alpha/100;
	}
	return "rgba("+[r, g, b]+","+alpha+")";
}
jQuery(window).bind("pageshow", function(event) {
	"use strict";
    if (event.originalEvent.persisted) {
        window.location.reload();
    } 
});
jQuery(document).ready(function() {
	if (theme_options.fount_active_skin!==undefined) {
		jQuery('html').addClass(theme_options.fount_active_skin);
		if (theme_options.fount_current_home!==undefined) {
			jQuery('#prk_logos a').attr('href',theme_options.fount_current_home);
		}
	}
	if (jQuery.browser.chrome) {
		jQuery('html').addClass('fount_chrome');
	}
	else {
		var nua = navigator.userAgent;
		if (((nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1))) {
			jQuery('html').addClass('fount_android');
		}
		else {
			var msie = nua.indexOf('MSIE ');
		    var trident = nua.indexOf('Trident/');
		    if (msie > 0 || trident > 0) {
		        jQuery('html').addClass('fount_ie');
		    }
		    else {
		    	if (jQuery.browser.safari) {
					jQuery('html').addClass('fount_safari');
				} 
		    }
		}
	}
	if (jQuery('#centered_block.forced_menu,.single-pirenko_portfolios').length) {
    	jQuery('#fount_wrapper').addClass('fount_forced_menu');
    }
    if (jQuery('.single-pirenko_portfolios').length) {
    	jQuery('#fount_wrapper').addClass('fount_forced_top_bar');
    }
	if (jQuery('#dotted_navigation').length) {
		jQuery('#fount_wrapper').addClass('dotted_navigation');
	}
	if (jQuery('.fount_alone').length) {
		jQuery('#fount_wrapper').addClass('fount_alone');
	}
	if (is_mobile()) {
		jQuery('#footer_mirror').css({'display':'none'});
		jQuery('#prk_footer_wrapper').css({'position':'relative'});
	}
	jQuery('.fount_logo_above #prk_logo_image').attr('data-width',0);
	var img_load=imagesLoaded('#fount_logo_holder');
	img_load.on('always', function() {
		setTimeout(function() {
			jQuery('#prk_alt_logo_image').css({'max-height':jQuery('#prk_alt_logo_image').attr('height')+'px'});
			jQuery('#prk_logo_image').css({'max-height':jQuery('#prk_logo_image').attr('height')+'px'});
			jQuery('.fount_logo_above.fount_forced_menu #centered_block').css({'margin-top':jQuery('#prk_alt_logo_image').attr('height')+'px'});
			var found_url=false;
			//TRY TO HIGHLIGHT PARENT PAGES 
			if (jQuery('#content').attr('data-parent')!==undefined) {
				if (found_url===false) {
					jQuery('#menu_section .sf-menu>li>a').each(function() {
						if (jQuery(this).attr('href')===jQuery('#content').attr('data-parent')) {
							jQuery(this).parent().addClass('active');
							found_url=true;
						}
					});
				}
				if (found_url===false) {
					jQuery('#menu_section .sf-menu li a').each(function() {
						if (jQuery(this).attr('href')===jQuery('#content').attr('data-parent')) {
							jQuery(this).parent().parent().parent().addClass('active');
							found_url=true;
						}
					});
				}
			}
			if (found_url===false) {
				jQuery('#menu_section .sf-menu li').each(function() {
					if (jQuery(this).hasClass('active') && jQuery(this).parent().hasClass('sub-menu')) {
						jQuery(this).parent().parent().addClass('active');
						found_url=true;
					}
				});
			}
			if (found_url===false && jQuery('.mini-site-header').length) {
				if(jQuery('#dotted_navigation').length) {
					if (window.location.href===jQuery("#menu_section>ul>li:first-child>a").attr('href').split('#')[0]) {
						jQuery("#menu_section .sf-menu>li:first-child").addClass('active');
					}
					else {
						//MULTIPAGE SEARCH
						jQuery("#menu_section .sf-menu>li>a").each(function() {
							if (window.location.href===jQuery(this).attr('href')) {
								jQuery('#menu_section ul li.active').removeClass('active');
								jQuery(this).parent().addClass('active');
							}
						});
					}
				}
				else {
					if (window.location.href===jQuery("#menu_section .sf-menu>li:first-child>a").attr('href').split('#')[0]) {
						jQuery("#menu_section .sf-menu>li:first-child").addClass('active');
					}
					else {
						//MULTIPAGE SEARCH
						jQuery("#menu_section .sf-menu>li>a").each(function() {
							if (window.location.href===jQuery(this).attr('href')) {
								jQuery('#menu_section ul li.active').removeClass('active');
								jQuery(this).parent().addClass('active');
							}
						});
					}
				}
			}
			jQuery('#prk_responsive_menu').addClass('prk_first_anim');
		},50);
	});
	if (jQuery('#prk_ajax_container.fount_coming').length) {
		if (jQuery('#fount_full_back').length) {
			jQuery('#fount_full_back').css({'background-image':'url('+jQuery('#fount_full_back').attr('data-image')+')'});
		}
		jQuery('#fount_countdown_wrapper').css({'color':jQuery('#fount_countdown_wrapper').attr('data-color'),'opacity':1});
	}
	NProgress.configure({ minimum: 0.3, trickleRate: 0.08, trickleSpeed: 400  });
	NProgress.start();
	//CALL MAIN JAVASCRIPT FUNCTION
	if (make_session!==true) {
		fount_init();
	}
});
/* jshint ignore:end */