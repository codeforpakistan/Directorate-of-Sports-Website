<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/jet-woo-builder/woocommerce/myaccount/form-edit-account.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

$template = jet_woo_builder_integration_woocommerce()->get_current_myaccount_account_template();
$template = apply_filters( 'jet-woo-builder/current-template/template-id', $template );

jet_woo_builder()->admin_bar->register_post_item( $template );

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div class="jet-woo-account-account-content">
	<?php echo jet_woo_builder_template_functions()->get_woo_builder_content( $template ); ?>
</div>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
