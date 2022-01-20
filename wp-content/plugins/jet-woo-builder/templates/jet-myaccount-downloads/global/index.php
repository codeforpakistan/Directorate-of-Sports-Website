<?php
/**
 * My Account Downloads Template
 */

if ( ! is_user_logged_in() ) {
	return esc_html__( 'You need to logged in first', 'jet-woo-builder' );
}

$downloads = WC()->customer->get_downloadable_products();

do_action( 'woocommerce_before_available_downloads' );
do_action( 'woocommerce_available_downloads', $downloads );
do_action( 'woocommerce_after_available_downloads' );