<?php
namespace JET_ABAF\Elementor_Integration;

use JET_ABAF\Plugin;

class Manager {

	public function __construct() {
		add_action( 'elementor/init', array( $this, 'init_components' ) );
	}

	public function init_components() {
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ), 10 );
		add_action( 'jet-engine/listings/preview-scripts', array( $this, 'preview_scripts' ) );
		add_action( 'jet-engine/elementor-views/dynamic-tags/register', array( $this, 'register_dynamic_tags' ) );
		add_filter( 'jet-engine/elementor-view/dynamic-link/generel-options', array( $this, 'register_dynamic_link_option' ) );
	}

	public function register_widgets( $widgets_manager ) {
		$widgets_manager->register_widget_type( new Widgets\Calendar() );
	}

	/**
	 * Enqueue preview JS
	 */
	public function preview_scripts() {
		Plugin::instance()->engine_plugin->enqueue_deps( get_the_ID() );
	}

	public function register_dynamic_tags( $tags_module ) {
		$tags_module->register_tag( new Dynamic_Tags\Price_Per_Night() );
	}

	public function register_dynamic_link_option( $options ) {
		$options[ Plugin::instance()->google_cal->query_var ] = esc_html__( 'Jet Booking: add booking to Google calendar', 'jet-booking' );
		return $options;
	}

}