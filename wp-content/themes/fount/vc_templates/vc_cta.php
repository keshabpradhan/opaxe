<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Cta
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->buildTemplate( $atts, $content );
?>
<div
	class="vc_cta3-container <?php echo esc_attr( implode( ' ', $this->getTemplateVariable( 'container-class' ) ) ); ?>">
	<div class="vc_general <?php echo esc_attr( implode( ' ', $this->getTemplateVariable( 'css-class' ) ) ); ?>"<?php
	if ( $this->getTemplateVariable( 'inline-css' ) ) {
		echo ' style="' . esc_attr( implode( ' ', $this->getTemplateVariable( 'inline-css' ) ) ) . '"';
	}
	?>>
		<?php echo fount_output().$this->getTemplateVariable( 'icons-top' ); ?>
		<?php echo fount_output().$this->getTemplateVariable( 'icons-left' ); ?>
		<div class="vc_cta3_content-container">
			<?php echo fount_output().$this->getTemplateVariable( 'actions-top' ); ?>
			<?php echo fount_output().$this->getTemplateVariable( 'actions-left' ); ?>
			<div class="vc_cta3-content">
				<header class="vc_cta3-content-header header_font zero_color">
					<?php echo fount_output().$this->getTemplateVariable( 'heading1' ); ?>
					<?php echo fount_output().$this->getTemplateVariable( 'heading2' ); ?>
				</header>
				<?php echo fount_output().$this->getTemplateVariable( 'content' ); ?>
			</div>
			<?php echo fount_output().$this->getTemplateVariable( 'actions-bottom' ); ?>
			<?php echo fount_output().$this->getTemplateVariable( 'actions-right' ); ?>
		</div>
		<?php echo fount_output().$this->getTemplateVariable( 'icons-bottom' ); ?>
		<?php echo fount_output().$this->getTemplateVariable( 'icons-right' ); ?>
		<div class="clearfix"></div>
	</div>
</div><?php echo fount_output().$this->endBlockComment( $this->getShortcode() ); ?>

