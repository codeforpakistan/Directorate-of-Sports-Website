<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/jet-woo-builder/woocommerce/myaccount/my-account.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

$endpoint_enable = 'yes' === jet_woo_builder_shop_settings()->get( 'custom_myaccount_page_endpoints' );
$template        = jet_woo_builder_integration_woocommerce()->get_current_myaccount_template();
$template        = apply_filters( 'jet-woo-builder/current-template/template-id', $template );

jet_woo_builder()->admin_bar->register_post_item( $template );
?>

<div class="jet-woo-builder-my-account-content">
	<?php
	if ( ! $endpoint_enable ) {
		remove_action( 'woocommerce_account_content', 'woocommerce_account_content' );
		do_action( 'woocommerce_account_content' );
	}

	echo jet_woo_builder_template_functions()->get_woo_builder_content( $template );
	?>
</div>
