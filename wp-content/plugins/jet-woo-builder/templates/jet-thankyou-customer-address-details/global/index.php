<?php
/**
 * Thank You Customer Address Details Template
 */

defined( 'ABSPATH' ) || exit;

$order = jet_woo_builder_template_functions()->get_current_received_order();

if ( ! $order ) {
	return;
}

wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
