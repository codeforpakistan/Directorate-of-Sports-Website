<?php
namespace JET_ABAF\Render;

use JET_ABAF\Plugin;

if ( ! class_exists( '\Jet_Engine_Render_Base' ) ) {
	require jet_engine()->plugin_path( 'includes/components/listings/render/base.php' );
}

class Calendar extends \Jet_Engine_Render_Base {

	private $instance_id = false;

	public function get_name() {
		return 'jet-booking-calendar';
	}

	public function render() {

		if ( ! $this->instance_id ) {
			$this->instance_id = 'calendar_' . rand( 1000, 9999 );
		}
		
		$post_id = get_the_ID();

		Plugin::instance()->engine_plugin->enqueue_deps( $post_id );

		$settings        = $this->get_settings();
		$select_dates    = ! empty( $settings['select_dates'] ) ? $settings['select_dates'] : false;
		$scroll_to_form  = ! empty( $settings['scroll_to_form'] ) ? $settings['scroll_to_form'] : false;
		$select_dates    = filter_var( $select_dates, FILTER_VALIDATE_BOOLEAN );
		$scroll_to_form  = filter_var( $scroll_to_form, FILTER_VALIDATE_BOOLEAN );
		$wrapper_classes = array( 'jet-booking-calendar' );

		if ( ! $select_dates ) {
			$wrapper_classes[] = 'disable-dates-select';
		}

		printf(
			'<div class="%2$s"><input type="hidden" class="jet-booking-calendar__input"><div class="jet-booking-calendar__container" id="%1$s" data-scroll-to-form="%3$s"></div></div>',
			$this->instance_id,
			implode( ' ', $wrapper_classes ),
			$scroll_to_form
		);
		
	}

}
