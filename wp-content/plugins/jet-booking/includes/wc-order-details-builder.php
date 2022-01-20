<?php
namespace JET_ABAF;

/**
 * WooCommerce ordersdetils builder class
 */
class WC_Order_Details_Builder {

	public $meta_key = '_jet_abaf_wc_details';

	/**
	 * Constructor for the class
	 */
	public function __construct() {
		add_action( 'jet-engine/forms/editor/assets', array( $this, 'enqueue_builder' ) );
		add_action( 'wp_ajax_jet_booking_save_wc_details', array( $this, 'save_wc_details' ) );
		add_filter( 'jet-booking/wc-integration/pre-cart-info', array( $this, 'set_cart_details' ), 10, 4 );
		add_filter( 'jet-booking/wc-integration/pre-get-order-details', array( $this, 'set_order_details' ), 10, 3 );
		add_action( 'jet-booking/wc-integration/process-order', array( $this, 'set_order_meta' ), 10, 3 );
	}

	/**
	 * Set cart order details
	 */
	public function set_cart_details( $result, $data, $form_data, $form_id ) {

		if ( ! $form_id ) {
			return $result;
		}

		return $this->get_order_details( $form_id, $data, $form_data );

	}

	/**
	 * Set order details info
	 *
	 * @param [type] $details  [description]
	 * @param [type] $order_id [description]
	 * @param [type] $booking  [description]
	 */
	public function set_order_details( $details, $order_id, $booking ) {

		$meta = get_post_meta( $order_id, $this->meta_key, true );

		if ( empty( $meta ) ) {
			return $details;
		}

		$form_id   = ! empty( $meta['form_id'] ) ? $meta['form_id'] : false;
		$form_data = ! empty( $meta['form_data'] ) ? $meta['form_data'] : array();

		if ( ! $form_id ) {
			return $details;
		}

		return $this->get_order_details( $form_id, $booking, $form_data );

	}

	/**
	 * Get order details for pased form, booking and form data
	 *
	 * @param  [type] $form_id   [description]
	 * @param  array  $booking   [description]
	 * @param  array  $form_data [description]
	 * @return [type]            [description]
	 */
	public function get_order_details( $form_id = null, $booking = array(), $form_data = array() ) {

		$details = $this->get_details_schema( $form_id );

		if ( false === $details ) {
			return false;
		}

		$result = array();

		foreach ( $details as $item ) {

			switch ( $item['type'] ) {

				case 'booked-inst':
					$result[] = array(
						'key'     => $item['label'],
						'display' => get_the_title( $booking['apartment_id'] ),
					);
					break;

				case 'check-in':
				case 'check-out':

					$date = ( 'check-in' === $item['type'] ) ? absint( $booking['check_in_date'] ) : absint( $booking['check_out_date'] );
					$format = isset( $item['format'] ) ? $item['format'] : get_option( 'date_format' );

					if ( $date ) {
						$result[] = array(
							'key'     => $item['label'],
							'display' => date_i18n( $format, $date ),
						);
					}

					break;

				case 'unit':
					$unit = ! empty( $booking['apartment_unit'] ) ? absint( $booking['apartment_unit'] ) : false;

					if ( $unit ) {

						$unit_data = Plugin::instance()->db->get_apartment_unit( $booking['apartment_id'], $unit );

						if ( ! empty( $unit_data ) ) {
							$unit_data = $unit_data[0];
						}

						if ( ! empty( $unit_data['unit_title'] ) ) {
							$result[] = array(
								'key'     => $item['label'],
								'display' => $unit_data['unit_title'],
							);
						}

					}

					break;

				case 'field':

					$field = isset( $item['field'] ) ? $item['field'] : false;

					if ( $field ) {
						$value = isset( $form_data[ $field ] ) ? $form_data[ $field ] : '';

						if ( is_array( $value ) ) {
							$value = implode( ', ', $value );
						}

						$result[] = array(
							'key'     => $item['label'],
							'display' => $value,
						);

					}

					break;

				case 'add_to_calendar':

					$url = Plugin::instance()->google_cal->get_internal_link( $booking['booking_id'] );

					if ( $url ) {
						$link_text = ! empty( $item['link_label'] ) ? $item['link_label'] : esc_html__( 'Add', 'jet-booking' );
						$link_format = '<strong><a href="%1$s" target="_blank">%2$s</a></strong>';
						$result[] = array(
							'key'           => $item['label'],
							'is_html'       => true,
							'display'       => sprintf( $link_format, $url, $link_text ),
							'display_plain' => $url
						);
					}

					break;

			}

		}

		return $result;

	}

	/**
	 * Stroe form ID and details into order meta
	 *
	 * @param [type] $order_id  [description]
	 * @param [type] $order     [description]
	 * @param [type] $cart_item [description]
	 */
	public function set_order_meta( $order_id, $order, $cart_item ) {

		$id_key  = Plugin::instance()->wc->form_id_key;
		$form_id = ! empty( $cart_item[ $id_key ] ) ? $cart_item[ $id_key ] : false;

		if ( ! $form_id ) {
			return;
		}

		$data_key  = Plugin::instance()->wc->form_data_key;
		$form_data = ! empty( $cart_item[ $data_key ] ) ? $cart_item[ $data_key ] : false;

		if ( empty( $form_data ) ) {
			return;
		}

		$meta = array(
			'form_id'   => $form_id,
			'form_data' => $form_data,
		);

		update_post_meta( $order_id, $this->meta_key, $meta );

	}

	/**
	 * Save WC details settings
	 *
	 * @return [type] [description]
	 */
	public function save_wc_details() {

		$nonce = ! empty( $_REQUEST['nonce'] ) ? $_REQUEST['nonce'] : false;

		if ( ! $nonce || ! wp_verify_nonce( $nonce, $this->meta_key ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Link is expired', 'jet-booking' ) ) );
		}

		$post_id = ! empty( $_REQUEST['post_id'] ) ? absint( $_REQUEST['post_id'] ) : false;

		if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) ) {
			wp_send_json_error( array( 'message' => __( 'You don`t have access to this post', 'jet-booking' ) ) );
		}

		$details = isset( $_REQUEST['details'] ) ? $_REQUEST['details'] : array();

		update_post_meta( $post_id, $this->meta_key, $details );

		wp_send_json_success();

	}

	/**
	 * Returns details config for current form
	 *
	 * @param  [type] $post_id [description]
	 * @return [type]          [description]
	 */
	public function get_details_schema( $post_id = null ) {

		if ( ! $post_id ) {
			global $post;
			$post_id = $post ? $post->ID : false;
		}

		if ( ! $post_id ) {
			return false;
		}

		$details = get_post_meta( $post_id, $this->meta_key );

		if ( ! $details ) {

			$details = array(
				array(
					'type'   => 'check-in',
					'label'  => __( 'Check In', 'jet-booking' ),
					'format' => get_option( 'date_format' ),
				),
				array(
					'type'   => 'check-out',
					'label'  => __( 'Check Out', 'jet-booking' ),
					'format' => get_option( 'date_format' ),
				),
			);
		} else {
			$details = $details[0];
		}

		return $details;

	}

	/**
	 * Enqueue order details builder
	 */
	public function enqueue_builder() {

		wp_enqueue_style(
			'jet-abaf-meta',
			JET_ABAF_URL . 'assets/css/admin/post.css',
			array(),
			JET_ABAF_VERSION
		);

		wp_enqueue_script(
			'jet-abaf-wc-details-builder',
			JET_ABAF_URL . 'assets/js/admin/wc-details-builder.js',
			array( 'jet-engine-forms' ),
			JET_ABAF_VERSION,
			true
		);

		global $post;

		wp_localize_script( 'jet-abaf-wc-details-builder', 'JetABAFWCDetails', array(
			'apartment'       => $post->ID,
			'details'         => $this->get_details_schema( $post->ID ),
			'confirm_message' => __( 'Are you sure?', 'jet-booking' ),
			'nonce'           => wp_create_nonce( $this->meta_key ),
		) );

		add_action( 'admin_footer', array( $this, 'builder_template' ) );

	}

	/**
	 * Include builder compoent template
	 */
	public function builder_template() {
		ob_start();
		include JET_ABAF_PATH . 'templates/admin/common/wc-details-builder.php';
		$content = ob_get_clean();
		printf( '<div id="jet_abaf_wc_details_builder_popup"></div><script type="text/x-template" id="jet-abaf-wc-details-builder">%s</script>', $content );
	}

}