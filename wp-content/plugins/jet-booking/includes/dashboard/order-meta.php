<?php
namespace JET_ABAF\Dashboard;

use JET_ABAF\Plugin;

/**
 * Post meta manager class
 */

class Order_Meta {

	public $post_type = null;
	public $column    = null;

	/**
	 * Constructir or the class
	 */
	public function __construct() {

		$this->post_type           = Plugin::instance()->settings->get( 'related_post_type' );
		$this->column              = Plugin::instance()->settings->get( 'related_post_type_column' );

		if ( $this->post_type && $this->column ) {
			add_action( 'add_meta_boxes_' . $this->post_type, array( $this, 'register_meta_box' ) );
			add_action( 'wp_ajax_jet_abaf_update_booking', array( $this, 'update_booking' ) );
			add_action( 'delete_post', array( $this, 'delete_booking_on_related_post_delete' ) );
		}

	}

	/**
	 * Register
	 * @return [type] [description]
	 */
	public function register_meta_box() {
		add_meta_box(
			'jet-abaf',
			esc_html__( 'Booking Data', 'jet-booking' ),
			array( $this, 'render_meta_box' ),
			null,
			'side',
			'high'
		);
	}

	/**
	 * Render bookings metabox
	 *
	 * @return [type] [description]
	 */
	public function render_meta_box( $post ) {

		echo '<div class="jet-abaf-booking">';
		$booking = $this->render_booking( $post );
		echo '</div>';

		if ( ! $booking ) {
			return;
		}

		?>
		<script>
			jQuery( document ).ready( function( $ ) {

				"use strict";

				$( document ).on( 'click', '.jet-abaf-edit-booking', function() {

					$( '.jet-abaf-booking-form' ).show();
					$( '.jet-abaf-booking-info' ).hide();

				} );

				$( document ).on( 'click', '.jet-abaf-cancel-edit', function() {

					$( '.jet-abaf-booking-form' ).hide();
					$( '.jet-abaf-booking-info' ).show();

				} );

				$( document ).on( 'click', '.jet-abaf-update-booking', function() {

					var fields = {},
						$this  = $( this ),
						label  = $this.html();

					$( '.jet-abaf-booking-input' ).each(function() {
						var $this = $( this );

						if ( 'booking_id' !== $this.attr( 'name' ) ) {
							fields[ $this.attr( 'name' ) ] = $this.val();
						}

					});

					$this.html( $this.data( 'loading' ) )

					$.ajax({
						url: ajaxurl,
						type: 'POST',
						dataType: 'json',
						data: {
							action: 'jet_abaf_update_booking',
							post: <?php echo $post->ID; ?>,
							booking: <?php echo $booking['booking_id'] ?>,
							fields: fields,
						},
					}).done(function( response ) {

						if ( response.success ) {
							$( '.jet-abaf-booking' ).html( response.data.html );
						} else {
							$( '.jet-abaf-booking' ).append( '<p>' + response.data.html + '</p>' );
						}

						$this.html( label );

					}).fail(function( response ) {
						$this.html( label );
						alert( response.statusText );
					});

				} );

			});
		</script>
		<?php

	}

	/**
	 * UPdate booking information
	 *
	 * @return [type] [description]
	 */
	public function update_booking() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( esc_html__( 'Access denied. Not enough permissions', 'jet-booking' ) );
		}

		$post_id = ! empty( $_REQUEST['post'] ) ? absint( $_REQUEST['post'] ) : false;
		$booking = ! empty( $_REQUEST['booking'] ) ? absint( $_REQUEST['booking'] ) : false;
		$fields  = ! empty( $_REQUEST['fields'] ) ? $_REQUEST['fields'] : false;

		if ( ! $post_id ) {
			wp_send_json_error( array(
				'html' => esc_html__( 'Updated post ID not found in request', 'jet-booking' )
			) );
		}

		if ( ! $fields ) {
			wp_send_json_error( array(
				'html' => esc_html__( 'Updated fields not found in request', 'jet-booking' )
			) );
		}

		$fields['check_out_date'] = ! empty( $fields['check_out_date'] ) ? strtotime( $fields['check_out_date'] ) : false;
		$fields['check_in_date'] = ! empty( $fields['check_in_date'] ) ? strtotime( $fields['check_in_date'] ) : false;

		if ( empty( $fields['check_out_date'] ) || empty( $fields['check_in_date'] ) ) {
			wp_send_json_error( array(
				'html' => esc_html__( 'check_in_date and check_out_date fields can\'t be empty', 'jet-booking' )
			) );
		}

		$fields['apartment_id'] = ! empty( $fields['apartment_id'] ) ? absint( $fields['apartment_id'] ) : 0;

		if ( ! $fields['apartment_id'] ) {
			wp_send_json_error( array(
				'html' => esc_html__( 'apartment_id field can\'t be empty', 'jet-booking' )
			) );
		}

		if ( ! empty( $fields['booking_id'] ) ) {
			unset( $fields['booking_id'] );
		}

		$is_available = Plugin::instance()->db->check_availability_on_update(
			$booking,
			$fields['apartment_id'],
			$fields['check_in_date'],
			$fields['check_out_date']
		);

		if ( ! $is_available ) {

			ob_start();

			echo esc_html__( 'New dates are not available.', 'jet-booking' ) . '<br>';

			if ( Plugin::instance()->db->latest_result ) {

				echo esc_html__( 'Overlapping bookings: ', 'jet-booking' );

				foreach ( Plugin::instance()->db->latest_result as $ob ) {

					$result = array();

					if ( absint( $ob['booking_id'] ) !== $booking && ! empty( $ob[ $this->column ] ) ) {
						$result[] = sprintf(
							'<a href="%1$s" target="_blank">#%2$s</a>',
							get_edit_post_link( $ob[ $this->column ] ),
							$ob[ $this->column ]
						);
					}

					echo implode( ', ', $result );

				}

			}

			wp_send_json_error( array(
				'html' => ob_get_clean()
			) );

		}

		Plugin::instance()->db->update_booking( $booking, $fields );

		ob_start();
		$this->render_booking( get_post( $post_id ) );

		wp_send_json_success( array(
			'html' => ob_get_clean()
		) );

	}

	/**
	 * Render information about current booking and return booking data
	 *
	 * @return [type] [description]
	 */
	public function render_booking( $post ) {

		$booking = Plugin::instance()->db->query( array(
			$this->column => $post->ID,
		) );

		if ( empty( $booking ) ) {
			echo '<p>' . esc_html__( 'Related booking not found', 'jet-booking' ) . '</p>';
			return false;
		}

		$booking = $booking[0];

		echo '<div class="jet-abaf-booking-info">';

		foreach ( $booking as $col => $value ) {

			if ( $col === $this->column ) {
				continue;
			}

			if ( in_array( $col, array( 'check_in_date', 'check_out_date' ) ) ) {
				$value = date_i18n( get_option( 'date_format' ), $value );
			}

			if ( 'apartment_id' === $col ) {

				$new_value = sprintf(
					'<a href="%1$s" target="_blank">%2$s</a>',
					get_permalink( $value ),
					get_the_title( $value )
				);

				$value = $new_value;
			}

			echo '<p><b>' . $col . '</b>: ' . $value . '</p>';
		}

		echo '<p><button type="button" class="button button-default jet-abaf-edit-booking">' . esc_html__( 'Edit', 'jet-booking' ) . '</button></p>';

		echo '</div>';

		echo '<div class="jet-abaf-booking-form" style="display:none;">';

		foreach ( $booking as $col => $value ) {

			if ( $col === $this->column ) {
				continue;
			}

			if ( in_array( $col, array( 'check_in_date', 'check_out_date' ) ) ) {
				$value = date_i18n( get_option( 'date_format' ), $value );
			}

			$disabled = '';

			if ( 'booking_id' === $col ) {
				$disabled = ' disabled';
			}

			echo '<p><b>' . $col . '</b>: <input type="text" class="jet-abaf-booking-input" name="' . $col . '" value="' . $value . '"' . $disabled . '></p>';
		}

		echo '<p><button type="button" class="button button-primary jet-abaf-update-booking" data-loading="' . esc_html__( 'Saving ...' ) . '">' . esc_html__( 'Save' ) . '</button>&nbsp;&nbsp;&nbsp;<button type="button" class="button button-default jet-abaf-cancel-edit">' . esc_html__( 'Cancel' ) . '</button></p>';

		echo '</div>';

		return $booking;

	}

	/**
	 * Delete booking on related post deleteion
	 *
	 * @return [type] [description]
	 */
	public function delete_booking_on_related_post_delete( $post_id ) {

		if ( $this->post_type !== get_post_type( $post_id ) ) {
			return;
		}

		Plugin::instance()->db->delete_booking( array(
			$this->column => $post_id,
		) );

	}

}