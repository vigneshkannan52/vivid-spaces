<?php

$timestamp = get_post_meta($appt_id,'_appointment_timestamp',true);
$timeslot = get_post_meta($appt_id,'_appointment_timeslot',true);
$timeslots = explode('-',$timeslot);
$timestamp_start = strtotime(date_i18n('Y-m-d',$timestamp).' '.$timeslots[0]);
$current_timestamp = current_time('timestamp');

// Send an email to the user?
if ( $timestamp_start >= $current_timestamp ):
	
	$email_content = get_option('scheduled_cancellation_email_content');
	$email_subject = get_option('scheduled_cancellation_email_subject');

	if ($email_content && $email_subject):

		$token_replacements = scheduled_get_appointment_tokens( $appt_id );
		$email_content = scheduled_token_replacement( $email_content,$token_replacements );
		$email_subject = scheduled_token_replacement( $email_subject,$token_replacements );

		do_action( 'scheduled_cancellation_email', $token_replacements['email'], $email_subject, $email_content );
		
	endif;
	
endif;

do_action( 'scheduled_appointment_cancelled', $appt_id );
wp_delete_post( $appt_id, true );