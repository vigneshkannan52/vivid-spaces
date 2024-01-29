;(function ($, window, document) {
	"use strict";
	const instagram = $('.mooseoom-instagram');

	function getParamsInstagram() {
		if (instagram.length) {
			instagram.each(function () {
				const max   = +$(this).attr('data-max') || 6;
				const token = $(this).attr('data-token');
				const size  = $(this).attr('data-size');

				$.fn.spectragram.accessData = {
					accessToken: token
				};
				$(this).spectragram('getUserFeed', {
					size: size,
					max: max,
					accessToken: token
				});
			});
		}
	}

/*	if (window.elementorFrontend) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/widget', (scope) => {
			const widgetName = scope.context.dataset.widget_type;
			if (widgetName.indexOf('instagram') > -1) {
				getParamsInstagram();
			}
		});
	}*/
	$(window).on('load', function () {
		getParamsInstagram();
	});
	

})(jQuery, window, document);
