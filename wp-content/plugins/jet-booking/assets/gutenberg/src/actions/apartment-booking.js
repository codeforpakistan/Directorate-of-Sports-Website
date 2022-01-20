const {
		  SelectControl,
		  TextControl,
		  BaseControl,
		  Button,
		  Notice,
	  } = wp.components;

const {
		  useState,
		  useEffect,
	  } = wp.element;

const {
		  addAction,
		  getFormFieldsBlocks,
	  } = JetFBActions;

const {
		  ActionFieldsMap,
		  WrapperRequiredControl,
		  RepeaterWithState,
		  ActionModal,
	  } = JetFBComponents;

const addNewOption = {
	type: '',
	label: '',
	format: '',
	field: '',
	link_label: '',
};

addAction( 'apartment_booking', function ApartmentBooking( {
															   settings,
															   source,
															   label,
															   help,
															   onChangeSetting,
														   } ) {

	const [ formFieldsList, setFormFieldsList ] = useState( [] );
	const [ columnsMap, setColumnsMap ] = useState( [] );
	const [ wcFields, setWcFields ] = useState( [] );
	const [ wcDetailsModal, setWcDetailsModal ] = useState( false );
	const [ isLoading, setLoading ] = useState( false );

	useEffect( () => {
		const columnsMap = {};
		source.columns.forEach( col => {
			columnsMap[ col ] = { label: col };
		} );

		const wcColumnsMap = {};
		source.wc_fields.forEach( col => {
			wcColumnsMap[ col ] = { label: col };
		} );

		setColumnsMap( Object.entries( columnsMap ) );
		setWcFields( Object.entries( wcColumnsMap ) );
		setFormFieldsList( getFormFieldsBlocks( [], '--' ) );
	}, [] );

	function saveWCDetails( items ) {
		setLoading( true );

		jQuery.ajax( {
			url: window.ajaxurl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'jet_booking_save_wc_details',
				post_id: source.apartment,
				nonce: source.nonce,
				details: items,
			},
		} ).done( function( response ) {
			setLoading( false );

			if ( ! response.success ) {
				alert( response.data.message );
			} else {
				JetBookingActionData.details = items;
				setWcDetailsModal( false );
			}

		} ).fail( function( jqXHR, textStatus, errorThrown ) {
			setLoading( false );
			alert( errorThrown );
		} );
	}

	return <>
		<SelectControl
			label={ label( 'booking_apartment_field' ) }
			labelPosition='side'
			value={ settings.booking_apartment_field }
			onChange={ val => onChangeSetting( val, 'booking_apartment_field' ) }
			options={ formFieldsList }
		/>
		<SelectControl
			label={ label( 'booking_dates_field' ) }
			labelPosition='side'
			value={ settings.booking_dates_field }
			onChange={ val => onChangeSetting( val, 'booking_dates_field' ) }
			options={ formFieldsList }
		/>
		<ActionFieldsMap
			label={ label( 'db_columns_map' ) }
			fields={ columnsMap }
			plainHelp={ help( 'db_columns_map' ) }
		>
			{ ( { fieldId, fieldData, index } ) => <WrapperRequiredControl
				field={ [ fieldId, fieldData ] }
			>
				<TextControl
					key={ fieldId + index }
					value={ settings[ `db_columns_map_${ fieldId }` ] }
					onChange={ val => onChangeSetting( val, `db_columns_map_${ fieldId }` ) }
				/>
			</WrapperRequiredControl> }
		</ActionFieldsMap>
		{ Boolean( source.wc_integration ) && <>
			<SelectControl
				label={ label( 'booking_wc_price' ) }
				help={ help( 'booking_wc_price' ) }
				labelPosition='side'
				value={ settings.booking_wc_price }
				onChange={ val => onChangeSetting( val, 'booking_wc_price' ) }
				options={ formFieldsList }
			/>
			<BaseControl
				label={ label( 'wc_order_details' ) }
				help={ help( 'wc_order_details' ) }
			>
				<Button
					isSecondary
					onClick={ () => setWcDetailsModal( true ) }
				>{ 'Set up' }</Button>
			</BaseControl>
			<ActionFieldsMap
				label={ label( 'wc_fields_map' ) }
				fields={ wcFields }
				plainHelp={ help( 'wc_fields_map' ) }
			>
				{ ( { fieldId, fieldData, index } ) => <WrapperRequiredControl
					field={ [ fieldId, fieldData ] }
				>
					<SelectControl
						key={ fieldId + index }
						labelPosition='side'
						value={ settings[ `wc_fields_map__${ fieldId }` ] }
						onChange={ val => onChangeSetting( val, `wc_fields_map__${ fieldId }` ) }
						options={ formFieldsList }
					/>
				</WrapperRequiredControl> }
			</ActionFieldsMap>
			{ wcDetailsModal && <ActionModal
				title={ 'Set up WooCommerce order details' }
				onRequestClose={ () => setWcDetailsModal( false ) }
				classNames={ [ 'width-60' ] }
				style={ { opacity: isLoading ? '0.5' : '1' } }
				updateBtnProps={ { isBusy: isLoading } }
			>
				{ ( { actionClick, onRequestClose } ) => <RepeaterWithState
					items={ source.details }
					onSaveItems={ saveWCDetails }
					newItem={ addNewOption }
					onUnMount={ () => {
						if ( ! actionClick ) {
							onRequestClose();
						}
					} }
					isSaveAction={ actionClick }
					addNewButtonLabel={ isLoading ? 'Saving...' : 'Add new item +' }
				>
					{ ( { currentItem, changeCurrentItem } ) => {
						return <>
							<SelectControl
								label={ label( 'wc_details__type' ) }
								labelPosition='side'
								value={ currentItem.type }
								onChange={ type => changeCurrentItem( { type } ) }
								options={ source.details_types }
							/>
							<TextControl
								label={ label( 'wc_details__label' ) }
								value={ currentItem.label }
								onChange={ label => changeCurrentItem( { label } ) }
							/>
							{ [ 'check-in', 'check-out' ].includes( currentItem.type ) && <>
								<TextControl
									label={ label( 'wc_details__format' ) }
									value={ currentItem.format }
									onChange={ format => changeCurrentItem( { format } ) }
								/>
								<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">
									Formatting docs
								</a>
							</> }
							{ 'field' === currentItem.type && <SelectControl
								label={ label( 'wc_details__field' ) }
								labelPosition='side'
								value={ currentItem.field }
								onChange={ field => changeCurrentItem( { field } ) }
								options={ formFieldsList }
							/> }
							{ 'add_to_calendar' === currentItem.type && <TextControl
								label={ label( 'wc_details__link_label' ) }
								value={ currentItem.link_label }
								onChange={ link_label => changeCurrentItem( { link_label } ) }
							/> }
						</>;
					} }
				</RepeaterWithState> }
			</ActionModal> }
		</> }
	</>;
} );