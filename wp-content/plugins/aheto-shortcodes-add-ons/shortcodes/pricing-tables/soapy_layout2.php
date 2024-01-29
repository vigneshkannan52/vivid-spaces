<?php
/**
 * The Pricing Tables Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

wp_enqueue_script('isotope');

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--soapy-isotope');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', $soapy_active);

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
	wp_enqueue_style('soapy-pricing-tables-layout2', $shortcode_dir . 'assets/css/soapy_layout2.css', null, null);
wp_enqueue_script('soapy-pricing-tables-layout2-js', $shortcode_dir . 'assets/js/soapy_layout2.js', array('jquery'), null);

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-pricing__head">
		<ul class="aheto-pricing__list ">
			<li class="aheto-pricing__list-item active">

				<a href="#" data-pricing-filter="*" class="aheto-pricing__list-link js-tab-list">
					<?php esc_html_e('All', 'soapy'); ?>
				</a>
			</li>
			<?php
			$all_filters        = array();
			foreach ( $soapy_pricings as $index => $item ) :
				$item['soapy_pricings_heading'] = !empty($item['soapy_pricings_heading']) ? $item['soapy_pricings_heading'] : '';
				$filter_heading = str_replace(' ', '_', $item['soapy_pricings_heading']);
				$filter_heading = strtolower($filter_heading);
				if ( !in_array($item['soapy_pricings_heading'], $all_filters) ) {

					$all_filters[] = $item['soapy_pricings_heading'];
					$heading_tag   = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h1';
					$active        = $index > 0 ? '' : 'active'; ?>

					<li class="aheto-pricing__list-item ">
						<a href="#" data-pricing-filter=".<?php echo esc_html($filter_heading); ?>"
						   class="aheto-pricing__list-link js-tab-list">
							<?php if ( $item['soapy_pricings_heading'] ) :

								echo esc_html($item['soapy_pricings_heading']);

							endif; ?>
						</a>
					</li>
					<?php
				}
			endforeach; ?>
		</ul>
	</div>

	<div class="aheto-pricing__content">
		<?php foreach ( $soapy_pricings as $index => $item ) :
			$filter_heading = str_replace(' ', '_', $item['soapy_pricings_heading']);
			$filter_heading = strtolower($filter_heading);
			$is_label = !empty($item['soapy_pricings_label']) && isset($item['soapy_pricings_label']) ? 'is-label' : '';
			?>

			<div class="aheto-pricing__box js-isotope-box <?php echo esc_attr($filter_heading); ?> <?php echo esc_attr($is_label); ?>">
				<div class="aheto-pricing__box-inner">
					<div class="aheto-pricing__box-header">
						<?php if ( !empty($item['soapy_pricings_title']) ) : ?>
							<div class="aheto-pricing__box-title-wrap">
								<h5 class="aheto-pricing__box-title">
									<?php echo wp_kses($item['soapy_pricings_title'], 'post'); ?>
								</h5>
								<span  class="aheto-pricing__box-label">
                                    <?php
									if ( !empty($item['soapy_pricings_label']) ) {
										echo wp_kses($item['soapy_pricings_label'], 'post');
									}
									?>
                                </span>
							</div>
						<?php endif; ?>
						<?php if ( !empty($item['soapy_pricings_price']) ): ?>
							<h5 class="aheto-pricing__box-price">
								<?php echo wp_kses($item['soapy_pricings_price'], 'post'); ?>
							</h5>
						<?php endif; ?>
					</div>
					<div class="aheto-pricing__box-content">
						<?php if ( !empty($item['soapy_pricings_descr']) ): ?>
							<p class="aheto-pricing__box-descr">
								<?php echo wp_kses($item['soapy_pricings_descr'], 'post'); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/soapy_layout2.css'?>" rel="stylesheet">
	<script>
/*eslint no-undef:0*/


;(function ($, window, document, undefined) {
    "use strict";

    const $isotope = $('.aheto-pricing--soapy-isotope .aheto-pricing__content');
    if ( window.elementorFrontend )  {
        isotopeInit();
    }

    $( () => {
            isotopeInit();

        $('.aheto-pricing__list-item a')
            .on('click', function () {
                $('.aheto-pricing__list-item a')
                    .removeClass('active');
                $(this)
                    .addClass('active');
                var filterValue = $(this).attr('data-pricing-filter');
                $isotope.isotope({
                    filter: filterValue
                });
            });
    });

    function isotopeInit() {
        if ($isotope.length) {
            $isotope.each(function () {
                $(this).isotope({
                    itemSelector: '.js-isotope-box',
                    layoutMode: 'masonry',
                    percentPosition: true,
                    masonry: {
                        gutter: 15
                    }
                })
            });

        }
    }


})(jQuery, window, document);
	</script>
	<?php
endif;