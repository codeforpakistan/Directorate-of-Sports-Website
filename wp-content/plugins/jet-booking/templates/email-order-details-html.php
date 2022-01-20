<?php
/**
 * WooCommerce order details
 */
?>
<h2 style="color:#96588a;display:block;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left"><?php
	esc_html_e( 'Booking Details', 'jet-booking' );
?></h2>
<ul><?php
	foreach ( $details as $item ) {
		echo '<li>';
			if ( ! empty( $item['key'] ) ) {
				echo $item['key'] . ': ';
			}
			if ( ! empty( $item['is_html'] ) ) {
				echo $item['display'];
			} else {
				echo '<strong>' . $item['display'] . '</strong>';
			}
		echo '</li>';
	}
?>
</ul>