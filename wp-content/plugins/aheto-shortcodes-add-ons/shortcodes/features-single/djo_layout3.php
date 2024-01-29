<?php
/**
 * The Features Shortcode.
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
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content--djo-with-image js-svg-replace');

$use_dot = isset($use_dot) && $use_dot == true ? 'djo-dot' : '';

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('djo-features-single-layout3', $shortcode_dir . 'assets/css/djo_layout3.css', null, null);
}
wp_enqueue_script( 'djo-features-single-layout3-js', $shortcode_dir . 'assets/js/djo_layout3.min.js', array( 'jquery' ), null );

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-content-block__wrap">
			<?php if ( ! empty($s_image['url']) ) : 
				$image_alt = get_the_title($s_image['id']) ? get_the_title($s_image['id']) : 'icon';	
			?>
			
				<div class="aheto-content-block__image">
					<img src="<?php echo esc_url( $s_image['url'] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="svg">
				</div>
			<?php endif; ?>

			<div class="aheto-content-block__inner">

				<div class="aheto-content-block__content">

					<?php if ( ! empty( $s_heading ) ) : ?>
						<h5 class="aheto-content-block__title"><?php echo esc_html($s_heading); ?></h5>
					<?php endif; ?>

					<div class="aheto-content-block__info">
						<?php if ( ! empty( $s_description ) ) : ?>
							<p class="aheto-content-block__info-text ">
								<?php echo wp_kses_post($s_description); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/djo_layout3.css'?>" rel="stylesheet">
	<script>
(function ($, window, document, undefined) {
	"use strict";

	/**
	 * Geneare random ID
	 */

	function makeid(length) {
		var result = "";
		var characters =
			"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		var charactersLength = characters.length;
		for (var i = 0; i < length; i++) {
			result += characters.charAt(
				Math.floor(Math.random() * charactersLength)
			);
		}
		return result;
	}

	/*
	 * Replace all SVG images with inline SVG
	 */

	function replaceSVG() {
		if ($('.aheto-content--djo-with-image').length) {
			jQuery(".aheto-content--djo-with-image img.svg").each((i, e) => {
				const $img = jQuery(e);
				const imgID = $img.attr("id");
				const imgClass = $img.attr("class");
				const imgURL = $img.attr("data-lazy-src") || $img.attr("src");

				jQuery.get(
					imgURL,
					data => {
						// Get the SVG tag, ignore the rest
						let $svg = jQuery(data).find("svg");

						// Add replaced image's ID to the new SVG
						if (typeof imgID !== "undefined") {
							$svg = $svg.attr("id", imgID);
						}
						// Add replaced image's classes to the new SVG
						if (typeof imgClass !== "undefined") {
							$svg = $svg.attr("class", `${imgClass}replaced-svg`);
						}

						// Remove any invalid XML tags as per http://validator.w3.org
						$svg = $svg.removeAttr("xmlns:a");

						// Check if the viewport is set, if the viewport is not set the SVG wont't scale.
						if (
							!$svg.attr("viewBox") &&
							$svg.attr("height") &&
							$svg.attr("width")
						) {
							$svg.attr(
								`viewBox 0 0  ${$svg.attr("height")} ${$svg.attr(
									"width"
								)}`
							);
						}

						//add an unique id
						$svg.find("linearGradient").each(function () {
							let $this = $(this);
							const id = makeid(4);
							$(this).attr("id", id);
							$(this)
								.next()
								.css("fill", `url(#${id})`);
						});

						// Replace image with new SVG
						$img.replaceWith($svg);
					},
					"xml"
				);
			});
		}
	}

	window.addEventListener("load", replaceSVG);
})(jQuery, window, document);
	</script>
	<?php
endif;