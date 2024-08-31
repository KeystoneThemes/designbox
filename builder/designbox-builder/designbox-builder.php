<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! defined( 'WDB_ADDONS_VERSION' ) ) {
	/**
	 * Plugin Version.
	 */
	define( 'WDB_ADDONS_VERSION', '1.0.0' );
}
if ( ! defined( 'WDB_ADDONS_FILE' ) ) {
	/**
	 * Plugin File Ref.
	 */
	define( 'WDB_ADDONS_FILE', __FILE__ );
}
if ( ! defined( 'WDB_ADDONS_BASE' ) ) {
	/**
	 * Plugin Base Name.
	 */
	define( 'WDB_ADDONS_BASE', plugin_basename( WDB_ADDONS_FILE ) );
}
if ( ! defined( 'WDB_ADDONS_PATH' ) ) {
	/**
	 * Plugin Dir Ref.
	 */
	define( 'WDB_ADDONS_PATH', plugin_dir_path( WDB_ADDONS_FILE ) );
}
if ( ! defined( 'WDB_ADDONS_URL' ) ) {
	/**
	 * Plugin URL.
	 */
	define( 'WDB_ADDONS_URL', plugin_dir_url( WDB_ADDONS_FILE ) );
}
if ( ! defined( 'WDB_ADDONS_WIDGETS_PATH' ) ) {
	/**
	 * Widgets Dir Ref.
	 */
	define( 'WDB_ADDONS_WIDGETS_PATH', WDB_ADDONS_PATH . 'widgets/' );
}

/**
 * Main WDB_ADDONS_Plugin Class
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
final class WDB_ADDONS_Plugin {

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

		register_activation_hook( WDB_ADDONS_BASE, [ __CLASS__, 'plugin_activation_hook' ] );
		register_uninstall_hook( WDB_ADDONS_BASE, [ __CLASS__, 'plugin_deactivation_hook' ] );

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Plugin activation hook
	 *
	 * @since 1.0.0
	 */
	public static function plugin_activation_hook() {
		//set setup wizard
		if ( !get_option( 'wdb_addons_version' ) && !get_option( 'wdb_addons_setup_wizard' ) ) {
			update_option( 'wdb_addons_setup_wizard', 'redirect' );
		}

		flush_rewrite_rules();
	}

	/**
	 * Plugin deactivation hook
	 *
	 * @since 1.0.0
	 */
	public static function plugin_deactivation_hook() {

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

		load_plugin_textdomain( 'designbox-builder', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );

			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );

			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );

			return;
		}

		add_action( 'wp_loaded', function () {
			// set current version to db
			if ( get_option( 'wdb_addons_version' ) != WDB_ADDONS_VERSION ) {
				// update plugin version
				update_option( 'wdb_addons_version', WDB_ADDONS_VERSION );
			}

			//redirect addons setup page
			if ( 'redirect' === get_option( 'wdb_addons_setup_wizard' ) ) {
				update_option( 'wdb_addons_setup_wizard', 'init' );
				wp_redirect( admin_url( 'admin.php?page=wdb_addons_setup_page' ) );
			}
		} );

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'class-plugin.php' );

		//wdb plugin loaded
		do_action( 'wdb_plugins_loaded' );
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
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'designbox-builder' ),
			'<strong>' . esc_html__( 'DesignBox Builder', 'designbox-builder' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'designbox-builder' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'designbox-builder' ),
			'<strong>' . esc_html__( 'DesignBox Builder', 'designbox-builder' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'designbox-builder' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'designbox-builder' ),
			'<strong>' . esc_html__( 'DesignBox Builder', 'designbox-builder' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'designbox-builder' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}
}

// Instantiate WDB_ADDONS_Plugin.
new WDB_ADDONS_Plugin();
