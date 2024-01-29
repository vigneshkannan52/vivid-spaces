/**
 * BLOCK: Qodeblock Testimonial
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import Testimonial from './components/testimonial';
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
    el('path', { fill:"#2A74ED",d:"m5.220892,10.52322a4.093317,4.238096 0 0 0 -1.826991,0.410496c0.578636,-1.664174 1.800202,-2.823549 3.702202,-3.472576a1.607323,1.664174 0 0 0 0.969752,-0.787709a0.916174,0.948579 0 0 0 0.04822,-0.748878a1.25907,1.303603 0 0 0 -1.242997,-0.76552a1.650185,1.708552 0 0 0 -0.492913,0.072114c-3.996878,1.164922 -6.381074,4.337947 -6.381074,8.48174c0,3.228498 1.773414,5.31981 4.521937,5.31981s4.479075,-1.730741 4.479075,-4.410061c0,-2.45743 -1.516242,-4.099415 -3.77721,-4.099415zm10.994093,0a4.098675,4.243644 0 0 0 -1.826991,0.410496c0.578636,-1.664174 1.800202,-2.823549 3.707559,-3.472576a1.607323,1.664174 0 0 0 0.969752,-0.787709a0.916174,0.948579 0 0 0 0.04822,-0.748878a1.253712,1.298056 0 0 0 -1.242997,-0.76552a1.666259,1.725194 0 0 0 -0.492913,0.072114c-3.996878,1.164922 -6.381074,4.337947 -6.381074,8.48174c0,3.228498 1.778771,5.31981 4.527294,5.31981s4.479075,-1.730741 4.479075,-4.410061c-0.010715,-2.45743 -1.526957,-4.099415 -3.787926,-4.099415z" } )
);

const ALLOWED_MEDIA_TYPES = [ 'image' ];

class QBTestimonialBlock extends Component {

	render() {

		// Setup the attributes
		const {
			attributes: {
				testimonialName,
				testimonialTitle,
				testimonialContent,
				testimonialAlignment,
				testimonialImgURL,
				testimonialImgID,
				testimonialBackgroundColor,
				testimonialTextColor,
				testimonialFontSize,
				testimonialCiteAlign
			},
			attributes,
			isSelected,
			editable,
			className,
			setAttributes
		} = this.props;

		const onSelectImage = img => {
			setAttributes( {
				testimonialImgID: img.id,
				testimonialImgURL: img.url,
			} );
		};

		return [
			// Show the alignment toolbar on focus
			<BlockControls key="controls">
				<AlignmentToolbar
					value={ testimonialAlignment }
					onChange={ ( value ) => setAttributes( { testimonialAlignment: value } ) }
				/>
			</BlockControls>,
			// Show the block controls on focus
			<Inspector
				{ ...{ setAttributes, ...this.props } }
			/>,
			// Show the block markup in the editor
			<Testimonial { ...this.props }>
				<RichText
					tagName="div"
					multiline="p"
					placeholder={ __( 'Add testimonial text...', 'qodeblock' ) }
					keepPlaceholderOnFocus
					value={ testimonialContent }
					formattingControls={ [ 'bold', 'italic', 'strikethrough', 'link' ] }
					className={ classnames(
						'qb-testimonial-text'
					) }
					style={ {
						textAlign: testimonialAlignment,
					} }
					onChange={ ( value ) => setAttributes( { testimonialContent: value } ) }
				/>

				<div className="qb-testimonial-info">
					<div className="qb-testimonial-avatar-wrap">
						<div className="qb-testimonial-image-wrap">
							<MediaUpload
								buttonProps={ {
									className: 'change-image'
								} }
								onSelect={ ( img ) => setAttributes(
									{
										testimonialImgID: img.id,
										testimonialImgURL: img.url,
									}
								) }
								allowed={ ALLOWED_MEDIA_TYPES }
								type="image"
								value={ testimonialImgID }
								render={ ( { open } ) => (
									<Button onClick={ open }>
										{ ! testimonialImgID ? icons.upload : <img
											className="qb-testimonial-avatar"
											src={ testimonialImgURL }
											alt="avatar"
										/>  }
									</Button>
								) }
							>
							</MediaUpload>
						</div>
					</div>

					<RichText
						tagName="h5"
						placeholder={ __( 'Add name', 'qodeblock' ) }
						keepPlaceholderOnFocus
						value={ testimonialName }
						className='qb-testimonial-name'
						style={ {
							color: testimonialTextColor
						} }
						onChange={ ( value ) => this.props.setAttributes( { testimonialName: value } ) }
					/>

					<RichText
						tagName="p"
						placeholder={ __( 'Add title', 'qodeblock' ) }
						keepPlaceholderOnFocus
						value={ testimonialTitle }
						className='qb-testimonial-title'
						style={ {
							color: testimonialTextColor
						} }
						onChange={ ( value ) => this.props.setAttributes( { testimonialTitle: value } ) }
					/>
				</div>
			</Testimonial>
		];
	}
}

// Register the block
registerBlockType( 'qodeblock/qb-testimonial', {
	title: __( 'Testimonial', 'qodeblock' ),
	description: __( 'Add a user testimonial with a name and title.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'testimonial', 'qodeblock' ),
		__( 'quote', 'qodeblock' ),
		__( 'qodeblock', 'qodeblock' ),
	],
	attributes: {
		testimonialName: {
			type: 'array',
			selector: '.qb-testimonial-name',
			source: 'children',
		},
		testimonialTitle: {
			type: 'array',
			selector: '.qb-testimonial-title',
			source: 'children',
		},
		testimonialContent: {
			type: 'array',
			selector: '.qb-testimonial-text',
			source: 'children',
		},
		testimonialAlignment: {
			type: 'string',
		},
		testimonialImgURL: {
			type: 'string',
			source: 'attribute',
			attribute: 'src',
			selector: 'img',
		},
		testimonialImgID: {
			type: 'number',
		},
		testimonialBackgroundColor: {
			type: 'string',
		},
		testimonialTextColor: {
			type: 'string',
		},
		testimonialFontSize: {
			type: 'number',
			default: 16,
		},
		testimonialCiteAlign: {
            type: 'string',
            default: 'left-aligned',
        },
	},

	// Render the block components
	edit: QBTestimonialBlock,

	// Save the attributes and markup
	save: function( props ) {

		// Setup the attributes
		const {
			testimonialName,
			testimonialTitle,
			testimonialContent,
			testimonialAlignment,
			testimonialImgURL,
			testimonialImgID,
			testimonialBackgroundColor,
			testimonialTextColor,
			testimonialFontSize,
			testimonialCiteAlign
		} = props.attributes;

		// Save the block markup for the front end
		return (
			<Testimonial { ...props }>
				<RichText.Content
					tagName="div"
					className="qb-testimonial-text"
					style={ {
						textAlign: testimonialAlignment,
					} }
					value={ testimonialContent }
				/>

				<div className="qb-testimonial-info">
					{ testimonialImgURL && (
						<div className="qb-testimonial-avatar-wrap">
							<div className="qb-testimonial-image-wrap">
								<img
									className="qb-testimonial-avatar"
									src={ testimonialImgURL }
									alt="avatar"
								/>
							</div>
						</div>
					) }

					{ testimonialName && (
						<RichText.Content
							tagName="h5"
							className="qb-testimonial-name"
							style={ {
								color: testimonialTextColor
							} }
							value={ testimonialName }
						/>
					) }

					{ testimonialTitle && (
						<RichText.Content
							tagName="p"
							className="qb-testimonial-title"
							style={ {
								color: testimonialTextColor
							} }
							value={ testimonialTitle }
						/>
					) }
				</div>
			</Testimonial>
		);
	},
} );
