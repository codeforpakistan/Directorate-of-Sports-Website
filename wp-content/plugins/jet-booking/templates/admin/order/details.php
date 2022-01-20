<?php
/**
 * Admin order details
 */
?>
<hr>
<h3><?php esc_html_e( 'Booking Details', 'jet-booking' ); ?></h3>
<p>
	<strong><?php echo $booking_title; ?></strong><br>
	<?php esc_html_e( 'Check In', 'jet-booking' ); ?>: <strong><?php echo $from; ?></strong><br>
	<?php esc_html_e( 'Check Out', 'jet-booking' ); ?>: <strong><?php echo $to; ?></strong><br>
</p>