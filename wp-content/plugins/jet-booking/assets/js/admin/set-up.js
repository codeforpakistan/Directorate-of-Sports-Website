(function () {

	"use strict";

	new Vue({
		el: '#jet-abaf-set-up-page',
		template: '#jet-abaf-set-up',
		data: {
			isSet: window.JetABAFConfig.setup.is_set,
			isReset: window.JetABAFConfig.reset.is_reset,
			resetURL: window.JetABAFConfig.reset.reset_url,
			postTypes: window.JetABAFConfig.post_types,
			dbFields: window.JetABAFConfig.db_fields,
			currentStep: 1,
			lastStep: 4,
			loading: false,
			setupData: {},
			log: false,
			additionalDBColumns: [],
			active_jet_form_builder: window.JetABAFConfig.active_jet_form_builder,
			form_options: window.JetABAFConfig.form_options
		},
		methods: {
			setWorkingHoursData: function( data ) {
				this.$set( this.setupData, data.key, data.value );
			},
			getDBFields: function() {

				if ( ( this.setupData.related_post_type || this.setupData.wc_integration ) && 0 > this.dbFields.indexOf( 'order_id' ) ) {
					this.dbFields.push( 'order_id' );
				}

				return this.dbFields;
			},
			nextStep: function() {

				var self = this;

				if ( 1 === self.currentStep ) {

					if ( ! self.setupData.apartment_post_type ) {

						self.$CXNotice.add( {
							message: 'Please select post type for booking instances.',
							type: 'error',
							duration: 7000,
						} );

						return;
					}

				}

				if ( self.currentStep === self.lastStep ) {

					self.loading = true;

					jQuery.ajax({
						url: ajaxurl,
						type: 'POST',
						dataType: 'json',
						data: {
							action: 'jet_abaf_setup',
							setup_data: self.setupData,
							db_columns: self.additionalDBColumns,
						},
					}).done( function( response ) {

						self.loading = false;

						if ( response.success ) {
							self.currentStep++;
							self.log = response.data;
						}
					} ).fail( function( jqXHR, textStatus, errorThrown ) {

						self.loading = false;

						self.$CXNotice.add( {
							message: errorThrown,
							type: 'error',
							duration: 7000,
						} );
					} );

				} else {
					self.currentStep++;
				}

			},
			prevStep: function() {
				if ( 1 < this.currentStep ) {
					this.currentStep--;
				}
			},
			addNewColumn: function( event ) {

				var col = {
					column: '',
					collapsed: false,
				};

				this.additionalDBColumns.push( col );

			},
			setColumnProp: function( index, key, value ) {

				var col = this.additionalDBColumns[ index ];

				col[ key ] = value;

				this.additionalDBColumns.splice( index, 1, col );

			},
			cloneColumn: function( index ) {

				var col    = this.additionalDBColumns[ index ],
					newCol = {
						'column': col.column + '_copy',
					};

				this.additionalDBColumns.splice( index + 1, 0, newCol );

			},
			deleteColumn: function( index ) {
				this.additionalDBColumns.splice( index, 1 );
			},
			isCollapsed: function( object ) {
				if ( undefined === object.collapsed || true === object.collapsed ) {
					return true;
				} else {
					return false;
				}
			},
			goToReset: function() {
				if ( confirm( 'Are you sure? All previously booked appoinments will be removed!' ) ) {
					window.location = this.resetURL;
				}
			}
		}
	});

})();
