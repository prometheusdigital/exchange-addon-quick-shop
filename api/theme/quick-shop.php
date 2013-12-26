<?php
/**
 * Quick Shop class for THEME API
 *
 * @since 1.0.0
*/

class IT_Theme_API_Quick_Shop implements IT_Theme_API {
	
	/**
	 * API context
	 * @var string $_context
	 * @since 1.0.0
	*/
	private $_context = 'quick-shop';

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
	function IT_Theme_API_Quick_Shop() {
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

		$id = empty( $this->product->ID ) ? false : '#product-' . $this->product->ID;

		if ( $options['has'] )
			return (boolean) $id;

		$result = '';
		$defaults   = array(
			'before' => '',
			'after'  => '',
			'label'  => __( 'Quick Shop', 'LION' )
		);
		$options = ITUtility::merge_defaults( $options, $defaults );
		
		$class = it_exchange( 'product', 'has-featured-image' ) ? ' it-exchange-product-quick-shop-featured' : ' it-exchange-right';

		$result .= $options['before'];

		$result .= '<a class="it-exchange-product-quick-shop' . $class . '" href="' . $id . '">';
		$result .= $options['label'];
		$result .= '</a>';

		$result .= $options['after'];

		return $result;

	}
}
