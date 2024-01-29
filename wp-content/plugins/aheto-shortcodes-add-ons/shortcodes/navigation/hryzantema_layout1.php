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

if ( isset( $mobile_menu_width ) && is_array( $mobile_menu_width ) && ! empty( $mobile_menu_width['size'] ) ) {
	$mobile_menu_width = $mobile_menu_width['size'];
} elseif ( ! isset( $mobile_menu_width ) || ! is_array( $mobile_menu_width ) || empty( $mobile_menu_width['size'] ) ) {
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

$button = $this->get_button_attributes( 'hryzantema_nav_main_' );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/navigation/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('hryzantema-navigation-layout1', $shortcode_dir . 'assets/css/hryzantema_layout1.css', null, null);
}
wp_enqueue_script( 'hryzantema-navigation-layout1-js', $shortcode_dir . 'assets/js/hryzantema_layout1.js', array( 'jquery' ), null );

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

		<div class="main-header__menu-box">
			<span class="mobile-menu-title"><?php esc_html_e('Menu', 'hryzantema'); ?></span>


			<?php
			wp_nav_menu( [
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $menus,
			] );
			?>
            <div class="main-header__widget-box-mobile">

                <?php if ( $search == true) : ?>

                    <a class="main-header__widget-box--search search-btn js-open-search" href="#">
                        <i class="icon ion-android-search" aria-hidden="true"></i>
                    </a>

                <?php endif; ?>

                <?php if ( isset($hryzantema_nav_main_mob_add_button ) &&  $hryzantema_nav_main_mob_add_button == true) { ?>
                    <?php echo Helper::get_button($this, $atts, 'hryzantema_nav_main_mob_'); ?>
                <?php } ?>
            </div>
		</div>
		<div class="main-header__widget-box">

            <div class="main-header__widget-box-desktop">
	            <?php if ( $search == true ) : ?>

                    <a class="main-header__widget-box--search search-btn js-open-search" href="#">
                        <i class="icon ion-android-search" aria-hidden="true"></i>
                    </a>

	            <?php endif; ?>

				<?php if ( isset($hryzantema_nav_main_add_button) &&  $hryzantema_nav_main_add_button == true ) {
					 echo \Aheto\Helper::get_button($this, $atts, 'hryzantema_nav_main_');
				} ?>
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
	<link href="<?php echo $shortcode_dir . 'assets/css/hryzantema_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
	"use strict";

	let prevScrollpos = window.pageYOffset;

	function hideMenuOnScroll() {
		if ($('.main-header--simple-button').length) {
			const mobileMenu = +$('.main-header--simple-button').data('mobile-menu');
			let currentScrollPos = window.pageYOffset;
			let headerHeight = $('.main-header--simple-button .hr-header-2-top').outerHeight();

			if ($(window).width() > mobileMenu) {
				if (prevScrollpos > currentScrollPos) {

					$('.main-header--simple-button .hr-header-2-top').css({
						'margin-top': `0px`,
						'transition': '0.5s'
					});

					$('.main-header--simple-button .hr-header-2-top').parents('.aheto-header--fixed.header-scroll').removeClass('dark-scroll');

				} else {
					$('.main-header--simple-button .hr-header-2-top').css({
						'margin-top': `-${headerHeight}px`,
						'transition': '0.5s'
					});
					$('.main-header--simple-button .hr-header-2-top').parents('.aheto-header--fixed.header-scroll').addClass('dark-scroll');
				}

				if (currentScrollPos == 0 || currentScrollPos < 5) {
					$('.main-header--simple-button .hr-header-2-top').css({
						'margin-top': `0px`,
						'transition': '0.5s'
					});
					$('.main-header--simple-button .hr-header-2-top').parents('.aheto-header--fixed.header-scroll').removeClass('dark-scroll');
					if ($('..main-header--simple-button .main-header__hamburger').hasClass('is-active')) {
						$('.hr-header-2-top').css({
							'margin-top': `-${headerHeight}px`,
							'transition': '0.5s'
						});
					}
				}

				prevScrollpos = currentScrollPos;
			} else {
				$('.main-header--simple-button .hr-header-2-top').parents('.aheto-header--fixed.header-scroll').removeClass('dark-scroll');
			}

			const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');
			let oldScroll = null;

			$('.main-header--simple-button .js-toggle-mobile-menu').on('click', function (e) {
				e.preventDefault();

				oldScroll = scrollY;

				$('html, body').addClass('no-scroll');

			});

			$('.main-header--simple-button .btn-close').on('click', function (e) {
				e.preventDefault();

				$('html, body').removeClass('no-scroll');

				window.scrollTo({
					top: oldScroll,
					behavior: 'smooth'
				});
			});
		}
	}


	window.addEventListener('scroll', () => {
		document.documentElement.style.setProperty('--scroll-y', `${window.scrollY}`);
	});

	$(window).on('load scroll', function () {
		hideMenuOnScroll();
	});

})(jQuery, window, document);
	</script>
	<?php
endif;