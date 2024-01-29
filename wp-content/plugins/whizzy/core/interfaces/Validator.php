<?php
defined('ABSPATH') or die;


/**
 * @package    whizzy
 * @category   core
 */
interface WhizzyValidator {

	/**
	 * @return array errors
	 */
	function validate( $input );

	/**
	 * @param string rule
	 * @return string error message
	 */
	function error_message( $rule );

} # interface
