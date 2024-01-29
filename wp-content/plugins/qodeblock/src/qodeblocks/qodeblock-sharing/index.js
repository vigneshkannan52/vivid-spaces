/**
 * BLOCK: Qodeblock Sharing
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import ShareLinks from './components/sharing';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// Components
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
} = wp.editor;

// Register components
const {
	Button,
	withFallbackStyles,
	IconButton,
	Dashicon,
} = wp.components;

// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m16.303138,12.644868c-1.293623,0 -2.430547,0.679951 -3.073187,1.7001l-6.037219,-3.123842c0.135617,-0.379635 0.210066,-0.788059 0.210066,-1.213639c0,-0.407685 -0.068821,-0.799299 -0.193626,-1.165328l6.101646,-3.04896c0.654636,0.95138 1.751523,1.576808 2.99232,1.576808c2.000837,0 3.628641,-1.625464 3.628641,-3.623317c0,-1.997902 -1.627803,-3.623317 -3.628641,-3.623317s-3.628641,1.625415 -3.628641,3.623317c0,0.407586 0.068771,0.7992 0.193577,1.16518l-6.101646,3.04896c-0.654686,-0.95133 -1.751572,-1.57671 -2.992271,-1.57671c-2.000837,0 -3.628641,1.625415 -3.628641,3.623317c0,1.997853 1.627803,3.623268 3.628641,3.623268c1.222482,0 2.304853,-0.607288 2.962649,-1.535153l6.085996,3.14918c-0.095924,0.324768 -0.148305,0.667972 -0.148305,1.023353c0,1.997902 1.627803,3.623317 3.628641,3.623317c2.000788,0 3.628641,-1.625415 3.628641,-3.623317c0,-1.997853 -1.627704,-3.623218 -3.628641,-3.623218z" } )
);

// Register the block
registerBlockType( 'qodeblock/qb-sharing', {
	title: __( 'Sharing Icons', 'qodeblock' ),
	description: __( 'Add sharing buttons to your posts and pages.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'sharing', 'qodeblock' ),
		__( 'social', 'qodeblock' ),
		__( 'qodeblock', 'qodeblock' ),
	],

	// Render the block components
	edit: props => {

		// Setup the props
		const {
			attributes,
			isSelected,
			editable,
			className,
			setAttributes
		} = props;

		const {
			twitter,
			facebook,
			google,
			linkedin,
			pinterest,
			email,
			reddit,
			shareAlignment,
			shareButtonStyle,
			shareButtonShape,
			shareButtonColor,
		} = props.attributes;

		return [
			// Show the alignment toolbar on focus
			<BlockControls key="controls">
				<AlignmentToolbar
					value={ shareAlignment }
					onChange={ ( value ) => {
						setAttributes( { shareAlignment: value } );
					} }
				/>
			</BlockControls>,
			// Show the block controls on focus
			<Inspector
				{ ...props }
			/>,
			// Show the button markup in the editor
			<ShareLinks { ...props }>
				<ul className="qb-share-list">
				{ twitter &&
					<li>
						<a className='qb-share-twitter'>
							<i className="fab fa-twitter"></i>
							<span className={ 'qb-social-text' }>
								{ __( 'Share on Twitter', 'qodeblock' ) }
							</span>
						</a>
					</li>
				}

				{ facebook &&
					<li>
						<a className='qb-share-facebook'>
							<i className="fab fa-facebook-f"></i>
							<span className={ 'qb-social-text' }>
								{ __( 'Share on Facebook', 'qodeblock' ) }
							</span>
						</a>
					</li>
				}

				{ google &&
					<li>
						<a className='qb-share-google'>
							<i className="fab fa-google"></i>
							<span className={ 'qb-social-text' }>
								{ __( 'Share on Google', 'qodeblock' ) }
							</span>
						</a>
					</li>
				}

				{ pinterest &&
					<li>
						<a className='qb-share-pinterest'>
							<i className="fab fa-pinterest-p"></i>
							<span className={ 'qb-social-text' }>
								{ __( 'Share on Pinterest', 'qodeblock' ) }
							</span>
						</a>
					</li>
				}

				{ linkedin &&
					<li>
						<a className='qb-share-linkedin'>
							<i className="fab fa-linkedin"></i>
							<span className={ 'qb-social-text' }>
								{ __( 'Share on LinkedIn', 'qodeblock' ) }
							</span>
						</a>
					</li>
				}

				{ reddit &&
					<li>
						<a className='qb-share-reddit'>
							<i className="fab fa-reddit-alien"></i>
							<span className={ 'qb-social-text' }>
								{ __( 'Share on reddit', 'qodeblock' ) }
							</span>
						</a>
					</li>
				}

				{ email &&
					<li>
						<a className='qb-share-email'>
							<i className="fas fa-envelope"></i>
							<span className={ 'qb-social-text' }>
								{ __( 'Share via Email', 'qodeblock' ) }
							</span>
						</a>
					</li>
				}
				</ul>
			</ShareLinks>
		];
	},

	// Render via PHP
	save() {
		return null;
	},
} );
