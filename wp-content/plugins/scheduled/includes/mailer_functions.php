<?php

$scheduled_mailer_actions = apply_filters( 'scheduled_mailer_actions', array(
	'scheduled_confirmation_email',
	'scheduled_admin_confirmation_email',
	'scheduled_reminder_email',
	'scheduled_admin_reminder_email',
	'scheduled_cancellation_email',
	'scheduled_admin_cancellation_email',
	'scheduled_approved_email',
	'scheduled_registration_email'
));

foreach( $scheduled_mailer_actions as $action ):
	add_action( $action, 'scheduled_mailer', 10, 5 );
endforeach;

function scheduled_mailer_tokens(){
	return apply_filters( 'scheduled_mailer_tokens', array(
		'name' => esc_html__( "Display the full name of the customer.","scheduled" ),
		'email' => esc_html__( "Display the customer's email address.","scheduled" ),
		'title' => esc_html__( "Display the title of the appointment's time slot.","scheduled" ),
		'calendar' => esc_html__( "Display the appointment's calendar name (if applicable).","scheduled" ),
		'date' => esc_html__( "Display the appointment date.","scheduled" ),
		'time' => esc_html__( "Display the appointment time.","scheduled" ),
		'customfields' => esc_html__( "Display the appointment's custom field data.","scheduled" ),
		'id' => esc_html__( "Display the appointment's unique identification number.","scheduled" ),
	));
}

function scheduled_user_tokens(){
	return apply_filters( 'scheduled_user_tokens', array(
		'name' => esc_html__( "Display the customer's name.","scheduled" ),
		'username' => esc_html__( "Display the customer's username.","scheduled" ),
		'password' => esc_html__( "Display the customer's password.","scheduled" ),
		'email' => esc_html__( "Display the customer's email address.","scheduled" )
	));
}

function scheduled_token_replacement( $content, $replacements, $type = 'appointment' ){

	if ( $type == 'appointment' ):
		$scheduled_tokens = scheduled_mailer_tokens();
	elseif ( $type == 'user' ):
		$scheduled_tokens = scheduled_user_tokens();
	else:
		return $content;
	endif;

	$needles = array(); $rep_with = array();

	foreach( $scheduled_tokens as $token => $desc ):
		if ( isset($replacements[$token]) ):
			$needles[] = '%' . $token . '%';
			$rep_with[] = $replacements[$token];
		endif;
	endforeach;

	$content = htmlentities( str_replace( $needles, $rep_with, $content ), ENT_QUOTES | ENT_IGNORE, "UTF-8" );
	$content = html_entity_decode( $content, ENT_QUOTES | ENT_IGNORE, "UTF-8" );

	return $content;

}

function scheduled_get_appointment_tokens( $appt_id ){

	// Name & Email
	// $customer_name
	// $email
	if ( $first_name = get_post_meta( $appt_id, '_appointment_guest_name', true ) ):
		$last_name = get_post_meta( $appt_id, '_appointment_guest_surname', true );
		$customer_name = ( $last_name ? $first_name . ' ' . $last_name : $first_name );
		$customer_email = get_post_meta( $appt_id, '_appointment_guest_email', true );
	else:
		$_appt = get_post( $appt_id );
		$appt_author = $_appt->post_author;
		$_user = get_userdata( $appt_author );
		$customer_name = scheduled_get_name( $appt_author );
		$customer_email = $_user->user_email;
	endif;

	// Calendar Name
	// $calendar_name
	$calendars = get_the_terms( $appt_id, 'scheduled_custom_calendars' );
	if ( !empty($calendars) ):
		foreach( $calendars as $calendar ):
			$calendar_id = $calendar->term_id;
			$calendar_term = get_term_by( 'id', $calendar_id, 'scheduled_custom_calendars' );
			$calendar_name = $calendar_term->name;
			break;
		endforeach;
	else:
		$calendar_name = '';
	endif;

	// Date
	// $date_text
	$date_format = get_option( 'date_format' );
	$timestamp = get_post_meta( $appt_id, '_appointment_timestamp', true);
	$date_text = date_i18n( $date_format,$timestamp );

	// Time
	// $time_text
	$timeslot = get_post_meta( $appt_id, '_appointment_timeslot', true );
	$timeslots = explode( '-', $timeslot );
	$time_format = get_option( 'time_format' );
	$hide_end_times = get_option( 'scheduled_hide_end_times', false );
	$timestamp_start = strtotime( date_i18n( 'Y-m-d', $timestamp) . ' ' . $timeslots[0] );
	$timestamp_end = strtotime( date_i18n( 'Y-m-d', $timestamp) . ' ' . $timeslots[1] );
	if ($timeslots[0] == '0000' && $timeslots[1] == '2400'):
		$time_text = esc_html__( 'All day', 'scheduled' );
	else :
		$time_text = date_i18n( $time_format, $timestamp_start ) . ( !$hide_end_times ? '&ndash;' . date_i18n( $time_format, $timestamp_end ) : '' );
	endif;

	$time_text = apply_filters( 'scheduled_emailed_timeslot_text', $time_text, $timestamp_start, $timeslot, $calendar_id );

	// Custom Fields
	// $custom_fields
	$custom_fields = get_post_meta( $appt_id, '_cf_meta_value', true);

	// Title
	// $title
	$title = get_post_meta( $appt_id, '_appointment_title', true );

	return apply_filters( 'scheduled_appointment_tokens', array(
		'name' => $customer_name,
		'date' => $date_text,
		'time' => $time_text,
		'customfields' => $custom_fields,
		'calendar' => $calendar_name,
		'email' => $customer_email,
		'title' => $title,
		'id' => $appt_id
	));

}

function scheduled_mailer( $to = false, $subject='', $message='', $from_email = false, $from_name = false ){

	if ( !$to )
		return false;

	add_filter( 'wp_mail_content_type', 'scheduled_set_html_content_type' );

	$scheduled_email_logo = get_option('scheduled_email_logo');
	if ($scheduled_email_logo):
		$logo = apply_filters( 'scheduled_email_logo_html', '<img src="'.$scheduled_email_logo.'" style="max-width:100%; height:auto; display:block; margin:10px 0 20px;">' );
	else :
		$logo = apply_filters( 'scheduled_email_logo_html', '' );
	endif;

	$link_color = get_option('scheduled_button_color','#56C477');
	$force_sender = get_option('scheduled_email_force_sender',false);
	$disable_scheduled_mailer = get_option('scheduled_emailer_disabled',false);

	if ( $disable_scheduled_mailer ):
		$from_email = false;
		$from_name = false;
	elseif ( $force_sender ):
		$admin_email = get_option( 'admin_email' );
		$from_email = get_option( 'scheduled_email_force_sender_from', $admin_email );
		$from_name = false;
	endif;

	if ( file_exists( get_stylesheet_directory() . '/scheduled/email-template.html' ) ):
		$template = file_get_contents( get_stylesheet_directory() . '/scheduled/email-template.html', true );
	elseif ( file_exists( get_template_directory() . '/scheduled/email-template.html' ) ):
		$template = file_get_contents( get_template_directory() . '/scheduled/email-template.html', true );
	else:
		$template = file_get_contents( untrailingslashit( SCHEDULED_PLUGIN_DIR ) . '/includes/email-templates/default.html', true );
	endif;

	$filter = array('%content%','%logo%','%link_color%');
	$replace = array(wpautop($message),$logo,$link_color);
	if ( $from_email ):
		$headers[] = 'From: ' . ( $from_name ? $from_name . ' <' . $from_email . '>' : $from_email );
	endif;
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	$message = str_replace($filter, $replace, $template);

	wp_mail( $to,$subject,$message,$headers );

	remove_filter( 'wp_mail_content_type', 'scheduled_set_html_content_type' );

}

function scheduled_set_html_content_type() {
	return 'text/html';
}
