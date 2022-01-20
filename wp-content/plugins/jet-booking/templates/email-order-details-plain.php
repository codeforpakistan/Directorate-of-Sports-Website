<?php
/**
 * WooCommerce order details
 */
?>
<?php esc_html_e( 'Booking Details', 'jet-booking' ); ?>
<?php
	foreach ( $details as $item ) {
		?>
		- <?php

			if ( ! empty( $item['key'] ) ) {
				echo $item['key'] . ': ';
			}

			if ( ! empty( $item['is_html'] ) ) {
				echo $item['display_plain'];
			} else {
				echo $item['display'];
			}

		?>
		<?php
	}
?>