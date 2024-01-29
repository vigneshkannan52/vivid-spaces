<?php
/**
 * Custom Post Type Masonry Layout.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */
use Aheto\Helper;

extract($atts);
$atts['layout'] = 'grid';

// Query.
$the_query = $this->get_wp_query();
if ( !$the_query->have_posts() ) {
	return;
}

$skin = isset($skin) && !empty($skin) ? $skin : 'skin-1';

// Wrapper.
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-cpt');
$this->add_render_attribute('wrapper', 'class', 'aheto-cpt--karma_construction-grid');
$this->add_render_attribute('wrapper', 'class', $skin ? 'js-popup-gallery' : '');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/custom-post-types/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('karma_construction-custom-post-types--layout1', $shortcode_dir . 'assets/css/karma_construction_layout1.css', null, null);
}wp_enqueue_script('karma_construction-custom-post-types--layout1-js', $shortcode_dir . 'assets/js/karma_construction_layout1.js', array('jquery'), null);

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php
	$this->add_excerpt_filter();
	$content = [];
	$filters = [];

	$content[] = '<div class="aheto-cpt-article aheto-cpt-article--size"></div>';

	$id = 'aheto_cpt_' . rand(0, 1000);
	while ( $the_query->have_posts() ) :
		$the_query->the_post();

		ob_start();

		$terms_list = get_the_terms(get_the_ID(), $terms);

		if ( !empty($terms_list) ) {
			$filters = array_merge($filters, $terms_list);
		}

		$this->get_skin_part($skin, $atts);

		$content[] = ob_get_clean();
	endwhile;

	$this->remove_excerpt_filter();
	if ( $karma_construction_add_filter ) { ?>

		<div class="aheto-cpt-filter">
			<?php if(!empty($karma_construction_title)):?>
			<div class="aheto-cpt-filter__name">
				<?php echo esc_html($karma_construction_title);?>
			</div>
			<?php endif;?>
			<ul class="aheto-cpt-filter__cat">
				<li class="aheto-cpt-filter__item aheto-cpt-filter__item--all">
					<a href="#" class="is-active" data-cpt-filter="*"
					   data-cpt-id="<?php echo esc_attr($id); ?>"><?php echo esc_html($karma_construction_all_items_text); ?></a>
				</li>

				<?php

				$filters_unique = [];
				foreach ( $filters as $current ) {
					if ( !in_array($current, $filters_unique) ) {
						$filters_unique[] = $current;
					}
				}
				$num = 0;
				foreach ( $filters_unique as $term ) :
					$num++;
					if ( $num <= 4 ): ?>
						<li class="aheto-cpt-filter__item">
							<a href="#" data-cpt-filter=".filter-<?php echo esc_attr($term->slug); ?>"
							   data-cpt-id="<?php echo esc_attr($id); ?>"><?php echo esc_html($term->name); ?></a>
						</li>
					<?php endif;
				endforeach; ?>
			</ul>
			<?php if ( $karma_construction_main_add_button ) { ?>
				<div class="aheto-cpt__links">
					<?php echo Helper::get_button($this, $atts, 'karma_construction_main_'); ?>
				</div>
			<?php } ?>
		</div>
		<?php
	}

	echo '<div class="aheto-cpt__list js-isotope" data-cpt-id="' . esc_attr($id) . '">' . join("\n", $content) . '</div>';

	$this->cpt_load_more($atts, $the_query->max_num_pages, $id);
	$this->cpt_pagination($atts, $the_query->max_num_pages, $id);
	wp_reset_query(); ?>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/karma_construction_layout1.css'?>" rel="stylesheet">
	<script>
/*eslint no-undef:0*/


;(function ($, window, document, undefined) {
	"use strict";
	const $isotope = $('.aheto-cpt--karma_construction-grid .js-isotope');
	const isotopes = [];

	function isotope_init() {
		if ($isotope.length) {

			$isotope.each(function ()  {
				let layout = $(this).attr('data-layout') || 'masonry';
				let id = $(this).attr('data-cpt-id');
				isotopes[id] = $(this).isotope({
					percentPosition: true,
					layoutMode: layout,
					masonry: {
						columnWidth: '.aheto-cpt-article--size',
					},
					hiddenStyle: {
						opacity: 0,
					},
					visibleStyle: {
						opacity: 1,
					}
				})
			});

		}
	}

	/* ISOTOPE INIT */
	$(window).on('load', () => {
		isotope_init();
	});

	/* ISOTOPE FILTER */
	$('.aheto-cpt--karma_construction-grid .aheto-cpt-filter__item a').on('click', function (e) {
		e.preventDefault();
		var $element = $('.aheto-cpt--karma_construction-grid .aheto-cpt-article');
		$element.css('opacity', 0);
		isotope_filter($(this));

		setTimeout(function () {
			$element.css('opacity', 1);
		}, 700);
	});

	function isotope_filter($this) {
		let filterValue = $this.attr('data-cpt-filter');
		let id = $this.attr('data-cpt-id');

		$('[data-cpt-id=' + id + ']').removeClass('is-active');

		$this.addClass('is-active');
		isotopes[id].isotope({
			filter: filterValue,
			hiddenStyle: {
				opacity: 0,
			},
			visibleStyle: {
				opacity: 1,
			}
		});
	}

})(jQuery, window, document);
	</script>
	<?php
endif;