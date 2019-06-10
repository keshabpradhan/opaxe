<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php post_class(); ?>>
	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );


	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	//REMOVED do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	//REMOVED do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	//REMOVED do_action( 'woocommerce_after_shop_loop_item_title' );

	?>
	<a href="<?php the_permalink(); ?>">

		<?php //BEGIN FOUNT ?>
		<div class="fount_woo_thumb_wrapper boxed_shadow">
			<?php 
				woocommerce_get_template( 'loop/sale-flash.php' );
			?>
				
				<div class="fount_woo_thumb">
					<a href="<?php the_permalink(); ?>">
						<?php echo woocommerce_get_product_thumbnail();	?>
					</a>
					<a href="<?php echo do_shortcode('[add_to_cart_url id="'.get_the_ID().'"]'); ?>" class="fount_woo_add_button fount_woo_hidden"><span class="left_floated"><?php echo esc_html($product->add_to_cart_text()); ?></span><i class="right_floated fount_fa-shopping-cart"></i></a>
				</div>
		</div>
		<div class="fount_woo_product_info">
			<a href="<?php the_permalink(); ?>"><h3 class="zero_color prk_heavier_600"><?php the_title(); ?></h3></a>
			<div class="fount_woo_hidden fount_woo_cats small_headings_color">
	        	<?php echo $product->get_categories(); ?>
	        </div>
    	</div>
        <?php //END FOUNT ?>
        <?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	</a>
	<?php

	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>
