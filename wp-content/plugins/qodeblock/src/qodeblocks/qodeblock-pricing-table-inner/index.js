/**
 * BLOCK: Qodeblock Pricing Table InnerBlocks
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';

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
	InnerBlocks,
	AlignmentToolbar,
	BlockControls,
	BlockAlignmentToolbar,
} = wp.editor;

const {
	Fragment,
} = wp.element;

// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m14.670613,19.162503l4.694596,0c0.324094,0 0.586825,-0.269316 0.586825,-0.601535l0,-10.226094c0,-0.332219 -0.26273,-0.601535 -0.586825,-0.601535l-4.694596,0l0,11.429164zm1.173649,-8.120722c0,0.829721 0.65712,1.503837 1.467061,1.503837c0.809431,0 1.467061,-0.673593 1.467061,-1.503837c0,-0.829721 -0.65712,-1.503837 -1.467061,-1.503837c-0.809431,0 -1.467061,0.673593 -1.467061,1.503837zm-0.293412,3.907159c0,0.167666 0.133726,0.303586 0.294137,0.303586l2.932673,0c0.162448,0 0.294137,-0.133345 0.294137,-0.303586l0,-0.595899c0,-0.167666 -0.133726,-0.303586 -0.294137,-0.303586l-2.932673,0c-0.162448,0 -0.294137,0.133345 -0.294137,0.303586l0,0.595899zm0.586825,2.105372c0,0.167666 0.132927,0.303586 0.292541,0.303586l1.762216,0c0.161565,0 0.292541,-0.133345 0.292541,-0.303586l0,-0.595899c0,-0.167666 -0.132927,-0.303586 -0.292541,-0.303586l-1.762216,0c-0.161565,0 -0.292541,0.133345 -0.292541,0.303586l0,0.595899zm-9.09578,-10.223276c-0.324094,0 -0.586825,0.269316 -0.586825,0.601535l0,12.030699c0,0.332219 0.26273,0.601535 0.586825,0.601535l5.868245,0c0.324094,0 0.586825,-0.269316 0.586825,-0.601535l0,-12.030699c0,-0.332219 -0.26273,-0.601535 -0.586825,-0.601535l-5.868245,0zm1.173649,3.60921c0,0.995619 0.788592,1.804605 1.760474,1.804605c0.971271,0 1.760474,-0.808361 1.760474,-1.804605c0,-0.995619 -0.788592,-1.804605 -1.760474,-1.804605c-0.971271,0 -1.760474,0.808361 -1.760474,1.804605zm-0.293412,4.508694c0,0.167666 0.132021,0.303586 0.295419,0.303586l3.516933,0c0.163155,0 0.295419,-0.133345 0.295419,-0.303586l0,-0.595899c0,-0.167666 -0.132021,-0.303586 -0.295419,-0.303586l-3.516933,0c-0.163155,0 -0.295419,0.133345 -0.295419,0.303586l0,0.595899zm0.880237,2.105372c0,0.167666 0.132927,0.303586 0.292541,0.303586l1.762216,0c0.161565,0 0.292541,-0.133345 0.292541,-0.303586l0,-0.595899c0,-0.167666 -0.132927,-0.303586 -0.292541,-0.303586l-1.762216,0c-0.161565,0 -0.292541,0.133345 -0.292541,0.303586l0,0.595899zm-8.215543,-9.320974c-0.324094,0 -0.586825,0.269316 -0.586825,0.601535l0,10.226094c0,0.332219 0.26273,0.601535 0.586825,0.601535l4.694596,0l0,-11.429164l-4.694596,0zm0.586825,3.308442c0,0.829721 0.65712,1.503837 1.467061,1.503837c0.809431,0 1.467061,-0.673593 1.467061,-1.503837c0,-0.829721 -0.65712,-1.503837 -1.467061,-1.503837c-0.809431,0 -1.467061,0.673593 -1.467061,1.503837zm-0.293412,3.907159c0,0.167666 0.133726,0.303586 0.294137,0.303586l2.932673,0c0.162448,0 0.294137,-0.133345 0.294137,-0.303586l0,-0.595899c0,-0.167666 -0.133726,-0.303586 -0.294137,-0.303586l-2.932673,0c-0.162448,0 -0.294137,0.133345 -0.294137,0.303586l0,0.595899zm0.586825,2.105372c0,0.167666 0.132927,0.303586 0.292541,0.303586l1.762216,0c0.161565,0 0.292541,-0.133345 0.292541,-0.303586l0,-0.595899c0,-0.167666 -0.132927,-0.303586 -0.292541,-0.303586l-1.762216,0c-0.161565,0 -0.292541,0.133345 -0.292541,0.303586l0,0.595899zm3.227535,-15.940677c0,0.167666 0.133552,0.303586 0.293535,0.303586l9.97577,0c0.162116,0 0.293535,-0.133345 0.293535,-0.303586l0,-0.595899c0,-0.167666 -0.133552,-0.303586 -0.293535,-0.303586l-9.97577,0c-0.162116,0 -0.293535,0.133345 -0.293535,0.303586l0,0.595899zm2.64071,2.40614c0,0.167666 0.130554,0.303586 0.291476,0.303586l4.698469,0c0.160978,0 0.291476,-0.133345 0.291476,-0.303586l0,-0.595899c0,-0.167666 -0.130554,-0.303586 -0.291476,-0.303586l-4.698469,0c-0.160978,0 -0.291476,0.133345 -0.291476,0.303586l0,0.595899z" } )
);

const ALLOWED_BLOCKS = [
	'qodeblock/qb-pricing-table-description',
	'qodeblock/qb-pricing-table-price',
	'qodeblock/qb-pricing-table-subtitle',
	'qodeblock/qb-pricing-table-title',
	'qodeblock/qb-pricing-table-button',
	'core/paragraph',
	'core/image',
];

class QBPricingTableBlock extends Component {

	render() {

		// Setup the attributes
		const { attributes: {
			borderWidth,
			borderColor,
			borderRadius,
			backgroundColor,
			padding,
			alignment
		},
			isSelected,
			className,
			setAttributes
		} = this.props;

		const styles = {
			borderWidth: borderWidth ? borderWidth : null,
			borderStyle: borderWidth > 0 ? 'solid' : null,
			borderColor: borderColor ? borderColor : null,
			borderRadius: borderRadius ? borderRadius : null,
			backgroundColor: backgroundColor ? backgroundColor : null,
			padding: padding ? padding + '%' : null,
		};

		return [
			<BlockControls key="controls">
				<AlignmentToolbar
					value={ alignment }
					onChange={ ( nextAlign ) => {
						setAttributes( { alignment: nextAlign } );
					} }
				/>
			</BlockControls>,
			<Inspector
				{ ...{ setAttributes, ...this.props } }
			/>,
			<Fragment>
				<div
					className={ classnames(
						alignment ? 'qb-block-pricing-table-' + alignment : 'qb-block-pricing-table-center',
						'qb-block-pricing-table',
					) }
					itemScope
					itemType="http://schema.org/Product"
				>
					<div
						className="qb-block-pricing-table-inside"
						style={ styles }
					>
						<InnerBlocks
							template={[
								// Add placeholder blocks
								['qodeblock/qb-pricing-table-title', {
									title: '<strong>Price Title</strong>',
									fontSize: 'medium',
									paddingTop: 30,
									paddingRight: 20,
									paddingBottom: 10,
									paddingLeft: 20,
								}],
								['qodeblock/qb-pricing-table-subtitle', {
									subtitle: 'Price Subtitle Description',
									customFontSize: 20,
									paddingTop: 10,
									paddingRight: 20,
									paddingBottom: 10,
									paddingLeft: 20,
								}],
								['qodeblock/qb-pricing-table-price', {
									price: '49',
									currency: '$',
									customFontSize: 60,
									term: '/mo',
									paddingTop: 10,
									paddingRight: 20,
									paddingBottom: 10,
									paddingLeft: 20,
								}],
								['qodeblock/qb-pricing-table-features', {
									features: '<li>Product Feature One</li><li>Product Feature Two</li><li>Product Feature Three</li>',
									multilineTag: 'li',
									ordered: false,
									customFontSize: 20,
									paddingTop: 15,
									paddingRight: 20,
									paddingBottom: 15,
									paddingLeft: 20,
								}],
								['qodeblock/qb-pricing-table-button', {
									buttonText: 'Buy Now',
									buttonBackgroundColor: '#272c30',
									paddingTop: 15,
									paddingRight: 20,
									paddingBottom: 35,
									paddingLeft: 20,
								}],
							]}
							templateLock={ false }
							allowedBlocks={ ALLOWED_BLOCKS }
							templateInsertUpdatesSelection={ false }
						/>
					</div>
				</div>
			</Fragment>
		];
	}
}

// Register the block
registerBlockType( 'qodeblock/qb-pricing-table', {
	title: __( 'Pricing Column', 'qodeblock' ),
	description: __( 'Add a pricing column.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	parent: [ 'qodeblock/qb-pricing' ],
	keywords: [
		__( 'pricing', 'qodeblock' ),
		__( 'shop', 'qodeblock' ),
		__( 'buy', 'qodeblock' ),
	],
	attributes: {
		borderWidth: {
			type: 'number',
			default: 2,
		},
		borderColor: {
			type: 'string',
		},
		borderRadius: {
			type: 'number',
			default: 0,
		},
		backgroundColor: {
			type: 'string',
		},
		alignment: {
			type: 'string',
		},
		padding: {
			type: 'number',
		},
	},

	// Render the block components
	edit: QBPricingTableBlock,

	// Save the attributes and markup
	save: function( props ) {

		// Setup the attributes
		const {
			borderWidth,
			borderColor,
			borderRadius,
			backgroundColor,
			alignment,
			padding,
		} = props.attributes;

		const styles = {
			borderWidth: borderWidth ? borderWidth : null,
			borderStyle: borderWidth > 0 ? 'solid' : null,
			borderColor: borderColor ? borderColor : null,
			borderRadius: borderRadius ? borderRadius : null,
			backgroundColor: backgroundColor ? backgroundColor : null,
			padding: padding ? padding + '%' : null,
		};

		// Save the block markup for the front end
		return (
			<div
				className={ classnames(
					alignment ? 'qb-block-pricing-table-' + alignment : 'qb-block-pricing-table-center',
					'qb-block-pricing-table',
				) }
				itemScope
				itemType="http://schema.org/Product"
			>
				<div
					className="qb-block-pricing-table-inside"
					style={ styles }
				>
					<InnerBlocks.Content />
				</div>
			</div>
		);
	},
} );
