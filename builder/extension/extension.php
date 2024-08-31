<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! defined( 'WDB_ADDONS_EX_VERSION' ) ) {
	/**
	 * Plugin Version.
	 */
	define( 'WDB_ADDONS_EX_VERSION', '1.0.0' );
}
if ( ! defined( 'WDB_ADDONS_EX_FILE' ) ) {
	/**
	 * Plugin File Ref.
	 */
	define( 'WDB_ADDONS_EX_FILE', __FILE__ );
}
if ( ! defined( 'WDB_ADDONS_EX_BASE' ) ) {
	/**
	 * Plugin Base Name.
	 */
	define( 'WDB_ADDONS_EX_BASE', plugin_basename( WDB_ADDONS_EX_FILE ) );
}
if ( ! defined( 'WDB_ADDONS_EX_PATH' ) ) {
	/**
	 * Plugin Dir Ref.
	 */
	define( 'WDB_ADDONS_EX_PATH', plugin_dir_path( WDB_ADDONS_EX_FILE ) );
}
if ( ! defined( 'WDB_ADDONS_EX_URL' ) ) {
	/**
	 * Plugin URL.
	 */
	define( 'WDB_ADDONS_EX_URL', plugin_dir_url( WDB_ADDONS_EX_FILE ) );
}
if ( ! defined( 'WDB_ADDONS_EX_WIDGETS_PATH' ) ) {
	/**
	 * Widgets Dir Ref.
	 */
	define( 'WDB_ADDONS_EX_WIDGETS_PATH', WDB_ADDONS_EX_PATH . 'widgets/' );
}

/**
 * Main WDB_ADDONS_EX_Plugin Class
 *
 * The init class that runs the Hello World plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 *
 * @since 1.2.0
 */
final class WDB_ADDONS_EX_Plugin {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.2.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function init() {

		load_plugin_textdomain( 'extension' );

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );

			return;
		}

		// Check if DesignBox Builder installed and activated
		if ( ! class_exists( 'WDB_ADDONS_Plugin' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_wdb_addons_plugin' ) );

			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'class-plugin.php' );

		//wdb plugin loaded
		do_action( 'wdb_plugins_pro_loaded' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'extension' ),
			'<strong>' . esc_html__( 'Extension', 'extension' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'extension' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have DesignBox Builder installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_wdb_addons_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'extension' ),
			'<strong>' . esc_html__( 'Extension', 'extension' ) . '</strong>',
			'<strong>' . esc_html__( 'DesignBox Builder', 'extension' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

}

// Instantiate WDB_ADDONS_Plugin_Pro.
new WDB_ADDONS_EX_Plugin();
