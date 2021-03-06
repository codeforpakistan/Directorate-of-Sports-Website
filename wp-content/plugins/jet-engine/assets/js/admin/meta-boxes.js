(function( $ ) {

	'use strict';

	var JetEngineMetaBoxes = {

		init: function() {

			var self = this;

			self.initDateFields( $( '.cx-control' ) );

			$( document ).on( 'cx-control-init', function( event, data ) {
				self.initDateFields( $( data.target ) );
			} );


		},

		/**
		 * Initialize date and time pickers
		 *
		 * @return {[type]} [description]
		 */
		initDateFields: function( $scope ) {

			var isRTL          = window.JetEngineMetaBoxesConfig.isRTL || false,
				i18n           = window.JetEngineMetaBoxesConfig.i18n || {},
				saveDateFormat = 'yy-mm-dd',
				saveTimeFormat = 'HH:mm',
				dateFormat     = window.JetEngineMetaBoxesConfig.dateFormat || saveDateFormat,
				timeFormat     = window.JetEngineMetaBoxesConfig.timeFormat || saveTimeFormat;

			$( 'input[type="date"]:not(.hasDatepicker)', $scope ).each( function() {

				var $this = $( this ),
					value = $this.val(),
					$datepicker = $( '<input/>', {
						'type': 'text',
						'class': 'widefat cx-ui-text',
					} );

				//$this.attr( 'type', 'text' );
				$this.prop( 'type', 'hidden' );
				$this.after( $datepicker );

				$datepicker.datepicker({
					dateFormat: dateFormat,
					altField: $this,
					altFormat: saveDateFormat,
					nextText: '>>',
					prevText: '<<',
					isRTL: isRTL,
					beforeShow: function( input, datepicker ) {
						datepicker.dpDiv.addClass( 'jet-engine-datepicker' );
					},
				});

				if ( value ) {
					$datepicker.datepicker( 'setDate', $.datepicker.parseDate( saveDateFormat, value ) );
				}

				$datepicker.on( 'blur', function() {
					if ( ! $datepicker.val() ) {
						$this.val( '' );
					}
				} );

			} );

			$( 'input[type="time"]:not(.hasDatepicker)', $scope ).each( function() {

				var $this = $( this ),
					value = $this.val(),
					$timepicker = $( '<input/>', {
						'type': 'text',
						'class': 'widefat cx-ui-text',
					} );

				//$this.attr( 'type', 'text' );
				$this.prop( 'type', 'hidden' );
				$this.after( $timepicker );

				$timepicker.timepicker({
					timeFormat: timeFormat,
					altField: $this,
					altTimeFormat: saveTimeFormat,
					isRTL: isRTL,
					timeOnlyTitle: i18n.timeOnlyTitle,
					timeText: i18n.timeText,
					hourText: i18n.hourText,
					minuteText: i18n.minuteText,
					currentText: i18n.currentText,
					closeText: i18n.closeText,
					beforeShow: function( input, datepicker ) {
						datepicker.dpDiv.addClass( 'jet-engine-datepicker' );
					},
				});

				if ( value ) {
					$timepicker.timepicker( 'setTime', $.datepicker.formatTime( timeFormat, $.datepicker.parseTime( saveTimeFormat, value ) ) );
				}

				$timepicker.on( 'blur', function() {
					if ( ! $timepicker.val() ) {
						$this.val( '' );
					}
				} );

			} );

			$( 'input[type="datetime-local"]:not(.hasDatepicker)', $scope ).each( function() {

				var $this = $( this ),
					value = $this.val(),
					$datetimepicker = $( '<input/>', {
						'type': 'text',
						'class': 'widefat cx-ui-text',
					} );

				//$this.attr( 'type', 'text' );
				$this.prop( 'type', 'hidden' );
				$this.after( $datetimepicker );

				$datetimepicker.datetimepicker({
					dateFormat: dateFormat,
					timeFormat: timeFormat,
					altField: $this,
					altFormat: saveDateFormat,
					altTimeFormat: saveTimeFormat,
					altFieldTimeOnly: false,
					altSeparator: 'T',
					nextText: '>>',
					prevText: '<<',
					isRTL: isRTL,
					timeText: i18n.timeText,
					hourText: i18n.hourText,
					minuteText: i18n.minuteText,
					currentText: i18n.currentText,
					closeText: i18n.closeText,
					beforeShow: function( input, datepicker ) {
						datepicker.dpDiv.addClass( 'jet-engine-datepicker' );
					},
				});

				if ( value ) {
					$datetimepicker.datetimepicker( 'setDate', $.datepicker.parseDateTime( saveDateFormat, saveTimeFormat, value, {}, { separator: 'T' } ) );
				}

				$datetimepicker.on( 'blur', function() {
					if ( ! $datetimepicker.val() ) {
						$this.val( '' );
					}
				} );

			} );

		},

	};

	JetEngineMetaBoxes.init();

})( jQuery );
