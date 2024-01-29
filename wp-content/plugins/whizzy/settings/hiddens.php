<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

return array(
	'type' => 'group',
	'options' => array(
		'settings_saved_once' => array(
			'default' => '0',
			'value' => '1',
			'type' => 'hidden',
		),
	)
); # config
