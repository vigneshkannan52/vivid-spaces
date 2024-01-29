<?php
/**
 * Time Schedule default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

$acacio_fixed_menu = isset($acacio_fixed_menu) && $acacio_fixed_menu ? 'fixed-additional' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-navbar' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-navbar--acacio-additional' );
$this->add_render_attribute( 'wrapper', 'class', $acacio_fixed_menu );


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/navbar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style('acacio-navbar-layout2', $shortcode_dir . 'assets/css/acacio_layout2.css', null, null);
}

wp_enqueue_script( 'acacio-navbar-layout2-js', $shortcode_dir . 'assets/js/acacio_layout2.js', array( 'jquery' ), null ); ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="aheto-navbar--inner">

		<?php wp_nav_menu([
			'container'       => 'div',
			'items_wrap'      => '<ul id="%1$s" class="%2$s widget-nav-menu__menu">%3$s</ul>',
			'container_class' => 'aheto-navbar--acacio-menu-additional ' . $acacio_transparent,
			'menu_class'      => 'menu',
			'menu'            => $acacio_menus,
		]); ?>

	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/acacio_layout2.css'?>" rel="stylesheet">
	<script>

;(function ($, window, document, undefined) {
    "use strict";

    let positionElement = 0;

    if ($('.aheto-navbar--acacio-additional.fixed-additional .aheto-navbar--inner').length) {
        positionElement = $('.aheto-navbar--acacio-additional.fixed-additional .aheto-navbar--inner').offset().top - 1;
    }

    function fixedAdditionalMenuOnScroll() {

        let positionTop = 0;

        if ($('body').hasClass('admin-bar')) {

            let wpAdminBarH = $(window).width() > 782 ? 32 : 46;

            positionTop += wpAdminBarH;
        }

        if ($('.aheto-header.aheto-header--fixed').length) {

            positionTop += $('.aheto-header.aheto-header--fixed').outerHeight();

        }

        const menu = $('.aheto-navbar--acacio-additional.fixed-additional .aheto-navbar--inner');

        if (menu.length) {

            let windowTop = $(window).scrollTop() + positionTop;

            if ( windowTop > positionElement) {

                menu.addClass('aheto-navbar--fixed').css({
                    'top': positionTop - 1,
                    'transition': 'all 0.7s'
                });

            } else if( windowTop <= positionElement ) {

                menu.removeClass('aheto-navbar--fixed');
            }

        }

    }

    $(window).on('load resize scroll orientationchange', function () {

        fixedAdditionalMenuOnScroll();

    });



})(jQuery, window, document);
	</script>
	<?php
endif;