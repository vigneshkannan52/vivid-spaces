<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
Plugin Name: Whizzy
Plugin URI: http://foxthemes.me/
Description: WordPress photo gallery plugin.
Version: 1.1.19
Author: UPQODE
Author URI: http://foxthemes.me/
Text Domain: whizzy
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require 'core/bootstrap.php';
require_once 'whizzy-advanced.php';

$config = include 'plugin-config.php';

// set textdomain
whizzy::settextdomain( $config['textdomain'] );

// Ensure Test Data
// ----------------
function whizzy_import_plugin_settings() {
	$config = include 'plugin-config.php';
	$defaults = include 'plugin-defaults.php';
	$current_data = get_option( $config['settings-key'] );

	if ( $current_data === false ) {
		add_option( $config['settings-key'], $defaults );
	} elseif ( count( array_diff_key( $defaults, $current_data ) ) != 0 ) {
		$plugindata = array_merge( $defaults, $current_data );

		update_option( $config['settings-key'], $plugindata );
	}
}
add_action( 'admin_init', 'whizzy_import_plugin_settings' );
# else: data is available; do nothing

// Load Callbacks
// --------------
$basepath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;
$callbackpath = $basepath . 'callbacks' . DIRECTORY_SEPARATOR;
whizzy::require_all( $callbackpath );

require_once($basepath . 'class-whizzy.php');

if ( file_exists( $basepath . '/lib/vendor/autoload.php' ) ) {
	require_once($basepath . '/lib/vendor/autoload.php');
}

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'WhizzyPlugin', 'activate' ) );

global $whizzy_plugin;
$whizzy_plugin = WhizzyPlugin::get_instance();
