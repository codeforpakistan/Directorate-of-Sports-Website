<?php
/**
 * Checkout Payment Template
 */

defined( 'ABSPATH' ) || exit;

if ( WC()->cart->needs_payment() && ! jet_woo_builder_integration()->in_elementor() ) {
	$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
	WC()->payment_gateways()->set_current_gateway( $available_gateways );
} else {
	$available_gateways = array();
}

wc_get_template(
	'checkout/payment.php',
	array(
		'checkout'           => WC()->checkout(),
		'available_gateways' => $available_gateways,
		'order_button_text'  => apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) ),
	)
);
