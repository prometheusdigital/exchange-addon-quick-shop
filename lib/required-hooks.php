<?php
/**
 * iThemes Exchange Quick View Add-on
 * @package IT_Exchange_Addon_Quick_View
 * @since 1.0.0
*/

/**
 * Shows the nag when needed.
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_quick_view_addon_show_version_nag() {
	if ( version_compare( $GLOBALS['it_exchange']['version'], '1.7.16', '<' ) ) {
		?>
		<div class="it-exchange-nag it-exchange-add-on-min-version-nag">
			<?php printf( __( 'The Quick View add-on requires iThemes Exchange version 1.7.16 or greater. %sPlease upgrade Exchange%s.', 'LION' ), '<a href="' . admin_url( 'update-core.php' ) . '">', '</a>' ); ?>
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

	if ( function_exists( 'it_exchange_register_stripe_addon' ) ) {
		$exchange_addon_stripe = get_plugin_data( plugin_dir_path( dirname( dirname( __FILE__  ) ) ) . 'exchange-addon-stripe/exchange-addon-stripe.php' );

		if ( version_compare( $exchange_addon_stripe['Version'], '1.1.14', '<' ) ) {
			?>
			<div class="it-exchange-nag it-exchange-add-on-min-version-nag">
				<?php printf( __( 'The Quick View add-on requires Exchange Add-on Stripe version 1.2.0 or greater to function properly.', 'LION' ) ); ?>
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
}
add_action( 'admin_notices', 'it_exchange_quick_view_addon_show_version_nag' );

/**
 * Enqueues Quick View scripts to WordPress frontend
 *
 * @since 1.0.0
 *
 * @param string $current_view WordPress passed variable
 * @return void
*/
function it_exchange_quick_view_addon_load_public_scripts( $current_view ) {
	// Frontend Quick View Store CSS & JS
	if ( it_exchange_is_page( 'store' ) ) {
		wp_enqueue_script( 'it-exchange-quick-view-addon-public-js', ITUtility::get_url_from_file( dirname( __FILE__ ) . '/assets/js/quick-view.js' ), array( 'jquery', 'jquery-colorbox', 'it-exchange-super-widget' ), false, true );
		wp_enqueue_style( 'it-exchange-quick-view-addon-public-css', ITUtility::get_url_from_file( dirname( __FILE__ ) . '/assets/styles/quick-view.css' ), array( 'it-exchange-icon-fonts' ) );
	}
}
add_action( 'wp_enqueue_scripts', 'it_exchange_quick_view_addon_load_public_scripts' );

/**
 * Adds Quick View Template Path to iThemes Exchange Template paths
 *
 * @since 1.0.0
 * @param array $possible_template_paths iThemes Exchange existing Template paths array
 * @param array $template_names
 * @return array
*/
function it_exchange_quick_view_addon_template_path( $possible_template_paths, $template_names ) {
	$possible_template_paths[] = dirname( __FILE__ ) . '/templates/';
	return $possible_template_paths;
}
add_filter( 'it_exchange_possible_template_paths', 'it_exchange_quick_view_addon_template_path', 10, 2 );

/**
 * Adds Quick View button to the product elements on the store.
 *
 * @since 1.0.0
*/
function it_exchange_quick_view_content_store_after_product_info_hook() {
	if ( ! it_exchange( 'product', 'has-featured-image' ) ) {
		it_exchange_get_template_part( 'content', 'store/elements/quick-view' );
	}
}
add_action( 'it_exchange_content_store_before_permalink_element', 'it_exchange_quick_view_content_store_after_product_info_hook' );

/**
 * If a product has a featured image, this removes the quick view button
 * from the elements loop and hooks it into the featured image template.
 *
 * @since 1.0.0
*/
function it_exchange_quick_view_content_after_featured_image_hook() {
	if ( it_exchange( 'product', 'has-featured-image' ) ) {
		it_exchange_get_template_part( 'content', 'store/elements/quick-view' );
	}
}
add_action( 'it_exchange_content_store_after_featured_image_element', 'it_exchange_quick_view_content_after_featured_image_hook' );

/**
 * Add the super widget to the footer of the store page
 * if a super widget does not exist on the page.
 *
 * @since 1.0.0
*/
function it_exchange_quick_view_add_super_widget() {
	if ( it_exchange_is_page( 'store' ) && ! is_active_widget( false, false, 'it-exchange-super-widget' ) ) {
		$args['before_widget'] = '<div class="it-exchange-product-sw single-product-super-widget it-exchange-hidden">';
		$args['after_widget'] = '</div>';
		$args['enqueue_hide_script'] = false;

		the_widget( 'IT_Exchange_Super_Widget', array(), $args );
	}
}
add_action( 'wp_footer', 'it_exchange_quick_view_add_super_widget' );