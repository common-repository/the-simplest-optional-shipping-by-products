<?php
/**
 * Plugin Name: The Simplest: Optional Shipping by Products
 * Description: Disable shipping methods if a certain product is added to WooCommerce shopping cart.
 * Version: 1.0.0
 * Author: thesimplestwp // Mindaugas Jakubauskas
 * Author URI: https://thesimplestwp.com
 * Text Domain: ts-osp
 * Domain Path: /languages
 *
 * @package ts-osp
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No skiddies please!' );
}

// constants.
require_once plugin_dir_path( __FILE__ ) . 'constants.php';

// required classes.
require_once TS_OSP_PATH . 'classes/class-ts-osp-main.php';
require_once TS_OSP_PATH . 'classes/class-ts-osp-product-panel.php';
require_once TS_OSP_PATH . 'classes/class-ts-osp-shipping-methods.php';

/**
 * Initialize main class
 *
 * @return bool|TS_OSP_Main
 */
function ts_osp_main_init() {
	if ( ! class_exists( 'TS_OSP_Main' ) ) {
		return false;
	} else {
		return TS_OSP_Main::instance();
	}
}

// initialize.
ts_osp_main_init();
