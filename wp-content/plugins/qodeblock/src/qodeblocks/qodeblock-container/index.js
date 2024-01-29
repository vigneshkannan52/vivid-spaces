/**
 * BLOCK: Qodeblock Container
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import Container from './components/container';

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
    el('path', { fill:"#2A74ED",d:"m19.587666,19.055994l0,-18.140641c0,-0.499284 -0.399639,-0.915353 -0.879206,-0.915353l-17.424258,0c-0.479567,0 -0.879206,0.41607 -0.879206,0.915353l0,18.140641c0,0.499284 0.399639,0.915353 0.879206,0.915353l17.424258,0c0.479567,0 0.879206,-0.41607 0.879206,-0.915353zm-17.584114,-17.391715l15.985558,0l0,4.992837l-15.985558,0l0,-4.992837zm0,5.824976l15.985558,0l0,4.992837l-15.985558,0l0,-4.992837zm0,10.817813l0,-4.992837l15.985558,0l0,4.992837l-15.985558,0z" } )
);

// Register editor components
const {
	AlignmentToolbar,
	BlockControls,
	BlockAlignmentToolbar,
	MediaUpload,
	RichText,
	InnerBlocks,
} = wp.editor;

// Register components
const {
	Button,
	withFallbackStyles,
	IconButton,
	Dashicon,
	withState,
	Toolbar,
} = wp.components;

const blockAttributes = {
	containerPaddingTop: {
		type: 'number',
	},
	containerPaddingRight: {
		type: 'number',
	},
	containerPaddingBottom: {
		type: 'number',
	},
	containerPaddingLeft: {
		type: 'number',
	},
	containerMarginTop: {
		type: 'number',
	},
	containerMarginBottom: {
		type: 'number',
	},
	containerWidth: {
		type: 'string',
	},
	containerMaxWidth: {
		type: 'number',
		default: 1600,
	},
	containerBackgroundColor: {
		type: 'string',
	},
	containerImgURL: {
		type: 'string',
		source: 'attribute',
		attribute: 'src',
		selector: 'img',
	},
	containerImgID: {
		type: 'number',
	},
	containerImgAlt: {
		type: 'string',
		source: 'attribute',
		attribute: 'alt',
		selector: 'img',
	},
	containerDimRatio: {
		type: 'number',
		default: 50,
	},
};

class QBContainerBlock extends Component {

	render() {

		// Setup the attributes
		const {
			attributes: {
				containerPaddingTop,
				containerPaddingRight,
				containerPaddingBottom,
				containerPaddingLeft,
				containerMarginTop,
				containerMarginBottom,
				containerWidth,
				containerMaxWidth,
				containerBackgroundColor,
				containerImgURL,
				containerImgID,
				containerImgAlt,
				containerDimRatio,
			},
			attributes,
			isSelected,
			editable,
			className,
			setAttributes
		} = this.props;

		const onSelectImage = img => {
			setAttributes( {
				containerImgID: img.id,
				containerImgURL: img.url,
				containerImgAlt: img.alt,
			} );
		};

		return [
			// Show the alignment toolbar on focus
			<BlockControls>
				<BlockAlignmentToolbar
					value={ containerWidth }
					onChange={ containerWidth => setAttributes( { containerWidth } ) }
					controls={ [ 'center', 'full' ] }
				/>
			</BlockControls>,
			// Show the block controls on focus
			<Inspector
				{ ...{ setAttributes, ...this.props } }
			/>,
			// Show the container markup in the editor
			<Container { ...this.props }>
				<div className="qb-container-inside">
					{ containerImgURL && !! containerImgURL.length && (
						<div className="qb-container-image-wrap">
							<img
								className={ classnames(
									'qb-container-image',
									dimRatioToClass( containerDimRatio ),
									{
										'has-background-dim': containerDimRatio !== 0,
									}
								) }
								src={ containerImgURL }
								alt={ containerImgAlt }
							/>
						</div>
					) }

					<div
						className="qb-container-content"
						style={ {
							maxWidth: `${containerMaxWidth}px`,
						} }
					>
						<InnerBlocks />
					</div>
				</div>
			</Container>
		];
	}
}

// Register the block
registerBlockType( 'qodeblock/qb-container', {
	title: __( 'Container', 'qodeblock' ),
	description: __( 'Add a container block to wrap several blocks in a parent container.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'container', 'qodeblock' ),
		__( 'section', 'qodeblock' ),
		__( 'qodeblock', 'qodeblock' ),
	],

	attributes: blockAttributes,

	getEditWrapperProps( { containerWidth } ) {
		if ( 'left' === containerWidth || 'right' === containerWidth || 'full' === containerWidth ) {
			return { 'data-align': containerWidth };
		}
	},

	// Render the block components
	edit: QBContainerBlock,

	// Save the attributes and markup
	save: function( props ) {

		// Setup the attributes
		const {
			containerPaddingTop,
			containerPaddingRight,
			containerPaddingBottom,
			containerPaddingLeft,
			containerMarginTop,
			containerMarginBottom,
			containerWidth,
			containerMaxWidth,
			containerBackgroundColor,
			containerImgURL,
			containerImgID,
			containerImgAlt,
			containerDimRatio,
		} = props.attributes;

		// Save the block markup for the front end
		return (
			<Container { ...props }>
				<div className="qb-container-inside">
					{ containerImgURL && !! containerImgURL.length && (
						<div className="qb-container-image-wrap">
							<img
								className={ classnames(
									'qb-container-image',
									dimRatioToClass( containerDimRatio ),
									{
										'has-background-dim': containerDimRatio !== 0,
									}
								) }
								src={ containerImgURL }
								alt={ containerImgAlt }
							/>
						</div>
					) }

					<div
						className="qb-container-content"
						style={ {
							maxWidth: `${containerMaxWidth}px`,
						} }
					>
						<InnerBlocks.Content />
					</div>
				</div>
			</Container>
		);
	},

	deprecated: deprecated,

} );

function dimRatioToClass( ratio ) {
	return ( ratio === 0 || ratio === 50 ) ?
		null :
		'has-background-dim-' + ( 10 * Math.round( ratio / 10 ) );
}

function backgroundImageStyles( url ) {
	return url ?
		{ backgroundImage: `url(${ url })` } :
		undefined;
}
