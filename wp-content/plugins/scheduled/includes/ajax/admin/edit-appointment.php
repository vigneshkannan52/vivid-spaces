<?php

do_action('scheduled_before_editing_appointment');

$appt_id = isset($_POST['appt_id']) ? $_POST['appt_id'] : '';
$date = isset($_POST['appt_date']) ? $_POST['appt_date'] : '';
$timeslot = isset($_POST['appt_timeslot']) ? $_POST['appt_timeslot'] : '';
$first_name = isset($_POST['name']) ? $_POST['name'] : '';
$last_name = isset($_POST['surname']) ? $_POST['surname'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$user_id = (isset($_POST['user_id']) ? $_POST['user_id'] : false);
$calendar_id = (isset($_POST['calendar_id']) ? $_POST['calendar_id'] : false);

$_timeslots = explode( '-', $timeslot );
$_timestamp_time = date( 'H:i:s', strtotime( $_timeslots[0] ) );

if ( $appt_id ):

	if ( $email && !is_email($email) ):
		echo 'error###' . esc_html__( 'That email does not appear to be valid.','scheduled');
		wp_die();
	endif;

	if ($calendar_id):
		$scheduled_defaults = get_option('scheduled_defaults_'.$calendar_id);
		if (!$scheduled_defaults):
			$scheduled_defaults = get_option('scheduled_defaults');
		endif;
	else :
		$scheduled_defaults = get_option('scheduled_defaults');
	endif;

	$scheduled_defaults = scheduled_apply_custom_timeslots_filter($scheduled_defaults,$calendar_id);

	$timestamp = strtotime( date_i18n('Y-m-d', strtotime($date) ) . ' ' . $_timestamp_time );
	$day = date('D',strtotime($date));
	$title = isset($scheduled_defaults[$day.'-details'][$timeslot]['title']) ? $scheduled_defaults[$day.'-details'][$timeslot]['title'] : '';

	if ( !$user_id ):

		update_post_meta( $appt_id, '_appointment_title', $title );
		update_post_meta( $appt_id, '_appointment_guest_name', $first_name );
		update_post_meta( $appt_id, '_appointment_guest_surname', $last_name );
		update_post_meta( $appt_id, '_appointment_guest_email', $email );
		update_post_meta( $appt_id, '_appointment_timestamp', $timestamp );
		update_post_meta( $appt_id, '_appointment_timeslot', $timeslot );

	else:

		update_post_meta( $appt_id, '_appointment_title', $title );
		update_post_meta( $appt_id, '_appointment_phone', $phone );
		update_post_meta( $appt_id, '_appointment_timestamp', $timestamp );
		update_post_meta( $appt_id, '_appointment_timeslot', $timeslot );

		if ( !user_can( $user_id, 'manage_options' ) ):
			update_user_meta( $user_id, 'scheduled_phone', $phone );
			wp_update_user( array( 'ID' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name, 'user_email' => $email, 'user_login' => $email, 'display_name' => $first_name . ( $last_name ? ' ' . $last_name : '' ) ) );
		endif;

	endif;

endif;
