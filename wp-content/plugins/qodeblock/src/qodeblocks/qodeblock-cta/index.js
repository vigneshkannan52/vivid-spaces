/**
 * BLOCK: Qodeblock Call-To-Action
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import CallToAction from './components/cta';

// Deprecated components
import deprecated from './deprecated/deprecated';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// Components
const { __ } = wp.i18n;

// Extend component
const { Component } = wp.element;

// Register block
const { registerBlockType } = wp.blocks;

// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m16.673483,3.519754c-0.078463,0 -0.156013,0.011589 -0.233068,0.023177l0.002359,-0.00445l-0.023782,0.006366c-0.107002,0.017367 -0.213129,0.044438 -0.316288,0.083067l-13.952206,3.671068c-1.112068,0.316383 -1.915459,1.167724 -1.915459,2.179235c0,1.012005 0.803391,1.86279 1.915459,2.178586l13.952206,3.671686c0.103235,0.038598 0.209286,0.065638 0.316288,0.083067l0.023782,0.00581l-0.002359,-0.003832c0.077055,0.011589 0.154567,0.023363 0.233068,0.023363c1.68144,0 3.044156,-2.663575 3.044156,-5.949007l0,-0.019283c0,-3.285401 -1.362717,-5.948853 -3.044156,-5.948853zm1.826494,5.968074c0,3.254437 -1.357009,4.960117 -1.826494,4.960117c-0.469942,0 -1.826494,-1.70565 -1.826494,-4.960117l0,-0.019283c0,-3.254468 1.356552,-4.959901 1.826494,-4.959901c0.469485,0 1.826494,1.705433 1.826494,4.959901l0,0.019283zm-10.958963,5.454562c0,0.272161 -0.265412,0.438295 -0.589311,0.368732l-1.237602,-0.262643c-0.324393,-0.069562 -0.589349,-0.347657 -0.589349,-0.620003l0,-0.949303l-1.217663,-0.320617l0,2.027255c0,0.272192 0.265907,0.548339 0.5903,0.614966l3.6711,0.747477c0.324355,0.066812 0.590262,-0.101361 0.590262,-0.373553l0,-1.739426l-1.217663,-0.320617l0,0.827763l-0.000076,0l0,-0.000031z" } )
);

// Register editor components
const {
	AlignmentToolbar,
	URLInput,
	BlockControls,
	BlockAlignmentToolbar,
	MediaUpload,
	RichText,
} = wp.editor;

// Register components
const {
	Button,
	withFallbackStyles,
	IconButton,
	Dashicon,
	Toolbar,
} = wp.components;

const blockAttributes = {
	buttonText: {
		type: 'string',
	},
	buttonUrl: {
		type: 'string',
		source: 'attribute',
		selector: 'a',
		attribute: 'href',
	},
	buttonAlignment: {
		type: 'string',
		default: 'center'
	},
	buttonBackgroundColor: {
		type: 'string'
	},
	buttonTextColor: {
		type: 'string'
	},
	buttonSize: {
		type: 'string',
		default: 'qb-button-size-small'
	},
	buttonShape: {
		type: 'string',
		default: 'qb-button-shape-rounded'
	},
	buttonTarget: {
		type: 'boolean',
		default: false
	},
	ctaTitle: {
		type: 'array',
		selector: '.qb-cta-title',
		source: 'children',
	},
	titleFontSize: {
		type: 'number'
	},
	ctaTextFontSize: {
		type: 'number',
	},
	ctaText: {
		type: 'array',
		selector: '.qb-cta-text',
		source: 'children',
	},
	ctaWidth: {
		type: 'string',
	},
	ctaBackgroundColor: {
		type: 'string',
	},
	ctaTextColor: {
		type: 'string'
	},
	imgURL: {
		type: 'string',
		source: 'attribute',
		attribute: 'src',
		selector: 'img',
	},
	imgID: {
		type: 'number',
	},
	imgAlt: {
		type: 'string',
		source: 'attribute',
		attribute: 'alt',
		selector: 'img',
	},
	dimRatio: {
		type: 'number',
		default: 50,
	},

	// Deprecated
	ctaTitleFontSize: {
		type: 'string'
	},
};

class QBCTABlock extends Component {

	render() {

		// Setup the attributes
		const {
			attributes: {
				buttonText,
				buttonUrl,
				buttonAlignment,
				buttonBackgroundColor,
				buttonTextColor,
				buttonSize,
				buttonShape,
				buttonTarget,
				ctaTitle,
				ctaText,
				ctaTitleFontSize,
				titleFontSize,
				ctaTextFontSize,
				ctaWidth,
				ctaBackgroundColor,
				ctaTextColor,
				imgURL,
				imgID,
				imgAlt,
				dimRatio,
			},
			attributes,
			isSelected,
			editable,
			className,
			setAttributes
		} = this.props;

		const onSelectImage = img => {
			setAttributes( {
				imgID: img.id,
				imgURL: img.url,
				imgAlt: img.alt,
			} );
		};

		const customColorText = ctaTextColor ? 'has-custom-color-text' : '';

		return [
			// Show the alignment toolbar on focus
			<BlockControls>
				<BlockAlignmentToolbar
					value={ ctaWidth }
					onChange={ ctaWidth => setAttributes( { ctaWidth } ) }
					controls={ [ 'center', 'wide', 'full' ] }
				/>
				<AlignmentToolbar
					value={ buttonAlignment }
					onChange={ ( value ) => {
						setAttributes( { buttonAlignment: value } );
					} }
				/>
			</BlockControls>,
			// Show the block controls on focus
			<Inspector
				{ ...{ setAttributes, ...this.props } }
			/>,
			// Show the button markup in the editor
			<CallToAction { ...this.props }>
				{ imgURL && !! imgURL.length && (
					<div className="qb-cta-image-wrap">
						<img
							className={ classnames(
								'qb-cta-image',
								dimRatioToClass( dimRatio ),
								{
									'has-background-dim': dimRatio !== 0,
								}
							) }
							src={ imgURL }
							alt={ imgAlt }
						/>
					</div>
				) }

				<div className="qb-cta-content">
					<RichText
						tagName="h2"
						placeholder={ __( 'Call-To-Action Title', 'qodeblock' ) }
						keepPlaceholderOnFocus
						value={ ctaTitle }
						className={ classnames(
							'qb-cta-title',
							'qb-font-size-' + titleFontSize
						) }
						style={ {
							color: ctaTextColor,
						} }
						onChange={ (value) => setAttributes( { ctaTitle: value } ) }
					/>
					<RichText
						tagName="div"
						multiline="p"
						placeholder={ __( 'Call To Action Text', 'qodeblock' ) }
						keepPlaceholderOnFocus
						value={ ctaText }
						className={ classnames(
							'qb-cta-text',
							'qb-font-size-' + ctaTextFontSize,
                            customColorText
						) }
						style={ {
							color: ctaTextColor,
						} }
						onChange={ ( value ) => setAttributes( { ctaText: value } ) }
					/>
				</div>
				<div className="qb-cta-button">
					<RichText
						tagName="span"
						placeholder={ __( 'Button text...', 'qodeblock' ) }
						value={ buttonText }
						formattingControls={ [] }
						className={ classnames(
							'qb-button',
							buttonShape,
							buttonSize,
						) }
						style={ {
							color: buttonTextColor,
							backgroundColor: buttonBackgroundColor,
						} }
						onChange={ (value) => setAttributes( { buttonText: value } ) }
					/>
					{ isSelected && (
						<form
							key="form-link"
							className={ `blocks-button__inline-link qb-button-${buttonAlignment}`}
							onSubmit={ event => event.preventDefault() }
							style={ {
								textAlign: buttonAlignment,
							} }
						>
							<Dashicon icon={ 'admin-links' } />
							<URLInput
								className="button-url"
								value={ buttonUrl }
								onChange={ ( value ) => setAttributes( { buttonUrl: value } ) }
							/>
							<IconButton
								icon="editor-break"
								label={ __( 'Apply', 'qodeblock' ) }
								type="submit"
							/>
						</form>
					) }
				</div>
			</CallToAction>
		];
	}
}

// Register the block
registerBlockType( 'qodeblock/qb-cta', {
	title: __( 'Call To Action', 'qodeblock' ),
	description: __( 'Add a call to action section with a title, text, and a button.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'call to action', 'qodeblock' ),
		__( 'cta', 'qodeblock' ),
		__( 'qodeblock', 'qodeblock' ),
	],

	attributes: blockAttributes,

	getEditWrapperProps( { ctaWidth } ) {
		if ( 'left' === ctaWidth || 'right' === ctaWidth || 'full' === ctaWidth ) {
			return { 'data-align': ctaWidth };
		}
	},

	// Render the block components
	edit: QBCTABlock,

	// Save the attributes and markup
	save: function( props ) {

		// Setup the attributes
		const {
			buttonText,
			buttonUrl,
			buttonAlignment,
			buttonBackgroundColor,
			buttonTextColor,
			buttonSize,
			buttonShape,
			buttonTarget,
			ctaTitle,
			ctaText,
			ctaTitleFontSize,
			titleFontSize,
			ctaTextFontSize,
			ctaWidth,
			ctaBackgroundColor,
			ctaTextColor,
			imgURL,
			imgID,
			imgAlt,
			dimRatio,
		} = props.attributes;


        const customColorText = ctaTextColor ? 'has-custom-color-text' : '';

		// Save the block markup for the front end
		return (
			<CallToAction { ...props }>
				{ imgURL && !! imgURL.length && (
					<div className="qb-cta-image-wrap">
						<img
							className={ classnames(
								'qb-cta-image',
								dimRatioToClass( dimRatio ),
								{
									'has-background-dim': dimRatio !== 0,
								}
							) }
							src={ imgURL }
							alt={ imgAlt }
						/>
					</div>
				) }

				<div className="qb-cta-content">
					{ ctaTitle && (
						<RichText.Content
							tagName="h2"
							className={ classnames(
								'qb-cta-title',
								'qb-font-size-' + titleFontSize,
							) }
							style={ {
								color: ctaTextColor,
							} }
							value={ ctaTitle }
						/>
					) }
					{ ctaText && (
						<RichText.Content
							tagName="div"
							className={ classnames(
								'qb-cta-text',
								'qb-font-size-' + ctaTitleFontSize,
                                customColorText
							) }
							style={ {
								color: ctaTextColor,
							} }
							value={ ctaText }
						/>
					) }
				</div>
				{ buttonText && (
					<div className="qb-cta-button">
						<a
							href={ buttonUrl }
							target={ buttonTarget ? '_blank' : '_self' }
							rel="noopener noreferrer"
							className={ classnames(
								'qb-button',
								buttonShape,
								buttonSize,
							) }
							style={ {
								color: buttonTextColor,
								backgroundColor: buttonBackgroundColor,
							} }
						>
							<RichText.Content
								value={ buttonText }
							/>
						</a>
					</div>
				) }
			</CallToAction>
		);
	},

	deprecated: deprecated,
} );

function dimRatioToClass( ratio ) {
	return ( ratio === 0 || ratio === 50 ) ?
		null :
		'has-background-dim-' + ( 10 * Math.round( ratio / 10 ) );
}