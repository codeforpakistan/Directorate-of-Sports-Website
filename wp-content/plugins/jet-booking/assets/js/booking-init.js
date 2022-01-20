(function () {

	var picker;
	var head = document.getElementsByTagName( 'head' )[0];
	var link = document.createElement( 'link' );
	var initialized = false;

	link.rel   = 'stylesheet';
	link.type  = 'text/css';
	link.href  = window.JetABAFData.css_url;
	link.media = 'all';

	head.appendChild( link );

	setDynamicPrice = function( value ) {

		var advancedRates = window.JetABAFData.advanced_price_rates;
		var defaultPrice = window.JetABAFData.default_price;

		jQuery( 'span[data-price-change="1"][data-post="' + window.JetABAFData.post_id + '"]' ).each( function() {

			var $this = jQuery( this );
			var dateFormat = "YYYY-MM-DD";
			var price = defaultPrice;

			if ( window.JetABAFData.one_day_bookings ) {
				return;
			}

			if ( ! advancedRates.length ) {
				return;
			}

			if ( 1 < value.length ) {
				value = value.split( ' - ' );

				if ( window.JetABAFInput.field_format ) {
					dateFormat = window.JetABAFInput.field_format;
				}

				var startDate = moment( value[0], dateFormat );
				var endDate   = moment( value[1], dateFormat );

				value = endDate.diff( startDate, 'days' );
				value = Number( value );

				if ( ! window.JetABAFData.per_nights ) {
					value++;
				}

			}

			if ( advancedRates.length ) {

				for ( var i = 0; i < advancedRates.length; i++ ) {
					rate = advancedRates[ i ];
					if ( value >= Number( rate.duration ) ) {
						price = Number( rate.value )
					}
				};

			}

			if ( $this.data( 'currency' ) ) {

				var currencyPosition = $this.data( 'currency-position' );

				if ( 'before' === currencyPosition ) {
					price = $this.data( 'currency' ) + '' + price;
				} else {
					price = price + '' + $this.data( 'currency' );
				}

			}

			$this.text( price )

		} );
	};

	validateDay = function( t ) {
		var formated = moment( t ).format( 'YYYY-MM-DD' ),
			valid    = true,
			_class   = '',
			_tooltip = '';

		if ( window.JetABAFData.booked_dates.length && 0 <= window.JetABAFData.booked_dates.indexOf( formated ) ) {
			valid    = false;
			_tooltip = window.JetABAFData.labels.booked;
		}

		return [ valid, _class, _tooltip ];

	};

	function initializeCheckInOut_JetEngine( event, $scope ) {
		if ( ! $scope ) {
			alert( 'Please update JetEngine to version 2.4.0 or higher' );
		}

		if ( ! $scope.find( '.field-type-check_in_out' ).length ) {
			return;
		}

		if ( initialized ) {
			return;
		}

		initialized = true;

		var config = {
			separator : ' - ',
			autoClose: true,
			startDate: new Date(),
			selectForward: true,
			beforeShowDay: validateDay,
			excludedDates: window.JetABAFData.booked_dates,
			perNights: window.JetABAFData.per_nights,
			startOfWeek: window.JetABAFInput.start_of_week,
			minDays: window.JetABAFData.per_nights ? 1 : 0 ,
		};

		if ( window.JetABAFData.custom_labels ) {
			jQuery.dateRangePickerLanguages['custom'] = window.JetABAFData.labels;
			config.language = 'custom';
		}

		if ( window.JetABAFInput.field_format ) {
			config.format = window.JetABAFInput.field_format;
		}

		if ( window.JetABAFData.weekly_bookings ) {
			config.batchMode     = 'week';
			config.showShortcuts = false;

			if ( window.JetABAFData.week_offset ) {
				config.weekOffset = Number( window.JetABAFData.week_offset );
			}

		} else if ( window.JetABAFData.one_day_bookings ) {
			config.singleDate = true;
		}

		if ( 'single' === window.JetABAFInput.layout ) {
			var $field = jQuery( '#jet_abaf_field' );
			config.container = '.jet-abaf-field';

			config.setValue = function( s, s1, s2 ) {
				$field.val( s ).trigger( 'change.JetEngine' );

				if ( jQuery( '.jet-booking-calendar__input' ).length ) {
					jQuery( '.jet-booking-calendar__input' ).data( 'dateRangePicker' ).clear();
				}

				setDynamicPrice( s );

			};

			$field.dateRangePicker( config );
		} else {

			var $checkIn  = jQuery( '#jet_abaf_field_1' ),
				$checkOut = jQuery( '#jet_abaf_field_2' ),
				$result   = jQuery( '#jet_abaf_field_range' );

			config.container = '.jet-abaf-separate-fields';

			config.getValue = function() {
				if ( $checkIn.val() && $checkOut.val() )
					return $checkIn.val() + ' - ' + $checkOut.val();
				else
					return '';
			};

			config.setValue = function( s, s1, s2 ) {

				if ( s === s1 ) {
					s2 = s1;
				}

				$checkIn.val( s1 );
				$checkOut.val( s2 );
				$result.val( s ).trigger( 'change.JetEngine' );

				if ( jQuery( '.jet-booking-calendar__input' ).length ) {
					jQuery( '.jet-booking-calendar__input' ).data( 'dateRangePicker' ).clear();
				}

				setDynamicPrice( s );

			};

			jQuery( '.jet-abaf-separate-fields' ).dateRangePicker( config );

		}

		if ( ! window.JetBookingInitialized ) {

			function culcBookedDates( value ) {
				var dateFormat = "YYYY-MM-DD";

				if ( window.JetABAFData.one_day_bookings ) {
					return 1;
				}

				if ( 1 < value.length ) {
					value = value.split( ' - ' );

					if( ! value[0] ){
						return 0;
					}

					if ( window.JetABAFInput.field_format ) {
						dateFormat = window.JetABAFInput.field_format;
					}

					var startDate = moment( value[0], dateFormat ),
						endDate   = moment( value[1], dateFormat );

					value = endDate.diff( startDate, 'days' );
					value = Number( value );

					if ( ! window.JetABAFData.per_nights ) {
						value++;
					}
				}

				return value;
			}

			JetEngine.filters.addFilter( 'forms/calculated-field-value', function( value, $field ) {

				if ( 'checkin-checkout' === $field.data( 'field' ) ) {
					return culcBookedDates( value );
				} else {
					return value;
				}
			} );

			JetEngine.filters.addFilter( 'forms/calculated-formula-before-value', function( formula, $scope ) {
				if ( -1 !== formula.search( new RegExp( 'ADVANCED_PRICE' ) ) ) {
					var advancedRates = window.JetABAFData.advanced_price_rates,
						defaultPrice = window.JetABAFData.default_price,
						regexp       = /%ADVANCED_PRICE::([a-zA-Z0-9-_]+)%/g,
						price        = defaultPrice,
						bookedDates,
						dateField;

					formula = formula.replace( regexp, function ( match1, match2 ) {
						dateField = $scope.closest( 'form' ).find( '[name="' + match2 + '"], [name="' + match2 + '[]"]' );
						bookedDates = culcBookedDates( JetEngineForms.getFieldValue( dateField ) );

						if ( advancedRates.length ) {
							for ( var i = 0; i < advancedRates.length; i++ ) {

								rate = advancedRates[ i ];
								if ( bookedDates >= Number( rate.duration ) ) {
									price = Number( rate.value )
								}
							};
						}

						return price * bookedDates;
					} );
				}

				return formula;
			} );
		}

		window.JetBookingInitialized = true;
	}

	function initializeCheckInOut_JetFormBuilder( event, $scope ) {
		if ( ! $scope.find( '.field-type-check-in-out' ).length ) {
			return;
		}

		if ( initialized ) {
			return;
		}

		initialized = true;

		var config = {
			separator : ' - ',
			autoClose: true,
			startDate: new Date(),
			selectForward: true,
			beforeShowDay: validateDay,
			excludedDates: window.JetABAFData.booked_dates,
			perNights: window.JetABAFData.per_nights,
			startOfWeek: window.JetABAFInput.start_of_week,
			minDays: window.JetABAFData.per_nights ? 1 : 0 ,
		};

		if ( window.JetABAFData.custom_labels ) {
			jQuery.dateRangePickerLanguages['custom'] = window.JetABAFData.labels;
			config.language = 'custom';
		}

		if ( window.JetABAFInput.field_format ) {
			config.format = window.JetABAFInput.field_format;
		}

		if ( window.JetABAFData.weekly_bookings ) {
			config.batchMode     = 'week';
			config.showShortcuts = false;

			if ( window.JetABAFData.week_offset ) {
				config.weekOffset = Number( window.JetABAFData.week_offset );
			}

		} else if ( window.JetABAFData.one_day_bookings ) {
			config.singleDate = true;
		}

		if ( 'single' === window.JetABAFInput.layout ) {
			var $field = jQuery( '#jet_abaf_field' );
			config.container = '.jet-abaf-field';

			config.setValue = function( s, s1, s2 ) {
				$field.val( s ).trigger( 'change.JetFormBuilderMain' );

				if ( jQuery( '.jet-booking-calendar__input' ).length ) {
					jQuery( '.jet-booking-calendar__input' ).data( 'dateRangePicker' ).clear();
				}

				setDynamicPrice( s );

			};

			$field.dateRangePicker( config );
		} else {

			var $checkIn  = jQuery( '#jet_abaf_field_1' ),
				$checkOut = jQuery( '#jet_abaf_field_2' ),
				$result   = jQuery( '#jet_abaf_field_range' );

			config.container = '.jet-abaf-separate-fields';

			config.getValue = function() {
				if ( $checkIn.val() && $checkOut.val() )
					return $checkIn.val() + ' - ' + $checkOut.val();
				else
					return '';
			};

			config.setValue = function( s, s1, s2 ) {

				if ( s === s1 ) {
					s2 = s1;
				}

				$checkIn.val( s1 );
				$checkOut.val( s2 );
				$result.val( s ).trigger( 'change.JetFormBuilderMain' );

				if ( jQuery( '.jet-booking-calendar__input' ).length ) {
					jQuery( '.jet-booking-calendar__input' ).data( 'dateRangePicker' ).clear();
				}

				setDynamicPrice( s );

			};

			jQuery( '.jet-abaf-separate-fields' ).dateRangePicker( config );

		}

		if ( ! window.JetBookingInitialized ) {

			function culcBookedDates( value ) {
				var dateFormat = "YYYY-MM-DD";

				if ( window.JetABAFData.one_day_bookings ) {
					return 1;
				}

				if ( 1 < value.length ) {
					value = value.split( ' - ' );

					if( ! value[0] ){
						return 0;
					}

					if ( window.JetABAFInput.field_format ) {
						dateFormat = window.JetABAFInput.field_format;
					}

					var startDate = moment( value[0], dateFormat ),
						endDate   = moment( value[1], dateFormat );

					value = endDate.diff( startDate, 'days' );
					value = Number( value );

					if ( ! window.JetABAFData.per_nights ) {
						value++;
					}
				}

				return value;
			}

			JetFormBuilderMain.filters.addFilter( 'forms/calculated-field-value', function( value, $field ) {

				if ( 'checkin-checkout' === $field.data( 'field' ) ) {
					return culcBookedDates( value );
				} else {
					return value;
				}
			} );

			JetFormBuilderMain.filters.addFilter( 'forms/calculated-formula-before-value', function( formula, $scope ) {
				if ( -1 !== formula.search( new RegExp( 'ADVANCED_PRICE' ) ) ) {
					var advancedRates = window.JetABAFData.advanced_price_rates,
						defaultPrice = window.JetABAFData.default_price,
						regexp       = /%ADVANCED_PRICE::([a-zA-Z0-9-_]+)%/g,
						price        = defaultPrice,
						bookedDates,
						dateField;

					formula = formula.replace( regexp, function ( match1, match2 ) {
						dateField = $scope.closest( 'form' ).find( '[name="' + match2 + '"], [name="' + match2 + '[]"]' );
						bookedDates = culcBookedDates( JetFormBuilder.getFieldValue( dateField ) );

						if ( advancedRates.length ) {
							for ( var i = 0; i < advancedRates.length; i++ ) {

								rate = advancedRates[ i ];
								if ( bookedDates >= Number( rate.duration ) ) {
									price = Number( rate.value )
								}
							};
						}

						return price * bookedDates;
					} );
				}

				return formula;
			} );
		}

		window.JetBookingInitialized = true;
	}

	jQuery( document ).on( 'jet-engine/booking-form/init', initializeCheckInOut_JetEngine );
	jQuery( document ).on( 'jet-form-builder/init', initializeCheckInOut_JetFormBuilder );

	jQuery( window ).on( 'elementor/frontend/init', function() {

		window.elementorFrontend.hooks.addAction( 'frontend/element_ready/jet-booking-calendar.default', function( $scope ) {

			var $container = $scope.find( '.jet-booking-calendar__container' ),
				scrollToForm = $container.data( 'scroll-to-form' ),
				config = {
					separator : ' - ',
					autoClose: true,
					startDate: new Date(),
					selectForward: true,
					beforeShowDay: validateDay,
					excludedDates: window.JetABAFData.booked_dates,
					perNights: window.JetABAFData.per_nights,
					showTopbar: false,
					inline: true,
					container: '#' + $container.attr( 'id' ),
					alwaysOpen: true,
					startOfWeek: window.JetABAFInput.start_of_week,
					minDays: window.JetABAFData.per_nights ? 1 : 0 ,
				};

			if ( window.JetABAFData.custom_labels ) {
				jQuery.dateRangePickerLanguages['custom'] = window.JetABAFData.labels;
				config.language = 'custom';
			}

			if ( window.JetABAFData.weekly_bookings ) {
				config.batchMode     = 'week';
				config.showShortcuts = false;

				if ( window.JetABAFData.week_offset ) {
					config.weekOffset = Number( window.JetABAFData.week_offset );
				}

			} else if ( window.JetABAFData.one_day_bookings ) {
				config.singleDate = true;
			}

			config.setValue = function( s, s1, s2 ) {

				if ( ! s )  {
					return;
				}

				var $formField = jQuery( '.field-type-check_in_out, .field-type-check-in-out' );

				if ( s === s1 ) {
					s2 = s1;
				}

				if ( $formField.find( '.jet-abaf-separate-fields' ).length ) {

					var $field_1 = $formField.find( '#jet_abaf_field_1' ),
						$field_2 = $formField.find( '#jet_abaf_field_2' ),
						$result  = $formField.find( '#jet_abaf_field_range' ),
						format   = $result.data( 'format' );

					if ( format ) {
						s1 = moment( s1 ).format( format );
						s2 = moment( s2 ).format( format );
						s  = s1 + config.separator + s2;
					}

					$field_1.val( s1 );
					$field_2.val( s2 );
					if ( $result.hasClass( 'jet-form__field' ) ) {
						$result.val( s ).trigger( 'change.JetEngine' );
					} else {
						$result.val( s ).trigger( 'change.JetFormBuilderMain' );
					}

					if ( scrollToForm ) {
						jQuery( 'html, body' ).animate({
							scrollTop: $formField.closest( 'form' ).offset().top
						}, 500 );
					}

				}
				else if ( $formField.find( '.jet-abaf-field' ).length ) {

					var $field  = $formField.find( '#jet_abaf_field' ),
						format  = $field.data( 'format' );

					if ( format ) {
						s1 = moment( s1 ).format( format );
						s2 = moment( s2 ).format( format );
						s  = s1 + config.separator + s2;
					}


					if ( $field.hasClass( 'jet-form__field' ) ) {
						$field.val( s ).trigger( 'change.JetEngine' );
					} else {
						$field.val( s ).trigger( 'change.JetFormBuilderMain' );
					}

					if ( scrollToForm ) {
						jQuery( 'html, body' ).animate({
							scrollTop: $formField.closest( 'form' ).offset().top
						}, 500 );
					}

				}

				setDynamicPrice( s );

			};

			$scope.find( '.jet-booking-calendar__input' ).dateRangePicker( config );

		} );
	} );

	jQuery( document ).on( 'jet-engine/form/ajax/on-success', function( response, data, $form ){
		if( data.new_date ){
			var new_date = data.new_date.replace( /\//g, '-' );

			JetABAFData.booked_dates.push( new_date );
		}

		let separateField = jQuery( '.jet-abaf-separate-fields', $form ),
			singleField = jQuery( '.jet-booking-calendar__input', $form  );

		if( separateField[0] ){
			separateField.data('dateRangePicker').clear();
		}else if( singleField[0] ){
			singleField.data( 'dateRangePicker' ).clear();
		}

	} );

}());