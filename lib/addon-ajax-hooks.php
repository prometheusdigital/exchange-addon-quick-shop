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

	/**
	 * Disables multi item carts if selecting a product with auto-renew enabled
	 * because you cannot mix auto-renew prices with non-auto-renew prices in
	 * payment gateways.
	*/
	if ( it_exchange_product_supports_feature( $product_id, 'recurring-payments', array( 'setting' => 'auto-renew' ) ) )
		if ( it_exchange_product_has_feature( $product_id, 'recurring-payments', array( 'setting' => 'auto-renew' ) ) )
			add_filter( 'it_exchange_multi_item_cart_allowed', '__return_false' );

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

/**
 * AJAX function called to set the added to cart templates.
 *
 * @since 1.0.0
 * @return string HTML output of product.
*/
function it_exchange_quick_view_product_added_to_cart() {
	$product_id = $_POST['id'];

	if ( it_exchange_get_product( $product_id ) ) {
		it_exchange_set_product( $product_id );

		it_exchange_get_template_part( 'content-quick-view-added' );
	} else {
		exit;
	}

	exit;
}
add_action( 'it_exchange_processing_super_widget_ajax_it-exchange-quick-view-product-added-to-cart', 'it_exchange_quick_view_product_added_to_cart' );
add_action( 'it_exchange_processing_super_widget_ajax_nopriv_it-exchange-quick-view-product-added-to-cart', 'it_exchange_quick_view_product_added_to_cart');