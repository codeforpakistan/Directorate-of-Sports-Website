const { __ } = wp.i18n;

const label = {
	cio_field_layout: __( 'Layout:', 'jet-booking' ),
	cio_fields_position: __( 'Fields position:', 'jet-booking' ),
	first_field_label: __( 'Check In field label:', 'jet-booking' ),
	first_field_placeholder: __( 'Placeholder:', 'jet-booking' ),
	second_field_label: __( 'Check Out field label:', 'jet-booking' ),
	second_field_placeholder: __( 'Check Out field placeholder:', 'jet-booking' ),
	cio_fields_format: __( 'Date format:', 'jet-booking' ),
	cio_fields_separator: __( 'Date field separator:', 'jet-booking' ),
	start_of_week: __( 'First day of the week:', 'jet-booking' ),
};

const help = {
	cio_fields_position: __( 'For separate fields layout' ),
	first_field_label: __( `If you are using separate fields for check in and check out dates,
	you need to left default "Label" empty and use this option for field label` ),
	cio_fields_format: __( `Applies only for date in the form checkin/checkout fields.
	For \`MM-DD-YYYY\` date format use the \`/\` date separator` ),
};

const options = {
	cio_field_layout: [
		{
			value: 'single',
			label: __( 'Single field', 'jet-booking' ),
		},
		{
			value: 'separate',
			label: __( 'Separate fields for check in and check out dates', 'jet-booking' ),
		},
	],
	cio_fields_position: [
		{
			value: 'inline',
			label: __( 'Inline', 'jet-booking' ),
		},
		{
			value: 'list',
			label: __( 'List', 'jet-booking' ),
		},
	],
	cio_fields_format: [
		{
			value: 'YYYY-MM-DD',
			label: __( 'YYYY-MM-DD', 'jet-booking' ),
		},
		{
			value: 'MM-DD-YYYY',
			label: __( 'MM-DD-YYYY', 'jet-booking' ),
		},
		{
			value: 'DD-MM-YYYY',
			label: __( 'DD-MM-YYYY', 'jet-booking' ),
		},
	],
	cio_fields_separator: [
		{
			value: '-',
			label: '-',
		},
		{
			value: '.',
			label: '.',
		},
		{
			value: '/',
			label: '/',
		},
		{
			value: 'space',
			label: __( 'Space', 'jet-booking' ),
		},
	],
	start_of_week: [
		{
			value: 'monday',
			label: __( 'Monday', 'jet-booking' ),
		},
		{
			value: 'sunday',
			label: __( 'Sunday', 'jet-booking' ),
		},
	],
};

export {
	help,
	label,
	options,
};

