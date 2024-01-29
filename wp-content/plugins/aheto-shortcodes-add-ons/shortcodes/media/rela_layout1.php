<?php
/**
 * The Acacia Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if (empty($rela_image)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto_media--rela');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style('rela-media-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}
wp_enqueue_script('rela-media-layout1-js', $shortcode_dir . 'assets/js/rela_layout1.js', array('jquery'), null);


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-single-gallery-img">
        <?php echo Helper::get_attachment($rela_image, ['class' => 'js-bg'], $rela_image_size, $atts, 'rela_'); ?>
    </div>
    <div class="aheto-single-gallery-popup">
        <div class="aheto-single-gallery-popup_overlay"></div>
        <img src="#" alt="active image">
        <span class='close'>&times;</span>
    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/rela_layout1.css'?>" rel="stylesheet">
	<script>
; (function ($, window, document, undefined) {
    "use strict";

    $(window).on('load', function () {
        let imageBlock = $('.aheto-single-gallery-img');
        let closePopup = $('.aheto-single-gallery-popup .close');
        let closePopupOut = $('.aheto-single-gallery-popup_overlay');
        imageBlock.on('click', function () {
            let imageUrl = $(this).find('img').attr('src');

            $(this).next().find('img').attr('src', imageUrl);
            $(this).next().fadeIn();
            $('body').css("overflow", "hidden");
            isBlocked = true;
        });

        closePopup.on('click', function () {
            $(this).parent().fadeOut();
            $('body').css("overflow", "unset");
            isBlocked = false;
        })
        closePopupOut.on('click', function () {
            $('.aheto-single-gallery-popup').fadeOut();
            $('body').css("overflow", "unset");
            isBlocked = false;
        })


        let isBlocked = false;
        let hasPassiveEvents = false;
        if (typeof window !== 'undefined') {
            let passiveTestOptions = {
                get passive() {
                    hasPassiveEvents = true;
                    return undefined;
                }
            };
            window.addEventListener('testPassive', null, passiveTestOptions);
            window.removeEventListener('testPassive', null, passiveTestOptions);
        }

        document.addEventListener('touchmove', function (e) {
            if (isBlocked) {
                e.preventDefault();
            }
        }, hasPassiveEvents ? {
            passive: false
        } : undefined);


    });
})(jQuery, window, document);
	</script>
	<?php
endif;