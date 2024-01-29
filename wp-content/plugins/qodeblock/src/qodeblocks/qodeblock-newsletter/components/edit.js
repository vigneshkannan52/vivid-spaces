/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Internal dependencies
 */
import Inspector from './inspector';
import NewsletterContainer from './newsletter';
import CustomButton from './../../qodeblock-button/components/button';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const {
	compose,
	withInstanceId
} = wp.compose;
const {
	getColorClassName,
	RichText,
	withColors
} = wp.editor;
const {
	Fragment,
	Component
} = wp.element;
const {
	TextControl,
	withFallbackStyles
} = wp.components;

/* Apply fallback styles. */
const applyFallbackStyles = withFallbackStyles( ( node, ownProps ) => {
	const { backgroundColor, textColor, buttonBackgroundColor } = ownProps.attributes;
	const editableNode = node.querySelector( '[contenteditable="true"]' );
	const computedStyles = editableNode ? getComputedStyle( editableNode ) : null;
	return {
		fallbackBackgroundColor: backgroundColor || ! computedStyles ? undefined : computedStyles.backgroundColor,
		fallbackTextColor: textColor || ! computedStyles ? undefined : computedStyles.color,
		fallbackButtonBackgroundColor: buttonBackgroundColor || ! computedStyles ? undefined : computedStyles.buttonBackgroundColor,
	};
} );

class Edit extends Component {
	constructor() {
		super( ...arguments );
		this.props.setAttributes( { instanceId: this.props.instanceId } );
	}

	render() {
		const {
			attributes,
			isSelected,
			setAttributes,
			buttonBackgroundColor,
			buttonTextColor,
		} = this.props;

		const apiKeyDefined = qodeblock_newsletter_block_vars.mailingListProviders.mailchimp.api_key_defined;

		/* Setup button background color class */
		let buttonBackgroundColorClass;

		if (attributes.customButtonBackgroundColor) {
			buttonBackgroundColorClass = 'qb-has-custom-background-color';
		} else {
			buttonBackgroundColorClass = attributes.buttonBackgroundColor ? 'has-' + attributes.buttonBackgroundColor + '-background-color' : null;
		}

		/* Setup button text color class */
		let buttonTextColorClass;

		if (attributes.customButtonTextColor) {
			buttonTextColorClass = 'qb-has-custom-text-color';
		} else {
			buttonTextColorClass = attributes.buttonTextColor ? 'has-' + attributes.buttonTextColor + '-color' : null;
		}

		return [
			<Inspector { ...{ setAttributes, ...this.props } }/>,
			<NewsletterContainer { ...this.props }>
				{ ! apiKeyDefined && (
					<Fragment>
						<div className="qb-newsletter-notice">
							{ __( 'You must define your newsletter provider API keys to use this block.', 'qodeblock' ) }
							<p><a href={ qodeblock_newsletter_block_vars.plugin_settings_page_url }>{ __( 'Configure your settings', 'qodeblock' ) }</a></p>
						</div>
					</Fragment>
				) }
				{ apiKeyDefined && (
					<Fragment>
						<RichText
							tagName="span"
							className="qb-block-newsletter-label"
							keepPlaceholderOnFocus
							formattingControls={ [] }
							value={ attributes.emailInputLabel }
							onChange={ ( value ) => this.props.setAttributes( { emailInputLabel: value } ) }
						/>

						<TextControl
							name="qb-newsletter-email-address"
						/>

						<div
							className={ classnames(
								'qb-block-button',
							) }
						>
							<CustomButton { ...this.props }>
								<RichText
									tagName="span"
									placeholder={ __( 'Button text...', 'qodeblock' ) }
									keepPlaceholderOnFocus
									value={ attributes.buttonText }
									formattingControls={ [] }
									className={ classnames(
										'qb-button',
										attributes.buttonClass,
										attributes.buttonShape,
										attributes.buttonSize,
										buttonBackgroundColorClass,
										buttonTextColorClass,
										{
											'has-background': attributes.buttonBackgroundColor || attributes.customButtonBackgroundColor,
											'has-text-color': attributes.buttonTextColor || attributes.customButtonTextColor,
										}
									) }
									style={ {
										backgroundColor: buttonBackgroundColor.color,
										color: buttonTextColor.color,
									} }
									onChange={ (value) => this.props.setAttributes( { buttonText: value } ) }
								/>
							</CustomButton>
							{ isSelected && (
								<form
									key="form-link"
									className={ `blocks-button__inline-link qb-button-${attributes.buttonAlignment}`}
									onSubmit={ event => event.preventDefault() }
									style={ {
										textAlign: attributes.buttonAlignment,
									} }
								>
								</form>
							) }
						</div>
					</Fragment>
				) }
			</NewsletterContainer>
		];
	}
}

export default compose( [
	applyFallbackStyles,
	withColors(
		'backgroundColor',
		{ textColor: 'color' },
		{ buttonBackgroundColor: 'background-color' },
		{ buttonTextColor: 'color' },
	),
] )( withInstanceId( Edit ) );
