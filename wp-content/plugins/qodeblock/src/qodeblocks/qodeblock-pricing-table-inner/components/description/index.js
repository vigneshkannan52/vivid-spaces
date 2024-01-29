/**
 * BLOCK: Qodeblock Pricing Table - Features Component
 */

// Import block dependencies and components
import classnames from 'classnames';
import Edit from './edit';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { Component } = wp.element;

const {
	RichText,
	getFontSizeClass,
	FontSizePicker,
	withFontSizes,
	getColorClassName,
} = wp.editor;

// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m19.89678,7.538512l-0.775859,-6.593725l-6.642436,-0.770169l-12.482544,12.391004l7.418257,7.363856l12.482544,-12.391004l0.000039,0.000039zm-4.785287,-2.613738c-0.729139,-0.723908 -0.729139,-1.897354 0.000039,-2.621146c0.729217,-0.72383 1.911293,-0.72383 2.64051,0.000039c0.729178,0.72383 0.729139,1.897277 -0.000039,2.621107c-0.729178,0.72383 -1.911254,0.723792 -2.64051,0z" } )
);

// Register the block
registerBlockType( 'qodeblock/qb-pricing-table-features', {
	title: __( 'Product Features', 'qodeblock' ),
	description: __( 'Adds a product feature component with schema markup.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	parent: [ 'qodeblock/qb-pricing-table' ],
	keywords: [
		__( 'pricing table', 'qodeblock' ),
		__( 'features', 'qodeblock' ),
		__( 'shop', 'qodeblock' ),
	],

	attributes: {
		features: {
			type: 'string',
			source: 'html',
			selector: 'ol,ul',
			multiline: 'li',
		},
		fontSize: {
			type: 'string',
		},
		customFontSize: {
			type: 'number',
		},
		textColor: {
			type: 'string',
		},
		customTextColor: {
			type: 'string',
		},
		backgroundColor: {
			type: 'string',
		},
		customBackgroundColor: {
			type: 'string',
		},
		borderStyle: {
			type: 'string',
			default: 'qb-list-border-none',
		},
		borderColor: {
			type: 'string',
		},
		borderWidth: {
			type: 'number',
			default: 1
		},
		paddingTop: {
			type: 'number',
			default: 10,
		},
		paddingRight: {
			type: 'number',
			default: 20,
		},
		paddingBottom: {
			type: 'number',
			default: 10,
		},
		paddingLeft: {
			type: 'number',
			default: 20,
		},
	},

	// Render the block components
	edit: Edit,

	// Save the attributes and markup
	save: function( props ) {

		// Setup the attributes
		const {
			features,
			fontSize,
			customFontSize,
			backgroundColor,
			textColor,
			customBackgroundColor,
			customTextColor,
			borderStyle,
			borderColor,
			borderWidth,
			paddingTop,
			paddingRight,
			paddingBottom,
			paddingLeft,
		} = props.attributes;

		// Retreive the fontSizeClass
		const fontSizeClass = getFontSizeClass( fontSize );

		// Retreive the getColorClassName
		const textClass = getColorClassName( 'color', textColor );
		const backgroundClass = getColorClassName( 'background-color', backgroundColor );

		// Setup class names
		const className = classnames( {
			'has-background': backgroundColor || customBackgroundColor,
			'qb-pricing-table-features': true,
			[ fontSizeClass ]: fontSizeClass,
			[ textClass ]: textClass,
			[ backgroundClass ]: backgroundClass,
			[ borderStyle ]: borderStyle,
			[ 'qb-list-border-width-' + borderWidth ]: borderWidth,
		} );

		// Setup styles
		const styles = {
			fontSize: fontSizeClass ? undefined : customFontSize,
			backgroundColor: backgroundClass ? undefined : customBackgroundColor,
			color: textClass ? undefined : customTextColor,
			borderColor: borderColor ? borderColor : undefined,
			paddingTop: paddingTop ? paddingTop + 'px' : undefined,
			paddingRight: paddingRight ? paddingRight + 'px' : undefined,
			paddingBottom: paddingBottom ? paddingBottom + 'px' : undefined,
			paddingLeft: paddingLeft ? paddingLeft + 'px' : undefined,
		};

		// Save the block markup for the front end
		return (
			<RichText.Content
				tagName="ul"
				itemProp="description"
				value={ features }
				className={ className ? className : undefined }
				style={ styles }
			/>
		);
	},
} );
