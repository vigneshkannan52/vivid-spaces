;(function ($, window, document, undefined) {
    'use strict';

    if ($('.snapster_layout3').length !== null) {
        $('.snapster_layout3')
            .append('<span class="btn-outline-horizontal-lines"></span>', '<span class="btn-outline-vertical-lines"></span>');
    }

})(jQuery, window, document);
var site_title = script_vars.site_title;
var site_slug = script_vars.site_slug;
if( site_slug === 'home-dark-1-5' && site_title === 'Home Dark 1 [5]' && (site_title != '')){
	jQuery('body').addClass('home_darkmode');
}
if( site_slug === 'home-dark-2-6' && site_title === 'Home Dark 2 [6]' && (site_title != '')){
	jQuery('body').addClass('home_darkmode');
}