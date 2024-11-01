<?php
/**
 * Woo cart actions class
 *
 * @package ts-osp
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No skiddies please!' );
}

/**
 * WooCommerce cart actions class.
 */
class TS_OSP_Shipping_Methods {
	/**
	 * Main instance
	 *
	 * @var array
	 */
	protected static $instance = null;

	/**
	 * Main instance
	 *
	 * @return TS_OSP_Main
	 */
	public static function instance() {
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor, loads main actions, methods etc.
	 */
	public function __construct() {
		// hide disabled shipping methods.
		add_filter( 'woocommerce_package_rates', array( $this, 'hide_selected_shipping_methods' ), 10, 2 );
	}

	/**
	 * Hide disabled shipping methods.
	 *
	 * @param array $rates shipping methods.
	 * @return array filtered shipping methods.
	 */
	public static function hide_selected_shipping_methods( $rates ) {
		$disabled_methods_array = $this->get_disabled_shipping_methods();
		$custom_methods_array   = array();

		if ( ! empty( $disabled_methods_array ) ) {
			foreach ( $rates as $rate_id => $rate ) {
				if ( in_array( $rate->method_id, $disabled_methods_array ) ) {
					continue;
				} else {
					$custom_methods_array[ $rate_id ] = $rate;
				}
			}

			return $custom_methods_array;
		} else {
			return $rates;
		}
	}

	/**
	 * Get disabled shipping methods for items in the shopping cart
	 *
	 * @return array Disabled methods list.
	 */
	public function get_disabled_shipping_methods() {
		global $wpdb;

		$disabled_methods = array();

		foreach ( WC()->cart->get_cart() as $cart_item ) {
			$item_disabled_methods = get_post_meta( $cart_item['product_id'], 'ts_osp_disabled_shipping_methods', true );

			if ( ! empty( $item_disabled_methods ) && is_array( $item_disabled_methods ) ) {
				$disabled_methods = array_merge( $disabled_methods, $item_disabled_methods );
			}
		}

		return $disabled_methods;
	}
}
