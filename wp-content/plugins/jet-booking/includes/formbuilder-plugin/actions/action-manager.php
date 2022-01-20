<?php


namespace JET_ABAF\Formbuilder_Plugin\Actions;


use JET_ABAF\Formbuilder_Plugin\With_Form_Builder;

/**
 * The script for registering the action
 * is displayed in the
 * JET_ABAF\Formbuilder_Plugin\Blocks\Blocks_Manager class
 *
 * Class Action_Manager
 * @package JET_ABAF\Formbuilder_Plugin\Actions
 */
class Action_Manager {

	use With_Form_Builder;

	public function manager_init() {
		add_action(
			'jet-form-builder/actions/register',
			array( $this, 'register_actions' )
		);
	}

	public function register_actions( $manager ) {
		$manager->register_action_type( new Apartment_Booking_Action() );
	}
}