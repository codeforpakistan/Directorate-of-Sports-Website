<?php

namespace JET_ABAF;

use JET_ABAF\Formbuilder_Plugin\Form_Manager;
use JET_ABAF\Formbuilder_Plugin\Jfb_Plugin as Builder_Plugin;

/**
 * Plugin setup class
 */
class Set_Up {

	private $setup_page = null;
	private $success_page = null;

	public function __construct() {
		add_filter( 'jet-abaf/dashboard/helpers/page-config/config', array( $this, 'check_setup' ) );
		add_action( 'wp_ajax_jet_abaf_setup', array( $this, 'process_setup' ) );
	}

	/**
	 * Process setup
	 *
	 * @return [type] [description]
	 */
	public function process_setup() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		$setup_data     = ! empty( $_REQUEST['setup_data'] ) ? $_REQUEST['setup_data'] : array();
		$db_columns     = ! empty( $_REQUEST['db_columns'] ) ? $_REQUEST['db_columns'] : array();
		$add_providers  = false;
		$create_forms   = array();
		$wc_integration = false;
		$rel_post_type  = false;

		if ( ! isset( $setup_data['wc_integration'] ) ) {
			$setup_data['wc_integration'] = false;
		}

		// Clear existing settings before processing set up
		Plugin::instance()->settings->clear();

		$bool = array(
			'wc_integration',
		);

		$form_actions = array(
			'create_single_form',
		);

		if ( ! empty( $setup_data ) ) {
			foreach ( $setup_data as $setting => $value ) {

				if ( in_array( $setting, $bool ) ) {
					$value = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
				} else {
					$value = is_array( $value ) ? $value : esc_attr( $value );
				}

				switch ( $setting ) {
					case 'wc_integration':
						$wc_integration = $value;
						break;

					case 'related_post_type':
						if ( $value ) {
							$rel_post_type = true;
						}
						break;
				}

				if ( Plugin::instance()->settings->setting_registered( $setting ) ) {
					Plugin::instance()->settings->update( $setting, $value, false );
				} elseif ( in_array( $setting, $form_actions ) ) {
					if ( $value ) {
						$create_forms[ $setting ] = $value;
					}
				}

			}
		}

		if ( $rel_post_type || $wc_integration ) {
			$db_columns[] = array( 'column' => 'order_id' );
			Plugin::instance()->settings->update( 'related_post_type_column', 'order_id', false );
		}

		if ( ! empty( $db_columns ) ) {
			Plugin::instance()->settings->update( 'additional_columns', $db_columns, false );
		}

		Plugin::instance()->settings->hook_db_columns();

		Plugin::instance()->db->create_bookings_table( true );
		Plugin::instance()->db->create_units_table( true );

		Plugin::instance()->settings->update( 'is_set', true, false );
		Plugin::instance()->settings->write();

		$created_forms = array();

		if ( ! empty( $create_forms ) ) {
			foreach ( $create_forms as $form_type => $mode ) {
				switch ( $mode ) {
					case 'install_jfb_create_form':
						$result = Builder_Plugin::install_and_activate();
						if ( $result['success'] ) {
							jet_form_builder_init();
							jet_form_builder()->init_components();
							jet_form_builder()->post_type->register_post_type();

							$created_forms[] = Form_Manager::instance()->insert_form( $form_type );
						}
						break;
					case 'je_create_form':
						$created_forms[] = $this->insert_form( $form_type );
						break;
					case 'true':
						$created_forms[] = Form_Manager::instance()->insert_form( $form_type );
						break;
				}
			}
		}

		$edit_link          = esc_url( admin_url( 'edit.php' ) );
		$bookings_cpt       = Plugin::instance()->settings->get( 'apartment_post_type' );
		$orders_cpt         = Plugin::instance()->settings->get( 'related_post_type' );
		$bookings_page_link = false;
		$orders_page_link   = false;

		if ( $bookings_cpt ) {
			$bookings_page_link = add_query_arg(
				array( 'post_type' => $bookings_cpt ),
				$edit_link
			);
		}

		if ( $orders_cpt ) {
			$orders_page_link = add_query_arg(
				array( 'post_type' => $orders_cpt ),
				$edit_link
			);
		}

		$product_id = Plugin::instance()->settings->get( 'wc_product_id' );

		if ( $product_id ) {
			$product_link = get_edit_post_link( $product_id, 'url' );
		} else {
			$product_link = false;
		}

		wp_send_json_success( array(
			'settings_url'  => $this->success_page->get_url(),
			'bookings_page' => $bookings_page_link,
			'orders_page'   => $orders_page_link,
			'forms'         => array_filter( $created_forms ),
			'wc'            => array(
				'enabled' => Plugin::instance()->settings->get( 'wc_integration' ),
				'link'    => $product_link,
			),
		) );

	}

	/**
	 * Insert form
	 *
	 * @return [type] [description]
	 */
	public function insert_form( $form ) {

		if ( ! jet_engine()->modules->is_module_active( 'booking-forms' ) ) {
			jet_engine()->modules->activate_module( 'booking-forms' );
		}

		$post_title         = __( 'Booking Form', 'jet-booking' );
		$form_data          = '[]';
		$notifications_data = '[]';
		$order_post_type    = Plugin::instance()->settings->get( 'related_post_type' );
		$wc_integration     = Plugin::instance()->settings->get( 'wc_integration' );

		switch ( $form ) {
			case 'create_single_form':

				$post_title = __( 'Single Page Booking Form', 'jet-booking' );
				$form_data  = '[{\"x\":0,\"y\":0,\"w\":12,\"h\":1,\"i\":\"0\",\"settings\":{\"name\":\"room_id\",\"desc\":\"\",\"required\":\"required\",\"type\":\"hidden\",\"hidden_value\":\"post_id\",\"hidden_value_field\":\"\",\"field_options_from\":\"manual_input\",\"field_options_key\":\"\",\"field_options\":[],\"label\":\"Current Post ID\",\"calc_formula\":\"\",\"precision\":2,\"is_message\":false,\"is_submit\":false,\"default\":\"\"},\"moved\":false},{\"x\":0,\"y\":5,\"w\":12,\"h\":1,\"i\":\"1\",\"settings\":{\"label\":\"Submit\",\"name\":\"Submit\",\"is_message\":false,\"is_submit\":true,\"type\":\"submit\",\"alignment\":\"right\",\"class_name\":\"\"},\"moved\":false},{\"x\":0,\"y\":1,\"w\":12,\"h\":1,\"i\":\"2\",\"settings\":{\"name\":\"your_email\",\"desc\":\"\",\"required\":\"required\",\"type\":\"text\",\"visibility\":\"all\",\"field_type\":\"email\",\"hidden_value\":\"\",\"hidden_value_field\":\"\",\"field_options_from\":\"manual_input\",\"field_options_key\":\"\",\"field_options\":[],\"label\":\"Your e-mail\",\"calc_formula\":\"\",\"precision\":2,\"is_message\":false,\"is_submit\":false,\"class_name\":\"\"},\"moved\":false},{\"x\":0,\"y\":2,\"w\":12,\"h\":1,\"i\":\"3\",\"settings\":{\"name\":\"your_name\",\"desc\":\"\",\"required\":\"required\",\"type\":\"text\",\"visibility\":\"all\",\"field_type\":\"text\",\"hidden_value\":\"\",\"hidden_value_field\":\"\",\"field_options_from\":\"manual_input\",\"field_options_key\":\"\",\"field_options\":[],\"label\":\"Your name:\",\"calc_formula\":\"\",\"precision\":2,\"is_message\":false,\"is_submit\":false,\"class_name\":\"\"},\"moved\":false},{\"x\":0,\"y\":4,\"w\":12,\"h\":1,\"i\":\"4\",\"settings\":{\"name\":\"_dates\",\"desc\":\"\",\"required\":\"required\",\"type\":\"check_in_out\",\"visibility\":\"all\",\"field_type\":\"text\",\"hidden_value\":\"\",\"hidden_value_field\":\"\",\"field_options_from\":\"manual_input\",\"field_options_key\":\"\",\"field_options\":[],\"label\":\"Check In/Check Out\",\"calc_formula\":\"\",\"precision\":2,\"is_message\":false,\"is_submit\":false,\"class_name\":\"\",\"cio_field_layout\":\"single\",\"cio_fields_position\":\"list\",\"first_field_label\":\"Check In:\",\"second_field_label\":\"Check Out:\"},\"moved\":false},{\"x\":0,\"y\":3,\"w\":12,\"h\":1,\"i\":\"6\",\"settings\":{\"name\":\"phone_number\",\"desc\":\"\",\"required\":\"required\",\"type\":\"text\",\"visibility\":\"all\",\"field_type\":\"tel\",\"hidden_value\":\"\",\"hidden_value_field\":\"\",\"field_options_from\":\"manual_input\",\"field_options_key\":\"\",\"field_options\":[],\"label\":\"Phone Number\",\"calc_formula\":\"\",\"precision\":2,\"is_message\":false,\"is_submit\":false,\"class_name\":\"\"},\"moved\":false},{\"x\":0,\"y\":6,\"w\":12,\"h\":1,\"i\":\"6\",\"settings\":{\"name\":\"order_id\",\"desc\":\"\",\"required\":\"required\",\"type\":\"hidden\",\"visibility\":\"all\",\"field_type\":\"text\",\"hidden_value\":\"\",\"hidden_value_field\":\"\",\"field_options_from\":\"manual_input\",\"field_options_key\":\"\",\"field_options\":[],\"label\":\"\",\"calc_formula\":\"\",\"precision\":2,\"is_message\":false,\"is_submit\":false,\"class_name\":\"\"},\"moved\":false}]';

				if ( $order_post_type ) {
					$notifications_data = '[{\"type\":\"insert_post\",\"mail_to\":\"admin\",\"hook_name\":\"send\",\"custom_email\":\"\",\"from_field\":\"\",\"post_type\":\"orders-post-type\",\"fields_map\":{\"your_email\":\"\"},\"email\":[],\"post_status\":\"draft\"},{\"type\":\"apartment_booking\",\"mail_to\":\"admin\",\"hook_name\":\"send\",\"custom_email\":\"\",\"from_field\":\"\",\"post_type\":\"\",\"fields_map\":{},\"email\":[],\"booking_apartment_field\":\"room_id\",\"booking_dates_field\":\"_dates\",\"db_columns_map_order_id\":\"inserted_post_id\",\"db_columns_map_user_email\":\"your_email\"}]';

					$notifications_data = str_replace( 'orders-post-type', $order_post_type, $notifications_data );

				} else {
					$notifications_data = '[{\"type\":\"apartment_booking\",\"mail_to\":\"admin\",\"hook_name\":\"send\",\"custom_email\":\"\",\"from_field\":\"\",\"post_type\":\"\",\"fields_map\":{},\"email\":[],\"booking_apartment_field\":\"room_id\",\"booking_dates_field\":\"_dates\",\"db_columns_map_order_id\":\"inserted_post_id\",\"db_columns_map_user_email\":\"your_email\"}]';
				}

				break;

		}

		$post_id = wp_insert_post( array(
			'post_title'  => $post_title,
			'post_type'   => 'jet-engine-booking',
			'post_status' => 'publish',
			'meta_input'  => array(
				'_captcha' => array(
					'enabled' => false,
					'key'     => '',
					'secret'  => '',
				),
				'_preset'  => array(
					'enabled'    => false,
					'from'       => 'post',
					'post_from'  => 'current_post',
					'user_from'  => 'current_user',
					'query_var'  => '_post_id',
					'fields_map' => array(),
				),
			),
		) );

		if ( ! $post_id || is_wp_error( $post_id ) ) {
			return false;
		} else {

			update_post_meta( $post_id, '_form_data', $form_data );
			update_post_meta( $post_id, '_notifications_data', $notifications_data );

			return array(
				'id'    => $post_id,
				'title' => $post_title,
				'link'  => get_edit_post_link( $post_id, 'url' ),
			);
		}

	}

	/**
	 * Register setup page for the plugin.
	 * If page already registerd will throw the error
	 *
	 * @param  [type] $setup [description]
	 *
	 * @return [type]        [description]
	 */
	public function register_setup_page( $setup_page ) {

		if ( null !== $this->setup_page ) {
			trigger_error( 'Setup page is already registered!' );
		} else {
			$this->setup_page = $setup_page;
		}

	}

	/**
	 * Register setup success page
	 *
	 * @return [type] [description]
	 */
	public function register_setup_success_page( $success_page ) {

		if ( null !== $this->success_page ) {
			trigger_error( 'Setup page is already registered!' );
		} else {
			$this->success_page = $success_page;
		}

	}

	/**
	 * Check if plugin is correctly configured and pass this data into appropriate
	 * @return [type] [description]
	 */
	public function check_setup( $args = array() ) {

		$result = array(
			'is_set'    => false,
			'setup_url' => null,
		);

		$is_set = Plugin::instance()->settings->get( 'is_set' );

		if ( ! $is_set ) {
			$is_set = Plugin::instance()->db->is_bookings_table_exists();
		}

		$result = array(
			'is_set'    => $is_set,
			'setup_url' => $this->setup_page->get_url(),
		);

		$args['setup'] = $result;

		if ( Plugin::instance()->dashboard->is_page_now( $this->setup_page ) ) {

			$args['reset'] = array(
				'is_reset'  => ! empty( $_GET['jet_abaf_reset'] ) ? true : false,
				'reset_url' => add_query_arg( array( 'jet_abaf_reset' => 1 ), $this->setup_page->get_url() ),
			);

			$args['post_types'] = \Jet_Engine_Tools::get_post_types_for_js();
			$args['db_fields']  = Plugin::instance()->db->get_default_fields();

		}

		return $args;

	}

}