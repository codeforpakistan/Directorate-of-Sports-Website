( function( $, elementorFrontend ) {

	"use strict";

	var JetWooBuilder = {

		init: function() {

			var widgets = {
				'jet-single-images.default' : JetWooBuilder.productImages,
				'jet-single-add-to-cart.default' : JetWooBuilder.addToCart,
				'jet-single-tabs.default' : JetWooBuilder.productTabs,
				'jet-woo-products.default' : JetWooBuilder.widgetProducts,
				'jet-woo-categories.default' : JetWooBuilder.widgetCategories,
			};

			$.each( widgets, function( widget, callback ) {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			});

			var userAgent = navigator.userAgent;

			if ( userAgent.indexOf('Safari') !== -1 && userAgent.indexOf('Chrome') === -1 ) {
				document.addEventListener( 'click', function ( event ) {

					if ( event.target.matches( '.add_to_cart_button .button-text' ) ) {
						var button = event.target.parentNode;

						button.focus();
					}

					if ( event.target.matches( '.add_to_cart_button' ) || event.target.matches( '.single_add_to_cart_button' ) ) {
						event.target.focus();
					}

				} );
			}

			elementorFrontend.hooks.addFilter( 'jet-popup/widget-extensions/popup-data', JetWooBuilder.prepareJetPopup );
			$( window ).on( 'jet-popup/render-content/ajax/success', JetWooBuilder.jetPopupLoaded );
			$( 'form.cart' ).on( 'change', 'input.qty', JetWooBuilder.ajaxLoopAddToCartWithQty );

			$( document )
				.on( 'wc_update_cart added_to_cart', JetWooBuilder.jetCartPopupOpen)
				.on( 'jet-filter-content-rendered', JetWooBuilder.reInitCarousel )
				.on( 'click.JetWooBuilder', '.jet-woo-switcher-btn', JetWooBuilder.layoutSwitcher )
				.on( 'jet-filter-content-rendered', JetWooBuilder.reInitAjaxLoopAddToCartWithQty )
				.on( 'jet-woo-builder-content-rendered', JetWooBuilder.reInitAjaxLoopAddToCartWithQty )
				.on( 'jet-engine/listing-grid/after-load-more', JetWooBuilder.reInitAjaxLoopAddToCartWithQty )
				.on( 'jet-engine/listing-grid/after-lazy-load', JetWooBuilder.reInitAjaxLoopAddToCartWithQty )
				.on( 'jet-cw-loaded', JetWooBuilder.reInitAjaxLoopAddToCartWithQty )
				.on( 'click.JetWooBuilder', '.jet-woo-item-overlay-wrap', JetWooBuilder.handleListingItemClick );

		},

		layoutSwitcher : function ( event ) {
			event.preventDefault();

			var switcher = $( event.currentTarget ),
				$productsWrapper = switcher.parents( '.jet-woo-builder-products-loop' ).find( '.jet-woo-products-wrapper' ),
				layout = $productsWrapper.data( 'layout-switcher' ),
				activeLayout = switcher.hasClass( 'jet-woo-switcher-btn-main' ) ? layout.main : layout.secondary,
				activeControl = $( document ).find( '.jet-woo-switcher-controls-wrapper .jet-woo-switcher-btn' );

			if ( window.JetSmartFilters && window.JetSmartFilters.filterGroups['woocommerce-archive/default'] ) {
				var jetSmartFiltersProvider = window.JetSmartFilters.filterGroups['woocommerce-archive/default'],
					jetSmartFiltersQuery = jetSmartFiltersProvider.query;
			}

			if ( ! switcher.hasClass( 'active' ) ) {
				if ( activeControl.hasClass( 'active' ) ) {
					activeControl.removeClass( 'active' );
				}

				switcher.addClass( 'active' );
			}

			$productsWrapper.addClass( 'jet-layout-loading' );

			$.ajax( {
				type: 'POST',
				url: window.jetWooBuilderData.ajax_url,
				data: {
					action: 'jet_woo_builder_get_layout',
					query: window.jetWooBuilderData.products,
					layout: activeLayout,
					filters: jetSmartFiltersQuery
				},
			} ).done( function( response ) {
				$productsWrapper.removeClass( 'jet-layout-loading' );
				$productsWrapper.html( response.data.html );

				JetWooBuilder.elementorFrontendInit( $productsWrapper );

				$(document).trigger( 'jet-woo-builder-content-rendered', [ switcher, response ] );
			} );
		},

		ajaxLoopAddToCartWithQty: function() {
			if ( '0' === this.value && ! $( this.form ).hasClass( 'grouped_form' ) ) {
				this.value = '1';
			}

			let $button = $( this.form ).find( 'button[data-quantity]' );

			$button.attr( 'data-quantity', this.value );

			if ( this.max ) {
				if ( +this.value > +this.max ) {
					$button.removeClass( 'ajax_add_to_cart' );
				} else if ( ! $button.hasClass( 'ajax_add_to_cart' ) ) {
					$button.addClass( 'ajax_add_to_cart' );
				}
			}
		},

		jetPopupLoaded : function( event, popupData){
			let $jetPopup = $( '#' + popupData.data.popupId );

			setTimeout( function(){
				$( window ).trigger('resize');

				if ( ! $jetPopup.hasClass( 'quick-view-product' ) ) {
					$jetPopup.addClass( 'woocommerce product quick-view-product' );
					$jetPopup.find( '.jet-popup__container-content' ).addClass( 'product' );
				}

				$( '.jet-popup .variations_form' ).each( function() {
					$( this ).wc_variation_form();
				} );

				$( '.jet-popup .woocommerce-product-gallery.images' ).each( function() {
					$( this ).wc_product_gallery();
				} );

				$( document ).on( 'wc_update_cart added_to_cart', function( event ) {
				 	event.preventDefault();

					$( window ).trigger( {
						type: 'jet-popup-close-trigger',
						popupData: {
							popupId: popupData.data.popupId,
							constantly: false
						}
					} );
				 } );

			}, 500);
		},

		prepareJetPopup: function( popupData, widgetData, $scope, event ) {

			if ( widgetData['is-jet-woo-builder'] ) {
				var $product;

				popupData['isJetWooBuilder'] = true;
				popupData['templateId'] = widgetData['jet-woo-builder-qv-template'];

				if ( $scope.hasClass( 'elementor-widget-jet-woo-products' ) || $scope.hasClass( 'elementor-widget-jet-woo-products-list' ) ) {
					$product     = $( event.target ).parents( '.jet-woo-builder-product' );
				} else {
					$product     = $scope.parents( '.jet-woo-builder-product' );
				}

				if ( $product.length ) {
					popupData['productId'] = $product.data( 'product-id' );
				}
			}

			return popupData;

		},

		productImages: function( $scope ) {
			$scope.find( '.jet-single-images__loading' ).remove();

			if ( $('body').hasClass( 'single-product' ) ) {
				return;
			}

			$scope.find( '.woocommerce-product-gallery' ).each( function() {
				$( this ).wc_product_gallery();
			} );

		},

		addToCart: function( $scope ) {

			if ( $('body').hasClass( 'single-product' ) ) {
				return;
			}

			if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
				$scope.find( '.variations_form' ).each( function() {
					$( this ).wc_variation_form();
				});
			}

		},

		productTabs: function( $scope ) {

			$scope.find( '.jet-single-tabs__loading' ).remove();

			if ( $('body').hasClass( 'single-product' ) ) {
				return;
			}

			var hash  = window.location.hash;
			var url   = window.location.href;
			var $tabs = $scope.find( '.wc-tabs, ul.tabs' ).first();

			$tabs.find( 'a' ).addClass( 'elementor-clickable' );

			$scope.find( '.wc-tab, .woocommerce-tabs .panel:not(.panel .panel)' ).hide();

			if ( hash.toLowerCase().indexOf( 'comment-' ) >= 0 || hash === '#reviews' || hash === '#tab-reviews' ) {
				$tabs.find( 'li.reviews_tab a' ).trigger( 'click' );
			} else if ( url.indexOf( 'comment-page-' ) > 0 || url.indexOf( 'cpage=' ) > 0 ) {
				$tabs.find( 'li.reviews_tab a' ).trigger( 'click' );
			} else if ( hash === '#tab-additional_information' ) {
				$tabs.find( 'li.additional_information_tab a' ).trigger( 'click' );
			} else {
				$tabs.find( 'li:first a' ).trigger( 'click' );
			}

		},

		widgetProducts: function ( $scope ) {

			var $target = $scope.find( '.jet-woo-carousel' ),
				$grid = $scope.find( '.jet-woo-products' ),
				$hoverSettings = $grid.data( 'mobile-hover' ),
				$gridItem = $grid.find( '.jet-woo-products__item' ),
				$cqwWrapper = $gridItem.find( '.jet-woo-products-cqw-wrapper' ),
				$hoveredContent = $gridItem.find( '.hovered-content' ),
				cqwWrapperExist = false,
				hoveredContentExist = false;

			if ( $cqwWrapper.length > 0 && $cqwWrapper.html().trim().length > 0 ) {
				cqwWrapperExist = true;
			}

			if ( $hoveredContent.length > 0 && $hoveredContent.html().trim().length > 0 ) {
				hoveredContentExist = true;
			}

			if ( ( cqwWrapperExist || hoveredContentExist ) && $hoverSettings ) {
				JetWooBuilder.mobileHoverOnTouch( $gridItem, '.jet-woo-product-thumbnail' );
			}

			if ( ! $target.length ) {
				return;
			}

			JetWooBuilder.initCarousel( $target, $target.data( 'slider_options' ) );

		},

		widgetCategories: function ( $scope ) {

			var $target = $scope.find( '.jet-woo-carousel' ),
				$grid = $scope.find( '.jet-woo-categories' ),
				$hoverSettings = $grid.data( 'mobile-hover' ),
				$gridItem = $grid.find( '.jet-woo-categories__item' ),
				$count = $gridItem.find( '.jet-woo-category-count' );

			if ( ( $grid.hasClass( 'jet-woo-categories--preset-2' ) && $count.length > 0 || $grid.hasClass( 'jet-woo-categories--preset-3' ) ) && $hoverSettings ) {
				JetWooBuilder.mobileHoverOnTouch( $gridItem, '.jet-woo-category-thumbnail' );
			}

			if ( ! $target.length ) {
				return;
			}

			JetWooBuilder.initCarousel( $target, $target.data( 'slider_options' ) );

		},

		mobileHoverOnTouch: function( $item, thumbnail ) {
			if ( 'undefined' !== typeof window.ontouchstart ) {
				$item.each( function() {
					let $this = $( this ),
						$thumbnailLink = $this.find( thumbnail + ' a' ),
						$adjacentItems = $this.siblings();

					if ( $this.hasClass( 'jet-woo-products__item' ) ) {
						let $itemContent = $this.not( thumbnail );

						$itemContent.each( function() {
							let $currentItem = $( this );

							JetWooBuilder.mobileTouchEvent( $this, $currentItem, $adjacentItems );
						} );
					}

					JetWooBuilder.mobileTouchEvent( $this, $thumbnailLink, $adjacentItems );
				} );
			}
		},

		mobileTouchEvent: function( $target, $item, $adjacentItems ) {
			$item.on( 'click', function( event ) {
				if ( ! $target.hasClass( 'mobile-hover' ) ) {
					event.preventDefault();

					$adjacentItems.each( function() {
						if ( $( this ).hasClass( 'mobile-hover' ) ) {
							$( this ).removeClass( 'mobile-hover' );
						}
					} );

					$target.addClass( 'mobile-hover' );
				}
			} );
		},

		reInitCarousel: function( event, $scope ) {
			JetWooBuilder.widgetProducts( $scope );
		},

		reInitAjaxLoopAddToCartWithQty: function() {
			$( 'form.cart' ).on( 'change', 'input.qty', JetWooBuilder.ajaxLoopAddToCartWithQty );
		},

		initCarousel: function( $target, options ) {

			let $eWidget = $target.closest( '.elementor-widget' ),
				$slidesCount = $target.find( '.swiper-slide' ).length,
				settings = JetWooBuilder.getElementorElementSettings( $eWidget ),
				eBreakpoints = window.elementorFrontend.config.responsive.activeBreakpoints,
				defaultOptions = {},
				slidesToShow = +settings.columns || 4,
				defaultSlidesToShowMap = {
					mobile: 1,
					tablet: 2
				};

			defaultOptions = {
				slidesPerView: slidesToShow,
				crossFade: 'fade' === options.effect,
				slideToClickedSlide: true,
				handleElementorBreakpoints: true
			}

			defaultOptions.breakpoints = {};

			let lastBreakpointSlidesToShowValue = slidesToShow;

			Object.keys( eBreakpoints ).reverse().forEach( breakpointName => {
				const defaultSlidesToShow = defaultSlidesToShowMap[breakpointName] ? defaultSlidesToShowMap[breakpointName] : lastBreakpointSlidesToShowValue;

				defaultOptions.breakpoints[ eBreakpoints[breakpointName].value ] = {
					slidesPerView: +settings['columns_' + breakpointName] || defaultSlidesToShow,
					slidesPerGroup: +settings['slides_to_scroll_' + breakpointName] || 1
				};

				lastBreakpointSlidesToShowValue = +settings['columns_' + breakpointName] || defaultSlidesToShow;
			} );

			if ( options.paginationEnable ) {
				defaultOptions.pagination = {
					el: '.swiper-pagination',
					clickable: true
				}
			}

			if ( options.navigationEnable ) {
				defaultOptions.navigation = {
					nextEl: '.jet-swiper-button-next',
					prevEl: '.jet-swiper-button-prev',
				}
			}

			let currentDeviceSlidePerView = +settings[ 'columns_' + elementorFrontend.getCurrentDeviceMode() ] || +settings['columns'];

			if ( $slidesCount > currentDeviceSlidePerView ) {
				const Swiper = elementorFrontend.utils.swiper;

				new Swiper( $target, $.extend( {}, defaultOptions, options ) );

				$target.find( '.jet-arrow' ).show();
			} else if ( options.direction === 'vertical' ) {
				$target.addClass( 'swiper-container-vertical' );
				$target.find( '.jet-arrow' ).hide();
			} else {
				$target.find( '.jet-arrow' ).hide();
			}
		},

		jetCartPopupOpen: function ( event, fragments, hash, button ) {
			var $target_enable = $( button ).parents('.jet-woo-products, .jet-woo-products-list, .jet-woo-builder-archive-add-to-cart, .jet-woo-builder-single-ajax-add-to-cart').data('cart-popup-enable'),
				$target_id     = $( button ).parents('.jet-woo-products, .jet-woo-products-list, .jet-woo-builder-archive-add-to-cart, .jet-woo-builder-single-ajax-add-to-cart').data('cart-popup-id');

			$target_id = $($target_id)[0];

			setTimeout( function () {
				if ( $target_enable ) {
					$( window ).trigger( {
						type: 'jet-popup-open-trigger',
						popupData: {
							popupId: 'jet-popup-' + $target_id
						}
					} );
				}
			}, 100 );
		},

		handleListingItemClick: function( event ) {
			var url    = $( this ).data( 'url' ),
				target = $( this ).data( 'target' ) || false;

			if ( url ) {
				event.preventDefault();

				if ( window.elementorFrontend && window.elementorFrontend.isEditMode() ) {
					return;
				}

				if ( '_blank' === target ) {
					window.open( url );
					return;
				}

				window.location = url;
			}
		},

		getElementorElementSettings: function( $scope ) {

			if ( window.elementorFrontend && window.elementorFrontend.isEditMode() && $scope.hasClass( 'elementor-element-edit-mode' ) ) {
				return JetWooBuilder.getEditorElementSettings( $scope );
			}

			return $scope.data( 'settings' ) || {};

		},

		getEditorElementSettings: function( $scope ) {

			var modelCID = $scope.data( 'model-cid' ),
				elementData;

			if ( ! modelCID ) {
				return {};
			}

			if ( ! window.elementorFrontend.hasOwnProperty( 'config' ) ) {
				return {};
			}

			if ( ! window.elementorFrontend.config.hasOwnProperty( 'elements' ) ) {
				return {};
			}

			if ( ! window.elementorFrontend.config.elements.hasOwnProperty( 'data' ) ) {
				return {};
			}

			elementData = window.elementorFrontend.config.elements.data[ modelCID ];

			if ( ! elementData ) {
				return {};
			}

			return elementData.toJSON();

		},

		elementorFrontendInit: function( $content ) {
			$content.find( '[data-element_type]' ).each( function() {

				let $this       = $( this ),
					elementType = $this.data( 'element_type' );

				if ( ! elementType ) {
					return;
				}

				if ( 'widget' === elementType ) {
					window.elementorFrontend.hooks.doAction( 'frontend/element_ready/widget', $this, $ );
				}

				window.elementorFrontend.hooks.doAction( 'frontend/element_ready/global', $this, $ );
				window.elementorFrontend.hooks.doAction( 'frontend/element_ready/' + elementType, $this, $ );

			} );
		}

	};

	$( window ).on( 'elementor/frontend/init', JetWooBuilder.init );

}( jQuery, window.elementorFrontend ) );