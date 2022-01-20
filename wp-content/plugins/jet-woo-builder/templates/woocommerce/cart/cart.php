<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/jet-woo-builder/woocommerce/cart/cart.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );

$template = jet_woo_builder_integration_woocommerce()->get_current_cart_template();
$template = apply_filters( 'jet-woo-builder/current-template/template-id', $template );

jet_woo_builder()->admin_bar->register_post_item( $template );
?>

<div class="jet-woo-builder-woocommerce-cart">
	<?php echo jet_woo_builder_template_functions()->get_woo_builder_content( $template ); ?>
</div>

<?php do_action( 'woocommerce_after_cart' );
