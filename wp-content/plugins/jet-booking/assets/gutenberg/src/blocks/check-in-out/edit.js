import {
	help,
	label,
	options,
} from './source';

const {
		  AdvancedFields,
		  GeneralFields,
		  ToolBarFields,
		  FieldWrapper,
	  } = JetFBComponents;

const {
		  Tools: { withPlaceholder },
	  } = JetFBActions;

const {
		  TextControl,
		  SelectControl,
		  PanelBody,
		  Flex,
		  FlexItem,
	  } = wp.components;
const { __ } = wp.i18n;

const {
		  InspectorControls,
		  useBlockProps,
	  } = wp.blockEditor;

function CheckInOutEdit( props ) {
	const blockProps = useBlockProps();

	const {
			  attributes,
			  setAttributes,
			  isSelected,
			  editProps: { uniqKey },
		  } = props;

	return [
		<ToolBarFields
			key={ uniqKey( 'ToolBarFields' ) }
			{ ...props }
		/>,
		isSelected && <InspectorControls
			key={ uniqKey( 'InspectorControls' ) }
		>
			<GeneralFields
				key={ uniqKey( 'GeneralFields' ) }
				{ ...props }
			/>
			<PanelBody
				title={ __( 'Field Settings' ) }
				key={ uniqKey( 'PanelBody' ) }
			>
				<SelectControl
					label={ label.cio_field_layout }
					labelPosition='top'
					value={ attributes.cio_field_layout }
					onChange={ cio_field_layout => {
						setAttributes( { cio_field_layout } );
					} }
					options={ withPlaceholder( options.cio_field_layout ) }
				/>
				<SelectControl
					label={ label.cio_fields_position }
					labelPosition='top'
					help={ help.cio_fields_position }
					value={ attributes.cio_fields_position }
					onChange={ cio_fields_position => {
						setAttributes( { cio_fields_position } );
					} }
					options={ withPlaceholder( options.cio_fields_position ) }
				/>
				<TextControl
					label={ label.first_field_label }
					value={ attributes.first_field_label }
					help={ help.first_field_label }
					onChange={ first_field_label => {
						setAttributes( { first_field_label } );
					} }
				/>
				<TextControl
					label={ label.first_field_placeholder }
					value={ attributes.first_field_placeholder }
					help={ help.first_field_placeholder }
					onChange={ first_field_placeholder => {
						setAttributes( { first_field_placeholder } );
					} }
				/>
				<TextControl
					label={ label.second_field_label }
					value={ attributes.second_field_label }
					help={ help.second_field_label }
					onChange={ second_field_label => {
						setAttributes( { second_field_label } );
					} }
				/>
				<TextControl
					label={ label.second_field_placeholder }
					value={ attributes.second_field_placeholder }
					help={ help.second_field_placeholder }
					onChange={ second_field_placeholder => {
						setAttributes( { second_field_placeholder } );
					} }
				/>
				<SelectControl
					label={ label.cio_fields_format }
					help={ help.cio_fields_format }
					labelPosition='top'
					value={ attributes.cio_fields_format }
					onChange={ cio_fields_format => {
						setAttributes( { cio_fields_format } );
					} }
					options={ withPlaceholder( options.cio_fields_format ) }
				/>
				<SelectControl
					label={ label.cio_fields_separator }
					labelPosition='top'
					value={ attributes.cio_fields_separator }
					onChange={ cio_fields_separator => {
						setAttributes( { cio_fields_separator } );
					} }
					options={ withPlaceholder( options.cio_fields_separator ) }
				/>
				<SelectControl
					label={ label.start_of_week }
					labelPosition='top'
					value={ attributes.start_of_week }
					onChange={ start_of_week => {
						setAttributes( { start_of_week } );
					} }
					options={ withPlaceholder( options.start_of_week ) }
				/>
			</PanelBody>
			<AdvancedFields
				key={ uniqKey( 'AdvancedFields' ) }
				{ ...props }
			/>
		</InspectorControls>,
		<div { ...blockProps } key={ uniqKey( 'viewBlock' ) }>
			<FieldWrapper
				key={ uniqKey( 'FieldWrapper' ) }
				{ ...props }
			>
				{ 'separate' !== attributes.cio_field_layout && <TextControl
					placeholder={ attributes.first_field_placeholder }
					key={ uniqKey( 'place_holder_block' ) }
					onChange={ () => {
					} }
				/> }
				{ 'separate' === attributes.cio_field_layout && <>
					{ 'list' !== attributes.cio_fields_position && <Flex expanded>
						<FlexItem isBlock style={ { flex: 1 } }>
							<TextControl
								label={ attributes.first_field_label }
								placeholder={ attributes.first_field_placeholder }
								key={ uniqKey( 'place_holder_block' ) }
								onChange={ () => {
								} }
							/>
						</FlexItem>
						<FlexItem isBlock style={ { flex: 1 } }>
							<TextControl
								label={ attributes.second_field_label }
								placeholder={ attributes.second_field_placeholder }
								key={ uniqKey( 'place_holder_block' ) }
								onChange={ () => {
								} }
							/>
						</FlexItem>
					</Flex> }
					{ 'list' === attributes.cio_fields_position && <>
						<TextControl
							label={ attributes.first_field_label }
							placeholder={ attributes.first_field_placeholder }
							key={ uniqKey( 'place_holder_block' ) }
							onChange={ () => {
							} }
						/>
						<TextControl
							label={ attributes.second_field_label }
							placeholder={ attributes.second_field_placeholder }
							key={ uniqKey( 'place_holder_block' ) }
							onChange={ () => {
							} }
						/>
					</> }
				</> }
			</FieldWrapper>
		</div>,
	];
}

export default CheckInOutEdit;