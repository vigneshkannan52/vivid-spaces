/**
 * BLOCK: Qodeblock Profile Box
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import ProfileBox from './components/profile';
import SocialIcons from './components/social';
import AvatarColumn from './components/avatar';
import icons from './components/icons';

// Import styles
import './styles/style.scss';
import './styles/editor.scss';

// Internationalization
const { __ } = wp.i18n;

// Extend component
const { Component } = wp.element;

// Register block
const { registerBlockType } = wp.blocks;

// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

// Register components
const {
	RichText,
	AlignmentToolbar,
	BlockControls,
	InspectorControls,
	MediaUpload,
} = wp.editor;

// Register Inspector components
const {
	Button,
} = wp.components;

const blockAttributes = {
	profileName: {
		type: 'array',
		source: 'children',
		selector: '.qb-profile-name',
	},
	profileTitle: {
		type: 'array',
		source: 'children',
		selector: '.qb-profile-title',
	},
	profileContent: {
		type: 'array',
		selector: '.qb-profile-text',
		source: 'children',
	},
	profileAlignment: {
		type: 'string',
	},
	profileImgURL: {
		type: 'string',
		source: 'attribute',
		attribute: 'src',
		selector: 'img',
	},
	profileImgID: {
		type: 'number',
	},
	profileBackgroundColor: {
		type: 'string',
	},
	profileTextColor: {
		type: 'string',
	},
	profileLinkColor: {
		type: 'string',
	},
	profileFontSize: {
		type: 'number',
		default: 16
	},
	profileAvatarShape: {
		type: 'string',
		default: 'square',
	},
	twitter: {
		type: 'url',
	},
	facebook: {
		type: 'url',
	},
	instagram: {
		type: 'url',
	},
	pinterest: {
		type: 'url',
	},
	google: {
		type: 'url',
	},
	youtube: {
		type: 'url',
	},
	github: {
		type: 'url',
	},
	linkedin: {
		type: 'url',
	},
	email: {
		type: 'url',
	},
	website: {
		type: 'url',
	},
};

const ALLOWED_MEDIA_TYPES = [ 'image' ];

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m11.05293,19.867795l7.726555,0c0.651154,0 1.072712,-0.221342 1.098026,-0.920038c0.038393,-1.153669 -0.102141,-1.992505 -0.881129,-2.994131c-1.187468,-1.537917 -3.843849,-2.30703 -4.929682,-2.749715c-1.353694,-0.547424 -1.660075,-1.048622 -1.647376,-2.015618c0,-0.407669 -0.063748,-0.873428 0.39578,-1.269964c0.868472,-0.768728 0.932558,-1.677402 1.277374,-1.910301c0.39578,-0.279663 0.817381,-0.745653 0.817381,-1.398124c-0.013121,-0.396113 -0.102141,-0.664027 -0.625798,-0.966996c-0.166269,-0.093144 -0.20424,-0.198076 -0.217361,-0.302776c-0.063706,-1.002011 1.328423,-3.867983 -0.75321,-3.716479c-1.583712,-2.353409 -6.794208,-1.759221 -7.586064,0.803782c-0.242632,0.792225 0.40869,2.003869 0.344984,2.912736c0,0.1047 -0.038393,0.209593 -0.217108,0.302776c-0.523699,0.302969 -0.613141,0.570883 -0.613141,0.966996c-0.012657,0.652471 0.421558,1.118461 0.817381,1.398124c0.344773,0.232899 0.40869,1.141573 1.277163,1.910301c0.459698,0.396536 0.383166,0.862295 0.395823,1.269964c0.012868,0.967034 -0.293724,1.468194 -1.64746,2.015618c-1.085538,0.442685 -3.754618,1.211797 -4.929429,2.749715c-0.791856,1.001626 -0.932389,1.840424 -0.881298,2.994131c0.012868,0.326081 0.102352,0.547424 0.268157,0.698696c0.191625,0.163175 0.472692,0.221304 0.830333,0.221304l7.726344,0l0.114798,-2.143392l0.204451,-3.471909c0.421347,-0.256358 0.893955,-0.256358 1.302476,0l0.204662,3.471909l0.12737,2.143392z" } )
);

class QBAuthorProfileBlock extends Component {

	render() {

		// Setup the attributes
		const {
			attributes: {
				profileName,
				profileTitle,
				profileContent,
				profileAlignment,
				profileImgURL,
				profileImgID,
				profileFontSize,
				profileBackgroundColor,
				profileTextColor,
				profileLinkColor,
				twitter,
				facebook,
				instagram,
				pinterest,
				google,
				youtube,
				github,
				email,
				website,
				profileAvatarShape
			},
			attributes,
			isSelected,
			editable,
			className,
			setAttributes
		} = this.props;

		const onSelectImage = img => {
			setAttributes( {
				profileImgID: img.id,
				profileImgURL: img.url,
			} );
		};

		return [
			// Show the block alignment controls on focus
			<BlockControls key="controls">
				<AlignmentToolbar
					value={ profileAlignment }
					onChange={ ( value ) => setAttributes( { profileAlignment: value } ) }
				/>
			</BlockControls>,
			// Show the block controls on focus
			<Inspector
				{ ...{ setAttributes, ...this.props } }
			/>,
			// Show the block markup in the editor
			<ProfileBox { ...this.props }>
				<AvatarColumn { ...this.props }>
					<div className="qb-profile-image-square">
						<MediaUpload
							buttonProps={ {
								className: 'change-image'
							} }
							onSelect={ ( img ) => setAttributes(
								{
									profileImgID: img.id,
									profileImgURL: img.url,
								}
							) }
							allowed={ ALLOWED_MEDIA_TYPES }
							type="image"
							value={ profileImgID }
							render={ ( { open } ) => (
								<Button onClick={ open }>
									{ ! profileImgID ? icons.upload : <img
										className="profile-avatar"
										src={ profileImgURL }
										alt="avatar"
									/>  }
								</Button>
							) }
						>
						</MediaUpload>
					</div>
				</AvatarColumn>

				<div
					className={ classnames(
						'qb-profile-column qb-profile-content-wrap'
					) }
				>
					<RichText
						tagName="h2"
						placeholder={ __( 'Add name', 'qodeblock' ) }
						keepPlaceholderOnFocus
						value={ profileName }
						className='qb-profile-name'
						style={ {
							color: profileTextColor
						} }
						onChange={ ( value ) => setAttributes( { profileName: value } ) }
					/>

					<RichText
						tagName="p"
						placeholder={ __( 'Add title', 'qodeblock' ) }
						keepPlaceholderOnFocus
						value={ profileTitle }
						className='qb-profile-title'
						style={ {
							color: profileTextColor
						} }
						onChange={ ( value ) => setAttributes( { profileTitle: value } ) }
					/>

					<RichText
						tagName="div"
						className='qb-profile-text'
						multiline="p"
                        style={ {
                            color: profileTextColor
                        } }
						placeholder={ __( 'Add profile text...', 'qodeblock' ) }
						keepPlaceholderOnFocus
						value={ profileContent }
						formattingControls={ [ 'bold', 'italic', 'strikethrough', 'link' ] }
						onChange={ ( value ) => setAttributes( { profileContent: value } ) }
					/>

					<SocialIcons { ...this.props } />
				</div>
			</ProfileBox>
		];
	}
}

// Register the block
registerBlockType( 'qodeblock/qb-profile-box', {
	title: __( 'Author Profile', 'qodeblock' ),
	description: __( 'Add a profile box with bio info and social media links.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'author', 'qodeblock' ),
		__( 'profile', 'qodeblock' ),
		__( 'qodeblock', 'qodeblock' ),
	],
	// Setup the block attributes
	attributes: blockAttributes,

	// Render the block components
	edit: QBAuthorProfileBlock,

	// Save the block markup
	save: function( props ) {

		// Setup the attributes
		const { profileName, profileTitle, profileContent, profileAlignment, profileImgURL, profileImgID, profileFontSize, profileBackgroundColor, profileTextColor, profileLinkColor, twitter, facebook, instagram, pinterest, google, youtube, github, linkedin, email, website, profileAvatarShape } = props.attributes;

		return (
			// Save the block markup for the front end
			<ProfileBox { ...props }>

				{ profileImgURL && (
					<AvatarColumn { ...props }>
						<div className="qb-profile-image-square">
							<img
								className="qb-profile-avatar"
								src={ profileImgURL }
								alt="avatar"
							/>
						</div>
					</AvatarColumn>
				) }

				<div
					className={ classnames(
						'qb-profile-column qb-profile-content-wrap'
					) }
				>
					{ profileName && (
						<RichText.Content
							tagName="h2"
							className="qb-profile-name"
							style={ {
								color: profileTextColor
							} }
							value={ profileName }
						/>
					) }

					{ profileTitle && (
						<RichText.Content
							tagName="p"
							className="qb-profile-title"
							style={ {
								color: profileTextColor
							} }
							value={ profileTitle }
						/>
					) }

					{ profileContent && (
						<RichText.Content
							tagName="div"
							className="qb-profile-text"
                            style={ {
                                color: profileTextColor
                            } }
							value={ profileContent }
						/>
					) }

					<SocialIcons { ...props } />
				</div>
			</ProfileBox>
		);
	},
} );
