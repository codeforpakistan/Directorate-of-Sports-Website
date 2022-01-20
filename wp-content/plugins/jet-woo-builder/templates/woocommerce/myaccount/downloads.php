<?php
/**
 * Downloads
 *
 * Shows downloads on the account page.
 *
 * This template can be overridden by copying it to yourtheme/jet-woo-builder/woocommerce/myaccount/downloads.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$downloads     = WC()->customer->get_downloadable_products();
$has_downloads = ( bool )$downloads;
$template      = jet_woo_builder_integration_woocommerce()->get_current_myaccount_downloads_template();
$template      = apply_filters( 'jet-woo-builder/current-template/template-id', $template );

jet_woo_builder()->admin_bar->register_post_item( $template );

do_action( 'woocommerce_before_account_downloads', $has_downloads ); ?>

<?php if ( $has_downloads ) : ?>
	<div class="jet-woo-account-downloads-content">
		<?php echo jet_woo_builder_template_functions()->get_woo_builder_content( $template ); ?>
	</div>
<?php else : ?>
	<div class="woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php esc_html_e( 'Browse products', 'woocommerce' ); ?>
		</a>
		<?php esc_html_e( 'No downloads available yet.', 'woocommerce' ); ?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_downloads', $has_downloads ); ?>
