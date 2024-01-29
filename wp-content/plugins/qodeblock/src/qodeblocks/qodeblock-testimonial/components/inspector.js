/**
 * Inspector Controls
 */

// Setup the block
const { __ } = wp.i18n;
const { Component } = wp.element;

// Import block components
const {
	InspectorControls,
	BlockDescription,
	ColorPalette,
	PanelColorSettings,
} = wp.editor;

// Import Inspector components
const {
	Toolbar,
	Button,
	PanelBody,
	PanelRow,
	FormToggle,
	RangeControl,
	SelectControl,
} = wp.components;

/**
 * Create an Inspector Controls wrapper Component
 */
export default class Inspector extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	render() {

		// Cite Alignment Options
		const citeAlignOptions = [
			{ value: 'left-aligned', label: __( 'Left Aligned', 'qodeblock' ) },
			{ value: 'right-aligned', label: __( 'Right Aligned', 'qodeblock' ) },
		];

		// Setup the attributes
		const { attributes: { testimonialName, testimonialTitle, testimonialContent, testimonialAlignment, testimonialImgURL, testimonialImgID, testimonialBackgroundColor, testimonialTextColor, testimonialFontSize, testimonialCiteAlign }, isSelected, className, setAttributes } = this.props;

		// Update color values
		const onChangeBackgroundColor = value => setAttributes( { testimonialBackgroundColor: value } );
		const onChangeTextColor = value => setAttributes( { testimonialTextColor: value } );

		return (
		<InspectorControls key="inspector">
			<PanelBody>
				<RangeControl
					label={ __( 'Font Size', 'qodeblock' ) }
					value={ testimonialFontSize }
					onChange={ ( value ) => this.props.setAttributes( { testimonialFontSize: value } ) }
					min={ 14 }
					max={ 24 }
					step={ 1 }
				/>

				<SelectControl
					label={ __( 'Cite Alignment', 'qodeblock' ) }
					description={ __( 'Left or right align the cite name and title.', 'qodeblock' ) }
					options={ citeAlignOptions }
					value={ testimonialCiteAlign }
					onChange={ ( value ) => this.props.setAttributes( { testimonialCiteAlign: value } ) }
				/>
			</PanelBody>
			<PanelColorSettings
				title={ __( 'Background Color', 'qodeblock' ) }
				initialOpen={ false }
				colorSettings={ [ {
					value: testimonialBackgroundColor,
					onChange: onChangeBackgroundColor,
					label: __( 'Background Color', 'qodeblock' ),
				} ] }
			>
			</PanelColorSettings>

			<PanelColorSettings
				title={ __( 'Text Color', 'qodeblock' ) }
				initialOpen={ false }
				colorSettings={ [ {
					value: testimonialTextColor,
					onChange: onChangeTextColor,
					label: __( 'Text Color', 'qodeblock' ),
				} ] }
			>
			</PanelColorSettings>
		</InspectorControls>
		);
	}
}
