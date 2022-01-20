import * as checkInOut from './blocks/check-in-out'
import './actions/apartment-booking';

const {
		  addFilter,
	  } = wp.hooks;

addFilter( 'jet.fb.register.fields', 'jet-form-builder', blocks => {
	blocks.push( checkInOut );

	return blocks;
} );

addFilter( 'jet.fb.calculated.field.available.fields', 'jet-form-builder', fields => {
	fields.push( '%ADVANCED_PRICE::field_name%', '%META::_apartment_price%' );

	return fields;
} )