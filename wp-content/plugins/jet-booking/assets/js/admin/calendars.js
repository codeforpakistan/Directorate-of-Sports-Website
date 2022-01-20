(function () {

	"use strict";

	Vue.component( 'jet-abaf-calendars-list', {
		template: '#jet-abaf-calendars-list',
		data: function() {
			return {
				itemsList: [],
				totalItems: 0,
				offset: 0,
				perPage: 30,
				currentItem: false,
				currentIndex: false,
				editDialog: false,
				synchDialog: false,
				bookingInstances: window.JetABAFConfig.bookings,
				isLoading: false,
				synchLog: null,
			};
		},
		mounted: function() {
			this.getItems();
		},
		methods: {
			showEditDialog: function( item, index ) {
				this.editDialog   = true;
				this.currentItem  = JSON.parse( JSON.stringify( item ) );
				this.currentIndex = index;

				if ( ! this.currentItem.import_url ) {
					this.$set( this.currentItem, 'import_url', [] );
				}

			},
			showSynchDialog: function( item ) {

				var self = this;

				self.synchDialog = true;
				self.synchLog    = null;

				wp.apiFetch( {
					method: 'post',
					path: window.JetABAFConfig.api.synch_calendar,
					data: { item: item }
				} ).then( function( response ) {
					self.synchLog = response.result;
				} ).catch( function( e ) {
					self.synchLog = e.message;
				} );
			},
			addURL: function() {
				this.currentItem.import_url.push( '' );
			},
			handleEdit: function() {

				var self = this;

				if ( ! self.currentItem ) {
					return;
				}

				self.itemsList.splice( self.currentIndex, 1, self.currentItem );

				wp.apiFetch( {
					method: 'post',
					path: window.JetABAFConfig.api.update_calendar,
					data: { item: self.currentItem }
				} ).then( function( response ) {

					if ( ! response.success ) {

						self.$CXNotice.add( {
							message: response.data,
							type: 'error',
							duration: 7000,
						} );

					} else {
						self.$CXNotice.add( {
							message: 'Done!',
							type: 'success',
							duration: 7000,
						} );
					}

					self.currentItem = false;
					self.currentIndex = false;

				} ).catch( function( e ) {

					self.$CXNotice.add( {
						message: e.message,
						type: 'error',
						duration: 7000,
					} );

					self.currentItem = false;
					self.currentIndex = false;
				} );

			},
			getItems: function() {

				var self = this;

				self.isLoading = true;

				wp.apiFetch( {
					method: 'get',
					path: window.JetABAFConfig.api.calendars_list,
				} ).then( function( response ) {
					self.isLoading = false;
					if ( response.success ) {
						self.itemsList = response.data;
					}
				} ).catch( function( e ) {
					self.isLoading = false;
					self.$CXNotice.add( {
						message: e.message,
						type: 'error',
						duration: 7000,
					} );
				} );
			},
		},
	} );

	new Vue({
		el: '#jet-abaf-ical-page',
		template: '#jet-abaf-calendars',
		data: {
			isSet: window.JetABAFConfig.setup.is_set,
		}
	});

})();
