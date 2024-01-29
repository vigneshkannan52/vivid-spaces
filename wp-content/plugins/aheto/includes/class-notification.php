<?php
/**
 * The Notification
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     FOX-THEMES <info@foxthemes.me>
 */

namespace Aheto;

defined( 'ABSPATH' ) || exit;

/**
 * Notification class.
 */
class Notification {

	/**
	 * Notification type.
	 *
	 * @var string
	 */
	const ERROR = 'error';

	/**
	 * Notification type.
	 *
	 * @var string
	 */
	const SUCCESS = 'success';

	/**
	 * Notification type.
	 *
	 * @var string
	 */
	const INFO = 'info';

	/**
	 * Notification type.
	 *
	 * @var string
	 */
	const WARNING = 'warning';

	/**
	 * Screen check.
	 *
	 * @var string
	 */
	const SCREEN_ANY = 'any';

	/**
	 * Contains optional arguments:
	 *
	 * -             type: The notification type, i.e. 'updated' or 'error'
	 * -               id: The ID of the notification
	 * -    dismissal_key: Option name to save dismissal information in, ID will be used if not supplied.
	 * -           screen: Only display on plugin page or on every page.
	 *
	 * @var array Options of this Notification.
	 */
	private $options = [];

	/**
	 * Internal flag for whether notifications has been displayed.
	 *
	 * @var boolean
	 */
	private $displayed = false;

	/**
	 * Notification class constructor.
	 *
	 * @param string $message Message string.
	 * @param array  $options Set of options.
	 */
	public function __construct( $message, $options = [] ) {
		$this->message = $message;
		$this->options = wp_parse_args( $options, [
			'id'      => '',
			'classes' => '',
			'type'    => self::SUCCESS,
			'screen'  => self::SCREEN_ANY,
		]);
	}

	/**
	 * Return data from options.
	 *
	 * @param  string $id Data to get.
	 * @return mixed
	 */
	public function args( $id ) {
		return $this->options[ $id ];
	}

	/**
	 * Is this Notification persistent.
	 *
	 * @return boolean True if persistent, False if fire and forget.
	 */
	public function is_persistent() {
		return ! empty( $this->args( 'id' ) );
	}

	/**
	 * Is this notification displayed.
	 *
	 * @return boolean
	 */
	public function is_displayed() {
		return $this->displayed;
	}

	/**
	 * Can display on current screen.
	 *
	 * @return boolean
	 */
	public function can_display() {
		$screen = get_current_screen();
		if ( self::SCREEN_ANY == $this->args( 'screen' ) || Helper::str_contains( $this->args( 'screen' ), $screen->id ) ) {
			$this->displayed = true;
		}

		return $this->displayed;
	}

	/**
	 * Dismiss persisten notification.
	 */
	public function dismiss() {
		$this->displayed     = true;
		$this->options['id'] = '';
	}

	/**
	 * Return the object properties as an array.
	 *
	 * @return array
	 */
	public function to_array() {
		return [
			'message' => $this->message,
			'options' => $this->options,
		];
	}

	/**
	 * Adds string (view) behaviour to the Notification.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->render();
	}

	/**
	 * Renders the notification as a string.
	 *
	 * @return string The rendered notification.
	 */
	public function render() {
		$attributes = [];

		// Default notification classes.
		$classes = [
			'notice',
			'notice-' . $this->args( 'type' ),
			'aheto-alert',
			$this->args( 'classes' ),
		];

		// Maintain WordPress visualisation of alerts when they are not persistent.
		if ( $this->is_persistent() ) {
			$classes[]                   = 'is-dismissible';
			$attributes['id']            = $this->args( 'id' );
			$attributes['data-security'] = wp_create_nonce( $this->args( 'id' ) );
			wp_enqueue_script( 'aheto-common' );
		}

		if ( ! empty( $classes ) ) {
			$attributes['class'] = implode( ' ', array_filter( $classes ) );
		}

		// Build the output DIV.
		return '<div ' . Helper::html_generate_attributes( $attributes ) . '>' . wpautop( $this->message ) . '</div>' . PHP_EOL;
	}
}
