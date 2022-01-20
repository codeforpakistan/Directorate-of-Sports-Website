<?php
namespace JET_ABAF\Dashboard;

use JET_ABAF\Plugin;

/**
 * Post meta manager class
 */

class Booking_Meta {

	public $post_type = null;
	public $column    = null;

	/**
	 * Constructir or the class
	 */
	public function __construct() {

		$this->apartment_post_type = Plugin::instance()->settings->get( 'apartment_post_type' );

		if ( $this->apartment_post_type ) {

			add_action(
				'add_meta_boxes_' . $this->apartment_post_type,
				array( $this, 'register_apartments_meta_box' )
			);

			$this->units_manager = new Units_Manager( $this->apartment_post_type );

			add_action( 'jet-engine/meta-boxes/register-instances', array( $this, 'register_price_meta_box' ) );
			add_action( 'wp_ajax_jet_booking_save_price_rates', array( $this, 'save_price_rates' ) );

		}

	}

	/**
	 * Regsiter booking specific metabox on all meta-boxes registration
	 *
	 * @param  [type] $meta_boxes_manager [description]
	 * @return [type]                     [description]
	 */
	public function register_price_meta_box( $meta_boxes_manager ) {

		$object_name = $this->apartment_post_type . '_jet_abaf';

		$meta_boxes_manager->register_custom_group(
			$object_name,
			esc_html__( 'Booking Settings', 'jet-booking' )
		);

		$meta_boxes_manager->register_metabox(
			$this->apartment_post_type,
			array(
				array(
					'type'        => 'number',
                    'min_value'   => '0',
                    'default_val' => '0',
					'name'        => '_apartment_price',
					'title'       => esc_html__( 'Price per 1 day/night', 'jet-booking' ),
				),
			),
			esc_html__( 'Pricing Settings', 'jet-booking' ),
			$object_name
		);

	}

	public function meta_assets() {

		wp_enqueue_style(
			'jet-abaf-meta',
			JET_ABAF_URL . 'assets/css/admin/post.css',
			array(),
			JET_ABAF_VERSION
		);

		$ui_data = jet_engine()->framework->get_included_module_data( 'cherry-x-vue-ui.php' );
		$ui      = new \CX_Vue_UI( $ui_data );

		$ui->enqueue_assets();

		wp_enqueue_script(
			'jet-abaf-meta-extras',
			JET_ABAF_URL . 'assets/js/admin/meta-extras.js',
			array( 'cx-vue-ui' ),
			JET_ABAF_VERSION,
			true
		);

		global $post;

		$pricing_rates = get_post_meta( $post->ID, '_pricing_rates', true );

		if ( ! $pricing_rates ) {
			$pricing_rates = array();
		}

		wp_localize_script( 'jet-abaf-meta-extras', 'JetABAFMetaExtras', array(
			'apartment'       => $post->ID,
			'pricing_rates'   => $pricing_rates,
			'button_label'    => esc_html__( 'Advanced price rates', 'jet-booking' ),
			'confirm_message' => esc_html__( 'Are you sure?', 'jet-booking' ),
			'nonce'           => wp_create_nonce( 'jet-abaf-meta-extras' ),
		) );

		add_action( 'admin_footer', array( $this, 'meta_extras_template' ) );

	}

	public function save_price_rates() {

		$nonce = ! empty( $_REQUEST['nonce'] ) ? $_REQUEST['nonce'] : false;

		if ( ! $nonce || ! wp_verify_nonce( $nonce, 'jet-abaf-meta-extras' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Link is expired', 'jet-booking' ) ) );
		}

		$post_id = ! empty( $_REQUEST['post_id'] ) ? absint( $_REQUEST['post_id'] ) : false;

		if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'You don`t have access to this post', 'jet-booking' ) ) );
		}

		$rates = isset( $_REQUEST['rates'] ) ? $_REQUEST['rates'] : array();

		update_post_meta( $post_id, '_pricing_rates', $rates );

		wp_send_json_success();

	}

	public function meta_extras_template() {
		ob_start();
		include JET_ABAF_PATH . 'templates/admin/common/meta-extras.php';
		$content = ob_get_clean();
		printf( '<div id="jet_abaf_meta_exras"></div><script type="text/x-template" id="jet-abaf-meta-extras">%s</script>', $content );
	}

	/**
	 * Register
	 * @return [type] [description]
	 */
	public function register_apartments_meta_box() {

		add_meta_box(
			'jet-abaf',
			esc_html__( 'Upcoming bookings', 'jet-booking' ),
			array( $this, 'render_apartments_meta_box' ),
			null,
			'normal',
			'high'
		);

		add_action( 'admin_enqueue_scripts', array( $this, 'meta_assets' ) );

	}

	/**
	 * Render apartments metabox
	 *
	 * @return [type] [description]
	 */
	public function render_apartments_meta_box( $post ) {

		$bookings = Plugin::instance()->db->get_future_bookings( $post->ID );

		if ( empty( $bookings ) ) {
			echo '<p style="text-align: center;">There are no upcoming bookings</p>';
			return;
		}

		$columns = array_keys( $bookings[0] );

		?>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr><?php
					foreach ( $columns as $column ) {
						if ( 'apartment_id' !== $column ) {
							echo '<th>' . $column . '</th>';
						}
					}
				?></tr>
			</thead>
			<tbody><?php
				foreach ( $bookings as $row ) {
					?>
					<tr><?php
						foreach ( $row as $key => $column ) {
							if ( 'apartment_id' !== $key ) {

								if ( $this->column && $this->column === $key ) {
									$column = sprintf(
										'<a href="%1$s" target="_blank">#%2$s</a>',
										get_edit_post_link( $column ),
										get_the_title( $column )
									);
								}

								if ( in_array( $key, array( 'check_in_date', 'check_out_date' ) ) ) {
									$column = date_i18n( get_option( 'date_format' ), $column );
								}

								echo '<td>' . $column . '</td>';
							}
						}
					?></tr>
					<?php
				}
			?></tbody>
		</table>
		<?php

	}

}