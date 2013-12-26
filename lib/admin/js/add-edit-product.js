jQuery(document).ready(function($) {
	/*
	 * We want the ability to edit the data for the
	 * thumbnails. Clicking on the any of the items
	 * will open this frame with the selected item.
	*/
	it_exchange_quick_shop_upload_frame = {
		frame: function() {
			if ( this._frame )
				return this._frame;

			this._frame = wp.media({
				title: 'Upload',
				button: {
					text: 'Insert Shortcode'
				},
				library: {
					type: ['video/mp4', 'video/x-ms-wmv', 'video/ogg', 'video/webm']
				},
				multiple: false
			});
			
			this._frame.on( 'open', this.open ).on( 'close', this.close ).state('library').on( 'select', this.select );
			
			return this._frame
		},
		
		open: function() {
			
		},
		
		select: function() {
			source = this.get( 'selection' ).single().toJSON();
			
			var file = source.mime.replace( 'video/', '' );
			
			if ( file == 'x-ms-wmv' ) {
				var file = file.replace( 'x-ms-', '' );
			}
			
			var shortcode = '[video width="' + source.width + '" height="' + source.height + '" ' + file + '="' + source.url + '"][/video]';
			
			$( '#quick-shop' ).val( shortcode );
			
			if ( shortcode !== $( this ).parent().attr( 'data-current' ) ) {
				$( '.quick-shop-placeholder' ).hide();
			}
		},
		
		init: function() {
			$( '#wpbody' ).on( 'click', '.it-exchange-quick-shop-upload', function( event ) {
				event.preventDefault();
				
				it_exchange_quick_shop_upload_frame.frame().open();
			});
		}
	};

	it_exchange_quick_shop_upload_frame.init();
	
	$( '#quick-shop' ).on( 'focusout', function() {
		if ( $( this ).val() !== $( this ).parent().attr( 'data-current' ) ) {
			$( '.quick-shop-placeholder' ).hide();
		}
	});
	
	$( '.quick-shop-embeded' ).fitVids();
});