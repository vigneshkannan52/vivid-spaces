/**
 * Button Wrapper
 */

// Setup the block
const { Component } = wp.element;

// Import block dependencies and components
import classnames from 'classnames';

/**
 * Create a Button wrapper Component
 */
export default class Spacer extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	render() {

		// Setup the attributes
		const { spacerHeight, spacerDivider, spacerDividerStyle, spacerDividerColor, spacerDividerHeight } = this.props.attributes;

		return (	
			<div 
				style={ {
					color: spacerDividerColor
				} }
				className={ classnames(
					this.props.className,
					'qb-block-spacer',
					spacerDividerStyle,
					{ 'qb-spacer-divider': spacerDivider },
					'qb-divider-size-' + spacerDividerHeight,
				) }
			>
				{ this.props.children }
			</div>
		);
	}
}
