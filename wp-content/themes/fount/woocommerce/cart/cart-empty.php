<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>
<div class="fount_woo_empty">
	<h4 class="cart-empty zero_color"><?php _e( 'Your cart is currently empty.', 'woocommerce' ) ?></h4>

	<?php do_action( 'woocommerce_cart_is_empty' ); ?>

	<p class="return-to-shop"><a class="button wc-backward" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php _e( 'Return To Shop', 'woocommerce' ) ?></a></p>
	<div class="simple_line"></div>
	<div class="related">
	<?php
		echo '<h2 class="zero_color">';
		_e( 'Recent Products', 'fount' );
		echo '</h2>';
		echo do_shortcode('[recent_products per_page="3" columns="3"]');
	?>
	</div>
</div>
