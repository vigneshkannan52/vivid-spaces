/**
 * BLOCK: Qodeblock Pricing Table
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import PricingTable from './components/pricing';
import memoize from 'memize';
import _times from 'lodash/times';

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
	InnerBlocks,
} = wp.editor;

// Register components
const {
	Button,
	SelectControl,
} = wp.components;


// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m14.670613,19.162503l4.694596,0c0.324094,0 0.586825,-0.269316 0.586825,-0.601535l0,-10.226094c0,-0.332219 -0.26273,-0.601535 -0.586825,-0.601535l-4.694596,0l0,11.429164zm1.173649,-8.120722c0,0.829721 0.65712,1.503837 1.467061,1.503837c0.809431,0 1.467061,-0.673593 1.467061,-1.503837c0,-0.829721 -0.65712,-1.503837 -1.467061,-1.503837c-0.809431,0 -1.467061,0.673593 -1.467061,1.503837zm-0.293412,3.907159c0,0.167666 0.133726,0.303586 0.294137,0.303586l2.932673,0c0.162448,0 0.294137,-0.133345 0.294137,-0.303586l0,-0.595899c0,-0.167666 -0.133726,-0.303586 -0.294137,-0.303586l-2.932673,0c-0.162448,0 -0.294137,0.133345 -0.294137,0.303586l0,0.595899zm0.586825,2.105372c0,0.167666 0.132927,0.303586 0.292541,0.303586l1.762216,0c0.161565,0 0.292541,-0.133345 0.292541,-0.303586l0,-0.595899c0,-0.167666 -0.132927,-0.303586 -0.292541,-0.303586l-1.762216,0c-0.161565,0 -0.292541,0.133345 -0.292541,0.303586l0,0.595899zm-9.09578,-10.223276c-0.324094,0 -0.586825,0.269316 -0.586825,0.601535l0,12.030699c0,0.332219 0.26273,0.601535 0.586825,0.601535l5.868245,0c0.324094,0 0.586825,-0.269316 0.586825,-0.601535l0,-12.030699c0,-0.332219 -0.26273,-0.601535 -0.586825,-0.601535l-5.868245,0zm1.173649,3.60921c0,0.995619 0.788592,1.804605 1.760474,1.804605c0.971271,0 1.760474,-0.808361 1.760474,-1.804605c0,-0.995619 -0.788592,-1.804605 -1.760474,-1.804605c-0.971271,0 -1.760474,0.808361 -1.760474,1.804605zm-0.293412,4.508694c0,0.167666 0.132021,0.303586 0.295419,0.303586l3.516933,0c0.163155,0 0.295419,-0.133345 0.295419,-0.303586l0,-0.595899c0,-0.167666 -0.132021,-0.303586 -0.295419,-0.303586l-3.516933,0c-0.163155,0 -0.295419,0.133345 -0.295419,0.303586l0,0.595899zm0.880237,2.105372c0,0.167666 0.132927,0.303586 0.292541,0.303586l1.762216,0c0.161565,0 0.292541,-0.133345 0.292541,-0.303586l0,-0.595899c0,-0.167666 -0.132927,-0.303586 -0.292541,-0.303586l-1.762216,0c-0.161565,0 -0.292541,0.133345 -0.292541,0.303586l0,0.595899zm-8.215543,-9.320974c-0.324094,0 -0.586825,0.269316 -0.586825,0.601535l0,10.226094c0,0.332219 0.26273,0.601535 0.586825,0.601535l4.694596,0l0,-11.429164l-4.694596,0zm0.586825,3.308442c0,0.829721 0.65712,1.503837 1.467061,1.503837c0.809431,0 1.467061,-0.673593 1.467061,-1.503837c0,-0.829721 -0.65712,-1.503837 -1.467061,-1.503837c-0.809431,0 -1.467061,0.673593 -1.467061,1.503837zm-0.293412,3.907159c0,0.167666 0.133726,0.303586 0.294137,0.303586l2.932673,0c0.162448,0 0.294137,-0.133345 0.294137,-0.303586l0,-0.595899c0,-0.167666 -0.133726,-0.303586 -0.294137,-0.303586l-2.932673,0c-0.162448,0 -0.294137,0.133345 -0.294137,0.303586l0,0.595899zm0.586825,2.105372c0,0.167666 0.132927,0.303586 0.292541,0.303586l1.762216,0c0.161565,0 0.292541,-0.133345 0.292541,-0.303586l0,-0.595899c0,-0.167666 -0.132927,-0.303586 -0.292541,-0.303586l-1.762216,0c-0.161565,0 -0.292541,0.133345 -0.292541,0.303586l0,0.595899zm3.227535,-15.940677c0,0.167666 0.133552,0.303586 0.293535,0.303586l9.97577,0c0.162116,0 0.293535,-0.133345 0.293535,-0.303586l0,-0.595899c0,-0.167666 -0.133552,-0.303586 -0.293535,-0.303586l-9.97577,0c-0.162116,0 -0.293535,0.133345 -0.293535,0.303586l0,0.595899zm2.64071,2.40614c0,0.167666 0.130554,0.303586 0.291476,0.303586l4.698469,0c0.160978,0 0.291476,-0.133345 0.291476,-0.303586l0,-0.595899c0,-0.167666 -0.130554,-0.303586 -0.291476,-0.303586l-4.698469,0c-0.160978,0 -0.291476,0.133345 -0.291476,0.303586l0,0.595899z" } )
);

// Set allowed blocks and media
const ALLOWED_BLOCKS = [ 'qodeblock/qb-pricing-table' ];

// Get the pricing template
const getPricingTemplate = memoize( ( columns ) => {
	return _times( columns, () => [ 'qodeblock/qb-pricing-table' ] );
} );

class QBPricingBlock extends Component {

	render() {

		// Setup the attributes
		const {
			attributes: {
				columns,
				columnsGap,
				align,
			},
			attributes,
			isSelected,
			editable,
			className,
			setAttributes
		} = this.props;

		return [
			// Show the alignment toolbar on focus
			<BlockControls key="controls">
				<BlockAlignmentToolbar
					value={ align }
					onChange={ align => setAttributes( { align } ) }
					controls={ [ 'center', 'wide', 'full' ] }
				/>
			</BlockControls>,
			// Show the block controls on focus
			<Inspector
				{ ...{ setAttributes, ...this.props } }
			/>,
			// Show the block markup in the editor
			<PricingTable { ...this.props }>
				<div
					className={ classnames(
						'qb-pricing-table-wrap-admin',
						'qb-block-pricing-table-gap-' + columnsGap
					) }
				>
					<InnerBlocks
						template={ getPricingTemplate( columns ) }
						templateLock="all"
						allowedBlocks={ ALLOWED_BLOCKS }
					/>
				</div>
			</PricingTable>
		];
	}
}

// Register the block
registerBlockType( 'qodeblock/qb-pricing', {
	title: __( 'Pricing', 'qodeblock' ),
	description: __( 'Add a pricing table.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'pricing table', 'qodeblock' ),
		__( 'shop', 'qodeblock' ),
		__( 'purchase', 'qodeblock' ),
	],
	attributes: {
		columns: {
			type: 'number',
			default: 2,
		},
		columnsGap: {
			type: 'number',
			default: 2,
		},
		align: {
			type: 'string',
		},
	},

	// Add alignment to block wrapper
	getEditWrapperProps( { align } ) {
		if ( 'left' === align || 'right' === align || 'full' === align || 'wide' === align ) {
			return { 'data-align': align };
		}
	},

	// Render the block components
	edit: QBPricingBlock,

	// Save the attributes and markup
	save: function( props ) {

		// Setup the attributes
		const {
			columns,
			columnsGap,
			align,
		} = props.attributes;

		// Setup the classes
		const className = classnames( [
			'qb-pricing-table-wrap',
			'qb-block-pricing-table-gap-' + columnsGap
		])

		// Save the block markup for the front end
		return (
			<PricingTable { ...props }>
				<div
					className={ className ? className : undefined }
				>
					<InnerBlocks.Content />
				</div>
			</PricingTable>
		);
	},
} );
