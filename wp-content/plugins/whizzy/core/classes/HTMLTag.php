<?php
defined('ABSPATH') or die;

/**
 * @package    whizzy
 * @category   core
 */
class WhizzyHTMLTagImpl implements WhizzyHTMLTag {

	/** @var array html attributes */
	protected $attrs = null;

	/**
	 * @param array config
	 * @return mixed
	 */
	static function instance( $config = null ) {
		$i = new self;
		$i->configure( $config );

		return $i;
	}

	/**
	 * Apply configuration.
	 */
	protected function configure( $config = null ) {
		$this->attrs = whizzy::instance( 'WhizzyMeta', $config );
	}

	/**
	 * @param string key
	 * @param mixed default
	 * @return mixed
	 */
	function get( $key, $default = null ) {
		return $this->attrs->get( $key, $default );
	}

	/**
	 * @param string key
	 * @param mixed value
	 * @return static $this
	 */
	function set( $key, $value ) {
		$this->attrs->set( $key, $value );

		return $this;
	}

	/**
	 * @param array $extra
	 * @return string attributes
	 */
	function htmlattributes( array $extra = array() ) {
		$attr_segments = array();
		$attributes = whizzy::merge( $this->attrs->metadata_array(), $extra );

		foreach ( $attributes as $key => $value ) {
			if ( $value !== false && $value !== null ) {
				if ( ! empty( $value ) ) {
					if ( is_array( $value ) ) {
						$htmlvalue = implode( ' ', $value );
						$attr_segments[] = "$key=\"$htmlvalue\"";
					} else { // value is not an array
						$attr_segments[] = "$key=\"$value\"";
					}
				} else { // empty html tag; ie. no value html tag
					$attr_segments[] = $key;
				}
			}
		}

		return implode( ' ', $attr_segments );
	}

} # class
