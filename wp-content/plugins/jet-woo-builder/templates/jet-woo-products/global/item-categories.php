<?php
/**
 * Loop item categories
 */

$categories = jet_woo_builder_template_functions()->get_product_terms_list( 'product_cat', $this->get_attr( 'categories_count' ) );

if ( 'yes' !== $this->get_attr( 'show_cat' ) || ! $categories ) {
	return;
}
?>

<div class="jet-woo-product-categories"><ul><?php echo $categories; ?></ul></div>