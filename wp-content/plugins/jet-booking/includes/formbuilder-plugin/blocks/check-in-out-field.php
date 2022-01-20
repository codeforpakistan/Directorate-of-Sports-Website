<?php


namespace JET_ABAF\Formbuilder_Plugin\Blocks;


use JET_ABAF\Plugin;
use Jet_Form_Builder\Blocks\Types\Base;
use Jet_Form_Builder\Live_Form;

class Check_In_Out_Field extends Base {

	/**
	 * @return string
	 */
	public function get_name() {
		return 'check-in-out';
	}

	public function get_path_metadata_block() {
		$path_parts = array( 'assets', 'gutenberg', 'src', 'blocks', $this->get_name() );
		$path       = implode( DIRECTORY_SEPARATOR, $path_parts );

		return JET_ABAF_PATH . $path;
	}

	/**
	 * @param null $wp_block
	 *
	 * @return mixed
	 */
	public function get_block_renderer( $wp_block = null ) {
		return ( new Check_In_Out_Render( $this ) )->getFieldTemplate();
	}
}