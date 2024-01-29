<?php
/**
 * Snapster functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Snapster
 */

defined( 'SNAPSTER_T_URI' ) or define( 'SNAPSTER_T_URI', get_template_directory_uri() );
defined( 'SNAPSTER_T_PATH' ) or define( 'SNAPSTER_T_PATH', get_template_directory() );

require_once ABSPATH . 'wp-admin/includes/plugin.php';

require_once SNAPSTER_T_PATH . '/include/class-tgm-plugin-activation.php';
require_once SNAPSTER_T_PATH . '/include/custom-header.php';
require_once SNAPSTER_T_PATH . '/include/actions-config.php';
require_once SNAPSTER_T_PATH . '/include/helper-function.php';
require_once SNAPSTER_T_PATH . '/include/customizer.php';

require SNAPSTER_T_PATH . '/vendor/autoload.php';


/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_snapster() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
        require_once SNAPSTER_T_PATH . '/vendor/appsero/client/src/Client.php';
    }

    $client = new Appsero\Client( '1f9bcc70-4705-48b9-a7a6-60eadae36591', 'Snapster', __FILE__ );

    // Active insights
    $client->insights()->init();

    // Active automatic updater
    $client->updater();

}

appsero_init_tracker_snapster();


$shortcodes_dir = get_template_directory() . '/aheto';
$files          = glob( $shortcodes_dir . '/*/controllers/*.php' );
foreach ( $files as $file ) {
	require_once( $file );
}


if ( ! function_exists( 'snapster_setup' ) ) :

	function snapster_setup() {

		register_nav_menus( array( 'primary-menu' => esc_html__( 'Primary menu', 'snapster' ) ) );
		load_theme_textdomain( 'snapster', get_template_directory() . '/languages' );


		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'post-formats', array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat'
		) );

		add_theme_support( 'woocommerce' );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'snapster_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		remove_theme_support( 'widgets-block-editor' );

		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		
		if ( function_exists('aheto') && !function_exists('foxThemeAheto')) :		
			add_action('admin_notices', 'snapster_admin_notice');
		endif;		
		
	}
endif;

add_action( 'after_setup_theme', 'snapster_setup' );

function snapster_admin_notice(){

	 echo '<div class="notice notice-error">
			 <p>We recommend you update <strong>Aheto</strong> to latest version, please <a href="'. get_admin_url() .'themes.php?page=tgmpa-install-plugins&plugin_status=all" class="">Click Here</a>&nbsp;</p>
		 </div>';

}

// ALT for wp users
function snapster_gravatar_alt( $crunchifyGravatar ) {
	if ( have_comments() ) {
		$alt = get_comment_author();
	} else {
		$alt = get_the_author_meta( 'display_name' );
	}
	$crunchifyGravatar = str_replace( 'alt=\'\'', 'alt=\'Avatar for ' . $alt . '\' title=\'Gravatar for ' . $alt . '\'', $crunchifyGravatar );

	return $crunchifyGravatar;
}

add_filter( 'get_avatar', 'snapster_gravatar_alt' );


// Disable REST API link tag
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );


/**
 * Button Shortcode
 */
function snapster_buttons( $buttons ) {
	$dir                         = SNAPSTER_T_URI . '/aheto/button/previews/';
	$buttons['snapster_layout1'] = array(
		'title' => esc_html__( 'Snapster Main', 'snapster' ),
		'image' => $dir . 'snapster_layout1.jpg',
	);
	$buttons['snapster_layout2'] = array(
		'title' => esc_html__( 'Snapster Transparent', 'snapster' ),
		'image' => $dir . 'snapster_layout2.jpg',
	);
	$buttons['snapster_layout3'] = array(
		'title' => esc_html__( 'Snapster Transparent', 'snapster' ),
		'image' => $dir . 'snapster_layout3.jpg',
	);


	return $buttons;
}

add_filter( 'aheto_button_all_layouts', 'snapster_buttons', 10, 2 );


/**
 * Aheto dependency
 */

function snapster_add_dependency( $id, $args = array(), $shortcode='' ) {

	if ( is_array( $id ) ) {

		foreach ( $id as $slug ) {
			$param                                     = (array) $shortcode->depedency[ $slug ]['template'];
			$shortcode->depedency[ $slug ]['template'] = array_merge( $args, $param );
		}

	} else {
		$param                                   = (array) $shortcode->depedency[ $id ]['template'];
		$shortcode->depedency[ $id ]['template'] = array_merge( $args, $param );
	}

	return;
}


/**
 * Aheto Theme Options
 */


if ( function_exists( 'aheto' ) ) {
	function snapster_theme_options( $theme_tabs ) {
		$img = aheto()->assets() . 'admin/img/sidebar-icon/';
		$theme_tabs = [
			'snapster_general' => [
				'icon'  => $img . 'theme-option.png',
				'title' => esc_html__( 'General Options', 'snapster' ),
				'desc'  => esc_html__( 'This tab contains the theme general options.', 'snapster' ),
				'file'  => SNAPSTER_T_PATH . '/include/general-options.php',
			],
			'snapster_whizzy'  => [
				'icon'  => $img . 'theme-option.png',
				'title' => esc_html__( 'Whizzy Options', 'snapster' ),
				'desc'  => esc_html__( 'This tab contains the theme whizzy options.', 'snapster' ),
				'file'  => SNAPSTER_T_PATH . '/include/whizzy-options.php',
			],
			'snapster_pricing'  => [
				'icon'  => $img . 'theme-option.png',
				'title' => esc_html__( 'Price PDF Options', 'snapster' ),
				'desc'  => esc_html__( 'This tab contains the theme price PDF options.', 'snapster' ),
				'file'  => SNAPSTER_T_PATH . '/include/pricing-options.php',
			],
			'snapster_blog'    => [
				'icon'  => $img . 'theme-option.png',
				'title' => esc_html__( 'Blog Options', 'snapster' ),
				'desc'  => esc_html__( 'This tab contains the theme blog options.', 'snapster' ),
				'file'  => SNAPSTER_T_PATH . '/include/blog-options.php',
			],
			'snapster_shop'    => [
				'icon'  => $img . 'theme-option.png',
				'title' => esc_html__( 'Shop Options', 'snapster' ),
				'desc'  => esc_html__( 'This tab contains the theme shop options.', 'snapster' ),
				'file'  => SNAPSTER_T_PATH . '/include/shop-options.php',
			],
		];

		return $theme_tabs;
	}
}

add_filter( 'aheto_theme_options', 'snapster_theme_options', 10, 2 );




if ( function_exists( 'aheto' ) ) {
	/**
	 * Custom metaboxes for whizzy clients
	 */
	add_action( 'cmb2_admin_init', 'snapster_whizzy_metabox' );

	function snapster_whizzy_metabox() {


		$clients = 'snapster_whizzy_client_';

		$cmb_clients = new_cmb2_box( array(
			'id'           => $clients . 'edit',
			'title'        => esc_html__( 'Clients options', 'snapster' ),
			'object_types' => array( 'term' ),
			'taxonomies'   => array( 'whizzy-client' ),
		) );

		$cmb_clients->add_field( array(
			'name'     => esc_html__( 'Additional Info', 'snapster' ),
			'desc'     => esc_html__( 'There is custom option from Snapster Theme', 'snapster' ),
			'id'       => $clients . 'additional_info',
			'type'     => 'title',
			'on_front' => false,
		) );

		$cmb_clients->add_field( array(
			'name' => esc_html__( 'Client Image', 'snapster' ),
			'desc' => esc_html__( 'Please, add photo of client', 'snapster' ),
			'id'   => $clients . 'avatar',
			'type' => 'file',
		) );


		$whizzy = 'snapster_whizzy_';

		$cmb_whizzy = new_cmb2_box( array(
			'id'           => $whizzy . 'edit',
			'title'        => esc_html__( 'Whizzy options', 'snapster' ),
			'object_types' => array( 'whizzy_proof_gallery' ),
			'context'      => 'normal',
			'show_names'   => true, // Show field names on the left
		) );

		$cmb_whizzy->add_field( array(
			'name'     => esc_html__( 'Additional Info', 'snapster' ),
			'desc'     => esc_html__( 'There is custom option from Snapster Theme', 'snapster' ),
			'id'       => $whizzy . 'additional_info',
			'type'     => 'title',
			'on_front' => false,
		) );

		$cmb_whizzy->add_field( array(
			'name' => esc_html__( 'Banner max width', 'snapster' ),
			'desc' => esc_html__( 'By default it is 100%, but you can change it. Please, write number with unit.', 'snapster' ),
			'id'   => $whizzy . 'banner',
			'type' => 'text',
		) );

		$cmb_whizzy->add_field( [
			'name'    => esc_html__( 'Banner overlay color', 'snapster' ),
			'id'      => $whizzy . 'banner_overlay',
			'options' => [ 'alpha' => true ],
			'type'    => 'colorpicker',
		] );

		$cmb_whizzy->add_field( [
			'name'    => esc_html__( 'Enable/Disable Right Click Copyright', 'snapster' ),
			'id'      => $whizzy . 'right_click',
			'type'    => 'radio_inline',
			'desc'    => esc_html__( 'You can enable/disable right click copyright for gallery.', 'snapster' ),
			'default' => 'off',
			'options' => [
				'default' => esc_html__( 'Default', 'snapster' ),
				'on'  => esc_html__( 'On', 'snapster' ),
			],
		] );
		$cmb_whizzy->add_field([
			'name'    => esc_html__( 'Main image of gallery for protected page', 'snapster' ),
			'id'      => $whizzy . 'protected_img',
			'type'    => 'file',
		]);

	}
}



if ( function_exists( 'aheto' ) ) {

add_action( 'wp_body_open', 'snapster_copyright' );
	
	function snapster_copyright() {

		if ( is_page() || is_home() ) {
			$post_id = get_queried_object_id();
		} else {
			$post_id = get_the_ID();
		}

		$snapster_copyright      = Aheto\Helper::get_settings( 'theme-options.snapster_copyright' );
		$snapster_copyright_title = Aheto\Helper::get_settings( 'theme-options.snapster_copyright_title' );
		$snapster_copyright_text = Aheto\Helper::get_settings( 'theme-options.snapster_copyright_text' );
		$whizzy_copyright        = get_post_meta( $post_id, 'snapster_whizzy_right_click', true );

		if ( ( isset( $snapster_copyright ) && $snapster_copyright ) || ( isset( $whizzy_copyright ) && $whizzy_copyright === 'on' ) ) {
			wp_enqueue_style( 'snapster-copyright', SNAPSTER_T_URI . '/assets/css/copyright.css' );
			wp_enqueue_script( 'snapster-copyright-script', SNAPSTER_T_URI . '/assets/js/copyright.js', array( 'jquery' ), '', true ); ?>

            <div class="snapster_copyright_overlay">
                <div class="snapster_copyright_overlay-active">
					<?php if ( isset( $snapster_copyright_title ) && ! empty( $snapster_copyright_title ) ) { ?>
                        <h4 class="snapster_copyright_overlay_title">
							<?php echo wp_kses( $snapster_copyright_title, 'post' ); ?>
                        </h4>
					<?php } ?>
	                <?php if ( isset( $snapster_copyright_text ) && ! empty( $snapster_copyright_text ) ) { ?>
                        <p class="snapster_copyright_overlay_text">
			                <?php echo wp_kses( $snapster_copyright_text, 'post' ); ?>
                        </p>
	                <?php } ?>
                </div>
            </div>

		<?php }

	}
}


add_filter( 'aheto_template_kit_category', function () {
	return 'snapster';
} );



add_filter( 'aheto_api_url', function () {
	return 'https://import.foxthemes.me/wp-json';
}, 10 );

function snapster_export_data() {
	if(class_exists('Aheto\Template_Kit\API') ){

		$aheto_api = new Aheto\Template_Kit\API;

		$endpoint = '/aheto/v1/getThemeTemplate/8313';

		$response = $aheto_api->get_demodata($endpoint, false, false, true);


		return $response;
	}
}

add_filter( 'export_data', 'snapster_export_data', 10 );
function deprecated_plugin_admin_notice() {
   
	if (is_plugin_active( 'booked/booked.php' ) ) { ?>
    <div data-dismissible="disable-done-notice-forever" class="updated notice notice-success is-dismissible">
        <p><?php _e( '<b>Booked plugin has been deprecated since version 2.4.3</b>, instead of using Booked plugin you can use <a  href="https://import.foxthemes.me/plugins/premium-plugins/scheduled.zip" target="_blank">Scheduled Plugin.</a>. Please make sure to take a backup before replacing plugin.'); ?></p> 
    </div>
    <?php 
	}
}
add_action( 'admin_notices', 'deprecated_plugin_admin_notice' );