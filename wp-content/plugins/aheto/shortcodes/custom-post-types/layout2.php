<?php
/**
 * Custom Post Type Masonry Layout.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     FOX-THEMES <info@foxthemes.me>
 */

use Aheto\Helper;

extract( $atts );
$atts['layout'] = 'grid';

// Query.
$the_query = $this->get_wp_query();
if ( ! $the_query->have_posts() ) {
	return;
}

$skin = isset( $skin ) && ! empty( $skin ) ? $skin : 'skin-1';

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--grid' );
$this->add_render_attribute( 'wrapper', 'class', $skin ? 'js-popup-gallery' : '' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'custom-post-types-style-2', $sc_dir . 'assets/css/layout2.css', null, null );
}

wp_enqueue_script( 'isotope' ); ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	$this->add_excerpt_filter();
	$content = [];
	$filters = [];

	$content[] = '<div class="aheto-cpt-article aheto-cpt-article--size" style = "position: absolute;left: 0%;top: 0px;"></div>';

	$id = 'aheto_cpt_' . rand( 0, 1000 );

	$counter = 1;

	while ( $the_query->have_posts() ) :
		$the_query->the_post();

		ob_start();

		$terms_list = get_the_terms( get_the_ID(), $terms );

		if ( isset($terms_list) && is_array($terms_list) ) {
			$filters = array_merge( $filters, $terms_list );
		}

		$this->get_skin_part( $skin, $atts, $counter );

		$content[] = ob_get_clean();
		$counter++;
	endwhile;

	$this->remove_excerpt_filter();

	$this->cpt_filter( $add_filter, $filters, $id, $all_items_text, $add_center_filter );

	echo '<div class="aheto-cpt__list js-isotope" data-cpt-id="' . esc_attr( $id ) . '">' . join( "\n", $content ) . '</div>';

	$this->cpt_load_more( $atts, $the_query->max_num_pages, $id );
	$this->cpt_pagination( $atts, $the_query->max_num_pages );

	wp_reset_query(); ?>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $sc_dir . 'assets/css/layout2.css'?>" rel="stylesheet">
	<?php
endif;