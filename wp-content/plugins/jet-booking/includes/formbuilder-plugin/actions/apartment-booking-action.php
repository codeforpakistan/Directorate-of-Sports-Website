<?php


namespace JET_ABAF\Formbuilder_Plugin\Actions;


use JET_ABAF\Apartment_Booking_Trait;
use JET_ABAF\Plugin;
use JET_ABAF\Vendor\Actions_Core\Smart_Action_Trait;
use Jet_Form_Builder\Actions\Types\Base;

class Apartment_Booking_Action extends Base {

	use Apartment_Booking_Trait;
	use Smart_Action_Trait;

	public function get_id() {
		return 'apartment_booking';
	}

	/**
	 * @return mixed
	 */
	public function get_name() {
		return esc_html__( 'Apartment Booking', 'jet-booking' );
	}

	/**
	 * @return mixed
	 */
	public function visible_attributes_for_gateway_editor() {
		return array( 'booking_apartment_field' );
	}

	/**
	 * @return mixed
	 */
	public function self_script_name() {
		return 'JetBookingActionData';
	}

	public function action_data() {
		$columns        = Plugin::instance()->db->get_additional_db_columns();
		$wc_integration = Plugin::instance()->settings->get( 'wc_integration' ) && Plugin::instance()->wc->details;
		$post_id        = get_the_ID();
		$wc_fields      = array();
		$details        = array();
		$nonce          = '';

		if ( $wc_integration ) {
			$nonce     = wp_create_nonce( Plugin::instance()->wc->details->meta_key );
			$wc_fields = Plugin::instance()->wc->get_checkout_fields();
			$details   = Plugin::instance()->wc->details->get_details_schema( $post_id );
		}

		return array(
			'columns'        => $columns,
			'wc_integration' => $wc_integration,
			'apartment'      => $post_id,
			'wc_fields'      => $wc_fields,
			'details'        => $details,
			'nonce'          => $nonce,
			'details_types'  => array(
				array(
					'value' => 'booked-inst',
					'label' => esc_html__( 'Booked instance name', 'jet-booking' )
				),
				array(
					'value' => 'check-in',
					'label' => esc_html__( 'Check in', 'jet-booking' )
				),
				array(
					'value' => 'check-out',
					'label' => esc_html__( 'Check out', 'jet-booking' )
				),
				array(
					'value' => 'unit',
					'label' => esc_html__( 'Booking unit', 'jet-booking' )
				),
				array(
					'value' => 'field',
					'label' => esc_html__( 'Form field', 'jet-booking' )
				),
				array(
					'value' => 'add_to_calendar',
					'label' => esc_html__( 'Add to Google calendar link', 'jet-booking' )
				),
			)
		);
	}

	/**
	 * @return mixed
	 */
	public function editor_labels() {
		return array(
			'booking_apartment_field' => esc_html__( 'Apartment ID field:', 'jet-booking' ),
			'booking_dates_field'     => esc_html__( 'Check-in/Check-out date field:', 'jet-booking' ),
			'db_columns_map'          => esc_html__( 'DB columns map:', 'jet-booking' ),
			'booking_wc_price'        => esc_html__( 'WooCommerce Price field:', 'jet-booking' ),
			'wc_order_details'        => esc_html__( 'WooCommerce order details:', 'jet-booking' ),
			'wc_fields_map'           => esc_html__( 'WooCommerce checkout fields map:', 'jet-booking' ),
			'wc_details__type'        => esc_html__( 'Type', 'jet-booking' ),
			'wc_details__label'       => esc_html__( 'Label', 'jet-booking' ),
			'wc_details__format'      => esc_html__( 'Date format', 'jet-booking' ),
			'wc_details__field'       => esc_html__( 'Select form field', 'jet-booking' ),
			'wc_details__link_label'  => esc_html__( 'Link text', 'jet-booking' ),
		);
	}

	public function editor_labels_help() {
		return [
			'db_columns_map'   => esc_html__(
				'Set `inserted_post_id` to add inserted post ID for Insert Post notification',
				'jet-booking'
			),
			'booking_wc_price' => esc_html__(
				'Select field to get total price from. If not selected price will be get from post meta value.',
				'jet-booking'
			),
			'wc_order_details' => esc_html__(
				'Set up booking-related info you want to add to the WooCommerce orders and e-mails',
				'jet-booking'
			),
			'wc_fields_map'    => esc_html__(
				'Connect WooCommerce checkout fields to appropriate form fields. 
				This allows you to pre-fill WooCommerce checkout fields after redirect to checkout.',
				'jet-booking'
			),
		];
	}

}