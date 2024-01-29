"use strict";

var $ = jQuery;

var QodeblockNewsletterSubmission = {

	init: function() {
		$( '.qb-newsletter-submit' ).on( 'click', function( event ) {

			event.preventDefault();

			wp.a11y.speak( qodeblock_newsletter_vars.l10n.a11y.submission_processing );

			var button = $( this );

			var button_text_original = button.val();

			button.val( qodeblock_newsletter_vars.l10n.button_text_processing ).prop( 'disabled', true );

			var form = $( this ).parents( 'form' );

			var nonce = button.parent().find( "[name='qb-newsletter-form-nonce']" ).val();

			var email = button.parent().find( "[name='qb-newsletter-email-address']" ).val();

			var provider = button.parent().find( "[name='qb-newsletter-mailing-list-provider']" ).val();

			var list = button.parent().find( "[name='qb-newsletter-mailing-list']" ).val();

			var successMessage = button.parent().find( "[name='qb-newsletter-success-message']" ).val();

			var errorMessageContainer = button.parents( '.qb-block-newsletter' ).find( '.qb-block-newsletter-errors' );

			var ampEndpoint = button.parent().find( "[name='qb-newsletter-amp-endpoint-request']" ).val();

			if ( ! email ) {
				setTimeout( function() {
					button.val( button_text_original ).prop( 'disabled', false );
					wp.a11y.speak( qodeblock_newsletter_vars.l10n.a11y.submission_failed );
				}, 400 );
				return;
			}

			if ( ! provider || ! list ) {
				form.html( '<p class="qb-newsletter-submission-message">' + qodeblock_newsletter_vars.l10n.invalid_configuration + '</p>' );
				return;
			}

			$.ajax( {
				data: {
					action: 'qodeblock_newsletter_submission',
					'qb-newsletter-email-address': email,
					'qb-newsletter-mailing-list-provider': provider,
					'qb-newsletter-mailing-list': list,
					'qb-newsletter-form-nonce': nonce,
					'qb-newsletter-success-message': successMessage,
					'qb-newsletter-amp-endpoint-request': ampEndpoint,
				},
				type: 'post',
				url: qodeblock_newsletter_vars.ajaxurl,
				success: function( response ) {
					if ( response.success ) {
						form.html( '<p class="qb-newsletter-submission-message">' + response.data.message + '</p>' );
						wp.a11y.speak( qodeblock_newsletter_vars.l10n.a11y.submission_succeeded );
					}

					if ( ! response.success ) {
						errorMessageContainer.html( '<p>' + response.data.message + '</p>' ).fadeIn();
						button.val( button_text_original ).prop( 'disabled', false );
						wp.a11y.speak( qodeblock_newsletter_vars.l10n.a11y.submission_failed );
					}

				},
				failure: function( response ) {
					errorMessageContainer.html( '<p>' + response.data.message + '</p>' ).fadeIn();
				}

			} );
		} );

		$( '.qb-newsletter-email-address-input' ).on( 'keyup', function( event ) {
			$( '.qb-block-newsletter-errors' ).html('').fadeOut();
		} );
	}
}

$( document ).ready( function() {
	QodeblockNewsletterSubmission.init();
} );
