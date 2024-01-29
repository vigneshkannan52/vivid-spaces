/**
 * BLOCK: Qodeblock Notice
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import NoticeBox from './components/notice';
import DismissButton from './components/button';
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
} = wp.editor;


// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m-0.240653,-0.084637l0,20.081412l20.31869,0l0,-20.081412l-20.31869,0zm8.309328,3.428098l3.679308,0l0,2.954377l-3.679308,0l0,-2.954377zm5.407819,13.230438l-6.948382,0l0,-2.226627l1.540563,0l0,-4.268505l-0.883253,0l0,-2.041677l4.562765,0l0,6.310182l1.728511,0l0,2.226627l-0.000203,0z" } )
);

class QBNoticeBlock extends Component {

	render() {

		// Setup the attributes
		const {
			attributes: {
				noticeTitle,
				noticeContent,
				noticeAlignment,
				noticeBackgroundColor,
				noticeTitleColor,
				noticeDismiss
			},
			setAttributes
		} = this.props;

		return [
			// Show the alignment toolbar on focus
			<BlockControls key="controls">
				<AlignmentToolbar
					value={ noticeAlignment }
					onChange={ ( value ) => setAttributes( { noticeAlignment: value } ) }
				/>
			</BlockControls>,
			// Show the block controls on focus
			<Inspector
				{ ...{ setAttributes, ...this.props } }
			/>,
			// Show the block markup in the editor
			<NoticeBox { ...this.props }>
				{	// Check if the notice is dismissible and output the button
					( noticeDismiss && noticeDismiss === 'qb-dismissable' ) && (
					<DismissButton { ...this.props }>
						{ icons.dismiss }
					</DismissButton>
				) }

				<RichText
					tagName="p"
					placeholder={ __( 'Notice Title', 'qodeblock' ) }
					keepPlaceholderOnFocus
					value={ noticeTitle }
					className={ classnames(
						'qb-notice-title'
					) }
					style={ {
						color: noticeTitleColor,
					} }
					onChange={ ( value ) => setAttributes( { noticeTitle: value } ) }
				/>

				<RichText
					tagName="div"
					multiline="p"
					placeholder={ __( 'Add notice text...', 'qodeblock' ) }
					value={ noticeContent }
					className={ classnames(
						'qb-notice-text'
					) }
					style={ {
						borderColor: noticeBackgroundColor,
					} }
					onChange={ ( value ) => setAttributes( { noticeContent: value } ) }
				/>
			</NoticeBox>
		];
	}
}

// Register the block
registerBlockType( 'qodeblock/qb-notice', {
	title: __( 'Inline Notice', 'qodeblock' ),
	description: __( 'Add a stylized text notice.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'notice', 'qodeblock' ),
		__( 'message', 'qodeblock' ),
		__( 'qodeblock', 'qodeblock' ),
	],
	attributes: {
		noticeTitle: {
			type: 'string',
			selector: '.qb-notice-title',
		},
		noticeContent: {
			type: 'array',
			selector: '.qb-notice-text',
			source: 'children',
		},
		noticeAlignment: {
			type: 'string',
		},
		noticeBackgroundColor: {
			type: 'string',
			default: '#2A74ED'
		},
		noticeTextColor: {
			type: 'string',
		},
		noticeTitleColor: {
			type: 'string',
			default: '#fff'
		},
		noticeFontSize: {
			type: 'number',
			default: 16
		},
		noticeDismiss: {
            type: 'string',
            default: '',
        },
	},

	// Render the block components
	edit: QBNoticeBlock,

	// Save the attributes and markup
	save: function( props ) {

		// Setup the attributes
		const {
			noticeTitle,
			noticeContent,
			noticeBackgroundColor,
			noticeTitleColor,
			noticeDismiss
		} = props.attributes;

		// Save the block markup for the front end
		return (
			<NoticeBox { ...props }>
				{ ( noticeDismiss && noticeDismiss === 'qb-dismissable' ) && (
					<DismissButton { ...props }>
						{ icons.dismiss }
					</DismissButton>
				) }

				{ noticeTitle && (
					<div
						className="qb-notice-title"
						style={ {
							color: noticeTitleColor
						} }
					>
						<RichText.Content
							tagName="p"
							value={ noticeTitle }
						/>
					</div>
				) }

				{ noticeContent && (
					<RichText.Content
						tagName="div"
						className="qb-notice-text"
						style={ {
							borderColor: noticeBackgroundColor
						} }
						value={ noticeContent }
					/>
				) }
			</NoticeBox>
		);
	},
} );
