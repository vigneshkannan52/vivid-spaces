<?php
/**
 * Header Menu with centered logo.
 */
use Aheto\Helper;

extract( $atts );

if ( empty( $menus ) ) {
	return;
}

$this->generate_css();

if(isset( $mobile_menu_width ) && is_array($mobile_menu_width) && ! empty( $mobile_menu_width['size'] ) ){
	$mobile_menu_width = $mobile_menu_width['size'];
}elseif (!isset( $mobile_menu_width ) || !is_array($mobile_menu_width) || empty($mobile_menu_width['size'])){
	$mobile_menu_width = 1199;
}

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'main-header main-header--centered' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header-js' );
$this->add_render_attribute( 'wrapper', 'class', $transparent );
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );

$type_logo = isset($type_logo) && !empty($type_logo) ? $type_logo : 'image';


if ( $type_logo == 'image' && is_array( $scroll_logo ) && is_array( $scroll_mob_logo ) ) {

    $scroll_logo     = ! empty( $scroll_logo['id'] ) ? $scroll_logo : $logo;
    $scroll_mob_logo = ! empty( $scroll_mob_logo['id'] ) ? $scroll_mob_logo : $mob_logo;

} elseif ( $type_logo == 'image' && ! is_array( $scroll_logo ) && ! is_array( $scroll_mob_logo ) ) {

    $scroll_logo     = isset( $scroll_logo ) && ! empty( $scroll_logo ) ? $scroll_logo : $logo;
    $scroll_mob_logo = isset( $scroll_mob_logo ) && ! empty( $scroll_mob_logo ) ? $scroll_mob_logo : $mob_logo;

}

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style('acacio-navigation-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null);
}

wp_enqueue_script( 'acacio-navigation-layout1-js', $shortcode_dir . 'assets/js/acacio_layout1.js', array( 'jquery' ), null );

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="main-header__main-line <?php echo esc_attr($acacio_align_right ? 'align-right' : ''); ?>" >
		<a href="<?php echo esc_url(home_url('/')); ?>" class="aheto-logo main-header__logo">
			<?php if ( ! empty( $logo ) && $type_logo == 'image' ) {
				echo Helper::get_attachment( $logo, [ 'class' => 'aheto-logo__image' ] );
			}

            if ( ! empty( $scroll_logo ) && $type_logo == 'image' ) {
                echo Helper::get_attachment( $scroll_logo, [ 'class' => 'aheto-logo__image aheto-logo__image-scroll' ] );
            }

			if ( ! empty( $mob_logo ) && $type_logo == 'image' ) {
				echo Helper::get_attachment( $mob_logo, [ 'class' => 'aheto-logo__image mob-logo' ] );
			}

			if ( ! empty( $scroll_mob_logo ) && $type_logo == 'image' ) {
				echo Helper::get_attachment( $scroll_mob_logo, [ 'class' => 'aheto-logo__image mob-logo aheto-logo__image-mob-scroll' ] );
			}

			if(!empty($text_logo) && $type_logo == 'text' ){ ?>
                <span><?php echo esc_html($text_logo); ?></span>
			<?php }?>
		</a>
		<div class="main-header__menu-box ">

            <span class="mobile-menu-title"><?php esc_html_e( 'Menu', 'aheto' ); ?></span>

			<?php
			wp_nav_menu([
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $menus,
			]);
			?>
		</div>

        <div class="main-header__widget-box">
            <button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/acacio_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    'use strict';

    let mobileMenu = 1199;

    function megaMenu() {

        if ($('header .main-header[data-mobile-menu]').length) {
            mobileMenu = $('header .main-header[data-mobile-menu]').data('mobile-menu');
        }

        let $megaMenuBlock = $('.acacio-header-menu .sub-menu.mega-menu');

        let adminBar = $('#wpadminbar');

        if ( $megaMenuBlock.length && $(window).width() > mobileMenu) {
            if(adminBar.length) {
                $megaMenuBlock.css({
                    width: $('.acacio-header-menu .elementor-row').width() - 170 + 'px',
                    top: $('.acacio-header-menu').height() + 17 + 'px',
                });
            } else {
                $megaMenuBlock.css({
                    width: $('.acacio-header-menu .elementor-row').width() - 170 + 'px',
                    top: $('.acacio-header-menu').height() - 10 + 'px',
                });
            }

        }


    }

    function changeMenuOnScroll () {
        if($(this).scrollTop() > 30) {
            $('.acacio-header-menu .acacio-header-logo').hide();
            $('.acacio-header-menu').find('.elementor-row').first().css({
                'justify-content': 'center'
            })
        } else {
            $('.acacio-header-menu .acacio-header-logo').show();
            $('.acacio-header-menu').find('.elementor-row').first().css({
                'justify-content': 'initial'
            })
        }
    }


    $(window).on('load resize orientationchange', function () {

        $('.main-header--centered').closest('.elementor-section').addClass('acacio-header-menu');

        megaMenu();
    });

    $(window).on('load scroll', function () {
        changeMenuOnScroll();
    });


})(jQuery, window, document);
	</script>
	<?php
endif;