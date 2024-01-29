;(function ($, window, document, undefined) {
	"use strict";
	function testimonials() {
	if($('.aheto-tm-wrapper--karma-events-layout1').length){
		let counter = 0;

		$('.aheto-tm-wrapper--karma-events-layout1').each(function () {
			let parent = $(this);

			if(parent.find('.aheto-tm___gallery-thumbs').length){

				parent.find('.aheto-tm___gallery-thumbs').addClass('karma-event-gallery-thumbs-' + counter);

				let galleryThumbs = new Swiper('.karma-event-gallery-thumbs-' + counter, {
					spaceBetween: 5,
					slidesPerView: 'auto',
					centeredSlides: true,
					freeMode: true,
					watchSlidesVisibility: true,
					watchSlidesProgress: true,
					scrollbar: {
						el: '.swiper-scrollbar',
					},
					scrollbarHide: true,
					mousewheel: true
				});


				if(parent.find('.aheto--tm__gallery-top').length){

					parent.find('.aheto--tm__gallery-top').addClass('karma-event-gallery-top-' + counter);

					let galleryTop = new Swiper('.karma-event-gallery-top-' + counter, {
						spaceBetween: 0,
						slidesPerView: 1,
						thumbs: {
							swiper: galleryThumbs,
						},
						breakpoints: {
							1199: {
								slidesPerView: 1,
							}
						},
						scrollbar: {
							el: '.swiper-scrollbar',
						},
						scrollbarHide: true,
					});

				}
			}

			counter++;
		});
	}
}

	$(window).on('load resize orientationchange', function () {
		testimonials();
	});

})(jQuery, window, document);