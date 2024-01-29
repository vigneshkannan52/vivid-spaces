<?php defined('ABSPATH') or die;

$basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;

$debug = false;
if ( isset( $_GET['debug'] ) && $_GET['debug'] == 'true' ) {
	$debug = true;
}
$debug = true;
$options = get_option('whizzy_settings');

$display_settings = false;

if ( isset( $options['display_settings'] ) ){
	$display_settings = $options['display_settings'];
}

return array(
	'plugin-name' => 'whizzy',
	'settings-key' => 'whizzy_settings',
	'textdomain' => 'whizzy_txtd',
	'template-paths' => array(
		$basepath . 'core/views/form-partials/',
		$basepath . 'views/form-partials/',
	),
	'fields' => apply_filters( 'whizzy_config_fields', array(
		'hiddens' => include 'settings/hiddens.php',
		'general' => include 'settings/general.php',
		'post_types' => include 'settings/post_types.php',
	) ),
	'processor' => array(
		'preupdate' => array(),
		'postupdate' => array( 'save_settings' ),
	),
	'cleanup' => array(
		'switch' => array( 'switch_not_available' ),
	),
	'checks' => array(
		'counter' => array( 'is_numeric', 'not_empty' ),
	),
	'errors' => array(
		'not_empty' => esc_html__( 'Invalid Value.', 'whizzy' ),
	),
	'callbacks' => array(
		'save_settings' => 'save_whizzy_settings'
	),
	'debug' => $debug,
); # config
