<?php
namespace JET_ABAF\Dashboard;

use JET_ABAF\Plugin;

/**
 * Units manager class
 */

class Units_Manager {

	public $apartment_post_type;
	private $base_url = null;

	/**
	 * Constructor class
	 *
	 * @param [type] $apartment_post_type [description]
	 */
	public function __construct( $apartment_post_type ) {

		$this->apartment_post_type = $apartment_post_type;

		add_action(
			'add_meta_boxes_' . $this->apartment_post_type,
			array( $this, 'register_meta_box' )
		);

		add_action( 'wp_ajax_jet_abaf_get_units', array( $this, 'get_units' ) );
		add_action( 'wp_ajax_jet_abaf_insert_units', array( $this, 'insert_units' ) );
		add_action( 'wp_ajax_jet_abaf_delete_unit', array( $this, 'delete_unit' ) );
		add_action( 'wp_ajax_jet_abaf_update_unit', array( $this, 'update_unit' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'init_units_manager' ), 99 );

	}

	/**
	 * Register
	 * @return [type] [description]
	 */
	public function register_meta_box() {

		add_meta_box(
			'jet-abaf-units',
			esc_html__( 'Units manager', 'jet-booking' ),
			array( $this, 'render_meta_box' ),
			null,
			'normal',
			'high'
		);
	}

	public function render_meta_box() {
		echo '<div id="jet_abaf_apartment_units"></div>';
	}

	/**
	 * Delete unit
	 *
	 * @return [type] [description]
	 */
	public function delete_unit() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		$request   = file_get_contents( 'php://input' );
		$request   = json_decode( $request, true );
		$apartment = ! empty( $request['apartment'] ) ? absint( $request['apartment'] ) : false;
		$unit      = ! empty( $request['unit'] ) ? absint( $request['unit'] ) : false;

		if ( ! $apartment ) {
			wp_send_json_error();
		}

		Plugin::instance()->db->delete_unit(
			array(
				'apartment_id' => $apartment,
				'unit_id'      => $unit,
			)
		);

		$result = Plugin::instance()->db->get_apartment_units( $apartment );

		wp_send_json_success( array( 'units' => $result ) );

	}

	/**
	 * Update unit
	 *
	 * @return [type] [description]
	 */
	public function update_unit() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		$request   = file_get_contents( 'php://input' );
		$request   = json_decode( $request, true );
		$apartment = ! empty( $request['apartment'] ) ? absint( $request['apartment'] ) : false;
		$unit      = ! empty( $request['unit'] ) ? $request['unit'] : false;

		if ( ! $apartment || ! $unit ) {
			wp_send_json_error();
		}

		$unit_id = isset( $unit['unit_id'] ) ? $unit['unit_id'] : false;

		if ( ! $unit_id ) {
			wp_send_json_error();
		}

		Plugin::instance()->db->update_unit( $unit_id, $unit );

		$result = Plugin::instance()->db->get_apartment_units( $apartment );

		wp_send_json_success( array( 'units' => $result ) );

	}

	/**
	 * Returns available units list
	 *
	 * @return [type] [description]
	 */
	public function get_units() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		$apartment = ! empty( $_REQUEST['apartment'] ) ? absint( $_REQUEST['apartment'] ) : false;

		if ( ! $apartment ) {
			wp_send_json_error();
		}

		$result = Plugin::instance()->db->get_apartment_units( $apartment );

		wp_send_json_success( array( 'units' => $result ) );

	}

	/**
	 * Insert new units of appartment
	 *
	 * @return [type] [description]
	 */
	public function insert_units() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		$request = file_get_contents( 'php://input' );
		$request = json_decode( $request, true );

		if ( empty( $request ) ) {
			wp_send_json_error();
		}

		$apartment = ! empty( $request['apartment'] ) ? absint( $request['apartment'] ) : false;
		$number    = ! empty( $request['number'] ) ? absint( $request['number'] ) : 1;
		$title     = ! empty( $request['title'] ) ? esc_attr( $request['title'] ) : false;

		if ( ! $apartment ) {
			wp_send_json_error();
		}

		if ( ! $title ) {
			$title = get_the_title( $apartment );
		}

		$db_instant = Plugin::instance()->db;
		$result = $db_instant->get_apartment_units( $apartment );

		$current_count = count( $result );

		for ( $i = 1; $i <= $number; $i++ ) {

			$num = $current_count + $i;

			$db_instant::wpdb()->insert( $db_instant::units_table(), array(
				'apartment_id' => $apartment,
				'unit_title'   => $title . ' ' . $num,
			) );
		}

		$result = $db_instant->get_apartment_units( $apartment );

		wp_send_json_success( array( 'units' => $result ) );

	}

	/**
	 * Initialize units manager
	 *
	 * @return [type] [description]
	 */
	public function init_units_manager( $hook ) {

		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
			return;
		}

		if ( $this->apartment_post_type !== get_post_type() ) {
			return;
		}

		if ( ! function_exists( 'jet_engine' ) ) {
			return;
		}

		$ui_data = jet_engine()->framework->get_included_module_data( 'cherry-x-vue-ui.php' );
		$ui      = new \CX_Vue_UI( $ui_data );

		$ui->enqueue_assets();

		wp_enqueue_script(
			'jet-abaf-units-manager',
			JET_ABAF_URL . 'assets/js/admin/units-manager.js',
			array( 'cx-vue-ui', 'wp-api-fetch' ),
			JET_ABAF_VERSION,
			true
		);

		global $post;

		wp_localize_script( 'jet-abaf-units-manager', 'JetABAFUnitsData', array(
			'apartment'    => $post->ID,
			'insert_units' => $this->get_action_url( 'insert_units' ),
			'get_units'    => $this->get_action_url( 'get_units', array( 'apartment' => $post->ID ) ),
			'delete_unit'  => $this->get_action_url( 'delete_unit' ),
			'update_unit'  => $this->get_action_url( 'update_unit' ),
		) );

		add_action( 'admin_footer', array( $this, 'unit_manager_template' ) );

	}

	/**
	 * Returns action URL
	 *
	 * @return [type] [description]
	 */
	public function get_action_url( $action = null, $args = array() ) {

		if ( ! $this->base_url ) {
			$this->base_url = admin_url( 'admin-ajax.php' );
		}

		return add_query_arg( array_merge( array( 'action' => 'jet_abaf_' . $action ), $args ), $this->base_url );

	}

	/**
	 * LOad units manager template
	 *
	 * @return [type] [description]
	 */
	public function unit_manager_template() {
		ob_start();
		include JET_ABAF_PATH . 'templates/units-manager.php';
		$content = ob_get_clean();
		printf( '<script type="text/x-template" id="jet-abaf-units-manager">%s</script>', $content );
	}

}