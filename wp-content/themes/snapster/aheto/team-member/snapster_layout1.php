<?php
	/**
	 * The Team Shortcode.
	 * @since      1.0.0
	 * @package    Aheto
	 * @subpackage Aheto\Shortcodes
	 * @author     Upqode <info@upqode.com>
	 */

	use Aheto\Helper;

	extract ( $atts );

	$this -> generate_css ();

	// Wrapper.
	$this -> add_render_attribute ( 'wrapper', 'id', $element_id );
	$this -> add_render_attribute ( 'wrapper', 'class', $this -> the_custom_classes () );
	$this -> add_render_attribute ( 'wrapper', 'class', 'aheto-team-member--snapster-simple' );

	// parse networks
	$networks = $this -> parse_group ( $networks );

	/**
	 * Set dependent style
	 */
	$sc_dir = SNAPSTER_T_URI . '/aheto/team-member/';
	$custom_css = Helper ::get_settings ( 'general.custom_css_including' );
	$custom_css = ( isset( $custom_css ) && !empty( $custom_css ) ) ? $custom_css : false;
	if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
		wp_enqueue_style ( 'snapster-team-member-layout1', $sc_dir . 'assets/css/snapster_layout1.css', null, null );
	}
	if( ! is_admin() ) {
		wp_enqueue_script('snapster-team-member-layout1-js', $sc_dir . 'assets/js/snapster_layout1.js', array('jquery'), null);
	}
	?>
<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>
	<?php if ( !empty( $image ) ) : ?>
        <div class="aheto-team-member__img-holder">
			<?php echo Helper ::get_attachment ( $image, [ 'class' => 'aheto-team-member__img' ], $snapster_image_size, $atts, 'snapster_' );
            if ( !empty( $networks ) ) { ?>
                <div class="aheto-team-member__contact">
                    <div class="aheto-team-member__networks">
	                    <?php echo Helper ::get_social_networks ( $networks, '<a class="aheto-team-member__link" href="%1$s"><i class="ion-social-%2$s"></i></a>' ); ?>
                    </div>

                </div>
            <?php }
			?>
        </div>
	<?php endif; ?>

    <div class="aheto-team-member__text">
		<?php
			// Name.
			if ( !empty( $name ) ) {
				echo '<h5 class="aheto-team-member__name">' . wp_kses ( $name, 'post' ) . '</h5>';
			}

			// Designation.
			if ( !empty( $designation ) ) {
				echo '<h6 class="aheto-team-member__position">' . esc_html ( $designation ) . '</h6>';
			}
			?>
    </div>
</div>
