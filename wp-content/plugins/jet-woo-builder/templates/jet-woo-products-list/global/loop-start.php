<?php
/**
 * Products list loop start template
 */

$settings    = $this->get_settings();
$layout      = $this->get_attr( 'products_layout' );
$target_attr = 'yes' === $this->get_attr( 'open_new_tab' ) ? 'target="_blank"' : '';

$classes = array(
	'jet-woo-products-list',
	$layout ? 'products-layout-' . $layout : '',
);

$attributes = '';
$attributes = apply_filters( 'jet-woo-builder/templates/jet-woo-products-list/widget-attributes', $attributes, $settings, $query, $this );

printf(
	'<ul class="%s" %s>',
	implode( ' ', $classes ),
	$attributes
);
