/**
 * BLOCK: Qodeblock Button
 */

// Import block dependencies and components
import classnames from 'classnames';
import Inspector from './components/inspector';
import CustomButton from './components/button';

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
	URLInput
} = wp.editor;

// Register components
const {
	IconButton,
	Dashicon,
} = wp.components;

// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m19.855814,8.041525l0,4.492201c0,1.234232 -1.100953,2.178717 -2.446562,2.178717l-4.893124,0c-0.672805,0 -1.223281,-0.505373 -1.223281,-1.12305s0.550476,-1.12305 1.223281,-1.12305l3.669843,0c0.672805,0 1.223281,-0.439113 1.223281,-1.055667l0,-2.2461c0,-0.617678 -0.550476,-1.190433 -1.223281,-1.190433l-3.009272,0l-0.819598,1.12305l1.382308,0c0.672805,0 1.223281,0.505373 1.223281,1.12305s-0.550476,1.12305 -1.223281,1.12305l-3.009272,0l-2.091811,2.89747l-0.012233,-0.028076c-0.220191,0.302101 -0.574942,0.499757 -1.003091,0.499757l-4.893124,0c-1.357842,0 -2.446562,-0.944485 -2.446562,-2.178717l0,-4.492201c0,-1.235355 1.100953,-2.313483 2.446562,-2.313483l4.893124,0c0.672805,0 1.223281,0.505373 1.223281,1.12305s-0.550476,1.12305 -1.223281,1.12305l-3.669843,0c-0.672805,0 -1.223281,0.572756 -1.223281,1.190433l0,2.2461c0,0.616555 0.550476,1.055667 1.223281,1.055667l3.009272,0l0.819598,-1.12305l-1.382308,0c-0.672805,0 -1.223281,-0.505373 -1.223281,-1.12305s0.550476,-1.12305 1.223281,-1.12305l3.009272,0l2.091811,-2.830087l0.012233,-0.006738c0.220191,-0.302101 0.574942,-0.532326 1.003091,-0.532326l4.893124,0c1.345609,0 2.446562,1.065775 2.446562,2.313483z" } )
);

class QBButtonBlock extends Component {
	render() {

		// Setup the attributes
		const { attributes: { buttonText, buttonUrl, buttonAlignment, buttonBackgroundColor, buttonTextColor, buttonSize, buttonShape, buttonTarget }, isSelected, className, setAttributes } = this.props;

		return [
			// Show the alignment toolbar on focus
			<BlockControls key="controls">
				<AlignmentToolbar
					value={ buttonAlignment }
					onChange={ ( value ) => {
						setAttributes( { buttonAlignment: value } );
					} }
				/>
			</BlockControls>,
			// Show the block controls on focus
			<Inspector
				{ ...this.props }
			/>,
			// Show the button markup in the editor
			<CustomButton { ...this.props }>
				<RichText
					tagName="span"
					placeholder={ __( 'Button text...', 'qodeblock' ) }
					keepPlaceholderOnFocus
					value={ buttonText }
					formattingControls={ [] }
					className={ classnames(
						'qb-button',
						buttonShape,
						buttonSize,
					) }
					style={ {
						color: buttonTextColor,
						backgroundColor: buttonBackgroundColor,
					} }
					onChange={ (value) => setAttributes( { buttonText: value } ) }
				/>
			</CustomButton>,
			isSelected && (
				<form
					key="form-link"
					className={ `blocks-button__inline-link qb-button-${buttonAlignment}`}
					onSubmit={ event => event.preventDefault() }
					style={ {
						textAlign: buttonAlignment,
					} }
				>
					<Dashicon icon={ 'admin-links' } />
					<URLInput
						className="button-url"
						value={ buttonUrl }
						onChange={ ( value ) => setAttributes( { buttonUrl: value } ) }
					/>
					<IconButton
						icon="editor-break"
						label={ __( 'Apply', 'qodeblock' ) }
						type="submit"
					/>
				</form>
			)
		];
	}
}

// Register the block
registerBlockType( 'qodeblock/qb-button', {
	title: __( 'Button', 'qodeblock' ),
	description: __( 'Add a customizable button.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'button', 'qodeblock' ),
		__( 'link', 'qodeblock' ),
		__( 'qodeblock', 'qodeblock' ),
	],
	attributes: {
		buttonText: {
			type: 'string',
		},
		buttonUrl: {
			type: 'string',
            source: 'attribute',
            selector: 'a',
            attribute: 'href',
		},
		buttonAlignment: {
			type: 'string',
		},
		buttonBackgroundColor: {
			type: 'string'
		},
		buttonTextColor: {
			type: 'string'
		},
		buttonSize: {
			type: 'string',
			default: 'qb-button-size-small'
		},
		buttonShape: {
			type: 'string',
			default: 'qb-button-shape-rounded'
		},
		buttonTarget: {
			type: 'boolean',
			default: false
		},
	},

	// Render the block components
	edit: QBButtonBlock,

	// Save the attributes and markup
	save: function( props ) {

		// Setup the attributes
		const { buttonText, buttonUrl, buttonAlignment, buttonBackgroundColor, buttonTextColor, buttonSize, buttonShape, buttonTarget } = props.attributes;

		// Save the block markup for the front end
		return (
			<CustomButton { ...props }>
				{	// Check if there is button text and output
					buttonText && (
					<a
						href={ buttonUrl }
						target={ buttonTarget ? '_blank' : null }
						rel={ buttonTarget ? 'noopener noreferrer' : null }
						className={ classnames(
							'qb-button',
							buttonShape,
							buttonSize,
						) }
						style={ {
							color: buttonTextColor,
							backgroundColor: buttonBackgroundColor,
						} }
					>
						<RichText.Content
							value={ buttonText }
						/>
					</a>
				) }
                <style>

				</style>
			</CustomButton>
		);
	},
} );