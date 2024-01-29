<?php
defined('ABSPATH') or die;

function whizzy_validate_not_empty( $fieldvalue, $processor ) {
	return ! empty( $fieldvalue );
}
