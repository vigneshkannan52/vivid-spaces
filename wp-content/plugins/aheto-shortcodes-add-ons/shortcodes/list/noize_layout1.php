<?php
/**
 * The List Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$lists = $this->parse_group($noize_table_lists);

if (empty($lists)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-list--noize' );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/list/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( empty($custom_css) || ($custom_css == "disabled") ) {
    wp_enqueue_style( 'noize-list-layout1', $shortcode_dir . 'assets/css/noize_layout1.css', null, null );
}

wp_enqueue_script( 'noize-list-layout1-js', $shortcode_dir . 'assets/js/noize_layout1.js', array('jquery'), null );

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-list--noize--links-items"> 
        <?php

        $counter = 1;

        foreach ($lists as $item) {
            $hide_item = $counter > 5 && $noize_load_add_button ? 'hide-item' : ''; ?>

            <div class="aheto-list--noize--row <?php echo esc_attr($hide_item); ?>">
                <div class="aheto-list--noize--column">
                    <div class="aheto-list--noize--box-white item-align-<?php echo esc_attr($item['noize_align_item']); ?>">
                        <h5><?php echo wp_kses($item['noize_first_item'], 'post'); ?></h5>
                    </div>
                </div>
                <div class="aheto-list--noize--column">
                    <?php echo wp_kses($item['noize_second_item'], 'post'); ?>
                </div>
                <div class="aheto-list--noize--column">
                    <?php echo wp_kses($item['noize_third_item'], 'post'); ?>
                </div>
                <div class="aheto-list--noize--column">
                    <div class="aheto-list--noize--box-no-bg">
                        <?php if ($item['noize_main_add_button']) { ?>
                            <div class="aheto-list--noize__links">
                                <?php echo Aheto\Helper::get_button($this, $item, 'noize_main_'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php
            $counter++;

        } ?>
    </div>

    <div class="aheto-list--noize-links-button <?php echo esc_attr($this->atts['noize_align']); ?>">
        <?php if ( $noize_load_add_button ) {
            echo \Aheto\Helper::get_button($this, $atts, 'noize_load_');
        } ?>
    </div>


</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/noize_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    "use strict";

    $('.aheto-list--noize .aheto-list--noize-links-button .aheto-btn, .aheto-list--noize .aheto-list--noize-links-button .cs-btn').on('click', function (e) {
        e.preventDefault();

        let parent = $(this).closest('.aheto-list--noize');

        if ( parent.find('.hide-item').length >= 5 ){
            parent.find('.hide-item').slice(0, 5).removeClass('hide-item');
        } else {
            parent.find('.hide-item').removeClass('hide-item');
            $(this).hide();
        }
    });

    $(window).on('load', function() {
        let checkItem = $('.aheto-list--noize--row').closest('.aheto-list--noize');

        checkItem.find('.hide-item').length == 0 ? $('.aheto-list--noize .cs-btn').hide() : $('.aheto-list--noize .cs-btn').show();
    });

})(jQuery, window, document);
	</script>
	<?php
endif;