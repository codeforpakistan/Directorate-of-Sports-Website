(function () {

	'use strict';

	let picker,
		calendar = null,
		settings = {
			selector: '.appointment-calendar',
			datesFilter: true,
			pastDates: false,
			weekDays: window.JetAPBData.week_days,
			weekStart: window.JetAPBData.start_of_week,
			api: window.JetAPBData.api,
			multiBooking: window.JetAPBData.multi_booking,
			services: window.JetAPBData.services,
			providers: window.JetAPBData.providers,
			namespace: '',
		};

	if ( window.JetAPBData.months ) {
		settings.months = window.JetAPBData.months;
	}

	if ( window.JetAPBData.shortWeekday ) {
		settings.shortWeekday = window.JetAPBData.shortWeekday;
	}

	const calcFiledValue = function( value, $field ) {
			if ( 'appointment' === $field.data( 'field' ) ) {
				let outputValue = 0,
					parseValue = value ? JSON.parse( value ) : 0 ;

				if( typeof parseValue === 'object' ){
					for ( const slot of parseValue ) {
						outputValue += parseInt( slot.price );
					}

					value = outputValue;
				}
			}

			return value;
		},
		bookingFormIinit = function( e ) {

			if( calendar ){
				return;
			}

			settings.namespace = e.data.namespace;
			calendar = new VanillaCalendar( settings );

			if( settings.namespace === "jet-form-builder" ){
				JetFormBuilderMain.filters.addFilter( 'forms/calculated-field-value', calcFiledValue );
			} else {
				JetEngine.filters.addFilter( 'forms/calculated-field-value', calcFiledValue );
			}

		};

	jQuery( document ).on( 'jet-engine/booking-form/init', { namespace: "jet-form" }, bookingFormIinit );
	jQuery( document ).on( 'jet-form-builder/init', { namespace: "jet-form-builder" }, bookingFormIinit );
}());
