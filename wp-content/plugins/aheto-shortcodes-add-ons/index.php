<?php

/**
 * Plugin Name: Aheto Shortcodes Add-Ons
 * Plugin URI: https://foxthemes.me
 * Description: Additional shortcodes for Aheto
 * Version: 1.1.3
 * Text Domain: aheto-shortcodes-add-ons
 * Author:            UPQODE
 * Author URI:        https://upqode.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace AAddons;

const ACTIVE           = true;
const PLUGIN_ROOT      = __DIR__;
const PLUGIN_ROOT_FILE = __FILE__;

spl_autoload_register(function ($name) {
	$name    = explode('\\', $name);
	$name[0] = 'includes';
	$path    = __DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $name) . '.php';

	if (file_exists($path)) {
		require_once $path;
	}
});

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/includes/helper-functions.php';

$shortcodes_dir = __DIR__ . DIRECTORY_SEPARATOR . 'shortcodes';
$theme_dir = get_template_directory() . '/aheto/';

$files = glob($shortcodes_dir . '/*/controllers/*.php');

foreach ($files as $file) {

	$shortcode = explode('/shortcodes/', $file);
	$shortcode = explode('/controllers/', $shortcode[0]);

	$shortcode_name = $shortcode[0];
	$layout_name = $shortcode[1];
	$layout_prefix = explode('_layout', $layout_name);
	$layout_number = isset($layout_prefix[1]) && !empty($layout_prefix[1]) ? $layout_prefix[1] : '';

	$theme = wp_get_theme();
	$theme_name = $theme->name;

	if (file_exists($theme_dir . $shortcode_name . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $layout_name) || (!empty($layout_number) && ($layout_name == $theme_name . '_layout' . $layout_number) && file_exists($theme_dir . $shortcode_name . DIRECTORY_SEPARATOR . 'cs_layout' . $layout_number))) {
		continue;
	}

	require_once($file);
}

new AhetoAddon();





/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_aheto_shortcodes_add_ons()
{

	if (!class_exists('Appsero\Client')) {
		require_once __DIR__ . '/vendor/appsero/client/src/Client.php';
	}

	$client = new \Appsero\Client('b7593806-6818-4d6c-9627-e7045944be89', 'Aheto Shortcodes Add-ons', __FILE__);

	// Active insights
	$client->insights()->init();

	// Active automatic updater
	$client->updater();
}

appsero_init_tracker_aheto_shortcodes_add_ons();
