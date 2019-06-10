/* jshint ignore:start */
jQuery(document).ready(function() {
	/*
	Live Modal
	*/
	jQuery(document).ajaxComplete(function(event, xhr, settings) {
		if (jQuery('.seven_icon_selector').length) {
			jQuery('.wpb_edit_form_elements').addClass('prkadmin-theme-icon');
		}
		if (jQuery(".vc_ui-panel.vc_active").length) {
			var classes = jQuery(".vc_ui-panel.vc_active").attr("class").split(' ');
			jQuery.each(classes, function(i, c) {
			    if (c.indexOf("fnt_") === 0) {
			        jQuery(".vc_ui-panel.vc_active").removeClass(c);
			    }
			});
			jQuery('.vc_ui-panel.vc_active .vc_shortcode-param').each(function() {
				if (jQuery(this).attr('data-vc-shortcode-param-name')!==undefined) {
					jQuery(this).addClass('fnt_'+jQuery(this).attr('data-vc-shortcode-param-name'));
				}
			});
			if (jQuery('.vc_ui-panel.vc_active').attr('data-vc-shortcode')!==undefined) {
				jQuery('.vc_ui-panel.vc_active').addClass('fnt_'+jQuery('.vc_ui-panel.vc_active').attr('data-vc-shortcode'));
			}
		}
	});
	//REDUX STUFF
	jQuery('#vrv_one_click #redux-header .notice').slideDown();
	//REMOVE VC REQUEST
	jQuery('.wp-list-table.plugins #the-list tr').each(function() {
		if (jQuery(this).attr('data-slug')==="wpbakery-visual-composer" && jQuery(this).find('.row-actions>.update').length===0) {
			jQuery(this).removeClass('update');
		}
		if (jQuery(this).attr('data-slug')==="fount-framework" && jQuery(this).find('.row-actions>.update').length===1) {
			jQuery(this).addClass('update');
		}
	});
});
/* jshint ignore:end */
