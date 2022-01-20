(function () {

	"use strict";

	Vue.component( 'jet-abaf-bookings-list', {
		template: '#jet-abaf-bookings-list',
		data: function() {
			return {
				itemsList: [],
				totalItems: 0,
				offset: 0,
				perPage: 30,
				deleteDialog: false,
				deleteItem: false,
				detailsDialog: false,
				currentItem: false,
				currentIndex: false,
				editDialog: false,
				statuses: window.JetABAFConfig.all_statuses,
				bookingInstances: window.JetABAFConfig.bookings,
				isLoading: false,
				overlappingBookings: false,
			};
		},
		mounted: function() {
			this.getItems();
		},
		methods: {
			changePage: function( page ) {
				this.offset = this.perPage * ( page - 1 );
				this.getItems();
			},
			showEditDialog: function( item, index ) {
				this.editDialog          = true;
				this.overlappingBookings = false;
				this.currentItem         = JSON.parse( JSON.stringify( item ) );
				this.currentIndex        = index;
			},
			showDetailsDialog: function( item ) {
				this.detailsDialog = true;
				this.currentItem = item;
			},
			showDeleteDialog: function( itemID ) {
				this.deleteItem   = itemID;
				this.deleteDialog = true;
			},
			handleEdit: function() {

				var self = this;

				if ( ! self.currentItem ) {
					return;
				}

				self.overlappingBookings = false;
				self.itemsList.splice( self.currentIndex, 1, self.currentItem );

				wp.apiFetch( {
					method: 'post',
					path: window.JetABAFConfig.api.update_booking + self.currentItem.booking_id + '/',
					data: { item: self.currentItem }
				} ).then( function( response ) {

					if ( ! response.success ) {

						if ( response.overlapping_bookings ) {

							self.$CXNotice.add( {
								message: response.data,
								type: 'error',
								duration: 7000,
							} );

							self.overlappingBookings = response.html;
							self.editDialog          = true;

							return;

						} else {

							self.$CXNotice.add( {
								message: response.data,
								type: 'error',
								duration: 7000,
							} );

						}

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
			handleDelete: function() {

				var self = this;

				if ( ! self.deleteItem ) {
					return;
				}

				wp.apiFetch( {
					method: 'delete',
					path: window.JetABAFConfig.api.delete_booking + self.deleteItem + '/',
				} ).then( function( response ) {
					if ( ! response.success ) {
						self.$CXNotice.add( {
							message: response.data,
							type: 'error',
							duration: 7000,
						} );
					}

					for ( var i = 0; i < self.itemsList.length; i++ ) {
						if ( self.itemsList[ i ].booking_id === self.deleteItem ) {
							self.itemsList.splice( i, 1 );
							break;
						}
					}

				} ).catch( function( e ) {
					self.$CXNotice.add( {
						message: e.message,
						type: 'error',
						duration: 7000,
					} );
				} );
			},
			buildQuery: function( params ) {
				return Object.keys( params ).map(function( key ) {
					return key + '=' + params[ key ];
				}).join( '&' );
			},
			getItems: function() {

				var self = this;

				self.isLoading = true;

				wp.apiFetch( {
					method: 'get',
					path: window.JetABAFConfig.api.bookings_list + '?' + this.buildQuery( {
						per_page: self.perPage,
						offset: self.offset,
					} ),
				} ).then( function( response ) {
					self.isLoading = false;
					if ( response.success ) {
						self.itemsList = response.data;
						if ( ! self.totalItems ) {
							self.totalItems = parseInt( response.total, 10 );
						}
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
			getBookingLabel: function( id ) {

				if ( ! id ) {
					return '--';
				}

				return this.bookingInstances[ id ] || id;
			},
			getOrderLink: function( orderID ) {
				return window.JetABAFConfig.edit_link.replace( /\%id\%/, orderID );
			},
			isFinished: function( status ) {
				return ( 0 <= window.JetABAFConfig.statuses.finished.indexOf( status ) );
			},
			isInProgress: function( status ) {
				return ( 0 <= window.JetABAFConfig.statuses.in_progress.indexOf( status ) );
			},
			isInvalid: function( status ) {
				return ( 0 <= window.JetABAFConfig.statuses.invalid.indexOf( status ) );
			}
		},
	} );

	new Vue({
		el: '#jet-abaf-bookings-page',
		template: '#jet-abaf-bookings',
		data: {
			isSet: window.JetABAFConfig.setup.is_set,
		}
	});

})();
