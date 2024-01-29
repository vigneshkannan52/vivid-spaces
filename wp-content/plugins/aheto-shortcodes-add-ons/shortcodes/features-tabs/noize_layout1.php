<?php
/**
 * The Button Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$video_tabs = $this->parse_group($noize_videos);

if ( empty($video_tabs) ) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $this->atts['element_id'] );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto--noize-features-tabs' );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/features-tabs/';

wp_enqueue_script( 'noize-youtube', 'https://www.youtube.com/iframe_api', '', true );
wp_enqueue_script( 'noize-features-tabs-layout1-js', $shortcode_dir . 'assets/js/noize_layout1.min.js', array( 'jquery' ), null );

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( empty($custom_css) || ($custom_css == "disabled") ) {
    wp_enqueue_style( 'noize-features-tabs-layout1', $shortcode_dir . 'assets/css/noize_layout1.css', null, null );
}


$video_params = array(
    'enablejsapi' => 1,
    'loop' => 0,
    'controls' => 1,
    'showinfo' => 0,
    'autohide' => 0,
    'modestbranding' => 1,
    'disablekb' => 1,
    'rel' => 0,
    'fs' => 1,
);

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="swiper-container aheto--noize-features-tabs__gallery-top gallery-top">
        <div class="swiper-wrapper">
            <?php foreach ( $video_tabs as $video ) :
                $video = wp_parse_args($video, [
                    'noize_background_image'         => '',
                    'noize_video_url' =>  '',
                ]);

                extract($video);

                $background_image = Helper::get_background_attachment($noize_background_image, 'full', $atts, '', false);
            ?>
                <div class="swiper-slide aheto--noize-features-tabs__iframe-video" <?php echo esc_attr($background_image); ?>>
                    <div class="aheto--noize-features-tabs__iframe-previews" data-url="<?php echo esc_attr($noize_video_url); ?>">
                        <button class="aheto--noize-features-tabs__iframe-play-video">
                            <svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%">
                                <path class="aheto--noize-features-tabs__iframe-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#212121" fill-opacity="0.8"></path>
                                <path d="M 45,24 27,14 27,34" fill="#fff"></path>
                            </svg>
                        </button>
                    </div>
                    <?php
                        if ( !empty($noize_video_name) ) {
                            echo '<h6 class="aheto--noize-features-tabs__video-name">' . esc_html( $noize_video_name ) . '</h6>';
                        }
                    ?>

                    <p class="aheto--noize-features-tabs__video-duration-top"></p>

                    <?php
                        $video_iframe = str_replace("?feature=oembed", "?feature=oembed&" . http_build_query ( $video_params ), wp_oembed_get($noize_video_url));
                        echo $video_iframe = str_replace('frameborder="0"', '', $video_iframe);
                    ?>

                </div>
            <?php endforeach; ?>
        </div>
        <!-- Add Scroll Bar -->
        <div class="swiper-scrollbar"></div>
    </div>
    <div class="swiper-container aheto--noize-features-tabs__gallery-thumbs gallery-thumbs">
        <div class="swiper-wrapper">
            <?php foreach ( $video_tabs as $video ) :
                $video = wp_parse_args($video, [
                    'noize_background_image'         => '',
                    'noize_video_url' =>  '',
                ]);

                extract($video);
            ?>
                <div class="swiper-slide">
                    <div class="aheto--noize-features-tabs__image" data-url="<?php echo esc_attr($noize_video_url); ?>"></div>
                    <?php
                        if ( !empty($noize_video_name) ) {
                            echo '<h6 class="aheto--noize-features-tabs__video-name">' . esc_html( $noize_video_name ) . '</h6>';
                        }
                    ?>
                    <p class="aheto--noize-features-tabs__video-duration-thumbs"></p>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Add Scroll Bar -->
        <div class="swiper-scrollbar"></div>
    </div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/noize_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    "use strict";

    let players = [];

    function getUrls() {
        let urls = $('.aheto--noize-features-tabs__gallery-thumbs .aheto--noize-features-tabs__image');
        let links = [];

        urls.each(function () {
            links.push($(this).data('url'));
        });

        return links;
    }

    let Youtube = (function () {
        let urls = $('.aheto--noize-features-tabs__gallery-thumbs .aheto--noize-features-tabs__image');
        let previewsUrls = $('.aheto--noize-features-tabs__gallery-top .swiper-slide');
        let video, regExp, results;

        let getThumb = function (url) {
            if (url === null) {
                return '';
            }

            for (let i = 0; i < url.length; i++) {
                regExp  = /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/;
                results = url[i].match(regExp);
                video   = (results === null) ? url : results[1];

                $(urls).eq(i).css('background', 'url(https://i3.ytimg.com/vi/' + video + '/maxresdefault.jpg)');
                $(previewsUrls).children('div').eq(i).css('background', 'url(https://i3.ytimg.com/vi/' + video + '/maxresdefault.jpg)');
            }
        };

        return {
            thumb: getThumb
        };
    }());

    let thumb = Youtube.thumb( getUrls() );

    window.onYouTubeIframeAPIReady = function() {

        // each all iframe
        $('.aheto--noize-features-tabs__gallery-top iframe').each(function(i) {

            players[i] = new YT.Player(this, {
                events: {
                    'onReady': function (event) {

                        setTimeout(function(){
                            videoGallery();

                            $('.aheto--noize-features-tabs__video-duration-top').eq(i).html( formatTime( $(players)[i].getDuration() - 1 ) );
                            $('.aheto--noize-features-tabs__video-duration-thumbs').eq(i).html( formatTime( $(players)[i].getDuration() - 1 ) );
                        }, 300);


                        $('.aheto--noize-features-tabs__gallery-top .aheto--noize-features-tabs__iframe-previews').on('click', function() {
                            let iframeIndex = $(this).parent().index();

                            $(this).hide();

                            players[iframeIndex].playVideo();
                        });
                    }
                }

            });

        });

    }


    function videoGallery() {
        if($('.aheto--noize-features-tabs').length){
            let counter = 0;

            $('.aheto--noize-features-tabs').each(function () {
                let parent = $(this);

                if(parent.find('.aheto--noize-features-tabs__gallery-thumbs').length){

                    parent.find('.aheto--noize-features-tabs__gallery-thumbs').addClass('noize-gallery-thumbs-' + counter);

                    let galleryThumbs = new Swiper('.noize-gallery-thumbs-' + counter, {
                        spaceBetween: 5,
                        slidesPerView: 'auto',
                        direction: 'vertical',
                        freeMode: true,
                        watchSlidesVisibility: true,
                        watchSlidesProgress: true,
                        scrollbar: {
                            el: '.swiper-scrollbar',
                        },
                        scrollbarHide: true,
                        mousewheel: true
                    });

                    galleryThumbs.on('slideChange', function () {
                        // each all iframe
                        $('.aheto--noize-features-tabs__gallery-top iframe').each(function(i) {
                            players[i].pauseVideo();
                        });
                    });

                    if(parent.find('.aheto--noize-features-tabs__gallery-top').length){

                        parent.find('.aheto--noize-features-tabs__gallery-top').addClass('noize-gallery-top-' + counter);

                        let galleryTop = new Swiper('.noize-gallery-top-' + counter, {
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

                        galleryTop.on('slideChange', function () {
                            // each all iframe
                            $('.aheto--noize-features-tabs__gallery-top iframe').each(function(i) {
                                players[i].pauseVideo();
                            });
                        });
                    }
                }

                counter++;
            });
        }
    }

    function formatTime(time) {
        let hours   = Math.floor(time / 3600);
        let minutes = Math.floor((time - (hours * 3600)) / 60);
        let seconds = time - (hours * 3600) - (minutes * 60);

        seconds = Math.round(seconds * 100 ) / 100;

        let result;

        if (hours == 0) {
            result = (minutes);
            result += ":" + (seconds  < 10 ? "0" + seconds : seconds);
        } else {
            result = (hours);
            result += ":" + (minutes);
            result += ":" + (seconds  < 10 ? "0" + seconds : seconds);
        }

        return result;
    }


    $(window).on('load resize orientationchange', function () {
        videoGallery();
    });

})(jQuery, window, document);
	</script>
	<?php
endif;