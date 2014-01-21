<?php
/**
 * Quick View class for THEME API
 *
 * @since 1.0.0
*/

class IT_Theme_API_Quick_View implements IT_Theme_API {
	
	/**
	 * API context
	 * @var string $_context
	 * @since 1.0.0
	*/
	private $_context = 'quick-view';

	/**	
	 * Maps api tags to methods
	 * @var array $_tag_map
	 * @since 1.0.0
	*/
	var $_tag_map = array(
		'button' => 'button',
	);

	/**
	 * Current product in iThemes Exchange Global
	 * @var object $product
	 * @since 1.0.0
	*/
	private $product;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @return void
	*/
	function IT_Theme_API_Quick_View() {
		// Set the current global product as a property
		$this->product = empty( $GLOBALS['it_exchange']['product'] ) ? false : $GLOBALS['it_exchange']['product'];
	}

	/**
	 * Returns the context. Also helps to confirm we are an iThemes Exchange theme API class
	 *
	 * @since 1.0.0
	 * 
	 * @return string
	*/
	function get_api_context() {
		return $this->_context;
	}

	/**
	 * The product ID.
	 *
	 * @since 1.0.0
	 * @return mixed
	*/
	function button( $options=array() ) {

		$id = empty( $this->product->ID ) ? false : $this->product->ID;

		if ( $options['has'] ) {
			return (boolean) $id;
		}

		if ( false === $id ) {
			return;
		}

		$result = '';
		$defaults   = array(
			'before'            => '',
			'after'             => '',
			'label'             => __( 'Quick View', 'LION' ),
			'buy_now_label'     => __( 'Buy Now', 'LION' ),
			'add_to_cart_label' => __( 'Add to Cart', 'LION' ),
			'on_hover'          => false
		);

		$options = ITUtility::merge_defaults( $options, $defaults );

		$class = it_exchange( 'product', 'has-featured-image' ) ? ' it-exchange-product-quick-view-featured' : ' it-exchange-right';

		if ( it_exchange( 'product', 'has-featured-image' ) ) {
			$class .= ( $options['on_hover'] == true ) ? ' it-exchange-hidden' : '';
		}

		$result .= $options['before'];

		$result .= '<a href class="it-exchange-product-quick-view' . $class . '" data-product-id="' . $id . '" data-buy-now="' . $options['buy_now_label'] . '" data-add-to-cart="' . $options['add_to_cart_label'] . '">';
		$result .= $options['label'];
		$result .= '</a>';

		$result .= $options['after'];

		return $result;

	}
}
