/**
 * BLOCK: Qodeblock Advanced Columns.
 */

/**
 * Components and dependencies.
 */
import Edit from './components/edit';
import Save from './components/save';

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
 * Register advanced columns block InnerBlocks.
 */
registerBlockType( 'qodeblock/qb-columns', {
	title: __( 'Advanced Columns', 'qodeblock' ),
	description: __( 'Add a pre-defined column layout.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'column', 'qodeblock' ),
		__( 'layout', 'qodeblock' ),
		__( 'row', 'qodeblock' ),
	],
	attributes: {
		columns: {
			type: 'number',
		},
		layout: {
			type: 'string',
		},
		columnsGap: {
			type: 'number',
			default: 2,
		},
		align: {
			type: 'string',
		},
		responsiveToggle: {
			type: 'boolean',
			default: true,
		},
		marginSync: {
			type: 'boolean',
			default: false,
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
		marginUnit: {
			type: 'string',
			default: 'px',
		},
		paddingSync: {
			type: 'boolean',
			default: false,
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
		paddingUnit: {
			type: 'string',
			default: 'px',
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
		columnMaxWidth: {
			type: 'number',
		},
		centerColumns: {
			type: 'boolean',
			default: true,
		},
	},

	/* Add alignment to block wrapper. */
	getEditWrapperProps( { align } ) {
		if ( 'left' === align || 'right' === align || 'full' === align || 'wide' === align ) {
			return { 'data-align': align };
		}
	},

	/* Render the block components. */
	edit: props => {
		return <Edit { ...props } />;
	},

	/* Save the block markup. */
	save: props => {
		return <Save { ...props } />;
	},
} );
