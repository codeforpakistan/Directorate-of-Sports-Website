<?php


namespace JET_ABAF;


use JET_ABAF\Vendor\Actions_Core\Smart_Notification_Action_Trait;

/**
 *
 * Trait Wc_Integration_Trait
 * @package JET_ABAF
 */
trait Wc_Integration_Trait {

	/**
	 * Process WC-related notification part
	 *
	 * @param $booking
	 * @param Smart_Notification_Action_Trait $action
	 *
	 * @return void [type]       [description]
	 * @throws \Exception
	 */
	public function process_wc_notification( $booking, $action ) {

		if ( ! Plugin::instance()->wc->get_status()
		     || ! Plugin::instance()->wc->get_product_id()
		) {
			return;
		}

		$cart_item_data = array(
			Plugin::instance()->wc->data_key      => $booking,
			Plugin::instance()->wc->form_data_key => $action->getRequest(),
			Plugin::instance()->wc->form_id_key   => $action->getFormId(),
		);

		$price_field = $action->getSettings( 'booking_wc_price' );
		$price       = false;

		if ( $price_field && $action->issetRequest( $price_field ) ) {
			$price = floatval( $action->getRequest( $price_field ) );
		}

		if ( $price ) {
			$cart_item_data[ Plugin::instance()->wc->price_key ] = $price;
		}

		WC()->cart->empty_cart();
		WC()->cart->add_to_cart( Plugin::instance()->wc->get_product_id(), 1, 0, array(), $cart_item_data );

		$checkout_fields_map = array();

		foreach ( $action->getSettings() as $key => $value ) {
			if ( false !== strpos( $key, 'wc_fields_map__' ) && ! empty( $value ) ) {
				$checkout_fields_map[ str_replace( 'wc_fields_map__', '', $key ) ] = $value;
			}
		}

		if ( ! empty( $checkout_fields_map ) ) {

			$checkout_fields = array();

			foreach ( $checkout_fields_map as $checkout_field => $form_field ) {
				if ( $action->issetRequest( $form_field ) ) {
					$checkout_fields[ $checkout_field ] = $action->getRequest( $form_field );
				}
			}

			if ( ! empty( $checkout_fields ) ) {
				WC()->session->set( 'jet_booking_fields', $checkout_fields );
			}
		}

		$action->filterQueryArgs( function ( $query_args, $handler, $args ) use ( $action ) {
			$url = apply_filters( 'jet-engine/forms/handler/wp_redirect_url', wc_get_checkout_url() );

			if ( $action->isAjax() ) {
				$query_args['redirect'] = $url;

				return $query_args;
			} else {
				wp_redirect( $url );
				die();
			}
		} );
	}

}