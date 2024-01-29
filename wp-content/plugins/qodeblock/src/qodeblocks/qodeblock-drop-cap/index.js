/**
 * BLOCK: Qodeblock Drop Cap
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import DropCap from './components/dropcap';
import icons from './components/icons';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// Internationalization
const { __ } = wp.i18n;

// Extend component
const { Component } = wp.element;

// Register block
const { registerBlockType } = wp.blocks;

// Register editor components
const {
	RichText,
	AlignmentToolbar,
	BlockControls,
	BlockAlignmentToolbar,
	MediaUpload,
} = wp.editor;

// Register components
const {
	Button,
	SelectControl,
} = wp.components;

// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"M7.6,0 L4.9,0 L0,12.2625 L0,12.5 L2.6,12.5 L3.6,10 L8.9,10 L9.9,12.5 L12.5,12.5 L12.5,12.2625 L7.6,0 Z M4.6,7.5 L6.25,3.3625 L7.9,7.5 L4.6,7.5 Z M0,15 L20,15 L20,17.5 L0,17.5 L0,15 Z M15,10 L20,10 L20,12.5 L15,12.5 L15,10 Z M15,5 L20,5 L20,7.5 L15,7.5 L15,5 Z M15,0 L20,0 L20,2.5 L15,2.5 L15,0 Z" } )
);

class QBDropCapBlock extends Component {

	render() {

		// Setup the attributes
		const { attributes: { dropCapContent, dropCapAlignment, dropCapBackgroundColor, dropCapTextColor, dropCapFontSize, dropCapStyle }, isSelected, className, setAttributes } = this.props;

		return [
			// Show the alignment toolbar on focus
			<BlockControls key="controls">
				<AlignmentToolbar
					value={ dropCapAlignment }
					onChange={ ( value ) => this.props.setAttributes( { dropCapAlignment: value } ) }
				/>
			</BlockControls>,
			// Show the block controls on focus
			<Inspector
				{ ...this.props }
			/>,
			// Show the block markup in the editor
			<DropCap { ...this.props }>
				<RichText
					tagName="div"
					multiline="p"
					placeholder={ __( 'Add paragraph text...', 'qodeblock' ) }
					keepPlaceholderOnFocus
					value={ dropCapContent }
					formattingControls={ [ 'bold', 'italic', 'strikethrough', 'link' ] }
					className={ classnames(
						'qb-drop-cap-text',
						'qb-font-size-' + dropCapFontSize,
					) }
					onChange={ ( value ) => this.props.setAttributes( { dropCapContent: value } ) }
				/>
			</DropCap>
		];
	}
}

// Register the block
registerBlockType( 'qodeblock/qb-drop-cap', {
	title: __( 'Drop Cap Text', 'qodeblock' ),
	description: __( 'Add a styled drop cap to the beginning of your paragraph.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'drop cap', 'qodeblock' ),
		__( 'quote', 'qodeblock' ),
		__( 'qodeblock', 'qodeblock' ),
	],
	attributes: {
		dropCapContent: {
			type: 'array',
			selector: '.qb-drop-cap-text',
			source: 'children',
		},
		dropCapAlignment: {
			type: 'string',
		},
		dropCapBackgroundColor: {
			type: 'string',
			default: '#f2f2f2'
		},
		dropCapTextColor: {
			type: 'string',
			default: '#32373c'
		},
		dropCapFontSize: {
			type: 'number',
			default: 3,
		},
		dropCapStyle: {
            type: 'string',
            default: 'drop-cap-letter',
        },
	},

	// Render the block components
	edit: QBDropCapBlock,

	// Save the attributes and markup
	save: function( props ) {

		const { dropCapContent, dropCapAlignment, dropCapBackgroundColor, dropCapTextColor, dropCapFontSize, dropCapStyle } = props.attributes;

		// Save the block markup for the front end
		return (
			<DropCap { ...props }>
				{	// Check if there is text and output
					dropCapContent && (
					<RichText.Content
						tagName="div"
						className="qb-drop-cap-text"
						value={ dropCapContent }
					/>
				) }
			</DropCap>
		);
	},
} );
