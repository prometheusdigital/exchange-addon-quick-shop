<?php
/**
 * iThemes Exchange Quick Shop Add-on
 * @package IT_Exchange_Addon_Quick_Shop
 * @since 1.0.0
*/

/**
 * AJAX function called load the product quick shop.
 *
 * @since 1.0.0
 * @return string HTML output of product.
*/
function it_exchange_quick_shop_initialize_product() {
	$product_id = $_POST['id'];
	$buy_now_text = $_POST['buy'];
	$add_to_cart_text = $_POST['add'];

	$args['before_widget'] = '<div class="it-exchange-product-sw single-product-super-widget">';
	$args['after_widget'] = '</div>';
	$args['enqueue_hide_script'] = false;

	$product = array(
		'images'      => it_exchange_get_product_feature( $product_id, 'product-images' ),
		'title'       => it_exchange_get_product_feature( $product_id, 'title' ),
		'description' => it_exchange_get_product_feature( $product_id, 'description' ),
		'price'       => it_exchange_format_price( it_exchange_get_product_feature( $product_id, 'base-price' ) ),
		'buy_now'     => it_exchange_quick_shop_buy_now( $product_id, $buy_now_text ),
		'add_to_cart' => it_exchange_quick_shop_add_to_cart( $product_id, $add_to_cart_text )
	);

	if ( isset( $product['images'][0] ) ) {
		$product['featured_image'] = wp_get_attachment_image_src( $product['images'][0], 'large' );
	}

	ob_start();

	?>
		<div id="it-exchange-quick-shop" class="it-exchange-columns-wrapper <?php echo ( isset( $product['featured_image'] ) ) ? 'it-exchange-quick-shop-has-featured-image' : 'it-exchange-quick-shop-no-featured-image'; ?>">
			<?php if ( isset( $product['featured_image'] ) ) : ?>
				<div class="it-exchange-column it-exchange-featured-image">
					<div class="it-exchange-column-inner">
						<img src="<?php echo $product['featured_image'][0] ?>" alt="" />
					</div>
				</div>
			<?php endif; ?>
			<div class="it-exchange-column it-exchange-product-info">
				<div class="it-exchange-column-inner">
					<h2 class="it-exchange-product-title"><?php echo $product['title']; ?></h2>
					<p class="it-exchange-base-price"><?php echo $product['price']; ?></p>
					<p class="it-exchange-product-description"><?php echo $product['description']; ?></p>
					<div class="it-exchange-quick-shop-purchase-options">
						<?php echo $product['buy_now']; ?>
						<?php echo $product['add_to_cart']; ?>
					</div>
				</div>
			</div>
		</div>
	<?php

	$output = ob_get_clean();

	echo $output;

	exit;
}
add_action( 'wp_ajax_it-exchange-quick-shop-initialize-product', 'it_exchange_quick_shop_initialize_product' );
add_action( 'wp_ajax_nopriv_it-exchange-quick-shop-initialize-product', 'it_exchange_quick_shop_initialize_product');