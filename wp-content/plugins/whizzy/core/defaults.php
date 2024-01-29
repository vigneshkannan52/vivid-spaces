<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

return array(
	'cleanup' => array(
		'switch' => array( 'switch_not_available' ),
	),
	'checks' => array(
		'counter' => array( 'is_numeric', 'not_empty' ),
	),
	'processor' => array(
		// callback signature: (array $input, WhizzyProcessor $processor)
		'preupdate' => array(
			// callbacks to run before update process
			// cleanup and validation has been performed on data
		),
		'postupdate' => array(
			// callbacks to run post update
		),
	),
	'errors' => array(
		'is_numeric' => esc_html__( 'Numberic value required.', 'whizzy' ),
		'not_empty' => esc_html__( 'Field is required.', 'whizzy' ),
	),
	'callbacks' => array(
		// cleanup callbacks
		'switch_not_available' => 'whizzy_cleanup_switch_not_available',

		// validation callbacks
		'is_numeric' => 'whizzy_validate_is_numeric',
		'not_empty' => 'whizzy_validate_not_empty',
	),
); # config
