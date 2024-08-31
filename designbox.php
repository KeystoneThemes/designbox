<?php
/**
 * Plugin Name: DesignBox
 * Description: DesignBox is an Elementor addon that enables custom header, footer, single post, animations and more.
 * Plugin URI:  https://wpdesignbox.com/designbox-plugin
 * Version:     3.0
 * Author:      wpdesignbox
 * Author URI:  https://wpdesignbox.com/
 * Text Domain: designbox
 * Elementor tested up to: 3.20.3
 * Elementor Pro tested up to: 3.1
 */

require_once plugin_dir_path(__FILE__) . 'builder/designbox-builder/designbox-builder.php';
require_once plugin_dir_path(__FILE__) . 'builder/wdb-addons-pro/wdb-addons-pro.php';
require_once plugin_dir_path(__FILE__) . 'builder/extension/extension.php';

require_once plugin_dir_path(__FILE__) . 'plugin-update-checker/plugin-update-checker.php';
	use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

	$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/KeystoneThemes/designbox/',
	__FILE__,
	'designbox'
	);

	//Set the branch that contains the stable release.
	$myUpdateChecker->setBranch('main');
