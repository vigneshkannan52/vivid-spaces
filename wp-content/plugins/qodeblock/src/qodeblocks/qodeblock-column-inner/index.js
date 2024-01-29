/**
 * BLOCK: Qodeblock Advanced Columns InnerBlocks.
 */

/**
 * Internal dependencies.
 */
import Edit from './components/edit';
import Save from './components/save';
import deprecated from './deprecated/deprecated';
import './styles/style.scss';
import './styles/editor.scss';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m0.112021,4l19.775958,0l0,11.550092l-19.775958,0l0,-11.550092zm1.521228,1.283344l0,8.983405l4.563683,0l0,-8.983405l-4.563683,0zm6.08491,0l0,8.983405l4.563683,0l0,-8.983405l-4.563683,0zm6.08491,0l0,8.983405l4.563683,0l0,-8.983405l-4.563683,0zm0,0" } )
);
/**
 * Register advanced columns block.
 */
registerBlockType( 'qodeblock/qb-column', {
	title: __( 'Advanced Column', 'qodeblock' ),
	description: __( 'Add a pre-defined column layout.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	parent: [ 'qodeblock/qb-columns' ],
	keywords: [
		__( 'column', 'qodeblock' ),
		__( 'layout', 'qodeblock' ),
		__( 'row', 'qodeblock' ),
	],
	attributes: {
		backgroundColor: {
			type: 'string',
		},
		customBackgroundColor: {
			type: 'string',
		},
		textColor: {
			type: 'string',
		},
		customTextColor: {
			type: 'string',
		},
		textAlign: {
			type: 'string',
		},
		marginSync: {
			type: 'boolean',
			default: false,
		},
		marginUnit: {
			type: 'string',
			default: 'px',
		},
		margin: {
			type: 'number',
			default: 0,
		},
		marginTop: {
			type: 'number',
			default: 0,
		},
		marginBottom: {
			type: 'number',
			default: 0,
		},
		paddingSync: {
			type: 'boolean',
			default: false,
		},
		paddingUnit: {
			type: 'string',
			default: 'px',
		},
		padding: {
			type: 'number',
			default: 0,
		},
		paddingTop: {
			type: 'number',
			default: 0,
		},
		paddingRight: {
			type: 'number',
			default: 0,
		},
		paddingBottom: {
			type: 'number',
			default: 0,
		},
		paddingLeft: {
			type: 'number',
			default: 0,
		},
		columnVerticalAlignment: {
			type: 'string',
		},
	},

	/* Render the block in the editor. */
	edit: props => {
		return <Edit { ...props } />;
	},

	/* Save the block markup. */
	save: props => {
		return <Save { ...props } />;
	},

	deprecated: deprecated,
} );

/* Add the vertical column alignment class to the block wrapper. */
const withClientIdClassName = wp.compose.createHigherOrderComponent( ( BlockListBlock ) => {
    return ( props ) => {
		const blockName = props.block.name;

		if( props.attributes.columnVerticalAlignment && blockName === 'qodeblock/qb-column' ) {
            return <BlockListBlock { ...props } className={ "qb-is-vertically-aligned-" + props.attributes.columnVerticalAlignment } />;
        } else {
            return <BlockListBlock { ...props } />
        }
	};
}, 'withClientIdClassName' );

wp.hooks.addFilter(
	'editor.BlockListBlock',
	'qodeblock/add-vertical-align-class',
	withClientIdClassName
);
