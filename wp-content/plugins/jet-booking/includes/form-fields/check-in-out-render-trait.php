<?php


namespace JET_ABAF\Form_Fields;


use JET_ABAF\Plugin;

/**
 * @method getArgs( $key = '', $ifNotExist = false, $wrap_callable = false )
 * @method isRequired()
 * @method isNotEmptyArg( $key )
 * @method getCustomTemplate( $provider_id, $args )
 * @method scopeClass( $suffix = '' )
 * @method is_block_editor()
 * @method get_queried_post_id()
 *
 * Trait Check_In_Out_Render_Trait
 * @package JET_ABAF\Form_Fields
 */
trait Check_In_Out_Render_Trait {

	public function field_template() {
		$layout = $this->getArgs( 'cio_field_layout', 'single', 'esc_attr' );

		if ( 'single' === $layout ) {
			$template = JET_ABAF_PATH . 'templates/form-field-single.php';
		} else {
			$template = JET_ABAF_PATH . 'templates/form-field-separate.php';
		}

		$searched = Plugin::instance()->session->get( 'searched_dates' );
		$options  = [];

		$field_format    = $this->getArgs( 'cio_fields_format', 'YYYY-MM-DD', 'esc_attr' );
		$field_separator = $this->getArgs( 'cio_fields_separator', '', 'esc_attr' );
		$start_of_week   = $this->getArgs( 'start_of_week', 'monday', 'esc_attr' );
		$return_value    = $this->getArgs( 'cio_return_value', 'days_num', 'esc_attr' );
		$fields_position = $this->getArgs( 'cio_fields_position', 'inline' );
		$default_format  = $field_format;

		$options['start_of_week'] = 'monday';

		if ( $default_format ) {
			switch ( $default_format ) {
				case 'YYYY-MM-DD':
					$default_format = 'Y-m-d';
					break;

				case 'MM-DD-YYYY':
					$default_format = 'm-d-Y';
					break;

				case 'DD-MM-YYYY':
					$default_format = 'd-m-Y';
					break;
			}
		}

		$options['date_format'] = $default_format ? $default_format : 'Y-m-d';

		if ( $field_separator ) {

			if ( 'space' === $field_separator ) {
				$field_separator = ' ';
			}

			$field_format = str_replace( '-', $field_separator, $field_format );

		}

		$booked_dates = Plugin::instance()->engine_plugin->get_booked_dates( $this->get_queried_post_id() );

		if ( $searched ) {

			$searched = explode( ' - ', $searched );

			if ( ! empty( $searched[0] ) && ! empty( $searched[1] ) ) {

				if ( '' !== $field_separator ) {
					$default_format = str_replace( '-', $field_separator, $default_format );
				}

				$checkin  = date( 'Y-m-d', $searched[0] );
				$checkout = date( 'Y-m-d', $searched[1] );

				if ( ! ( in_array( $checkin, $booked_dates ) && in_array( $checkout, $booked_dates ) ) ) {

					if ( in_array( $checkin, $booked_dates ) ) {
						$checkin = end( $booked_dates );
						$checkin = strtotime( $checkin . ' + 1 day' );
						reset( $booked_dates );
					} else {
						$checkin = $searched[0];
					}

					if ( in_array( $checkout, $booked_dates ) ) {
						$checkout = $booked_dates[0];
						$checkout = strtotime( $checkout . ' - 1 day' );
						reset( $booked_dates );
					} else {
						$checkout = $searched[1];
					}

					$options['checkin']  = date( $default_format, $checkin );
					$options['checkout'] = date( $default_format, $checkout );

				}
			}
		}

		Plugin::instance()->engine_plugin->enqueue_deps( $this->get_queried_post_id() );

		wp_localize_script( 'jquery-date-range-picker', 'JetABAFInput', array(
			'layout'        => $layout,
			'field_format'  => $field_format,
			'start_of_week' => $start_of_week,
			'return_value'  => $return_value,
		) );

		$args = $this->getArgs();

		ob_start();
		include $template;

		return ob_get_clean();
	}

}