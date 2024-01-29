<?php

if(!class_exists('Scheduled_AJAX')) {
	class Scheduled_AJAX {

		public function __construct() {

			// ------------ Guests & Logged-in Users ------------ //

				// Actions

			add_action('wp_ajax_scheduled_ajax_login', array(&$this,'scheduled_ajax_login'));
			add_action('wp_ajax_nopriv_scheduled_ajax_login', array(&$this,'scheduled_ajax_login'));

			add_action('wp_ajax_scheduled_ajax_forgot', array(&$this,'scheduled_ajax_forgot'));
			add_action('wp_ajax_nopriv_scheduled_ajax_forgot', array(&$this,'scheduled_ajax_forgot'));

			add_action('wp_ajax_scheduled_add_appt', array(&$this,'scheduled_add_appt'));
			add_action('wp_ajax_nopriv_scheduled_add_appt', array(&$this,'scheduled_add_appt'));

				// Loaders

			add_action('wp_ajax_scheduled_calendar_month', array(&$this,'scheduled_calendar_month'));
			add_action('wp_ajax_nopriv_scheduled_calendar_month', array(&$this,'scheduled_calendar_month'));

			add_action('wp_ajax_scheduled_calendar_date', array(&$this,'scheduled_calendar_date'));
			add_action('wp_ajax_nopriv_scheduled_calendar_date', array(&$this,'scheduled_calendar_date'));

			add_action('wp_ajax_scheduled_appointment_list_date', array(&$this,'scheduled_appointment_list_date'));
			add_action('wp_ajax_nopriv_scheduled_appointment_list_date', array(&$this,'scheduled_appointment_list_date'));

			add_action('wp_ajax_scheduled_new_appointment_form', array(&$this,'scheduled_new_appointment_form'));
			add_action('wp_ajax_nopriv_scheduled_new_appointment_form', array(&$this,'scheduled_new_appointment_form'));


			// ------------ Logged-in Users Only ------------ //

				// Actions

			add_action('wp_ajax_scheduled_cancel_appt', array(&$this,'scheduled_cancel_appt'));

		}
		
		public static function nonce_check( $nonce ){
			if ( !wp_verify_nonce( $_POST['nonce'], $nonce ) ){
				die ( 'Required "nonce" value is not here, please let the developer know.');
			}
		}


		// ------------ LOADERS ------------ //

		// Calendar Month
		public function scheduled_calendar_month(){
			
			Scheduled_AJAX::nonce_check( 'ajax-nonce' );

			scheduled_wpml_ajax();

			if (isset($_POST['gotoMonth'])):

				$calendar_id = (isset($_POST['calendar_id']) ? $_POST['calendar_id'] : false);
				$force_default = (isset($_POST['force_default']) ? $_POST['force_default'] : false);
				$timestamp = ($_POST['gotoMonth'] != 'false' ? strtotime($_POST['gotoMonth']) : current_time('timestamp'));

				$year = date_i18n('Y',$timestamp);
				$month = date_i18n('m',$timestamp);

				scheduled_fe_calendar($year,$month,$calendar_id,$force_default);

			endif;
			wp_die();

		}

		// Calendar Date
		public function scheduled_calendar_date(){
			
			Scheduled_AJAX::nonce_check( 'ajax-nonce' );

			scheduled_wpml_ajax();

			if (isset($_POST['date'])):

				$calendar_id = (isset($_POST['calendar_id']) ? $_POST['calendar_id'] : false);
				scheduled_fe_calendar_date_content($_POST['date'],$calendar_id);

			endif;
			wp_die();

		}

		// Appointment List Date
		public function scheduled_appointment_list_date(){
			
			Scheduled_AJAX::nonce_check( 'ajax-nonce' );

			scheduled_wpml_ajax();

			if (isset($_POST['date'])):

				$date = date_i18n('Ymd',strtotime($_POST['date']));
				$calendar_id = (isset($_POST['calendar_id']) ? $_POST['calendar_id'] : false);
				$force_default = (isset($_POST['force_default']) ? $_POST['force_default'] : false);

				scheduled_fe_appointment_list_content($date,$calendar_id,$force_default);

			endif;
			wp_die();

		}

		// New Appointment Form
		public function scheduled_new_appointment_form(){
			
			Scheduled_AJAX::nonce_check( 'ajax-nonce' );

			scheduled_wpml_ajax();

			if ( apply_filters( 'scheduled_show_new_appointment_form', true ) ):

				include(SCHEDULED_AJAX_INCLUDES_DIR . 'front/appointment-form.php');

			endif;

			wp_die();
		}


		// ------------ ACTIONS ------------ //

		public function scheduled_ajax_login(){
			
			Scheduled_AJAX::nonce_check( 'ajax-nonce' );

			scheduled_wpml_ajax();

			if (isset($_POST['security']) && isset($_POST['username']) && isset($_POST['password'])):

				$nonce_check = wp_verify_nonce( $_POST['security'], 'ajax_login_nonce' );

				if ($nonce_check){

					if (is_email($_POST['username'])) {
				        $user = get_user_by('email', $_POST['username']);
				    } else {
						$user = get_user_by('login', $_POST['username']);
				    }

				    $creds = array();

				    if ($user && wp_check_password( $_POST['password'], $user->data->user_pass, $user->ID)) {
				        $creds = array('user_login' => $user->data->user_login, 'user_password' => $_POST['password']);
				        $creds['remember'] = true;
				    }

					$user = wp_signon( $creds, false );

					if ( !is_wp_error($user) ):
						echo 'success';
					endif;

				}

			endif;

			wp_die();

		}

		public function scheduled_ajax_forgot(){
			
			Scheduled_AJAX::nonce_check( 'ajax-nonce' );

			scheduled_wpml_ajax();

			global $wpdb, $wp_hasher;

			if (isset($_POST['security']) && isset($_POST['username'])):

				$nonce_check = wp_verify_nonce( $_POST['security'], 'ajax_forgot_nonce' );

				if ($nonce_check){

					$password_reset = scheduled_reset_password( $_POST['username'] );

					if ( $password_reset ):
						echo 'success';
					endif;

				}

			endif;

			wp_die();

		}

		public function scheduled_add_appt(){
			
			Scheduled_AJAX::nonce_check( 'ajax-nonce' );

			scheduled_wpml_ajax();

			$can_add_appt = apply_filters(
				'scheduled_can_add_appt',
				isset($_POST['date']) && isset($_POST['timestamp']) && isset($_POST['timeslot']) && isset($_POST['customer_type'])
			);

			if ( $can_add_appt ):

				include(SCHEDULED_AJAX_INCLUDES_DIR . 'front/book-appointment.php');

			endif;

			wp_die();

		}

		public function scheduled_cancel_appt(){
			
			Scheduled_AJAX::nonce_check( 'ajax-nonce' );

			scheduled_wpml_ajax();

			if (is_user_logged_in() && isset($_POST['appt_id'])):

				include(SCHEDULED_AJAX_INCLUDES_DIR . 'front/cancel-appointment.php');

			endif;

			wp_die();

		}



	}
}
