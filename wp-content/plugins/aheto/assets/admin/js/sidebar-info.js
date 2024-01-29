( function( $ ) {



    function system_info_position(){
        if($(window).width() > 991){
            var info_header = $('.aheto-system-info-header').clone();
            $('.aheto-option-body .aheto-system-info-header').hide();
            $('.aheto-option-header').append(info_header);
        }
        else{
            $('.aheto-system-info-header').hide();
            $('.aheto-option-body .aheto-system-info-header').show();
        }
    }

    $( () => {

        if($('.aheto-option-sidebar-info').length && $('#aheto-right-sidebar-option').length ) {

            var aheto_sidebar = $('.aheto-option-sidebar-info').clone(),
                aheto_parent = $('.aheto-option-sidebar-info').parent();

            aheto_parent.find('.aheto-option-sidebar-info').remove();
            aheto_parent.find('.aheto-option-body').append(aheto_sidebar);

        }

        if($('.aheto-system-info-header').length){
            system_info_position();
        }


    });

    $(window).on('resize', function () {
        if($('.aheto-system-info-header').length){
            system_info_position();
        }
    });

    $(window).on('load', function () {
        $('.aheto-preloader').addClass('active');
        $('.aheto-wrap .aheto-option-sidebar-info').addClass('load-visible');

        if($('.aheto-option-sidebar-info').length && $('#aheto-right-sidebar-option').length ) {

            if($('#aheto-right-sidebar-option').prop("checked") == true){

                $('.aheto-option-sidebar-info').addClass('active');

            } else{

                $('.aheto-option-sidebar-info').removeClass('active');

            }

        }
    });


    $('#aheto-right-sidebar-option').on('change', function () {
        if($(this).prop("checked") == true){

            $('.aheto-option-sidebar-info').addClass('active');

        } else{

            $('.aheto-option-sidebar-info').removeClass('active');

        }
    })


}( jQuery ) );
