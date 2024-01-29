/**
 * Inspector Controls
 */

// Setup the block
const { __ } = wp.i18n;
const {
	Component,
	Fragment,
} = wp.element;

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
	RangeControl,
	ToggleControl,
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

		// Setup the attributes
		const {
			attributes: {
				spacerHeight,
				spacerDivider,
				spacerDividerStyle,
				spacerDividerColor,
				spacerDividerHeight
			},
			setAttributes
		} = this.props;

		// Button size values
		const spacerStyleOptions = [
			{ value: 'qb-divider-solid', label: __( 'Solid', 'qodeblock' ) },
			{ value: 'qb-divider-dashed', label: __( 'Dashed', 'qodeblock' ) },
			{ value: 'qb-divider-dotted', label: __( 'Dotted', 'qodeblock' ) },
		];

		// Divider color
		const dividerColor = [
			{ color: '#ddd', name: 'white' },
			{ color: '#333', name: 'black' },
			{ color: '#3373dc', name: 'royal blue' },
			{ color: '#22d25f', name: 'green' },
			{ color: '#ffdd57', name: 'yellow' },
			{ color: '#ff3860', name: 'pink' },
			{ color: '#7941b6', name: 'purple' },
		];

		// Update color values
		const onChangeDividerColor = value => setAttributes( { spacerDividerColor: value } );

		return (
		<InspectorControls key="inspector">
			<PanelBody>
				<RangeControl
					label={ __( 'Spacer Height', 'qodeblock' ) }
					value={ spacerHeight || '' }
					onChange={ ( value ) => this.props.setAttributes( { spacerHeight: value } ) }
					min={ 50 }
					max={ 600 }
				/>

				<ToggleControl
					label={ __( 'Add Divider', 'qodeblock' ) }
					checked={ spacerDivider }
					onChange={ () => this.props.setAttributes( { spacerDivider: ! spacerDivider } ) }
				/>
			</PanelBody>
			{ spacerDivider ?
				<Fragment>
					<PanelBody>
						<SelectControl
							label={ __( 'Divider Style', 'qodeblock' ) }
							value={ spacerDividerStyle }
							options={ spacerStyleOptions.map( ({ value, label }) => ( {
								value: value,
								label: label,
							} ) ) }
							onChange={ ( value ) => { this.props.setAttributes( { spacerDividerStyle: value } ) } }
						/>

						<RangeControl
							label={ __( 'Divider Height', 'qodeblock' ) }
							value={ spacerDividerHeight || '' }
							onChange={ ( value ) => this.props.setAttributes( { spacerDividerHeight: value } ) }
							min={ 1 }
							max={ 5 }
						/>
					</PanelBody>
					<PanelColorSettings
						title={ __( 'Divider Color', 'qodeblock' ) }
						initialOpen={ false }
						colorSettings={ [ {
							colors: dividerColor,
							value: spacerDividerColor,
							onChange: onChangeDividerColor,
							label: __( 'Divider Color', 'qodeblock' )
						} ] }
					>
					</PanelColorSettings>
				</Fragment>
				: null }
		</InspectorControls>
		);
	}
}
