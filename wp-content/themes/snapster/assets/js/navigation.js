/**
 * Header menu
 */
;(function ($, window, document, undefined) {
    'use strict';


    const mobileMenuBreakpoint = 1199;
    let winW = null;


    /* ============================ */
    /* CALCULATE WINDOW SIZE (width, height) */

    /* ============================ */
    function calcWinSizes() {
        winW = window.innerWidth;
    }


    $(window).on('load resize orientationchange', function () {
        calcWinSizes();
    });


    /*=================================*/
    /* MOBILE MENU */
    /*=================================*/


    if ($('.snapster-header--wrap').length) {

        // Add dropdown arrow to items with childrens
        $('.snapster-header--wrap .menu-item-has-children > a').after('<span class="dropdown-btn"></span>');

        $('.snapster-header--wrap').append('<span class="body-overlay"></span>');


        // click menu item
        $('.snapster-header--wrap').find('.menu-item-has-children .dropdown-btn').on('click', function (e) {
            e.stopPropagation();
            if (winW <= mobileMenuBreakpoint) {
                var parentItems = $(this).parent().parent().parent().parent();

                if (parentItems.hasClass('snapster-header--menu-wrapper')) {
                    $(this).closest('.snapster-header--menu-wrapper').find('.dropdown-btn').not(this).next('.sub-menu').slideUp();
                }

                $(this).next('.sub-menu').slideToggle();
            }
        });


        if (!$('.snapster-header--menu-wrapper').find('.btn-close').length) {
            $('.snapster-header--menu-wrapper').append('<span class="btn-close"><i class="ion-android-close"></i></span>');
        }

        // Close click
        $('.btn-close').on('click', function () {

            $('.snapster-header--menu-wrapper').removeClass('menu-open');
            $('html').removeClass('no-scroll');

            $('body').removeClass('sidebar-open');
            $('.snapster-header--mob-nav__hamburger').removeClass('active');

        });


    }


    $('.snapster-header--mob-nav__hamburger').on('click', function (e) {
        e.preventDefault();

        var adminBarH = 0;

        $(this).toggleClass('active');

        if ($(this).hasClass('active')) {
            $('html').addClass('no-scroll');
            $('body').addClass('sidebar-open');
            $('.snapster-header--menu-wrapper').addClass('menu-open');
        } else {
            $('html').removeClass('no-scroll');
            $('body').removeClass('sidebar-open');
            $('.snapster-header--menu-wrapper').removeClass('menu-open');
        }
        if ($('#wpadminbar').length) {
            adminBarH = $(window).width() && $('#wpadminbar').length > 782 ? 32 : 46;
        }
        $('.snapster-header--menu-wrapper').css('top', adminBarH);

    });

    function resizeMenu() {
        if ($(window).width() > 1199 && $('html').hasClass('no-scroll')) {
            $('html').removeClass('no-scroll').height('auto');
            $('.snapster-header--mob-nav__hamburger').toggleClass('active');
        } else {

            var adminBar = 0;

            if ($('#wpadminbar').length) {
                adminBar = $(window).width() && $('#wpadminbar').length > 782 ? 32 : 46;
            }

            var menuHeight = $(window).height() - adminBar;

            $('.snapster-header--menu-wrapper').outerHeight(menuHeight);
        }
    }


    $(window).on('load resize orientationchange', function () {
        resizeMenu();
    })

})(jQuery, window, document);
