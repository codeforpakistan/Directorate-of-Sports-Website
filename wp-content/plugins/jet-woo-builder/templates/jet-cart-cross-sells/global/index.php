<?php
/**
 * Cart Cross Sells products Template
 */

$settings = $this->get_settings();
$columns  = isset( $settings['cross_sell_products_columns'] ) ? $settings['cross_sell_products_columns'] : 2;
$orderby  = isset( $settings['cross_sell_products_orderby'] ) ? $settings['cross_sell_products_orderby'] : 'rand';
$order    = isset( $settings['cross_sell_products_order'] ) ? $settings['cross_sell_products_order'] : 'desc';

woocommerce_cross_sell_display( '', $columns, $orderby, $order );
