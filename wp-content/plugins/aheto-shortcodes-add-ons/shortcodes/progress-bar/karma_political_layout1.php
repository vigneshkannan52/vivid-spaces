<?php

/**
 * The Progress Bar Shortcode.
 */

extract($atts);

use Aheto\Helper;

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-counter__karma-political');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/progress-bar/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style( 'karma-political-progress-bar-layout1', $shortcode_dir . 'assets/css/karma_political_layout1.css', null, null );
}

wp_enqueue_script( 'karma-political-progress-bar-layout1-js', $shortcode_dir . 'assets/js/karma_political_layout1.js', array( 'jquery' ), null );

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="aheto-counter--karma-political-number">
	    <?php
	        if ( ! empty( $karma_political_image ) ) {
                echo \Aheto\Helper::get_attachment( $karma_political_image, [ 'class' => 'aheto-counter__image' ], $karma_political_image_size, $atts, 'karma_political_' );
	        }
	    
		    if ( ! empty( $percentage ) ) {
	            echo '<h2 class="aheto-counter__number js-counter">' . absint($percentage) . '</h2>';
		    }

		    if ( ! empty( $description ) ) {
	            echo '<p class="aheto-counter__desc">' . wp_kses_post($description) . '</p>';
		    }
	    ?>
    </div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/karma_political_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document) {
    "use strict";

    let lengthCounter = $('.aheto-counter--karma-political-number').length;

    for (let i = 0; i < lengthCounter; i++ ) {
        let getContainer = $('.aheto-counter--karma-political-number').eq(i).find('.aheto-counter__number');
        let getNumb = $('.aheto-counter--karma-political-number').eq(i).find('.aheto-counter__number').html();

        counterFunction(getNumb, getContainer);
    }

    function counterFunction(count, container) {
        if ( count >= 1000 ) {
            let mathAlg = Math.round((count / 1000) * 10) / 10 + 'k';

            return container.html(mathAlg);
        } else {
            return count;
        }
    }

})(jQuery, window, document);
	</script>
	<?php
endif;