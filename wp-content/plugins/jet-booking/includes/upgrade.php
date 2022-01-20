<?php
namespace JET_ABAF;

/**
 * Upgrader class
 */
class Upgrade {

	public function __construct() {
		$this->to_2_0();
	}

	/**
	 * Check DB requirements for 2.0 version and show upgrade notice
	 *
	 * @return [type] [description]
	 */
	public function to_2_0() {
		add_action( 'admin_init', function() {

			if ( ! Plugin::instance()->db->is_bookings_table_exists() ) {
				return;
			}

			if ( ! Plugin::instance()->db->column_exists( 'status' ) ) {
				Plugin::instance()->db->insert_table_columns( array( 'status' ) );
			}

			if ( Plugin::instance()->dashboard->is_dashboard_page() ) {
				if ( ! Plugin::instance()->db->column_exists( 'import_id' ) ) {
					Plugin::instance()->db->insert_table_columns( array( 'import_id' ) );
				}
			}

			$wc_integration = Plugin::instance()->settings->get( 'wc_integration' );

			if ( $wc_integration ) {

				$additional_columns = Plugin::instance()->settings->get( 'additional_columns' );
				$has_order_id_col   = false;

				if ( ! empty( $additional_columns ) ) {
					foreach ( $additional_columns as $col ) {

						if ( ! empty( $col['column'] ) && 'order_id' === $col['column'] ) {
							$has_order_id_col = true;
						}

					}
				}

				if ( ! $has_order_id_col ) {

					if ( ! is_array( $additional_columns ) ) {
						$additional_columns = array();
					}

					$additional_columns[] = array( 'column' => 'order_id' );

					Plugin::instance()->settings->update( 'additional_columns', $additional_columns );

					if ( ! Plugin::instance()->db->column_exists( 'order_id' ) ) {
						Plugin::instance()->db->insert_table_columns( array( 'order_id' ) );
					}

				}

			}

		} );
	}

}
