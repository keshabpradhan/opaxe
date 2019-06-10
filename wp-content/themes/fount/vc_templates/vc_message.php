<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $message_box_style
 * @var $style
 * @var $color
 * @var $message_box_color
 * @var $css_animation
 * @var $icon_type
 * @var $icon_fontawesome
 * // Todo add $icon_... defaults
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Message
 */
// Todo add $icon_typicons and etc

$atts = $this->convertAttributesToMessageBox2( $atts );
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$elementClass = array(
	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_alert vc_message_box', $this->settings['base'], $atts ),
	//'style' => 'vc_message_box-' . $message_box_style,
	'shape' => 'wpb_alert-' . $style,
	'color' => 'wpb_alert-' . $message_box_color,
	'extra' => $this->getExtraClass( $el_class ),
	'css_animation' => $this->getCSSAnimation( $css_animation ),
);
$elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
$current_icon='<i class="fount_fa-info-circle"></i>';
if (strpos($elementClass,"vc_color-warning"))
	$current_icon='<i class="fount_fa-exclamation-triangle"></i>';
if (strpos($elementClass,"vc_color-success"))
	$current_icon='<i class="fount_fa-check-circle"></i>';
if (strpos($elementClass,"vc_color-danger"))
	$current_icon='<i class="fount_fa-times-circle"></i>';

?>
<div class="<?php echo esc_attr( $elementClass ); ?>">
	<div class="vc_message_box-icon">
		<?php echo fount_output().$current_icon; ?>
	</div>
	<div class="messagebox_text">
		<?php echo wpb_js_remove_wpautop( $content, true ); ?>
	</div>
</div>
<?php echo fount_output().$this->endBlockComment( $this->getShortcode() ); ?>