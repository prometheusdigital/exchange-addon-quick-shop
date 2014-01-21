<?php
/**
 * iThemes Exchange Quick View Add-on
 * @package IT_Exchange_Addon_Quick_View
 * @since 1.0.0
*/

/**
 * AJAX function called load the product quick view.
 *
 * @since 1.0.0
 * @return string HTML output of product.
*/
function it_exchange_quick_view_initialize_product() {
	$product_id = $_POST['id'];
	$buy_now_text = $_POST['buy'];
	$add_to_cart_text = $_POST['add'];

	if ( it_exchange_get_product( $product_id ) ) {
		it_exchange_set_product( $product_id );
		
		it_exchange_get_template_part( 'content-quick-view' );
	} else {
		exit;
	}

	exit;
}
add_action( 'it_exchange_processing_super_widget_ajax_it-exchange-quick-view-initialize-product', 'it_exchange_quick_view_initialize_product' );
add_action( 'it_exchange_processing_super_widget_ajax_nopriv_it-exchange-quick-view-initialize-product', 'it_exchange_quick_view_initialize_product');