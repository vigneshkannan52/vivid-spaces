<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Snapster
 */

add_action('tgmpa_register', 'snapster_include_required_plugins');
add_action('widgets_init', 'snapster_widgets_init');
add_action('after_setup_theme', 'snapster_content_width', 0);
add_action('wp_enqueue_scripts', 'snapster_enqueue_scripts');
add_action('enqueue_block_editor_assets', 'snapster_add_gutenberg_assets');
add_action('snapster_search', 'snapster_search_popup', 10);

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function snapster_body_classes($classes)
{
	// Adds a class of hfeed to non-singular pages.
	if (!is_singular()) {
		$classes[] = 'snapster-page';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if (!is_active_sidebar('snapster-enable-sidebar')) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}

add_filter('body_class', 'snapster_body_classes');


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function snapster_content_width()
{
	$GLOBALS['content_width'] = apply_filters('snapster_content_width', 1200);
}


/**
 * Register widget area.
 */
function snapster_widgets_init()
{
	register_sidebar(array(
		'name'          => esc_html__('Sidebar', 'snapster'),
		'id'            => 'snapster-sidebar',
		'description'   => esc_html__('Add widgets here.', 'snapster'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	));
}


/**
 * Register Fonts
 */
if (!function_exists('snapster_fonts_url')) {
	function snapster_fonts_url()
	{
		/*
        Translators: If there are characters in your language that are not supported
        by chosen font(s), translate this to 'off'. Do not translate into your own language.
         */
		if ('off' !== esc_html_x('on', 'Google font: on or off', 'snapster')) {

			$query_args = array(
				'family' => 'Playfair+Display:400,400i,500,500i,600,600i,700,700i,800,800i|Muli:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i',
				'subset' => 'latin,latin-ext',
				'display' => 'swap',
			);

			$font_url = add_query_arg($query_args, "//fonts.googleapis.com/css");

			$font_url = urldecode($font_url);
		}

		return $font_url;
	}
}

/*
Enqueue scripts and styles.
*/
if (!function_exists('snapster_font_scripts')) {
	function snapster_font_scripts()
	{
		wp_enqueue_style('snapster-fonts', snapster_fonts_url(), array(), '1.0.0');
	}
}


/**
 * Enqueue scripts and styles.
 */
function snapster_enqueue_scripts()
{

	// general settings
	if ((is_admin())) {
		return;
	}

	if (is_page() || is_home()) {
		$post_id = get_queried_object_id();
	} else {
		$post_id = get_the_ID();
	}

	$include_scripts = true;
	$page_template = get_page_template_slug($post_id);
	if (!empty($page_template)) {
		$page_template_array = explode("_", $page_template);
		$include_scripts = $page_template_array[0] == 'aheto' ? false : true;
	}

	if ($include_scripts) {
		wp_enqueue_style('snapster-fonts', snapster_fonts_url(), array(), '1.0.1');
		wp_enqueue_style('ionicons', SNAPSTER_T_URI . '/assets/css/lib/ionicons.css');
		wp_enqueue_style('font-awesome', SNAPSTER_T_URI . '/assets/css/lib/font-awesome.min.css');
		wp_enqueue_style('bootstrap', SNAPSTER_T_URI . '/assets/css/lib/bootstrap.css');
	}

	wp_enqueue_style('snapster-general', SNAPSTER_T_URI . '/assets/css/general.css');
	wp_enqueue_style('snapster-shop', SNAPSTER_T_URI . '/assets/css/shop.css');

	if (is_404()) {
		wp_enqueue_style('snapster-error-page', SNAPSTER_T_URI . '/assets/css/error-page.css');
	}

	if (get_post_type() === 'whizzy_proof_gallery') {
		wp_enqueue_style('snapster-whizzy-post', SNAPSTER_T_URI . '/assets/css/blog/post-whizzy.css');
	}

	if ($include_scripts) {
		wp_enqueue_style('snapster-main-style', SNAPSTER_T_URI . '/assets/css/style.css');
	}

	wp_enqueue_style('snapster-style', SNAPSTER_T_URI . '/style.css');

	// add TinyMCE style
	add_editor_style();

	// including jQuery plugins
	wp_localize_script(
		'snapster-script',
		'get',
		array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'siteurl' => get_template_directory_uri(),
		)
	);

	if (is_singular()) {
		wp_enqueue_script('comment-reply');
	}


	$active_plugin = function_exists('aheto') ? true : false;

	wp_enqueue_script('fancytransitions', SNAPSTER_T_URI . '/assets/js/lib/jqFancyTransitions.js', array('jquery'), '', true);

	if ($include_scripts) {
		wp_enqueue_script('snapster-navigation', SNAPSTER_T_URI . '/assets/js/navigation.min.js', array(), '', true);
		wp_enqueue_script('snapster-skip-link-focus-fix', SNAPSTER_T_URI . '/assets/js/lib/skip-link-focus-fix.js', array(), '', true);
		wp_enqueue_script('fitvids', SNAPSTER_T_URI . '/assets/js/lib/fitvids.js', array('jquery'), '', true);
		wp_enqueue_script('isotope', SNAPSTER_T_URI . '/assets/js/lib/isotope.js', array('jquery'), '', true);
		wp_enqueue_script('snapster-script', SNAPSTER_T_URI . '/assets/js/script.min.js', array('jquery', 'fitvids', 'isotope'), '', true);
	} elseif ($active_plugin && (is_archive() || is_author() || is_category() || is_home() || is_tag() || is_search())) {
		wp_enqueue_script('isotope', SNAPSTER_T_URI . '/assets/js/lib/isotope.js', array('jquery'), '', true);
		wp_enqueue_script('fitvids', SNAPSTER_T_URI . '/assets/js/lib/fitvids.js', array('jquery'), '', true);
		wp_enqueue_script('snapster-script', SNAPSTER_T_URI . '/assets/js/script.min.js', array('jquery', 'fitvids', 'isotope'), '', true);
	}
	wp_enqueue_script('snapster-btn-script', SNAPSTER_T_URI . '/assets/js/btn-script.js', array('jquery'), '', true);

	$sitepost = get_post(get_the_ID());
	$site_title = $sitepost->post_title;
	$site_slug = $sitepost->post_name;

	wp_localize_script('snapster-btn-script', 'script_vars', array('site_title' => $site_title, 'site_slug' => $site_slug));

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}


/**
 * Include plugins
 */
if (!function_exists('snapster_include_required_plugins')) {
	function snapster_include_required_plugins()
	{
		$import_url = "https://import.foxthemes.me";
		$plugins = array(
			array(
				'name'               => esc_html__('Elementor', 'snapster'),
				'slug'               => 'elementor',
				'required'           => false,
				'version'            => '',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),
			array(
				'name'               => 'Aheto',
				'slug'               => 'aheto',
				'source'             => esc_url($import_url . '/plugins/aheto.zip'),
				'required'           => true,
				'version'            => '1.4.1',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),
			array(
				'name'               => 'Aheto Shortcodes Add-Ons',
				'slug'               => 'aheto-shortcodes-add-ons',
				'source'             => esc_url($import_url . '/plugins/aheto-shortcodes-add-ons.zip'),
				'required'           => true,
				'version'            => '1.1.2',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Contact Form 7', 'snapster'),
				'slug'               => 'contact-form-7',
				'required'           => false,
				'version'            => '',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Qodeblock', 'snapster'),
				'slug'               => 'qodeblock',
				'source'             => esc_url($import_url . '/plugins/premium-plugins/qodeblock.zip'),
				'required'           => false,
				'version'            => '',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('WP Datepicker', 'snapster'),
				'slug'               => 'wp-datepicker',
				'required'           => false,
				'version'            => '',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),
			/*
			*Replaced Booked plugin with Scheduled plugin
			*/
			array(
				'name'     				=> esc_html__( 'Scheduled', 'snapster' ),
				'slug'     				=> 'scheduled',
				'source'   				=> esc_url('https://import.foxthemes.me/plugins/premium-plugins/scheduled.zip'),
				'required' 				=> true,
				'version' 				=> '1.0.0',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> '',
			),
			array(
				'name'               => esc_html__('Whizzy', 'snapster'),
				'slug'               => 'whizzy',
				'source'             => esc_url($import_url . '/plugins/premium-plugins/whizzy.zip'),
				'required'           => true,
				'version'            => '',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),

		);

		// Change this to your theme text domain, used for internationalising strings

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'       => 'snapster',                    // Text domain - likely want to be the same as your theme.
			'default_path' => '',                            // Default absolute path to pre-packaged plugins
			'menu'         => 'tgmpa-install-plugins',    // Menu slug
			'has_notices'  => true,                        // Show admin notices or not
			'is_automatic' => true,                        // Automatically activate plugins after installation or not
			'message'      => '',                            // Message to output right before the plugins table
			'strings'      => array(
				'page_title'                      => esc_html__('Install Required Plugins', 'snapster'),
				'menu_title'                      => esc_html__('Install Plugins', 'snapster'),
				'installing'                      => esc_html__('Installing Plugin: %s', 'snapster'),
				// %1$s = plugin name
				'oops'                            => esc_html__('Something went wrong with the plugin API.', 'snapster'),
				'notice_can_install_required'     => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'snapster'),
				// %1$s = plugin name(s)
				'notice_can_install_recommended'  => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'snapster'),
				// %1$s = plugin name(s)
				'notice_cannot_install'           => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'snapster'),
				// %1$s = plugin name(s)
				'notice_can_activate_required'    => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'snapster'),
				// %1$s = plugin name(s)
				'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'snapster'),
				// %1$s = plugin name(s)
				'notice_cannot_activate'          => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'snapster'),
				// %1$s = plugin name(s)
				'notice_ask_to_update'            => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'snapster'),
				// %1$s = plugin name(s)
				'notice_cannot_update'            => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'snapster'),
				// %1$s = plugin name(s)
				'install_link'                    => _n_noop('Begin installing plugin', 'Begin installing plugins', 'snapster'),
				'activate_link'                   => _n_noop('Activate installed plugin', 'Activate installed plugins', 'snapster'),
				'return'                          => esc_html__('Return to Required Plugins Installer', 'snapster'),
				'plugin_activated'                => esc_html__('Plugin activated successfully.', 'snapster'),
				'complete'                        => esc_html__('All plugins installed and activated successfully. %s', 'snapster'),
				// %1$s = dashboard link
				'nag_type'                        => 'updated'
				// Determines admin notice type - can only be 'updated' or 'error'
			)
		);

		tgmpa($plugins, $config);
	}
}


/**
 * Password form
 */
if (!function_exists('snapster_password_form')) {
	function snapster_password_form($post_id)
	{
		$form = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post" class="form">
					<h3>' . esc_html__('Enter password below:', 'snapster') . '</h3>
  				  	<input placeholder="' . esc_attr__("Password:", 'snapster') . '" name="post_password" type="password" size="20" maxlength="20" />
  				  	<input type="submit" name="' . esc_attr__('Submit', 'snapster') . '" value="' . esc_attr__('Enter', 'snapster') . '" />
				  </form>';

		return $form;
	}
}
add_filter('the_password_form', 'snapster_password_form');


/**
 * Check need minimal requirements (PHP and WordPress version)
 */
if (version_compare($GLOBALS['wp_version'], '4.3', '<') || version_compare(PHP_VERSION, '5.3', '<')) {
	if (!function_exists('snapster_requirements_notice')) {
		function snapster_requirements_notice()
		{
			$message = sprintf(esc_html__('Snapster theme needs minimal WordPress version 4.3 and PHP 5.6<br>You are running version WordPress - %s, PHP - %s.<br>Please upgrade need module and try again.', 'snapster'), $GLOBALS['wp_version'], PHP_VERSION);
			printf('<div class="notice-warning notice"><p><strong>%s</strong></p></div>', $message);
		}
	}
	add_action('admin_notices', 'snapster_requirements_notice');
}


/**
 * Add backend styles for Gutenberg.
 */

if (!function_exists('snapster_add_gutenberg_assets')) {
	function snapster_add_gutenberg_assets()
	{

		$active_plugin = function_exists('aheto') ? true : false;

		if ($active_plugin) {

			$layout = \Aheto\Helper::get_settings('general.single_template', 'theme');

			if ('theme' == $layout) {

				// Load the theme styles within Gutenberg.

				wp_enqueue_style('snapster-fonts', snapster_fonts_url(), array(), '1.0.0');

				wp_enqueue_style('snapster-gutenberg', SNAPSTER_T_URI . '/assets/css/gutenberg.css');
			}
		} else {

			// Load the theme styles within Gutenberg.

			wp_enqueue_style('snapster-fonts', snapster_fonts_url(), array(), '1.0.0');

			wp_enqueue_style('snapster-gutenberg', SNAPSTER_T_URI . '/assets/css/gutenberg.css');
		}
	}
}


/**
 * Search popup
 */

if (!function_exists('snapster_search_popup')) {
	function snapster_search_popup()
	{ ?>
		<div class="snapster-header--search" id="search-box-<?php echo esc_attr(rand()); ?>">
			<div class="snapster-header--search__form-container">
				<form role="search" method="get" class="snapster-header--search__form" action="<?php echo esc_url(home_url('/')); ?>">
					<div class="input-group">
						<input type="search" value="<?php echo get_search_query() ?>" name="s" class="search-field" placeholder="<?php esc_attr_e('Search..', 'snapster'); ?>" required>
						<button><i class="ion-ios-search-strong open-search"></i></button>
					</div>
				</form>
			</div>
		</div>
<?php }
}
