(function(it_exchange_quick_view) {

	it_exchange_quick_view(window.jQuery, window, document);

	}(function($, window, document) {
		$(function() {
			$( '.it-exchange-product-quick-view' ).on( 'click', function( event ) {
				event.preventDefault();	
				var id = $( this ).data( 'product-id' );

				$.ajax({
					type: 'POST',
					url: itExchangeSWAjaxURL + '&sw-action=it-exchange-quick-view-initialize-product',
					data: { 
						'action' : 'it-exchange-quick-view-initialize-product',
						'id'     : id,
						'buy'    : $( this ).data( 'buy-now' ),
						'add'    : $( this ).data( 'add-to-cart' )
					},
					dataType: 'html',
					success: function( data ) {
						$( 'body' ).append( '<div id="it-exchange-quick-view-container"></div>' ).find( '#it-exchange-quick-view-container' ).html( data );

						$.colorbox({
							inline: true,
							href: '#it-exchange-quick-view-container',
							opacity: 1,
							innerWidth: '100%',
							innerHeight: '100%',
							close: '<span class="it-ex-icon-close"></span>',
							overlayClose: false,
							scrolling: false,
							fixed: true,
							className: 'it-exchange-colorbox it-exchange-colorbox-light it-exchange-colorbox-quick-view',
							onOpen: function() {
								$( '#cboxClose' ).delay( 500 ).fadeTo( 1, 1 );
								$( '#cboxContent, #cboxOverlay' ).delay( 350 ).fadeTo( 350, 1 );
								
								$( '#it-exchange-quick-view-container' ).on( 'click', '.it-exchange-thumbnail-images li', function() {
									$( '#it-exchange-quick-view-container' ).find( '.it-exchange-thumbnail-images span' ).removeClass( 'current' );
									$( this ).find( 'span' ).addClass( 'current' );

									$( '#it-exchange-quick-view-container' ).find( '.it-exchange-featured-image img' ).attr({
										'src':               $( this ).find( 'img' ).attr( 'data-src-large' ),
										'data-src-large':    $( this ).find( 'img' ).attr( 'data-src-large' ),
										'data-height-large': $( this ).find( 'img' ).attr( 'data-height-large' ),
										'data-src-full':     $( this ).find( 'img' ).attr( 'data-src-full' )
									});
								});
							},
							onComplete: function() {
								var padding = ( $( window ).height() - $( '#it-exchange-quick-view-container' ).height() ) / 2;

								$( '#it-exchange-quick-view-container' ).css( 'margin', padding + 'px auto' );

								if ( $( '.it-exchange-super-widget' ).length > 0) {
									$( '#it-exchange-quick-view-container' ).on( 'submit', '.it-exchange-quick-view-purchase-options form', function( event ) {
										// $.colorbox.remove();

										$( '#it-exchange-quick-view-container' ).html( '' ).addClass( 'super-widget-mode' );

										$( '.it-exchange-super-widget' ).clone().appendTo( '#it-exchange-quick-view-container' )
									});
								}

								$( document ).on( 'click', '.it-exchange-super-widget .payment-methods-wrapper input', function( event ) {
									$( '#it-exchange-quick-view-container' ).fadeOut(250);
									window.setTimeout( function() { $.colorbox.remove() }, 250 );
								});

								$( document ).on( 'click', function( event ) {
									if ( $( event.target ).attr( 'id' ) ) {
										var closer = $( event.target ).attr( 'id' );
									} else {
										var closer = $( event.target ).attr( 'class' );
									}

									if ( closer == 'cboxLoadedContent' ) {
										$.colorbox.remove();
									}
								});
							},
							onCleanup: function() {
								$( '#it-exchange-quick-view-container' ).remove();
							},
							onClosed: function() {
								$( '#cboxClose' ).fadeTo( 1, 0 );
							}
						});
					}
				});
			});
		});
	})
);