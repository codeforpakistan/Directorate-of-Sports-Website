(function () {

	"use strict";

	Vue.component( 'jet-abaf-settings-general', {
		template: '#jet-abaf-settings-general',
		props: {
			settings: {
				type: Object,
				default: {},
			}
		},
		data: function() {
			return {
				postTypes: window.JetABAFConfig.post_types,
				generalSettings: {}
			};
		},
		mounted: function() {
			this.generalSettings = this.settings;
		},
		methods: {
			addNewColumn: function( event ) {

				var col = {
					column: '',
					collapsed: false,
				};

				this.generalSettings.additional_columns.push( col );

			},
			setColumnProp: function( index, key, value ) {

				var col = this.generalSettings.additional_columns[ index ];

				col[ key ] = value;

				this.generalSettings.additional_columns.splice( index, 1, col );

				this.updateSetting( this.generalSettings.additional_columns, 'additional_columns' );

			},
			cloneColumn: function( index ) {

				var col    = this.generalSettings.additional_columns[ index ],
					newCol = {
						'column': col.column + '_copy',
					};

				this.generalSettings.additional_columns.splice( index + 1, 0, newCol );
				this.updateSetting( this.generalSettings.additional_columns, 'additional_columns' );
			},
			deleteColumn: function( index ) {
				this.generalSettings.additional_columns.splice( index, 1 );
				this.updateSetting( this.generalSettings.additional_columns, 'additional_columns' );
			},
			isCollapsed: function( object ) {
				if ( undefined === object.collapsed || true === object.collapsed ) {
					return true;
				} else {
					return false;
				}
			},
			updateSetting: function( value, key ) {
				this.$emit( 'force-update', {
					key: key,
					value: value,
				} );
			}
		}
	} );

	Vue.component( 'jet-abaf-settings-labels', {
		template: '#jet-abaf-settings-labels',
		props: {
			settings: {
				type: Object,
				default: {},
			}
		},
		data: function() {
			return {
				advancedSettings: {}
			};
		},
		mounted: function() {
			this.advancedSettings = this.settings;
		},
		methods: {
			updateSetting: function( value, key ) {
				this.$emit( 'force-update', {
					key: key,
					value: value,
				} );
			}
		}
	} );

	Vue.component( 'jet-abaf-settings-advanced', {
		template: '#jet-abaf-settings-advanced',
		props: {
			settings: {
				type: Object,
				default: {},
			}
		},
		data: function() {
			return {
				advancedSettings: {},
				cronSchedules: window.JetABAFConfig.cron_schedules,
			};
		},
		mounted: function() {
			this.advancedSettings = this.settings;
		},
		methods: {
			getInterval: function( to ) {

				var res = [];

				for ( var i = 0; i <= to; i++ ) {

					let item = {};
					let val  = '';

					if ( 10 > i ) {
						val = '' + '0' + i;
					} else {
						val = i;
					}

					item.value = val;
					item.label = val;

					res.push( item );
				}

				return res;

			},
			updateSetting: function( value, key ) {
				this.$emit( 'force-update', {
					key: key,
					value: value,
				} );
			}
		}
	} );

	new Vue({
		el: '#jet-abaf-settings-page',
		template: '#jet-abaf-settings',
		data: {
			settings: window.JetABAFConfig.settings,
			dbTablesExists: window.JetABAFConfig.db_tables_exists,
			processingTables: false,
		},
		computed: {
			initialTab: function() {

				var result = 'general';

				if ( ! this.dbTablesExists ) {
					result = 'db_tables';
				}

				return result;
			},
		},
		methods: {
			processTables: function() {

				var self = this;

				self.processingTables = true;

				jQuery.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'jet_abaf_process_tables',
					},
				}).done( function( response ) {

					self.processingTables = false;

					if ( response.success ) {

						if ( ! self.dbTablesExists ) {
							self.dbTablesExists = true;
						}

						self.$CXNotice.add( {
							message: response.data.message,
							type: 'success',
							duration: 7000,
						} );
					} else {
						self.$CXNotice.add( {
							message: response.data.message,
							type: 'error',
							duration: 15000,
						} );
					}
				} ).fail( function( jqXHR, textStatus, errorThrown ) {

					self.processingTables = false;

					self.$CXNotice.add( {
						message: errorThrown,
						type: 'error',
						duration: 15000,
					} );
				} );
			},
			onUpdateSettings: function( setting, force ) {
				force = force || false;
				this.$set( this.settings, setting.key, setting.value );
				if ( force ) {
					this.$nextTick( function() {
						this.saveSettings();
					} );
				}
			},
			saveSettings: function() {

				var self = this;

				jQuery.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'jet_abaf_save_settings',
						settings: this.settings,
					},
				}).done( function( response ) {
					if ( response.success ) {
						self.$CXNotice.add( {
							message: response.data.message,
							type: 'success',
							duration: 7000,
						} );
					}
				} ).fail( function( jqXHR, textStatus, errorThrown ) {
					self.$CXNotice.add( {
						message: errorThrown,
						type: 'error',
						duration: 15000,
					} );
				} );
			}
		}
	});

})();
