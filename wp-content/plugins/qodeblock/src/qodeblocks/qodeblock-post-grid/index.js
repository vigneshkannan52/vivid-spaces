/**
 * BLOCK: Qodeblock Post and Page Grid
 */

// Import block dependencies and components
import edit from './components/edit';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// Components
const { __ } = wp.i18n;

// Register block controls
const {
	registerBlockType,
} = wp.blocks;

// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m0,0l8.741061,0l0,8.696703l-8.741061,0l0,-8.696703zm11.238507,0l8.741061,0l0,8.696703l-8.741061,0l0,-8.696703zm-11.238507,11.181475l8.741061,0l0,8.696703l-8.741061,0l0,-8.696703zm11.238507,0l8.741061,0l0,8.696703l-8.741061,0l0,-8.696703zm0,0" } )
);

// Register alignments
const validAlignments = [ 'center', 'wide', 'full' ];

// Register the block
registerBlockType( 'qodeblock/qb-post-grid', {
	title: __( 'Post and Page Grid', 'qodeblock' ),
	description: __( 'Add a grid or list of customizable posts or pages.', 'qodeblock' ),
	icon: iconEl,
	category: 'qodeblock',
	keywords: [
		__( 'post', 'qodeblock' ),
		__( 'page', 'qodeblock' ),
		__( 'grid', 'qodeblock' ),
	],

	getEditWrapperProps( attributes ) {
		const { align } = attributes;
		if ( -1 !== validAlignments.indexOf( align ) ) {
			return { 'data-align': align };
		}
	},

	edit,

	// Render via PHP
	save() {
		return null;
	},
} );
