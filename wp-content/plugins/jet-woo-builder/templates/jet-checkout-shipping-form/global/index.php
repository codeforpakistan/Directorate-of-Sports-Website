<?php
/**
 * Checkout Shipping Form Template
 */

$checkout = WC()->checkout();
$title    = isset( $settings['checkout_shipping_form_title_text'] ) ? $settings['checkout_shipping_form_title_text'] : '';

if ( Elementor\Plugin::instance()->editor->is_edit_mode() ) :
	if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
		<form>
			<div class="woocommerce-shipping-fields">
				<h3 id="ship-to-different-address">
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
						<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1"/>
						<span><?php echo ! empty( $title ) ? $title : esc_html__( 'Ship to a different address?', 'woocommerce' ); ?></span>
					</label>
				</h3>
				<div class="shipping_address">
					<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

					<div class="woocommerce-shipping-fields__field-wrapper">
						<?php
							$fields = $checkout->get_checkout_fields( 'shipping' );

							foreach ( $fields as $key => $field ) {
								woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
							}
						?>
					</div>
					<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>
				</div>
			</div>
		</form>
	<?php endif;
elseif ( is_checkout() ) :
	if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
		<div class="woocommerce-shipping-fields">
			<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
				<h3 id="ship-to-different-address">
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
						<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1"/>
						<span><?php echo ! empty( $title ) ? $title : esc_html__( 'Ship to a different address?', 'woocommerce' ); ?></span>
					</label>
				</h3>
				<div class="shipping_address">
					<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

					<div class="woocommerce-shipping-fields__field-wrapper">
						<?php
							$fields = $checkout->get_checkout_fields( 'shipping' );

							foreach ( $fields as $key => $field ) {
								woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
							}
						?>
					</div>
					<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif;
endif;
