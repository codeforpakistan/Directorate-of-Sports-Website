<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/jet-woo-builder/woocommerce/myaccount/my-address.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$template = jet_woo_builder_integration_woocommerce()->get_current_myaccount_address_template();
$template = apply_filters( 'jet-woo-builder/current-template/template-id', $template );

jet_woo_builder()->admin_bar->register_post_item( $template );
?>

<div class="jet-woo-account-address-content">
	<?php echo jet_woo_builder_template_functions()->get_woo_builder_content( $template ); ?>
</div>
