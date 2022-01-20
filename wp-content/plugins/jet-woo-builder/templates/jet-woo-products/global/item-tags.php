<?php
/**
 * Loop item tags
 */

$tags = jet_woo_builder_template_functions()->get_product_terms_list( 'product_tag', $this->get_attr( 'tags_count' ) );

if ( 'yes' !== $this->get_attr( 'show_tag' ) || ! $tags ) {
	return;
}
?>

<div class="jet-woo-product-tags"><ul><?php echo $tags; ?></ul></div>