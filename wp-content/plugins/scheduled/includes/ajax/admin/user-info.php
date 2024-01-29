<?php

echo '<div class="scheduled-scrollable">';

	echo '<p class="scheduled-title-bar"><small>'.esc_html__('Edit Appointment','scheduled').'</small></p>';

	$appt_id = ( isset($_POST['appt_id']) ? esc_html( $_POST['appt_id'] ) : false );

	?><form action="" method="post" class="scheduled-form" id="editAppointmentForm" data-appt-id="<?php echo $appt_id; ?>"<?php if ($calendar_id): echo ' data-calendar-id="'.$calendar_id.'"'; endif; ?>><?php
		
		wp_nonce_field( 'ajax-admin-edit-appt-nonce', 'nonce' );

		$calendars = get_the_terms( $appt_id, 'scheduled_custom_calendars' );
		if ( !empty($calendars) ):
			foreach( $calendars as $calendar ):
				$calendar_id = $calendar->term_id;
			endforeach;
		else:
			$calendar_id = false;
		endif;

		$_appt = get_post( $appt_id );
		$user_id = ( isset($_POST['user_id']) ? esc_html( $_POST['user_id'] ) : false );

		if ( $appt_id ):

			?><p class="scheduled-calendar-name"><?php esc_html_e( 'Appointment Date/Time', 'scheduled' ); ?></p><?php

			// Appointment Information
			$time_format = get_option('time_format');
			$date_format = get_option('date_format');

			$timestamp = get_post_meta($appt_id, '_appointment_timestamp',true);

			$timeslot = get_post_meta($appt_id, '_appointment_timeslot',true);
			$cf_meta_value = get_post_meta($appt_id, '_cf_meta_value',true);

			$date_display = date_i18n($date_format,$timestamp);
			$day_name = date_i18n('l',$timestamp);

			$timeslots = explode('-',$timeslot);
			$time_start = date_i18n($time_format,strtotime($timeslots[0]));
			$time_end = date_i18n($time_format,strtotime($timeslots[1]));

			if ($timeslots[0] == '0000' && $timeslots[1] == '2400'):
				$timeslotText = esc_html__('All day','scheduled');
			else :
				$timeslotText = $time_start.' '.esc_html__('to','scheduled').' '.$time_end;
			endif;

			$year = date_i18n( 'Y', $timestamp );
			$month = date_i18n( 'm', $timestamp );
			$day = date_i18n( 'd', $timestamp );
			$full_date = date_i18n( 'Y-m-d', $timestamp );

			echo '<div class="field">';
				echo '<i class="fa-solid fa-calendar-days" style="font-size:1.2em; position:relative; top:-1px;"></i>&nbsp;&nbsp;<span class="scheduled_appt_date-formatted">' . date_i18n( $date_format, $timestamp ) . '</span>';
				echo '<input type="hidden" placeholder="Date..." class="large textfield scheduled_appt_date" name="appt_date" value="' . date_i18n( 'Y-m-d', $timestamp ) . '">';
			echo '</div>';
			echo '<div class="field timeslots-select-field">';
				scheduled_timeslots_select( $appt_id, $year, $month, $day );
			echo '</div>';

			echo '<hr>';

			?><p class="scheduled-calendar-name"><?php esc_html_e( 'Customer Information', 'scheduled' ); ?></p><?php

			if ( !$user_id ):

				$first_name = get_post_meta($appt_id, '_appointment_guest_name',true);
				$last_name = get_post_meta($appt_id, '_appointment_guest_surname',true);
				$customer_email = get_post_meta($appt_id, '_appointment_guest_email',true);

			else :

				// Customer Information
				$user_info = get_userdata($user_id);
				$first_name = scheduled_get_name($user_id,'first');
				$last_name = scheduled_get_name($user_id,'last');
				$customer_email = $user_info->user_email;
				$customer_phone = get_user_meta($user_id, 'scheduled_phone', true);

			endif;

			$name_requirements = get_option('scheduled_registration_name_requirements',array('require_name'));

			if (isset($name_requirements[0]) && $name_requirements[0] == 'require_surname'): ?>
				<div class="field">
					<input value="<?php echo $first_name; ?>" placeholder="<?php esc_html_e('First Name','scheduled'); ?>..." type="text" class="textfield" name="name"<?php if ( $user_id && user_can( $user_id, 'manage_options' ) ):
						echo ' readonly="true"';
					endif; ?> />
					<input value="<?php echo $last_name; ?>" placeholder="<?php esc_html_e('Last Name','scheduled'); ?>..." type="text" class="textfield" name="surname"<?php if ( $user_id && user_can( $user_id, 'manage_options' ) ):
						echo ' readonly="true"';
					endif; ?> />
				</div>
			<?php else: ?>
				<div class="field">
					<input
						value="<?php echo $first_name . ( $last_name ? ' ' . $last_name : '' ); ?>"
						placeholder="<?php esc_html_e('Name','scheduled'); ?>..."
						type="text"
						class="large textfield"
						name="name"<?php
						if ( $user_id && user_can( $user_id, 'manage_options' ) ):
							echo ' readonly="true"';
						endif;
					?> />
				</div>
			<?php endif;

			if ($customer_email):
				?><div class="field">
					<input
						value="<?php echo $customer_email; ?>"
						placeholder="<?php esc_html_e('Email Address','scheduled'); ?>..."
						type="email"
						class="large textfield"
						name="email"<?php
						if ( $user_id && user_can( $user_id, 'manage_options' ) ):
							echo ' readonly="true"';
						endif;
					?> />
				</div><?php
			endif;

			if ($customer_phone):
				?><div class="field">
					<input value="<?php echo $customer_phone; ?>" placeholder="<?php esc_html_e('Phone Number','scheduled'); ?>..." type="tel" class="large textfield" name="phone"<?php
						if ( $user_id && user_can( $user_id, 'manage_options' ) ):
							echo ' readonly="true"';
						endif;
					?> />
				</div><?php
			endif;

			if ( $cf_meta_value ):
			
				echo '<hr />';
	
				?><p class="scheduled-calendar-name"><?php esc_html_e( 'Appointment Information', 'scheduled' ); ?></p><?php
	
				do_action('scheduled_before_appointment_information_admin');
				echo ( $cf_meta_value ? '<div class="cf-meta-values">'.$cf_meta_value.'</div>' : '');
				do_action('scheduled_after_appointment_information_admin');
				
			endif;

			echo '<hr />';

			?><input type="hidden" name="action" value="scheduled_admin_edit_appt" />
			<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
			<input type="hidden" name="appt_id" value="<?php echo $appt_id; ?>" />
			<input type="hidden" name="calendar_id" value="<?php echo $calendar_id; ?>" /><?php

			?><div class="field">
				<input type="submit" class="button button-primary" value="<?php esc_html_e('Update Appointment','scheduled'); ?>">
			</div><?php

		endif;

	?></form><?php

echo '</div>';

// Close button
echo '<a href="#" class="close"><i class="fa-solid fa-xmark"></i></a>';
