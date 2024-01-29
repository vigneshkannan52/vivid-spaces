<?php
/**
 * Newsletter block registration and rendering functions.
 *
 * @package Qodeblock
 */

add_action( 'init', 'qodeblock_register_newsletter_block' );
/**
 * Registers the newsletter block.
 */
function qodeblock_register_newsletter_block() {

	register_block_type(
		'qodeblock/newsletter',
		[
			'attributes'      => qodeblock_newsletter_block_attributes(),
			'render_callback' => 'qodeblock_render_newsletter_block',
		]
	);
}

/**
 * Renders the newsletter block.
 *
 * @param array $attributes The block attributes.
 * @return string The block HTML.
 */
function qodeblock_render_newsletter_block( $attributes ) {

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- False positive. Only used for displaying a message on AMP redirects.
	if ( ! empty( $_GET['qb-newsletter-submission-message'] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- False positive. Only used for displaying a message on AMP redirects.
		echo '<p class="qb-newsletter-submission-message">' . esc_html( urldecode( sanitize_text_field( wp_unslash( $_GET['qb-newsletter-submission-message'] ) ) ) );
		return;
	}

	$amp_endpoint = function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();

	if ( ! $amp_endpoint ) {
		wp_enqueue_script( 'qodeblock-newsletter-functions' );
	}

	$defaults = [];
	foreach ( qodeblock_newsletter_block_attributes() as $key => $values ) {
		$defaults[ $key ] = isset( $values['default'] ) ? $values['default'] : null;
	}

	$attributes = wp_parse_args( $attributes, $defaults );

	$button_bg_color_class   = ! empty( $attributes['buttonBackgroundColor'] ) ? 'has-' . $attributes['buttonBackgroundColor'] . '-background-color' : null;
	$button_text_color_class = ! empty( $attributes['buttonTextColor'] ) ? 'has-' . $attributes['buttonTextColor'] . '-color' : null;
	$button_class            = $attributes['buttonClass'] . ' ' . $attributes['buttonSize'] . ' ' . $attributes['buttonShape'] . ' ' . $button_bg_color_class . ' ' . $button_text_color_class;

	$wrapper_styles = '';

	/* Padding styles. */
	if ( ! empty( $attributes['containerPadding'] ) && $attributes['containerPadding'] > 0 ) {
		$wrapper_styles .= 'padding:' . $attributes['containerPadding'] . 'px;';
	}

	/* Margin styles. */
	if ( ! empty( $attributes['containerMarginTop'] ) && $attributes['containerMarginTop'] > 0 ) {
		$wrapper_styles .= 'margin-top:' . $attributes['containerMarginTop'] . 'px;';
	}

	if ( ! empty( $attributes['containerMarginBottom'] ) && $attributes['containerMarginBottom'] > 0 ) {
		$wrapper_styles .= 'margin-bottom:' . $attributes['containerMarginBottom'] . 'px;';
	}

	/* Background styles. */
	if ( ! empty( $attributes['customBackgroundColor'] ) ) {
		$wrapper_styles .= 'background-color:' . $attributes['customBackgroundColor'] . ';';
	}

	/* Text styles. */
	if ( ! empty( $attributes['customTextColor'] ) ) {
		$wrapper_styles .= 'color:' . $attributes['customTextColor'] . ';';
	}

	/* Newsletter wrapper styles. */
	if ( ! empty( $wrapper_styles ) ) {
		$wrapper_style = $wrapper_styles;
	} else {
		$wrapper_style = null;
	}

	/* Wrapper color classes. */
	$wrapper_class = '';

	if ( isset( $attributes['className'] ) ) {
		$wrapper_class .= $attributes['className'];
	}

	if ( ! empty( $attributes['backgroundColor'] ) ) {
		$wrapper_class .= ' has-background ' . 'has-' . $attributes['backgroundColor'] . '-background-color';
	}

	if ( ! empty( $attributes['customBackgroundColor'] ) ) {
		$wrapper_class .= ' qb-has-custom-background-color';
	}

	if ( ! empty( $attributes['textColor'] ) ) {
		$wrapper_class .= ' has-text-color has-' . $attributes['textColor'] . '-color';
	}

	if ( ! empty( $attributes['customTextColor'] ) ) {
		$wrapper_class .= ' qb-has-custom-text-color';
	}

	/* Button styles. */
	$button_styles_custom = '';

	if ( ! empty( $attributes['customButtonBackgroundColor'] ) ) {
		$button_styles_custom .= 'background-color:' . $attributes['customButtonBackgroundColor'] . ';';
	}

	if ( ! empty( $attributes['customButtonTextColor'] ) ) {
		$button_styles_custom .= 'color:' . $attributes['customButtonTextColor'] . ';';
	}

	/* Button style output. */
	if ( ! empty( $button_styles_custom ) ) {
		$button_styles = $button_styles_custom;
	} else {
		$button_styles = null;
	}

	$form = '
		<div class="qb-block-newsletter qb-form-styles ' . esc_attr( $wrapper_class ) . '" style="' . safecss_filter_attr( $wrapper_style ) . '" >
			<form method="post" action-xhr="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '">
				<label for="qb-newsletter-email-address-' . esc_attr( $attributes['instanceId'] ) . '" class="qb-newsletter-email-address-label">' . esc_html( $attributes['emailInputLabel'] ) . '</label>
				<input type="email" id="qb-newsletter-email-address-' . esc_attr( $attributes['instanceId'] ) . '" name="qb-newsletter-email-address" class="qb-newsletter-email-address-input" />
				<input class="' . esc_attr( $button_class ) . ' qb-newsletter-submit" type="submit" style="' . safecss_filter_attr( $button_styles ) . '"  value="' . esc_attr( $attributes['buttonText'] ) . '"/>
				<input type="hidden" name="qb-newsletter-mailing-list-provider" value="' . esc_attr( $attributes['mailingListProvider'] ) . '" />
				<input type="hidden" name="qb-newsletter-mailing-list" value="' . esc_attr( $attributes['mailingList'] ) . '" />
				<input type="hidden" name="qb-newsletter-success-message" value="' . esc_attr( $attributes['successMessage'] ) . '" />
				<input type="hidden" name="qb-newsletter-amp-endpoint-request" value="' . $amp_endpoint . '" />
				<input type="hidden" name="qb-newsletter-form-nonce" value="' . wp_create_nonce( 'qb-newsletter-form-nonce' ) . '" />
			</form>
			<div class="qb-block-newsletter-errors" style="display: none;"></div>
		</div>';

	return $form;
}

/**
 * Returns the newsletter block attributes.
 *
 * @return array
 */
function qodeblock_newsletter_block_attributes() {
	return [
		'buttonAlignment'             => [
			'type'    => 'string',
			'default' => 'left',
		],
		'buttonBackgroundColor'       => [
			'type' => 'string',
		],
		'customButtonBackgroundColor' => [
			'type' => 'string',
		],
		'buttonClass'                 => [
			'type'    => 'string',
			'default' => 'qb-button',
		],
		'buttonShape'                 => [
			'type'    => 'string',
			'default' => 'qb-button-shape-rounded',
		],
		'buttonSize'                  => [
			'type'    => 'string',
			'default' => 'qb-button-size-small',
		],
		'buttonText'                  => [
			'type'    => 'string',
			'default' => esc_html__( 'Subscribe', 'qodeblock' ),
		],
		'buttonTextColor'             => [
			'type' => 'string',
		],
		'customButtonTextColor'       => [
			'type' => 'string',
		],
		'buttonTextProcessing'        => [
			'type'    => 'string',
			'default' => esc_html__( 'Please wait...', 'qodeblock' ),
		],
		'emailInputLabel'             => [
			'type'    => 'string',
			'default' => esc_html__( 'Your Email Address', 'qodeblock' ),
		],
		'mailingList'                 => [
			'type' => 'string',
		],
		'mailingListProvider'         => [
			'type'    => 'string',
			'default' => 'mailchimp',
		],
		'successMessage'              => [
			'type'    => 'string',
			'default' => esc_html__( 'Thanks for subscribing.', 'qodeblock' ),
		],
		'containerPadding'            => [
			'type'    => 'number',
			'default' => 0,
		],
		'containerMarginTop'          => [
			'type'    => 'number',
			'default' => 0,
		],
		'containerMarginBottom'       => [
			'type'    => 'number',
			'default' => 0,
		],
		'backgroundColor'             => [
			'type' => 'string',
		],
		'customBackgroundColor'       => [
			'type' => 'string',
		],
		'textColor'                   => [
			'type' => 'string',
		],
		'customTextColor'             => [
			'type' => 'string',
		],
		'instanceId'                  => [
			'type'    => 'number',
			'default' => 1,
		],
	];
}
