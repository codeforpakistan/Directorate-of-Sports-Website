<?php
/**
 * My Account Logout Template
 */

if ( ! is_user_logged_in() ) {
	return esc_html__( 'You need to logged in first', 'jet-woo-builder' );
}

foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
	if ( $endpoint == 'customer-logout' ): ?>
		<div class="jet-woo-builder-customer-logout">
			<a href="<?php echo esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>"><?php echo esc_html( $label ); ?></a>
		</div>
	<?php endif;
endforeach;