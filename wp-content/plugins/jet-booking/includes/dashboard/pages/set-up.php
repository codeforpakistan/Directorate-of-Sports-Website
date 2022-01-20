<?php

namespace JET_ABAF\Dashboard\Pages;

use JET_ABAF\Dashboard\Helpers\Page_Config;
use JET_ABAF\Plugin;

/**
 * Base dashboard page
 */
class Set_Up extends Base {

	/**
	 * Page slug
	 *
	 * @return string
	 */
	public function slug() {
		return 'jet-abaf-set-up';
	}

	/**
	 * Page title
	 *
	 * @return string
	 */
	public function title() {
		return esc_html__( 'Set Up', 'jet-booking' );
	}

	/**
	 * Page render funciton
	 *
	 * @return void
	 */
	public function render() {
		echo '<div id="jet-abaf-set-up-page"></div>';
	}

	/**
	 * Return  page config object
	 *
	 * @return [type] [description]
	 */
	public function page_config() {
		return new Page_Config(
			$this->slug(),
			array(
				'active_jet_form_builder' => function_exists( 'jet_form_builder' ),
				'form_options'            => array(
					array(
						'value' => 'install_jfb_create_form',
						'label' => __( 'Install or Activate <b>JetFormBuilder</b> and create a form in it.', 'jet-booking' )
					),
					array(
						'value' => 'je_create_form',
						'label' => __( 'Create <b>JetEngine</b> form.', 'jet-booking' )
					),
					array(
						'value' => 'not',
						'label' => __( "Don't create a form.", 'jet-booking' )
					)
				)
			)
		);
	}

	/**
	 * Define that is setup page
	 *
	 * @return boolean [description]
	 */
	public function is_setup_page() {
		return true;
	}

	/**
	 * Page specific assets
	 *
	 * @return [type] [description]
	 */
	public function assets() {

		$this->enqueue_script( $this->slug(), 'admin/set-up.js' );
		$this->enqueue_style( $this->slug(), 'admin/set-up.css' );

	}

	/**
	 * Set to true to hide page from admin menu
	 * @return boolean [description]
	 */
	public function is_hidden() {
		return Plugin::instance()->settings->get( 'hide_setup' );
	}

	/**
	 * Page components templates
	 *
	 * @return [type] [description]
	 */
	public function vue_templates() {
		return array(
			'set-up',
		);
	}

}