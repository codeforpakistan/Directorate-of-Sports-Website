<?php

/**
 * @var Check_In_Out_Render_Trait $this
 */

use JET_ABAF\Form_Fields\Check_In_Out_Render_Trait;

$f1_label       = $this->getArgs( 'first_field_label', '', 'wp_kses_post' );
$f1_placeholder = $this->getArgs( 'first_field_placeholder', '', 'esc_attr' );

$f2_label       = $this->getArgs( 'second_field_label', '', 'wp_kses_post' );
$f2_placeholder = $this->getArgs( 'second_field_placeholder', '', 'esc_attr' );

$default = $this->getArgs( 'default', '' );

$f1_default = '';
$f2_default = '';

if ( ! empty( $default ) ) {
	$default_values = explode( ' - ', $default );
	$f1_default     = isset( $default_values[0] ) ? $default_values[0] : '';
	$f2_default     = isset( $default_values[1] ) ? $default_values[1] : '';
}

if ( $options ) {
	$date_format = $options['date_format'];

	$f1_default = isset( $options['checkin'] ) ? $options['checkin'] : '';
	$f2_default = isset( $options['checkout'] ) ? $options['checkout'] : '';
	$default    = $f1_default . ' - ' . $f2_default;
}

$col_class = 'jet-abaf-separate-field';

if ( 'list' === $fields_position ) {
	$col_class .= ' jet-form-col-12';
} else {
	$col_class .= ' jet-form-col-6';
}

if ( $field_separator ) {
	if ( 'space' === $field_separator ) {
		$field_separator = ' ';
	}
	$field_format = str_replace( '-', $field_separator, $field_format );
}
?>
    <div class="jet-abaf-separate-fields">
        <div class="<?php echo $col_class; ?>">
			<?php if ( $f1_label ) { ?>
                <div class="jet-abaf-separate-field__label <?php echo $this->scopeClass( '__label' ) ?>"><?php
					echo $f1_label;
					if ( ! empty( $args['required'] ) ) {
						echo '<span class="' . $this->scopeClass( '__required' ) . '">*</span>';
					}
					?></div>
			<?php } ?>
            <div class="jet-abaf-separate-field__control">
                <input
                        type="text"
                        id="jet_abaf_field_1"
                        class="jet-abaf-field__input <?php echo $this->scopeClass( '__field' ) ?>"
                        placeholder="<?php echo $f1_placeholder; ?>"
                        autocomplete="off"
                        name="<?php echo $args['name']; ?>__in"
					<?php if ( ! empty( $args['required'] ) ) {
						echo 'required';
					} ?>
                        value="<?php echo $f1_default; ?>"
                        readonly
                >
            </div>
        </div>
        <div class="<?php echo $col_class; ?>">
			<?php if ( $f2_label ) { ?>
                <div class="jet-abaf-separate-field__label <?php echo $this->scopeClass( '__label' ) ?>"><?php
					echo $f2_label;
					if ( ! empty( $args['required'] ) ) {
						echo '<span class="' . $this->scopeClass( '__required' ) . '">*</span>';
					}
					?></div>
			<?php } ?>
            <div class="jet-abaf-separate-field__control">
                <input
                        type="text"
                        id="jet_abaf_field_2"
                        class="jet-abaf-field__input <?php echo $this->scopeClass( '__field' ) ?>"
                        placeholder="<?php echo $f2_placeholder; ?>"
                        autocomplete="off"
                        name="<?php echo $args['name']; ?>__out"
					<?php if ( ! empty( $args['required'] ) ) {
						echo 'required';
					} ?>
                        value="<?php echo $f2_default; ?>"
                        readonly
                >
            </div>
        </div>
        <input
                type="hidden"
                id="jet_abaf_field_range"
                name="<?php echo $args['name']; ?>"
                data-field="checkin-checkout"
                data-format="<?php echo $field_format; ?>"
                class="<?php echo $this->scopeClass( '__field' ) ?>"
                value="<?php echo $default; ?>"
        >
    </div>
<?php jet_abaf()->engine_plugin->ensure_ajax_js(); ?>