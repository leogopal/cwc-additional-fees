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
 * Class CWC_Settings_Global
 *
 * Defines the WooCommerce Sitewide custom fields.
 */
class CWC_Settings_Global {

	public static function init() {
		add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
		add_action( 'woocommerce_settings_tabs_settings_cwc', __CLASS__ . '::settings_tab' );
		add_action( 'woocommerce_update_options_settings_cwc', __CLASS__ . '::update_settings' );
		add_filter( "plugin_action_links", __CLASS__ . '::plugin_add_settings_link' );
	}

	/**
	 * Add a new settings tab to the WooCommerce settings tabs array.
	 *
	 * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Custom Fee tab.
	 *
	 * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Custom Fee tab.
	 */
	public static function add_settings_tab( $settings_tabs ) {
		$settings_tabs['settings_cwc'] = __( 'Additional Cart Fee', 'cwc' );

		return $settings_tabs;
	}

	/**
	 * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
	 *
	 * @uses woocommerce_admin_fields()
	 * @uses self::get_settings()
	 */
	public static function settings_tab() {
		woocommerce_admin_fields( self::get_settings() );
	}

	/**
	 * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
	 *
	 * @uses woocommerce_update_options()
	 * @uses self::get_settings()
	 */
	public static function update_settings() {
		woocommerce_update_options( self::get_settings() );
	}

	/**
	 * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
	 *
	 * @return array Array of settings for @see woocommerce_admin_fields() function.
	 */
	public static function get_settings() {

		$settings = array(
			'section_title' => array(
				'name'     => __( 'Add Custom % Increase to Cart', 'cwc' ),
				'type'     => 'title',
				'desc'     => 'This will add a percentage increase to the whole cart based on the presence of certain products.',
				'id'       => 'cwc_add_additional_section_title',
				'desc_tip' => true,
			),

			'enable' => array(
				'name'     => __( 'Enable ', 'cwc' ),
				'type'     => 'checkbox',
				'desc'     => __( 'Enable or Disable Cart Total Increase', 'cwc' ),
				'id'       => '_cwc_fee_enabled',
				'default'  => 'yes',
				'desc_tip' => true,
			),

			'label' => array(
				'name'     => __( 'Custom Fee Label', 'cwc' ),
				'type'     => 'text',
				'desc'     => __( 'Enter text for Custom Fee label', 'cwc' ),
				'id'       => '_cwc_fee_label',
				'default'  => __( 'Additional Fees', 'cwc' ),
				'desc_tip' => true,
			),

			'charges' => array(
				'name'     => __( 'Custom Fee Percentage', 'cwc' ),
				'type'     => 'text',
				'desc'     => __( 'Enter amount for Custom Fee charges', 'cwc' ),
				'id'       => '_cwc_fee_charges',
				'class'    => 'wc_input_price',
				'default'  => '10',
				'desc_tip' => true,
			),

			'section_end' => array(
				'type' => 'sectionend',
				'id'   => 'cwc_section_end',
			),
		);

		return apply_filters( 'wc_settings_cwc_settings', $settings );
	}

	// Add custom links to the plugin listing.
	public static function plugin_add_settings_link( $links ) {
		$settings_link = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=settings_cwc' ) . '">' . __( 'Settings' ) . '</a>';
		$docs_link = '<a href="https://projects.leogopal.com/codeable/how-to-use-the-woocommerce-additional-cart-fees-plugin/">' . __( 'Docs' ) . '</a>';
			array_push( $links, $settings_link, $docs_link );

		return $links;
	}

}

CWC_Settings_Global::init();