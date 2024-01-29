<?php
/**
 * The Button Shortcode(Video-Inline ).
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $this->atts['element_id'] );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-video--djo-inline' );


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/video-btn/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('djo-video-btn-layout2', $shortcode_dir . 'assets/css/djo_layout2.css', null, null);
}
wp_enqueue_script( 'djo-video-btn-layout2-js', $shortcode_dir . 'assets/js/djo_layout2.min.js', array( 'jquery' ), null );

/**
 * Get video ID
 */

if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $atts["video_link"], $match)) {
    $video_id = $match[1];
}

// SEO-title for image
$djo_title = ! empty($djo_title) ? $djo_title : 'video';

$image = !empty( $djo_image['url'] ) ? Helper::get_attachment($djo_image, [], 'large') : '<img src="https://i.ytimg.com/vi/' . $video_id . '/maxresdefault.jpg">';
?>

<?php if( ! empty( $atts["video_link"] ) ): ?>

	<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-video js-video" data-id="<?php echo esc_attr($video_id); ?>">
		<a class="aheto-video__link js-link s-back-switch" href="<?php echo 'https://youtu.be/' . $video_id; ?>">
			<?php echo wp_kses_post($image); ?>
		</a>
		<button class="aheto-video__button js-button" type="button" aria-label="<?php echo esc_html__( 'Play video' , 'djo' ); ?>"></button>
	</div>
	</div>

<?php endif; 
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/djo_layout2.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    "use strict";
    
    /**
     * find all videos
     */

    function findVideos() {
        if($('.aheto-video--djo-inline').length ) {
            let videos = document.querySelectorAll('.aheto-video--djo-inline .js-video');

            for (let i = 0; i < videos.length; i++) {
                setupVideo(videos[i]);
            }
        }
    }

    /**
     * Setup video after click on box
     * 
     * @param video 
     */

    function setupVideo(video) {
        if($('.aheto-video--djo-inline').length ) {
            let link = video.querySelector('.aheto-video--djo-inline .js-link');
            let button = video.querySelector('.aheto-video--djo-inline .js-button');
            let id = video.getAttribute('data-id');

            video.addEventListener('click', () => {
                let iframe = createIframe(id);

                link.remove();
                button.remove();
                video.appendChild(iframe);
            });

            link.removeAttribute('href');
            video.classList.add('video--enabled');
        }
    }

    /**
     * Parse ID from URL
     * 
     * @param media Link with video ID(youtube poster src)
     */

    // function parseMediaURL(media) {
    // 	let regexp = /https:\/\/i\.ytimg\.com\/vi\/([a-zA-Z0-9_-]+)\/maxresdefault\.jpg/i;
    // 	let url = media.src;
    // 	let match = url.match(regexp);

    // 	return match[1];
    // }

    /**
     * Create Iframe
     * 
     * @param id Video ID
     * 
     * @returns iframe objects
     */

    function createIframe(id) {
        let iframe = document.createElement('iframe');

        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('allow', 'autoplay');
        iframe.setAttribute('src', generateURL(id));
        iframe.classList.add('aheto-video__media');

        return iframe;
    }

    /**
     * Generate full video URL
     * 
     * @param id Video ID
     * 
     * @returns full video url
     */

    function generateURL(id) {
        let query = '?rel=0&showinfo=0&autoplay=1';

        return 'https://www.youtube.com/embed/' + id + query;
    }

    findVideos();	

})(jQuery, window, document);
	</script>
	<?php
endif;