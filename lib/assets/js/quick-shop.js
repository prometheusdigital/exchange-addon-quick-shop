(function(it_exchange_quick_shop) {
	
	it_exchange_quick_shop(window.jQuery, window, document);
	
	}(function($, window, document) {
		$(function() {
			$( '.it-exchange-product-quick-shop' ).on( 'click', function( event ) {
				event.preventDefault();
					var id = $(this).data( 'product-id' );
					
					$.ajax({
						type: 'POST',
						url: it_exchange_quick_shop.ajaxurl,
						data: { 
							'action' : 'it-exchange-quick-shop-initialize-product',
							'id': id
						},
						dataType: 'html',
						success: function( data ) {
							$( 'body' ).append( '<div id="it-exchange-quick-shop-container"></div>' ).find( '#it-exchange-quick-shop-container' ).html( data );
							
							$.colorbox({
								inline: true,
								href: '#it-exchange-quick-shop-container',
								opacity: 1,
								innerWidth: '100%',
								innerHeight: '100%',
								close: '<span class="it-ex-icon-close"></span>',
								overlayClose: false,
								scrolling: false,
								fixed: true,
								className: 'it-exchange-colorbox it-exchange-colorbox-light it-exchange-colorbox-quick-shop',
								onOpen: function() {
									$( '#cboxClose' ).delay( 500 ).fadeTo( 1, 1 );
									$( '#cboxContent, #cboxOverlay' ).delay( 350 ).fadeTo( 350, 1 );
									
									$( '#it-exchange-quick-shop-container' ).on( 'click', '.it-exchange-thumbnail-images li', function() {
										$( '#it-exchange-quick-shop-container' ).find( '.it-exchange-thumbnail-images span' ).removeClass( 'current' );
										$( this ).find( 'span' ).addClass( 'current' );

										$( '#it-exchange-quick-shop-container' ).find( '.it-exchange-featured-image img' ).attr({
											'src':               $( this ).find( 'img' ).attr( 'data-src-large' ),
											'data-src-large':    $( this ).find( 'img' ).attr( 'data-src-large' ),
											'data-height-large': $( this ).find( 'img' ).attr( 'data-height-large' ),
											'data-src-full':     $( this ).find( 'img' ).attr( 'data-src-full' )
										});
									});
								},
								onComplete: function() {
									var padding = ( $( window ).height() - $( '#it-exchange-quick-shop-container' ).height() ) / 2;
									
									$( '#it-exchange-quick-shop-container' ).css( 'margin', padding + 'px auto' );
									
									if ( $( '.it-exchange-super-widget' ).length > 0) {
										$( '#it-exchange-quick-shop-container' ).on( 'submit', '.it-exchange-quick-shop-purchase-options form', function( event ) {
											// $.colorbox.remove();
											
											$( '#it-exchange-quick-shop-container' ).html( '' ).addClass( 'super-widget-mode' );
											
											$( '.it-exchange-super-widget' ).clone().appendTo( '#it-exchange-quick-shop-container' )
										});
									}
									
									$( document ).on( 'click', '.it-exchange-super-widget input', function( event ) {
										$( '#it-exchange-quick-shop-container' ).fadeOut(250);
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
									$( '#it-exchange-quick-shop-container' ).remove();
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