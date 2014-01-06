<?php
/**
 * iThemes Exchange Quick Shop Add-on
 * @package IT_Exchange_Addon_Quick_Shop
 * @since 1.0.0
*/

/**
 * Shows the nag when needed.
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_quick_shop_addon_show_version_nag() {
	if ( $GLOBALS['it_exchange']['version'] < '1.5.0' ) {
		?>
		<div class="it-exchange-nag it-exchange-add-on-min-version-nag">
			<?php printf( __( 'The Quick Shop add-on requires iThemes Exchange version 1.5.0 or greater. %sPlease upgrade Exchange%s.', 'LION' ), '<a href="' . admin_url( 'update-core.php' ) . '">', '</a>' ); ?>
		</div>
		<script type="text/javascript">
			jQuery( document ).ready( function() {
				if ( jQuery( '.wrap > h2' ).length == '1' ) {
					jQuery(".it-exchange-add-on-min-version-nag").insertAfter('.wrap > h2').addClass( 'after-h2' );
				}
			});
		</script>
		<?php
	}
}
add_action( 'admin_notices', 'it_exchange_quick_shop_addon_show_version_nag' );

/**
 * Enqueues Quick Shop scripts to WordPress frontend
 *
 * @since 1.0.0
 *
 * @param string $current_view WordPress passed variable
 * @return void
*/
function it_exchange_quick_shop_addon_load_public_scripts( $current_view ) {
	// Frontend Quick Shop Store CSS & JS
	if ( it_exchange_is_page( 'store' ) ) {
		wp_enqueue_script( 'it-exchange-quick-shop-addon-public-js', ITUtility::get_url_from_file( dirname( __FILE__ ) . '/assets/js/quick-shop.js' ), array( 'jquery', 'jquery-colorbox' ), false, true );
		wp_localize_script( 'it-exchange-quick-shop-addon-public-js', 'it_exchange_quick_shop', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_style( 'it-exchange-quick-shop-addon-public-css', ITUtility::get_url_from_file( dirname( __FILE__ ) . '/assets/styles/quick-shop.css' ), array( 'it-exchange-icon-fonts' ) );
	}
}
add_action( 'wp_enqueue_scripts', 'it_exchange_quick_shop_addon_load_public_scripts' );

/**
 * Adds Quick Shop Template Path to iThemes Exchange Template paths
 *
 * @since 1.0.0
 * @param array $possible_template_paths iThemes Exchange existing Template paths array
 * @param array $template_names
 * @return array
*/
function it_exchange_quick_shop_addon_template_path( $possible_template_paths, $template_names ) {
	$possible_template_paths[] = dirname( __FILE__ ) . '/templates/';
	return $possible_template_paths;
}
add_filter( 'it_exchange_possible_template_paths', 'it_exchange_quick_shop_addon_template_path', 10, 2 );

/**
 * Adds Quick Shop button to the product elements on the store.
 *
 * @since 1.0.0
*/
function it_exchange_quick_shop_content_store_after_product_info_hook() {
	it_exchange_get_template_part( 'content', 'store/elements/quick-shop' );
}
add_action( 'it_exchange_content_store_before_permalink_element', 'it_exchange_quick_shop_content_store_after_product_info_hook' );

/**
 * If a product has a featured image, this removes the quick shop button
 * from the elements loop and hooks it into the featured image template.
 *
 * @since 1.0.0
*/
function it_exchange_quick_shop_content_after_featured_image_hook() {
	if ( it_exchange( 'product', 'has-featured-image' ) === false ) {
		return;
	}
	
	remove_action( 'it_exchange_content_store_before_permalink_element', 'it_exchange_quick_shop_content_store_after_product_info_hook' );
	
	it_exchange_get_template_part( 'content', 'store/elements/quick-shop' );
}
add_action( 'it_exchange_content_store_after_featured_image_element', 'it_exchange_quick_shop_content_after_featured_image_hook' );

/**
 * Build the quick shop buy now button. This is used in the
 * addon ajax callback.
 *
 * @since 1.0.0
 * @var $product_id
*/
function it_exchange_quick_shop_buy_now( $product_id ) {
	
	// Setting this filter to true will disable the Buy Now Button
	if ( apply_filters( 'it_exchange_disable_buy_now', false, $product_id ) ) {
		return '';
	}

	// Parse options
	$result = false;

	$options = array(
		'before'              => '',
		'after'               => '',
		'class'               => false,
		'label'               => __( 'Buy Now', 'LION' ),
		'button-type'         => 'submit',
		'button-name'         => false,
		'out-of-stock-text'   => __( 'Out of stock.', 'LION' ),
		'not-available-text'  => __( 'Product not available right now.', 'LION' ),
	);

	// Allow options to be filtered
	$options = apply_filters( 'it_exchange_product_theme_api_buy_now_options', $options, $product_id );

	// If we are tracking inventory, lets make sure we have some available
	$product_in_stock = it_exchange_product_supports_feature( $product_id, 'inventory' ) ? it_exchange_product_has_feature( $product_id, 'inventory' ) : true;

	// If we're supporting availability dates, check that
	$product_is_available = it_exchange_is_product_available( $product_id );

	$output = '';

	$class          = empty( $options['class'] ) ? 'buy-now-button' : 'buy-now-button ' . esc_attr( $options['class'] );
	$var_key        = it_exchange_get_field_name( 'buy_now' );
	$var_value      = $product_id;
	$button_name    = empty( $options['button-name'] ) ? '' : ' name="' . esc_attr( $options['button-name'] ) . '"';
	$button         = '<input' . $button_name . ' type="' . esc_attr( $options['button-type'] ) . '" value="' . esc_attr( $options['label'] ) . '" class="' . esc_attr( $class ) . '" />';
	$hidden_fields  = '<input type="hidden" name="it-exchange-action" value="buy_now" />';
	$hidden_fields .= '<input class="buy-now-product-id" type="hidden" name="' . esc_attr( $var_key ). '" value="' . esc_attr( $var_value ). '" />';
	$hidden_fields .= wp_nonce_field( 'it-exchange-purchase-product-' . $product_id, '_wpnonce', true, false );

	if ( ! $product_in_stock )
		return '<p>' . esc_attr( $options['out-of-stock-label'] ) . '</p>';

	if ( ! $product_is_available )
		return '<p>' . esc_attr( $options['not-available-text'] ) . '</p>';

	$result  = '<form action="" method="post" class="it-exchange-sw-purchase-options it-exchange-sw-buy-now ' . esc_attr( $class ) . '">';
	$result .= $hidden_fields;

	$result .= $button;
	$result .= '</form>';

	return $result;
}

/**
 * Build the quick shop add to cart button. This is used in the
 * addon ajax callback.
 *
 * @since 1.0.0
 * @var $product_id
*/
function it_exchange_quick_shop_add_to_cart( $product_id ) {
	// Parse options
	$result        = false;

	$defaults      = array(
		'before'              => '',
		'after'               => '',
		'class'               => false,
		'label'               => __( 'Add to Cart', 'LION' ),
		'button-type'         => 'submit',
		'button-name'         => false,
		'out-of-stock-text'   => __( 'Out of stock.', 'LION' ),
		'not-available-text'  => __( 'Product not available right now.', 'LION' ),
	);
	$options   = $defaults;

	// If we are tracking inventory, lets make sure we have some available
	$product_in_stock = it_exchange_product_supports_feature( $product_id, 'inventory' ) ? it_exchange_product_has_feature( $product_id, 'inventory' ) : true;

	// If we're supporting availability dates, check that
	$product_is_available = it_exchange_is_product_available( $product_id );

	// Do we have multi-item cart add-on enabled?
	$multi_item_cart = it_exchange_is_multi_item_cart_allowed();

	// Init empty hidden field variables
	$buy_now_hidden_fields = $add_to_cart_hidden_fields = '';

	$class          = empty( $options['class'] ) ? 'add-to-cart-button' : 'add-to-cart-button ' . esc_attr( $options['class'] );
	$var_key        = it_exchange_get_field_name( 'add_product_to_cart' );
	$var_value      = $product_id;
	$button_name    = empty( $options['button-name'] ) ? '' : ' name="' . esc_attr( $options['button-name'] ) . '"';
	$button         = '<input' . $button_name . ' type="' . esc_attr( $options['button-type'] ) . '" value="' . esc_attr( $options['label'] ) . '" class="' . esc_attr( $class ) . '" />';
	$hidden_fields  = '<input type="hidden" name="it-exchange-action" value="add_product_to_cart" />';
	$hidden_fields .= '<input class="add-to-cart-product-id" type="hidden" name="' . esc_attr( $var_key ). '" value="' . esc_attr( $var_value ). '" />';
	$hidden_fields .= wp_nonce_field( 'it-exchange-purchase-product-' . $product_id, '_wpnonce', true, false );

	if ( ! $product_in_stock )
		return '<p>' . esc_attr( $options['out-of-stock-text'] ) . '</p>';

	if ( ! $product_is_available )
		return '<p>' . esc_attr( $options['not-available-text'] ) . '</p>';

	if ( ! $multi_item_cart )
		return '';

	$result  = '<form action="" method="post" class="it-exchange-sw-purchase-options it-exchange-sw-add-to-cart ' . esc_attr( $class ) . '">';
	$result .= $hidden_fields;

	$result .= $button;
	$result .= '</form>';

	return $result;
}
