<?php


namespace JET_ABAF\Formbuilder_Plugin;

use JET_ABAF\Plugin;


class Manage_Calculated_Data {

	public function __construct() {
		add_filter(
			'jet-engine/calculated-data/ADVANCED_PRICE',
			function ( $macros, $macros_matches ) {
				return $macros;
			}, 10, 2
		);

		add_filter(
			'jet-form-builder/field-data/calculated-field',
			array( $this, 'prepare_calc_description' )
		);
	}

	public function prepare_calc_description( $content ) {
		ob_start();
		Plugin::instance()->engine_plugin->add_macros_list();

		$content['field_desc'] .= ob_get_clean() . '<br>';

		return $content;
	}

}