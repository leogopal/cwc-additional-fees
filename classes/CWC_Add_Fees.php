<?php
/**
 * Created by PhpStorm.
 * User: leogopal
 * Date: 3/28/18
 * Time: 10:48 AM
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class CWC_Add_Fees
 *
 * Defines the core logic of adding the percentage increase.
 *
 */
class CWC_Add_Fees {

	public function __construct() {
		if ( is_admin() ) {
			// Product & global settings
			require_once 'CWC_Settings_Global.php';
			require_once 'CWC_Settings_Product.php';
		}

		// Hook-in for fees to be added
		add_action( 'woocommerce_cart_calculate_fees', array( $this, 'add_fees' ), 15 );
	}

	public function add_fees() {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}

		$fee_enabled = get_option( '_cwc_fee_enabled' );

		// Quit if feature is not enabled site-wide.
		if ( ! isset( $fee_enabled ) || empty( $fee_enabled ) || $fee_enabled == 'no' ) {
			return;
		}

		$fee_label           = ! empty( get_option( '_cwc_fee_label' ) ) ? get_option( '_cwc_fee_label' ) : 'Custom Fee';
		$fee_percentage      = ! empty( get_option( '_cwc_fee_charges' ) ) ? get_option( '_cwc_fee_charges' ) : 10;
		$maybe_increase_cart = false;

		// Check if there are any products in the cart that should affect the price increase.
		foreach ( WC()->cart->cart_contents as $key => $values ) {
			$product_fee_enabled = get_post_meta( $values['product_id'], '_cwc_product_fee_enabled', true );

			if ( ( isset( $product_fee_enabled ) && ! empty( $product_fee_enabled ) ) && $product_fee_enabled == 'yes' ) {
				$maybe_increase_cart = true;
				break;
			}

		}

		// If there are products in the cart to affect the price increase, do the increase once only.
		if ( $maybe_increase_cart ) {
			$additional_fee = WC()->cart->subtotal * ( $fee_percentage / 100 );
			WC()->cart->add_fee( __( $fee_label, 'cwc' ), $additional_fee );
		}

	}
}