<?php
/**
 * Main class
 *
 * @package ts-osp
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No skiddies please!' );
}

/**
 * WooCommerce product admin panel class.
 */
class TS_OSP_Product_Panel {
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
	 *
	 * @return void
	 */
	public function __construct() {
		// add shipping methods meta box to product page.
		add_action( 'add_meta_boxes', array( $this, 'add_shipping_methods_meta_box' ) );

		// save data from shipping methods meta box.
		add_action( 'save_post', array( $this, 'save_shipping_methods_meta_data' ) );
	}

	/**
	 * Add meta box for shipping methods to product admin panel.
	 *
	 * @return void
	 */
	public function add_shipping_methods_meta_box() {
		add_meta_box(
			'ts_osp_shipping_methods_id',
			'Select the shipping methods you want to disable',
			array( $this, 'shipping_methods_meta_box_html' ),
			'product'
		);
	}

	/**
	 * Show shipping methods box.
	 *
	 * @param array $post post object.
	 * @return void
	 */
	public static function shipping_methods_meta_box_html( $post ) {
		$all_shipping_methods = WC()->shipping->get_shipping_methods();
		$disabled_methods     = get_post_meta( $post->ID, 'ts_osp_disabled_shipping_methods', true );

		TS_OSP_Main::load_template(
			'shipping-methods-box',
			array(
				'all_shipping_methods' => $all_shipping_methods,
				'disabled_methods'     => $disabled_methods,
			)
		);
	}

	/**
	 * Save shipping methods form checkbox values.
	 *
	 * @param int $post_id post id.
	 * @return void
	 */
	public static function save_shipping_methods_meta_data( $post_id ) {
		if ( isset( $_POST['ts_osp_disabled_methods'] ) ) {
			$disabled_methods = wp_unslash( $_POST['ts_osp_disabled_methods'] );
			$disabled_methods = array_map( 'sanitize_text_field', $disabled_methods );

			update_post_meta(
				$post_id,
				'ts_osp_disabled_shipping_methods',
				$disabled_methods
			);
		} else {
			update_post_meta(
				$post_id,
				'ts_osp_disabled_shipping_methods',
				false
			);
		}
	}
}
