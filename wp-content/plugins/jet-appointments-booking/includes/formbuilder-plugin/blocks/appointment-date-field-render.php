<?php


namespace JET_APB\Formbuilder_Plugin\Blocks;

use JET_APB\Form_Fields\Date_Field_Template_Trait;
use JET_APB\Vendor\Fields_Core\Smart_Block_Trait;
use Jet_Form_Builder\Blocks\Render\Base;

class Appointment_Date_Field_Render extends Base {

	use Smart_Block_Trait;
	use Date_Field_Template_Trait;

	/**
	 * @return mixed
	 */
	public function get_name() {
		return 'appointment-date';
	}

}