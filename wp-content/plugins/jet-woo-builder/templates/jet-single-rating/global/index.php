<?php
/**
 * JetWooBuilder Single Rating template.
 */

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
	return;
}

$settings            = $this->get_settings();
$rating_count        = $product->get_rating_count();
$review_count        = $product->get_review_count();
$rating_icon         = isset( $settings['rating_icon'] ) ? $settings['rating_icon'] : 'jetwoo-front-icon-rating-1';
$empty_single_rating = isset( $settings['show_single_empty_rating'] ) && 'true' === $settings['show_single_empty_rating'];
$rating              = jet_woo_builder_template_functions()->get_product_custom_rating( $rating_icon, $empty_single_rating );

$counter_html = sprintf(
	_n( '(%s customer review)', '(%s customer reviews)', $review_count, 'jet-woo-builder' ),
	'<span class="count">' . esc_html( $review_count ) . '</span>'
);

$counter_html = apply_filters( 'jet-woo-builder/jet-single-rating/rating-counter-label', $counter_html, $review_count );

if ( $rating_count > 0 || $empty_single_rating ) : ?>
	<div class="woocommerce-product-rating">
		<?php echo $rating; ?>
		<?php if ( comments_open() ) : ?>
			<a href="#reviews" class="woocommerce-review-link" rel="nofollow">
				<?php echo $counter_html; ?>
			</a>
		<?php endif ?>
	</div>
<?php endif; ?>