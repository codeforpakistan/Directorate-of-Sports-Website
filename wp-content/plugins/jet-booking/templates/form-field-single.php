<?php
/**
 * Render check-in checkout fields for booking form
 *
 * @var Check_In_Out_Render $this
 */

use JET_ABAF\Formbuilder_Plugin\Blocks\Check_In_Out_Render;

$placeholder = $this->getArgs( 'first_field_placeholder', '', 'esc_attr' );;
$default     = $this->getArgs( 'default', '' );

if ( $options ) {
	$date_format = $options['date_format'];

	$checkin = isset( $options['checkin'] ) ? $options['checkin'] : '' ;
	$checkout = isset( $options['checkout'] ) ? $options['checkout'] : '' ;

	$default = sprintf( '%1$s - %2$s', $checkin, $checkout );
}

if ( $field_separator ) {
	if ( 'space' === $field_separator ) {
		$field_separator = ' ';
	}
	$field_format = str_replace( '-', $field_separator, $field_format );
}

?>
<div class="jet-abaf-field">
	<input
		type="text"
		id="jet_abaf_field"
		class="jet-abaf-field__input <?php echo $this->scopeClass( '__field' ) ?>"
		placeholder="<?php echo $placeholder; ?>"
		autocomplete="off"
		data-field="checkin-checkout"
		data-format="<?php echo $field_format; ?>"
		name="<?php echo $args['name']; ?>"
		<?php if ( ! empty( $args['required'] ) ) {
			echo 'required';
		} ?>
		value="<?php echo $default; ?>"
		readonly
	>
</div>
<?php jet_abaf()->engine_plugin->ensure_ajax_js(); ?>