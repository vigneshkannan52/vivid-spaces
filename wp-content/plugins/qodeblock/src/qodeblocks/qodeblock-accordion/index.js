/**
 * BLOCK: Qodeblock Accordion Block
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import Accordion from './components/accordion';
import icons from './components/icons';
import omit from 'lodash/omit';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// Components
const { __ } = wp.i18n;

// Extend component
const { Component } = wp.element;

// Register block
const {
	registerBlockType,
	createBlock,
} = wp.blocks;

// Register editor components
const {
	RichText,
	AlignmentToolbar,
	BlockControls,
	BlockAlignmentToolbar,
	InnerBlocks,
} = wp.editor;

// Register components
const {
	Button,
	withFallbackStyles,
	IconButton,
	Dashicon,
} = wp.components;

// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m19.342529,5.407801l-12.456586,0c-0.344016,0 -0.622829,-0.20298 -0.622829,-0.493868s0.278813,-0.493868 0.622829,-0.493868l12.456586,0c0.344016,0 0.622829,0.20298 0.622829,0.493868s-0.278813,0.493868 -0.622829,0.493868zm0.622829,4.774061c0,-0.290888 -0.278813,-0.493868 -0.622829,-0.493868l-12.456586,0c-0.344016,0 -0.622829,0.20298 -0.622829,0.493868s0.278813,0.493868 0.622829,0.493868l12.456586,0c0.344016,0 0.622829,-0.20298 0.622829,-0.493868zm0,5.267929c0,-0.290888 -0.278813,-0.493868 -0.622829,-0.493868l-12.456586,0c-0.344016,0 -0.622829,0.20298 -0.622829,0.493868s0.278813,0.493868 0.622829,0.493868l12.456586,0c0.344016,0 0.622829,-0.20298 0.622829,-0.493868zm-17.575757,-8.889713l2.491317,-2.633965c0.214973,-0.227262 0.171375,-0.55873 -0.09722,-0.740473c-0.268692,-0.182073 -0.660588,-0.144786 -0.875464,0.082229l-2.114116,2.235248l-0.762771,-0.483826c-0.275213,-0.174253 -0.665357,-0.127089 -0.872058,0.105359c-0.206312,0.232777 -0.15055,0.56301 0.124566,0.737592l1.245659,0.790189c0.111915,0.071035 0.243098,0.105359 0.373308,0.105359c0.183053,-0.000082 0.364063,-0.067989 0.48678,-0.197712zm0,5.267765l2.491317,-2.633882c0.214973,-0.227262 0.171375,-0.55873 -0.09722,-0.740473c-0.268692,-0.182073 -0.660588,-0.144786 -0.875464,0.082229l-2.114214,2.235413l-0.762771,-0.483991c-0.275213,-0.174089 -0.665357,-0.126924 -0.872058,0.105359c-0.206312,0.232777 -0.15055,0.563092 0.124566,0.737428l1.245659,0.790272c0.111915,0.070952 0.243098,0.105441 0.373308,0.105441c0.183151,0 0.364161,-0.067907 0.486877,-0.197794zm0,5.267929l2.491317,-2.633965c0.214973,-0.227179 0.171375,-0.55873 -0.09722,-0.740309c-0.268692,-0.181826 -0.660588,-0.145115 -0.875464,0.082311l-2.114214,2.235248l-0.762771,-0.483826c-0.275213,-0.174665 -0.665357,-0.127336 -0.872058,0.105194c-0.206312,0.232777 -0.15055,0.563092 0.124566,0.737428l1.245659,0.790272c0.111915,0.070952 0.243098,0.105441 0.373308,0.105441c0.183151,0 0.364161,-0.067907 0.486877,-0.197794z" } )
);

const blockAttributes = {
	accordionTitle: {
		type: 'array',
		selector: '.qb-accordion-title',
		source: 'children',
	},
	accordionText: {
		type: 'array',
		selector: '.qb-accordion-text',
		source: 'children',
	},
	accordionAlignment: {
		type: 'string',
	},
	accordionFontSize: {
		type: 'number',
		default: 16
	},
	accordionOpen: {
		type: 'boolean',
		default: false
	},
};

class QBAccordionBlock extends Component {

	render() {

		// Setup the attributes
		const { attributes: { accordionTitle, accordionText, accordionAlignment, accordionFontSize, accordionOpen }, isSelected, className, setAttributes } = this.props;

		return [
			// Show the block alignment controls on focus
			<BlockControls key="controls">
				<AlignmentToolbar
					value={ accordionAlignment }
					onChange={ ( value ) => this.props.setAttributes( { accordionAlignment: value } ) }
				/>
			</BlockControls>,
			// Show the block controls on focus
			<Inspector
				{ ...this.props }
			/>,
			// Show the button markup in the editor
			<Accordion { ...this.props }>
				<RichText
					tagName="p"
					placeholder={ __( 'Accordion Title', 'qodeblock' ) }
					value={ accordionTitle }
					className="qb-accordion-title"
					onChange={ ( value ) => this.props.setAttributes( { accordionTitle: value } ) }
				/>

				<div className="qb-accordion-text">
					<InnerBlocks />
				</div>
			</Accordion>
		];
	}
}

// Register the block
registerBlockType( 'qodeblock/qb-accordion', {
	title: __( 'Accordion', 'qodeblock' ),
	description: __( 'Add accordion block with a title and text.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'accordion', 'qodeblock' ),
		__( 'list', 'qodeblock' ),
		__( 'qodeblock', 'qodeblock' ),
	],
	attributes: blockAttributes,

	// Render the block components
	edit: QBAccordionBlock,

	// Save the attributes and markup
	save: function( props ) {

		// Setup the attributes
		const { accordionTitle, accordionText, accordionAlignment, accordionFontSize, accordionOpen } = props.attributes;

		// Save the block markup for the front end
		return (
			<Accordion { ...props }>
				<details open={accordionOpen}>
					<summary className="qb-accordion-title">
						<RichText.Content
							value={ accordionTitle }
						/>
					</summary>
					<div className="qb-accordion-text">
						<InnerBlocks.Content />
					</div>
				</details>
			</Accordion>
		);
	},

	deprecated: [ {
		attributes: {
			accordionText: {
				type: 'array',
				selector: '.qb-accordion-text',
				source: 'children',
			},
			...blockAttributes
		},

		migrate( attributes, innerBlocks  ) {
			return [
				omit( attributes, 'accordionText' ),
				[
					createBlock( 'core/paragraph', {
						content: attributes.accordionText,
					} ),
					...innerBlocks,
				],
			];
		},

		save( props ) {
			return (
				<Accordion { ...props }>
					<details open={ props.attributes.accordionOpen }>
						<summary className="qb-accordion-title">
							<RichText.Content
								value={ props.attributes.accordionTitle }
							/>
						</summary>
						<RichText.Content
							className="qb-accordion-text"
							tagName="p"
							value={ props.attributes.accordionText }
						/>
					</details>
				</Accordion>
			);
		},
	} ],
} );
