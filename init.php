<?php
/**
 * iThemes Exchange Membership Add-on
 * @package exchange-addon-quick-view
 * @since 1.0.0
*/

/**
 * New API functions.
*/
include( 'api/load.php' );

/**
 * Exchange Add-ons require several hooks in order to work properly. 
 * We've placed them all in one file to help add-on devs identify them more easily
*/
include( 'lib/required-hooks.php' );

/**
 * We decided to place all AJAX hooked functions into this file, just for ease of use
*/
include( 'lib/addon-ajax-hooks.php' );
