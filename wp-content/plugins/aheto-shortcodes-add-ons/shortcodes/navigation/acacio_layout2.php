<?php
/**
 * Header Modern Menu.
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
$this->add_render_attribute( 'wrapper', 'class', 'main-header' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header--simple-button' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header-js' );
$this->add_render_attribute( 'wrapper', 'class', $transparent );
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );

$type_logo = isset( $type_logo ) && ! empty( $type_logo ) ? $type_logo : 'image';


if ( $type_logo == 'image' && is_array( $scroll_logo ) && is_array( $scroll_mob_logo ) ) {

	$scroll_logo     = ! empty( $scroll_logo['id'] ) ? $scroll_logo : $logo;
	$scroll_mob_logo = ! empty( $scroll_mob_logo['id'] ) ? $scroll_mob_logo : $mob_logo;

} elseif ( $type_logo == 'image' && ! is_array( $scroll_logo ) && ! is_array( $scroll_mob_logo ) ) {

	$scroll_logo     = isset( $scroll_logo ) && ! empty( $scroll_logo ) ? $scroll_logo : $logo;
	$scroll_mob_logo = isset( $scroll_mob_logo ) && ! empty( $scroll_mob_logo ) ? $scroll_mob_logo : $mob_logo;

}

$button = $this->get_button_attributes( 'acacio_nav_main_' );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style('acacio-navigation-layout2', $shortcode_dir . 'assets/css/acacio_layout2.css', null, null);

}
wp_enqueue_script( 'acacio-navigation-layout2-js', $shortcode_dir . 'assets/js/acacio_layout2.js', array( 'jquery' ), null );

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="main-header__main-line">
        <div class="aheto-logo main-header__logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
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


				if ( ! empty( $text_logo ) && $type_logo == 'text' ) { ?>
                    <span><?php echo esc_html( $text_logo ); ?></span>
				<?php } ?>
            </a>
        </div>

		<div class="main-header__menu-box <?php echo esc_attr($type_logo); ?>">


			<?php
			wp_nav_menu( [
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $menus,
			] );
			?>

            <div class="main-header__widget-box-mobile">

                <?php if ( $search ) : ?>

                    <a class="main-header__widget-box--search search-btn js-open-search" href="#">
                        <i class="icon ion-android-search" aria-hidden="true"></i>
                    </a>

                <?php endif; ?>

                <?php if ( isset($acacio_main_mob_add_button) && !empty($acacio_main_mob_add_button) ) { ?>
                    <?php echo Helper::get_button($this, $atts, 'acacio_nav_main_mob_'); ?>
                <?php } ?>
            </div>
		</div>
		<div class="main-header__widget-box">

            <div class="main-header__widget-box-desktop">
	            <?php if ( $search ) : ?>

                    <a class="main-header__widget-box--search search-btn js-open-search" href="#">
                        <i class="icon ion-android-search" aria-hidden="true"></i>
                    </a>

	            <?php endif; ?>

				<?php if ( isset($acacio_main_add_button) && !empty($acacio_main_add_button) ) { ?>
					<?php echo \Aheto\Helper::get_button($this, $atts, 'acacio_nav_main_'); ?>
				<?php } ?>
            </div>

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
	<link href="<?php echo $shortcode_dir . 'assets/css/acacio_layout2.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    'use strict';

    let mobileMenu = 1199;
    let prevScrollpos = window.pageYOffset;

    function subMenuPositioning(block, item) {
        let $megaMenuBlock = $(block);
        let $megaMenuItem = $(item);

        if ( $megaMenuBlock.length && $(window).width() > 1024 ) {
            $megaMenuBlock.css({
                'left' : - ( ( $megaMenuBlock.outerWidth(true) / 2 ) - ( $megaMenuItem.width() / 2 ) )
            });
        }
    }

    function hideMenuOnScroll() {

        if ($('header .main-header[data-mobile-menu]').length) {
            mobileMenu = $('header .main-header[data-mobile-menu]').data('mobile-menu');
        }

        let currentScrollPos = window.pageYOffset;
        let headerHeight = $('.acacio-header-2-top').outerHeight();

        if($(window).width() > mobileMenu) {
            if (prevScrollpos > currentScrollPos) {

                $('.acacio-header-2-top').css({
                    'margin-top': `0px`,
                    'transition': '0.5s'
                });

            } else {
                $('.acacio-header-2-top').css({
                    'margin-top': `-${headerHeight}px`,
                    'transition': '0.5s'
                });


            }

            if(currentScrollPos == 0 || currentScrollPos < 100) {
                $('.acacio-header-2-top').css({
                    'margin-top': `0px`,
                    'transition': '0.5s'
                });
                if($('.main-header--simple-button .main-header__hamburger').hasClass('is-active')) {
                    $('.acacio-header-2-top').css({
                        'margin-top': `-${headerHeight}px`,
                        'transition': '0.5s'
                    });
                }
            }

            prevScrollpos = currentScrollPos;
        }
    }

    $(window).on('load scroll', function () {
        hideMenuOnScroll();
    });

})(jQuery, window, document);
	</script>
	<?php
endif;