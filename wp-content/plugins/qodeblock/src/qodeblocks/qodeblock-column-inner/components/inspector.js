/**
 * Internal dependencies.
 */
import Margin from './../../../utils/components/margin';
import Padding from './../../../utils/components/padding';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { Component } = wp.element;
const { compose } = wp.compose;
const {
	InspectorControls,
	PanelColorSettings,
	withColors,
	ContrastChecker,
} = wp.editor;
const {
	PanelBody,
	ToggleControl,
	SelectControl,
} = wp.components;

/**
 * Create an Inspector Controls wrapper Component.
 */
class Inspector extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	render() {

		const {
			backgroundColor,
			setBackgroundColor,
			textColor,
			setTextColor,
			attributes,
			setAttributes,
		} = this.props;

		/* CSS Units. */
		const cssUnits = [
			{ value: 'px', label: __( 'Pixel (px)', 'qodeblock' ) },
			{ value: '%', label: __( 'Percent (%)', 'qodeblock' ) },
			{ value: 'em', label: __( 'Em (em)', 'qodeblock' ) },
        ];

		return (
		<InspectorControls key="inspector">
			<PanelBody
					title={ __( 'Margin and Padding', 'qodeblock' ) }
					initialOpen={ false }
				>
				<SelectControl
					label={ __( 'Margin Unit', 'qodeblock' ) }
					help={ __( 'Choose between pixel, percent, or em units.', 'qodeblock' ) }
					options={ cssUnits }
					value={ attributes.marginUnit }
					onChange={ ( value ) => this.props.setAttributes( { marginUnit: value } ) }
				/>
				<ToggleControl
					label={ __( 'Sync Margin', 'qodeblock' ) }
					help={ __( 'Top and bottom margins will have the same value.', 'qodeblock' ) }
					checked={ attributes.marginSync }
					onChange={ () => this.props.setAttributes( { marginSync: ! attributes.marginSync } ) }
				/>
				{ ! attributes.marginSync ?
					<Margin
						/* Margin top. */
						marginEnableTop={ true }
						marginTop={ attributes.marginTop }
						marginTopMin="0"
						marginTopMax="200"
						onChangeMarginTop={ marginTop => setAttributes( { marginTop } ) }
						/* Margin bottom. */
						marginEnableBottom={ true }
						marginBottom={ attributes.marginBottom }
						marginBottomMin="0"
						marginBottomMax="200"
						onChangeMarginBottom={ marginBottom => setAttributes( { marginBottom } ) }
					/>
				:
					<Margin
						/* Margin top/bottom. */
						marginEnableVertical={ true }
						marginVerticalLabel={ __( 'Margin Top/Bottom', 'qodeblock' ) }
						marginVertical={ attributes.margin }
						marginVerticalMin="0"
						marginVerticalMax="200"
						onChangeMarginVertical={ margin => setAttributes( { margin } ) }
					/>
				}

				<hr />

				<SelectControl
					label={ __( 'Padding Unit', 'qodeblock' ) }
					help={ __( 'Choose between pixel, percent, or em units.', 'qodeblock' ) }
					options={ cssUnits }
					value={ attributes.paddingUnit }
					onChange={ ( value ) => this.props.setAttributes( { paddingUnit: value } ) }
				/>
				<ToggleControl
					label={ __( 'Sync Padding', 'qodeblock' ) }
					help={ __( 'Padding on all sides will have the same value.', 'qodeblock' ) }
					checked={ attributes.paddingSync }
					onChange={ () => this.props.setAttributes( { paddingSync: ! attributes.paddingSync } ) }
				/>
				{ ! attributes.paddingSync ?
					<Padding
						/* Padding top. */
						paddingEnableTop={ true }
						paddingTop={ attributes.paddingTop }
						paddingTopMin="0"
						paddingTopMax="200"
						onChangePaddingTop={ paddingTop => setAttributes( { paddingTop } ) }
						/* Padding right. */
						paddingEnableRight={ true }
						paddingRight={ attributes.paddingRight }
						paddingRightMin="0"
						paddingRightMax="200"
						onChangePaddingRight={ paddingRight => setAttributes( { paddingRight } ) }
						/* Padding bottom. */
						paddingEnableBottom={ true }
						paddingBottom={ attributes.paddingBottom }
						paddingBottomMin="0"
						paddingBottomMax="200"
						onChangePaddingBottom={ paddingBottom => setAttributes( { paddingBottom } ) }
						/* Padding left. */
						paddingEnableLeft={ true }
						paddingLeft={ attributes.paddingLeft }
						paddingLeftMin="0"
						paddingLeftMax="200"
						onChangePaddingLeft={ paddingLeft => setAttributes( { paddingLeft } ) }
					/>
				:
					<Padding
						/* Padding. */
						paddingEnable={ true }
						padding={ attributes.padding }
						paddingMin="0"
						paddingMax="200"
						onChangePadding={ padding => setAttributes( { padding } ) }
					/>
				}
			</PanelBody>

			<PanelColorSettings
				title={ __( 'Color', 'qodeblock' ) }
				initialOpen={ false }
				colorSettings={ [
					{
						value: backgroundColor.color,
						onChange: setBackgroundColor,
						label: __( 'Background Color', 'qodeblock' ),
					},
					{
						value: textColor.color,
						onChange: setTextColor,
						label: __( 'Text Color', 'qodeblock' ),
					}
			 	] }
			>
				<ContrastChecker
					{ ...{
						textColor: textColor.color,
						backgroundColor: backgroundColor.color,
					} }
				/>
			</PanelColorSettings>
		</InspectorControls>
		);
	}
}

export default compose( [
	withColors(
		'backgroundColor',
		{ textColor: 'color' },
	),
] )( Inspector );
