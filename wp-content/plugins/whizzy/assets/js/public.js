(function ($) {
	"use strict";
	$(document).ready(function () {

		$(document).on('click', '.w-select-action', function(ev){
			ev.preventDefault();
			ev.stopPropagation();
			//var photo = $('#' + $(this).data('photoid'));
			let photo = $('[id=' + $(this).data('photoid') + ']');
			$(photo).toggleClass('selected');
			$(photo).addClass('selecting');

			let selected = $(photo).hasClass('selected'),
				attachment_id = $(photo).data('attachment_id');

			if( selected ){
				jQuery(this).find('.button-text').html(whizzy.l10n.deselect);
				photo.find('.w-select-action  .button-text').html(whizzy.l10n.deselect);
			} else {
				jQuery(this).find('.button-text').html(whizzy.l10n.select);
				photo.find('.w-select-action .button-text').html(whizzy.l10n.select);
			}

			$.ajax({ type: "post",url: whizzy.ajaxurl,data: {
					action: 'whizzy_image_click',
					attachment_id: attachment_id,
					selected: selected
				},
				beforeSend: function() {
					//
				}, //show loading just when link is clicked
				complete: function() {
					setTimeout(function(){
						$(photo).removeClass('selecting');
					}, 600);
				}, //stop showing loading when the process is complete

				success:function(response){
						// console.log(response);
						// var result = JSON.parse(response);
						// console.log(result);
				}
			});

			prepare_download_button();
		});

		prepare_download_button();

		$('.js-whizzy-gallery:not(.lightpopup)').each(function() { // the containers for all your galleries should have the class gallery
			$(this).magnificPopup({
				delegate: 'a.zoom-action', // the container for each your gallery items
				type: 'image',
				removalDelay: 500,
				mainClass: 'mfp-fade',
				image:{
					titleSrc: function(item) {
						let text = $('#' + item.el.data('photoid')).hasClass('selected') == true ? whizzy.l10n.deselect : whizzy.l10n.select;

						return '<a class="meta__action  meta__action--popup  w-select-action"  id="popup-selector" href="#" data-photoid="' + item.el.data('photoid') + '"><span class="button-text">' + text + '</span></a>';
					}
				},
				gallery:{
				    enabled:true,
				    navigateByImgClick: true,
					tPrev: whizzy.l10n.previous, // title for left button
					tNext: whizzy.l10n.next, // title for right button
					tCounter: '<span class="mfp-counter">%curr% ' + whizzy.l10n.ofCounter + ' %total%</span>' // markup of counter
				},

			});
		});

		bound_reference_links();
	});

	// check if the download button needs to be disabled
	let prepare_download_button = function () {

		if ( whizzy.whizzy_settings.zip_archive_generation !== 'automatic' ) return;

		let download_button = $('.js-download');
		download_button.attr('disabled', 'disabled');

		$('.proof-photo').each(function(i,el){
			if ( $(this).hasClass('selected') ) {
				download_button.removeAttr('disabled');
			}
		});
	}

	let bound_reference_links = function(){

		if ( typeof bound_reference_links.bound === 'undefined' ) {

			bound_reference_links.bound = true;

			$(document).on('click', 'span.whizzy_photo_ref', function() {

				//if (location.pathname.replace(/^\//,'') == $(this).data('href').replace(/^\//,'') && location.hostname == this.hostname) {

					let target = $($(this).data('href'));
					target = target.length ? target : $('[name=' + $(this).data('href').slice(1) +']');

					if (target.length) {
						$('body').animate(
							{
								scrollTop: target.offset().top-200
							},
							500,
							function (){
								$(target).addClass('scrooled_from_comments');

								setTimeout(function(){
									$(target).removeClass('scrooled_from_comments');
								}, 800);
							}
						);

					}
				//}
			});

		}

	};



    /*=================================*/
    /* BACKGROUND */
    /*=================================*/
    //sets child image as a background
    function wpc_add_img_bg(img_sel, parent_sel) {
        if (!img_sel) {

            return false;
        }
        let $parent, $imgDataHidden, _this;
        $(img_sel).each(function () {
            _this = $(this);
            $imgDataHidden = _this.data('s-hidden');
            $parent = _this.closest(parent_sel);
            $parent = $parent.length ? $parent : _this.parent();
            $parent.css('background-image', 'url(' + this.src + ')').addClass('s-back-switch');
            if ($imgDataHidden) {
                _this.css('visibility', 'hidden');
                _this.show();
            }
            else {
                _this.hide();
            }
        });
    }

    jQuery(window).on('load', function () {
        wpc_add_img_bg('.s-img-switch');

        $(".js-whizzy-gallery.lightpopup").lightGallery({
            selector: 'a.zoom-action',
            mode: 'lg-slide',
            closable: false,
            iframeMaxWidth: '80%',
            download: false,
            thumbnail: false,
            showThumbByDefault: false
        });

    });


    $('#whizzy_proof_gallery').each(function () {
        let space = $(this).data('space');
        $(this).find('.proof-photo').css({
            'padding-right': space,
            'padding-left': space,
            'margin-top': '0',
            'margin-bottom': space*2
        });
        $(this).css({
            'margin-left': -space + 'px',
            'margin-right': -space + 'px'
        });

    });



    function whizzyinitisotope() {
        if ($('#whizzy_proof_gallery.masonry').length) {
            $('#whizzy_proof_gallery.masonry').each(function () {
                let self = $(this);

                let layoutM = self.attr('data-layout') || 'masonry';

                let filters = self.prev('.whizzy-filters');

				if(filters.length){

					filters.find('button').on('click', function() {

						let selector = $(this).attr('data-selector');

						self.prev('.whizzy-filters').find('button').removeClass('is-checked');

						$(this).addClass('is-checked');

						self.isotope({
							filter: selector
						});
					});
				}


                self.isotope({
                    itemSelector: '.proof-photo',
                    layoutMode: layoutM,
                    masonry: {
                        columnWidth: '.proof-photo'
                    }
                });
            });
        }

    }

    $(window).on('load resize', function () {
        whizzyinitisotope();
    });

    window.addEventListener("orientationchange", function () {
        whizzyinitisotope();
	});



}(jQuery));