<?php

/**
 * Contact Info default templates.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

$vestry_use_background  = isset($vestry_use_background) && $vestry_use_background  ? 'bb' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'widget_aheto__audio--vestry');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', $vestry_use_background);

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contact-info/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
    wp_enqueue_style('vestry-contact-info-layout2', $shortcode_dir . 'assets/css/vestry_layout2.css', null, null);
}
wp_enqueue_script('vestry-contact-info-layout2-js', $shortcode_dir . 'assets/js/vestry_layout2.min.js', array('jquery'), null);

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="widget_aheto__title-wrapper">
        <div class="widget_aheto__infos">
            <?php
            if (!empty($vestry_download)) : ?>
                <a class="widget_aheto__link" href="<?php echo esc_attr($vestry_download); ?>" download>
                    <?php echo wp_kses($this->get_icon_for('download'), 'post'); ?>
                </a>
            <?php endif;
            if (!empty($vestry_call)) : ?>
                <a class="widget_aheto__link clickAud" href="javascript:void(0);">
                    <?php echo wp_kses($this->get_icon_for('call'), 'post'); ?>
                    <audio id="audio_id" src="<?php echo esc_attr($vestry_call); ?>"></audio>
                </a>
            <?php endif;
            if (!empty($vestry_copy)) : ?>
                <a class="widget_aheto__link" href="<?php echo esc_attr($vestry_copy); ?>">
                    <?php echo wp_kses($this->get_icon_for('copy'), 'post'); ?>
                </a>
            <?php endif;
            if (!empty($vestry_audio)) : ?>
                <a class="widget_aheto__link" href="<?php echo esc_attr($vestry_audio); ?>">
                    <?php echo wp_kses($this->get_icon_for('audio'), 'post'); ?>
                </a>
            <?php endif;
            ?>
        </div>
    </div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/vestry_layout2.css'?>" rel="stylesheet">
	<script>
; (function ($, window, document, undefined) {

  function playAudio() {
    $(".widget_aheto__audio--vestry .clickAud").on('click', function () {
      stopAudio();

      const audio = $(this).find("audio").get(0);

      if (!$(this).hasClass('playAud')) {
        audio.play();
        $(this).addClass('playAud');
      } else {
        audio.pause();
        $(this).removeClass('playAud');
      }
    });
  }

  function stopAudio() {
    const $audios = document.querySelectorAll('audio');

    $audios.forEach((element) => {
      element.pause();
    });
  }

  playAudio();

})(jQuery, window, document);
	</script>
	<?php
endif;