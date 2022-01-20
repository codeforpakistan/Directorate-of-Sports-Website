( function ( $ ) {

	'use strict';

	var $product = $( '.woocommerce div.product' );

	if ( $product.hasClass( 'product-type-grouped' ) || $product.hasClass( 'product-type-external' ) ) {
		return false;
	}

	var AjaxSingleAddToCart = {

		init: function() {

			var self = this;

			$( document ).on( 'click', '.single_add_to_cart_button:not(.disabled)', self.ajaxAddToCart );

		},

		ajaxAddToCart: function( event ) {

			event.preventDefault();

			var $form = $( this ).closest('form');

			if( ! $form[0].checkValidity() ) {
				$form[0].reportValidity();
				return false;
			}

			var $thisbtn = $(this),
				product_id = $thisbtn.val() || '',
				cartFormData = $form.serialize();

			$.ajax( {
				type: 'POST',
				url: window.jetWooBuilderData.ajax_url,
				data: 'action=jet_woo_builder_add_cart_single_product&add-to-cart=' + product_id + '&' + cartFormData,
				beforeSend: function ( response ) {
					$thisbtn.removeClass( 'added' ).addClass( 'loading' );
				},
				complete: function ( response ) {
					$thisbtn.addClass( 'added' ).removeClass( 'loading' );
				},
				success: function ( response ) {

					if ( response.error && response.product_url ) {
						window.location = response.product_url;
						return;
					}

					setTimeout( function () {
						$thisbtn.removeClass( 'added' );
					}, 1000 );

					$( document.body ).trigger( 'wc_fragment_refresh' );
					$( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $thisbtn ] );

					if ( typeof wc_add_to_cart_params === 'undefined' ) {
						return;
					}

				},
			} );

			return false;

		}
		
	};

	AjaxSingleAddToCart.init();

} )( jQuery );