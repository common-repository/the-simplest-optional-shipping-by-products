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
 * Main plugin class
 */
class TS_OSP_Main {
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
		// initialize additional meta box in product page.
		add_action( 'init', array( 'TS_OSP_Product_Panel', 'instance' ) );

		// hide disabled shipping methods.
		add_action( 'init', array( 'TS_OSP_Shipping_Methods', 'instance' ) );
	}

	/**
	 * Load theme template parts
	 *
	 * @param string $template template path.
	 * @param array  $args variables array to use in the template.
	 * @return void
	 */
	public static function load_template( $template, $args = array() ) {
		// transfer required arguments.
		foreach ( $args as $key => $arg ) {
			${$key} = $arg;
		}

		// check if view exists at all.
		if ( file_exists( TS_OSP_PATH . '/views/' . $template . '.php' ) ) {
			$load = TS_OSP_PATH . '/views/' . $template . '.php';
		}

		if ( $load ) {
			include $load;
		} else {
			esc_html_e( 'Template not found', 'ts-osp' );
		}
	}
}
