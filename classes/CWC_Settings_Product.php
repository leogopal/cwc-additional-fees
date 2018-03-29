<?php
/**
 * Created by PhpStorm.
 * User: leogopal
 * Date: 3/28/18
 * Time: 10:48 AM
 */

class CWC_Settings_Product {
	public function __construct() {
		// Add and save product settings.
		add_action( 'woocommerce_product_write_panel_tabs', array( $this, 'create_product_panel_tab' ) );
		add_action( 'woocommerce_product_data_panels', array( $this, 'product_settings_fields' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_product_settings_fields' ) );

		// CSS
		add_action( 'admin_head', array( $this, 'admin_css' ) );
	}

	// Add a metabox tab to a single product.
	public function create_product_panel_tab() {
		echo '<li class="fees_product_tab product_fee_options"><a href="#fees_product_data"><span>' . __( 'Additional Fees',
				'cwc' ) . '</span></a></li>';
	}

	// Add the checkbox to enable the product as a trigger for increase.
	public function product_settings_fields() {
		echo '<div id="fees_product_data" class="fee_panel panel woocommerce_options_panel wc-metaboxes-wrapper">';

		echo '<div class="options_group">';

		// Check Box - Fee Multiply Option
		woocommerce_wp_checkbox( array(
			'id'          => '_cwc_product_fee_enabled',
			'label'       => __( 'Enable Additional Fees', 'cwc' ),
			'desc_tip'    => 'true',
			'description' => __( 'When enabled, this will increase the carts total when this product is in the cart.',
				'cwc' ),
		) );

		echo '</div>';
		echo '</div>';
	}

	public function save_product_settings_fields( $post_id ) {

		$product_fee_enabled = isset( $_POST['_cwc_product_fee_enabled'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_cwc_product_fee_enabled', $product_fee_enabled );
	}

	public function admin_css() {
		echo "
		<style type='text/css'>
			#woocommerce-product-data ul.product_data_tabs li.product_fee_options a:before {
				content: '\\e01e';
				font-family: 'WooCommerce';
			}
		</style>
		";
	}
}

new CWC_Settings_Product();