<?php
/**
 * Plugin Name: Codeable WooCommerce Additional Cart Fees
 * Plugin URI: https://leogopal.com/
 * Description: A WooCommerce Extension that will increase the carts total by a specified percentage based on which products are present in the cart. A Codeable Test Plugin.
 * Version: 0.0.1
 * Author: Leo Gopal
 * Author URI: https://leogopal.com
 *
 * Text Domain: cwc
 * Domain Path: /languages/
 *
 * @package CodeableWC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Initiate the plugin only if WooCommerce is active and
 * After plugins_loaded.
 */
add_action( 'plugins_loaded', 'cwc_load_after_plugins_loaded' );
function cwc_load_after_plugins_loaded() {
	if ( ! class_exists( "CWC_Add_Fees" ) && class_exists( 'WooCommerce' ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'classes/CWC_Add_Fees.php';
		new CWC_Add_Fees();
	}
}