<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

$this->generate_css();

extract($atts);

$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contents--funero-content-accordion');

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contents/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
	wp_enqueue_style('funero-contents-layout3', $shortcode_dir . 'assets/css/funero_layout3.css', null, null);
}
wp_enqueue_script('magnific');
wp_enqueue_script('funero-contents-js-layout3', $shortcode_dir . 'assets/js/funero_layout3.min.js', array('jquery'), null);

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-contents__item-title ">
		<?php if ( !empty($funero_obituaries) && !empty($funero_obituaries_title) ) : ?>
			<h5 class="aheto-contents__title js-accordion-title is-active"
				data-num="1"><?php echo esc_html($funero_obituaries_title); ?></h5>
		<?php endif; ?>
		<?php if ( !empty($funero_photographs) && !empty($funero_photographs_title)) : ?>
			<h5 class="aheto-contents__title js-accordion-title"
				data-num="2"><?php echo esc_html($funero_photographs_title); ?></h5>
		<?php endif; ?>
		<?php if ( !empty($funero_condolences_title)) : ?>
		<h5 class="aheto-contents__title js-accordion-title"
			data-num="3"><?php echo esc_html($funero_condolences_title); ?></h5>
		<?php endif;?>
		<?php if ( !empty($funero_service) && !empty($funero_service_title)) : ?>
			<h5 class="aheto-contents__title js-accordion-title"
				data-num="4"><?php echo esc_html($funero_service_title); ?></h5>
		<?php endif; ?>
	</div>
	<div class="aheto-contents__items ">
		<?php if ( !empty($funero_obituaries) ) {
			echo '<div class="aheto-contents__desc js-is-open js-accordion-content " data-num="1" >' . wp_kses($funero_obituaries, 'post') . '</div>';
		} ?>
		<?php
		if ( !empty($funero_photographs) ) { ?>
			<div class="js-accordion-content aheto-contents__gallery-wrap" data-num="2">
				<?php foreach ( $funero_photographs as $funero_photograph ):
					$background_image = '';
					if(!empty($funero_photograph)) {
						$background_image = \Aheto\Helper::get_background_attachment($funero_photograph, 'medium', $atts);
					}?>
					<figure data-mfp-src="<?php echo esc_url($funero_photograph['url']); ?>"
							class="aheto-contents__gallery">
						<span <?php echo esc_attr($background_image); ?>></span>
					</figure>
				<?php endforeach; ?>
			</div>
		<?php } ?>
		<div class="aheto-contents__desc  js-accordion-content" data-num="3">
			<?php comments_template('', true); ?>
		</div>
		<?php if ( !empty($funero_service) ) {
			echo '<div class="aheto-contents__desc  js-accordion-content" data-num="4">' . wp_kses($funero_service, 'post') . '</div>';
		} ?>
		<?php if ( !empty($funero_bottom_img) ) {
			$bg_image = \Aheto\Helper::get_background_attachment($funero_bottom_img, 'medium', $atts);
			echo '<div class="aheto-contents__bg  " ' . $bg_image . '></div>';

		} ?>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/funero_layout3.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
	"use strict";

	if($('.aheto-contents--funero-content-accordion .js-accordion-content').length){
		$('.aheto-contents--funero-content-accordion .js-accordion-content').hide();
		$('.aheto-contents--funero-content-accordion .js-accordion-content.js-is-open').show();
	}
	$('.aheto-contents--funero-content-accordion .js-accordion-title').on('click', function (e) {
		e.preventDefault();
		$('.aheto-contents--funero-content-accordion .js-accordion-title').removeClass('is-active');
		$(this).addClass('is-active');
		var num = $(this).attr('data-num');
			$('.aheto-contents--funero-content-accordion .js-accordion-content').removeClass('js-is-open').hide(300);
			$('.aheto-contents--funero-content-accordion .js-accordion-content[data-num="' + num + '"]').addClass('js-is-open').show(300);
	});


	function funero_popup() {
		if ($('.aheto-contents--funero-content-accordion .aheto-contents__gallery-wrap').length) {
			$('.aheto-contents--funero-content-accordion .aheto-contents__gallery-wrap').magnificPopup({
				delegate: 'figure',
				type: 'image',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0, 1]
				}
			});
		}
	}

	$(window).on('load', function () {
		funero_popup();


	});
})(jQuery, window, document);
	</script>
	<?php
endif;