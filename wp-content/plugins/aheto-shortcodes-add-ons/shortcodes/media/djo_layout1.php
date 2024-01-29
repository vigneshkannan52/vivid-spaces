<?php
/**
 * The Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;
extract($atts);

if ( empty($djo_items) ) {
	return '';
}

wp_enqueue_script('magnific');

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-gallery--djo-gallery');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('djo-media-layout1', $shortcode_dir . 'assets/css/djo_layout1.css', null, null);
}
wp_enqueue_script( 'djo-media-layout1-js', $shortcode_dir . 'assets/js/djo_layout1.js', array( 'jquery' ), null );

$counter 	= 1;

$atts['djo_image_height'] = 600;
$atts['djo_image_width'] = 600;

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	
	<div class="aheto-gallery__box">
		<?php foreach ( $djo_items as $index => $item ) :
			$image		= $item['djo_image'];
			$title		= $item['djo_title'];
			$subtitle	= $item['djo_subtitle'];

			$preview_img = Helper::get_attachment($image,'custom', $atts, 'djo_');

			$counter  = ($counter > 8) ? 1 : $counter;
			$itemClass	= 'aheto-gallery-item--' . $counter;
		?>
		
		<?php if( ($index > 0) && ($index % 8) == 0 ) { ?>
			</div>
			<div class="aheto-gallery__box js-gallery-wrap">
		<?php } ?>

			<a href="<?php echo esc_url( $image['url'] ); ?>" class="aheto-gallery-item js-gallery-item s-back-switch <?php echo esc_attr($itemClass); ?>" data-effect="mfp-zoom-in">
				<?php echo wp_kses_post($preview_img); ?>
				<?php if ( ! empty( $title ) || ! empty( $subtitle ) ) { ?>
					<div class="aheto-gallery-item__hidden">
						<div class="aheto-gallery-item__content">
							<?php if ( ! empty( $title ) ) { ?>
								<h4 class="aheto-gallery-item__title"><?php echo esc_html( $title ); ?></h4>
							<?php } ?>
							<?php if ( ! empty( $subtitle ) ) { ?>
								<p class="aheto-gallery-item__subtitle"><?php echo esc_html( $subtitle ); ?></p>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</a>

		<?php 
			$counter++;
			endforeach;
		?>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/djo_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    "use strict";

    /**
     * Prevent scroll on mobile devices
     */

    let isBlocked = false;
    let hasPassiveEvents = false;
    if (typeof window !== 'undefined') {
        const passiveTestOptions = {
            get passive() {
                hasPassiveEvents = true;
                return undefined;
            }
        };
        window.addEventListener('testPassive', null, passiveTestOptions);
        window.removeEventListener('testPassive', null, passiveTestOptions);
    }
    document.addEventListener('touchmove', function(e) {
        if (isBlocked) {
            e.preventDefault();
        }
    }, hasPassiveEvents ? {
        passive: false
    } : undefined);

    window.addEventListener('load', () => {
        if ($('.aheto-gallery--djo-gallery').length) {
            $('.aheto-gallery--djo-gallery .js-gallery-wrap').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                removalDelay: 500,
                callbacks: {
                    beforeOpen: function() {
                        this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                        this.st.mainClass = this.st.el.attr('data-effect');
                        isBlocked = true;
                    },
                    beforeClose: () => {
                        isBlocked = false;
                    }
                },
                closeOnContentClick: true,
                midClick: true
            });
        }
    })
})(jQuery, window, document);
	</script>
	<?php
endif;