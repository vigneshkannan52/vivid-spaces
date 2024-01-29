/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Internal dependencies
 */
import Edit from './components/edit';
import './styles/style.scss';
import './styles/editor.scss';

// Import the element creator function (React abstraction layer)
const el = wp.element.createElement;

const iconEl = el('svg', { width: 25, height: 20 },
    el('path', { fill:"#2A74ED",d:"m9.999601,11.163567c-1.560245,0 -9.598741,-6.860773 -9.598741,-6.860773l0,-0.753847c0,-0.93406 0.715811,-1.692138 1.599391,-1.692138l15.9987,0c0.884378,0 1.60019,0.758078 1.60019,1.692138l-0.012782,0.846069c0,0 -7.951416,6.768552 -9.586757,6.768552zm0,2.32669c1.710437,0 9.586757,-6.557035 9.586757,-6.557035l0.012782,10.152828c0,0.93406 -0.715811,1.692138 -1.60019,1.692138l-15.9987,0c-0.882781,0 -1.599391,-0.758078 -1.599391,-1.692138l0.012782,-10.152828c-0.000799,0 8.025714,6.557035 9.585959,6.557035z" } )
);

registerBlockType(
	'qodeblock/newsletter',
	{
		title: __( 'Email newsletter', 'qodeblock' ),
		description: __( 'Add an email newsletter sign-up form.', 'qodeblock' ),
		category: 'qodeblock',
		icon: iconEl,
		keywords: [
			__( 'Mailchimp', 'qodeblock' ),
			__( 'Subscribe', 'qodeblock' ),
			__( 'Newsletter', 'qodeblock' ),
		],
		edit: Edit,
		save: () => {
			return null;
		}
	},
);
