<?php
/**
 * The default product-info loop for the
 * content-quick-view.php template part.
 *
 * @since 1.1.0
 * @version 1.1.0
 * @package IT_Exchange
 *
 * WARNING: Do not edit this file directly. To use
 * this template in a theme, simply copy this file's
 * content to the exchange/content-quick-view/loops
 * directory located in your theme.
*/
?>

<?php do_action( 'it_exchange_quick_view_before_product_info_loop' ); ?>
<?php foreach ( it_exchange_get_template_part_elements( 'content_quick_view', 'product_info_loop', array( 'title', 'base-price', 'description', 'purchase-options' ) ) as $detail ) : ?>
	<?php it_exchange_get_template_part( 'content-quick-view/elements/' . $detail ); ?>
<?php endforeach; ?>
<?php do_action( 'it_exchange_quick_view_after_product_info_loop' ); ?>