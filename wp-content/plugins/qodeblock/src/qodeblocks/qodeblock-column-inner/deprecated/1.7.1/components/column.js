/**
 * Column wrapper component.
 */

/**
 * WordPress dependencies.
 */
const { Component } = wp.element;

/**
 * External dependencies.
 */
import classnames from 'classnames';

/**
 * Create a Columns wrapper Component.
 */
export default class Column_1_7_1 extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	render() {

		const {
			attributes,
		} = this.props;

		/* Setup the margin styles. */
		let marginStyle;

		if ( attributes.marginSync ) {
			marginStyle = {
				marginTop: attributes.margin > 0 ? attributes.margin + attributes.marginUnit : null,
				marginBottom: attributes.margin > 0 ? attributes.margin + attributes.marginUnit : null
			}
		} else {
			marginStyle = {
				marginTop: attributes.marginTop > 0 ? attributes.marginTop + attributes.marginUnit : null,
				marginBottom: attributes.marginBottom > 0 ? attributes.marginBottom + attributes.marginUnit : null,
			}
		}

		/* Setup the padding styles. */
		let paddingStyle;

		if ( attributes.paddingSync ) {
			paddingStyle = {
				padding: attributes.padding > 0 ? attributes.padding + attributes.paddingUnit: null,
			}
		} else {
			paddingStyle = {
				paddingTop: attributes.paddingTop > 0 ? attributes.paddingTop + attributes.paddingUnit : null,
				paddingRight: attributes.paddingRight > 0 ? attributes.paddingRight + attributes.paddingUnit : null,
				paddingBottom: attributes.paddingBottom > 0 ? attributes.paddingBottom + attributes.paddingUnit : null,
				paddingLeft: attributes.paddingLeft > 0 ? attributes.paddingLeft + attributes.paddingUnit : null,
			}
		}

		/* Misc styles. */
		const styles = {
			backgroundColor: this.props.backgroundColorValue ? this.props.backgroundColorValue : null,
			color: this.props.textColorValue ? this.props.textColorValue : null,
			textAlign: attributes.textAlign ? attributes.textAlign : null,
		}

		/* Setup the background color class. */
		let backgroundColorClass;

		if (attributes.customBackgroundColor) {
			backgroundColorClass = 'qb-has-custom-background-color';
		} else {
			backgroundColorClass = attributes.backgroundColor ? 'has-' + attributes.backgroundColor + '-background-color' : null;
		}

		/* Setup the text color class. */
		let textColorClass;

		if (attributes.customTextColor) {
			textColorClass = 'qb-has-custom-text-color';
		} else {
			textColorClass = attributes.textColor ? 'has-' + attributes.textColor + '-color' : null;
		}

		return (
			<div
				className={ classnames(
					'qb-block-layout-column',
					attributes.columnVerticalAlignment ? 'qb-is-vertically-aligned-' + attributes.columnVerticalAlignment : null
				) }
			>
				<div
					className={ classnames(
						'qb-block-layout-column-inner',
						backgroundColorClass,
						textColorClass,
					) }
					style={ Object.assign( marginStyle, paddingStyle, styles ) }
				>
					{ this.props.children }
				</div>
			</div>
		);
	}
}
