<?php
$output = $title = $in_image = $size = $zoom = $type = $bubble = $el_class = '';
extract(shortcode_atts(array(
    'title' => '',
    'map_type' => '',
    'map_latitude' => '',
    'map_longitude' => '',
    'map_style' => '',
    'size' => '',
    'zoom' => 14,
    'marker_image' => '',
    'marker_image_long' => '',
    'marker_image_lat' => '',
    'bubble' => '',
    'el_class' => ''
), $atts));
if ($marker_image!="")
    $in_image=wp_get_attachment_image_src($marker_image,'full');
else
    $in_image[0]="";
$size = str_replace(array( 'px', ' ' ), array( '', '' ), $size);
$el_class = $this->getExtraClass($el_class);
if ($size=='')
{
    $size="300";
}
$map_latitude = str_replace(array( '"', '' ), array( '', '' ), $map_latitude);
$map_longitude = str_replace(array( '"', '' ), array( '', '' ), $map_longitude);


$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gmaps_widget wpb_content_element'.$el_class, $this->settings['base']);
?>
<div class="<?php echo $css_class; ?>">
	<?php echo wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_map_heading')); ?>
	<div class="wpb_wrapper">
		<div class="wpb_map_wraper">
			<?php
			echo '<div id="google-maps-cover"><div id="google_maps_'.rand(1, 1000).'" class="google_maps twelve" data-type="'.$map_type.'" data-style="'.$map_style.'" data-zoom="'.$zoom.'" data-lat="'.$map_latitude.'" data-long="'.$map_longitude.'" data-marker="'.$in_image[0].'" data-marker_image_lat="'.$marker_image_lat.'" data-marker_image_long="'.$marker_image_long.'" style="height:'.$size.'px;">';
            echo '<div class="spinner"><div class="spinner-icon"></div></div>';
            echo '</div></div>';
			?>
		</div>
	</div><?php echo $this->endBlockComment('.wpb_wrapper'); ?>
</div><?php echo $this->endBlockComment('.wpb_gmaps_widget'); 
//PIRENKOEDIT
?>

