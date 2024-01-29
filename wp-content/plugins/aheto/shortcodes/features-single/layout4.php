<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     FOX-THEMES <info@foxthemes.me>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Button.
$button = $this->get_button_attributes( 'link' );
// Icon.
$icon = $this->get_icon_attributes( '', true, true );
if ( ! empty( $icon ) ) {
	$this->add_render_attribute( 'icon', 'class', 'aheto-content-block__ico aheto-content-block__ico--lg icon' );
	$this->add_render_attribute( 'icon', 'class', $icon['icon'] );
	$this->add_render_attribute( 'icon', 'class', $icon['align'] );
	if ( ! empty( $icon['color'] ) ) {
		$this->add_render_attribute( 'icon', 'style', 'color:' . $icon['color'] );
	}
}

$background_image = Helper::get_background_attachment( $s_image, $image_size, $atts );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'features-single-style-4', $sc_dir . 'assets/css/layout4.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-content-block t-center aheto-content-block--light aheto-content-block--bgImg" <?php echo esc_attr( $background_image ); ?>>

        <div class="aheto-content-block__descr">

			<?php
			if ( ! empty( $s_heading ) ) :
				// Icon.
				if ( ! empty( $icon ) ) {
					echo '<i ' . $this->get_render_attribute_string( 'icon' ) . '></i>';
				}
				?>
                <h3 class="aheto-content-block__title t-light"><?php echo $this->highlight_text( $s_heading ); ?></h3>
			<?php endif; ?>

            <div class="aheto-content-block__info">

				<?php if ( ! empty( $s_description ) ) : ?>
                    <p class="aheto-content-block__info-text">
						<?php echo wp_kses_post( $s_description ); ?>
                    </p><br>
				<?php endif; ?>

				<?php
				if ( isset( $button['href'] ) && ! empty( $button['href'] ) ) :
					$this->add_render_attribute( 'button', $button );
					$this->add_render_attribute( 'button', 'class', 'aheto-link aheto-btn--light' );
					?>
                    <div class="aheto-btn-container t-center">
                        <a <?php $this->render_attribute_string( 'button' ); ?>><?php echo esc_html( $button['title'] ); ?></a>
                    </div>
				<?php endif; ?>

            </div>

        </div>

    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $sc_dir . 'assets/css/layout4.css'?>" rel="stylesheet">
	<?php
endif;