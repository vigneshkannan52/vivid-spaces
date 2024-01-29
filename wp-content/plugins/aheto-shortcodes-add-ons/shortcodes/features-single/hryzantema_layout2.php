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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--hr-simple-image');


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/features-single/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('hryzantema-features-simple-layout2', $shortcode_dir . 'assets/css/hryzantema_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div <?php $this->render_attribute_string('block_wrapper'); ?>>
        <div class="aheto-features-block__shape"></div>
        <div class="aheto-features-block__wrap <?php echo esc_attr($hryzantema_content_orientation) ?>">

            <?php if ( !empty($s_image)  ) : ?>
                <?php echo \Aheto\Helper::get_attachment( $s_image, ['class' => 'aheto-features-block__image'], $hryzantema_image_size, $atts, 'hryzantema_' ); ?>
            <?php endif; ?>

            <div class="aheto-features-block__content">
                <?php if ( !empty($hryzantema_title) ) : ?>
                    <h5 class="aheto-features-block__title"><?php echo esc_html($hryzantema_title); ?></h5>
                <?php endif; ?>

                <div class="aheto-features-block__info">
                    <?php if ( !empty($hryzantema_description)) : ?>
                        <p class="aheto-features-block__info-text ">
                            <?php echo wp_kses_post($hryzantema_description); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/hryzantema_layout2.css'?>" rel="stylesheet">
	<?php
endif;