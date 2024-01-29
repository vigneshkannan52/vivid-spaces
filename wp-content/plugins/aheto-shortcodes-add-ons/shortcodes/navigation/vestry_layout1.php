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
$this->add_render_attribute( 'wrapper', 'id', 'vestry-header' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'main-header' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header--vestry' );
$this->add_render_attribute( 'wrapper', 'class', 'main-header-js' );
$this->add_render_attribute( 'wrapper', 'class', $transparent );
$this->add_render_attribute( 'wrapper', 'data-mobile-menu', $mobile_menu_width );


$type_logo = isset( $type_logo ) && ! empty( $type_logo ) ? $type_logo : 'image';

if ( $type_logo == 'image' && is_array( $scroll_logo ) ) {

	$scroll_logo = ! empty( $scroll_logo['id'] ) ? $scroll_logo : $logo;
} elseif ( $type_logo == 'image' && ! is_array( $scroll_logo ) ) {
	$scroll_logo = isset( $scroll_logo ) && ! empty( $scroll_logo ) ? $scroll_logo : $logo;
}

$button     = $this->get_button_attributes( 'main' );
$add_button = $this->get_button_attributes( 'add' );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'vestry-navigation-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null );
}
wp_enqueue_script( 'vestry-navigation-layout1-js', $shortcode_dir . 'assets/js/vestry_layout1.js', array( 'jquery' ), null );
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="main-header__main-line">
        <div class="main-header__widget-box">
            <button class="hamburger main-header__hamburger js-toggle-mobile-menu" type="button">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
            </button>
        </div>
        <div class="main-header__menu-box left-menu">
			<?php
			wp_nav_menu( [
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline main-menu-left',
				'menu'            => $menus,
			] );
			?>
        </div>
        <div class="aheto-logo main-header__logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( ! empty( $logo ) && $type_logo == 'image' ) {
					echo Helper::get_attachment( $logo, [ 'class' => 'aheto-logo__image' ] );
				}
				if ( ! empty( $scroll_logo ) && $type_logo == 'image' ) {
					echo Helper::get_attachment( $scroll_logo, [ 'class' => 'aheto-logo__image aheto-logo__image-scroll' ] );
				}
				if (!empty($mob_logo) && $type_logo == 'image') {
					echo Helper::get_attachment($mob_logo, ['class' => 'aheto-logo__image mob-logo']);
				}
				if (!empty($scroll_mob_logo) && $type_logo == 'image') {
					echo Helper::get_attachment($scroll_mob_logo, ['class' => 'aheto-logo__image mob-logo aheto-logo__image-mob-scroll']);
				}
				if ( ! empty( $text_logo ) && $type_logo == 'text' ) { ?>
                    <span><?php echo esc_html( $text_logo ); ?></span>
				<?php } ?>
            </a>
        </div>
        <div class="main-header__menu-box">
			<?php
			wp_nav_menu( [
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $vestry_menus_right,
			] );
			?>
        </div>
        <div class="main-header__menu-box mobile-menu">
            <span class="mobile-menu-title"><?php esc_html_e( 'Menu', 'aheto' ); ?></span>
            <div class="main-header__widget-box-mobile"></div>
			<?php
			wp_nav_menu( [
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $menus,
			] );

			wp_nav_menu( [
				'container'       => 'nav',
				'container_class' => 'menu-home-page-container',
				'menu_class'      => 'main-menu main-menu--inline',
				'menu'            => $vestry_menus_right,
			] );

			?>
        </div>
    </div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/vestry_layout1.css'?>" rel="stylesheet">
	<script>
; (function ($, window, document, undefined) {
    "use strict";

    const $WIN = $(window),
        $mainHeader = $('.main-header-js'),
        $topMenu = $('.main-header-js ul'),
        $menuItems = $topMenu.find("a"),
        topMenuHeight = $('.aheto-header').outerHeight() + 50

    let lastId,
        $winHeight = $WIN.height(),
        isBlocked = false,
        hasPassiveEvents = false;

    if (typeof window !== 'undefined') {
        const passiveTestOptions = {
            get passive() {
                hasPassiveEvents = true;
                return undefined;
            }
        };
        window.addEventListener('testPassive', null, passiveTestOptions);
        window.removeEventListener('testPassive', null, passiveTestOptions);
    }
    document.addEventListener('touchmove', function (e) {
        if (isBlocked && mobFullHeight < $winHeight) {
            e.preventDefault();
        } else if (isBlocked && !e.target.closest('.js-mob-menu')) {
            e.preventDefault();
        }
    }, hasPassiveEvents ? {
        passive: false
    } : undefined);

    /**
     * Check if home page
     */

    const isHome = $('body').hasClass('home') ? true : false;

    /**
     * Set up custon namespace to prevent Elementor default ScrollToId
     * Custom scroll to target section
     */

    $menuItems.on('click.djoNav', function (e) {
        const href = $(this).get(0).getAttribute('href');

        if (href.indexOf('#') >= 0) {
            e.preventDefault();
        }

        if (!isHome) {
            const targetID = $(this).data('id') ? $(this).data('id') : '';
            //save in localstorage Id of target section
            localStorage.setItem('blockID', targetID);
        }

        scrollTo(href);
    });

    /**
     * Scrool to Id function
     */

    function scrollTo(id) {
        //check if the url is realy ID
        if (id.indexOf("#") >= 0) {
            const offsetTop = $(id).length ? $(id).offset().top - topMenuHeight + 1 : 0;

            if (offsetTop) {
                $('html, body').stop().animate({
                    scrollTop: offsetTop
                }, 350);
            }
        }
    }
    $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
            $('.aheto-header--fixed').addClass('vestry-header-scroll');
        } else {
            $('.aheto-header--fixed').removeClass('vestry-header-scroll');
        }
    });

    /**
     * Prevent other events on main nav items(if namespace != to created  before)
     */

    $WIN.on("load", () => {
        //get target section ID
        if (localStorage.getItem('blockID')) {
            const targetID = localStorage.getItem('blockID');
            scrollTo(targetID);
            localStorage.removeItem('blockID');
        }

        setTimeout(() => {
            const $doc = $(document),
                $events = $menuItems.length ? $._data($doc[0], "events") : null;
            if ($events) {
                for (let i = $events.click.length - 1; i >= 0; i--) {
                    const handler = $events.click[i];
                    if (handler && handler.namespace != "djoNav" && handler.selector === 'a[href*="#"]') {
                        $doc.off("click", handler.handler);
                    }
                }
            }
        }, 300);
    });


    /**
     * Change links for inner pages
     */

    if (!isHome) {
        const homeUrl = $('.main-header__logo > a').attr('href');
        const linksArr = $mainHeader.find('.menu-item > a');

        linksArr.each(function () {
            const thisUrl = $(this).attr('href');

            //check if this link to ID
            if (thisUrl.indexOf("#") >= 0) {
                const newUrl = homeUrl;

                //save target id in data-atrribute
                $(this).attr('data-id', thisUrl);
                //set url to home page instead of ID
                $(this).attr('href', newUrl);
            }
        });
    }

})(jQuery, window, document);
	</script>
	<?php
endif;