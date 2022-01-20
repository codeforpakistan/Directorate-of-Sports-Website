<?php


namespace JET_ABAF\Formbuilder_Plugin;


use JET_ABAF\Plugin;
use Jet_Form_Builder\Actions\Types\Base;
use Jet_Form_Builder\Gateways\Base_Gateway;

class Gateway_Manager {

	public function __construct() {
		add_filter(
			'jet-form-builder/gateways/notifications-before',
			array( $this, 'before_form_gateway' ), 0, 2
		);
		add_action(
			'jet-form-builder/gateways/on-payment-success',
			array( $this, 'on_gateway_success' )
		);
	}

	public function before_form_gateway( $actions_ids, $actions_all ) {
		foreach ( $actions_all as $action ) {
			/** @var Base $action */
			if ( 'apartment_booking' === $action->get_id() && ! in_array( $action->_id, $actions_ids ) ) {
				$actions_ids[ $action->_id ] = array( 'active' => true );
			}
		}

		return $actions_ids;
	}

	/**
	 * Finalize booking on internal JetFormBuilder form gateway success
	 *
	 * @param Base_Gateway $gateway
	 *
	 * @return void
	 */
	public function on_gateway_success( Base_Gateway $gateway ) {
		$form_data = $gateway->property( 'data' )['form_data'];

		if ( ! isset( $form_data['booking_id'] ) || ! $form_data['booking_id'] ) {
			return;
		}

		Plugin::instance()->db->update_booking(
			$form_data['booking_id'],
			array(
				'status' => 'completed',
			)
		);
	}

}