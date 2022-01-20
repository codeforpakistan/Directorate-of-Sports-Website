<?php
namespace JET_APB;

use JET_APB\Time_Slots;
use JET_APB\Time_Range;
use JET_APB\Time_Recurring;
use JET_APB\Appointment_Price;

/**
 * Time_Types class
 */
class Time_Types {

	static $close_button = '<div class="jet-apb-calendar-slots__close">&times;</div>';
	
	public static function render_frontend_view( $args = null ){
		if( empty( $args ) ){
			return '';
		}

		$output = [
			'booking_type' => Plugin::instance()->settings->get( 'booking_type' ),
			'slots' => '',
			'settings' => '',
		];
		
		switch ( $output['booking_type'] ){
			case "range":
				$view = self::get_range_view( $args );

				$output['slots']    = $view[ 'slots' ];
				$output['settings'] = $view[ 'settings' ];
				break;
				
			case "recurring":
				$view = self::get_recurring_view( $args );

				$output['slots']                    = $view[ 'slots' ];
				$output['recurrence_settings_html'] = $view[ 'settings_html' ];
				$output['settings']                 = $view[ 'settings' ];
				break;
				
			default:
				$view = self::get_slots_view( $args );

				$output['slots'] = $view[ 'slots' ];
				break;
		}
		
		if ( empty( $view['slots'] ) ) {
			$output['slots'] = esc_html__( 'No available slots', 'jet-appointments-booking' );
		}

		if( ! $args['admin'] ) {
			$output['slots'] .= self::$close_button;
		}
		
		return $output;
	}
	
	public static function get_slots_view( $args =null  ){
		$result = [
			'slots' => Plugin::instance()->calendar->get_date_slots( $args['service'], $args['provider'], $args['date'], $args['time'], $args['selected_slots'] ),
			'settings'=> '',
		];
		$result['slots'] = ! empty( $result['slots'] ) ? $result['slots'] : [] ;
		
		if( ! $args['admin'] ) {
			ob_start();
			
			$price_instans = new Appointment_Price( $args );
			$price = $price_instans->get_price();

			$format = Plugin::instance()->settings->get('slot_time_format');
			
			Time_Slots::generate_slots_html( $result['slots'], $format, ['data-price="' . $price['price'] . '"'], $args['date'], $args['service'] );
			
			$result['slots'] = ob_get_clean();
		}
		
		return $result;
	}
	
	public static function get_range_view( $args =null  ){
		$result = [
			'slots' => '',
			'settings'=> '',
		];

		if( ! $args['admin'] ){
			$result['slots'] = Time_Range::get_range_view( $args );
		}else{
			$result['settings'] = Time_Range::get_settings( $args );
			$result['slots']    =  $result['settings']['min_max_time']['max'] ? true : null;
		}

		return $result;
	}
	
	public static function get_recurring_view( $args =null  ){
		$result = [
			'slots' => '',
			'settings'=> '',
			'settings_html'=> '',
		];
		
		if( ! $args['admin'] ){
			$result = Time_Recurring::get_recurring_view( $args );
		}else{
			$result['slots']    = Time_Recurring::get_slots( $args );
			$result['settings'] = Time_Recurring::get_settings( $args );
		}

		return $result;
	}

}
