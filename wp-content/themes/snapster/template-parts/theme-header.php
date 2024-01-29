<div class="snapster-preloader"></div>

<div class="snapster-main-wrapper">
    <header class="snapster-header--wrap">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- HEADER -->
                    <div class="snapster-header">

                        <!-- NAVIGATION -->
                        <nav id="topmenu" class="snapster-header--topmenu">

                            <div class="snapster-header--logo-wrap">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="snapster-header--logo">
                                    <span><?php echo get_option( 'blogname' ); ?></span>
                                </a>
                            </div>

                            <div class="snapster-header--menu-wrapper">
                                <span class="mobile-menu-title"><?php esc_html_e('Menu', 'snapster'); ?></span>
								<?php if ( has_nav_menu( 'primary-menu' ) ) {

									$args                   = array( 'container' => '' );
									$args['theme_location'] = 'primary-menu';
									wp_nav_menu( $args );

								} else {

									echo '<span class="no-menu primary-no-menu">' . esc_html__( 'Please register Top Navigation from', 'snapster' ) . ' <a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">' . esc_html__( 'Appearance &gt; Menus', 'snapster' ) . '</a></span>';

								} ?>

                            </div>

                            <!-- MOB MENU ICON -->
                            <div class="snapster-header--mob-nav">
                                <a href="#" class="snapster-header--mob-nav__hamburger">
                                    <span></span>
                                </a>
                            </div>
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </header>

