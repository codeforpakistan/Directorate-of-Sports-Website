<?php
namespace JET_ABAF;

/**
 * WooCommerce integration class
 *
 * @property WC_Order_Details_Builder details
 *
 * Class WC_Integration
 * @package JET_ABAF
 */
class WC_Integration {

	use Wc_Integration_Trait;

	private $is_enbaled     = false;
	private $product_id     = 0;
	private $price_adjusted = false;
	public  $product_key    = '_is_jet_booking';
	public  $data_key       = 'booking_data';
	public  $price_key      = 'wc_booking_price';
	public  $form_data_key  = 'booking_form_data';
	public  $form_id_key    = 'booking_form_id';
	public  $details;

	/**
	 * Constructor for the class
	 */
	public function __construct() {

		if ( ! class_exists( '\WooCommerce' ) ) {
			return;
		}

		add_action( 'jet-abaf/settings/before-write', array( $this, 'maybe_create_booking_product' ) );

		$this->set_status();

		if ( ! $this->get_status() || ! $this->get_product_id() ) {
			return;
		}

		// Form-related
		add_action( 'jet-abaf/form/notification/success', array( $this, 'process_wc_notification' ), 10, 2 );
		add_action( 'jet-abaf/jet-fb/action/success', array( $this, 'process_wc_notification' ), 10, 2 );

		// Cart related
		add_filter( 'woocommerce_get_item_data', array( $this, 'add_formatted_cart_data' ), 10, 2 );
		add_filter( 'woocommerce_get_cart_contents', array( $this, 'set_booking_price' ) );
		add_filter( 'woocommerce_cart_item_name', array( $this, 'set_booking_name' ), 10, 2 );
		add_filter( 'woocommerce_checkout_get_value', array( $this, 'maybe_set_checkout_defaults' ), 10, 2 );

		// Order related
		add_action( 'woocommerce_checkout_order_processed', array( $this, 'process_order' ), 10, 3 );
		add_action( 'woocommerce_thankyou', array( $this, 'order_details' ), 0 );
		add_action( 'woocommerce_view_order', array( $this, 'order_details' ), 0 );
		add_action( 'woocommerce_email_order_meta', array( $this, 'email_order_details' ), 0, 3 );
		add_action( 'woocommerce_admin_order_data_after_shipping_address', array( $this, 'admin_order_details' ) );
		add_action( 'woocommerce_order_status_changed', array( $this, 'update_status_on_order_update' ), 10, 4 );

		$this->details = new WC_Order_Details_Builder();

	}

	/**
	 * Set checkout default fields values for checkout forms
	 */
	public function maybe_set_checkout_defaults( $value, $field ) {

		$fields = WC()->session->get( 'jet_booking_fields' );

		if ( ! empty( $fields ) && ! empty( $fields[ $field ] ) ) {
			return $fields[ $field ];
		} else {
			return $value;
		}

	}

	/**
	 * Returns checkout fields list
	 */
	public function get_checkout_fields() {

		if ( ! $this->get_status() ) {
			return array();
		}

		$result = array(
			'billing_first_name',
			'billing_last_name',
			'billing_email',
			'billing_phone',
			'billing_company',
			'billing_country',
			'billing_address_1',
			'billing_address_2',
			'billing_city',
			'billing_state',
			'billing_postcode',
			'shipping_first_name',
			'shipping_last_name',
			'shipping_company',
			'shipping_country',
			'shipping_address_1',
			'shipping_address_2',
			'shipping_city',
			'shipping_state',
			'shipping_postcode',
			'order_comments',
		);

		return apply_filters( 'jet-booking/wc-integration/checkout-fields', $result );

	}

	/**
	 * Update an booking status on related order update
	 *
	 * @return [type] [description]
	 */
	public function update_status_on_order_update( $order_id, $old_status, $new_status, $order ) {

		$booking = $this->get_booking_by_order_id( $order_id );

		if ( ! $booking ) {
			return;
		}

		$this->set_order_data( $booking, $order_id, $order );

	}

	/**
	 * Process new order creation
	 *
	 * @param  [type] $order [description]
	 * @param  [type] $data  [description]
	 * @return [type]        [description]
	 */
	public function process_order( $order_id, $data, $order ) {

		$cart = WC()->cart->get_cart_contents();

		foreach ( $cart as $item ) {
			if ( ! empty( $item[ $this->data_key ] ) ) {
				$this->set_order_data(
					$item[ $this->data_key ],
					$order_id,
					$order,
					$item
				);
			}
		}

	}

	/**
	 * Setup order data
	 */
	public function set_order_data( $data, $order_id, $order, $cart_item = array() ) {

		$booking_id = ! empty( $data['booking_id'] ) ? absint( $data['booking_id'] ) : false;

		if ( ! $booking_id ) {
			return;
		}

		Plugin::instance()->db->update_booking(
			$booking_id,
			array(
				'order_id' => $order_id,
				'status'   => $order->get_status(),
			)
		);

		do_action( 'jet-booking/wc-integration/process-order', $order_id, $order, $cart_item );

	}

	/**
	 * Set booking name for checkout order details
	 *
	 * @param [type] $title [description]
	 * @param [type] $item  [description]
	 */
	public function set_booking_name( $title, $item ) {

			if ( empty( $item[ $this->data_key ] ) ) {
				return $title;
			}

			$data      = $item[ $this->data_key ];
			$apartment = ! empty( $data['apartment_id'] ) ? absint( $data['apartment_id'] ) : false;

			if ( ! $apartment ) {
				return $title;
			}

			$title = $this->get_apartment_label() . ': ' . get_the_title( $apartment );

			return $title;

		}

	/**
	 * Set custom price per appointemnt
	 *
	 * @param [type] $cart [description]
	 */
	public function set_booking_price( $cart_items ) {

		if ( $this->price_adjusted ) {
			return $cart_items;
		}

		if ( ! empty( $cart_items ) ) {

			foreach ( $cart_items as $item ) {
				if ( ! empty( $item[ $this->data_key ] ) ) {

					$data         = $item[ $this->data_key ];
					$apartment_id = ! empty( $data['apartment_id'] ) ? $data['apartment_id'] : 0;

					if ( ! empty( $item[ $this->price_key ] ) ) {
						$price = $item[ $this->price_key ];
					} else {

						$price = get_post_meta( $apartment_id, '_apartment_price', true );
						$price = floatval( $price );
						$diff  = $data['check_out_date'] - $data['check_in_date'];
						$diff  = ceil( $diff / DAY_IN_SECONDS );

						if ( ! Plugin::instance()->engine_plugin->is_per_nights_booking() ) {
							$diff++;
						}

						$advanced_price_rates = new Advanced_Price_Rates( $apartment_id );
						$rates                = $advanced_price_rates->get_rates();

						if ( ! empty( $rates ) ) {
							foreach ( $rates as $rate ) {

								$duration = absint( $rate['duration'] );

								if ( $diff >= $duration ) {
									$price = floatval( $rate['value'] );
								}

							}
						}

						$price = $price * $diff;

					}

					if ( $price ) {
						$item['data']->set_price( floatval( $price ) );
					}

					$this->price_adjusted = true;

				}
			}
		}

		return $cart_items;

	}

	/**
	 * Add booking infor,ation into cart meta data
	 *
	 * @param [type] $item_data [description]
	 * @param [type] $cart_item [description]
	 */
	public function add_formatted_cart_data( $item_data, $cart_item ) {

		if ( ! empty( $cart_item[ $this->data_key ] ) ) {
			$item_data = array_merge(
				$item_data,
				$this->get_formatted_info(
					$cart_item[ $this->data_key ],
					$cart_item[ $this->form_data_key ],
					$cart_item[ $this->form_id_key ]
				)
			);
		}

		return $item_data;

	}

	public function order_details_template( $order_id, $template = 'order-details' ) {

		$booking = $this->get_booking_by_order_id( $order_id );

		if ( ! $booking ) {
			return;
		}

		$details = apply_filters(
			'jet-booking/wc-integration/pre-get-order-details', false, $order_id, $booking
		);

		if ( ! $details ) {
			$booking_title = get_the_title( $booking['apartment_id'] );
			$from          = ! empty( $booking['check_in_date'] ) ? absint( $booking['check_in_date'] ) : false;
			$to            = ! empty( $booking['check_out_date'] ) ? absint( $booking['check_out_date'] ) : false;

			if ( ! $from || ! $to ) {
				return;
			}

			$from = date_i18n( get_option( 'date_format' ), $from );
			$to   = date_i18n( get_option( 'date_format' ), $to );

			$details = array(
				array(
					'key'     => '',
					'display' => $booking_title,
				),
				array(
					'key'     => __( 'Check In', 'jet-booking' ),
					'display' => $from,
				),
				array(
					'key'     => __( 'Check Out', 'jet-booking' ),
					'display' => $to,
				),
			);

		}

		$details = apply_filters(
			'jet-booking/wc-integration/order-details', $details, $order_id, $booking
		);

		include Plugin::instance()->get_template( $template . '.php' );

	}

	/**
	 * Show booking-related order details on order page
	 *
	 * @param  [type] $order_id [description]
	 * @return [type]           [description]
	 */
	public function order_details( $order_id ) {
		$this->order_details_template( $order_id );
	}

		/**
	 * Show booking-related order details on order page
	 *
	 * @param  [type] $order_id [description]
	 * @return [type]           [description]
	 */
	public function email_order_details( $order, $sent_to_admin, $plain_text ) {

		if ( $plain_text ) {
			$template = 'email-order-details-plain';
		} else {
			$template = 'email-order-details-html';
		}

		$this->order_details_template( $order->get_id(), $template );

	}

	/**
	 * Returns booking detail by order id
	 *
	 * @return [type] [description]
	 */
	public function get_booking_by_order_id( $order_id ) {

		$booking = Plugin::instance()->db->get_booking_by( 'order_id', $order_id );

		if ( ! $booking || ! $booking['apartment_id'] ) {
			return false;
		}

		return $booking;

	}

	/**
	 * Admin order details
	 *
	 * @param  [type] $order [description]
	 * @return [type]        [description]
	 */
	public function admin_order_details( $order ) {

		$order_id    = $order->get_id();
		$booking = $this->get_booking_by_order_id( $order_id );

		if ( ! $booking ) {
			return;
		}

		$booking_title = get_the_title( $booking['apartment_id'] );
		$from          = ! empty( $booking['check_in_date'] ) ? absint( $booking['check_in_date'] ) : false;
		$to            = ! empty( $booking['check_out_date'] ) ? absint( $booking['check_out_date'] ) : false;

		if ( ! $from || ! $to ) {
			return;
		}

		$from = date_i18n( get_option( 'date_format' ), $from );
		$to   = date_i18n( get_option( 'date_format' ), $to );

		include JET_ABAF_PATH . 'templates/admin/order/details.php';

	}

	/**
	 * Get formatted booking information
	 *
	 * @return [type] [description]
	 */
	public function get_formatted_info( $data = array(), $form_data = array(), $form_id = null ) {

		$pre_cart_info = apply_filters(
			'jet-booking/wc-integration/pre-cart-info',
			false, $data, $form_data, $form_id
		);

		if ( $pre_cart_info ) {
			return $pre_cart_info;
		}

		$from   = ! empty( $data['check_in_date'] ) ? absint( $data['check_in_date'] ) : false;
		$to     = ! empty( $data['check_out_date'] ) ? absint( $data['check_out_date'] ) : false;
		$result = array();

		if ( ! $from || ! $to ) {
			return;
		}

		$result[] = array(
			'key'     => __( 'Check In', 'jet-bookings-booking' ),
			'display' => date_i18n( get_option( 'date_format' ), $from ),
		);

		$result[] = array(
			'key'     => __( 'Check Out', 'jet-bookings-booking' ),
			'display' => date_i18n( get_option( 'date_format' ), $to ),
		);

		return apply_filters( 'jet-booking/wc-integration/cart-info', $result, $data, $form_data, $form_id );

	}

	/**
	 * Returns apartment CPT label
	 *
	 * @return [type] [description]
	 */
	public function get_apartment_label() {

		$cpt = Plugin::instance()->settings->get( 'apartment_post_type' );

		if ( ! $cpt ) {
			return null;
		}

		$cpt_object = get_post_type_object( $cpt );

		if ( ! $cpt_object ) {
			return null;
		}

		return $cpt_object->labels->singular_name;

	}

	/**
	 * Check if we need to create new Appointment product
	 *
	 * @return [type] [description]
	 */
	public function maybe_create_booking_product( $settings ) {

		$new_status = $settings->get( 'wc_integration' );

		if ( ! $new_status ) {
			return;
		}

		$product_id = $settings->get( 'wc_product_id' );

		if ( $product_id ) {
			return;
		}

		$product_id = $this->get_product_id_from_db();

		if ( ! $product_id ) {
			$product_id = $this->create_booking_product();
		}

		$settings->update( 'wc_product_id', $product_id, false );

	}

	/**
	 * Try to get previousle created product ID in db.
	 * @return [type] [description]
	 */
	public function get_product_id_from_db() {

		global $wpdb;

		$table      = $wpdb->postmeta;
		$key        = $this->product_key;
		$product_id = $wpdb->get_var(
			"SELECT `post_id` FROM $table WHERE `meta_key` = '$key' ORDER BY post_id DESC;"
		);

		if ( ! $product_id ) {
			return false;
		}

		if ( 'product' !== get_post_type( $product_id ) ) {
			return false;
		}

		return absint( $product_id );
	}

	/**
	 * Returns product name
	 *
	 * @return [type] [description]
	 */
	public function get_product_name() {

		return apply_filters(
			'jet-abaf/wc-integration/product-name',
			__( 'Booking', 'jet-booking' )
		);

	}

	/**
	 * Create new booking product
	 *
	 * @return [type] [description]
	 */
	public function create_booking_product() {

		$product = new \WC_Product_Simple( 0 );

		$product->set_name( $this->get_product_name() );
		$product->set_status( 'publish' );
		$product->set_price( 1 );
		$product->set_regular_price( 1 );
		$product->set_slug( sanitize_title( $this->get_product_name() ) );

		$product->save();

		$product_id = $product->get_id();

		if ( $product_id ) {
			update_post_meta( $product_id, $this->product_key, true );
		}

		return $product_id;

	}

	/**
	 * Set WC integration status
	 */
	public function set_status() {

		$is_enbaled       = Plugin::instance()->settings->get( 'wc_integration' );
		$product_id       = Plugin::instance()->settings->get( 'wc_product_id' );
		$this->is_enbaled = filter_var( $is_enbaled, FILTER_VALIDATE_BOOLEAN );
		$this->product_id = $product_id;

	}

	/**
	 * Return WC integration status
	 *
	 * @return [type] [description]
	 */
	public function get_status() {
		return $this->is_enbaled;
	}

	/**
	 * Return WC integration product
	 *
	 * @return [type] [description]
	 */
	public function get_product_id() {
		return $this->product_id;
	}

}