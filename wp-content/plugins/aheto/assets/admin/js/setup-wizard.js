( function( $ ) {

	function a() {

		$(".next_page_required").on("click", function (e) {
			// e.preventDefault();
			alert('aaaaa');
			$("form#tgmpa-plugins").find("input[type='checkbox']").prop('checked','checked');
			$("form#tgmpa-plugins").find("input[name='plugin_status']").val('install');
			$("form#tgmpa-plugins").find("select[name='action2']").val('tgmpa-bulk-install');
			$("form#tgmpa-plugins").find("input[name='_wp_http_referer']").val('http://test-aheto.loc./wp-admin/themes.php?page=tgmpa-install-plugins&plugin_status=install');
			$("form#tgmpa-plugins").submit();
			//
			// var info = {
			//     data: $(this).serialize(),
			//     action: 'adjustment_action'
			// };
			//
			// $(this).find('#loader-pic').show();
			//
			// $.post({
			//     url: get.ajaxurl,
			//     data: info,
			//     success: function (data) {
			//         $(this).find('#loader-pic').hide();
			//         $("#loader-pic").hide();
			//         $("form#adjustment-form").next(".green").text("Updated").show();
			//     },
			//     error: function (data) {
			//         alert(data.responseJSON.message);
			//         console.log('error');
			//         console.log(data);
			//     },
			// });

		});

	}
	// setTimeout( a, 500);

	// Document Ready
	$( function() {
		$( '.aheto-option-content' ).on( 'click', '.install-now', function( event ) {;
			var $button = $( event.target )
			event.preventDefault()

			if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
				return
			}

			if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
				wp.updates.requestFilesystemCredentials( event )

				$document.on( 'credential-modal-cancel', function() {
					var $message = $( '.install-now.updating-message' )

					$message
						.removeClass( 'updating-message' )
						.text( wp.updates.l10n.installNow )

					wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' )
				})
			}

			wp.updates.installPlugin({
				slug: $button.data( 'slug' )
			})
		});


        $( '.aheto-option-content' ).on( 'click', 'input[name="plugin-select"]', function( ) {
            $('.aheto-setup-actions.step input[name="save_step"]').removeClass('default');
        });

		$( document ).on( 'wp-plugin-install-success', function( response ) {
			// window.location.reload()
		});


		let getTitle = document.querySelector('.aheto-option-page-nav .aheto-option-nav-wrap .nav-active') ? document.querySelector('.aheto-option-nav-wrap .nav-active').getAttribute('title') : '';
		document.querySelector('.options-page-title') ? document.querySelector('.options-page-title').textContent = getTitle : '' ;







	})


}( jQuery ) )
