<?php

use Aheto\Helper;

extract( $atts );

// Query.
$the_query = $this->get_wp_query();

if ( ! $the_query->have_posts() ) {
	return;
}

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--karma-political__simple' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/custom-post-types/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'karma-political-custom-post-types-layout2', $shortcode_dir . 'assets/css/karma_political_layout2.css', null, null );
}

wp_enqueue_script( 'karma-political-custom-post-types-layout2-js', $shortcode_dir . 'assets/js/karma_political_layout2.min.js', array('jquery'), null );

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="aheto-cpt__container">
		<?php
			$this->add_excerpt_filter();
			$counter = 1;

			while ( $the_query->have_posts() ) :
				$hide_item = $counter <= 3 ? '' : 'hide-item';
				$the_query->the_post();
		?>

			<div class="aheto-cpt__blog <?php echo esc_attr($hide_item) . ' ' . esc_attr('column-row-' . $karma_political_row); ?> " data-item-limit-showed="<?php echo $karma_political_row ?>">
				<?php $this->get_skin_part( $skin, $atts ); ?>
			</div>

		<?php
			$counter++;

			endwhile;

			$this->remove_excerpt_filter();

			wp_reset_query();
		?>

		<?php if ( $karma_political_load_add_button ) { ?>
	        <div class="aheto-cpt-article__load-button <?php echo esc_attr($this->atts['karma_political_align_btn']); ?>">
	            <?php echo \Aheto\Helper::get_button($this, $atts, 'karma_political_load_'); ?>
	        </div>
	    <?php } ?>

		<?php if ( ! empty( $karma_political_small_image ) ) : ?>
	        <div class="aheto-cpt__small-image">
				<?php echo Helper::get_attachment( $karma_political_small_image, array(), 'medium' ); ?>
	        </div>
		<?php endif; ?>
	</div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/karma_political_layout2.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {

    "use strict";

    let getLengthItem = $('.aheto-cpt--karma-political__simple .aheto-cpt__blog').attr('data-item-limit-showed');
    let checkItem = $('.aheto-cpt__blog').closest('.aheto-cpt--karma-political__simple');

    $('.aheto-cpt--karma-political__simple .aheto-cpt-article__load-button .aheto-btn').on('click', function(e) {
        e.preventDefault();

        let parent = $(this).closest('.aheto-cpt--karma-political__simple');

        if ( parent.find('.aheto-cpt__blog').not('.showed').length >= getLengthItem ) {
            parent.find('.aheto-cpt__blog').not('.showed').slice(0, getLengthItem).addClass('showed').removeClass('hide-item');
            checkItem.find('.hide-item').length == 0 ? $(this).hide() : null;
        } else {
            parent.find('.aheto-cpt__blog').not('.showed').addClass('showed');

            $(this).hide();
        }

    });

    $(window).on('load', function() {
        $('.aheto-cpt__blog').length >= getLengthItem ? $('.aheto-cpt__blog').slice(0, getLengthItem).addClass('showed').removeClass('hide-item') : null;

        checkItem.find('.hide-item').length == 0 ? $('.aheto-cpt--karma-political__simple .aheto-cpt-article__load-button .aheto-btn').hide() : $('.aheto-cpt--karma-political__simple .aheto-cpt-article__load-button .aheto-btn').show();
    });

})(jQuery, window, document);
	</script>
	<?php
endif;