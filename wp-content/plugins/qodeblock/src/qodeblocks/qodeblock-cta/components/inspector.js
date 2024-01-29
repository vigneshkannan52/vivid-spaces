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
  MediaUpload,
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
	ToggleControl,
	IconButton,
} = wp.components;

/**
 * Create an Inspector Controls wrapper Component
 */
export default class Inspector extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	render() {

		// Setup the attributes
		const {
			buttonText,
			buttonUrl,
			buttonAlignment,
			buttonBackgroundColor,
			buttonTextColor,
			buttonSize,
			buttonShape,
			buttonTarget,
			ctaTitle,
			ctaText,
			titleFontSize,
			ctaTextFontSize,
			ctaBackgroundColor,
			ctaTextColor,
			dimRatio,
			imgURL,
			imgID,
			imgAlt,
		} = this.props.attributes;
		const { setAttributes } = this.props;

		// Button size values
		const buttonSizeOptions = [
			{ value: 'qb-button-size-small', label: __( 'Small' ) },
			{ value: 'qb-button-size-medium', label: __( 'Medium' ) },
			{ value: 'qb-button-size-large', label: __( 'Large' ) },
			{ value: 'qb-button-size-extralarge', label: __( 'Extra Large' ) },
		];

		// Button shape
		const buttonShapeOptions = [
			{ value: 'qb-button-shape-square', label: __( 'Square' ) },
			{ value: 'qb-button-shape-rounded', label: __( 'Rounded Square' ) },
			{ value: 'qb-button-shape-circular', label: __( 'Circular' ) },
		];

		// Change the image
		const onSelectImage = img => {
			setAttributes( {
				imgID: img.id,
				imgURL: img.url,
				imgAlt: img.alt,
			} );
		};

		// Clear the image
		const onRemoveImage = () => {
			setAttributes({
				imgID: null,
				imgURL: null,
				imgAlt: null,
			});
		}

		// Update color values
		const onChangeBackgroundColor = value => setAttributes( { ctaBackgroundColor: value } );
		const onChangeTextColor = value => setAttributes( { ctaTextColor: value } );
		const onChangeButtonColor = value => setAttributes( { buttonBackgroundColor: value } );
		const onChangeButtonTextColor = value => setAttributes( { buttonTextColor: value } );

		return (
		<InspectorControls key="inspector">
			<PanelBody title={ __( 'Text Options', 'qodeblock' ) } initialOpen={ true }>
				<RangeControl
					label={ __( 'Title Font Size', 'qodeblock' ) }
					value={ titleFontSize }
					onChange={ ( value ) => this.props.setAttributes( { titleFontSize: value } ) }
					min={ 24 }
					max={ 60 }
					step={ 2 }
				/>

				<RangeControl
					label={ __( 'Text Font Size', 'qodeblock' ) }
					value={ ctaTextFontSize }
					onChange={ ( value ) => this.props.setAttributes( { ctaTextFontSize: value } ) }
					min={ 14 }
					max={ 24 }
					step={ 2 }
				/>

				<PanelColorSettings
					title={ __( 'Text Color', 'qodeblock' ) }
					initialOpen={ false }
					colorSettings={ [ {
						value: ctaTextColor,
						onChange: onChangeTextColor,
						label: __( 'Text Color', 'qodeblock' ),
					} ] }
				>
				</PanelColorSettings>
			</PanelBody>

			<PanelBody title={ __( 'Background Options', 'qodeblock' ) } initialOpen={ false }>
				<p>{ __( 'Select a background image:', 'qodeblock' ) }</p>
				<MediaUpload
					onSelect={ onSelectImage }
					type="image"
					value={ imgID }
					render={ ( { open } ) => (
						<div>
							<IconButton
								className="qb-cta-inspector-media"
								label={ __( 'Edit image', 'qodeblock' ) }
								icon="format-image"
								onClick={ open }
							>
								{ __( 'Select Image', 'qodeblock' ) }
							</IconButton>

							{ imgURL && !! imgURL.length && (
								<IconButton
									className="qb-cta-inspector-media"
									label={ __( 'Remove Image', 'qodeblock' ) }
									icon="dismiss"
									onClick={ onRemoveImage }
								>
									{ __( 'Remove', 'qodeblock' ) }
								</IconButton>
							) }
						</div>
					) }
				>
				</MediaUpload>

				{ imgURL && !! imgURL.length && (
					<RangeControl
						label={ __( 'Image Opacity', 'qodeblock' ) }
						value={ dimRatio }
						onChange={ ( value ) => this.props.setAttributes( { dimRatio: value } ) }
						min={ 0 }
						max={ 100 }
						step={ 10 }
					/>
				) }

				<PanelColorSettings
					title={ __( 'Background Color', 'qodeblock' ) }
					initialOpen={ false }
					colorSettings={ [ {
						value: ctaBackgroundColor,
						onChange: onChangeBackgroundColor,
						label: __( 'Overlay Color', 'qodeblock' ),
					} ] }
				>
				</PanelColorSettings>
			</PanelBody>

			<PanelBody title={ __( 'Button Options', 'qodeblock' ) } initialOpen={ false }>
				<ToggleControl
					label={ __( 'Open link in new window', 'qodeblock' ) }
					checked={ buttonTarget }
					onChange={ () => this.props.setAttributes( { buttonTarget: ! buttonTarget } ) }
				/>

				<SelectControl
					label={ __( 'Button Size', 'qodeblock' ) }
					value={ buttonSize }
					options={ buttonSizeOptions.map( ({ value, label }) => ( {
						value: value,
						label: label,
					} ) ) }
					onChange={ ( value ) => { this.props.setAttributes( { buttonSize: value } ) } }
				/>

				<SelectControl
					label={ __( 'Button Shape', 'qodeblock' ) }
					value={ buttonShape }
					options={ buttonShapeOptions.map( ({ value, label }) => ( {
						value: value,
						label: label,
					} ) ) }
					onChange={ ( value ) => { this.props.setAttributes( { buttonShape: value } ) } }
				/>

				<PanelColorSettings
					title={ __( 'Button Color', 'qodeblock' ) }
					initialOpen={ false }
					colorSettings={ [ {
						value: buttonBackgroundColor,
						onChange: onChangeButtonColor,
						label: __( 'Button Color', 'qodeblock' ),
					} ] }
				>
				</PanelColorSettings>

				<PanelColorSettings
					title={ __( 'Button Text Color', 'qodeblock' ) }
					initialOpen={ false }
					colorSettings={ [ {
						value: buttonTextColor,
						onChange: onChangeButtonTextColor,
						label: __( 'Button Text Color', 'qodeblock' ),
					} ] }
				>
				</PanelColorSettings>
			</PanelBody>
		</InspectorControls>
		);
	}
}
