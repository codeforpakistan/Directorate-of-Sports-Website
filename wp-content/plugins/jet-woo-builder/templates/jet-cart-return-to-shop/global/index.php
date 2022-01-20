<?php
/**
 * Cart Return to Shop Template.
 */

$settings    = $this->get_settings_for_display();
$button_text = isset( $settings['cart_return_to_shop_button_text'] ) ? $settings['cart_return_to_shop_button_text'] : apply_filters( 'woocommerce_return_to_shop_text', esc_html__( 'Return to shop', 'woocommerce' ) );
$button_link = isset( $settings['cart_return_to_shop_button_link'] ) ? $settings['cart_return_to_shop_button_link'] : wc_get_page_permalink( 'shop' );
?>

<p class="return-to-shop">
	<a class="button wc-backward" href="<?php echo esc_url( $button_link ); ?>">
		<?php echo esc_html( $button_text ); ?>
	</a>
</p>
