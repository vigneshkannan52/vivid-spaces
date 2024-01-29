/**
 * BLOCK: Qodeblock Button
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import Spacer from './components/spacer';
import icons from './components/icons';
import Resizable from 're-resizable';

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

// Register editor components
const {
	RichText,
	AlignmentToolbar,
	BlockControls,
	BlockAlignmentToolbar,
	UrlInput,
} = wp.editor;

// Register components
const {
	Button,
	withFallbackStyles,
	IconButton,
	Dashicon,
} = wp.components;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"M20 9v2h-3v8H3v-8H0V9h3V1h14v8h3zM6.5 7h7L10 3zM17 9.5H3v1h14v-1zM13.5 13h-7l3.5 4z" } )
);

class QBSpacerBlock extends Component {

	render() {

		// Setup the attributes
		const { attributes: { spacerHeight, spacerDivider, spacerDividerStyle, spacerDividerColor }, isSelected, className, setAttributes, toggleSelection, spacerDividerHeight } = this.props;

		return [
			// Show the block controls on focus
			<Inspector
				{ ...this.props }
			/>,
			// Show the button markup in the editor
			<Spacer { ...this.props }>
				<Resizable
					className={ classnames( className, 'qb-spacer-handle' ) }
					style={ {
						color: spacerDividerColor
					} }
					size={ {
						width: '100%',
						height: spacerHeight,
					} }
					minWidth= { '100%' }
					maxWidth= { '100%' }
					minHeight= { '100%' }
					handleClasses={ {
						bottomLeft: 'qb-spacer-control__resize-handle',
					} }
					enable={ { top: false, right: false, bottom: true, left: false, topRight: false, bottomRight: false, bottomLeft: true, topLeft: false } }
					onResizeStart={ () => {
						toggleSelection( false );
					} }
					onResizeStop={ ( event, direction, elt, delta ) => {
						setAttributes( {
							spacerHeight: parseInt( spacerHeight + delta.height, 10 ),
						} );
						toggleSelection( true );
					} }
				>
				</Resizable>
			</Spacer>
		];
	}
}

// Register the block
registerBlockType( 'qodeblock/qb-spacer', {
	title: __( 'Spacer', 'qodeblock' ),
	description: __( 'Add a spacer and divider between your blocks.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'spacer', 'qodeblock' ),
		__( 'divider', 'qodeblock' ),
		__( 'qodeblock', 'qodeblock' ),
	],
	attributes: {
		spacerHeight: {
			type: 'number',
			default: 30,
		},
		spacerDivider: {
			type: 'boolean',
			default: false
		},
		spacerDividerStyle: {
			type: 'string',
			default: 'qb-divider-solid'
		},
		spacerDividerColor: {
			type: 'string',
			default: '#ddd'
		},
		spacerDividerHeight: {
			type: 'number',
			default: 1,
		},
	},

	// Render the block components
	edit: QBSpacerBlock,

	// Save the attributes and markup
	save: function( props ) {

		// Setup the attributes
		const { spacerHeight, spacerDivider, spacerDividerStyle, spacerDividerColor, spacerDividerHeight } = props.attributes;

		// Save the block markup for the front end
		return (
			<Spacer { ...props }>
				<hr style={ { height: spacerHeight ? spacerHeight + 'px' : undefined } }></hr>
			</Spacer>
		);
	},
} );
