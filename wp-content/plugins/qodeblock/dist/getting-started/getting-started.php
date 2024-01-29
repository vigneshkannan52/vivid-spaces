<?php
/**
 * Getting Started page
 *
 * @package qodeblock
 */

/**
 * Load Getting Started styles in the admin
 *
 * @since 1.0.0
 * @param string $hook The current admin page.
 */
function qodeblock_start_load_admin_scripts( $hook ) {

	if ( ! ( $hook === 'toplevel_page_qodeblock' ) ) {
		return;
	}

	// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison -- Could be true or 'true'.
	$postfix = ( SCRIPT_DEBUG == true ) ? '' : '.min';

	/**
	 * Load scripts and styles
	 *
	 * @since 1.0
	 */

	// Getting Started javascript.
	wp_enqueue_script( 'qodeblock-getting-started', plugins_url( 'getting-started/getting-started.js', dirname( __FILE__ ) ), array( 'jquery' ), '1.0.0', true );

	// Getting Started styles.
	wp_register_style( 'qodeblock-getting-started', plugins_url( 'getting-started/getting-started.css', dirname( __FILE__ ) ), false, '1.0.0' );
	wp_enqueue_style( 'qodeblock-getting-started' );

	// FontAwesome.
	wp_register_style( 'qodeblock-fontawesome', plugins_url( '/assets/fontawesome/css/all' . $postfix . '.css', dirname( __FILE__ ) ), false, '1.0.0' );
	wp_enqueue_style( 'qodeblock-fontawesome' );
}
add_action( 'admin_enqueue_scripts', 'qodeblock_start_load_admin_scripts' );


/**
 * Adds a menu item for the Getting Started page.
 *
 * @since 1.0.0
 */
function qodeblock_getting_started_menu() {

	add_menu_page(
		__( 'qodeblock', 'qodeblock' ),
		__( 'qodeblock', 'qodeblock' ),
		'manage_options',
		'qodeblock',
		'qodeblock_getting_started_page',
		plugins_url( 'qodeblock' ) . '/dist/getting-started/images/q3-01.svg'
	);

	add_submenu_page(
		'qodeblock',
		esc_html__( 'Getting Started', 'qodeblock' ),
		esc_html__( 'Getting Started', 'qodeblock' ),
		'manage_options',
		'qodeblock',
		'qodeblock_getting_started_page'
	);

	if ( PHP_VERSION_ID >= 50600 ) {
		add_submenu_page(
			'qodeblock',
			esc_html__( 'qodeblock Settings', 'qodeblock' ),
			esc_html__( 'Settings', 'qodeblock' ),
			'manage_options',
			'qodeblock-plugin-settings',
			'qodeblock_render_settings_page'
		);
	}

}
add_action( 'admin_menu', 'qodeblock_getting_started_menu' );


/**
 * Outputs the markup used on the Getting Started
 *
 * @since 1.0.0
 */
function qodeblock_getting_started_page() {

	/**
	 * Create recommended plugin install URLs
	 *
	 * @since 1.0.0
	 */
	$gberg_install_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'install-plugin',
				'plugin' => 'gutenberg',
			),
			admin_url( 'update.php' )
		),
		'install-plugin_gutenberg'
	);

	$qb_install_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'install-plugin',
				'plugin' => 'qodeblock',
			),
			admin_url( 'update.php' )
		),
		'install-plugin_qodeblock'
	);

	$qb_theme_install_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'install-theme',
				'theme'  => 'qodeblock',
			),
			admin_url( 'update.php' )
		),
		'install-theme_qodeblock'
	);
	?>
	<div class="wrap qb-getting-started">
		<div class="intro-wrap">
			<div class="intro">
				<h3><?php printf( esc_html__( 'Getting started with', 'qodeblock' ) ); ?> <strong><?php printf( esc_html__( 'qodeblock', 'qodeblock' ) ); ?></strong></h3>
			</div>
		</div>

		<div class="panels">
			<div id="panel" class="panel">
				<div id="qodeblock-panel" class="panel-left visible">
					<div class="qb-block-split clearfix">
						<div class="qb-block-split-left">
							<div class="qb-titles">
								<h2><?php esc_html_e( 'Welcome to the future of site building with Gutenberg and qodeblock!', 'qodeblock' ); ?></h2>
								<p><?php esc_html_e( 'The qodeblock plugin is a collection of “blocks” for the new WordPress block editor, also known as Gutenberg. Blocks are chunks of content such as paragraphs, images, galleries, columns, and more. Building with blocks gives you more control to quickly create and launch any kind of site you want!', 'qodeblock' ); ?></p>
							</div>
						</div>
						<div class="qb-block-split-right">
							<div class="qb-block-theme">
								<img src="<?php echo esc_url( plugins_url( 'images/build-content.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'qodeblock Theme', 'qodeblock' ); ?>" />
							</div>
						</div>
					</div>

					<div class="qb-block-feature-wrap clear">
						<h2><?php esc_html_e( 'Available blocks', 'qodeblock' ); ?></h2>
						<p><?php esc_html_e( 'Edit and customize the appearance, add new blocks and features and much more without code and programming', 'qodeblock' ); ?></p>

						<div class="qb-block-features">
							<div class="qb-block-feature">
								<div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/image_post.png', __FILE__ ) ); ?>" alt="Post Grid Block" /></div>
								<div class="qb-block-feature-text">
									<h3><?php esc_html_e( 'Post Grid Block', 'qodeblock' ); ?></h3>
									<p><?php esc_html_e( 'This block helps you to create beautiful post or page grid and list.', 'qodeblock' ); ?></p>
								</div>
							</div>

							<div class="qb-block-feature">
								<div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/marketing_2-1.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Call To Action Block', 'qodeblock' ); ?>" /></div>
								<div class="qb-block-feature-text">
									<h3><?php esc_html_e( 'Call-To-Action Block', 'qodeblock' ); ?></h3>
									<p><?php esc_html_e( 'Call to Action Block allows to persuade a visitor to perform a certain act immediately.', 'qodeblock' ); ?></p>
								</div>
							</div>

							<div class="qb-block-feature">
								<div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/reminder_note_1-4.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Inline Notices Block', 'qodeblock' ); ?>" /></div>
								<div class="qb-block-feature-text">
									<h3><?php esc_html_e( 'Inline Notice Block', 'qodeblock' ); ?></h3>
									<p><?php esc_html_e( 'This block is used to create notifications or special messages on the page.', 'qodeblock' ); ?></p>
								</div>
							</div>

							<div class="qb-block-feature">
								<div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/personal_data_1-1.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Author Profile Block', 'qodeblock' ); ?>" /></div>
								<div class="qb-block-feature-text">
									<h3><?php esc_html_e( 'Author Profile Block', 'qodeblock' ); ?></h3>
									<p><?php esc_html_e( 'The block allows you to add information about the author as a user profile.', 'qodeblock' ); ?></p>
								</div>
							</div>

							<div class="qb-block-feature">
								<div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/moving_forward-1.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Customizable Button Block', 'qodeblock' ); ?>" /></div>
								<div class="qb-block-feature-text">
									<h3><?php esc_html_e( 'Customizable Button', 'qodeblock' ); ?></h3>
									<p><?php esc_html_e( 'The block makes it easy to add a beutiful custom button to a post or page.', 'qodeblock' ); ?></p>
								</div>
							</div>
                            <div class="qb-block-feature">
                                <div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/designer_1-1.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Spacer and Divider Block', 'qodeblock' ); ?>" /></div>
                                <div class="qb-block-feature-text">
                                    <h3><?php esc_html_e( 'Spacer & Divider', 'qodeblock' ); ?></h3>
                                    <p><?php esc_html_e( 'The block allows you to creatively divide the content of a page or post using spacing or line.', 'qodeblock' ); ?></p>
                                </div>
                            </div>
							<div class="qb-block-feature">
								<div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/creative_process_2-1.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Drop Cap Block', 'qodeblock' ); ?>" /></div>
								<div class="qb-block-feature-text">
									<h3><?php esc_html_e( 'Drop Cap Block', 'qodeblock' ); ?></h3>
									<p><?php esc_html_e( 'This block allows you to add a stylized letter at the beginning of the paragraph.', 'qodeblock' ); ?></p>
								</div>
							</div>
                            <div class="qb-block-feature">
                                <div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/share.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Sharing Icons Block', 'qodeblock' ); ?>" /></div>
                                <div class="qb-block-feature-text">
                                    <h3><?php esc_html_e( 'Sharing Icons Block', 'qodeblock' ); ?></h3>
                                    <p><?php esc_html_e( 'This block allows you to add Social Media Sharing Icons to you post or page.', 'qodeblock' ); ?></p>
                                </div>
                            </div>
                            <div class="qb-block-feature">
                                <div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/social_media_2-1.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Testimonials Block', 'qodeblock' ); ?>" /></div>
                                <div class="qb-block-feature-text">
                                    <h3><?php esc_html_e( 'Testimonial Block', 'qodeblock' ); ?></h3>
                                    <p><?php esc_html_e( 'This block allows you to add a testimonial area to your post or page.', 'qodeblock' ); ?></p>
                                </div>
                            </div>
                            <div class="qb-block-feature">
                                <div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/analyze_report_2-1.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Accordion Toggle', 'qodeblock' ); ?>" /></div>
                                <div class="qb-block-feature-text">
                                    <h3><?php esc_html_e( 'Accordion Block', 'qodeblock' ); ?></h3>
                                    <p><?php esc_html_e( 'This block helps to create toggle content with a title and descriptive text.', 'qodeblock' ); ?></p>
                                </div>
                            </div>
                            <div class="qb-block-feature">
                                <div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/bitcoin_1.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Pricing Block', 'qodeblock' ); ?>" /></div>
                                <div class="qb-block-feature-text">
                                    <h3><?php esc_html_e( 'Pricing', 'qodeblock' ); ?></h3>
                                    <p><?php esc_html_e( 'Pricing Block allows you to create price tables and services packages.', 'qodeblock' ); ?></p>
                                </div>
                            </div>
                            <div class="qb-block-feature">
                                <div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/new_message-1.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Email Newsletter', 'qodeblock' ); ?>" /></div>
                                <div class="qb-block-feature-text">
                                    <h3><?php esc_html_e( 'Email Newsletter', 'qodeblock' ); ?></h3>
                                    <p><?php esc_html_e( 'Using this block, you can add Mailchimp Mail Subscription Form to your website.', 'qodeblock' ); ?></p>
                                </div>
                            </div>
                            <div class="qb-block-feature">
                                <div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/building_website.png', __FILE__ ) ); ?>" alt="Container Block" /></div>
                                <div class="qb-block-feature-text">
                                    <h3><?php esc_html_e( 'Container Block', 'qodeblock' ); ?></h3>
                                    <p><?php esc_html_e( 'This block allows you to select part of the text in the container.', 'qodeblock' ); ?></p>
                                </div>
                            </div>
                            <div class="qb-block-feature">
                                <div class="qb-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/content_digital.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Advanced Columns', 'qodeblock' ); ?>" /></div>
                                <div class="qb-block-feature-text">
                                    <h3><?php esc_html_e( 'Advanced Columns', 'qodeblock' ); ?></h3>
                                    <p><?php esc_html_e( 'The Advanced Columns Block allows you to create your own page layout with a simple setup.', 'qodeblock' ); ?></p>
                                </div>
                            </div>
						</div><!-- .qb-block-features -->
					</div><!-- .qb-block-feature-wrap -->
				</div><!-- .panel-left -->


				<div class="footer-wrap">
					<div class="qb-footer">
						<p>
                            <?php echo esc_html__('Made with love by ', 'qodeblock'); ?><a href="<?php echo esc_url( 'http://qodeblock.com/landing-page/' ); ?>"><?php echo esc_html__( 'qodeblock.', 'qodeblock' ); ?></a>
						</p>
						<div class="qb-footer-links">
							<a href="http://qodeblock.com/landing-page/"><?php esc_html_e( 'qodeblock.com', 'qodeblock' ); ?></a>
							<a href="http://qodeblock.com/docs/"><?php esc_html_e( 'Docs', 'qodeblock' ); ?></a>
						</div>
					</div>
				</div><!-- .footer-wrap -->
			</div><!-- .panel -->
		</div><!-- .panels -->
	</div><!-- .getting-started -->
	<?php
}

/**
 * Renders the plugin settings page.
 */
function qodeblock_render_settings_page() {

	$pages_dir = trailingslashit( dirname( __FILE__ ) ) . 'pages/';

	include $pages_dir . 'settings-main.php';
}

add_action( 'admin_init', 'qodeblock_save_settings' );
/**
 * Saves the plugin settings.
 */
function qodeblock_save_settings() {

	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated,WordPress.Security.ValidatedSanitizedInput.MissingUnslash,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Handled below.
	if ( empty( $_POST['qodeblock-settings'] ) ) {
		return;
	}

	if ( empty( $_POST['qodeblock-settings-save-nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['qodeblock-settings-save-nonce'] ) ), 'qodeblock-settings-save-nonce' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated,WordPress.Security.ValidatedSanitizedInput.MissingUnslash,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Handled below.
	$posted_settings = $_POST['qodeblock-settings'];

	/**
	 * Process the Mailchimp API key setting.
	 */
	if ( ! empty( $posted_settings['mailchimp-api-key'] ) ) {
		update_option( 'qodeblock_mailchimp_api_key', sanitize_text_field( wp_unslash( $posted_settings['mailchimp-api-key'] ) ), false );
	} else {
		delete_option( 'qodeblock_mailchimp_api_key' );
	}

	$redirect = remove_query_arg( 'qodeblock-settings-saved', wp_get_referer() );
	wp_safe_redirect( $redirect . '&qodeblock-settings-saved=true' );
	exit;
}
