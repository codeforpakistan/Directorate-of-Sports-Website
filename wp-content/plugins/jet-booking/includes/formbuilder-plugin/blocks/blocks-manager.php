<?php


namespace JET_ABAF\Formbuilder_Plugin\Blocks;


use JET_ABAF\Formbuilder_Plugin\With_Form_Builder;

class Blocks_Manager {

	use With_Form_Builder;

	public function manager_init() {
		add_action(
			'jet-form-builder/blocks/register',
			array( $this, 'register_fields' )
		);
		add_action(
			'jet-form-builder/editor-assets/before',
			array( $this, 'editor_assets' )
		);
	}

	public function register_fields( $manager ) {
		$manager->register_block_type( new Check_In_Out_Field() );
	}

	public function editor_assets() {
		wp_enqueue_script(
			'jet-booking-form-builder-fields',
			JET_ABAF_URL . 'assets/js/builder.editor.js',
			array(),
			JET_ABAF_VERSION,
			true
		);
	}

}