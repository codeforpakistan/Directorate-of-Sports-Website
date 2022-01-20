import CheckInOutEdit from "./edit";
import metadata from "./block.json";

const { __ } = wp.i18n;

const { name, icon } = metadata;

/**
 * Available items for `useEditProps`:
 *  - uniqKey
 *  - formFields
 *  - blockName
 *  - attrHelp
 */
const settings = {
	title: __( 'Check-in/check-out dates' ),
	icon: <span dangerouslySetInnerHTML={ { __html: icon } }></span>,
	edit: CheckInOutEdit,
	useEditProps: [ 'uniqKey', 'blockName', 'attrHelp' ],
	example: {
		attributes: {
			label: 'Check-in/check-out dates',
			desc: 'Field description...',
		},
	},
};

export {
	metadata,
	name,
	settings
};