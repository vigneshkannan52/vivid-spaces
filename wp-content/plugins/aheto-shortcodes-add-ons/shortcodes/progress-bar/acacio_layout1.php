<?php
/**
 * The Progress Bar Shortcode.
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
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-progress');
$this->add_render_attribute( 'wrapper', 'class', 'aheto-progress--acacio-inline' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/progress-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style( 'acacio-progress-bar-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null );

}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-progress aheto-progress--bar">

		<?php
		// Heading.
		if ( !empty($heading) ) {
			echo '<h6 class="aheto-progress__title">' . wp_kses_post($heading) . '</h6>';
		}
		?>

		<div class="aheto-progress__bar prog-bar">
			<div class="aheto-progress__bar-holder prog-bar-hldr">
				<span class="aheto-progress__bar-perc prog-bar-perc t-medium"><?php echo absint($percentage); ?></span>
            </div>
            <div class="aheto-progress__bar-val prog-bar-val"></div>
		</div>

	</div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/acacio_layout1.css'?>" rel="stylesheet">
	<?php
endif;