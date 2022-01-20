(function( $, extrasSettings ) {

	'use strict';

	window.JetABAFMeta = new Vue( {
		el: '#jet_abaf_meta_exras',
		template: '#jet-abaf-meta-extras',
		data: {
			saving: false,
			isActive: false,
			defaultPrice: 0,
			rates: extrasSettings.pricing_rates,
			nonce: extrasSettings.nonce,
		},
		created: function() {
			var self       = this,
				priceInput = document.getElementById( '_apartment_price' ),
				button     = document.createElement( 'button' );

			button.type = 'button';
			button.classList.add( 'button' );
			button.classList.add( 'button-secondary' );
			button.style.margin = '10px 0 -20px';
			button.innerHTML = extrasSettings.button_label

			priceInput.after( button );

			button.addEventListener( 'click', function() {
				
				self.isActive = ! self.isActive;
				self.defaultPrice = priceInput.value;

				if ( ! self.defaultPrice ) {
					self.defaultPrice = 0;
				}

			} );
		},
		methods: {
			newRate: function() {
				this.rates.push( {
					duration: 2,
					value: this.defaultPrice,
				} )
			},
			deleteRate: function( index ) {
				if ( window.confirm( extrasSettings.confirm_message ) ) {
					this.rates.splice( index, 1 );
				}
			},
			saveRates: function() {

				var self = this;

				self.saving = true;
				
				jQuery.ajax({
					url: window.ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'jet_booking_save_price_rates',
						post_id: extrasSettings.apartment,
						nonce: self.nonce,
						rates: self.rates,
					},
				}).done( function( response ) {

					self.saving = false;

					if ( response.success ) {
						self.isActive = false;
					} else {
						alert( response.data.message );
					}
				} ).fail( function( jqXHR, textStatus, errorThrown ) {
					self.saving = false;
					alert( errorThrown );
				} );

			},
		}
	} );

})( jQuery, window.JetABAFMetaExtras );