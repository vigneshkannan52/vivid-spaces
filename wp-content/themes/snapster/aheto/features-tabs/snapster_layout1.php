<?php

	/**
	 * The Features Shortcode.
	 *
	 * @since      1.0.0
	 * @package    Aheto
	 * @subpackage Aheto\Shortcodes
	 * @author     KARMA <info@karma.com>
	 */

	use Aheto\Helper;

	extract($atts);

	$tabs = $this->parse_group($snapster_tabs);
	if (empty($tabs)) {
		return '';
	}

	$this->generate_css();

	// Wrapper.
	$this->add_render_attribute('wrapper', 'id', $element_id);
	$this->add_render_attribute('wrapper', 'class', 'aheto-features-tabs--snapster');
	$this->add_render_attribute('wrapper', 'class', 'js-tab');
	$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


	$snapster_reverse = isset( $snapster_reverse ) && $snapster_reverse ? 'reverse' : '';
	$this->add_render_attribute( 'wrapper', 'class', $snapster_reverse );

	/**
	 * Set dependent style
	 */
	$sc_dir = SNAPSTER_T_URI . '/aheto/features-tabs/';
	$custom_css = Helper::get_settings('general.custom_css_including');
	$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
	if (empty($custom_css) || ($custom_css == "disabled")) {
		wp_enqueue_style('snapster-features-tabs-layout1', $sc_dir . 'assets/css/snapster_layout1.css', null, null);
	}
	wp_enqueue_script('snapster-features-tabs-layout1-js', $sc_dir . 'assets/js/snapster_layout1.js', array('jquery'), null);
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>


    <div class="aheto-features-tabs__block__wrap aheto-features-tabs-wrap-js">
        <div class="aheto-features-tabs__list aheto-features-tabs-split-js">
            <ul>

				<?php foreach ($tabs as $index => $item) :

					$heading_tag = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h1';
					$active = $index > 0 ? '' : 'active'; ?>

                    <li data-item="<?php echo esc_attr($index); ?>" class="aheto-features-tabs__list-item tab-lists-split-js <?php echo esc_attr($active); ?>">
	                    <?php
		                    $indexNamber = $index;
		                    $indexNamber++;
		                    echo '<span>' . str_pad($indexNamber, 2, "0", STR_PAD_LEFT)  . '</span>';
	                    ?>
                        <a href="<?php echo esc_attr($item['snapster_main_href']); ?>" class="aheto-features-tabs__list-link ">



							<?php if ( !empty($item['snapster_main_heading'] )) :

								echo esc_html($item['snapster_main_heading']);

							endif; ?>
                        </a>
                    </li>
				<?php endforeach; ?>

            </ul>
        </div>
        <div class="aheto-features-tabs__content">
			<?php foreach ($tabs as $index => $item) :
				$active = $index > 0 ? '' : 'active';
				$background_image = Helper::get_background_attachment($item['snapster_bg_image'], $image_size, $atts, ''); ?>

                <div data-img="<?php echo esc_attr($index); ?>" class="aheto-features-tabs__box tab-img-split-js <?php echo esc_attr($active); ?>">
                    <div class="aheto-features-tabs__box-img" <?php echo esc_attr($background_image); ?>></div>
                </div>

			<?php endforeach; ?>
        </div>
    </div>


</div>