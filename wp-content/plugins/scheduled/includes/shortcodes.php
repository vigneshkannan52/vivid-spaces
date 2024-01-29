<?php

if (!shortcode_exists('scheduled-calendar')) {
	add_shortcode('scheduled-calendar', 'scheduled_calendar_shortcode');
}


/* CALENDAR SWITCHER SHORTCODE */
class ScheduledShortcodes {

	function __construct(){

		// Shortcodes
		add_shortcode('scheduled-calendar-switcher', array($this, 'scheduled_calendar_switcher_shortcode') );
		add_shortcode('scheduled-calendar', array($this, 'scheduled_calendar_shortcode') );
		add_shortcode('scheduled-appointments', array($this, 'scheduled_appts_shortcode') );
		add_shortcode('scheduled-profile', array($this, 'scheduled_profile_template') );
		add_shortcode('scheduled-login', array($this, 'scheduled_login_form') );

		// Shortcode Actions
		add_action('template_redirect', array($this, 'scheduled_registration_redirect') );

	}

	public function scheduled_registration_redirect(){

		$name_requirements = get_option('scheduled_registration_name_requirements',array('require_name'));
		$name_requirements = ( isset($name_requirements[0]) ? $name_requirements[0] : false );

		if ( get_option('users_can_register') && !is_user_logged_in() && isset($_POST['scheduled_reg_submit'] ) ) {

			global $registration_complete, $scheduled_reg_errors, $name, $display_name, $surname, $email, $password;

			if ( $name_requirements == 'require_surname' && isset($_POST['scheduled_reg_surname']) && !$_POST['scheduled_reg_surname'] ):

				$registration_complete = 'error';
				$scheduled_reg_errors[] = esc_html__('A first and last name are required to register.','scheduled');

			elseif ( !isset($_POST['scheduled_reg_name']) || isset($_POST['scheduled_reg_name']) && !$_POST['scheduled_reg_name'] ):

				$registration_complete = 'error';
				$scheduled_reg_errors[] = esc_html__('A name is required to register.','scheduled');

			else:

				$name 			= isset($_POST['scheduled_reg_name']) ? esc_attr($_POST['scheduled_reg_name']) : false;
				$surname 		= isset($_POST['scheduled_reg_surname']) ? esc_attr($_POST['scheduled_reg_surname']) : false;
				$display_name 	= $name . ( $surname ? ' ' . $surname : '' );
				$combined_name	= $name . ( $surname ? '_' . $surname : '' );
		        $password 		= isset($_POST['scheduled_reg_password']) ? $_POST['scheduled_reg_password'] : false;
		        $email      	= isset($_POST['scheduled_reg_email']) ? sanitize_email(esc_html($_POST['scheduled_reg_email'])) : '';

		        if (isset($_POST['captcha_word'])):
		        	$captcha_word = strtolower($_POST['captcha_word']);
					$captcha_code = strtolower($_POST['captcha_code']);
		        else :
		        	$captcha_word = false;
					$captcha_code = false;
		        endif;

				$scheduled_reg_errors = scheduled_registration_validation($email,$password,$captcha_word,$captcha_code);

				if (empty($scheduled_reg_errors)):
		        	$registration_complete = scheduled_complete_registration();
		        else :
		        	$registration_complete = 'error';
		        endif;

			endif;

	    } else {

		    $registration_complete = false;

	    }

	    if ($registration_complete && $registration_complete != 'error'){

		    $user = get_user_by('email', $email);
		    $creds = array();

		    if ($user && wp_check_password( $password, $user->data->user_pass, $user->ID)) {
		        $creds = array('user_login' => $user->data->user_login, 'user_password' => $password);
		        $creds['remember'] = true;
		    }

		    $user = wp_signon( $creds, false );

			$page_id = get_queried_object_id();
			wp_redirect(get_the_permalink($page_id));
			exit;

	    }

	}

	public function scheduled_profile_template(){
		if (!is_user_logged_in()) {
			return do_shortcode('[scheduled-login]');
		} else {
			ob_start();
			require(SCHEDULED_PLUGIN_TEMPLATES_DIR . 'profile.php');
			return ob_get_clean();
		}
	}

	/* CALENDAR SWITCHER SHORTCODE */
    public function scheduled_calendar_switcher_shortcode( $attrs ){

		if( $attrs ){
			extract( $attrs );
		}

		$rand = rand(0000000,9999999);

		$args = array(
			'taxonomy'		=> 'scheduled_custom_calendars',
			'hide_empty'	=> 0,
			'echo'			=> 0,
			'class'			=> 'scheduled_calendar_chooser',
			'id'			=> 'scheduled_calendar_chooser_'.$rand,
			'name'			=> 'scheduled_calendar_chooser_'.$rand
		);

		if( isset($id) ){
			$args['include'] = wp_parse_id_list( $id );
			$args['orderby'] = 'include';
		}

		if (!get_option('scheduled_hide_default_calendar')): $args['show_option_all'] = esc_html__('Default Calendar','scheduled'); endif;

		return str_replace( "\n", '', wp_dropdown_categories( $args ) );

	}

	/* CALENDAR SHORTCODE */
	public function scheduled_calendar_shortcode($atts, $content = null){

		$local_time = current_time('timestamp');
		$calendars = get_terms('scheduled_custom_calendars',array('orderby'=>'name','order'=>'ASC','hide_empty'=>false));

		$atts = shortcode_atts(
			array(
				'size' => 'large',
				'calendar' => false,
				'year' => false,
				'month' => false,
				'day' => false,
				'switcher' => false,
				'style' => 'calendar',
				'members-only' => false
			), $atts );

		if ($atts['members-only'] && is_user_logged_in() || !$atts['members-only']):

			ob_start();

			$atts = apply_filters('scheduled_calendar_shortcode_atts', $atts );
			$rand = rand(0000000,9999999);

			echo '<div class="scheduled-calendar-shortcode-wrap">';

				if ($atts['switcher']):
					$args = array(
						'taxonomy'		=> 'scheduled_custom_calendars',
						'hide_empty'	=> 0,
						'echo'			=> 0,
						'id'			=> 'scheduled_calendar_chooser_'.$rand,
						'name'			=> 'scheduled_calendar_chooser_'.$rand,
						'class'			=> 'scheduled_calendar_chooser',
						'selected'		=> $atts['calendar'],
						'orderby'		=> 'name',
						'order'			=> 'ASC'
					);
					if (!get_option('scheduled_hide_default_calendar')): $args['show_option_all'] = esc_html__('Default Calendar','scheduled'); endif;
					echo '<div class="scheduled-calendarSwitcher '.$atts['style'].'"><p><i class="fa-solid fa-calendar-days"></i>' . str_replace( "\n", '', wp_dropdown_categories( $args ) ) . '</p></div>';
				endif;

				if (get_option('scheduled_hide_default_calendar') && $atts['switcher'] && !$atts['calendar'] && !empty($calendars)):
					$atts['calendar'] = $calendars[0]->term_id;
				endif;

				if ($atts['year'] || $atts['month'] || $atts['day']):
					$force_calendar = true;
					$year = ($atts['year'] ? $atts['year'] : date_i18n('Y',$local_time));
					$month = ($atts['month'] ? date_i18n('m',strtotime($year.'-'.$atts['month'].'-01')) : date_i18n('m',$local_time));
					$day = ($atts['day'] ? date_i18n('d',strtotime($year.'-'.$month.'-'.$atts['day'])) : date_i18n('d',$local_time));
					$default_date = $year.'-'.$month.'-'.$day;
				else:
					$default_date = date_i18n('Y-m-d',$local_time);
					$force_calendar = false;
				endif;

				if (!$atts['style'] || $atts['style'] != 'list'):
					echo '<div class="scheduled-calendar-wrap '.$atts['size'].'"'.($force_calendar ? ' data-default="'.$default_date.'"' : '').'>';
						scheduled_fe_calendar($atts['year'],$atts['month'],$atts['calendar'],$force_calendar);
					echo '</div>';
				elseif ($atts['style'] == 'list'):
					echo '<div class="scheduled-list-view scheduled-calendar-wrap '.$atts['size'].'"'.($force_calendar ? ' data-default="'.$default_date.'"' : '').'>';
						scheduled_fe_appointment_list_content($default_date,$atts['calendar'],$force_calendar);
					echo '</div>';
				endif;

			echo '</div>';

			wp_reset_postdata();

			return ob_get_clean();

		else:

			return false;

		endif;

	}

	/* APPOINTMENTS SHORTCODE */
	public function scheduled_appts_shortcode($atts = null, $content = null) {

		ob_start();

		if ( is_user_logged_in() ):

			$scheduled_current_user = wp_get_current_user();
			$my_id = $scheduled_current_user->ID;

			$historic = isset($atts['historic']) && $atts['historic'] ? true : false;

			$time_format = get_option('time_format');
			$date_format = get_option('date_format');
			$appointments_array = scheduled_user_appointments($my_id,false,$time_format,$date_format,$historic);
			$total_appts = count($appointments_array);
			$appointment_default_status = get_option('scheduled_new_appointment_default','draft');
			$only_titles = get_option('scheduled_show_only_titles',false);

			if (!isset($atts['remove_wrapper'])): echo '<div id="scheduled-profile-page" class="scheduled-shortcode">'; endif;

				echo '<div class="scheduled-profile-appt-list">';

					if ($historic):
						if ($total_appts):
							echo '<h4><span class="count">' . number_format($total_appts) . '</span> ' . _n('Past Appointment','Past Appointments',$total_appts,'scheduled') . '</h4>';
						else:
							echo '<p class="scheduled-no-margin">'.esc_html__('No past appointments.','scheduled').'</p>';
						endif;
					else:
						if ($total_appts):
							echo '<h4><span class="count">' . number_format($total_appts) . '</span> ' . _n('Upcoming Appointment','Upcoming Appointments',$total_appts,'scheduled') . '</h4>';
						else:
							echo '<p class="scheduled-no-margin">'.esc_html__('No upcoming appointments.','scheduled').'</p>';
						endif;
					endif;

					foreach($appointments_array as $appt):

						$today = date_i18n($date_format);
						$date_display = date_i18n($date_format,$appt['timestamp']);
						if ($date_display == $today){
							$date_display = esc_html__('Today','scheduled');
							$day_name = '';
						} else {
							$day_name = date_i18n('l',$appt['timestamp']).', ';
						}

						$date_to_convert = date_i18n('Y-m-d',$appt['timestamp']);

						$cf_meta_value = get_post_meta($appt['post_id'], '_cf_meta_value',true);

						$timeslots = explode('-',$appt['timeslot']);
						$time_start = date_i18n($time_format,strtotime($timeslots[0]));
						$time_end = date_i18n($time_format,strtotime($timeslots[1]));

						$appt_date_time = strtotime($date_to_convert.' '.date_i18n('H:i:s',strtotime($timeslots[0])));

						$atc_date_startend = date_i18n('Y-m-d',$appt['timestamp']);
						$atc_time_start = date_i18n('H:i:s',strtotime($timeslots[0]));
						$atc_time_end = date_i18n('H:i:s',strtotime($timeslots[1]));

						$current_timestamp = current_time('timestamp');
						$cancellation_buffer = get_option('scheduled_cancellation_buffer',0);

						if ($cancellation_buffer):
							if ($cancellation_buffer < 1){
								$time_type = 'minutes';
								$time_count = $cancellation_buffer * 60;
							} else {
								$time_type = 'hours';
								$time_count = $cancellation_buffer;
							}
							$buffered_timestamp = strtotime('+'.$time_count.' '.$time_type,$current_timestamp);
							$date_to_compare = $buffered_timestamp;
						else:
							$date_to_compare = current_time('timestamp');
						endif;

						$timeslotText = '';
						$status = ($appt['status'] != 'publish' && $appt['status'] != 'future' ? esc_html__('pending','scheduled') : esc_html__('approved','scheduled'));
						$status_class = $appt['status'] != 'publish' && $appt['status'] != 'future' ? 'pending' : 'approved';
						$ts_title = get_post_meta($appt['post_id'], '_appointment_title',true);

						if ($timeslots[0] == '0000' && $timeslots[1] == '2400'):
							if ($only_titles && !$ts_title || !$only_titles):
								$timeslotText = esc_html__('All day','scheduled');
							endif;
							$atc_date_startend_end = date_i18n('Y-m-d',strtotime(date_i18n('Y-m-d',$appt['timestamp']) . '+ 1 Day'));
							$atc_time_end = '00:00:00';
						else :
							if ($only_titles && !$ts_title || !$only_titles):
								$timeslotText = (!get_option('scheduled_hide_end_times') ? esc_html__('from','scheduled').' ' : esc_html__('at','scheduled').' ') . $time_start . (!get_option('scheduled_hide_end_times') ? ' &ndash; '.$time_end : '');
							endif;
							$atc_date_startend_end = $atc_date_startend;
						endif;

						echo '<span class="appt-block scheduledClearFix '.(!$historic ? $status_class : 'approved').'" data-appt-id="'.$appt['post_id'].'">';
							if (!$historic):
								if ($appointment_default_status !== 'publish' && $appt['status'] !== 'future' || $appointment_default_status == 'publish' && $status_class == 'pending'):
									echo '<span class="status-block">'.($status_class == 'pending' ? '<i class="fa-solid fa-circle"></i>' : '<i class="fa-solid fa-circle-dot"></i>').'&nbsp;&nbsp;'.$status.'</span>';
								endif;
							endif;
							echo (!empty($appt['calendar_id']) ? '<i class="fa-solid fa-calendar-days"></i><strong>'.esc_html__('Calendar','scheduled').':</strong> '.$appt['calendar_id'][0]->name.'<br>' : '');

							echo '<i class="fa-solid fa-clock"></i>'.($ts_title ? '<strong>'.$ts_title.':</strong>&nbsp;&nbsp;' : '').$day_name.$date_display.'&nbsp;&nbsp;' . $timeslotText;

							do_action('scheduled_shortcode_appointments_additional_information', $appt['post_id']);

							echo ($cf_meta_value ? '<br><i class="fa-solid fa-circle-info"></i><a href="#" class="scheduled-show-cf">'.esc_html__('Additional information','scheduled').'</a><div class="cf-meta-values-hidden">'.$cf_meta_value.'</div>' : '');

							if (!$historic):

								$calendar_button_array = array(
									'atc_date_startend' => $atc_date_startend,
									'atc_time_start' => $atc_time_start,
									'atc_date_startend_end' => $atc_date_startend_end,
									'atc_time_end' => $atc_time_end,
								);

								ob_start();
								scheduled_add_to_calendar_button($calendar_button_array,$cf_meta_value);
								if ( apply_filters('scheduled_shortcode_appointments_allow_cancel', true, $appt['post_id']) && !get_option('scheduled_dont_allow_user_cancellations',false) ) { if ( $appt_date_time >= $date_to_compare ) { echo '<a href="#" data-appt-id="'.$appt['post_id'].'" class="cancel">'.esc_html__('Cancel Appointment','scheduled').'</a>'; } }
								do_action('scheduled_shortcode_appointments_buttons', $appt['post_id']);
								$buttons_content = ob_get_clean();

								if ($buttons_content):
									echo '<div class="scheduled-cal-buttons">';
										echo $buttons_content;
									echo '</div>';
								endif;

							endif;

						echo '</span>';

					endforeach;

				echo '</div>';


			if (!isset($atts['remove_wrapper'])): echo '</div>'; endif;

			wp_reset_postdata();

		else :

			return '<p>'.esc_html__('Please log in to view your upcoming appointments.','scheduled').'</p>';

		endif;

		return ob_get_clean();

	}

	/* LOGIN SHORTCODE */
	public function scheduled_login_form( $atts, $content = null ) {

		global $post;

		if (!is_user_logged_in()) {

			ob_start();

			?><div id="scheduled-profile-page">

				<div id="scheduled-page-form">

					<ul class="scheduled-tabs login scheduledClearFix">
						<li<?php if ( !isset($_POST['scheduled_reg_submit'] ) ) { ?> class="active"<?php } ?>><a href="#login"><i class="fa-solid fa-lock"></i><?php esc_html_e('Sign In','scheduled'); ?></a></li>
						<?php if ( get_option('users_can_register') ): ?><li<?php if ( isset($_POST['scheduled_reg_submit'] ) ) { ?> class="active"<?php } ?>><a href="#register"><i class="fa-solid fa-pencil"></i><?php esc_html_e('Register','scheduled'); ?></a></li><?php endif; ?>
						<li><a href="#forgot"><i class="fa-solid fa-circle-question"></i><?php esc_html_e('Forgot Password','scheduled'); ?></a></li>
					</ul>

					<div id="profile-login" class="scheduled-tab-content">

						<?php if (isset($reset) && $reset == true) { ?>

							<p class="scheduled-form-notice">
							<strong><?php esc_html_e('Success!','scheduled'); ?></strong><br />
							<?php esc_html_e('Check your email to reset your password.','scheduled'); ?>
							</p>

						<?php } ?>

						<?php $login_redirect = get_option('scheduled_login_redirect_page') ? get_option('scheduled_login_redirect_page') : $post->ID; ?>

						<div class="scheduled-form-wrap scheduledClearFix">
							<div class="scheduled-custom-error"><?php esc_html_e('Both fields are required to log in.','scheduled'); ?></div>
							<?php if (isset($_GET['loginfailed'])): ?><div class="scheduled-custom-error not-hidden"><?php esc_html_e('Sorry, those login credentials are incorrect.','scheduled'); ?></div><?php endif; ?>

							<?php $custom_login_form_message = get_option('scheduled_custom_login_message',false);
							if ($custom_login_form_message):
								echo do_shortcode(wpautop($custom_login_form_message));
							endif;

							add_filter( 'login_form_top', 'scheduled_hidden_login_field' );
							echo wp_login_form( array( 'echo' => false, 'redirect' => get_the_permalink($login_redirect), 'label_username' => esc_html__( 'Email Address','scheduled' ) ) );
							remove_filter( 'login_form_top', 'scheduled_hidden_login_field' );

							?>

						</div>
					</div>

					<?php if (get_option('users_can_register')): ?>

					<div id="profile-register" class="scheduled-tab-content">
						<div class="scheduled-form-wrap scheduledClearFix">

							<?php global $registration_complete,$scheduled_reg_errors;

							if ($registration_complete == 'error'){
						    	?><div class="scheduled-custom-error" style="display:block"><?php echo implode('<br>', $scheduled_reg_errors); ?></div><?php
					    	}

							$name = (isset($_POST['scheduled_reg_name']) ? $_POST['scheduled_reg_name'] : '');
							$surname = (isset($_POST['scheduled_reg_surname']) ? $_POST['scheduled_reg_surname'] : '');
							$email = (isset($_POST['scheduled_reg_email']) ? $_POST['scheduled_reg_email'] : '');
							$password = (isset($_POST['scheduled_reg_password']) ? $_POST['scheduled_reg_password'] : '');

							scheduled_registration_form($name,$surname,$email,$password);

							?>

						</div>
					</div>

					<?php endif; ?>

					<div id="profile-forgot" class="scheduled-tab-content">
						<div class="scheduled-form-wrap scheduledClearFix">
							<div class="scheduled-custom-error"><?php esc_html_e('An email address is required to reset your password.','scheduled'); ?></div>
							<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="wp-user-form">
								<p class="username">
									<label for="user_login"><?php esc_html_e('What is your email address?','scheduled'); ?></label>
									<input type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
								</p>

								<?php do_action('login_form', 'resetpass'); ?>
								<input type="submit" name="user-submit" value="<?php esc_html_e('Reset my password','scheduled'); ?>" class="user-submit button-primary" tabindex="1002" />
								<input type="hidden" name="redirect_to" value="<?php the_permalink(); ?>?reset=true" />
								<input type="hidden" name="user-cookie" value="1" />

							</form>
						</div>
					</div>
				</div><!-- END #scheduled-page-form -->

			</div><?php

			$content = ob_get_clean();
		}

		return $content;

	}

}

new ScheduledShortcodes;
