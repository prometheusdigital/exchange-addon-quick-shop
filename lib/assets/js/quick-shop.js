(function(it_exchange_quick_shop) {
	
	it_exchange_quick_shop(window.jQuery, window, document);
	
	}(function($, window, document) {
		$(function() {
			$( '.it-exchange-product-quick-shop' ).on( 'click', function( event ) {
				event.preventDefault();
				
				var data = {
					action: 'it-exchange-quick-shop-initilize-product',
					id: $( this ).attr( 'href' )
				};
				
				$.post( it_exchange_quick_shop.ajax_url, data, function( response ) {
					
				});	
			});
		});
	})
);