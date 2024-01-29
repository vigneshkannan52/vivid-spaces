/**
 * Handles dismissible notices from the Notice block.
 */

document.addEventListener( 'DOMContentLoaded', function() {

	var notices = document.querySelectorAll('.qb-block-notice.qb-dismissable[data-id]' );

	notices.forEach( function( element ) {

		var uid = element.getAttribute( 'data-id' );

		if ( ! localStorage.getItem('notice-' + uid ) ) {
			element.style.display = 'block';
		}

		var dismissible = element.querySelector( '.qb-notice-dismiss' );

		if ( dismissible ) {
			dismissible.addEventListener( 'click', function( event ) {
				event.preventDefault();
				localStorage.setItem( 'notice-' + uid, '1' );
				element.style.display = '';
			} );
		}
	} );
} );
