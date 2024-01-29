<?php

/*
Plugin Name: Scheduled
Plugin URI: https://foxthemes.me/
Description: Powerful appointment booking made simple.
Version: 1.0.0
Author: Foxthemes
Author URI: https://foxthemes.me/
Text Domain: scheduled
*/

define( 'SCHEDULED_VERSION', '1.0.0' );
define( 'SCHEDULED_WELCOME_SCREEN', get_option('scheduled_welcome_screen',true) );
define( 'SCHEDULED_DEMO_MODE', get_option('scheduled_demo_mode',false) );
define( 'SCHEDULED_PLUGIN_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'SCHEDULED_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'SCHEDULED_STYLESHEET_DIR', get_stylesheet_directory() );
define( 'SCHEDULED_PLUGIN_TEMPLATES_DIR', SCHEDULED_PLUGIN_DIR . '/templates/' );
define( 'SCHEDULED_AJAX_INCLUDES_DIR', SCHEDULED_PLUGIN_DIR . '/includes/ajax/' );

// FontAwesome Support
require_once __DIR__ . '/vendor/fortawesome/wordpress-fontawesome/index.php';

// Included Add-Ons
require_once SCHEDULED_PLUGIN_DIR . '/includes/add-ons/init.php';

// Scheduled Updates
require_once SCHEDULED_PLUGIN_DIR . '/includes/updates/plugin-update-checker.php';
//$scheduled_update_check = PucFactory::buildUpdateChecker('http://boxyupdates.com/get/?action=get_metadata&slug=scheduled', __FILE__, 'scheduled');

// Scheduled Mailer Functions
require_once('includes/mailer_functions.php');

if(!class_exists('scheduled_plugin')) {
	class scheduled_plugin {
		/**
		 * Construct the plugin object
		 */
		public $scheduled_screens;
		public function __construct() {

			$this->scheduled_screens = apply_filters('scheduled_admin_scheduled_screens', array('scheduled-pending','scheduled-appointments','scheduled-settings','scheduled-welcome'));

			require_once(sprintf("%s/post-types/scheduled_appts.php", SCHEDULED_PLUGIN_DIR));
			$scheduled_appts_post_type = new scheduled_appts_post_type();

			require_once(sprintf("%s/includes/general-functions.php", SCHEDULED_PLUGIN_DIR));
			require_once(sprintf("%s/includes/shortcodes.php", SCHEDULED_PLUGIN_DIR));
			require_once(sprintf("%s/includes/widgets.php", SCHEDULED_PLUGIN_DIR));
			require_once(sprintf("%s/includes/ajax/init.php", SCHEDULED_PLUGIN_DIR));
			require_once(sprintf("%s/includes/ajax/init_admin.php", SCHEDULED_PLUGIN_DIR));

			$scheduled_ajax = new Scheduled_AJAX();
			$scheduled_admin_ajax = new Scheduled_Admin_AJAX();

			add_action('admin_init', array(&$this, 'admin_init'), 9);
			add_action('admin_menu', array(&$this, 'add_menu'));
			add_action('admin_bar_menu', array(&$this, 'add_admin_bar_menu'), 65);

			add_action('the_posts', array(&$this, 'add_to_calendar_check'));

			add_action('admin_enqueue_scripts', array(&$this, 'admin_styles'));
			add_action('admin_enqueue_scripts', array(&$this, 'admin_scripts'));
			add_action('manage_users_custom_column', array(&$this, 'scheduled_add_custom_user_columns'), 15, 3);
			add_filter('manage_users_columns', array(&$this, 'scheduled_add_user_columns'), 15, 1);
			add_filter('user_contactmethods', array(&$this, 'scheduled_phone_numbers'));

			add_action('scheduled_profile_tabs', array(&$this, 'scheduled_profile_tabs'));
			add_action('scheduled_profile_tab_content', array(&$this, 'scheduled_profile_tab_content'));
			add_action('wp_enqueue_scripts', array(&$this, 'front_end_scripts'),1);

			add_action('admin_menu', array(&$this, 'scheduled_add_pending_appt_bubble' ));
			add_action('admin_notices', array(&$this, 'scheduled_pending_notice' ));
			add_action('admin_notices', array(&$this, 'scheduled_no_profile_page_notice' ));
			add_action('parent_file', array(&$this, 'scheduled_tax_menu_correction'));

			add_action( 'scheduled_custom_calendars_add_form_fields', array(&$this, 'scheduled_calendars_add_custom_fields'), 10, 2 );
			add_action( 'scheduled_custom_calendars_edit_form_fields', array(&$this, 'scheduled_calendars_edit_custom_fields'), 10, 2 );
			add_action( 'create_scheduled_custom_calendars', array(&$this, 'scheduled_save_calendars_custom_fields'), 10, 2 );
			add_action( 'edited_scheduled_custom_calendars', array(&$this, 'scheduled_save_calendars_custom_fields'), 10, 2 );

			add_action('init', array(&$this, 'init'),10);

			// Prevent WooCommerce from Redirecting "Booking Agents" to the My Account page.
			add_filter('woocommerce_prevent_admin_access', array(&$this, 'scheduled_wc_check_admin_access'));

			// Allow other plugins/themes to apply Scheduled capabilities to other user roles
			add_filter( 'scheduled_user_roles', array(&$this,'scheduled_user_roles_filter') );

			// Email Reminders (Added in v1.8.0)
			add_filter( 'cron_schedules', array(&$this,'cron_schedules'));
			add_action( 'scheduled_send_admin_reminders', array($this, 'admin_reminders'), 20 );
			add_action( 'scheduled_send_user_reminders', array($this, 'user_reminders'), 20 );

			$user_email_content = get_option('scheduled_reminder_email',false);
			$user_email_subject = get_option('scheduled_reminder_email_subject',false);

			if ($user_email_content && $user_email_subject):
				if ( !wp_next_scheduled('scheduled_send_user_reminders') ):
					wp_schedule_event( time(),'scheduled_everyfive','scheduled_send_user_reminders' );
			    endif;
			else:
				wp_clear_scheduled_hook( 'scheduled_send_user_reminders' );
			endif;

			$admin_email_content = get_option('scheduled_admin_reminder_email',false);
			$admin_email_subject = get_option('scheduled_admin_reminder_email_subject',false);

			if ($admin_email_content && $admin_email_subject):
				if ( !wp_next_scheduled('scheduled_send_admin_reminders') ):
					wp_schedule_event(time(),'scheduled_everyfive','scheduled_send_admin_reminders');
			    endif;
			else:
				wp_clear_scheduled_hook('scheduled_send_admin_reminders');
			endif;

		}

		public static function admin_reminders(){

			$admin_reminder_buffer = get_option('scheduled_admin_reminder_buffer',30);
			$start_timestamp = current_time('timestamp');
			$end_timestamp = strtotime( date_i18n('Y-m-d H:i:s', current_time('timestamp')).' + ' . $admin_reminder_buffer . ' minutes' );

			$args = array(
				'post_type' => 'scheduled_appts',
				'posts_per_page' => 5000,
				'post_status' => array('publish','future'),
				'meta_query' => array(
					array(
						'key'     => '_appointment_timestamp',
						'value'   => array( $start_timestamp, $end_timestamp ),
						'compare' => 'BETWEEN',
					)
				)
			);

			$scheduledAppointments = new WP_Query($args);

			if( $scheduledAppointments->have_posts() ):
				while ( $scheduledAppointments->have_posts() ):

					$scheduledAppointments->the_post();
					global $post;

					$appt_id = $post->ID;
					$reminder_sent = get_post_meta($appt_id,'_appointment_admin_reminder_sent',true);

					$calendars = get_the_terms( $appt_id, 'scheduled_custom_calendars' );
					if ( !empty($calendars) ):
						foreach( $calendars as $calendar ):
							$calendar_id = $calendar->term_id;
						endforeach;
					else:
						$calendar_id = false;
					endif;

					if ( !$reminder_sent && apply_filters( 'scheduled_prepare_sending_reminder', true, $appt_id ) ):

						$email_content = get_option('scheduled_admin_reminder_email',false);
						$email_subject = get_option('scheduled_admin_reminder_email_subject',false);
						if ($email_content && $email_subject):

							$admin_email = scheduled_which_admin_to_send_email( $calendar_id );
							$token_replacements = scheduled_get_appointment_tokens( $appt_id );
							$email_content = scheduled_token_replacement( $email_content,$token_replacements );
							$email_subject = scheduled_token_replacement( $email_subject,$token_replacements );

							update_post_meta($appt_id,'_appointment_admin_reminder_sent',true);

							do_action( 'scheduled_admin_reminder_email', $admin_email, $email_subject, $email_content, $token_replacements['email'], $token_replacements['name'] );

						endif;

					endif;

				endwhile;

			endif;

			wp_reset_postdata();

		}

		public static function user_reminders(){

			$user_reminder_buffer = get_option('scheduled_reminder_buffer',30);

			$start_timestamp = current_time('timestamp');
			$end_timestamp = strtotime(date_i18n('Y-m-d H:i:s',current_time('timestamp')).' + '.$user_reminder_buffer.' minutes');

			$args = array(
				'post_type' => 'scheduled_appts',
				'posts_per_page' => 500,
				'post_status' => array('publish','future'),
				'meta_query' => array(
					array(
						'key'     => '_appointment_timestamp',
						'value'   => array( $start_timestamp, $end_timestamp ),
						'compare' => 'BETWEEN',
					)
				)
			);

			$scheduledAppointments = new WP_Query($args);
			if($scheduledAppointments->have_posts()):
				while ($scheduledAppointments->have_posts()):

					$scheduledAppointments->the_post();
					global $post;

					$appt_id = $post->ID;
					$reminder_sent = get_post_meta($appt_id,'_appointment_user_reminder_sent',true);

					$send_mail = true;
					if ( !$reminder_sent && apply_filters( 'scheduled_prepare_sending_reminder', true, $appt_id ) ):

						$email_content = get_option('scheduled_reminder_email',false);
						$email_subject = get_option('scheduled_reminder_email_subject',false);

						if ($email_content && $email_subject):

							$token_replacements = scheduled_get_appointment_tokens( $appt_id );
							$email_content = scheduled_token_replacement( $email_content,$token_replacements );
							$email_subject = scheduled_token_replacement( $email_subject,$token_replacements );

							update_post_meta($appt_id,'_appointment_user_reminder_sent',true);

							do_action( 'scheduled_reminder_email', $token_replacements['email'], $email_subject, $email_content );

						endif;

					endif;

				endwhile;

			endif;

			wp_reset_postdata();

		}

		public static function cron_schedules( $schedules ) {
			$schedules['scheduled_everyfive'] = array(
				'interval' => 60 * 5,
				'display' => esc_html__('Every Five Minutes', 'scheduled')
			);

			return $schedules;
		}

		public static function activate() {
			set_transient( '_scheduled_welcome_screen_activation_redirect', true, 30 );
		}

		public function scheduled_wc_check_admin_access( $redirect_to ) {
			$scheduled_current_user = wp_get_current_user();
			if( is_array( $scheduled_current_user->roles ) && in_array( 'scheduled_booking_agent', $scheduled_current_user->roles ) ) {
				return false;
  			}
  			return $redirect_to;
		}

		public function admin_init() {
			
			if ( current_user_can('edit_scheduled_appts') && isset($_POST['scheduled_export_appointments_csv']) ):
				include('includes/export-csv.php');
			endif;

			$scheduled_redirect_non_admins = get_option('scheduled_redirect_non_admins',false);

			// Redirect non-admin users
			if ($scheduled_redirect_non_admins):
				if (!current_user_can('edit_scheduled_appts') && !defined( 'DOING_AJAX' )){

					$scheduled_profile_page = scheduled_get_profile_page();

					if ($scheduled_profile_page):
						$redirect_url = get_permalink($scheduled_profile_page);
					else:
						$redirect_url = home_url();
					endif;

					wp_redirect( $redirect_url );
					exit;

				}
			endif;

			// Set up the settings for this plugin
			require_once(sprintf("%s/includes/admin-functions.php", SCHEDULED_PLUGIN_DIR));
			require_once(sprintf("%s/includes/dashboard-widget.php", SCHEDULED_PLUGIN_DIR));
			$this->init_settings();

			// Welcome Screen Redirect
			if ( !get_transient( '_scheduled_welcome_screen_activation_redirect' ) ) {
				return;
  			}

  			delete_transient( '_scheduled_welcome_screen_activation_redirect' );

  			if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
  				return;
  			}

  			if (SCHEDULED_WELCOME_SCREEN):
  				wp_safe_redirect( add_query_arg( array( 'page' => 'scheduled-welcome' ), admin_url( 'admin.php' ) ) );
  				exit;
  			endif;
  			// END Welcome Screen Redirect

  			return;

		} // END public static function activate

		public function scheduled_curl($url){

			if ( function_exists('curl_init') ):

				$ch = curl_init();
				$timeout = 5;
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$data = curl_exec($ch);
				curl_close($ch);
				if ($data):
					return $data;
				else:
					return false;
				endif;

			else:

				return false;

			endif;

		}

		public function scheduled_profile_tabs($default_tabs){

			foreach($default_tabs as $slug => $name):
				echo '<li'.($name['class'] ? ' class="'.$name['class'].'"' : '').'><a href="#'.$slug.'"><i class="fa-solid fa-'.$name['fa-icon'].'"></i>'.$name['title'].'</a></li>';
			endforeach;

		}

		public function scheduled_profile_tab_content($default_tabs){

			foreach($default_tabs as $slug => $name):
				echo '<div id="profile-'.$slug.'" class="scheduled-tab-content scheduledClearFix">';
					call_user_func('scheduled_profile_content_'.$slug);
				echo '</div>';
			endforeach;

		}

		public function init() {

			// Hide the Admin Bar from subscribers.
		    $scheduled_current_user = wp_get_current_user();
			if ( isset($scheduled_current_user->roles[0]) && in_array( 'subscriber',$scheduled_current_user->roles ) ) {
				add_filter('show_admin_bar', '__return_false');
			}

			// Include the Scheduled functions file.
			require_once(sprintf("%s/includes/functions.php", SCHEDULED_PLUGIN_DIR));

			// Start a session if none is started yet.
			//Added check if headers sent - patch
			if( !headers_sent() && !(session_id() && apply_filters( 'scheduled_sessions_enabled', true ) ) ){
		        session_start();
		    }

		    // Check to see if the plugin was updated.
			$current_version = get_option('scheduled_version_check','1.6.20');
			if ( version_compare( $current_version, SCHEDULED_VERSION ) < 0 && !SCHEDULED_DEMO_MODE):
				update_option('scheduled_version_check',SCHEDULED_VERSION);
				set_transient( '_scheduled_welcome_screen_activation_redirect', true, 60 );
				set_transient('scheduled_show_new_tags',true,60*60*24*15);
			else:
				update_option('scheduled_version_check',SCHEDULED_VERSION);
			endif;

			//Site health issues fix - patch
			session_write_close();

		}

		public function add_to_calendar_check($posts){

		    if (empty($posts)):
		    	return $posts;
		    endif;

		    $found = false;

			foreach ($posts as $post):

				$profile_shortcode = stripos($post->post_content, '[scheduled-profile');
				$appts_shortcode = stripos($post->post_content, '[scheduled-appointments');

				if ( $profile_shortcode !== false || $appts_shortcode !== false):
					$found = true;
					break;
				endif;

			endforeach;

		    return $posts;

		}

		static function plugin_settings() {
			$plugin_options = array(
				'scheduled_login_redirect_page',
				'scheduled_custom_login_message',
				'scheduled_appointment_redirect_type',
				'scheduled_appointment_success_redirect_page',
				'scheduled_registration_name_requirements',
				'scheduled_hide_admin_bar_menu',
				'scheduled_timeslot_intervals',
				'scheduled_appointment_buffer',
				'scheduled_appointment_limit',
				'scheduled_cancellation_buffer',
				'scheduled_new_appointment_default',
				'scheduled_prevent_appointments_before',
				'scheduled_prevent_appointments_after',
				'scheduled_booking_type',
				'scheduled_require_guest_email_address',
				'scheduled_hide_default_calendar',
				'scheduled_hide_unavailable_timeslots',
				'scheduled_hide_google_link',
				'scheduled_hide_weekends',
				'scheduled_dont_allow_user_cancellations',
				'scheduled_show_only_titles',
				'scheduled_hide_end_times',
				'scheduled_hide_available_timeslots',
				'scheduled_public_appointments',
				'scheduled_redirect_non_admins',
				'scheduled_light_color',
				'scheduled_dark_color',
				'scheduled_button_color',
				'scheduled_email_logo',
				'scheduled_default_email_user',
				'scheduled_email_force_sender',
				'scheduled_email_force_sender_from',
				'scheduled_emailer_disabled',
				'scheduled_reminder_buffer',
				'scheduled_admin_reminder_buffer',
				'scheduled_reminder_email',
				'scheduled_admin_reminder_email',
				'scheduled_reminder_email_subject',
				'scheduled_admin_reminder_email_subject',
				'scheduled_registration_email_subject',
				'scheduled_registration_email_content',
				'scheduled_approval_email_content',
				'scheduled_approval_email_subject',
				'scheduled_cancellation_email_content',
				'scheduled_cancellation_email_subject',
				'scheduled_appt_confirmation_email_content',
				'scheduled_appt_confirmation_email_subject',
				'scheduled_admin_appointment_email_content',
				'scheduled_admin_appointment_email_subject',
				'scheduled_admin_cancellation_email_content',
				'scheduled_admin_cancellation_email_subject'
			);

			return $plugin_options;
		}

		public function init_settings() {
			$plugin_options = $this->plugin_settings();
			foreach($plugin_options as $option_name) {
				register_setting('scheduled_plugin-group', $option_name);
			}
		}


		public function scheduled_phone_numbers($profile_fields) {
			$profile_fields['scheduled_phone'] = esc_html__('Phone Number','scheduled');
			return $profile_fields;
		}


		/**********************
		ADD MENUS FUNCTION
		**********************/

		public function add_menu() {
			add_menu_page( esc_html__('Appointments','scheduled'), esc_html__('Appointments','scheduled'), 'edit_scheduled_appts', 'scheduled-appointments', array(&$this, 'admin_calendar'), 'dashicons-calendar-alt', 58 );
			add_submenu_page('scheduled-appointments', esc_html__('Pending','scheduled'), esc_html__('Pending','scheduled'), 'edit_scheduled_appts', 'scheduled-pending', array(&$this, 'admin_pending_list'));
			add_submenu_page('scheduled-appointments', esc_html__('Calendars','scheduled'), esc_html__('Calendars','scheduled'), 'manage_scheduled_options', 'edit-tags.php?taxonomy=scheduled_custom_calendars');
			add_submenu_page('scheduled-appointments', esc_html__('Settings','scheduled'), esc_html__('Settings','scheduled'), 'edit_scheduled_appts', 'scheduled-settings', array(&$this, 'plugin_settings_page'));
			add_submenu_page('scheduled-appointments', esc_html__('What\'s New?','scheduled'), esc_html__('What\'s New?','scheduled'), 'manage_scheduled_options', 'scheduled-welcome', array(&$this, 'scheduled_welcome_content'));
		}

		public function add_admin_bar_menu() {

			$hide_menu = get_option('scheduled_hide_admin_bar_menu',false);

			if (!$hide_menu):

				global $wp_admin_bar;

				$wp_admin_bar->add_menu(array('id' => 'scheduled', 'title' => '<span class="ab-icon"></span>'.esc_html__('Appointments','scheduled'), 'href' => get_admin_url().'admin.php?page=scheduled-appointments'));
				$wp_admin_bar->add_menu(array('parent' => 'scheduled', 'title' => esc_html__('Appointments','scheduled'), 'id' => 'scheduled-appointments', 'href' => get_admin_url().'admin.php?page=scheduled-appointments'));
				$wp_admin_bar->add_menu(array('parent' => 'scheduled', 'title' => esc_html__('Pending','scheduled'), 'id' => 'scheduled-pending', 'href' => get_admin_url().'admin.php?page=scheduled-pending'));
				if (current_user_can('manage_scheduled_options')):
					$wp_admin_bar->add_menu(array('parent' => 'scheduled', 'title' => esc_html__('Calendars','scheduled'), 'id' => 'scheduled-calendars', 'href' => get_admin_url().'edit-tags.php?taxonomy=scheduled_custom_calendars'));
				endif;
				$wp_admin_bar->add_menu(array('parent' => 'scheduled', 'title' => esc_html__('Settings','scheduled'), 'id' => 'scheduled-settings', 'href' => get_admin_url().'admin.php?page=scheduled-settings'));

			endif;

		}

		public function scheduled_welcome_content(){
			include(sprintf("%s/templates/welcome.php", SCHEDULED_PLUGIN_DIR));
		}

		// Move Taxonomy (custom calendars) to Appointments Menu
		public function scheduled_tax_menu_correction($parent_file) {
			global $current_screen;
			$taxonomy = $current_screen->taxonomy;
			if ($taxonomy == 'scheduled_custom_calendars')
				$parent_file = 'scheduled-appointments';
			return $parent_file;
		}

		// Scheduled Settings
		public function plugin_settings_page() {
			if(!current_user_can('edit_scheduled_appts')) {
				wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'scheduled'));
			}
			include(sprintf("%s/templates/settings.php", SCHEDULED_PLUGIN_DIR));
		}

		// Scheduled Pending Appointments List
		public function admin_pending_list() {
			if(!current_user_can('edit_scheduled_appts')) {
				wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'scheduled'));
			}
			include(sprintf("%s/templates/pending-list.php", SCHEDULED_PLUGIN_DIR));
		}

		// Scheduled Appointment Calendar
		public function admin_calendar() {
			if(!current_user_can('edit_scheduled_appts')) {
				wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'scheduled'));
			}
			include(sprintf("%s/templates/admin-calendar.php", SCHEDULED_PLUGIN_DIR));
		}

		// Add Pending Appointments Bubble
		public function scheduled_add_pending_appt_bubble() {

			global $submenu;

			$pending = scheduled_pending_appts_count();

			foreach ( $submenu as $key => $value ) :
				if ( $key == 'scheduled-appointments' ) :
					if ( $pending ) { $submenu[$key][1][0] .= "&nbsp;<span class='awaiting-mod count-$pending' title='$pending'><span class='pending-count' aria-hidden='true'>$pending</span><span class='comments-in-moderation-text screen-reader-text'>$pending Pending Bookings</span></span>"; }
					return;
				endif;
			endforeach;

		}

		public function scheduled_no_profile_page_notice() {

			if (current_user_can('manage_scheduled_options')):

				$scheduled_booking_type = get_option('scheduled_booking_type','registered');
				$scheduled_redirect_type =  get_option('scheduled_appointment_redirect_type',false);
				$scheduled_profile_page = scheduled_get_profile_page();
				$page = (isset($_GET['page']) ? $page = esc_html( $_GET['page'] ) : $page = false);

				if ($scheduled_booking_type == 'registered' && $scheduled_redirect_type == 'scheduled-profile' && !$scheduled_profile_page && $page != 'scheduled-welcome'):

					echo '<div class="notice notice-warning" style="line-height:37px; border-left-color:#DB5933;">';
						echo sprintf(esc_html__( 'You need to create a page with the %s shortcode. It is required with your current settings.','scheduled' ),'<code>[scheduled-profile]</code>').'&nbsp;&nbsp;&nbsp;<a href="'.get_admin_url().'post-new.php?post_type=page">'.esc_html__('Create a Page','scheduled').'</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="'.get_admin_url().'admin.php?page=scheduled-settings">'.esc_html__('Change Settings','scheduled').'</a>';
					echo '</div>';

				endif;

			endif;

		}

		public function scheduled_pending_notice() {

			if (current_user_can('edit_scheduled_appts')):

				$pending = scheduled_pending_appts_count();
				$page = (isset($_GET['page']) ? $page = esc_html( $_GET['page'] ) : $page = false);
				if ($pending && $page != 'scheduled-pending' && $page != 'scheduled-welcome'):

					echo '<div class="notice notice-warning" style="line-height:37px">';
						echo sprintf( _n( 'There is %s pending appointment.', 'There are %s pending appointments.', $pending, 'scheduled' ), $pending ).'&nbsp;&nbsp;<a href="'.get_admin_url().'admin.php?page=scheduled-pending">'._n('View Pending Appointment','View Pending Appointments',$pending,'scheduled').' &rarr;</a>';
					echo '</div>';

				endif;

			endif;

		}

		/**********************
		ADD USER FIELD TO CALENDAR TAXONOMY PAGE
		**********************/
		public function scheduled_calendars_add_custom_fields($tag) {

			?><div class="form-field">
				<label for="term_meta[notifications_user_id]"><?php esc_html_e('Assign this calendar to','scheduled'); ?>:</label>
				<select name="term_meta[notifications_user_id]" id="term_meta[notifications_user_id]">
				<option value=""><?php esc_html_e('Default','scheduled'); ?></option><?php

					$allowed_users = get_users( array( 'role__in' => array( 'administrator', 'scheduled_booking_agent' ) ) );

					if(!empty($allowed_users)) :
						foreach($allowed_users as $u) :
							$user_id = $u->ID;
							$email = $u->data->user_email;
							$display_name = ( isset( $u->data->display_name ) && $u->data->display_name ? $u->data->display_name . ' (' . $email .')' : $email ); ?>
							<option value="<?php echo $email; ?>"><?php echo $display_name; ?></option><?php
						endforeach;
					endif;

				?></select>
				<p><?php esc_html_e('This will use your setting from the Scheduled Settings panel by default.','scheduled'); ?></p>
			</div><?php

		}

		public function scheduled_calendars_edit_custom_fields($tag) {

			$t_id = $tag->term_id;
			$term_meta = get_option( "taxonomy_$t_id" );
			$selected_value = $term_meta['notifications_user_id'];

			$allowed_users = get_users( array( 'role__in' => array( 'administrator', 'scheduled_booking_agent' ) ) ); ?>

			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="term_meta[notifications_user_id]"><?php esc_html_e('Assign this calendar to','scheduled'); ?>:</label>
				</th>
				<td>
					<select name="term_meta[notifications_user_id]" id="term_meta[notifications_user_id]">
						<option value=""><?php esc_html_e('Default','scheduled'); ?></option>
						<?php if(!empty($allowed_users)) :
							foreach($allowed_users as $u) :
								$user_id = $u->ID;
								$email = $u->data->user_email;
								$display_name = ( isset( $u->data->display_name ) && $u->data->display_name ? $u->data->display_name . ' (' . $email .')' : $email ); ?>
								<option value="<?php echo $email; ?>"<?php echo ($selected_value == $email ? ' selected="selected"' : ''); ?>><?php echo $display_name; ?></option>
							<?php endforeach;

						endif; ?>
					</select><br>
					<span class="description"><?php esc_html_e('This will use your setting from the Scheduled Settings panel by default.'); ?></span>
				</td>
			</tr><?php
		}

		/**********************
		SAVE USER FIELD FROM CALENDAR TAXONOMY PAGE
		**********************/
		public function scheduled_save_calendars_custom_fields( $term_id ) {
			if ( isset( $_POST['term_meta'] ) ) {
				$t_id = $term_id;
				$term_meta = get_option( "taxonomy_$t_id" );
				$cat_keys = array_keys( $_POST['term_meta'] );
				foreach ( $cat_keys as $key ) {
					if ( isset ( $_POST['term_meta'][$key] ) ) {
						$term_meta[$key] = $_POST['term_meta'][$key];
					}
				}
				update_option( "taxonomy_$t_id", $term_meta );
			}
		}

		/**********************
		ADD USER COLUMN FOR APPOINTMENT COUNTS
		**********************/

		public function scheduled_add_user_columns( $defaults ) {
			$defaults['scheduled_appts'] = esc_html__('Appointments', 'scheduled');
			return $defaults;
		}
		public function scheduled_add_custom_user_columns( $value, $column_name, $id ) {

			if ( $column_name == 'scheduled_appts' ) {

				$args = array(
					'posts_per_page'   	=> 500,
					'meta_key'   	   	=> '_appointment_timestamp',
					'orderby'			=> 'meta_value_num',
					'order'            	=> 'ASC',
					'meta_query' => array(
						array(
							'key'     => '_appointment_timestamp',
							'value'   => strtotime(date_i18n('Y-m-d H:i:s')),
							'compare' => '>=',
						),
					),
					'author'		   	=> $id,
					'post_type'        	=> 'scheduled_appts',
					'post_status'      	=> array('publish','future'),
					'suppress_filters'	=> true );

				$appointments = get_posts($args);
				$count = count($appointments);

				$appointments = array_slice($appointments, 0, 5);
				$time_format = get_option('time_format');
				$date_format = get_option('date_format');

				ob_start();

				if ($count){

					echo '<strong>'.$count.' '._n('Upcoming Appointment','Upcoming Appointments',$count,'scheduled').':</strong>';

					echo '<span style="font-size:12px;">';

					foreach($appointments as $appointment):
						$timeslot = get_post_meta($appointment->ID, '_appointment_timeslot',true);
						$timeslot = explode('-',$timeslot);
						$timestamp = get_post_meta($appointment->ID, '_appointment_timestamp',true);
						echo '<br>' . date_i18n($date_format,$timestamp) . ' @ ' . date_i18n($time_format,strtotime($timeslot[0])) . '&ndash;' . date_i18n($time_format,strtotime($timeslot[1]));
					endforeach;

					if ($count > 5):
						$diff = $count - 5;
						echo '<br>...'.esc_html__('and','scheduled').' '.$diff.' '.esc_html__('more','scheduled');
					endif;

					echo '</span>';

				}

				return ob_get_clean();

			} else {

				return $value;

			}

		}


		// --------- ADMIN SCRIPTS/STYLES --------- //

		public function admin_scripts() {

			$current_page = (isset($_GET['page']) ? esc_html( $_GET['page'] ) : false);
			$screen = get_current_screen();

			// Gonna need jQuery
			wp_enqueue_script('jquery');

			// For Serializing Arrays
			if ($current_page == 'scheduled-settings' || $screen->id == 'dashboard'):
				wp_enqueue_script('scheduled-serialize', SCHEDULED_PLUGIN_URL . '/assets/js/jquery.serialize.js', array(), SCHEDULED_VERSION);
			endif;

			// Load the rest of the stuff!
			if (in_array($current_page,$this->scheduled_screens) || $screen->id == 'dashboard'):

				wp_enqueue_media();
				wp_enqueue_script('wp-color-picker');
				wp_enqueue_script('jquery-ui');
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('jquery-ui-datepicker');
				wp_enqueue_script('spin-js', SCHEDULED_PLUGIN_URL . '/assets/js/spin.min.js', array(), '2.0.1');
				wp_enqueue_script('spin-jquery', SCHEDULED_PLUGIN_URL . '/assets/js/spin.jquery.js', array(), '2.0.1');
				wp_enqueue_script('scheduled-chosen', SCHEDULED_PLUGIN_URL . '/assets/js/chosen/chosen.jquery.min.js', array(), '1.2.0');
				wp_enqueue_script('scheduled-fitvids', SCHEDULED_PLUGIN_URL . '/assets/js/fitvids.js', array(), '1.1');
				wp_enqueue_script('scheduled-tooltipster', SCHEDULED_PLUGIN_URL . '/assets/js/tooltipster/js/jquery.tooltipster.min.js', array(), '3.3.0', true);
				wp_register_script('scheduled-admin', SCHEDULED_PLUGIN_URL . '/assets/js/admin-functions.js', array(), SCHEDULED_VERSION);

				// WPML Compatibility with AJAX calls
				$ajax_url = admin_url( 'admin-ajax.php' );
				$wpml_current_language = apply_filters( 'wpml_current_language', NULL );
				if ( $wpml_current_language ) {
					$ajax_url = add_query_arg( 'wpml_lang', $wpml_current_language, $ajax_url );
				}

				$scheduled_js_vars = array(
					'ajax_url' => $ajax_url,
					'ajaxRequests' => array(),
					'i18n_slot' => esc_html( _x('Space Available', 'Single Space', 'scheduled') ),
					'i18n_slots' => esc_html( _x('Spaces Available', 'Multiple Spaces', 'scheduled') ),
					'i18n_add' => esc_html__('Add Timeslots','scheduled'),
					'i18n_time_error' => esc_html__('The "End Time" needs to be later than the "Start Time".','scheduled'),
					'i18n_bulk_add_confirm' => esc_html__('Are you sure you want to add those bulk time slots?','scheduled'),
					'i18n_all_fields_required' => esc_html__('All fields are required.','scheduled'),
					'i18n_single_add_confirm' => esc_html__('You are about to add the following time slot(s)','scheduled'),
					'i18n_to' => esc_html__('to','scheduled'),
					'i18n_please_wait' => esc_html__('Please wait ...','scheduled'),
					'i18n_update_appointment' => esc_html__('Update Appointment','scheduled'),
					'i18n_create_appointment' => esc_html__('Create Appointment','scheduled'),
					'i18n_all_day' => esc_html__('All day','scheduled'),
					'i18n_enable' => esc_html__('Enable','scheduled'),
					'i18n_disable' => esc_html__('Disable','scheduled'),
					'i18n_change_date' => esc_html__('Change Date','scheduled'),
					'i18n_choose_customer' => esc_html__('Please choose a customer.','scheduled'),
					'i18n_fill_out_required_fields' => esc_html__('Please fill out all required fields.','scheduled'),
					'i18n_confirm_ts_delete' => esc_html__('Are you sure you want to delete this time slot?','scheduled'),
					'i18n_confirm_cts_delete' => esc_html__('Are you sure you want to delete this custom time slot?','scheduled'),
					'i18n_confirm_appt_delete' => esc_html__('Are you sure you want to cancel this appointment?','scheduled'),
					'i18n_clear_timeslots_confirm' => esc_html__('Are you sure you want to delete all of the timeslots for this day?','scheduled'),
					'i18n_appt_required_fields' => esc_html__('A name, email address and password are required.','scheduled'),
					'i18n_appt_required_guest_fields' => esc_html__('A name is required.','scheduled'),
					'i18n_appt_required_guest_fields_surname' => esc_html__('A first and last name are required.','scheduled'),
					'i18n_appt_required_guest_fields_all' => esc_html__('A first name, last name and email address are required.','scheduled'),
					'i18n_appt_required_guest_fields_name_email' => esc_html__('A name and an email address are required.','scheduled'),
					'i18n_confirm_appt_approve' => esc_html__('Are you sure you want to approve this appointment?','scheduled'),
					'i18n_confirm_appt_approve_all' => esc_html__('Are you sure you want to approve ALL pending appointments?','scheduled'),
					'i18n_confirm_appt_delete_all' => esc_html__('Are you sure you want to delete ALL pending appointments?','scheduled'),
					'i18n_confirm_appt_delete_past' => esc_html__('Are you sure you want to delete all PASSED pending appointments?','scheduled'),
					'nonce' => wp_create_nonce('ajax-admin-nonce')
				);

				wp_localize_script('scheduled-admin', 'scheduled_js_vars', $scheduled_js_vars );
				wp_enqueue_script('scheduled-admin');

			endif;

		}

		public function admin_styles() {

			$current_page = (isset($_GET['page']) ? esc_html( $_GET['page'] ) : false);
			$screen = get_current_screen();

			if (in_array($current_page,$this->scheduled_screens) || $screen->id == 'dashboard'):
				wp_enqueue_style('wp-color-picker');
				wp_enqueue_style('scheduled-tooltipster', 	SCHEDULED_PLUGIN_URL . '/assets/js/tooltipster/css/tooltipster.css', array(), '3.3.0');
				wp_enqueue_style('scheduled-tooltipster-theme', 	SCHEDULED_PLUGIN_URL . '/assets/js/tooltipster/css/themes/tooltipster-light.css', array(), '3.3.0');
				wp_enqueue_style('chosen', SCHEDULED_PLUGIN_URL . '/assets/js/chosen/chosen.min.css', array(), '1.2.0');
				wp_enqueue_style('scheduled-animations', SCHEDULED_PLUGIN_URL . '/assets/css/animations.css', array(), SCHEDULED_VERSION);
				wp_enqueue_style('scheduled-admin', SCHEDULED_PLUGIN_URL . '/dist/scheduled-admin.css', array(), SCHEDULED_VERSION);
			endif;

		}


		// --------- FRONT-END SCRIPTS/STYLES --------- //

		public function front_end_scripts() {

			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui');
			wp_enqueue_script('jquery-ui-datepicker');
			wp_register_script('scheduled-atc', SCHEDULED_PLUGIN_URL . '/assets/js/atc.min.js', array(), '1.6.1', true );
			wp_enqueue_script('scheduled-spin-js', 	SCHEDULED_PLUGIN_URL . '/assets/js/spin.min.js', array(), '2.0.1', true);
			wp_enqueue_script('scheduled-spin-jquery', SCHEDULED_PLUGIN_URL . '/assets/js/spin.jquery.js', array(), '2.0.1', true);
			wp_enqueue_script('scheduled-tooltipster', SCHEDULED_PLUGIN_URL . '/assets/js/tooltipster/js/jquery.tooltipster.min.js', array(), '3.3.0', true);
			wp_register_script('scheduled-functions', SCHEDULED_PLUGIN_URL . '/assets/js/functions.js', array(), SCHEDULED_VERSION, true);

			$scheduled_redirect_type = get_option('scheduled_appointment_redirect_type','scheduled-profile');
			$scheduled_detect_profile_page = scheduled_get_profile_page();

			if ($scheduled_redirect_type == 'scheduled-profile'):
				$profile_page = ( $scheduled_detect_profile_page ? $scheduled_detect_profile_page : false );
			elseif ($scheduled_redirect_type == 'page'):
				$profile_page = get_option( 'scheduled_appointment_success_redirect_page',false );
			else:
				$profile_page = false;
			endif;

			$profile_page = ( $profile_page ? esc_url( get_permalink( $profile_page ) ) : false );

			// WPML Compatibility with AJAX calls
			$ajax_url = admin_url( 'admin-ajax.php' );
			$wpml_current_language = apply_filters( 'wpml_current_language', NULL );
			if ( $wpml_current_language ) {
				$ajax_url = add_query_arg( 'wpml_lang', $wpml_current_language, $ajax_url );
			}

			$scheduled_js_vars = array(
				'ajax_url' => $ajax_url,
				'profilePage' => $profile_page,
				'publicAppointments' => get_option('scheduled_public_appointments',false),
				'i18n_confirm_appt_delete' => esc_html__('Are you sure you want to cancel this appointment?','scheduled'),
				'i18n_please_wait' => esc_html__('Please wait ...','scheduled'),
				'i18n_wrong_username_pass' => esc_html__('Wrong username/password combination.','scheduled'),
				'i18n_fill_out_required_fields' => esc_html__('Please fill out all required fields.','scheduled'),
				'i18n_guest_appt_required_fields' => esc_html__('Please enter your name to book an appointment.','scheduled'),
				'i18n_appt_required_fields' => esc_html__('Please enter your name, your email address and choose a password to book an appointment.','scheduled'),
				'i18n_appt_required_fields_guest' => esc_html__('Please fill in all "Information" fields.','scheduled'),
				'i18n_password_reset' => esc_html__('Please check your email for instructions on resetting your password.','scheduled'),
				'i18n_password_reset_error' => esc_html__('That username or email is not recognized.','scheduled'),
				'nonce' => wp_create_nonce('ajax-nonce')
			);
			wp_localize_script( 'scheduled-functions', 'scheduled_js_vars', $scheduled_js_vars );
			wp_enqueue_script('scheduled-functions');

		}

		public static function front_end_styles() {

			wp_enqueue_style('scheduled-tooltipster', SCHEDULED_PLUGIN_URL . '/assets/js/tooltipster/css/tooltipster.css', array(), '3.3.0');
			wp_enqueue_style('scheduled-tooltipster-theme', SCHEDULED_PLUGIN_URL . '/assets/js/tooltipster/css/themes/tooltipster-light.css', array(), '3.3.0');
			wp_enqueue_style('scheduled-animations', SCHEDULED_PLUGIN_URL . '/assets/css/animations.css', array(), SCHEDULED_VERSION);
			wp_enqueue_style('scheduled-css', SCHEDULED_PLUGIN_URL . '/dist/scheduled.css', array(), SCHEDULED_VERSION);

			if ( defined('NECTAR_THEME_NAME') && NECTAR_THEME_NAME == 'salient' ):
				wp_enqueue_style('scheduled-salient-overrides', SCHEDULED_PLUGIN_URL . '/assets/css/theme-specific/salient.css', array(), SCHEDULED_VERSION);
			endif;
			
			if (!isset($_GET['print'])):
				$colors_pattern_file = SCHEDULED_PLUGIN_DIR . '/assets/css/color-theme.php';
				if ( !file_exists($colors_pattern_file) ) {
					return;
				}
			
				ob_start();
				include(esc_attr($colors_pattern_file));
				$scheduled_color_css = ob_get_clean();
				$compressed_scheduled_color_css = scheduled_compress_css( $scheduled_color_css );
				
				wp_add_inline_style( 'scheduled-css', $compressed_scheduled_color_css );
			
			endif;

		}

		public static function scheduled_user_roles_filter( $scheduled_user_roles ) {
			return $scheduled_user_roles;
		}

	} // END class scheduled_plugin
} // END if(!class_exists('scheduled_plugin'))

if(class_exists('scheduled_plugin')) {

	// Add the "Booking Agent" User Role
	$booking_agent = add_role(
	    'scheduled_booking_agent',
	    esc_html__( 'Booking Agent','scheduled' ),
	    array(
	        'read' => true,
	    )
	);

	// Add Capabilities to User Roles (the below array can be filtered to include more or exclude any of the defaults)
	$scheduled_user_roles = apply_filters( 'scheduled_user_roles', array('administrator','scheduled_booking_agent') );

	foreach($scheduled_user_roles as $role_name):
		$role_caps = get_role($role_name);
		$role_caps->add_cap( 'edit_scheduled_appts' );
	endforeach;

	$scheduled_admin_caps = get_role( 'administrator' );
	$scheduled_admin_caps->add_cap('manage_scheduled_options');

	// Activation Hook
	register_activation_hook( __FILE__, array('scheduled_plugin', 'activate'));
	register_activation_hook( __FILE__, 'FortAwesome\FontAwesome_Loader::initialize' );
	register_deactivation_hook( __FILE__, 'FortAwesome\FontAwesome_Loader::maybe_deactivate' );
	
	add_action(
		'font_awesome_preferences',
		function() {
			fa()->register(
				array(
					'name' => 'Scheduled',
					'version' => [
						[ '6.1.2', '>=' ]
					]
				)
			);
		}
	);

	// Initiate the Scheduled Class
	$scheduled_plugin = new scheduled_plugin();

	// Add a link to the settings page onto the plugin page
	if(isset($scheduled_plugin)) {

		// Add the settings link to the plugins page
		function scheduled_custom_links($links) {

			$custom_links[] = '<a href="admin.php?page=scheduled-settings">'.esc_html__('Settings','scheduled').'</a>';
			$custom_links[] = '<a href="'.trailingslashit(get_admin_url()).'admin.php?page=scheduled-welcome">'.esc_html__('What\'s New?','scheduled').'</a>';

			foreach($custom_links as $custom_link):
				array_unshift($links, $custom_link);
			endforeach;

			return $links;

		}

		$plugin = plugin_basename(__FILE__);
		add_filter("plugin_action_links_$plugin", 'scheduled_custom_links');

		// Load the Front-End Styles and Color Settings
		add_action('wp_enqueue_scripts', array('scheduled_plugin', 'front_end_styles'));

	}
}

// Localization
function scheduled_local_init(){
	$domain = 'scheduled';
	$locale = apply_filters('plugin_locale', get_locale(), $domain);
	load_textdomain($domain, WP_LANG_DIR.'/scheduled/'.$domain.'-'.$locale.'.mo');
	load_plugin_textdomain($domain, FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
}
add_action('after_setup_theme', 'scheduled_local_init');
