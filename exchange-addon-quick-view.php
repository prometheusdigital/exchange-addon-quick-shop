<?php
/*
 * Plugin Name: iThemes Exchange - Quick View Add-on
 * Version: 1.0.0
 * Description: Adds the quick view feature to iThemes Exchange store products.
 * Plugin URI: http://ithemes.com/exchange/quick-view/
 * Author: iThemes
 * Author URI: http://ithemes.com
 * iThemes Package: exchange-addon-quick-view
 
 * Installation:
 * 1. Download and unzip the latest release zip file.
 * 2. If you use the WordPress plugin uploader to install this plugin skip to step 4.
 * 3. Upload the entire plugin directory to your `/wp-content/plugins/` directory.
 * 4. Activate the plugin through the 'Plugins' menu in WordPress Administration.
 *
*/

/**
 * This registers our plugin as a quick view addon
 *
 * @since 1.0.0
 *
 * @return void
*/
function it_exchange_register_quick_view_addon() {
	$options = array(
		'name'              => __( 'Quick View', 'LION' ),
		'description'       => __( 'Adds a quick view feature to the store page.', 'LION' ),
		'author'            => 'iThemes',
		'author_url'        => 'http://ithemes.com/exchange/quick-view/',
		'icon'              => ITUtility::get_url_from_file( dirname( __FILE__ ) . '/lib/images/quickview50px.png' ),
		'file'              => dirname( __FILE__ ) . '/init.php',
		'category'          => 'other',
		'basename'          => plugin_basename( __FILE__ ),
		'labels'      => array(
			'singular_name' => __( 'Quick View', 'LION' ),
		),
		'settings-callback' => 'it_exchange_quick_view_settings_callback',
	);
	it_exchange_register_addon( 'quick-view', $options );
}
add_action( 'it_exchange_register_addons', 'it_exchange_register_quick_view_addon' );

/**
 * Loads the translation data for WordPress
 *
 * @uses load_plugin_textdomain()
 * @since 1.0.0
 * @return void
*/
function it_exchange_quick_view_set_textdomain() {
	load_plugin_textdomain( 'LION', false, dirname( plugin_basename( __FILE__  ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'it_exchange_quick_view_set_textdomain' );

/**
 * Registers Plugin with iThemes updater class
 *
 * @since 1.0.0
 *
 * @param object $updater ithemes updater object
 * @return void
*/
function ithemes_exchange_addon_quick_view_updater_register( $updater ) { 
	$updater->register( 'exchange-addon-quick-view', __FILE__ );
}
add_action( 'ithemes_updater_register', 'ithemes_exchange_addon_quick_view_updater_register' );
require( dirname( __FILE__ ) . '/lib/updater/load.php' );