<?php
/**
 * Plugin Name: Qodeblock
 * Plugin URI:  http://foxthemes.me/
 * Description: A beautiful collection of handy Gutenberg blocks to help you get started with the new WordPress editor.
 * Author: Foxthemes
 * Author URI:http://foxthemes.me/
 * Version: 1.0.2
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Qodeblock
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialize the blocks
 */
function qodeblock_loader() {

	$qodeblock_includes_dir = plugin_dir_path( __FILE__ ) . 'includes/';
	$qodeblock_src_dir      = plugin_dir_path( __FILE__ ) . 'src/';
	$qodeblock_dist_dir     = plugin_dir_path( __FILE__ ) . 'dist/';

	/**
	 * Load the blocks functionality
	 */
	require_once plugin_dir_path( __FILE__ ) . 'dist/init.php';

	/**
	 * Load Getting Started page
	 */
	require_once plugin_dir_path( __FILE__ ) . 'dist/getting-started/getting-started.php';

	/**
	 * Load Social Block PHP
	 */
	require_once plugin_dir_path( __FILE__ ) . 'src/qodeblocks/qodeblock-sharing/index.php';

	/**
	 * Load Post Grid PHP
	 */
	require_once plugin_dir_path( __FILE__ ) . 'src/qodeblocks/qodeblock-post-grid/index.php';

	/**
	 * Load the newsletter block and related dependencies.
	 */
	if ( PHP_VERSION_ID >= 50600 ) {
		if ( ! class_exists( '\DrewM\MailChimp\MailChimp' ) ) {
			require_once $qodeblock_includes_dir . 'libraries/drewm/mailchimp-api/MailChimp.php';
		}

		require_once $qodeblock_includes_dir . 'exceptions/class-api-error-exception.php';
		require_once $qodeblock_includes_dir . 'exceptions/class-mailchimp-api-error-exception.php';
		require_once $qodeblock_includes_dir . 'interfaces/newsletter-provider-interface.php';
		require_once $qodeblock_includes_dir . 'classes/class-mailchimp.php';
		require_once $qodeblock_includes_dir . 'newsletter/newsletter-functions.php';
		require_once $qodeblock_src_dir . 'qodeblocks/qodeblock-newsletter/index.php';
	}

	/**
	 * Compatibility functionality.
	 */
	require_once $qodeblock_includes_dir . 'compat.php';
}
add_action( 'plugins_loaded', 'qodeblock_loader' );


/**
 * Load the plugin textdomain
 */
function qodeblock_init() {
	load_plugin_textdomain( 'qodeblock', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'qodeblock_init' );


/**
 * Adds a redirect option during plugin activation on non-multisite installs.
 *
 * @param bool $network_wide Whether or not the plugin is being network activated.
 */
function qodeblock_activate( $network_wide = false ) {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Only used to do a redirect. False positive.
	if ( ! $network_wide && ! isset( $_GET['activate-multi'] ) ) {
		add_option( 'qodeblock_do_activation_redirect', true );
	}
}
register_activation_hook( __FILE__, 'qodeblock_activate' );


/**
 * Redirect to the Qodeblock Getting Started page on single plugin activation.
 */
function qodeblock_redirect() {
	if ( get_option( 'qodeblock_do_activation_redirect', false ) ) {
		delete_option( 'qodeblock_do_activation_redirect' );
		wp_safe_redirect( esc_url( admin_url( 'admin.php?page=qodeblock' ) ) );
		exit;
	}
}
add_action( 'admin_init', 'qodeblock_redirect' );


/**
 * Add image sizes
 */
function qodeblock_image_sizes() {
	// Post Grid Block.
	add_image_size( 'qb-block-post-grid-landscape', 600, 400, true );
	add_image_size( 'qb-block-post-grid-square', 600, 600, true );
}
add_action( 'after_setup_theme', 'qodeblock_image_sizes' );

/**
 * Returns the full path and filename of the main Qodeblock plugin file.
 *
 * @return string
 */
function qodeblock_main_plugin_file() {
	return __FILE__;
}
