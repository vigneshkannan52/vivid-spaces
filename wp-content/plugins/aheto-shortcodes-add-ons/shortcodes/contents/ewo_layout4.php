<?php

/**
 * The Gallery Shortcode.
 */

use Aheto\Helper;

extract($atts);

wp_enqueue_script('isotope');

$this->generate_css();

$ewo_active = isset($ewo_active) && $ewo_active ? 'active' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-gallery-brands--ewo-isotope');
$this->add_render_attribute('wrapper', 'class', $ewo_active);


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contents/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if (empty($custom_css) || ($custom_css == "disabled")) {
  wp_enqueue_style('ewo-contents-layout4', $shortcode_dir . 'assets/css/ewo_layout4.css', null, null);
}
wp_enqueue_script('ewo-contents-layout4-js', $shortcode_dir . 'assets/js/ewo_layout4.min.js', array('jquery'), null);

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="aheto-gallery-brands__head">
    <ul class="aheto-gallery-brands__list ">
      <?php
      $all_filters = array();
      foreach ($ewo_gallery_brands as $index => $item) :
        $item['ewo_gallery_heading'] = !empty($item['ewo_gallery_heading']) ? $item['ewo_gallery_heading'] : '';
        $filter_heading = str_replace(' ', '_', $item['ewo_gallery_heading']);
        $filter_heading = strtolower($filter_heading);
        if (!in_array($item['ewo_gallery_heading'], $all_filters)) {
          $all_filters[] = $item['ewo_gallery_heading'];
          $active = $index > 0 ? '' : 'active'; ?>
          <li class="aheto-gallery-brands__list-item <?php echo esc_attr($active); ?>">
            <a href="javascript:void(0);" data-gallery-brands-filter="<?php echo esc_html($filter_heading); ?>" class="aheto-gallery-brands__list-link aheto-gallery-brands--ewo-link js-tab-list">
              <?php if (!empty($item['ewo_gallery_heading'])) :
                echo esc_html($item['ewo_gallery_heading']);
              endif; ?>
            </a>
          </li>
      <?php
        }
      endforeach; ?>
    </ul>
  </div>


  <div class="aheto-gallery-brands__content">
    <?php foreach ($ewo_gallery_brands as $index => $item) :
      $filter_heading = str_replace(' ', '_', $item['ewo_gallery_heading']);
      $filter_heading = strtolower($filter_heading);
      $item_width     = str_replace(' ', '_', $item['ewo_gallery_size']);
      $image        = $item['ewo_gallery_img'];
    ?>
      <div class="aheto-gallery-brands__box js-isotope-box <?php echo esc_attr($active); ?> <?php echo esc_attr($filter_heading); ?> <?php echo esc_attr($item_width); ?>">
        <a href="<?php echo esc_url($image['url']); ?>">
        </a>
        <?php if (!empty($item['ewo_gallery_img'])) { ?>
          <?php echo Helper::get_attachment($item['ewo_gallery_img'], ['class' => 'js-bg aheto-gallery-brands-box__add-image']); ?>
        <?php } ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/ewo_layout4.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    "use strict";
    const $isotope = $('.aheto-gallery-brands--ewo-isotope .aheto-gallery-brands__content');

    $(() => {

        // ISOTOPE FILTER
        $('.aheto-gallery-brands--ewo-link[data-gallery-brands-filter]').on('click', function (e) {
            e.preventDefault();

            const $this = $(this);

            const filterValue = $this.attr('data-gallery-brands-filter');

            $isotope.isotope({
                filter: '.' + filterValue
            });
        });

        $(window).on('load', function () {
            initIsotope();
            initialFiltering();
        })

        // Magnific Popup gallery

        $('.aheto-gallery-brands__content').magnificPopup({
            delegate: '.aheto-gallery-brands__box:visible a',
            type: 'image',
            gallery: {
                enabled: true
            },
            removalDelay: 500,
            callbacks: {
                beforeOpen: function () {
                    this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                    this.st.mainClass = this.st.el.attr('data-effect');
                }
            },
            closeOnContentClick: true,
            midClick: true
        });
    });

    function initIsotope() {
        if ($isotope.length) {
            $isotope.each(function () {
                $(this).isotope({
                    itemSelector: '.js-isotope-box',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.js-isotope-box',
                        "gutter": 23,
                    }
                })
            });
        }
    }

    function initialFiltering() {
        let $firstFilterValue = $('[data-gallery-brands-filter]').first().attr('data-gallery-brands-filter');

        $isotope.isotope({
            filter: '.' + $firstFilterValue
        });
    }

    if (window.elementorFrontend) {
        initIsotope();
        initialFiltering();
    }
})(jQuery, window, document);
	</script>
	<?php
endif;