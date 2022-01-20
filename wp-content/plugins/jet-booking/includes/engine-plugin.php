<?php
namespace JET_ABAF;

// If this file is called directly, abort.
use JET_ABAF\Form_Fields\Check_In_Out_Render;
use JET_ABAF\Vendor\Actions_Core\Smart_Notification_Trait;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plug-in code into JetEngine
 */
class Engine_Plugin {

    use Apartment_Booking_Trait;
    use Smart_Notification_Trait;

	private $done         = false;
	private $deps_added   = false;
	private $booked_dates = array();
	public  $default      = false;

	public $namespace = 'jet-form';

	public function __construct() {

		// Register field for booking form
		add_filter(
			'jet-engine/forms/booking/field-types',
			array( $this, 'register_dates_field' )
		);

		// Regsiter notification for booking form
		add_filter(
			'jet-engine/forms/booking/notification-types',
			array( $this, 'register_booking_notification' )
		);

		add_action(
			'jet-engine/forms/booking/notifications/fields-after',
			array( $this, 'notification_fields' )
		);

		add_filter(
			'jet-engine/calculated-data/ADVANCED_PRICE',
			array( $this, 'macros_advanced_price' ), 10, 2
		);

		add_action(
			'jet-engine/forms/edit-field/before',
			array( $this, 'edit_fields' )
		);

		$check_in_out = new Check_In_Out_Render();
		// Add form field template
		add_action(
			'jet-engine/forms/booking/field-template/check_in_out',
			array( $check_in_out, 'getFieldTemplate' ), 10, 3
		);

		// Register notification handler
		add_filter(
			'jet-engine/forms/booking/notification/apartment_booking',
			array( $this, 'do_action' ), 1, 2
		);

		add_filter(
			'jet-engine/forms/gateways/notifications-before',
			array( $this, 'before_form_gateway' ), 1, 2
		);
		
		add_filter(
			'jet-engine/forms/handler/query-args',
			[ $this, 'handler_query_args' ], 10, 3
		);

		add_action(
			'jet-engine/forms/gateways/on-payment-success',
			array( $this, 'on_gateway_success' ), 10, 3
		);

		add_action(
			'jet-engine/forms/editor/macros-list',
			array( $this, 'add_macros_list' ), 10, 0
		);
	}

	/**
	 * Set bookng appointment notification before gateway
	 *
	 * @param  [type] $keep [description]
	 * @param  [type] $all  [description]
	 * @return [type]       [description]
	 */
	public function before_form_gateway( $keep, $all ) {

		foreach ( $all as $index => $notification ) {
			if ( 'apartment_booking' === $notification['type'] && ! in_array( $index, $keep ) ) {
				$keep[] = $index;
			}
		}

		return $keep;

	}
	
	public function handler_query_args( $query_args, $args, $handler_instance ) {
		$field_name = false;
		
		foreach ( $handler_instance->form_fields as $field ) {
			if( 'check_in_out' === $field['type'] ){
				$field_name = $field[ 'name' ];
			}
		}
		
		if( $field_name ){
			$query_args[ 'new_date' ] = $handler_instance->notifcations->data[ $field_name ];
		}

		return $query_args;
	}

	
	
	/**
	 * Finalize booking on internal JetEngine form gateway success
	 *
	 * @return [type] [description]
	 */
	public function on_gateway_success( $form_id, $settings, $form_data ) {

		$booking_id = $form_data['booking_id'];

		if ( $booking_id ) {
			Plugin::instance()->db->update_booking(
				$booking_id,
				array(
					'status' => 'completed',
				)
			);
		}

	}

	/**
	 * Register new dates fields
	 *
	 * @return [type] [description]
	 */
	public function register_dates_field( $fields ) {
		$fields['check_in_out'] = esc_html__( 'Check-in/check-out dates', 'jet-booking' );
		return $fields;
	}

	/**
	 * Register booking notifications
	 *
	 * @param  [type] $notifications [description]
	 * @return [type]                [description]
	 */
	public function register_booking_notification( $notifications ) {
		$notifications['apartment_booking'] = esc_html__( 'Apartment booking', 'jet-booking' );
		return $notifications;
	}

	/**
	 * Macros _advanced_apartment_price processing in the calculator field
	 *
	 */
	public function macros_advanced_price( $macros, $macros_matches ) {
		return $macros;
	}

	/**
	 * Render additional edit fields
	 *
	 * @return [type] [description]
	 */
	public function edit_fields() {
		?>
		<div class="jet-form-editor__row" v-if="'check_in_out' === currentItem.settings.type">
			<div class="jet-form-editor__row-label"><?php esc_html_e( 'Layout:', 'jet-booking' ); ?></div>
			<div class="jet-form-editor__row-control">
				<select type="text" v-model="currentItem.settings.cio_field_layout">
					<option value="single"><?php
						esc_html_e( 'Single field', 'jet-booking' );
					?></option>
					<option value="separate"><?php
						esc_html_e( 'Separate fields for check in and check out dates', 'jet-booking' );
					?></option>
				</select>
			</div>
		</div>
		<div class="jet-form-editor__row" v-if="'check_in_out' === currentItem.settings.type">
			<div class="jet-form-editor__row-label"><?php esc_html_e( 'Fields position:', 'jet-booking' ); ?></div>
			<div class="jet-form-editor__row-control">
				<select type="text" v-model="currentItem.settings.cio_fields_position">
					<option value="inline"><?php
						esc_html_e( 'Inline', 'jet-booking' );
					?></option>
					<option value="list"><?php
						esc_html_e( 'List', 'jet-booking' );
					?></option>
				</select>
				<div><i>* - For separate fields layout</i></div>
			</div>
		</div>
		<div class="jet-form-editor__row" v-if="'check_in_out' === currentItem.settings.type">
			<div class="jet-form-editor__row-label"><?php esc_html_e( 'Check In field label:', 'jet-booking' ); ?></div>
			<div class="jet-form-editor__row-control">
				<input type="text" v-model="currentItem.settings.first_field_label">
				<div><i>* - if you are using separate fields for check in and check out dates,<br> you need to left default "Label" empty and use this option for field label</i></div>
			</div>
		</div>
		<div class="jet-form-editor__row" v-if="'check_in_out' === currentItem.settings.type">
			<div class="jet-form-editor__row-label"><?php esc_html_e( 'Placeholder:', 'jet-booking' ); ?></div>
			<div class="jet-form-editor__row-control">
				<input type="text" v-model="currentItem.settings.first_field_placeholder">
			</div>
		</div>
		<div class="jet-form-editor__row" v-if="'check_in_out' === currentItem.settings.type">
			<div class="jet-form-editor__row-label"><?php esc_html_e( 'Check Out field label:', 'jet-booking' ); ?></div>
			<div class="jet-form-editor__row-control">
				<input type="text" placeholder="For separate fields layout" v-model="currentItem.settings.second_field_label">
			</div>
		</div>
		<div class="jet-form-editor__row" v-if="'check_in_out' === currentItem.settings.type">
			<div class="jet-form-editor__row-label"><?php esc_html_e( 'Check Out field placeholder:', 'jet-booking' ); ?></div>
			<div class="jet-form-editor__row-control">
				<input type="text" placeholder="For separate fields layout" v-model="currentItem.settings.second_field_placeholder">
			</div>
		</div>
		<div class="jet-form-editor__row" v-if="'check_in_out' === currentItem.settings.type">
			<div class="jet-form-editor__row-label"><?php esc_html_e( 'Date format:', 'jet-booking' ); ?></div>
			<div class="jet-form-editor__row-control">
				<select type="text" v-model="currentItem.settings.cio_fields_format">
					<option value="YYYY-MM-DD">YYYY-MM-DD</option>
					<option value="MM-DD-YYYY">MM-DD-YYYY</option>
					<option value="DD-MM-YYYY">DD-MM-YYYY</option>
				</select>
				<div><i>* - applies only for date in the form checkin/checkout fields</i></div>
				<div><i>* - for `MM-DD-YYYY` date format use the `/` date separator</i></div>
			</div>
		</div>
		<div class="jet-form-editor__row" v-if="'check_in_out' === currentItem.settings.type">
			<div class="jet-form-editor__row-label"><?php esc_html_e( 'Date field separator:', 'jet-booking' ); ?></div>
			<div class="jet-form-editor__row-control">
				<select type="text" v-model="currentItem.settings.cio_fields_separator">
					<option value="-">-</option>
					<option value=".">.</option>
					<option value="/">/</option>
					<option value="space">Space</option>
				</select>
			</div>
		</div>
		<div class="jet-form-editor__row" v-if="'check_in_out' === currentItem.settings.type">
			<div class="jet-form-editor__row-label"><?php esc_html_e( 'First day of the week:', 'jet-booking' ); ?></div>
			<div class="jet-form-editor__row-control">
				<select type="text" v-model="currentItem.settings.start_of_week">
					<option value="monday"><?php esc_html_e( 'Monday', 'jet-booking' ); ?></option>
					<option value="sunday"><?php esc_html_e( 'Sunday', 'jet-booking' ); ?></option>
				</select>
			</div>
		</div>
		<?php
	}

	/**
	 * Render additional notification fields
	 *
	 * @return [type] [description]
	 */
	public function notification_fields() {
		?>
		<div class="jet-form-editor__row" v-if="'apartment_booking' === currentItem.type">
			<div class="jet-form-editor__row-label"><?php
				esc_html_e( 'Apartment ID field:', 'jet-booking' );
			?></div>
			<div class="jet-form-editor__row-control">
				<select v-model="currentItem.booking_apartment_field">
					<option value="">--</option>
					<option v-for="field in availableFields" :value="field">{{ field }}</option>
				</select>
			</div>
		</div>
		<div class="jet-form-editor__row" v-if="'apartment_booking' === currentItem.type">
			<div class="jet-form-editor__row-label"><?php
				esc_html_e( 'Check-in/Check-out date field:', 'jet-booking' );
			?></div>
			<div class="jet-form-editor__row-control">
				<select v-model="currentItem.booking_dates_field">
					<option value="">--</option>
					<option v-for="field in availableFields" :value="field">{{ field }}</option>
				</select>
			</div>
		</div>
		<?php

		$columns = Plugin::instance()->db->get_additional_db_columns();

		if ( $columns ) {
			?>
			<div class="jet-form-editor__row" v-if="'apartment_booking' === currentItem.type">
				<div class="jet-form-editor__row-label">
					<?php esc_html_e( 'DB columns map:', 'jet-booking' ); ?>
					<div class="jet-form-editor__row-notice"><?php
						_e( 'Set <i>inserted_post_id</i> to add inserted post ID for Insert Post notification', 'jet-enegine' );
					?></div>
				</div>
				<div class="jet-form-editor__row-fields">
					<?php foreach ( $columns as $column ) {
					?>
					<div class="jet-form-editor__row-map">
						<span><?php echo $column; ?></span>
						<input type="text" v-model="currentItem.db_columns_map_<?php echo $column; ?>">
					</div>
					<?php
					} ?>
				</div>
			</div>
			<?php
		}

		if ( Plugin::instance()->settings->get( 'wc_integration' ) ) {

		?>
		<div class="jet-form-editor__row" v-if="'apartment_booking' === currentItem.type">
			<div class="jet-form-editor__row-label">
				<?php esc_html_e( 'WooCommerce Price field:', 'jet-booking' ); ?>
				<div class="jet-form-editor__row-notice"><?php
					esc_html_e( 'Select field to get total price from. If not selected price will be get from post meta value.', 'jet-booking' );
				?></div>
			</div>
			<div class="jet-form-editor__row-control">
				<select v-model="currentItem.booking_wc_price">
					<option value="">--</option>
					<option v-for="field in availableFields" :value="field">{{ field }}</option>
				</select>
			</div>
		</div>
		<div class="jet-form-editor__row" v-if="'apartment_booking' === currentItem.type">
			<div class="jet-form-editor__row-label">
				<?php esc_html_e( 'WooCommerce order details:', 'jet-booking' ); ?>
				<div class="jet-form-editor__row-notice"><?php
					esc_html_e( 'Set up booking-related info you want to add to the WooCommerce orders and e-mails', 'jet-booking' );
				?></div>
			</div>
			<div class="jet-form-editor__row-control">
				<button type="button" class="button button-secondary" id="jet-booking-wc-details"><?php esc_html_e( 'Set up', 'jet-booking' ); ?></button>
			</div>
		</div>
		<div class="jet-form-editor__row" v-if="'apartment_booking' === currentItem.type">
			<div class="jet-form-editor__row-label">
				<?php esc_html_e( 'WooCommerce checkout fields map:', 'jet-booking' ); ?>
				<div class="jet-form-editor__row-notice"><?php
					esc_html_e( 'Connect WooCommerce checkout fields to appropriate form fields. This allows you to pre-fill WooCommerce checkout fields after redirect to checkout.', 'jet-booking' );
				?></div>
			</div>
			<div class="jet-form-editor__row-fields jet-wc-checkout-fields">
				<?php foreach ( Plugin::instance()->wc->get_checkout_fields() as $field ) {
				?>
				<div class="jet-form-editor__row-map">
					<span><?php echo $field; ?></span>
					<select v-model="currentItem.wc_fields_map__<?php echo $field; ?>">
						<option value="">--</option>
						<option v-for="field in availableFields" :value="field">{{ field }}</option>
					</select>
				</div>
				<?php
				} ?>
			</div>
		</div>
		<?php
		}

	}

	/**
	 * Check if per nights booking mode
	 *
	 * @return boolean [description]
	 */
	public function is_per_nights_booking() {

		$period = Plugin::instance()->settings->get( 'booking_period' );

		if ( ! $period || 'per_nights' === $period ) {
			$per_nights = true;
		} else {
			$per_nights = false;
		}

		return $per_nights;

	}

	public function enqueue_deps( $post_id ) {

		if ( $this->deps_added ) {
			return;
		}

		ob_start();
		include JET_ABAF_PATH . 'assets/js/booking-init.js';
		$init_datepicker = ob_get_clean();

		wp_register_script(
			'moment-js',
			JET_ABAF_URL . 'assets/lib/moment/js/moment.js',
			array(),
			'2.4.0',
			true
		);

		$handle = 'jquery-date-range-picker';

		wp_enqueue_script(
			$handle,
			JET_ABAF_URL . 'assets/lib/jquery-date-range-picker/js/daterangepicker.min.js',
			array( 'jquery', 'moment-js' ),
			JET_ABAF_VERSION,
			true
		);

		wp_add_inline_script( $handle, $init_datepicker );

		$custom_labels   = Plugin::instance()->settings->get( 'use_custom_labels' );
		$weekly_bookings = Plugin::instance()->settings->get( 'weekly_bookings' );
		$weekly_bookings = filter_var( $weekly_bookings, FILTER_VALIDATE_BOOLEAN );
		$week_offset     = false;

		if ( ! $weekly_bookings ) {
			$one_day_bookings = Plugin::instance()->settings->get( 'one_day_bookings' );
		} else {
			$one_day_bookings = false;
			$week_offset      = Plugin::instance()->settings->get( 'week_offset' );
		}

		if ( $weekly_bookings || $one_day_bookings ) {
			$this->default = false;
		}

		$advanced_price_rates = new Advanced_Price_Rates( $post_id );

		$css_url = add_query_arg(
			array( 'v' => JET_ABAF_VERSION ),
			JET_ABAF_URL . 'assets/lib/jquery-date-range-picker/css/daterangepicker.min.css'
		);

		wp_localize_script( $handle, 'JetABAFData', array(
			'css_url'              => $css_url,
			'booked_dates'         => Plugin::instance()->engine_plugin->get_booked_dates( $post_id ),
			'custom_labels'        => $custom_labels,
			'labels'               => Plugin::instance()->settings->get_labels(),
			'weekly_bookings'      => $weekly_bookings,
			'week_offset'          => $week_offset,
			'one_day_bookings'     => $one_day_bookings,
			'per_nights'           => $this->is_per_nights_booking(),
			'advanced_price_rates' => $advanced_price_rates->get_rates(),
			'default_price'        => $advanced_price_rates->get_default_price(),
			'post_id'              => $post_id,
		) );

		$this->deps_added = true;

	}

	public function ensure_ajax_js() {
		if ( wp_doing_ajax() ) {
			wp_scripts()->done[] = 'jquery';
			wp_scripts()->print_scripts( 'jquery-date-range-picker' );
		}
	}

	/**
	 * Returns booked dates
	 *
	 * @return [type] [description]
	 */
	public function get_booked_dates( $post_id ) {

		if ( isset( $this->booked_dates[ $post_id ] ) ) {
			return $this->booked_dates[ $post_id ];
		}

		$bookings  = Plugin::instance()->db->get_future_bookings( $post_id );
		$units     = Plugin::instance()->db->get_apartment_units( $post_id );
		$units_num = ! empty( $units ) ? count( $units ) : 0;
		$dates     = array();

		if ( empty( $bookings ) ) {
			$this->booked_dates[ $post_id ] = array();
			return array();
		}

		$weekly_bookings  = Plugin::instance()->settings->get( 'weekly_bookings' );
		$weekly_bookings  = filter_var( $weekly_bookings, FILTER_VALIDATE_BOOLEAN );
		$week_offset      = Plugin::instance()->settings->get( 'week_offset' );
		$skip_statuses    = Plugin::instance()->statuses->invalid_statuses();
		$skip_statuses[]  = Plugin::instance()->statuses->temporary_status();
		
		if ( ! $units_num || 1 === $units_num ) {

			foreach ( $bookings as $booking ) {

				if ( ! empty( $booking['status'] ) && in_array( $booking['status'], $skip_statuses ) ) {
					continue;
				}

				$from = $booking['check_in_date'];
				$to   = $booking['check_out_date'];
				$from = new \DateTime( date( 'F d, Y', $from ) );
				$to   = new \DateTime( date( 'F d, Y', $to ) );

				$formatted_from = $from->format( 'Y-m-d' );
				$formatted_to   = $to->format( 'Y-m-d' );

				if ( $formatted_from === $formatted_to ) {
					$dates[] = $formatted_from;
					continue;
				}

				if ( $weekly_bookings ) {
					if ( ! $week_offset ) {
						$to = $to->modify( '+1 day' );
					}
				} elseif ( ! $this->is_per_nights_booking() ) {
					$to = $to->modify( '+1 day' );
				}

				if ( $to->format( 'Y-m-d' ) === $from->format( 'Y-m-d' ) ) {
					$dates[] = $from->format( 'Y-m-d' );
				} else {

					$period = new \DatePeriod( $from, new \DateInterval( 'P1D' ), $to );

					foreach ( $period as $key => $value ) {
						$dates[] = $value->format( 'Y-m-d' );
					}
				}

			}

		} else {

			$booked_units = array();

			foreach ( $bookings as $booking ) {

				$from = $booking['check_in_date'];
				$to   = $booking['check_out_date'];
				$from = new \DateTime( date( 'F d, Y', $from ) );
				$to   = new \DateTime( date( 'F d, Y', $to ) );

				if ( ! empty( $booking['status'] ) && in_array( $booking['status'], $skip_statuses ) ) {
					continue;
				}

				if ( $weekly_bookings ) {
					$to = $to->modify( '+1 day' );
				}

				if ( $to->format( 'Y-m-d' ) === $from->format( 'Y-m-d' ) ) {

					if ( empty( $booked_units[ $from->format( 'Y-m-d' ) ] ) ) {
						$booked_units[ $from->format( 'Y-m-d' ) ] = 1;
					} else {
						$booked_units[ $from->format( 'Y-m-d' ) ]++;
					}

				} else {

					$period = new \DatePeriod( $from, new \DateInterval( 'P1D' ), $to );

					foreach ( $period as $key => $value ) {
						if ( empty( $booked_units[ $value->format( 'Y-m-d' ) ] ) ) {
							$booked_units[ $value->format( 'Y-m-d' ) ] = 1;
						} else {
							$booked_units[ $value->format( 'Y-m-d' ) ]++;
						}
					}

				}

			}

			foreach ( $booked_units as $date => $booked_units_num ) {
				if ( $units_num <= $booked_units_num ) {
					$dates[] = $date;
				}
			}

		}

		$this->booked_dates[ $post_id ] = $dates;

		return $dates;

	}


	/**
	 * Adds a macro description to the calculator field
	 *
	 * @return void
	 */
	function add_macros_list(){
		?>
			<br><div><b><?php esc_html_e( 'Booking macros:', 'jet-booking' ); ?></b></div>
			<div><i>%ADVANCED_PRICE::_check_in_out%</i> - <?php esc_html_e( 'The macro will return the advanced rate times the number of days booked.', 'jet-booking' ); ?> <b>_check_in_out</b> <?php esc_html_e( ' - is the name of the field that returns the number of days booked.', 'jet-booking' ); ?></div><br>
			<div><i>%META::_apartment_price%</i> - <?php esc_html_e( 'Macro returns price per 1 day / night', 'jet-booking' ); ?></div>
		<?php
	}
}