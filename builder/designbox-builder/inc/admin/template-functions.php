<?php
/**
 * Template
 *
 * Functions for the admin templating system.
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wdb_admin_settings_home_tab' ) ) {

	/**
	 * Output the home tab content.
	 */
	function wdb_admin_settings_home_tab( $key, $tab ) {
		include WDB_ADDONS_PATH . 'inc/admin/views/settings-home.php';
	}
}

if ( ! function_exists( 'wdb_admin_settings_widget_tab' ) ) {

	/**
	 * Output the widget tab content.
	 */
	function wdb_admin_settings_widget_tab( $key, $tab ) {
		include WDB_ADDONS_PATH . 'inc/admin/views/settings-widgets.php';
	}
}

if ( ! function_exists( 'wdb_admin_settings_extension_tab' ) ) {

	/**
	 * Output the extension tab content.
	 */
	function wdb_admin_settings_extension_tab( $key, $tab ) {

		include WDB_ADDONS_PATH . 'inc/admin/views/settings-extensions.php';
	}
}
