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
	// Frontend Quick Shop Dashboard CSS & JS
	wp_enqueue_script( 'it-exchange-quick-shop-addon-public-js', ITUtility::get_url_from_file( dirname( __FILE__ ) . '/assets/js/quick-shop.js' ), array( 'jquery', 'fitvids', 'jquery-colorbox' ), false, true );
	wp_localize_script( 'it-exchange-quick-shop-addon-public-js', 'it_exchange_quick_shop', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_style( 'it-exchange-quick-shop-addon-public-css', ITUtility::get_url_from_file( dirname( __FILE__ ) . '/assets/styles/quick-shop.css' ) );
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

function it_exchange_quick_shop_content_store_after_product_info_hook() {
	it_exchange_get_template_part( 'content', 'store/elements/quick-shop' );
}
add_action( 'it_exchange_content_store_before_permalink_element', 'it_exchange_quick_shop_content_store_after_product_info_hook' );

function it_exchange_quick_shop_content_after_featured_image_hook() {
	if ( it_exchange( 'product', 'has-featured-image' ) === false ) {
		return;
	}
	
	remove_action( 'it_exchange_content_store_before_permalink_element', 'it_exchange_quick_shop_content_store_after_product_info_hook' );
	
	it_exchange_get_template_part( 'content', 'store/elements/quick-shop' );
}
add_action( 'it_exchange_content_store_after_featured_image_element', 'it_exchange_quick_shop_content_after_featured_image_hook' );