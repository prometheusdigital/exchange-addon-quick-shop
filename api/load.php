<?php
/**
 * iThemes Exchange Quick Shop Add-on
 * load theme API functions
 * @package IT_Exchange_Addon_Quick_Shop
 * @since 1.0.0
*/

if ( is_admin() ) {
	// Admin only
} else {
	// Frontend only
	include( 'theme.php' );
}