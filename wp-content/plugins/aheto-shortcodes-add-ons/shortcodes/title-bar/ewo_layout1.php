<?php

/**
 * Title bar default templates.
 */

use Aheto\Helper;

extract($atts);
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-titlebar--ewo');

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/title-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
  wp_enqueue_style('ewo-title-bar-layout1', $shortcode_dir . 'assets/css/ewo_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <div class="aheto-titlebar__main">
    <div class="aheto-titlebar__content">
      <div class="aheto-titlebar__content-inner">
        <?php if (!empty($searchform)) : ?>
          <div class="aheto-titlebar__input <?php echo Helper::get_button($this, $atts, 'sf_', true); ?>">
            <form role="search" class="w-800" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
              <label class="screen-reader-text" for="s">Search: </label>
              <input type="text" value="" name="s" id="s" placeholder="<?php echo esc_html($sf_placeholder); ?>" />
              <?php if (!empty($sf_button)) { ?>
                <input type="submit" id="searchsubmit" value="<?php echo esc_html($sf_button); ?>" />
              <?php } else { ?>
                <div class="submit-wrap ion-ios-search">
                  <input class="not-value" type="submit" id="searchsubmit" value="" />
                </div>
              <?php } ?>
            </form>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/ewo_layout1.css'?>" rel="stylesheet">
	<?php
endif;