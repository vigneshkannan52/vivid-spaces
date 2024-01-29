<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Plugin class.
 * @package   Whizzy
 * @author    Foxthemes
 */

defined( 'WHIZZY_ROOT' ) or define( 'WHIZZY_ROOT', dirname( __FILE__ ) );

class WhizzyPlugin {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 * @since   1.0.0
	 * @const   string
	 */
	protected $version = '1.0.0';
	/**
	 * Unique identifier for your plugin.
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_slug = 'whizzy';

	/**
	 * Instance of this class.
	 * @since    1.0.0
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Path to the plugin.
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_basepath = null;

	public $display_admin_menu = false;

	protected $config;

	protected static $number_of_images;

	public static $plugin_settings;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 * @since     1.0.0
	 */
	protected function __construct() {

		$this->plugin_basepath = plugin_dir_path( __FILE__ );
		$this->config          = self::config();
		self::$plugin_settings = get_option( 'whizzy_settings' );

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __FILE__ ) . 'whizzy.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );


		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 99999999999 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'plugins_loaded', array( $this, 'register_metaboxes' ), 14 );
		add_action( 'init', array( $this, 'register_entities' ), 5 );

		// a little hook into the_content
		add_filter( 'the_content', array( $this, 'hook_into_the_content' ), 10, 1 );

		add_filter( 'whizzy_filter_gallery_filename', array( $this, 'prepare_the_gallery_name' ), 10, 4 );

		// parse comments to find referances for images
		add_filter( 'comment_text', array( $this, 'parse_comments' ) );

		add_filter( 'template_include',  array( $this, 'whizzy_portfolio_page_template' ), 99 );

		/**
		 * Ajax Callbacks
		 */
		add_action( 'wp_ajax_whizzy-send-email', array( $this, 'ajax_send_mail' ) );
		add_action( 'wp_ajax_whizzy_image_click', array( &$this, 'ajax_click_on_photo' ) );
		add_action( 'wp_ajax_nopriv_whizzy_image_click', array( &$this, 'ajax_click_on_photo' ) );
		add_action( 'wp_ajax_whizzy_zip_file_url', array( &$this, 'generate_photos_zip_file' ) );
		add_action( 'wp_ajax_nopriv_whizzy_zip_file_url', array( &$this, 'generate_photos_zip_file' ) );
	}

	/**
	 * Return an instance of this class.
	 * @since     1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public static function config() {
		// @TODO maybe check this
		return include 'plugin-config.php';
	}

	/**
	 * Fired when the plugin is activated.
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

	}

	/**
	 * Fired when the plugin is deactivated.
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	static function deactivate( $network_wide ) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 * @since    1.0.0
	 */
	function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, basename( dirname( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 * @since     1.0.0
	 * @return    void|null    Return early if no settings page is registered.
	 */
	function enqueue_admin_styles() {

		$screen = get_current_screen();
		if ( $screen->id == 'whizzy_proof_gallery_page_statistic' || $screen->id == 'whizzy_proof_gallery_page_settings' ) {
			wp_enqueue_style( $this->plugin_slug . '-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), $this->version );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 * @since     1.0.0
	 * @return    void|null    Return early if no settings page is registered.
	 */
	function enqueue_admin_scripts() {
		$screen = get_current_screen();

		if ( $screen->id == 'whizzy_proof_gallery_page_statistic' || $screen->id == 'whizzy_proof_gallery_page_settings' ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.min.js', __FILE__ ), array( 'jquery' ), $this->version );
			wp_localize_script( $this->plugin_slug . '-admin-script', 'locals', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			) );
		}

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 * @since    1.0.0
	 */
	function enqueue_styles() {
        wp_enqueue_style( 'whizzy_skin', plugins_url(  'assets/css/skin.css', __FILE__ ), array(), $this->version );

        if ( ! wp_style_is( 'wpgrade-main-style' ) && self::$plugin_settings['enable_whizzy_style'] === '1' ) {
            wp_enqueue_style( 'whizzy_inuit', plugins_url( 'assets/css/inuit.css', __FILE__ ), array(), $this->version );
            wp_enqueue_style( 'bootstrap', plugins_url( 'assets/css/bootstrap.min.css', __FILE__ ), array(), $this->version );
            wp_enqueue_style( 'font-awesome-css', plugins_url( 'assets/css/font-awesome.min.css', __FILE__ ), array(), $this->version );
            wp_enqueue_style( 'whizzy_magnific-popup', plugins_url( 'assets/css/mangnific-popup.css', __FILE__ ), array(), $this->version );
            wp_enqueue_style( 'whizzy_gallery-detail', plugins_url( 'assets/css/gallery-detail.css', __FILE__ ), array(), $this->version );
        }else{
            wp_enqueue_style( 'whizzy_gallery-general', plugins_url( 'assets/css/gallery-general.css', __FILE__ ), array(), $this->version );

        }

        wp_enqueue_style( 'lightgallery', plugins_url(  'assets/css/lightgallery.min.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$zip_archive_generation = self::$plugin_settings['zip_archive_generation'];

		wp_enqueue_script( 'mousewheel', plugins_url('assets/js/jquery.mousewheel.min.js',__FILE__ ), array( 'jquery' ),  $this->version, true  );
		wp_enqueue_script( 'lightgallery', plugins_url( 'assets/js/lightgallery.min.js', __FILE__ ), array( 'jquery' ),  $this->version, true   );
		wp_enqueue_script( 'thumbnails_popup', plugins_url(  'assets/js/thumbnails-popup.min.js',__FILE__ ), array( 'jquery' ),  $this->version, true   );

		wp_enqueue_script( 'isotope', plugins_url( 'assets/js/isotope.min.js', __FILE__ ), array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'magnific-popup', plugins_url( 'assets/js/magnific-popup.min.js', __FILE__ ), array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.min.js', __FILE__ ), array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_slug . '-plugin-script', 'whizzy', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'whizzy_settings' => array(
				'zip_archive_generation' => $zip_archive_generation
			),
			'l10n' => array(
				'select'    => esc_html__( 'Select', 'whizzy' ),
				'deselect'  => esc_html__( 'Deselect', 'whizzy' ),
				'ofCounter' => esc_html__( 'of', 'whizzy' ),
				'next'      => esc_html__( 'Next', 'whizzy' ),
				'previous'  => esc_html__( 'Previous', 'whizzy' )
			),
		) );
	}

	/**
	 * Render the settings page for this plugin.
	 */
	function display_plugin_admin_page() {
		include_once('views/admin.php');
	}

	/**
	 * Add settings action link to the plugins page.
	 */
	function add_action_links( $links ) {
		return array_merge( array( 'settings' => '<a href="' . admin_url( 'edit.php?post_type=whizzy_proof_gallery&page=settings' ) . '">' . esc_html__( 'Settings', 'whizzy' ) . '</a>' ), $links );
	}

	function register_entities() {
		require_once( $this->plugin_basepath . 'features/custom_post_types.php' );
	}

	function register_metaboxes() {
		require_once( $this->plugin_basepath . 'features/metaboxes/metaboxes.php' );
	}

	function hook_into_the_content( $content ) {
		if ( get_post_type() !== 'whizzy_proof_gallery' || post_password_required() ) {
			return $content;
		}
		$style = '';
		// == This order is important ==
		$whizzy_path = self::get_base_path();

		if ( self::$plugin_settings['enable_whizzy_style'] === '1' && file_exists( $whizzy_path . 'assets/css/public.css' ) ) {
			ob_start();
			echo '<style>';
			include( $whizzy_path . 'assets/css/public.css' );
			echo '</style>';
			$style = ob_get_clean();
		}

		$gallery  = self::get_gallery();
		$metadata = self::get_metadata();

		if ( isset( self::$plugin_settings['gallery_position_in_content'] ) && ! empty( self::$plugin_settings['gallery_position_in_content'] ) ) {
			// == This order is important ==
			$whizzy_output = $style . $metadata . $gallery;
			$gallery_position = self::$plugin_settings['gallery_position_in_content'];

			$whizzy_popup = get_post_meta( get_the_ID(), '_whizzy_position', true );

			if ( $whizzy_popup === 'before' ) {
				return $whizzy_output . $content;
			} else {
				return $content . $whizzy_output;
			}
		}

		return $content;
	}

	static function get_gallery( $post_id = null ) {
		// get the global $post variable or a specific post
		if ( $post_id == null ) {
			$post = get_post( $post_id );
		} else {
			global $post;
		}

		//		$attachments = get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) );
		// get this gallery's metadata
		$gallery_data = get_post_meta( get_the_ID(), '_whizzy_main_gallery', true );
		// quit if there is no gallery data
		if ( empty( $gallery_data ) || ! isset( $gallery_data[ 'gallery' ] ) ) {
			return false;
		}

		$gallery_ids = explode( ',', $gallery_data[ 'gallery' ] );
		if ( empty( $gallery_ids ) ) {
			return false;
		}

		$order = 'post__in';
		if ( isset( $gallery_data[ 'random' ] ) && ( $gallery_data[ 'random' ] === 'true' ) ) {
			$order = 'rand';
		}

		$columns = 3;
		if ( isset( $gallery_data[ 'columns' ] ) && ! empty( $gallery_data[ 'columns' ] ) ) {
			$columns = $gallery_data[ 'columns' ];
		}

		if ( isset( $gallery_data[ 'size' ] ) && ! empty( $gallery_data[ 'size' ] ) ) {
			$thumbnails_size = $gallery_data[ 'size' ];
		}


		if ( self::has_global_style() ) {
			$thumbnails_size = self::get_thumbnails_size();
			$columns = self::get_gallery_grid_size();
		}

		// get attachments
		$attachments = get_posts( array(
			'post_status'    => 'any',
			'post_type'      => 'attachment',
			'post__in'       => $gallery_ids,
			'orderby'        => $order, //'post__in',
			'posts_per_page' => '-1'
		) );
		if ( is_wp_error( $attachments ) || empty( $attachments ) ) {
			return false;
		}
		$number_of_images = self::set_number_of_images( count( $attachments ) );
		$template_name    = 'whizzy_proof_gallery' . EXT;
		$_located         = locate_template( "templates/" . $template_name, false, false );

		// use the default one if the (child) theme doesn't have it
		if ( ! $_located ) {
			$_located = dirname( __FILE__ ) . '/views/' . $template_name;
		}

		//get the settings so they are available in the template
		$photo_display_name = get_post_meta( get_the_ID(), '_whizzy_photo_display_name', true );
		$whizzy_style = get_post_meta( get_the_ID(), '_whizzy_style', true );
		$whizzy_columns = get_post_meta( get_the_ID(), '_whizzy_columns', true );
		$whizzy_space = get_post_meta( get_the_ID(), '_whizzy_space', true );
		$whizzy_popup = get_post_meta( get_the_ID(), '_whizzy_popup', true );
		$show_filters = get_post_meta( get_the_ID(), '_whizzy_filters', true );

		ob_start();
		require $_located;

		return ob_get_clean();
	}

	static function get_metadata( $post_id = null ) {
		if ( $post_id == null ) {
			$post = get_post( $post_id );
		} else {
			global $post;
		}

		$template_name = 'whizzy_metadata' . EXT;
		$_located      = locate_template( "templates/" . $template_name, false, false );

		// use the default one if the (child) theme doesn't have it
		if ( ! $_located ) {
			$_located = dirname( __FILE__ ) . '/views/' . $template_name;
		}

		$client_select = get_post_meta( get_the_ID(), '_whizzy_client_select', true );
		$client_list = get_post_meta( get_the_ID(), '_whizzy_clients_list', true );
		$client_name = get_post_meta( get_the_ID(), '_whizzy_client_name', true );
		$show_zip_button = get_post_meta( get_the_ID(), '_whizzy_show_zip_button', true );
		$show_pdf_button = get_post_meta( get_the_ID(), '_whizzy_show_pdf_button', true );

		$attachments = get_children( array(
			'post_parent'    => $post->post_parent,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
		) );
		$event_date  = get_post_meta( get_the_ID(), '_whizzy_event_date', true );
		$download_is_disabled  = get_post_meta( get_the_ID(), '_whizzy_disable_archive_download', true );

		if ( self::$plugin_settings[ 'enable_archive_zip_download' ] && $download_is_disabled !== 'on' ) {

			// this must be here
			if ( ! class_exists( 'PclZip' ) ) {
				require ABSPATH . 'wp-admin/includes/class-pclzip.php';
			}

			// if the user wants a download link, now we qenerate it
			if ( ! isset( self::$plugin_settings[ 'zip_archive_generation' ] ) || self::$plugin_settings[ 'zip_archive_generation' ] == 'manual' ) {
				$file = get_post_meta( get_the_ID(), '_whizzy_file', true );
			} elseif ( class_exists( 'PclZip' ) ) {
				$file = new PclZip( 'photos' );
				$file = WhizzyPlugin::get_zip_file_url( get_the_ID() );
			}
		}

		$number_of_images = self::get_number_of_images();

		ob_start();
		require $_located;

		return ob_get_clean();

	}

	static function get_attachment_class( $attachment ) {
		$data = wp_get_attachment_metadata( $attachment->ID );

		if ( isset( $data[ 'selected' ] ) && ! empty( $data[ 'selected' ] ) && $data[ 'selected' ] == 'true' ) {
			return 'selected';
		} else {
			return '';
		}
	}

	static function attachment_class( $attachment ) {
		echo self::get_attachment_class( $attachment );
	}

	static function attachment_data( $attachment ) {
		$data   = wp_get_attachment_metadata( $attachment->ID );
		$output = '';

		$output .= ' data-attachment_id="' . esc_attr($attachment->ID) . '"';

		echo $output;
	}

	static function set_number_of_images( $number_of_images ) {
		return self::$number_of_images = $number_of_images;
	}

	static function get_number_of_images() {
		return self::$number_of_images;
	}

	static function get_thumbnails_size() {
		if ( isset( self::$plugin_settings['gallery_thumbnail_sizes'] ) ) {
			return self::$plugin_settings['gallery_thumbnail_sizes'];
		}
		// 'thumbnail' is the default
		return 'thumbnail';
	}

	static function get_gallery_grid_size() {
		if ( isset( self::$plugin_settings['gallery_grid_sizes'] ) ) {
			return self::$plugin_settings['gallery_grid_sizes'];
		}
		// '3' is the default
		return 3;
	}

	static function has_global_style() {
		if ( isset( self::$plugin_settings['enable_whizzy_proof_gallery_global_style'] ) ) {
			return self::$plugin_settings['enable_whizzy_proof_gallery_global_style'];
		}

		return false;
	}
	function ajax_click_on_photo() {
		ob_start();

		if ( ! isset( $_POST[ 'attachment_id' ] ) || ! isset( $_POST[ 'selected' ] ) ) {
			return false;
		}
		$attachment_id = intval( $_POST['attachment_id'] );
		$selected      = sanitize_text_field( $_POST['selected'] );

		$data               = wp_get_attachment_metadata( $attachment_id );
		$data[ 'selected' ] = $selected;

		wp_update_attachment_metadata( $attachment_id, $data );

		echo json_encode( ob_get_clean() );
		die();
	}

	function parse_comments( $comment = '' ) {
		global $post;

		if ( 'whizzy_proof_gallery' !== $post->post_type ) {
			return $comment;
		}
		$comment = preg_replace_callback( "=(^| )+#[\w\-]+=", 'whizzy_comments_match_callback', $comment );

		return $comment;
	}

	static function get_base_path() {
		return plugin_dir_path( __FILE__ );
	}

	// create an ajax call link
	static function get_zip_file_url( $post_id ) {
		return add_query_arg( array(
			'action' => 'whizzy_zip_file_url',
			'gallery_id' => intval( $post_id ),
		), admin_url( 'admin-ajax.php' ) );
	}

	public function generate_photos_zip_file() {
		if ( ! isset ( $_REQUEST[ 'gallery_id' ] ) ) {
			return 'no gallery';
		}

		global $post;

		$gallery_id = intval( $_REQUEST[ 'gallery_id' ] );
		$post = get_post( $gallery_id );

		if ( post_password_required( $post ) ) {
			wp_send_json_error( esc_html__('The gallery password is required', 'whizzy') );
		}

		// get this gallery's metadata
		$gallery_data = get_post_meta( $gallery_id, '_whizzy_main_gallery', true );
		// quit if there is no gallery data
		if ( empty( $gallery_data ) || ! isset( $gallery_data[ 'gallery' ] ) ) {
			wp_send_json_error( esc_html__('No gallery data', 'whizzy') );
		}

		$gallery_ids = explode( ',', $gallery_data[ 'gallery' ] );
		if ( empty( $gallery_ids ) ) {
			wp_send_json_error( esc_html__('Empty gallery', 'whizzy') );
		}

		// get attachments
		$attachments = get_posts( array(
			'post_status'    => 'any',
			'post_type'      => 'attachment',
			'post__in'       => $gallery_ids,
			'orderby'        => 'post__in',
			'posts_per_page' => '-1',
		) );

		if ( is_wp_error( $attachments ) || empty( $attachments ) ) {
			return false;
		}

		// turn off compression on the server
		if ( function_exists( 'apache_setenv' ) ) {
			@apache_setenv( 'no-gzip', 1 );
		}
		@ini_set( 'zlib.output_compression', 'Off' );


		// create the archive
		if ( ! class_exists( 'PclZip' ) ) {
			require ABSPATH . 'wp-admin/includes/class-pclzip.php';
		}

		$filename = tempnam( get_temp_dir(), 'zip' );
		$zip      = new PclZip( $filename );
		$images   = array();

		foreach ( $attachments as $key => $attachment ) {
			$metadata = wp_get_attachment_metadata( $attachment->ID );

			// only those selected
			if ( isset( $metadata[ 'selected' ] ) && $metadata[ 'selected' ] == 'true' ) {
				$images[] = get_attached_file( $attachment->ID );
			}
		}

		$debug = $zip->create( $images, PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_NO_COMPRESSION );

		if ( ! is_array( $debug ) ) {
			die( $zip->errorInfo( true ) );
		}
		unset( $zip );

		$uniqness = date( 'd_m_Y' );
		$file_name = apply_filters( 'whizzy_filter_gallery_filename', 'gallery_', $post->post_name, $uniqness, '.zip' );

		// create the output of the archive
		header( 'Content-Description: File Transfer' );
		header( 'Content-Type: application/zip' );
		header( 'Content-Disposition: attachment; filename=' . $file_name  );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );
		header( 'Content-Length: ' . filesize( $filename ) );

		$chunksize = 512 * 1024;
		$file      = @fopen( $filename, 'rb' );
		while ( ! feof( $file ) ) {
			echo @fread( $file, $chunksize );
			flush();
		}
		fclose( $file );

		// check for bug in some old PHP versions, close a second time!
		if ( is_resource( $file ) ) {
			@fclose( $file );
		}

		// delete the temporary file
		@unlink( $filename );

		exit;
	}

	/**
	 * This filter must return the gallery's zip filename
	 *
	 * @param $file_name_prefix
	 * @param $post_slug
	 * @param $unique
	 * @param $extension
	 *
	 * @return string
	 */
	function prepare_the_gallery_name( $file_name_prefix, $post_slug, $unique, $extension ) {
		return $file_name_prefix . $post_slug . '_' . $unique . $extension;
	}

	/**
	 * Template for pdf page.
	 * @param $template
	 *
	 * @return string
	 */
	public function whizzy_portfolio_page_template( $template ) {
		$file_name = 'whizzy-page-pdf.php';

		if ( isset( $_GET['download'] ) && $_GET['download'] == 'pdf' ) {

			$new_template = WHIZZY_ROOT . '/' . $file_name;;

			if ( '' != $new_template ) {

				return $new_template;
			}
		}

		return $template;
	}

	public function ajax_send_mail() {
		$mail_to = sanitize_email( $_POST['send_to'] );
		$subject = sanitize_text_field( $_POST['subject'] );
		$message = sanitize_textarea_field( $_POST['message'] );
		$post_url = esc_url_raw( $_POST['post_url'] );
		$site = sanitize_text_field( $_POST['site'] );
		$message .= "\r\n\r\n" . $post_url;

		$headers = 'Content-Type: text/html; charset=utf-8; \n\r From: '. $site .'\n\r';
		$send_message = wp_mail( $mail_to, $subject, $message, $headers );

		if ( $send_message ) {
			wp_send_json( 'done' );
		} else {
			wp_send_json( 'error' );
		}
	}
}


function whizzy_comments_match_callback( $matches ) {
	$the_id = substr( trim( $matches[ 0 ] ), 1 );

	$matches[ 0 ] = '<span class="whizzy_photo_ref" data-href="#item-' . esc_attr( $the_id ) . '">#' . esc_html( $the_id ) . '</span>';

	return $matches[ 0 ];

}




/**
 *
 * whizzy counter zip
 * @since 1.0.0
 * @version 1.0.0
 *
 */
function whizzy_counter() {
	if ( isset ( $_REQUEST[ 'gallery_id' ] ) ) {
		$gallery_id = intval( $_REQUEST['gallery_id'] );
		$gallery_data = get_post_meta( $gallery_id, '_whizzy_main_gallery', true );
		$gallery_ids = explode( ',', $gallery_data[ 'gallery' ] );

		$attachments = get_posts( array(
			'post_status'    => 'any',
			'post_type'      => 'attachment',
			'post__in'       => $gallery_ids,
			'orderby'        => 'post__in',
			'posts_per_page' => '-1',
		) );

		foreach ( $attachments as $key => $attachment ) {
			$metadata = wp_get_attachment_metadata( $attachment->ID );

			// only those selected
			if ( isset( $metadata[ 'selected' ] ) && $metadata[ 'selected' ] == 'true' ) {
				$current_count = get_post_meta( $attachment->ID, 'attr_download', true ) ? : 0;
				$current_count = sanitize_text_field( $current_count );
				update_post_meta( $attachment->ID, 'attr_download', $current_count + 1 );
			}
		}


		$current_count_gallery = get_post_meta( $gallery_id, 'attr_download', true ) ? : 0;
		$current_count_gallery = sanitize_text_field( $current_count_gallery );
		update_post_meta( $gallery_id, 'attr_download', $current_count_gallery + 1 );
	}

}
add_action( 'wp_ajax_whizzy_zip_file_url', 'whizzy_counter', 5 );
add_action( 'wp_ajax_nopriv_whizzy_zip_file_url', 'whizzy_counter' );


function whizzy_downloads_columns( $posts_columns ) {
	// Delete an existing column
	unset( $posts_columns['comments'] );

	// Add a new column
	$posts_columns['att_count'] = _x( 'Downloads', 'column name', 'whizzy' );

	return $posts_columns;
}
add_filter( 'manage_whizzy_proof_gallery_posts_columns', 'whizzy_downloads_columns' );

function whizzy_manage_attachment_downloads_column( $column_name, $post_id ) {
	switch ( $column_name ) {
		case 'att_count':

			$page_url = add_query_arg( array( 'post_type' => 'whizzy_proof_gallery', 'page' => 'statistic', 'gallery_id' => intval( $post_id ) ), get_admin_url( null, 'edit.php' ) );

			echo sprintf( '<a href="%s">%s</a>', $page_url, esc_html__( 'Activities' , 'whizzy' ) );

			break;
		default:
			break;
	}
}
add_action( 'manage_whizzy_proof_gallery_posts_custom_column', 'whizzy_manage_attachment_downloads_column', 10, 2 );

function whizzy_downloads_page() {
	add_submenu_page(
		'edit.php?post_type=whizzy_proof_gallery',
		__( 'Activities', 'whizzy' ),
		__( 'Activities', 'whizzy' ),
		'manage_options',
		'statistic',
		'whizzy_download_page_callback'
	);
}
add_action( 'admin_menu', 'whizzy_downloads_page' );

function whizzy_download_page_callback() {
	$page_title = get_admin_page_title();

	$output  = '';
	$output .= '<div class="wrap-whizzy">';
	$output .= '<h2>'. esc_html( $page_title ) .'</h2>';

	if ( isset( $_GET['gallery_id'] ) ) {
		$gallery_id = intval( $_GET['gallery_id'] );
		$gallery_data = get_post_meta( $gallery_id, '_whizzy_main_gallery', true );
		$gallery_ids = explode( ',', $gallery_data[ 'gallery' ] );

		$attachments = get_posts( array(
			'post_status'    => 'any',
			'post_type'      => 'attachment',
			'post__in'       => $gallery_ids,
			'orderby'        => 'post__in',
			'posts_per_page' => '-1',
		) );

		$output.= '<div class="table-pix-wrap">';
		$output.= '<div class="table wp-list-table widefat fixed striped media">';
		$output.= '<div class="tr">';
		$output.= '<div class="td">';
		$output.=  esc_html__( 'Filename', 'whizzy' );
		$output.= '</div>';
		$output.= '<div class="td">';
		$output.=  esc_html__( 'Name', 'whizzy' );
		$output.= '</div>';
		$output.= '<div class="td">';
		$output.=  esc_html__( 'Downloads ZIP', 'whizzy' );
		$output.= '</div>';
		$output.= '<div class="td">';
		$output.=  esc_html__( 'Downloads PDF', 'whizzy' );
		$output.= '</div>';
		$output.= '</div>';

		foreach ( $attachments as $key => $attachment ) {
			$img_url = wp_get_attachment_image_src( $attachment->ID, 'full');
			// only those selected

			$current_count = get_post_meta( $attachment->ID, 'attr_download', true );
			$current_count_pdf = get_post_meta( $attachment->ID, 'attr_download_pdf', true );

			$path = $img_url[0];
			$filename = substr( strrchr( $path, "/" ), 1 );

			$output.= '<div class="tr">';
			$output.= '<div class="td">';
			$output.= '<img src="' . esc_url( $img_url[0] ) . '" alt="">';
			$output.= '</div>';
			$output.= '<div class="td">';
			$output.= esc_html( $filename );
			$output.= '</div>';
			$output.= '<div class="td">';
			$output.= '<span class="wp-menu-image dashicons-before dashicons-arrow-down-alt"></span> ';
			$output.= !empty($current_count) ? esc_html($current_count) : esc_html('0');
			$output.= esc_html__( ' downloads', 'whizzy' );
			$output.= '</div>';
			$output.= '<div class="td">';
			$output.= '<span class="wp-menu-image dashicons-before dashicons-arrow-down-alt"></span> ';
			$output.= !empty($current_count_pdf) ? esc_html($current_count_pdf) : esc_html('0');
			$output.= esc_html__( ' downloads', 'whizzy' );
			$output.= '</div>';
			$output.= '</div>';

		}
		$output.= '</div>';
		$output.= '</div>';

	} else {


		$output.= '<div class="table-pix-wrap">';
		$output.= '<div class="table wp-list-table widefat fixed striped media">';
		$output.= '<div class="tr">';
		$output.= '<div class="td" style="width:450px;">';
		$output.=  esc_html__( 'Gallery name', 'whizzy' );
		$output.= '</div>';
		$output.= '<div class="td" style="width:170px;">';
		$output.=  esc_html__( 'Downloads ZIP', 'whizzy' );
		$output.= '</div>';
		$output.= '<div class="td">';
		$output.=  esc_html__( 'Downloads PDF', 'whizzy' );
		$output.= '</div>';
		$output.= '</div>';


		$attachments_gallery = get_posts( array(
			'post_status'    => 'any',
			'post_type'      => 'whizzy_proof_gallery',
			'orderby'        => 'post__in',
			'posts_per_page' => '-1',
		) );


		foreach ( $attachments_gallery as $posts ) {
			$current_count_post = get_post_meta( $posts->ID, 'attr_download', true );
			$current_count_post_pdf = get_post_meta( $posts->ID, 'attr_download_pdf', true );

			$output.= '<div class="tr">';
			$output.= '<div class="td">';
			$output.= esc_html( $posts->post_title );
			$output.= '</div>';
			$output.= '<div class="td">';
			$output.= '<span class="wp-menu-image dashicons-before dashicons-arrow-down-alt"></span> ';
			$output.= !empty($current_count_post) ? esc_html( $current_count_post ) : esc_html('0');
			$output.= esc_html__( ' downloads', 'whizzy' );
			$output.= '</div>';
			$output.= '<div class="td">';
			$output.= '<span class="wp-menu-image dashicons-before dashicons-arrow-down-alt"></span> ';
			$output.= !empty($current_count_post_pdf) ? esc_html( $current_count_post_pdf ) : esc_html('0');
			$output.= esc_html__( ' downloads', 'whizzy' );
			$output.= '</div>';
			$output.= '</div>';
		}

		$output.= '</div>';
		$output.= '</div>';
	}

	$output.= '</div>';

	echo $output;

}

function whizzy_settings_page() {
	add_submenu_page(
		'edit.php?post_type=whizzy_proof_gallery',
		__( 'Settings', 'whizzy' ),
		__( 'Settings', 'whizzy' ),
		'manage_options',
		'settings',
		'whizzy_settings_page_callback'
	);
}
add_action( 'admin_menu', 'whizzy_settings_page' );

function whizzy_settings_page_callback() {
	include_once('views/admin.php');
}
