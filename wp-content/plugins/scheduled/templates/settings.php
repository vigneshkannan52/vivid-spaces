<div class="scheduled-settings-prewrap">
	<div class="wrap scheduled-settings-wrap"><?php

	if (get_transient('scheduled_show_new_tags',false)):
		$show_new_tags = true;
	else:
		$show_new_tags = false;
	endif;

	$calendars = get_terms('scheduled_custom_calendars','orderby=slug&hide_empty=0');
	$scheduled_none_assigned = true;
	$default_calendar_id = false;

	if (!empty($calendars)):

		if (!current_user_can('manage_scheduled_options')):

			$scheduled_current_user = wp_get_current_user();
			$calendars = scheduled_filter_agent_calendars($scheduled_current_user,$calendars);

			if (empty($calendars)):
				$scheduled_none_assigned = true;
			else:
				$first_calendar = array_slice($calendars, 0, 1);
				$default_calendar_id = array_shift($first_calendar)->term_id;
				$scheduled_none_assigned = false;
			endif;

		else:
			$scheduled_none_assigned = false;
		endif;

	endif;

	if (!current_user_can('manage_scheduled_options') && $scheduled_none_assigned):

		echo '<div style="text-align:center;">';
			echo '<br><br><h3>'.esc_html__('There are no calendars assigned to you.','scheduled').'</h3>';
			echo '<p>'.esc_html__('Get in touch with the Administration of this site to get a calendar assigned to you.','scheduled').'</p>';
		echo '</div>';

	else: ?>

		<div class="topSavingState savingState"><i class="fa-solid fa-circle-notch fa-spin"></i>&nbsp;&nbsp;<?php esc_html_e('Updating, please wait...','scheduled'); ?></div>

		<div class="scheduled-settings-title"><?php echo esc_html__('Scheduled Settings','scheduled'); ?></div>

		<div id="scheduled-admin-panel-container">

			<?php $scheduled_settings_tabs = [];
			
			$scheduled_settings_tabs[] = [
				'access' => 'admin',
				'slug' => 'general',
				'content' => '<i class="fa-solid fa-gear"></i><span class="scheduled-tab-text">&nbsp;&nbsp;'.esc_html__('General','scheduled') . '</span>'
			];
			
			$scheduled_settings_tabs[] = [
				'access' => 'agent',
				'slug' => 'defaults',
				'content' => '<i class="fa-solid fa-clock"></i><span class="scheduled-tab-text">&nbsp;&nbsp;'.esc_html__('Time Slots','scheduled') . '</span><span class="savingState">&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-circle-notch fa-spin"></i></span>'
			];
			
			$scheduled_settings_tabs[] = [
				'access' => 'agent',
				'slug' => 'custom-timeslots',
				'content' => '<i class="fa-solid fa-clock"></i><span class="scheduled-tab-text">&nbsp;&nbsp;'.esc_html__('Custom Time Slots','scheduled') . '</span><span class="savingState">&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-circle-notch fa-spin"></i></span>'
			];
			
			$scheduled_settings_tabs[] = [
				'access' => 'agent',
				'slug' => 'custom-fields',
				'content' => '<i class="fa-solid fa-pencil"></i><span class="scheduled-tab-text">&nbsp;&nbsp;'.esc_html__('Custom Fields','scheduled') . '</span>'
			];
			
			$scheduled_settings_tabs[] = [
				'access' => 'admin',
				'slug' => 'email-settings',
				'content' => '<i class="fa-solid fa-envelope"></i><span class="scheduled-tab-text">&nbsp;&nbsp;'.esc_html__('Emails','scheduled') . '</span>'
			];
			
			if ( class_exists('woocommerce') ):
			
				$scheduled_settings_tabs[] = [
					'access' => 'admin',
					'slug' => 'woocommerce-settings',
					'content' => '<i class="fa-solid fa-cart-shopping"></i><span class="scheduled-tab-text">&nbsp;&nbsp;'.esc_html__('WooCommerce','scheduled') . '</span>'
				];
				
			endif;
			
			$scheduled_settings_tabs[] = [
				'access' => 'admin',
				'slug' => 'calendar-feeds',
				'content' => '<i class="fa-solid fa-calendar-days"></i><span class="scheduled-tab-text">&nbsp;&nbsp;'.esc_html__('Calendar Feeds','scheduled') . '</span>'
			];
			
			$scheduled_settings_tabs[] = [
				'access' => 'admin',
				'slug' => 'export-appointments',
				'content' => '<i class="fa-solid fa-arrow-up-right-from-square"></i><span class="scheduled-tab-text">&nbsp;&nbsp;'.esc_html__('Export','scheduled') . '</span>'
			];
			
			$scheduled_settings_tabs[] = [
				'access' => 'admin',
				'slug' => 'shortcodes',
				'content' => '<i class="fa-solid fa-code"></i><span class="scheduled-tab-text">&nbsp;&nbsp;'.esc_html__('Shortcodes','scheduled') . '</span>'
			];
			
			$scheduled_settings_tabs = apply_filters( 'scheduled_settings_tabs', $scheduled_settings_tabs );

			$tab_counter = 1;

			$new_items_in_tabs = array();

			foreach($scheduled_settings_tabs as $tab_data):
				if ($tab_data['access'] == 'admin' && current_user_can('manage_scheduled_options') || $tab_data['access'] == 'agent'):
					if ($tab_counter == 1): ?><ul class="scheduled-admin-tabs scheduledClearFix">
					<?php endif;
					?><li<?php if ($tab_counter == 1): ?> class="active"<?php endif; ?>><a href="#<?php echo $tab_data['slug']; ?>"><?php echo $tab_data['content']; ?><?php if (in_array($tab_data['slug'],$new_items_in_tabs)): scheduled_new_tag($show_new_tags); endif; ?></a></li><?php
					$tab_counter++;
				endif;
			endforeach;

			?></ul>

			<div class="form-wrapper">
				
				<?php foreach($scheduled_settings_tabs as $tab_data):

					if ($tab_data['access'] == 'admin' && current_user_can('manage_scheduled_options') || $tab_data['access'] == 'agent'):

						switch ($tab_data['slug']):

							case 'general': ?>

								<form action="options.php" class="scheduled-settings-form" method="post">

									<?php settings_fields('scheduled_plugin-group'); ?>

									<div id="scheduled-general" class="tab-content">

										<h1 style="display:none;"></h1>

										<?php settings_errors(); ?>

										<div class="section-row">
											<div class="section-head">
												<?php $section_title = esc_html__('Booking Type', 'scheduled'); ?>
												<h3><?php echo esc_attr($section_title); ?></h3>
												<p><?php esc_html_e('You have the option to choose between "Registered" and "Guest" booking. Registered booking will require all appointments to be scheduled by a registered user (default). Guest booking will allow anyone with a name and email address to book an appointment.','scheduled'); ?></p>

												<?php $option_name = 'scheduled_booking_type';
												$booking_type = get_option($option_name,'registered'); ?>
												<div class="select-box">
													<select data-condition="booking_type" name="<?php echo $option_name; ?>">
														<option value="registered"<?php echo ($booking_type == 'registered' ? ' selected="selected"' : ''); ?>><?php esc_html_e('Registered Booking','scheduled'); ?></option>
														<option value="guest"<?php echo ($booking_type == 'guest' ? ' selected="selected"' : ''); ?>><?php esc_html_e('Guest Booking','scheduled'); ?></option>
													</select>
												</div><!-- /.select-box -->
											</div><!-- /.section-body -->
										</div><!-- /.section-row -->

										<?php $selected_value = get_option('scheduled_registration_name_requirements',array('scheduled_require_name')); $selected_value = (isset($selected_value[0]) ? $selected_value[0] : false); ?>
										<div class="section-row">
											<div class="section-head">

											<?php $section_title = esc_html__('Booking Options', 'scheduled'); ?>
											<h3><?php echo esc_attr($section_title); ?></h3>

											<p style="margin:1.2em 0 10px;">
												<input style="margin:-5px 5px 0 0;" id="scheduled_require_name" name="scheduled_registration_name_requirements[]" value="require_name"<?php if (!$selected_value || $selected_value == 'require_name'): echo ' checked="checked"'; endif; ?> type="radio">
												<label class="checkbox-radio-label" for="scheduled_require_name"><strong><?php esc_html_e('Require "Name" only','scheduled'); ?></strong> &mdash; <?php esc_html_e('Require your customers to enter their name in a single text field.','scheduled'); ?></label><br>
											</p>
											<p style="margin:0 0 10px;">
												<input style="margin:-5px 5px 0 0;" id="scheduled_require_surname" name="scheduled_registration_name_requirements[]" value="require_surname"<?php if ($selected_value == 'require_surname'): echo ' checked="checked"'; endif; ?> type="radio">
												<label class="checkbox-radio-label" for="scheduled_require_surname"><strong><?php esc_html_e('Require "First Name" and "Last Name"','scheduled'); ?></strong> &mdash; <?php esc_html_e('Require your customers to enter their first and last name in two text fields.','scheduled'); ?></label><br>
											</p>

											</div>
										</div>

										<?php $selected_value = get_option('scheduled_require_guest_email_address',false); ?>
										<div class="condition-block booking_type" data-condition-val="guest" style="<?php if ($booking_type == 'guest'): ?>display:block; <?php endif; ?>">
											<div class="section-row">
												<div class="section-head">

												<?php $section_title = esc_html__('Guest Booking Options', 'scheduled'); ?>
												<h3><?php echo esc_attr($section_title); ?></h3>

												<p style="margin:1.2em 0 10px;">
													<input style="margin:-4px 5px 0 0;" id="scheduled_require_guest_email_address" name="scheduled_require_guest_email_address" value="true"<?php if ($selected_value): echo ' checked="checked"'; endif; ?> type="checkbox">
													<label class="checkbox-radio-label" for="scheduled_require_guest_email_address"><strong><?php esc_html_e('Require Email Address','scheduled'); ?></strong> &mdash; <?php esc_html_e('Require your guests to enter their email address.','scheduled'); ?></label>
												</p>

												</div>
											</div>
										</div>

										<div class="section-row">
											<div class="section-head">
												<?php $section_title = esc_html__('Appointment Booking Redirect', 'scheduled'); ?>
												<h3><?php echo esc_attr($section_title); ?></h3>

												<?php $option_name = 'scheduled_appointment_redirect_type'; $selected_value = get_option($option_name,false);

												$scheduled_redirect_type = $selected_value;

												$detected_page_error = false;
												$detected_page = scheduled_get_profile_page();
												if (!$detected_page):
													$detected_page_error = true;
												endif; ?>

												<p style="margin:1.2em 0 10px;"><input style="margin:-4px 5px 0 0;" data-condition="redirect_type" id="redirect_type_none" name="<?php echo $option_name; ?>" value=""<?php if (!$selected_value): echo ' checked="checked"'; endif; ?> type="radio">
												<label class="checkbox-radio-label" for="redirect_type_none"><?php echo sprintf( esc_html__('%s Refresh the calendar list after booking.','scheduled'), '<strong>' . esc_html__('No Redirect','scheduled') . '</strong> &mdash; ' ); ?></label></p>

												<div class="condition-block booking_type" data-condition-val="registered" style="<?php if ($booking_type == 'registered'): ?>display:block; <?php endif; ?>">
													<p style="margin:0 0 10px;">
														<input style="margin:-4px 5px 0 0;" data-condition="redirect_type" id="redirect_type_detect" name="<?php echo $option_name; ?>" value="scheduled-profile"<?php if ($selected_value == 'scheduled-profile'): echo ' checked="checked"'; endif; ?> type="radio">
														<label class="checkbox-radio-label" for="redirect_type_detect"><?php echo sprintf( esc_html__('%s Auto-detect the page with the [scheduled-profile] shortcode.','scheduled'), '<strong>' . esc_html__('Auto-Detect Profile Page','scheduled') . '</strong> &mdash; ' ); ?><?php if (!$detected_page_error && $detected_page): ?>&nbsp;&nbsp;&mdash;&nbsp;&nbsp;<strong><?php echo sprintf(esc_html__('Detected Page: %s','scheduled'),'<a href="'.get_permalink($detected_page).'">'.get_permalink($detected_page).'</a>'); ?></strong><?php endif; ?></label>
													</p>
												</div>

												<?php if ($detected_page_error): ?>
												<div style="margin:0 0 10px;">
													<div class="condition-block redirect_type" data-condition-val="scheduled-profile" style="<?php if ($scheduled_redirect_type == 'scheduled-profile'): ?>display:block; <?php endif; ?>line-height:30px; padding:0 0 0 30px; margin:-5px 0 10px;"><?php echo sprintf(esc_html__( '%s We were not able to auto-detect. You need to %s with the %s shortcode.','scheduled' ),'<strong style="color:#DB5933;">'.esc_html__('Important:','scheduled').'</strong>','<strong><a href="'.get_admin_url().'post-new.php?post_type=page">'.esc_html__('create a page','scheduled').'</a></strong>','<code>[scheduled-profile]</code>'); ?></div>
												</div>
												<?php endif; ?>

												<p style="margin:0;">
													<input style="margin:-4px 5px 0 0;" data-condition="redirect_type" id="redirect_type_page" name="<?php echo $option_name; ?>" value="page"<?php if ($selected_value == 'page'): echo ' checked="checked"'; endif; ?> type="radio">
													<label class="checkbox-radio-label" for="redirect_type_page"><?php echo sprintf( esc_html__('%s Choose a redirect page.','scheduled'), '<strong>' . esc_html__('Choose Specific Page','scheduled') . '</strong> &mdash; ' ); ?></label>
												</p>

												<?php $option_name = 'scheduled_appointment_success_redirect_page';

												$pages = get_posts(array(
													'post_type' => 'page',
													'orderby'	=> 'name',
													'order'		=> 'asc',
													'posts_per_page' => 500
												));

												$selected_value = get_option($option_name); ?>
												<div style="padding:15px 0 0 0;" class="condition-block redirect_type select-box<?php if ($scheduled_redirect_type == 'page'): ?> default<?php endif; ?>" data-condition-val="page">
													<select name="<?php echo $option_name; ?>">
														<option value=""<?php echo (!$selected_value ? ' selected="selected"' : ''); ?>><?php echo esc_html__('Choose a page','scheduled').'...'; ?></option>
														<?php if(!empty($pages)) :

															foreach($pages as $p) :
																$entry_id = $p->ID;
																$entry_title = get_the_title($entry_id); ?>
																<option value="<?php echo $entry_id; ?>"<?php echo ($selected_value == $entry_id ? ' selected="selected"' : ''); ?>><?php echo $entry_title; ?></option>
															<?php endforeach;

														endif; ?>
													</select>
												</div><!-- /.select-box -->
											</div><!-- /.section-body -->
										</div><!-- /.section-row -->

										<div class="condition-block booking_type<?php if ($booking_type == 'registered'): ?> default<?php endif; ?>" data-condition-val="registered">

											<div class="section-row">
												<div class="section-head">
													<?php $section_title = esc_html__('Login Redirect', 'scheduled'); ?>
													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('If you would like the login form to redirect somewhere else (instead of reloading the same page), you can choose a page here.','scheduled'); ?></p>

													<?php $option_name = 'scheduled_login_redirect_page';

													$pages = get_posts(array(
														'post_type' => 'page',
														'orderby'	=> 'name',
														'order'		=> 'asc',
														'posts_per_page' => 500
													));

													$selected_value = get_option($option_name); ?>
													<div class="select-box">
														<select name="<?php echo $option_name; ?>">
															<option value=""><?php esc_html_e('Redirect to the same page','scheduled'); ?></option>
															<?php if(!empty($pages)) :
																foreach($pages as $p) :
																	$entry_id = $p->ID;
																	$entry_title = get_the_title($entry_id); ?>
																	<option value="<?php echo $entry_id; ?>"<?php echo ($selected_value == $entry_id ? ' selected="selected"' : ''); ?>><?php echo $entry_title; ?></option>
																<?php endforeach;

															endif; ?>
														</select>
													</div><!-- /.select-box -->
												</div><!-- /.section-body -->
											</div><!-- /.section-row -->

											<div class="section-row">
												<div class="section-head">
													<?php $section_title = esc_html__('Custom Login Tab Content', 'scheduled'); ?>
													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('If you would like the login form to include a custom message (above the login form), you can add that here.','scheduled'); ?></p>

													<?php $option_name = 'scheduled_custom_login_message';
													$custom_content_value = get_option($option_name);

													wp_editor( $custom_content_value, $option_name, array('textarea_name' => $option_name,'media_buttons' => false,'editor_height' => 250,'teeny' => true) );

													?>
												</div><!-- /.section-body -->
											</div><!-- /.section-row -->

										</div>

										<div class="section-row">
											<div class="section-head">
												<?php $section_title = esc_html__('Time Slot Intervals', 'scheduled'); ?>
												<h3><?php echo esc_attr($section_title); ?></h3>
												<p><?php esc_html_e('Choose the intervals you need for your appointment time slots. This will only affect the way default time slots are entered.','scheduled'); ?></p>

												<?php $option_name = 'scheduled_timeslot_intervals';
												$selected_value = get_option( $option_name, 5 );

												$interval_options = apply_filters( 'scheduled_timeslot_interval_sizes', array(
													'120'	=> esc_html__('Every 2 hours','scheduled'),
													'60' 	=> esc_html__('Every 1 hour','scheduled'),
													'30' 	=> esc_html__('Every 30 minutes','scheduled'),
													'15' 	=> esc_html__('Every 15 minutes','scheduled'),
													'10' 	=> esc_html__('Every 10 minutes','scheduled'),
													'5' 	=> esc_html__('Every 5 minutes','scheduled'),
												) ); ?>

												<div class="select-box">
													<select name="<?php echo $option_name; ?>">
														<?php foreach($interval_options as $current_value => $option_title):
															echo '<option value="'.$current_value.'"' . ($selected_value == $current_value ? ' selected' : ''). '>' . $option_title . '</option>';
														endforeach; ?>
													</select>
												</div><!-- /.select-box -->
											</div><!-- /.section-body -->
										</div><!-- /.section-row -->

										<div class="section-row">
											<div class="section-head">
												<?php $section_title = esc_html__('Appointment Buffer', 'scheduled'); ?>
												<h3><?php echo esc_attr($section_title); ?></h3>
												<p><?php esc_html_e('To prevent appointments from getting scheduled too close to the current date and/or time, you can set an appointment buffer. Available appointments time slots will be pushed up to a new date and time depending on which buffer amount you choose below.','scheduled'); ?></p>

												<?php $option_name = 'scheduled_appointment_buffer';
												$selected_value = get_option($option_name);

												$interval_options = array(
													'0' 				=> esc_html__('No buffer','scheduled'),
													'1' 				=> esc_html__('1 hour','scheduled'),
													'2' 				=> esc_html__('2 hours','scheduled'),
													'3' 				=> esc_html__('3 hours','scheduled'),
													'4' 				=> esc_html__('4 hours','scheduled'),
													'5' 				=> esc_html__('5 hours','scheduled'),
													'6' 				=> esc_html__('6 hours','scheduled'),
													'12' 				=> esc_html__('12 hours','scheduled'),
													'24' 				=> esc_html__('24 hours','scheduled'),
													'48' 				=> esc_html__('2 days','scheduled'),
													'72' 				=> esc_html__('3 days','scheduled'),
													'96' 				=> esc_html__('5 days','scheduled'),
													'144' 				=> esc_html__('6 days','scheduled'),
													'168' 				=> esc_html__('1 week','scheduled'),
													'336' 				=> esc_html__('2 weeks','scheduled'),
													'504' 				=> esc_html__('3 weeks','scheduled'),
													'672' 				=> esc_html__('4 weeks','scheduled'),
													'840' 				=> esc_html__('5 weeks','scheduled'),
													'1008' 				=> esc_html__('6 weeks','scheduled'),
													'1176' 				=> esc_html__('7 weeks','scheduled'),
													'1344' 				=> esc_html__('8 weeks','scheduled'),
												); ?>

												<div class="select-box">
													<select name="<?php echo $option_name; ?>">
														<?php foreach($interval_options as $current_value => $option_title):
															echo '<option value="'.$current_value.'"' . ($selected_value == $current_value ? ' selected' : ''). '>' . $option_title . '</option>';
														endforeach; ?>
													</select>
												</div><!-- /.select-box -->
											</div><!-- /.section-body -->
										</div><!-- /.section-row -->

										<?php $date_format = get_option('date_format'); ?>

										<div class="section-row">
											<div class="section-head">
												<?php $section_title = esc_html__('Prevent Appointments Before Date', 'scheduled'); ?>
												<h3><?php echo esc_attr($section_title); ?></h3>
												<p><?php esc_html_e('To prevent appointments from getting scheduled before a certain date, you can choose that date below.','scheduled'); ?></p>

												<?php $option_name = 'scheduled_prevent_appointments_before';
												$selected_value = get_option($option_name); ?>

												<div class="select-box">
													<input type="text" placeholder="<?php esc_html_e("Choose a date","scheduled"); ?>..." class="scheduled_prevent_appointments_before" name="<?php echo $option_name; ?>" value="<?php echo $selected_value; ?>">
													<span class="<?php echo $option_name; ?>-formatted" style="padding-left:15px; font-weight:600; font-size:15px;"><?php echo ( $selected_value ? ucwords( date_i18n( $date_format,strtotime($selected_value) ) ) : '' ); ?></span>
												</div><!-- /.select-box -->
											</div><!-- /.section-body -->
										</div><!-- /.section-row -->

										<div class="section-row">
											<div class="section-head">
												<?php $section_title = esc_html__('Prevent Appointments After Date', 'scheduled'); ?>
												<h3><?php echo esc_attr($section_title); ?></h3>
												<p><?php esc_html_e('To prevent appointments from getting scheduled after a certain date, you can choose that date below.','scheduled'); ?></p>

												<?php $option_name = 'scheduled_prevent_appointments_after';
												$selected_value = get_option($option_name); ?>

												<div class="select-box">
													<input type="text" placeholder="<?php esc_html_e("Choose a date","scheduled"); ?>..." class="scheduled_prevent_appointments_after" name="<?php echo $option_name; ?>" value="<?php echo $selected_value; ?>">
													<span class="<?php echo $option_name; ?>-formatted" style="padding-left:15px; font-weight:600; font-size:15px;"><?php echo ( $selected_value ? ucwords( date_i18n( $date_format,strtotime($selected_value) ) ) : '' ); ?></span>
												</div><!-- /.select-box -->
											</div><!-- /.section-body -->
										</div><!-- /.section-row -->

										<div class="section-row">
											<div class="section-head">
												<?php $section_title = esc_html__('Cancellation Buffer', 'scheduled'); ?>
												<h3><?php echo esc_attr($section_title); ?></h3>
												<p><?php esc_html_e('To prevent appointments from getting cancelled too close to the appointment time, you can set a cancellation buffer.','scheduled'); ?></p>

												<?php $option_name = 'scheduled_cancellation_buffer';
												$selected_value = get_option($option_name);

												$interval_options = array(
													'0' 				=> esc_html__('No buffer','scheduled'),
													'0.25' 				=> esc_html__('15 minutes','scheduled'),
													'0.50' 				=> esc_html__('30 minutes','scheduled'),
													'0.75' 				=> esc_html__('45 minutes','scheduled'),
													'1' 				=> esc_html__('1 hour','scheduled'),
													'2' 				=> esc_html__('2 hours','scheduled'),
													'3' 				=> esc_html__('3 hours','scheduled'),
													'4' 				=> esc_html__('4 hours','scheduled'),
													'5' 				=> esc_html__('5 hours','scheduled'),
													'6' 				=> esc_html__('6 hours','scheduled'),
													'12' 				=> esc_html__('12 hours','scheduled'),
													'24' 				=> esc_html__('24 hours','scheduled'),
													'48' 				=> esc_html__('2 days','scheduled'),
													'72' 				=> esc_html__('3 days','scheduled'),
													'96' 				=> esc_html__('5 days','scheduled'),
													'144' 				=> esc_html__('6 days','scheduled'),
													'168' 				=> esc_html__('1 week','scheduled'),
													'336' 				=> esc_html__('2 weeks','scheduled'),
													'504' 				=> esc_html__('3 weeks','scheduled'),
													'672' 				=> esc_html__('4 weeks','scheduled'),
													'840' 				=> esc_html__('5 weeks','scheduled'),
													'1008' 				=> esc_html__('6 weeks','scheduled'),
													'1176' 				=> esc_html__('7 weeks','scheduled'),
													'1344' 				=> esc_html__('8 weeks','scheduled'),
												); ?>

												<div class="select-box">
													<select name="<?php echo $option_name; ?>">
														<?php foreach($interval_options as $current_value => $option_title):
															echo '<option value="'.$current_value.'"' . ($selected_value == $current_value ? ' selected' : ''). '>' . $option_title . '</option>';
														endforeach; ?>
													</select>
												</div><!-- /.select-box -->
											</div><!-- /.section-body -->
										</div><!-- /.section-row -->

										<div class="section-row">
											<div class="section-head">
												<?php $section_title = esc_html__('Appointment Limit', 'scheduled'); ?>
												<h3><?php echo esc_attr($section_title); ?></h3>
												<p><?php esc_html_e('To prevent users from booking too many appointments, you can set an appointment limit.','scheduled'); ?></p>

												<?php $option_name = 'scheduled_appointment_limit';
												$selected_value = get_option($option_name);

												$interval_options = array(
													'0' 				=> esc_html__('No limit','scheduled'),
													'1' 				=> esc_html__('1 appointment','scheduled'),
													'2' 				=> esc_html__('2 appointments','scheduled'),
													'3' 				=> esc_html__('3 appointments','scheduled'),
													'4' 				=> esc_html__('4 appointments','scheduled'),
													'5' 				=> esc_html__('5 appointments','scheduled'),
													'6' 				=> esc_html__('6 appointments','scheduled'),
													'7' 				=> esc_html__('7 appointments','scheduled'),
													'8' 				=> esc_html__('8 appointments','scheduled'),
													'9' 				=> esc_html__('9 appointments','scheduled'),
													'10' 				=> esc_html__('10 appointments','scheduled'),
													'15' 				=> esc_html__('15 appointments','scheduled'),
													'20' 				=> esc_html__('20 appointments','scheduled'),
													'25' 				=> esc_html__('25 appointments','scheduled'),
													'50' 				=> esc_html__('50 appointments','scheduled'),
												); ?>

												<div class="select-box">
													<select name="<?php echo $option_name; ?>">
														<?php foreach($interval_options as $current_value => $option_title):
															echo '<option value="'.$current_value.'"' . ($selected_value == $current_value ? ' selected' : ''). '>' . $option_title . '</option>';
														endforeach; ?>
													</select>
												</div><!-- /.select-box -->
											</div><!-- /.section-body -->
										</div><!-- /.section-row -->

										<div class="section-row">
											<div class="section-head">
												<?php $section_title = esc_html__('New Appointment Default', 'scheduled'); ?>
												<h3><?php echo esc_attr($section_title); ?></h3>
												<p><?php esc_html_e('Would you like your appointment requests to go into a pending list or should they be approved immediately?','scheduled'); ?></p>

												<?php $option_name = 'scheduled_new_appointment_default';
												$selected_value = get_option($option_name);

												$interval_options = array(
													'draft' 	=> esc_html__('Set as Pending','scheduled'),
													'publish' 	=> esc_html__('Approve Immediately','scheduled')
												); ?>

												<div class="select-box">
													<select name="<?php echo $option_name; ?>">
														<?php foreach($interval_options as $current_value => $option_title):
															echo '<option value="'.$current_value.'"' . ($selected_value == $current_value ? ' selected' : ''). '>' . $option_title . '</option>';
														endforeach; ?>
													</select>
												</div><!-- /.select-box -->
											</div><!-- /.section-body -->
										</div><!-- /.section-row -->

										<div class="section-row cf">
											<div class="section-head">

												<h3><?php esc_html_e('Display Options', 'scheduled'); ?></h3><?php // TODO - WIP ?>

												<br>

												<?php $option_name = 'scheduled_hide_default_calendar';
												$option_value = get_option($option_name,false); ?>

												<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"<?php echo $option_value ? ' checked="checked"' : ''; ?> type="checkbox">
												<label class="checkbox-radio-label" for="<?php echo $option_name; ?>"><?php esc_html_e('Hide "Default" in the calendar switcher','scheduled'); ?></label><br><br>

												<?php $option_name = 'scheduled_hide_weekends';
												$option_value = get_option($option_name,false); ?>

												<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"<?php echo $option_value ? ' checked="checked"' : ''; ?> type="checkbox">
												<label class="checkbox-radio-label" for="<?php echo $option_name; ?>"><?php esc_html_e('Hide weekends in the calendar','scheduled'); ?></label><br><br>

												<?php $option_name = 'scheduled_hide_google_link';
												$option_value = get_option($option_name,false); ?>

												<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"<?php echo $option_value ? ' checked="checked"' : ''; ?> type="checkbox">
												<label class="checkbox-radio-label" for="<?php echo $option_name; ?>"><?php esc_html_e('Hide "Add to Calender" button in the Profile appointment list','scheduled'); ?></label><br><br>

												<?php $option_name = 'scheduled_show_only_titles';
												$option_value = get_option($option_name,false); ?>

												<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"<?php echo $option_value ? ' checked="checked"' : ''; ?> type="checkbox">
												<label class="checkbox-radio-label" for="<?php echo $option_name; ?>"><?php esc_html_e('Hide time slots (when a time slot title exists)','scheduled'); ?></label><br><br>

												<?php $option_name = 'scheduled_hide_end_times';
												$option_value = get_option($option_name,false); ?>

												<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"<?php echo $option_value ? ' checked="checked"' : ''; ?> type="checkbox">
												<label class="checkbox-radio-label" for="<?php echo $option_name; ?>"><?php esc_html_e('Hide end times (show only start times)','scheduled'); ?></label><br><br>

												<?php $option_name = 'scheduled_hide_available_timeslots';
												$option_value = get_option($option_name,false); ?>

												<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"<?php echo $option_value ? ' checked="checked"' : ''; ?> type="checkbox">
												<label class="checkbox-radio-label" for="<?php echo $option_name; ?>"><?php esc_html_e('Hide the number of available time slots','scheduled'); ?></label><br><br>

												<?php $option_name = 'scheduled_hide_unavailable_timeslots';
												$option_value = get_option($option_name,false); ?>

												<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"<?php echo $option_value ? ' checked="checked"' : ''; ?> type="checkbox">
												<label class="checkbox-radio-label" for="<?php echo $option_name; ?>"><?php esc_html_e('Hide the already scheduled time slots (cannot be used with "Public Appointments")','scheduled'); ?></label><br><br>

												<?php $option_name = 'scheduled_public_appointments';
												$option_value = get_option($option_name,false); ?>

												<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"<?php echo $option_value ? ' checked="checked"' : ''; ?> type="checkbox">
												<label class="checkbox-radio-label" for="<?php echo $option_name; ?>"><?php esc_html_e('Public Appointments (show names under scheduled appointments)','scheduled'); ?></label><br><br>

											</div>
										</div>

										<div class="section-row cf">
											<div class="section-head">

												<h3><?php esc_html_e('Other Options', 'scheduled'); ?></h3><?php // TODO - WIP ?>

												<br>

												<?php $option_name = 'scheduled_dont_allow_user_cancellations';
												$option_value = get_option($option_name,false); ?>

												<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"<?php echo $option_value ? ' checked="checked"' : ''; ?> type="checkbox">
												<label class="checkbox-radio-label" for="<?php echo $option_name; ?>"><?php esc_html_e('Do not allow users to cancel their own appointments.','scheduled'); ?></label><br><br>

												<?php $option_name = 'scheduled_redirect_non_admins';
												$option_value = get_option($option_name,false); ?>

												<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"<?php echo $option_value ? ' checked="checked"' : ''; ?> type="checkbox">
												<label class="checkbox-radio-label" for="<?php echo $option_name; ?>"><?php esc_html_e('Redirect users (except Admins and Booking Agents) from the "/wp-admin/" URL.','scheduled'); ?></label><br><br>

												<?php $option_name = 'scheduled_hide_admin_bar_menu';
												$option_value = get_option($option_name,false); ?>

												<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>"<?php echo $option_value ? ' checked="checked"' : ''; ?> type="checkbox">
												<label class="checkbox-radio-label" for="<?php echo $option_name; ?>"><?php esc_html_e('Hide "Appointments" menu from Admin Bar.','scheduled'); ?></label>

											</div>
										</div><!-- /.section-row -->

										<div class="section-row">
											<div class="section-head">
												<?php $section_title = esc_html__('Front-End Color Settings', 'scheduled'); ?>
												<h3><?php echo esc_attr($section_title); ?></h3><?php // TODO - WIP ?>
											</div><!-- /.section-head -->
											<div class="section-body">

												<?php
												$color_options = array(
													array(
														'name' => 'scheduled_light_color',
														'title' => 'Light Color',
														'val' => get_option('scheduled_light_color','#2371B1'),
														'default' => '#2371B1'
													),
													array(
														'name' => 'scheduled_dark_color',
														'title' => 'Dark Color',
														'val' => get_option('scheduled_dark_color','#014163'),
														'default' => '#014163'

													),
													array(
														'name' => 'scheduled_button_color',
														'title' => 'Primary Button Color',
														'val' => get_option('scheduled_button_color','#56C477'),
														'default' => '#56C477'

													),
												);

												foreach($color_options as $color_option):

													echo '<label class="scheduled-color-label" for="'.$color_option['name'].'">'.$color_option['title'].'</label>';
													echo '<input data-default-color="'.$color_option['default'].'" type="text" name="'.$color_option['name'].'" value="'.$color_option['val'].'" id="'.$color_option['name'].'" class="scheduled-color-field" />';

												endforeach;
												?>

											</div><!-- /.section-body -->
										</div>

										<div class="section-row submit-section" style="padding:0;">
											<?php @submit_button(); ?>
										</div><!-- /.section-row -->

									</div>

									<div id="scheduled-email-settings" class="tab-content">

										<div class="section-row">
											<div class="section-head">
												<p style="background:#fff; padding:13px 19px 12px; border-left:3px solid #aaa; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px; box-shadow:0 1px 3px rgba(0,0,0,0.10); margin:0; font-size:15px; line-height:1.6;"><?php esc_html_e('If you DO NOT want to send emails for any of the actions listed below, just remove the email subject or content text (or both) and the email will not be sent for that notification.','scheduled'); ?></p>
											</div>
										</div>

										<?php $email_template_tabs = apply_filters( 'scheduled_admin_email_template_tabs', array(
											'customer-emails' => esc_html__('Customer Emails','scheduled'),
											'admin-emails' => esc_html__('Admin/Agent Emails','scheduled'),
											'email-settings' => esc_html__('Settings','scheduled')
										));

										$tab_counter = 0; ?>

										<?php do_action( 'scheduled_admin_before_email_tabs' ); ?>

										<ul class="scheduled-admin-subtabs scheduledClearFix">
											<?php foreach( $email_template_tabs as $tab_name => $tab_text ): $tab_counter++; ?>
												<li<?php if ( $tab_counter == 1): ?> class="active"<?php endif; ?>><a href="#<?php echo $tab_name; ?>"><?php echo $tab_text; ?></a></li>
											<?php endforeach; ?>
										</ul>

										<?php do_action( 'scheduled_admin_after_email_tabs' ); ?>

										<?php do_action( 'scheduled_admin_before_email_tab_content' ); ?>

										<div id="scheduled-subtab-email-settings" class="subtab-content">

											<div class="section-row">
												<div class="section-head"><?php

													$option_name = 'scheduled_email_logo';
													$scheduled_email_logo = get_option($option_name);
													$section_title = esc_html__('Header/Logo Image', 'scheduled'); ?>

													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('Choose an image for your custom emails. Keep it 600px or less for best results.','scheduled'); ?></p>

													<input id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" value="<?php echo $scheduled_email_logo; ?>" type="hidden" />
													<input id="scheduled_email_logo_button" class="button button-primary" name="scheduled_email_logo_button" type="button" value="<?php esc_html_e('Upload Logo','scheduled'); ?>" />

													<input id="scheduled_email_logo_button_remove"<?php echo ( !$scheduled_email_logo ? ' style="display:none;"' : '' ); ?> class="button" name="scheduled_email_logo_button_remove" type="button" value="<?php esc_html_e('Remove','scheduled'); ?>" />
													<img src="<?php echo $scheduled_email_logo; ?>"<?php echo ( !$scheduled_email_logo ? ' style="display:none;"' : '' ); ?> id="scheduled_email_logo-img">

												</div>
											</div>

											<div class="section-row">
												<div class="section-head">
													<?php $section_title = esc_html__('Which Administrator or Booking Agent user should receive the notification emails by default?', 'scheduled'); ?>
													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('By default, Scheduled uses the "Settings > General > E-mail Address" setting. Also, each custom calendar can have their own user notification setting, this is just the default.','scheduled'); ?></p>

													<?php $option_name = 'scheduled_default_email_user';

													$allowed_users = get_users( array( 'role__in' => array( 'administrator', 'scheduled_booking_agent' ) ) );

													$selected_value = get_option($option_name); ?>
													<div class="select-box">
														<select name="<?php echo $option_name; ?>">
															<option value=""><?php esc_html_e('Choose a default user for notifications','scheduled'); ?> ...</option>
															<?php if(!empty($allowed_users)) :
																foreach($allowed_users as $u) :
																	$user_id = $u->ID;
																	$email = $u->data->user_email;
																	$display_name = ( isset( $u->data->display_name ) && $u->data->display_name ? $u->data->display_name . ' (' . $email .')' : $email ); ?>
																	<option value="<?php echo $email; ?>"<?php echo ($selected_value == $email ? ' selected="selected"' : ''); ?>><?php echo $display_name; ?></option>
																<?php endforeach;

															endif; ?>
														</select>
													</div><!-- /.select-box -->
												</div><!-- /.section-body -->
											</div><!-- /.section-row -->

											<?php $selected_value = get_option('scheduled_email_force_sender',false); ?>
											<?php $selected_email = get_option('scheduled_email_force_sender_from',false); ?>
											<?php $selected_scheduled_mailer = get_option('scheduled_emailer_disabled',false); ?>

											<div class="section-row">
												<div class="section-head">

													<h3><?php echo esc_html__('Having Email Issues?', 'scheduled'); ?></h3>
													<p style="margin-bottom:2.5em;"><?php echo sprintf( esc_html__('Try using an SMTP plugin like %s or %s','scheduled'), '<a href="https://wordpress.org/plugins/wp-mail-smtp/" target="_blank">WP Mail SMTP</a>', '<a href="https://wordpress.org/plugins/easy-wp-smtp/" target="_blank">Easy WP SMTP</a>' ); ?></p>

													<h3><?php echo esc_html__('Emails ONLY NOT sending to Admins/Agents?', 'scheduled'); ?></h3>
													<p><?php esc_html_e('Some SMTP clients reject emails being sent "from" your customers. Google is one of them, but they simply change the name of the sender to prevent the rejection. Others do not. You can check the following option to "Force the sender name/email", but you will not be able to reply directly to the notification emails coming from customers.','scheduled'); ?></p>

													<p style="margin:1.2em 0 15px;">
														<input data-condition="force_sender" style="margin:-4px 5px 0 0;" id="scheduled_email_force_sender" name="scheduled_email_force_sender" value="true"<?php if ($selected_value): echo ' checked="checked"'; endif; ?> type="checkbox">
														<label class="checkbox-radio-label" for="scheduled_email_force_sender"><strong><?php esc_html_e("Force sender email", "scheduled"); ?></strong></label>
													</p>

													<p class="condition-block force_sender"<?php echo ( $selected_value ? ' style="display:block;"' : '' ); ?>>
														<input style="margin:0" name="scheduled_email_force_sender_from" value="<?php echo ( $selected_email ? $selected_email : get_option('admin_email') ); ?>" type="text" class="field">
													</p>

													<h3 style="margin-top:2em;"><?php echo esc_html__('Still not working?', 'scheduled'); ?></h3>
													<p><?php esc_html_e('If you are still having issues, check the box below to disable the Scheduled mailer and let WordPress handle the emails completely.','scheduled'); ?></p>

													<p style="margin:1.2em 0 0;">
														<input style="margin:-4px 5px 0 0;" id="scheduled_emailer_disabled" name="scheduled_emailer_disabled" value="true"<?php if ($selected_scheduled_mailer): echo ' checked="checked"'; endif; ?> type="checkbox">
														<label class="checkbox-radio-label" for="scheduled_emailer_disabled"><strong><?php esc_html_e("Disable Scheduled mailer, let WordPress handle it.", "scheduled"); ?></strong></label>
													</p>

												</div>
											</div>

										</div>
										<div id="scheduled-subtab-customer-emails" class="subtab-content">

											<div class="section-row">
												<div class="section-head">
													<?php $section_title = esc_html__('Customer Appointment Reminder', 'scheduled'); ?>
													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('When do you want to send out appointment reminders?','scheduled'); ?></p>

													<?php $option_name = 'scheduled_reminder_buffer';
													$selected_value = get_option($option_name,30);

													$interval_options = array(
														'0' 				=> esc_html__('At appointment time','scheduled'),
														'5' 				=> esc_html__('5 minutes before','scheduled'),
														'10' 				=> esc_html__('10 minutes before','scheduled'),
														'15' 				=> esc_html__('15 minutes before','scheduled'),
														'30' 				=> esc_html__('30 minutes before','scheduled'),
														'45' 				=> esc_html__('45 minutes before','scheduled'),
														'60' 				=> esc_html__('1 hour before','scheduled'),
														'120' 				=> esc_html__('2 hours before','scheduled'),
														'180' 				=> esc_html__('3 hours before','scheduled'),
														'240' 				=> esc_html__('4 hours before','scheduled'),
														'300' 				=> esc_html__('5 hours before','scheduled'),
														'360' 				=> esc_html__('6 hours before','scheduled'),
														'720' 				=> esc_html__('12 hours before','scheduled'),
														'1440' 				=> esc_html__('24 hours before','scheduled'),
														'2880' 				=> esc_html__('2 days before','scheduled'),
														'4320' 				=> esc_html__('3 days before','scheduled'),
														'5760' 				=> esc_html__('4 days before','scheduled'),
														'7200' 				=> esc_html__('5 days before','scheduled'),
														'8640' 				=> esc_html__('6 days before','scheduled'),
														'10080' 			=> esc_html__('1 week before','scheduled'),
														'20160' 			=> esc_html__('2 weeks before','scheduled'),
														'30240' 			=> esc_html__('3 weeks before','scheduled'),
														'40320' 			=> esc_html__('4 weeks before','scheduled'),
														'60480' 			=> esc_html__('6 weeks before','scheduled'),
														'80640' 			=> esc_html__('2 months before','scheduled'),
														'120960' 			=> esc_html__('3 months before','scheduled'),
													); ?>

													<div class="select-box">
														<select name="<?php echo $option_name; ?>">
															<?php foreach($interval_options as $current_value => $option_title):
																echo '<option value="'.$current_value.'"' . ($selected_value == $current_value ? ' selected' : ''). '>' . $option_title . '</option>';
															endforeach; ?>
														</select>
													</div><!-- /.select-box -->

													<p><strong><?php esc_html_e('Please Note:','scheduled'); ?></strong> <?php esc_html_e('WordPress crons do not run unless someone visits your site. Because of this, some reminders might not get sent out. To prevent this from happening, you would need to setup cron to run from the server level using the following command:','scheduled'); ?></p>
													<p><code>*/5 * * * * wget -q -O - <?php echo get_site_url(); ?>/wp-cron.php?doing_wp_cron</code></p>

												</div><!-- /.section-body -->
											</div><!-- /.section-row -->

											<div class="section-row">
												<div class="section-head">
													<?php $option_name = 'scheduled_reminder_email';

$default_content = 'Just a friendly reminder that you have an appointment coming up soon! Here\'s the appointment information:

<strong>Calendar:</strong> %calendar%
<strong>Date:</strong> %date%
<strong>Time:</strong> %time%

Sincerely,
Your friends at '.get_bloginfo('name');

													$email_content_admin_reminder = get_option($option_name,$default_content);
													$section_title = esc_html__('Customer Appointment Reminder Content', 'scheduled'); ?>

													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('This is the email content for appoinment reminders. Some tokens you can use:','scheduled'); ?></p>
													<ul class="cp-list">
														<?php $scheduled_mailer_tokens = scheduled_mailer_tokens();
														foreach( $scheduled_mailer_tokens as $token => $desc ):
															echo '<li><strong>%' . $token . '%</strong> &mdash; ' . $desc . '</li>';
														endforeach; ?>
													</ul><br>

													<?php

													$subject_var = 'scheduled_reminder_email_subject';
													$subject_default = 'Reminder: You have an appointment coming up soon!';
													$current_subject_value = get_option($subject_var,$subject_default); ?>

													<input style="margin:0" name="<?php echo $subject_var; ?>" value="<?php echo $current_subject_value; ?>" type="text" class="field">
													<?php wp_editor( $email_content_admin_reminder, $option_name, array('textarea_name' => $option_name,'media_buttons' => false,'editor_height' => 250,'teeny' => true) ); ?>

												</div>
											</div><!-- /.section-row -->

											<div class="section-row">
												<div class="section-head">
													<?php $option_name = 'scheduled_registration_email_content';

$default_content = 'Hey %name%!

Thanks for registering at '.get_bloginfo('name').'. You can now login to manage your account and appointments using the following credentials:

Email Address: %email%
Password: %password%

Sincerely,
Your friends at '.get_bloginfo('name');

													$email_content_registration = get_option($option_name,$default_content);
													$section_title = esc_html__('User Registration', 'scheduled'); ?>

													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('The email content that is sent to the user upon registration (using the Scheduled registration form). Some tokens you can use:','scheduled'); ?></p>
													<ul class="cp-list">
														<li><strong>%name%</strong> &mdash; <?php esc_html_e("To display the person's name.","scheduled"); ?></li>
														<li><strong>%email%</strong> &mdash; <?php esc_html_e("To display the person's email address.","scheduled"); ?></li>
														<li><strong>%password%</strong> &mdash; <?php esc_html_e("To display the password for login.","scheduled"); ?></li>
													</ul><br>

													<?php

													$subject_var = 'scheduled_registration_email_subject';
													$subject_default = 'Thank you for registering!';
													$current_subject_value = get_option($subject_var,$subject_default); ?>

													<input style="margin:0" name="<?php echo $subject_var; ?>" value="<?php echo $current_subject_value; ?>" type="text" class="field">
													<?php wp_editor( $email_content_registration, $option_name, array('textarea_name' => $option_name,'media_buttons' => false,'editor_height' => 350,'teeny' => true) ); ?>

												</div>
											</div><!-- /.section-row -->

											<div class="section-row" data-controller="cp_fes_controller" data-controlled_by="fes_enabled">
												<div class="section-head">
													<?php $option_name = 'scheduled_appt_confirmation_email_content';

$default_content = 'Hey %name%!

This is just an email to confirm your appointment. For reference, here\'s the appointment information:

Date: %date%
Time: %time%

Sincerely,
Your friends at '.get_bloginfo('name');

													$email_content_approval = get_option($option_name,$default_content);
													$section_title = esc_html__('Appointment Confirmation', 'scheduled'); ?>

													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('The email content that is sent to the user upon appointment creation. Some tokens you can use:','scheduled'); ?></p>
													<ul class="cp-list">
														<?php $scheduled_mailer_tokens = scheduled_mailer_tokens();
														foreach( $scheduled_mailer_tokens as $token => $desc ):
															echo '<li><strong>%' . $token . '%</strong> &mdash; ' . $desc . '</li>';
														endforeach; ?>
													</ul><br>

													<?php

													$subject_var = 'scheduled_appt_confirmation_email_subject';
													$subject_default = 'Your appointment confirmation from '.get_bloginfo('name').'.';
													$current_subject_value = get_option($subject_var,$subject_default); ?>

													<input style="margin:0" name="<?php echo $subject_var; ?>" value="<?php echo $current_subject_value; ?>" type="text" class="field">
													<?php wp_editor( $email_content_approval, $option_name, array('textarea_name' => $option_name,'media_buttons' => false,'editor_height' => 350,'teeny' => true) ); ?>
												</div>
											</div><!-- /.section-row -->

											<div class="section-row" data-controller="cp_fes_controller" data-controlled_by="fes_enabled">
												<div class="section-head">
													<?php $option_name = 'scheduled_approval_email_content';

$default_content = 'Hey %name%!

The appointment you requested at '.get_bloginfo('name').' has been approved! Here\'s your appointment information:

Date: %date%
Time: %time%

Sincerely,
Your friends at '.get_bloginfo('name');

													$email_content_approval = get_option($option_name,$default_content);
													$section_title = esc_html__('Appointment Approval', 'scheduled'); ?>

													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('The email content that is sent to the user upon appointment approval. Some tokens you can use:','scheduled'); ?></p>
													<ul class="cp-list">
														<?php $scheduled_mailer_tokens = scheduled_mailer_tokens();
														foreach( $scheduled_mailer_tokens as $token => $desc ):
															echo '<li><strong>%' . $token . '%</strong> &mdash; ' . $desc . '</li>';
														endforeach; ?>
													</ul><br>

													<?php

													$subject_var = 'scheduled_approval_email_subject';
													$subject_default = 'Your appointment has been approved!';
													$current_subject_value = get_option($subject_var,$subject_default); ?>

													<input style="margin:0" name="<?php echo $subject_var; ?>" value="<?php echo $current_subject_value; ?>" type="text" class="field">
													<?php wp_editor( $email_content_approval, $option_name, array('textarea_name' => $option_name,'media_buttons' => false,'editor_height' => 350,'teeny' => true) ); ?>
												</div>
											</div><!-- /.section-row -->

											<div class="section-row" data-controller="cp_fes_controller" data-controlled_by="fes_enabled">
												<div class="section-head">
													<?php $option_name = 'scheduled_cancellation_email_content';

$default_content = 'Hey %name%!

The appointment you requested at '.get_bloginfo('name').' has been cancelled. For reference, here\'s the appointment information:

Date: %date%
Time: %time%

Sincerely,
Your friends at '.get_bloginfo('name');

													$email_content_approval = get_option($option_name,$default_content);
													$section_title = esc_html__('Appointment Cancellation', 'scheduled'); ?>

													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('The email content that is sent to the user upon appointment cancellation. Some tokens you can use:','scheduled'); ?></p>
													<ul class="cp-list">
														<?php $scheduled_mailer_tokens = scheduled_mailer_tokens();
														foreach( $scheduled_mailer_tokens as $token => $desc ):
															echo '<li><strong>%' . $token . '%</strong> &mdash; ' . $desc . '</li>';
														endforeach; ?>
													</ul><br>

													<?php

													$subject_var = 'scheduled_cancellation_email_subject';
													$subject_default = 'Your appointment has been cancelled.';
													$current_subject_value = get_option($subject_var,$subject_default); ?>

													<input style="margin:0" name="<?php echo $subject_var; ?>" value="<?php echo $current_subject_value; ?>" type="text" class="field">
													<?php wp_editor( $email_content_approval, $option_name, array('textarea_name' => $option_name,'media_buttons' => false,'editor_height' => 350,'teeny' => true) ); ?>

												</div>
											</div><!-- /.section-row -->

										</div>
										<div id="scheduled-subtab-admin-emails" class="subtab-content">

											<div class="section-row">
												<div class="section-head">
													<?php $section_title = esc_html__('Admin/Agent Appointment Reminder', 'scheduled'); ?>
													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('When do you want to send out appointment reminders?','scheduled'); ?></p>

													<?php $option_name = 'scheduled_admin_reminder_buffer';
													$selected_value = get_option($option_name,30);

													$interval_options = array(
														'0' 				=> esc_html__('At appointment time','scheduled'),
														'5' 				=> esc_html__('5 minutes before','scheduled'),
														'10' 				=> esc_html__('10 minutes before','scheduled'),
														'15' 				=> esc_html__('15 minutes before','scheduled'),
														'30' 				=> esc_html__('30 minutes before','scheduled'),
														'45' 				=> esc_html__('45 minutes before','scheduled'),
														'60' 				=> esc_html__('1 hour before','scheduled'),
														'120' 				=> esc_html__('2 hours before','scheduled'),
														'180' 				=> esc_html__('3 hours before','scheduled'),
														'240' 				=> esc_html__('4 hours before','scheduled'),
														'300' 				=> esc_html__('5 hours before','scheduled'),
														'360' 				=> esc_html__('6 hours before','scheduled'),
														'720' 				=> esc_html__('12 hours before','scheduled'),
														'1440' 				=> esc_html__('24 hours before','scheduled'),
														'2880' 				=> esc_html__('2 days before','scheduled'),
														'4320' 				=> esc_html__('3 days before','scheduled'),
														'5760' 				=> esc_html__('4 days before','scheduled'),
														'7200' 				=> esc_html__('5 days before','scheduled'),
														'8640' 				=> esc_html__('6 days before','scheduled'),
														'10080' 			=> esc_html__('1 week before','scheduled'),
														'20160' 			=> esc_html__('2 weeks before','scheduled'),
														'30240' 			=> esc_html__('3 weeks before','scheduled'),
														'40320' 			=> esc_html__('4 weeks before','scheduled'),
														'60480' 			=> esc_html__('6 weeks before','scheduled'),
														'80640' 			=> esc_html__('2 months before','scheduled'),
														'120960' 			=> esc_html__('3 months before','scheduled'),
													); ?>

													<div class="select-box">
														<select name="<?php echo $option_name; ?>">
															<?php foreach($interval_options as $current_value => $option_title):
																echo '<option value="'.$current_value.'"' . ($selected_value == $current_value ? ' selected' : ''). '>' . $option_title . '</option>';
															endforeach; ?>
														</select>
													</div><!-- /.select-box -->

													<p><strong><?php esc_html_e('Please Note:','scheduled'); ?></strong> <?php esc_html_e('WordPress crons do not run unless someone visits your site. Because of this, some reminders might not get sent out. To prevent this from happening, you would need to setup cron to run from the server level using the following command:','scheduled'); ?></p>
													<p><code>*/5 * * * * wget -q -O - <?php echo get_site_url(); ?>/wp-cron.php?doing_wp_cron</code></p>

												</div><!-- /.section-body -->
											</div><!-- /.section-row -->

											<div class="section-row">
												<div class="section-head">
													<?php $option_name = 'scheduled_admin_reminder_email';

$default_content = 'You have an appointment coming up soon! Here\'s the appointment information:

<strong>Customer:</strong> %name%
<strong>Date:</strong> %date%
<strong>Time:</strong> %time%

(Sent via the '.get_bloginfo('name').' website)';

													$email_content_admin_reminder = get_option($option_name,$default_content);
													$section_title = esc_html__('Admin/Agent Appointment Reminder Content', 'scheduled'); ?>

													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('This is the email content for appoinment reminders. Some tokens you can use:','scheduled'); ?></p>
													<ul class="cp-list">
														<?php $scheduled_mailer_tokens = scheduled_mailer_tokens();
														foreach( $scheduled_mailer_tokens as $token => $desc ):
															echo '<li><strong>%' . $token . '%</strong> &mdash; ' . $desc . '</li>';
														endforeach; ?>
													</ul><br>

													<?php

													$subject_var = 'scheduled_admin_reminder_email_subject';
													$subject_default = 'An appointment is coming up soon!';
													$current_subject_value = get_option($subject_var,$subject_default); ?>

													<input style="margin:0" name="<?php echo $subject_var; ?>" value="<?php echo $current_subject_value; ?>" type="text" class="field">
													<?php wp_editor( $email_content_admin_reminder, $option_name, array('textarea_name' => $option_name,'media_buttons' => false,'editor_height' => 250,'teeny' => true) ); ?>

												</div>
											</div><!-- /.section-row -->

											<div class="section-row">
												<div class="section-head">
													<?php $option_name = 'scheduled_admin_appointment_email_content';

$default_content = 'You have a new appointment request! Here\'s the appointment information:

Customer: %name%
Date: %date%
Time: %time%

Log into your website here: '.get_admin_url().' to approve this appointment.

(Sent via the '.get_bloginfo('name').' website)';

													$email_content_registration = get_option($option_name,$default_content);
													$section_title = esc_html__('Appointment Request', 'scheduled'); ?>

													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('The email content that is sent (to the selected admin users above) upon appointment request. Some tokens you can use:','scheduled'); ?></p>
													<ul class="cp-list">
														<?php $scheduled_mailer_tokens = scheduled_mailer_tokens();
														foreach( $scheduled_mailer_tokens as $token => $desc ):
															echo '<li><strong>%' . $token . '%</strong> &mdash; ' . $desc . '</li>';
														endforeach; ?>
													</ul><br>

													<?php

													$subject_var = 'scheduled_admin_appointment_email_subject';
													$subject_default = 'You have a new appointment request!';
													$current_subject_value = get_option($subject_var,$subject_default); ?>

													<input style="margin:0" name="<?php echo $subject_var; ?>" value="<?php echo $current_subject_value; ?>" type="text" class="field">
													<?php wp_editor( $email_content_registration, $option_name, array('textarea_name' => $option_name,'media_buttons' => false,'editor_height' => 350,'teeny' => true) ); ?>

												</div>
											</div><!-- /.section-row -->

											<div class="section-row">
												<div class="section-head">
													<?php $option_name = 'scheduled_admin_cancellation_email_content';

$default_content = 'One of your customers has cancelled their appointment. Here\'s the appointment information:

Customer: %name%
Date: %date%
Time: %time%

(Sent via the '.get_bloginfo('name').' website)';

													$email_content_registration = get_option($option_name,$default_content);
													$section_title = esc_html__('Appointment Cancellation', 'scheduled'); ?>

													<h3><?php echo esc_attr($section_title); ?></h3>
													<p><?php esc_html_e('The email content that is sent (to the selected admin users above) upon cancellation. Some tokens you can use:','scheduled'); ?></p>
													<ul class="cp-list">
														<?php $scheduled_mailer_tokens = scheduled_mailer_tokens();
														foreach( $scheduled_mailer_tokens as $token => $desc ):
															echo '<li><strong>%' . $token . '%</strong> &mdash; ' . $desc . '</li>';
														endforeach; ?>
													</ul><br>

													<?php

													$subject_var = 'scheduled_admin_cancellation_email_subject';
													$subject_default = 'An appointment has been cancelled.';
													$current_subject_value = get_option($subject_var,$subject_default); ?>

													<input style="margin:0" name="<?php echo $subject_var; ?>" value="<?php echo $current_subject_value; ?>" type="text" class="field">
													<?php wp_editor( $email_content_registration, $option_name, array('textarea_name' => $option_name,'media_buttons' => false,'editor_height' => 250,'teeny' => true) ); ?>

												</div>
											</div><!-- /.section-row -->

										</div>

										<?php do_action( 'scheduled_admin_after_email_tab_content' ); ?>

										<div class="section-row submit-section" style="padding:0;">
											<?php @submit_button(); ?>
										</div><!-- /.section-row -->

									</div><!-- /templates -->

								</form>

							<?php break;
							
							case 'woocommerce-settings':
							
								if ( class_exists('woocommerce') ):
							
								?><div id="scheduled-woocommerce-settings" class="scheduled-payment-settings-wrap tab-content">
									<form action="options.php" method="post">
										<div class="section-row">
											<div class="section-head">
												<?php settings_fields( SCHEDULED_WC_PLUGIN_PREFIX . 'payment_options' );
												do_settings_sections( SCHEDULED_WC_PLUGIN_PREFIX . 'payment_options' );
											?></div>
										</div><?php
										submit_button(); ?>
									</form>
								</div><?php
								
								endif;
							
							break;
							
							case 'calendar-feeds': ?>
								
								<div id="scheduled-calendar-feeds" class="tab-content">
									
									<div class="section-row">
										<div class="section-head">
											<?php $section_title = esc_html__('Calendar Feeds', 'scheduled'); ?>
											<h3 style="font-size:17px; margin:0; padding:0 0 5px;"><?php echo $section_title; ?></h3>
									
											<?php $secure_hash = md5( home_url() ); ?>
										
											<p style="width:50%; font-size:14px; margin:0; padding:0 0 20px;"><?php _e('Use the following URLs to either download a static feed (not auto-updating) or paste the URL into your favorite calendar app (Google Calendar, Apple Calendar, etc.) as a subscription to load a read-only auto-updating appointment feed.','scheduled-ical'); ?></p>
											
											<p style="font-size:15px; margin:0; padding:0 0 10px;"><strong><?php _e('All Appointments','scheduled-ical'); ?></strong></p>
											<p style="font-size:15px; margin:0; padding:0 0 20px;"><input readonly="readonly" type="text" style="width:50%;" value="<?php echo get_site_url(); ?>/?scheduled_ical&sh=<?php echo esc_attr( SCHEDULEDICAL_SECURE_HASH ); ?>"></p>
											
											<?php $calendars = get_terms('scheduled_custom_calendars','orderby=slug&hide_empty=0');
												
											if (!empty($calendars)):
												
												foreach($calendars as $calendar):
													
													?><p style="font-size:15px; margin:0; padding:0 0 10px;"><strong><?php echo $calendar->name; ?></strong></p>
													<p style="font-size:15px; margin:0; padding:0 0 20px;"><input readonly="readonly" type="text" style="width:50%;" value="<?php echo get_site_url(); ?>/?scheduled_ical&calendar=<?php echo $calendar->term_id; ?>&sh=<?php echo esc_attr( SCHEDULEDICAL_SECURE_HASH ); ?>"></p><?php
												
												endforeach;
															
											endif; ?>
										</div>
									</div>
								
								</div>
							
							<?php break;

							case 'defaults': ?>

								<div id="scheduled-defaults" class="tab-content">

									<?php if (!$scheduled_none_assigned && count($calendars) >= 1):

										?><div id="scheduled-timeslotsSwitcher">
											<p><strong><?php esc_html_e('Editing time slots for:','scheduled'); ?></strong></p>
											<?php

											echo '<select name="scheduledTimeslotsDisplayed">';
											if (current_user_can('manage_scheduled_options')): echo '<option value="">'.esc_html__('Default Calendar','scheduled').'</option>'; endif;

											foreach($calendars as $calendar):

												?><option value="<?php echo $calendar->term_id; ?>"><?php echo $calendar->name; ?></option><?php

											endforeach;

											echo '</select>';

										?></div><?php

									endif; ?>

									<div id="scheduledTimeslotsWrap">
										<?php if (current_user_can('manage_scheduled_options')):
											scheduled_render_timeslots();
										else:
											$first_calendar = reset($calendars);
											scheduled_render_timeslots($first_calendar->term_id);
										endif; ?>
									</div>

									<?php $timeslot_intervals = get_option('scheduled_timeslot_intervals',5); ?>

									<div id="timepickerTemplate" class="scheduledClearFix">
										<div class="timeslotTabs scheduledClearFix">
											<a class="addTimeslotTab active" href="#Single"><?php esc_html_e('Single','scheduled'); ?></a>
											<a class="addTimeslotTab" href="#Bulk"><?php esc_html_e('Bulk','scheduled'); ?></a>
										</div>
										<div class="tsTabContent tsSingle">
											<?php echo scheduled_render_single_timeslot_form($timeslot_intervals); ?>
										</div>
										<div class="tsTabContent tsBulk">
											<?php echo scheduled_render_bulk_timeslot_form($timeslot_intervals); ?>
										</div>
										<span class="cancel button"><?php esc_html_e('Close','scheduled'); ?></span>
									</div>

								</div><!-- /templates -->

							<?php break;

							case 'custom-timeslots': ?>

								<div id="scheduled-custom-timeslots" class="tab-content">

									<form action="" id="customTimeslots">

										<div id="customTimeslotsWrapper">
											<div id="customTimeslotsContainer">

												<?php

												// Any custom time slots saved already?
												$scheduled_custom_timeslots_encoded = get_option('scheduled_custom_timeslots_encoded');
												$scheduled_custom_timeslots_decoded = json_decode($scheduled_custom_timeslots_encoded,true);

												$available_calendar_ids = array();

												foreach($calendars as $this_calendar):
													$available_calendar_ids[] = $this_calendar->term_id;
												endforeach;

												if (!empty($scheduled_custom_timeslots_decoded)):

													$custom_timeslots_array = scheduled_custom_timeslots_reconfigured($scheduled_custom_timeslots_decoded);
													foreach($custom_timeslots_array as $key => $timeslot):
														$date_string = date_i18n('Ymd',strtotime($timeslot['scheduled_custom_start_date']));
														$new_custom_timeslots_array[$date_string.$key] = $timeslot;
													endforeach;

													$custom_timeslots_array = $new_custom_timeslots_array;

													ksort($custom_timeslots_array);
													$current_timeslot_month_year = false;

													foreach($custom_timeslots_array as $this_timeslot):

														$this_timeslot['scheduled_custom_calendar_id'] = isset($this_timeslot['scheduled_custom_calendar_id']) ? $this_timeslot['scheduled_custom_calendar_id'] : false;
														$this_timeslot_month_year = ( $this_timeslot['scheduled_custom_start_date'] ? date_i18n('F, Y',strtotime($this_timeslot['scheduled_custom_start_date'])) : '<span style="color:#dd0000;">'.esc_html__('No "Start date" has been set for these:').'</span>' );

														if (!$current_timeslot_month_year || $current_timeslot_month_year != $this_timeslot_month_year):
															$current_timeslot_month_year = $this_timeslot_month_year;
															echo '<h3 class="scheduled-ct-date-heading">'.$current_timeslot_month_year.'</h3>';
														endif;

														?><div class="scheduled-customTimeslot"<?php if (!current_user_can('manage_scheduled_options') && $this_timeslot['scheduled_custom_calendar_id'] && !in_array($this_timeslot['scheduled_custom_calendar_id'],$available_calendar_ids)): echo ' style="display:none;"'; endif; ?>>

															<?php

															if (!empty($calendars)):

															    if (!current_user_can('manage_scheduled_options') && $this_timeslot['scheduled_custom_calendar_id'] && !in_array($this_timeslot['scheduled_custom_calendar_id'],$available_calendar_ids)):

															        ?><input type="hidden" name="scheduled_custom_calendar_id" value="<?php echo $this_timeslot['scheduled_custom_calendar_id']; ?>"><?php

															    else:

															        echo '<select name="scheduled_custom_calendar_id">';

															            if (current_user_can('manage_scheduled_options')): echo '<option value="">'.__('Default Calendar','scheduled').'</option>'; endif;

															            foreach($calendars as $calendar):

															                ?><option<?php if ($this_timeslot['scheduled_custom_calendar_id'] == $calendar->term_id): echo ' selected="selected"'; endif; ?> value="<?php echo $calendar->term_id; ?>"><?php echo $calendar->name; ?></option><?php

															            endforeach;

															        echo '</select>';

															    endif;

															else:

															    ?><input type="hidden" name="scheduled_custom_calendar_id" value=""><?php

															endif; ?>

															<input type="text" placeholder="<?php esc_html_e("Start date","scheduled"); ?>..." class="scheduled_custom_start_date" name="scheduled_custom_start_date" value="<?php echo ( $this_timeslot['scheduled_custom_start_date'] ? date_i18n( 'Y-m-d', strtotime( $this_timeslot['scheduled_custom_start_date'] ) ) : '' ); ?>">
															<input type="text" placeholder="<?php esc_html_e("Optional End date","scheduled"); ?>..." class="scheduled_custom_end_date" name="scheduled_custom_end_date" value="<?php echo ( $this_timeslot['scheduled_custom_end_date'] ? date_i18n( 'Y-m-d', strtotime( $this_timeslot['scheduled_custom_end_date'] ) ) : '' ); ?>">

															<?php if (isset($this_timeslot['scheduled_this_custom_timelots']) && is_array($this_timeslot['scheduled_this_custom_timelots'])): ?>
																<input type="hidden" name="scheduled_this_custom_timelots" value="<?php echo esc_attr(json_encode($this_timeslot['scheduled_this_custom_timelots'])); ?>">
															<?php else : ?>
																<input type="hidden" name="scheduled_this_custom_timelots" value="<?php echo esc_attr($this_timeslot['scheduled_this_custom_timelots']); ?>">
															<?php endif; ?>

															<?php if (isset($this_timeslot['scheduled_this_custom_timelots_details']) && is_array($this_timeslot['scheduled_this_custom_timelots_details'])): ?>
																<input type="hidden" name="scheduled_this_custom_timelots_details" value="<?php echo esc_attr(json_encode($this_timeslot['scheduled_this_custom_timelots_details'])); ?>">
															<?php else : ?>
																<input type="hidden" name="scheduled_this_custom_timelots_details" value="<?php echo esc_attr($this_timeslot['scheduled_this_custom_timelots_details']); ?>">
															<?php endif; ?>

															<input id="vacationDayCheckbox" name="vacationDayCheckbox" type="checkbox" value="1"<?php if ($this_timeslot['vacationDayCheckbox']): echo ' checked="checked"'; endif; ?>>
															<label for="vacationDayCheckbox"><?php esc_html_e('Disable appointments','scheduled'); ?></label>

															<a href="#" class="deleteCustomTimeslot"><i class="fa-solid fa-xmark"></i></a>

															<?php

															if (is_array($this_timeslot['scheduled_this_custom_timelots'])):
																$timeslots = $this_timeslot['scheduled_this_custom_timelots'];
															else:
																$timeslots = json_decode($this_timeslot['scheduled_this_custom_timelots'],true);
															endif;

															if (isset($this_timeslot['scheduled_this_custom_timelots_details']) && is_array($this_timeslot['scheduled_this_custom_timelots_details'])):
																$timeslots_details = $this_timeslot['scheduled_this_custom_timelots_details'];
															elseif(isset($this_timeslot['scheduled_this_custom_timelots_details'])):
																$timeslots_details = json_decode($this_timeslot['scheduled_this_custom_timelots_details'],true);
															endif;

															echo '<div class="customTimeslotsList">';

															if (!empty($timeslots)):

																echo '<div class="cts-header"><span class="slotsTitle">'.esc_html__('Spaces Available','scheduled').'</span>'.esc_html__('Time Slot','scheduled').'</div>';

																foreach ($timeslots as $timeslot => $count):

																	$time = explode('-',$timeslot);
																	$time_format = get_option('time_format');

																	echo '<span class="timeslot" data-timeslot="'.$timeslot.'">';
																		echo '<span class="slotsBlock"><span class="changeCount minus" data-count="-1"><i class="fa-solid fa-circle-minus"></i></span><span class="count"><em>'.$count.'</em> ' . _n('Space Available','Spaces Available',$count,'scheduled') . '</span><span class="changeCount add" data-count="1"><i class="fa-solid fa-circle-plus"></i></span></span>';

																		do_action( 'scheduled_single_custom_timeslot_start', $this_timeslot, $timeslot, $this_timeslot['scheduled_custom_calendar_id'] );

																		if ( !empty($timeslots_details[$timeslot]) ) {

																			if ( !empty($timeslots_details[$timeslot]['title']) ) {
																				echo '<span class="title">' . esc_html($timeslots_details[$timeslot]['title']) . '</span>';
																			}
																		}

																		if ($time[0] == '0000' && $time[1] == '2400'):
																			echo '<span class="start"><i class="fa-solid fa-clock"></i>&nbsp;&nbsp;' . strtoupper(esc_html__('All day','scheduled')) . '</span>';
																		else :
																			echo '<span class="start"><i class="fa-solid fa-clock"></i>&nbsp;&nbsp;' . date_i18n($time_format,strtotime('2014-01-01 '.$time[0])) . '</span> &ndash; <span class="end">' . date_i18n($time_format,strtotime('2014-01-01 '.$time[1])) . '</span>';
																		endif;

																		do_action( 'scheduled_single_custom_timeslot_end', $this_timeslot, $timeslot, $this_timeslot['scheduled_custom_calendar_id'] );

																		echo '<span class="delete"><i class="fa-solid fa-xmark"></i></span>';
																	echo '</span>';

																endforeach;
															endif;

															echo '</div>';

															?>

															<button class="button addSingleTimeslot"><?php esc_html_e('+ Single Time Slot','scheduled'); ?></button>
															<button class="button addBulkTimeslots"><?php esc_html_e('+ Bulk Time Slots','scheduled'); ?></button>

														</div><?php

													endforeach;
												endif;

												?>

											</div>
										</div>

										<div class="section-row submit-section scheduledClearFix" style="padding:0;">
											<button class="button addCustomTimeslot"><?php esc_html_e('Add Date(s)','scheduled'); ?></button>
											<input id="scheduled-saveCustomTimeslots" type="button" disabled="true" class="button saveCustomTimeslots" value="<?php esc_html_e('Save Custom Time Slots','scheduled'); ?>">
											<div class="cts-updater savingState"><i class="fa-solid fa-circle-notch fa-spin"></i>&nbsp;&nbsp;<?php esc_html_e('Saving','scheduled'); ?>...</div>
										</div><!-- /.section-row -->

									</form>

									<input type="hidden" style="width:100%;" id="custom_timeslots_encoded" name="custom_timeslots_encoded" value="<?php echo esc_attr($scheduled_custom_timeslots_encoded); ?>">

									<div style="border:1px solid #FFBA00;" class="scheduled-customTimeslotTemplate">

										<?php if (!empty($calendars)):

											echo '<select name="scheduled_custom_calendar_id">';
												if (current_user_can('manage_scheduled_options')): echo '<option value="">'.esc_html__('Default Calendar','scheduled').'</option>'; endif;

												foreach($calendars as $calendar):

													?><option value="<?php echo $calendar->term_id; ?>"><?php echo $calendar->name; ?></option><?php

												endforeach;

											echo '</select>';

										else: ?>

											<input type="hidden" name="scheduled_custom_calendar_id" value="">

										<?php endif; ?>

										<input type="text" placeholder="<?php esc_html_e("Start date","scheduled"); ?>..." class="scheduled_custom_start_date" name="scheduled_custom_start_date" value="">
										<input type="text" placeholder="<?php esc_html_e("Optional End date","scheduled"); ?>..." class="scheduled_custom_end_date" name="scheduled_custom_end_date" value="">
										<input type="hidden" name="scheduled_this_custom_timelots" value="">
										<input type="hidden" name="scheduled_this_custom_timelots_details" value="">

										<input id="vacationDayCheckbox" name="vacationDayCheckbox" type="checkbox" value="1">
										<label for="vacationDayCheckbox"><?php esc_html_e('Disable appointments','scheduled'); ?></label>

										<a href="#" class="deleteCustomTimeslot"><i class="fa-solid fa-xmark"></i></a>

										<div class="customTimeslotsList"></div>

										<button class="button addSingleTimeslot"><?php esc_html_e('+ Single Time Slot','scheduled'); ?></button>
										<button class="button addBulkTimeslots"><?php esc_html_e('+ Bulk Time Slots','scheduled'); ?></button>

									</div>

									<div id="scheduled-customTimePickerTemplates">
										<div class="customSingle scheduledClearFix">
											<?php echo scheduled_render_single_timeslot_form($timeslot_intervals,'custom'); ?>
											<button class="button-primary addSingleTimeslot_button"><?php esc_html_e('Add','scheduled'); ?></button>
											<button class="button cancel"><?php esc_html_e('Close','scheduled'); ?></button>
										</div>
										<div class="customBulk scheduledClearFix">
											<?php echo scheduled_render_bulk_timeslot_form($timeslot_intervals,'custom'); ?>
											<button class="button-primary addBulkTimeslots_button"><?php esc_html_e('Add','scheduled'); ?></button>
											<button class="button cancel"><?php esc_html_e('Close','scheduled'); ?></button>
										</div>
									</div>

								</div>

							<?php break;

							case 'custom-fields': ?>

								<div id="scheduled-custom-fields" class="tab-content">

									<div class="section-row">
										<div class="section-head">

											<div class="scheduled-cf-block">

												<?php if (!empty($calendars)):

													echo '<div id="scheduled-cfSwitcher" style="margin:0 0 30px;">';
														echo '<select name="scheduledCustomFieldsDisplayed">';

															if (current_user_can('manage_scheduled_options')): echo '<option value="">'.esc_html__('Default Calendar','scheduled').'</option>'; endif;

															foreach($calendars as $calendar):

																?><option value="<?php echo $calendar->term_id; ?>"><?php echo $calendar->name; ?></option><?php

															endforeach;

														echo '</select>';
													echo '</div>';

												endif; ?>

												<div id="scheduled_customFields_Wrap">

													<?php if (current_user_can('manage_scheduled_options')):
														scheduled_render_custom_fields();
													else:
														$first_calendar = reset($calendars);
														scheduled_render_custom_fields($first_calendar->term_id);
													endif; ?>

												</div>

											</div>

											<ul id="scheduled-cf-sortable-templates">

												<li id="scheduledCFTemplate-single-line-text-label" class="ui-state-default"><i class="main-handle fa-solid fa-bars"></i>
													<small><?php esc_html_e('Single Line Text','scheduled'); ?></small>
													<p><input class="cf-required-checkbox" type="checkbox" name="required" id="required"> <label for="required"><?php esc_html_e('Required Field','scheduled'); ?></label></p>
													<input type="text" name="single-line-text-label" value="" placeholder="<?php esc_html_e('Enter a label for this field...','scheduled'); ?>" />
													<span class="cf-delete"><i class="fa-solid fa-trash-can"></i></span>
												</li>
												<li id="scheduledCFTemplate-paragraph-text-label" class="ui-state-default"><i class="main-handle fa-solid fa-bars"></i>
													<small><?php esc_html_e('Paragraph Text','scheduled'); ?></small>
													<p><input class="cf-required-checkbox" type="checkbox" name="required" id="required"> <label for="required"><?php esc_html_e('Required Field','scheduled'); ?></label></p>
													<input type="text" name="paragraph-text-label" value="" placeholder="<?php esc_html_e('Enter a label for this field...','scheduled'); ?>" />
													<span class="cf-delete"><i class="fa-solid fa-trash-can"></i></span>
												</li>
												<li id="scheduledCFTemplate-checkboxes-label" class="ui-state-default"><i class="main-handle fa-solid fa-bars"></i>
													<small><?php esc_html_e('Checkboxes','scheduled'); ?></small>
													<p><input class="cf-required-checkbox" type="checkbox" name="required" id="required"> <label for="required"><?php esc_html_e('Required Field','scheduled'); ?></label></p>
													<input type="text" name="checkboxes-label" value="" placeholder="<?php esc_html_e('Enter a label for this checkbox group...','scheduled'); ?>" />
													<ul id="scheduled-cf-checkboxes"></ul>
													<button class="cfButton button" data-type="single-checkbox">+ <?php esc_html_e('Checkbox','scheduled'); ?></button>
													<span class="cf-delete"><i class="fa-solid fa-trash-can"></i></span>
												</li>
												<li id="scheduledCFTemplate-radio-buttons-label" class="ui-state-default"><i class="main-handle fa-solid fa-bars"></i>
													<small><?php esc_html_e('Radio Buttons','scheduled'); ?></small>
													<p><input class="cf-required-checkbox" type="checkbox" name="required" id="required"> <label for="required"><?php esc_html_e('Required Field','scheduled'); ?></label></p>
													<input type="text" name="radio-buttons-label" value="" placeholder="<?php esc_html_e('Enter a label for this radio button group...','scheduled'); ?>" />
													<ul id="scheduled-cf-radio-buttons"></ul>
													<button class="cfButton button" data-type="single-radio-button">+ <?php esc_html_e('Option','scheduled'); ?></button>
													<span class="cf-delete"><i class="fa-solid fa-trash-can"></i></span>
												</li>
												<li id="scheduledCFTemplate-drop-down-label" class="ui-state-default"><i class="main-handle fa-solid fa-bars"></i>
													<small><?php esc_html_e('Drop Down','scheduled'); ?></small>
													<p><input class="cf-required-checkbox" type="checkbox" name="required" id="required"> <label for="required"><?php esc_html_e('Required Field','scheduled'); ?></label></p>
													<input type="text" name="drop-down-label" value="" placeholder="<?php esc_html_e('Enter a label for this drop-down group...','scheduled'); ?>" />
													<ul id="scheduled-cf-drop-down"></ul>
													<button class="cfButton button" data-type="single-drop-down">+ <?php esc_html_e('Option','scheduled'); ?></button>
													<span class="cf-delete"><i class="fa-solid fa-trash-can"></i></span>
												</li>
												<li id="scheduledCFTemplate-plain-text-content" class="ui-state-default"><i class="main-handle fa-solid fa-bars"></i>
													<small><?php esc_html_e('Text Content','scheduled'); ?></small>
													<textarea name="plain-text-content"></textarea>
													<small class="help-text"><?php esc_html_e('HTML allowed','scheduled'); ?></small>
													<span class="cf-delete"><i class="fa-solid fa-trash-can"></i></span>
												</li>

												<li id="scheduledCFTemplate-single-checkbox" class="ui-state-default "><i class="sub-handle fa-solid fa-bars"></i>
													<?php do_action('scheduled_before_custom_checkbox'); ?>
													<input type="text" name="single-checkbox" value="" placeholder="<?php esc_html_e('Enter a label for this checkbox...','scheduled'); ?>" />
													<span class="cf-delete"><i class="fa-solid fa-trash-can"></i></span>
													<?php do_action('scheduled_after_custom_checkbox'); ?>
												</li>
												<li id="scheduledCFTemplate-single-radio-button" class="ui-state-default "><i class="sub-handle fa-solid fa-bars"></i>
													<input type="text" name="single-radio-button" value="" placeholder="<?php esc_html_e('Enter a label for this radio button...','scheduled'); ?>" />
													<span class="cf-delete"><i class="fa-solid fa-trash-can"></i></span>
												</li>
												<li id="scheduledCFTemplate-single-drop-down" class="ui-state-default "><i class="sub-handle fa-solid fa-bars"></i>
													<input type="text" name="single-drop-down" value="" placeholder="<?php esc_html_e('Enter a label for this option...','scheduled'); ?>" />
													<span class="cf-delete"><i class="fa-solid fa-trash-can"></i></span>
												</li>

												<?php do_action('scheduled_custom_fields_add_template') ?>
											</ul>

										</div>
									</div>

									<input id="scheduled_custom_fields" name="scheduled_custom_fields" value="" type="hidden" class="field" style="width:100%;">

									<div class="section-row submit-section scheduledClearFix" style="padding:0;">
										<input id="scheduled-cf-saveButton" type="button" class="button button-primary" value="<?php esc_html_e('Save Custom Fields','scheduled'); ?>">
										<div class="cf-updater savingState"><i class="fa-solid fa-circle-notch fa-spin"></i>&nbsp;&nbsp;<?php esc_html_e('Saving','scheduled'); ?>...</div>
									</div><!-- /.section-row -->

								</div><!-- /templates -->

							<?php break;

							case 'shortcodes': ?>

								<div id="scheduled-shortcodes" class="tab-content">

									<div class="section-row" style="margin-bottom:-50px;">
										<div class="section-head">

											<h3><?php echo esc_html__('Display the Default Calendar', 'scheduled'); ?></h3>
											<p><?php esc_html_e('You can use this shortcode to display the front-end booking calendar. Use the "calendar" attribute to display a specific calendar. Use the "year" and/or "month" attributes to display a specific month and/or year. You can also use the "switcher" variable to add a calendar switcher dropdown above the calendar. Your users can then switch between each calendar you\'ve created.','scheduled'); ?></p>
											<p><input value="[scheduled-calendar]" type="text" readonly="readonly" class="field"></p>

										</div>

										<?php

										if (!empty($calendars)):

											?><div class="section-head">
												<h3><?php echo esc_html__('Display a Custom Calendar', 'scheduled'); ?></h3>
												<p style="margin:0 0 10px;">&nbsp;</p><?php

												foreach($calendars as $calendar):

													?><p style="margin:0 0 10px;"><strong style="font-size:14px;"><?php echo $calendar->name; ?></strong></p>
													<input value="[scheduled-calendar calendar=<?php echo $calendar->term_id; ?>]" readonly="readonly" type="text"class="field"><?php

												endforeach;

											?></div><?php

										endif;

										?>

										<div class="section-head">

											<h3><?php echo esc_html__('Display the Login / Register Form', 'scheduled'); ?></h3>
											<p><?php esc_html_e("If the Registration tab doesn't show up, be sure to allow registrations from the Settings > General page.","scheduled"); ?></p>
											<p><input value="[scheduled-login]" type="text" readonly="readonly" class="field"></p>

										</div>

										<div class="section-head">

											<h3><?php echo esc_html__('Display User Profile', 'scheduled'); ?></h3>
											<p><?php esc_html_e("You can use this shortcode to display the profile content on any page. If a user is not logged in, they will see the login form instead.","scheduled"); ?></p>
											<p><input value="[scheduled-profile]" type="text" readonly="readonly" class="field"></p>

										</div>

										<div class="section-head">

											<h3><?php echo esc_html__("Display User's Appointments", 'scheduled'); ?></h3>
											<p><?php esc_html_e("You can use this shortcode to display just the currently logged in user's upcoming appointments.","scheduled"); ?></p>
											<p><input value="[scheduled-appointments]" type="text" readonly="readonly" class="field"></p>

										</div>

									</div>

								</div>


							<?php break;

							case 'export-appointments': ?>

								<form action="" class="scheduled-export-form" method="post">

									<div id="scheduled-export-appointments" class="tab-content">

										<div class="section-row">
											<div class="section-head">
												<h3><?php esc_html_e('Export Appointments','scheduled'); ?></h3>
												<p><?php esc_html_e('You can export all appointments or specify what you want by choosing from the below options.','scheduled'); ?></p>
												<br>
												<div class="select-box">
													<label class="scheduled-color-label" for="appointment_time"><?php esc_html_e('Appointment Dates','scheduled'); ?>:</label>
													<select name="appointment_time">
														<option value="" selected="selected"><?php esc_html_e('Upcoming & Past','scheduled'); ?></option>
														<option value="upcoming"><?php esc_html_e('Only Upcoming','scheduled'); ?></option>
														<option value="past"><?php esc_html_e('Only Past','scheduled'); ?></option>
													</select>
												</div>

												<br>
												<div class="select-box">
													<label class="scheduled-color-label" for="appointment_type"><?php esc_html_e('Approved and/or Pending','scheduled'); ?>:</label>
													<select name="appointment_type">
														<option value="any" selected="selected"><?php esc_html_e('Approved & Pending','scheduled'); ?></option>
														<option value="publish"><?php esc_html_e('Only Approved','scheduled'); ?></option>
														<option value="draft"><?php esc_html_e('Only Pending','scheduled'); ?></option>
													</select>
												</div>

												<?php if (!empty($calendars)): ?>

													<br>
													<div class="select-box">
														<label class="scheduled-color-label" for="calendar_id"><?php esc_html_e('Calendar','scheduled'); ?>:</label>
														<select name="calendar_id">
															<option value="" selected="selected"><?php esc_html_e('All Calendars','scheduled'); ?></option>
															<?php
															foreach($calendars as $calendar):
																?><option value="<?php echo $calendar->term_id; ?>"><?php echo $calendar->name; ?></option><?php
															endforeach;
															?>
														</select>
													</div>

												<?php endif; ?>

											</div>
										</div>

										<div class="section-row submit-section" style="padding:0;">
											<p class="submit">
												<button class="button-primary"><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;<?php esc_html_e('Export Appointments to CSV','scheduled'); ?></button>
											</p>
										</div>

									</div>

									<input type="hidden" name="scheduled_export_appointments_csv" value="1">

								</form>

							<?php break;

						endswitch;

					endif;

				endforeach;

				?>

			</div>

		</div>

	<?php endif; ?>

	</div>
</div>