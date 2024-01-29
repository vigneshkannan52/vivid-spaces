<?php

$bookings = array();

if ( ! empty( $_POST['calendars'] ) ) {
	$bookings = $_POST['calendars'];
} else {
	$calendar_id = isset( $_POST['calendar_id'] ) ? intval( $_POST['calendar_id'] ) : false;
	$bookings[ $calendar_id ][] = array(
		'date' => isset( $_POST['date'] ) ? esc_html( $_POST['date'] ) : '',
        'title' => isset( $_POST['title'] ) ? esc_html( $_POST['title'] ) : '',
        'timeslot' => isset( $_POST['timeslot'] ) ? esc_html( $_POST['timeslot'] ) : '',
        'calendar_id' => $calendar_id,
	);
}

// allow other addons to modify the appointments booking list and filter those if necessary
$bookings = apply_filters( 'scheduled_fe_appt_form_bookings', $bookings );

// this must be False, if a plugin or script has already checked it while filtering the appointments with 'scheduled_fe_appt_form_bookings'
$check_availability = apply_filters( 'scheduled_fe_appt_form_check_availability', true );

// count the appointments
$total_appts = 0;
$total_calendars = count( $bookings );
foreach ( $bookings as $calendar_id => $appointments ) {
	$total_appts += count( $appointments );
}

$has_appts = ! empty( $bookings );
$availability_error = esc_html__( "Sorry, someone just scheduled this appointment before you could. Please choose a different booking time.", "scheduled" );
?>
<div class="scheduled-form scheduled-scrollable">

	<?php

	// If there are appointments, show the form
	if ( $has_appts ) {
		include(SCHEDULED_AJAX_INCLUDES_DIR . 'front/appointment-form/form.php');
	}

	// there are no available appointments
	// probably some of them have been already scheduled and removed by an add on
	if ( ! $has_appts ) {
		echo wpautop( $availability_error  );
	}

	?>

</div>

<?php $new_appointment_default = get_option('scheduled_new_appointment_default','draft'); ?>

<p class="scheduled-title-bar"><small><?php echo ( $new_appointment_default == 'draft' ? esc_html__('Request an Appointment','scheduled') : esc_html__('Book an Appointment','scheduled') ); ?></small></p>

<?php echo '<a href="#" class="close"><i class="fa-solid fa-xmark"></i></a>';
