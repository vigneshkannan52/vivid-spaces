<?php
/**
 * Header Modern Menu.
 */
use Aheto\Helper;
extract( $atts );

if ( empty( $menus ) ) {
	return;
}

$home_class = 'js-home';
$home_page = get_post_meta( get_the_ID(), 'home_check', 1 );

if( is_home() || $home_page ) {
	$home_class .= ' home';
}

$this->generate_css();

if(isset( $mobile_menu_width ) && is_array($mobile_menu_width) && ! empty( $mobile_menu_width['size'] ) ){
	$mobile_menu_width = $mobile_menu_width['size'];
}elseif (!isset( $mobile_menu_width ) || !is_array($mobile_menu_width) || empty($mobile_menu_width['size'])){
	$mobile_menu_width = 1199;
}


// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', 'djo-header');
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'main-header main-header--djo-layout1' );
$this->add_render_attribute( 'wrapper', 'class', $home_class );
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

$button = $this->get_button_attributes( 'main' );
$add_button = $this->get_button_attributes( 'add' );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('djo-navigation-layout1', $shortcode_dir . 'assets/css/djo_layout1.css', null, null);
}
wp_enqueue_script( 'djo-navigation-layout1-js', $shortcode_dir . 'assets/js/djo_layout1.js', array( 'jquery' ), null );

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="main-header__main-line">
		<div class="main-header__menu-box d-none d-xl-block">
			<?php
				wp_nav_menu([
					'container'       => 'nav',
					'container_class' => 'menu-home-page-container',
					'menu_class'      => 'main-menu main-menu--inline',
					'menu'            => $menus,
				]);
			?>
        </div>
		<button class="hamburger main-header__hamburger js-toggle-menu mr-auto" type="button" aria-label="mobile menu open">
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
		</button>
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
		<div class="main-header__menu-box d-none d-xl-block">
			<?php
				wp_nav_menu([
					'container'       => 'nav',
					'container_class' => 'menu-home-page-container',
					'menu_class'      => 'main-menu main-menu--inline',
					'menu'            => $djo_menus_right,
				]);
			?>
		</div>
		<div class="main-header__menu-box d-xl-none js-mob-menu">
			<span class="menu-title"><?php esc_html_e('Menu', 'djo'); ?></span>
			<div>
				<?php
					wp_nav_menu([
						'container'       => 'nav',
						'container_class' => 'menu-home-page-container',
						'menu_class'      => 'main-menu main-menu--inline',
						'menu'            => $menus,
					]);
				?>
				<?php
					wp_nav_menu([
						'container'       => 'nav',
						'container_class' => 'menu-home-page-container',
						'menu_class'      => 'main-menu main-menu--inline',
						'menu'            => $djo_menus_right,
					]);
				?>
			</div>
        </div>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/djo_layout1.css'?>" rel="stylesheet">
	<script>
;
(function ($, window, document, undefined) {
    "use strict";


    if ($('.main-header--djo-layout1').length) {

        const $WIN = $(window),
            $mainHeader = $('.main-header-js'),
            $topMenu = $('.main-header-js ul'),
            $menuItems = $topMenu.find("a"),
            topMenuHeight = $('.aheto-header').outerHeight() + 50,
            $toggleMenu = $('.js-toggle-menu'),
            $headerWrap = $('.aheto-header'),
            $body = document.querySelector('body'),
            $menuBox = $headerWrap.find('.main-header__menu-box'),
            scrollItems = $menuItems.length && $menuItems
                .map(function () {
                    if ($(this).attr('href').indexOf("#") >= 0) {
                        const item = $($(this).attr("href"));
                        if (item.length) {
                            return item;
                        }
                    }
                });

        let lastId,
            $winHeight = $WIN.height(),
            scrollPosition = 0;

        const scrollControl = {
            enable() {
                scrollPosition = window.pageYOffset;
                $body.style.overflow = 'hidden';
                $body.style.position = 'fixed';
                $body.style.top = `-${scrollPosition}px`;
                $body.style.width = '100%';
            },
            disable() {
                $body.style.removeProperty('overflow');
                $body.style.removeProperty('position');
                $body.style.removeProperty('top');
                $body.style.removeProperty('width');
                window.scrollTo(0, scrollPosition);
            },
        };

        /**
         * Check if home page
         */

        const isHome = $('body').hasClass('home') || $('.js-home').hasClass('home') ? true : false;

        /**
         * Set up custon namespace to prevent Elementor default ScrollToId
         * Custom scroll to target section
         */

        $menuItems.on('click.djoNav', function (e) {
            const href = $(this).get(0).getAttribute('href');
            const mobileMenu = +$(this).closest('.main-header-js').data('mobile-menu');

            if (href.indexOf('#') >= 0) {
                e.preventDefault();
            }

            if (!isHome) {
                const targetID = $(this).data('id') ? $(this).data('id') : '';
                //save in localstorage Id of target section
                localStorage.setItem('blockID', targetID);
            }

            $menuBox.removeClass('open');
            $('body').removeClass('sidebar-open');
            if ($(window).width() <= (mobileMenu + 1)) {
                scrollControl.disable();
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
         * Toogle menu on mobile
         */

        if ($headerWrap.length) {

            $toggleMenu.on('click', function () {
                scrollControl.enable();
                $menuBox.addClass('open');
                $('body').addClass('sidebar-open');
            });
        }

        document.addEventListener('touchstart', (event) => {
            if (event.target && event.target.className === 'body-overlay') {
                scrollControl.disable();
                $body.classList.remove('sidebar-open');
                $menuBox.removeClass('open');
            }
        });

        /**
         * Close mobile menu
         */

        $(document).on('click', '.btn-close', function () {
            scrollControl.disable();
            $menuBox.removeClass('open');
            $('body').removeClass('sidebar-open');
        })

        /**
         * Highlight active menu on scroll
         */

        $WIN.on('scroll', function () {
            const fromTop = $(this).scrollTop() + topMenuHeight;

            let cur = scrollItems.map(function () {
                if ($(this).offset().top < fromTop)
                    return this;
            });

            cur = cur[cur.length - 1];

            const id = cur && cur.length ? cur[0].id : "";

            if (id && lastId !== id) {
                lastId = id;
                $menuItems
                    .parent().removeClass("active")
                    .end()
                    .filter("[href=\\#" + id + "]")
                    .parent()
                    .addClass("active");
            } else if (!id) {
                $menuItems
                    .parent().removeClass("active");
            }
        });

        /**
         * Change links for inner pages
         */

        if (!isHome) {
            const homeUrl = $('.main-header--djo-layout1  .main-header__logo > a').attr('href');
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
    }
})(jQuery, window, document);
	</script>
	<?php
endif;