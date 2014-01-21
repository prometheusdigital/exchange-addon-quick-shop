<?php
/**
 * iThemes Exchange Quick View Add-on
 * load theme API functions
 * @package IT_Exchange_Addon_Quick_View
 * @since 1.0.0
*/

if ( is_admin() ) {
	// Admin only
} else {
	// Frontend only
	include( 'theme.php' );
}