;(function ($, window, document, undefined) {
    'use strict';

    var $gridAlbums;

    /*=================================*/
    /* BACKGROUND */
    /*=================================*/
    //sets child image as a background
    function wpc_add_img_bg(img_sel, parent_sel) {
        if (!img_sel) {

            return false;
        }
        var $parent, $imgDataHidden, _this;
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


    function portfolioFilter() {
        // init Isotope
        $gridAlbums = $('.whizzy-portfolio-wrapper').isotope({
            itemSelector: '.item',
            layoutMode: 'masonry',
            masonry: {
                columnWidth: '.item',
                "gutter": $('.whizzy-portfolio-wrapper').find('.classic, .grid, .masonry').length ? 0 : 30
            }
        });
        // filter functions
        var filterFns = {
            // show if number is greater than 50
            numberGreaterThan50: function() {
                var number = $(this).find('.number').text();
                return parseInt( number, 10 ) > 50;
            },
            // show if name ends with -ium
            ium: function() {
                var name = $(this).find('.name').text();
                return name.match( /ium$/ );
            }
        };
        // bind filter button click
        $('.filter ul').on( 'click', 'li', function() {
            var filterValue = $( this ).attr('data-selector');
            // use filterFn if matches value
            filterValue = filterFns[ filterValue ] || filterValue;
            $gridAlbums.isotope({ filter: filterValue });

            wpc_add_img_bg('.s-img-switch');
        });
        // change is-checked class on buttons
        $('.filter ul').each( function( i, buttonGroup ) {
            var $buttonGroup = $( buttonGroup );
            $buttonGroup.on( 'click', 'li', function() {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
                $( this ).addClass('is-checked');
            });
        });
    }


    function imageWidth($imagesSelector) {
        var $imagesWidth = $imagesSelector.innerWidth();
        $imagesSelector.each( function() {
            $(this).innerHeight( $imagesWidth );
        });
    }

    function initIzotope() {
        if ($('.whizzy-plugin.whizzy-popup .izotope-container').length) {
            $('.whizzy-plugin.whizzy-popup .izotope-container').each(function () {
                var self = $(this);
                var layoutM = self.attr('data-layout') || 'masonry';
                self.isotope({
                    itemSelector: '.item-single',
                    layoutMode: layoutM,
                    masonry: {
                        columnWidth: '.item-single',
                        "gutter": 30
                    }
                });
            });
        }
    }



    if($('.portfolio-single-content.whizzy-plugin.whizzy-popup').length ) {
        $(".portfolio-single-content.whizzy-plugin.whizzy-popup").lightGallery({
            selector: '.gallery-item',
            mode: 'lg-slide',
            closable: false,
            iframeMaxWidth: '80%',
            download: false,
            thumbnail: false,
            showThumbByDefault: false
        });
    }


    function load_more_portfolio() {
        // Load More Portfolio
        if (window.load_more_post) {

            var pageNum = parseInt(load_more_post.startPage) + 1;

            // The maximum number of pages the current query can return.
            var max = parseInt(load_more_post.maxPage);

            // The link of the next page of posts.
            var nextLink = load_more_post.nextLink;

            // wrapper selector
            var wrap_selector = '.whizzy-portfolio-wrapper .portfolio';

            //button click
            $('.load-more').on('click', function (e) {

                var $btn = $(this),
                    $btnText = $btn.html();
                $btn.html('loading...');

                if (pageNum <= max) {

                    var $container = $(wrap_selector);
                    $.ajax({
                        url: nextLink,
                        type: "get",
                        success: function (data) {

                            var newElements = $(data).find('.portfolio .item');
                            var elems = [];

                            newElements.each(function (i) {
                                elems.push(this);
                            });
                            $container.append(elems);

                            wpc_add_img_bg('.s-img-switch');

                            $gridAlbums.isotope('appended', $(elems));
                            imageWidth( $('.whizzy-portfolio-wrapper.grid .item-link') );
                            portfolioFilter();
                            pageNum++;
                            nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/' + pageNum);

                            $btn.html($btnText);

                            if (pageNum == ( max + 1 )) {
                                $btn.hide('fast');
                            }
                        }
                    });
                }
                return false;
            });
        }
    }


    $(window).on('load resize', function () {
        load_more_portfolio();
    });
    $(window).on('load resize', function () {
        wpc_add_img_bg('.s-img-switch');
        if( $('.whizzy-portfolio-wrapper.grid').length){
            imageWidth( $('.whizzy-portfolio-wrapper.grid .item-link') );
        }
        if($('.portfolio-single-content.whizzy-plugin.boxed_grid.whizzy-popup') .length){
            imageWidth( $('.portfolio-single-content.whizzy-plugin.boxed_grid.whizzy-popup .item-single') );
        }
        initIzotope();
        portfolioFilter();
    });

})(jQuery, window, document);