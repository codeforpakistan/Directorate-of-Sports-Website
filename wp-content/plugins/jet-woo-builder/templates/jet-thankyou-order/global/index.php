<?php
/**
 * Thank You Order Template
 */

defined( 'ABSPATH' ) || exit;

$settings               = $this->get_settings_for_display();
$order_thankyou_message = esc_html__( $settings['thankyou_message_text'], 'jet-woo-builder' );
$order                  = jet_woo_builder_template_functions()->get_current_received_order();

if ( ! $order ) {
	return;
}

if ( $order->has_status( 'failed' ) ) : ?>
	<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

	<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
		<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
		<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
		<?php endif; ?>
	</p>
<?php else : ?>
	<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', $order_thankyou_message, $order ); ?></p>

	<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

		<li class="woocommerce-order-overview__order order">
			<?php echo ! empty( $settings['thankyou_order_table_order_heading'] ) ? esc_html__( $settings['thankyou_order_table_order_heading'], 'jet-woo-builder' ) : esc_html__( 'Order number:', 'woocommerce' ); ?>
			<strong><?php echo $order->get_order_number(); ?></strong>
		</li>

		<li class="woocommerce-order-overview__date date">
			<?php echo ! empty( $settings['thankyou_order_table_date_heading'] ) ? esc_html__( $settings['thankyou_order_table_date_heading'], 'jet-woo-builder' ) : esc_html__( 'Date:', 'woocommerce' ); ?>
			<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
		</li>

		<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
			<li class="woocommerce-order-overview__email email">
				<?php echo ! empty( $settings['thankyou_order_table_email_heading'] ) ? esc_html__( $settings['thankyou_order_table_email_heading'], 'jet-woo-builder' ) : esc_html__( 'Email:', 'woocommerce' ); ?>
				<strong><?php echo $order->get_billing_email(); ?></strong>
			</li>
		<?php endif; ?>

		<li class="woocommerce-order-overview__total total">
			<?php echo ! empty( $settings['thankyou_order_table_total_heading'] ) ? esc_html__( $settings['thankyou_order_table_total_heading'], 'jet-woo-builder' ) : esc_html__( 'Total:', 'woocommerce' ); ?>
			<strong><?php echo $order->get_formatted_order_total(); ?></strong>
		</li>

		<?php if ( $order->get_payment_method_title() ) : ?>
			<li class="woocommerce-order-overview__payment-method method">
				<?php echo ! empty( $settings['thankyou_order_table_payment_method_heading'] ) ? esc_html__( $settings['thankyou_order_table_payment_method_heading'], 'jet-woo-builder' ) : esc_html__( 'Payment method:', 'woocommerce' ); ?>
				<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
			</li>
		<?php endif; ?>

	</ul>
<?php endif; ?>
	<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
