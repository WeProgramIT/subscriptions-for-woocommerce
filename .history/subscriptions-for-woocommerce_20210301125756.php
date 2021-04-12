<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           Subscriptions_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Subscriptions For Woocommerce
 * Plugin URI:        https://makewebbetter.com/product/subscriptions-for-woocommerce/
 * Description:       This plugin is use to provide the subscriptions option for any type of services
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       subscriptions-for-woocommerce
 * Domain Path:       /languages
 *
 * Requires at least: 4.6
 * Tested up to:      4.9.5
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins') ) ) ) {
	
	/**
	 * Define plugin constants.
	 *
	 * @since             1.0.0
	 */
	function define_subscriptions_for_woocommerce_constants() {

		subscriptions_for_woocommerce_constants( 'SUBSCRIPTIONS_FOR_WOOCOMMERCE_VERSION', '1.0.0' );
		subscriptions_for_woocommerce_constants( 'SUBSCRIPTIONS_FOR_WOOCOMMERCE_DIR_PATH', plugin_dir_path( __FILE__ ) );
		subscriptions_for_woocommerce_constants( 'SUBSCRIPTIONS_FOR_WOOCOMMERCE_DIR_URL', plugin_dir_url( __FILE__ ) );
		subscriptions_for_woocommerce_constants( 'SUBSCRIPTIONS_FOR_WOOCOMMERCE_SERVER_URL', 'https://makewebbetter.com' );
		subscriptions_for_woocommerce_constants( 'SUBSCRIPTIONS_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'Subscriptions For Woocommerce' );
	}


	/**
	 * Callable function for defining plugin constants.
	 *
	 * @param   String $key    Key for contant.
	 * @param   String $value   value for contant.
	 * @since             1.0.0
	 */
	function subscriptions_for_woocommerce_constants( $key, $value ) {

		if ( ! defined( $key ) ) {

			define( $key, $value );
		}
	}

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-subscriptions-for-woocommerce-activator.php
	 */
	function activate_subscriptions_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-subscriptions-for-woocommerce-activator.php';
		Subscriptions_For_Woocommerce_Activator::subscriptions_for_woocommerce_activate();
		$mwb_sfw_active_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_sfw_active_plugin ) && ! empty( $mwb_sfw_active_plugin ) ) {
			$mwb_sfw_active_plugin['subscriptions-for-woocommerce'] = array(
				'plugin_name' => __( 'Subscriptions For Woocommerce', 'subscriptions-for-woocommerce' ),
				'active' => '1',
			);
		} else {
			$mwb_sfw_active_plugin = array();
			$mwb_sfw_active_plugin['subscriptions-for-woocommerce'] = array(
				'plugin_name' => __( 'Subscriptions For Woocommerce', 'subscriptions-for-woocommerce' ),
				'active' => '1',
			);
		}
		update_option( 'mwb_all_plugins_active', $mwb_sfw_active_plugin );
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-subscriptions-for-woocommerce-deactivator.php
	 */
	function deactivate_subscriptions_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-subscriptions-for-woocommerce-deactivator.php';
		Subscriptions_For_Woocommerce_Deactivator::subscriptions_for_woocommerce_deactivate();
		$mwb_sfw_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_sfw_deactive_plugin ) && ! empty( $mwb_sfw_deactive_plugin ) ) {
			foreach ( $mwb_sfw_deactive_plugin as $mwb_sfw_deactive_key => $mwb_sfw_deactive ) {
				if ( 'subscriptions-for-woocommerce' === $mwb_sfw_deactive_key ) {
					$mwb_sfw_deactive_plugin[ $mwb_sfw_deactive_key ]['active'] = '0';
				}
			}
		}
		update_option( 'mwb_all_plugins_active', $mwb_sfw_deactive_plugin );
	}

	register_activation_hook( __FILE__, 'activate_subscriptions_for_woocommerce' );
	register_deactivation_hook( __FILE__, 'deactivate_subscriptions_for_woocommerce' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-subscriptions-for-woocommerce.php';


	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_subscriptions_for_woocommerce() {
		define_subscriptions_for_woocommerce_constants();

		$sfw_plugin_standard = new Subscriptions_For_Woocommerce();
		$sfw_plugin_standard->sfw_run();
		$GLOBALS['sfw_mwb_sfw_obj'] = $sfw_plugin_standard;

	}
	run_subscriptions_for_woocommerce();


	// Add settings link on plugin page.
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'subscriptions_for_woocommerce_settings_link' );

	/**
	 * Settings link.
	 *
	 * @since    1.0.0
	 * @param   Array $links    Settings link array.
	 */
	function subscriptions_for_woocommerce_settings_link( $links ) {

		$my_link = array(
			'<a href="' . admin_url( 'admin.php?page=subscriptions_for_woocommerce_menu' ) . '">' . __( 'Settings', 'subscriptions-for-woocommerce' ) . '</a>',
		);
		return array_merge( $my_link, $links );
	}

}
else{
	// WooCommerce is not active so deactivate this plugin.
	add_action( 'admin_init', 'mwb_sfw_activation_failure' );

	// Deactivate this plugin.
	function mwb_sfw_activation_failure() {

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	// Add admin error notice.
	add_action( 'admin_notices', 'mwb_sfw_activation_failure_admin_notice' );

	// This function is used to display admin error notice when WooCommerce is not active.
	function mwb_sfw_activation_failure_admin_notice() {

		// to hide Plugin activated notice.
		//unset( $_GET['activate'] );

	    ?>

	    <div class="notice notice-error is-dismissible">
	        <p><?php esc_html_e( 'WooCommerce is not activated, Please activate WooCommerce first to activate Subscriptions for Woocommerce.','subscriptions-for-woocommerce' ); ?></p>
	    </div>

	    <?php
	}
}