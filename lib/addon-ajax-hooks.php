<?php
/**
 * iThemes Exchange Membership Add-on
 * @package IT_Exchange_Addon_Membership
 * @since 1.0.0
*/

/**
 * AJAX function called to remove content access rules to a WordPress $post
 *
 * @since 1.0.0
 * @return string HTML output of content access rules
*/
function it_exchange_quick_shop_initilize_product() {

	$id = $_POST['id'];

	echo $id;
	
	$return = '<div style="height: 500px;background: red;"></div>';

	die( $return );
}
add_action( 'wp_ajax_it-exchange-quick-shop-initilize-product', 'it_exchange_quick_shop_initilize_product' );
