<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/jet-woo-builder/woocommerce/checkout/form-checkout.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$elementor_version = defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0.0', '<' );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );

$template     = apply_filters( 'jet-woo-builder/current-template/template-id', jet_woo_builder_integration_woocommerce()->get_current_checkout_template() );
$template     = apply_filters( 'jet-woo-builder/current-template/template-id', $template );
$top_template = apply_filters( 'jet-woo-builder/current-template/template-id', jet_woo_builder_integration_woocommerce()->get_current_top_checkout_template() );
$top_template = apply_filters( 'jet-woo-builder/current-template/template-id', $top_template );

jet_woo_builder()->admin_bar->register_post_item( $template );
jet_woo_builder()->admin_bar->register_post_item( $top_template );

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'jet-woo-builder' ) ) );
	return;
} ?>

<div class="jet-woo-builder-woocommerce-checkout">
	<?php
		if ( $top_template ) :
			echo jet_woo_builder_template_functions()->get_woo_builder_content( $top_template );
		else: ?>
			<section class="elementor-section-boxed elementor-section" data-element_type="section">
				<div class="elementor-container elementor-column-gap-default">
					<?php echo $elementor_version ? '<div class="elementor-row">' : '' ?>
						<div class="elementor-element elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
							<?php echo $elementor_version ? '<div class="elementor-column-wrap  elementor-element-populated">' : '' ?>
								<div class="elementor-widget-wrap">
									<?php
										woocommerce_checkout_coupon_form();
										woocommerce_checkout_login_form();
									?>
								</div>
							<?php echo $elementor_version ? '</div>' : '' ?>
						</div>
					<?php echo $elementor_version ? '</div>' : '' ?>
				</div>
			</section>
		<?php endif; ?>

	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
		<?php echo jet_woo_builder_template_functions()->get_woo_builder_content( $template ); ?>
		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
	</form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
