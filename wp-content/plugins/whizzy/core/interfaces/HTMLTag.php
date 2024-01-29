<?php
defined('ABSPATH') or die;

/**
 * @package    whizzy
 * @category   core
 */
interface WhizzyHTMLTag {

	/**
	 * @param string key
	 * @param mixed default
	 * @return mixed
	 */
	function get( $key, $default = null );

	/**
	 * @param string key
	 * @param mixed value
	 * @return static $this
	 */
	function set( $key, $value );

	/**
	 * @return string
	 */
	function htmlattributes( array $extra = array() );

} # interface
