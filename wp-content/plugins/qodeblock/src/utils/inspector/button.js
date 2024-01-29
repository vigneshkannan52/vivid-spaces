const { __ } = wp.i18n;
const { Fragment } = wp.element;
const {
	SelectControl,
	ToggleControl,
} = wp.components;
const {
	PanelColorSettings,
} = wp.editor;


export default function ButtonSettings( props ) {
	const {
		enableButtonBackgroundColor,
		buttonBackgroundColor,
		onChangeButtonColor = () => {},
		enableButtonTextColor,
		buttonTextColor,
		onChangeButtonTextColor = () => {},
		enableButtonSize,
		buttonSize,
		onChangeButtonSize = () => {},
		enableButtonShape,
		buttonShape,
		onChangeButtonShape = () => {},
		enableButtonTarget,
		buttonTarget,
		onChangeButtonTarget = () => {},
	} = props;

	// Button size values
	const buttonSizeOptions = [
		{ value: 'qb-button-size-small', label: __( 'Small', 'qodeblock' ) },
		{ value: 'qb-button-size-medium', label: __( 'Medium', 'qodeblock' ) },
		{ value: 'qb-button-size-large', label: __( 'Large', 'qodeblock' ) },
		{ value: 'qb-button-size-extralarge', label: __( 'Extra Large', 'qodeblock' ) },
	];

	// Button shape
	const buttonShapeOptions = [
		{ value: 'qb-button-shape-square', label: __( 'Square', 'qodeblock' ) },
		{ value: 'qb-button-shape-rounded', label: __( 'Rounded Square', 'qodeblock' ) },
		{ value: 'qb-button-shape-circular', label: __( 'Circular', 'qodeblock' ) },
	];

	return (
		<Fragment>
			{ enableButtonTarget != false && (
				<ToggleControl
					label={ __( 'Open link in new window', 'qodeblock' ) }
					checked={ buttonTarget }
					onChange={ onChangeButtonTarget }
				/>
			) }
			{ enableButtonSize != false && (
				<SelectControl
					selected={ buttonSize }
					label={ __( 'Button Size', 'qodeblock' ) }
					value={ buttonSize }
					options={ buttonSizeOptions.map( ({ value, label }) => ( {
						value: value,
						label: label,
					} ) ) }
					onChange={ onChangeButtonSize }
				/>
			) }
			{ enableButtonShape != false && (
				<SelectControl
					label={ __( 'Button Shape', 'qodeblock' ) }
					value={ buttonShape }
					options={ buttonShapeOptions.map( ({ value, label }) => ( {
						value: value,
						label: label,
					} ) ) }
					onChange={ onChangeButtonShape }
				/>
			) }
			{ enableButtonBackgroundColor != false && (
				<PanelColorSettings
					title={ __( 'Button Background Color', 'qodeblock' ) }
					initialOpen={ false }
					colorSettings={ [ {
						value: buttonBackgroundColor,
						onChange: onChangeButtonColor,
						label: __( 'Button Background Color', 'qodeblock' ),
					} ] }
				>
				</PanelColorSettings>
			) }
			{ enableButtonTextColor != false && (
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
			) }
		</Fragment>
	);
}
