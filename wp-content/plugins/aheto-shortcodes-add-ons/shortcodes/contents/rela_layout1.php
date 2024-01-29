<?php
/**
 * The Contents Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */
use Aheto\Helper;
extract($atts);
$faqs = $this->parse_group($faqs);

if (empty($faqs)) {
    return '';
}
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contents--rela-faq');
$this->add_render_attribute('wrapper', 'class', 'js-accordion-parent');

if (isset($multi_active) && !empty($multi_active)) {
    $this->add_render_attribute('wrapper', 'data-multiple', '1');
}
/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contents/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style('rela-contents-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <?php
    foreach ($faqs as $key => $item) :

        $class_active = $key === 0 && $first_is_opened ? 'is-open' : '';
        $active_display = $key === 0 && $first_is_opened ? 'block' : 'none';

        if (empty($item['title']) && empty($item['description'])) {
            continue;
        }
        ?>
        <div class="aheto-contents__item <?php echo esc_attr($class_active); ?>">
            <?php if (!empty($item['title'])) : ?>
                <h5 class="aheto-contents__title js-accordion"><?php echo wp_kses($item['title'], 'post'); ?>
                    <i class="el icon_plus"></i>
                </h5>
            <?php endif; ?>

            <?php if (!empty($item['description'])) : ?>
                <div class="aheto-contents__panel js-accordion-text"
                     style="display: <?php echo esc_attr($active_display); ?>">
                    <p class="aheto-contents__desc">
                        <?php echo wp_kses($item['description'], 'post'); ?>
                    </p>
                </div>
            <?php endif; ?>

        </div>

    <?php endforeach; ?>

</div>
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/rela_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    'use strict';

        const $isotope = $('.rela-js-accordion-parent');

        /* ISOTOPE INIT */
        $(window).on('load', () => {
            if ($isotope.length) {

                $isotope.each(function () {

                    let $isotope_parent = $(this);

                    $(this).isotope({
                        itemSelector: '.rela-js-accordion-item',
                        layoutMode: 'masonry',
                        percentPosition: true,
                        masonry: {
                            gutter: 10
                        }
                    })


                    $isotope_parent.find('.rela-js-accordion').on('click', function (e) {
                        e.preventDefault();

                        let timerId;

                        if ($(this).parent().find('.rela-js-accordion-text').is(':hidden')) {
                            timerId = setInterval(() => $isotope_parent.isotope('layout'), 50);

                        } else {
                            setTimeout(() => {
                                $isotope_parent.isotope('layout');
                            }, 365);
                        }

                        $(this).parent().find('.rela-js-accordion-text').slideToggle(function () {
                            if ($(this).is(':hidden')) {
                                $(this).parent().removeClass('is-open')
                            } else {
                                $(this).parent().addClass('is-open');
                                clearInterval(timerId);
                            }
                        });

                        if (!$(this).closest('.rela-js-accordion-parent').data('multiple')) {
                            $(this).parent().siblings().removeClass('is-open').find('.rela-js-accordion-text').hide(350);
                        }
                    });

                });

            }

        });

})(jQuery, window, document);

	</script>
	<?php
endif;