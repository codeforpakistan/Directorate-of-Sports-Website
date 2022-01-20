<?php
/**
 * JetWooBuilder Product Attributes Table template.
 */

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

ob_start();

wc_display_product_attributes( $product );

$content = ob_get_clean();

if ( empty( $content ) ) {
	return;
}

$settings = $this->get_settings();
$tag      = jet_woo_builder_tools()->sanitize_html_tag( $settings['block_title_tag'] );
$title    = esc_html( $settings['block_title'] );

if ( ! empty( $settings['block_title'] ) ) {
	printf( '<%1$s class="jet-single-attrs__title">%2$s</%1$s>', $tag, $title );
}

echo $content;
