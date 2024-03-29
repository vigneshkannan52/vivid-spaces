<?php

$appt_id = intval($appt_id);
$appointment = Scheduled_WC_Appointment::get($appt_id);
$post_status = $appointment->post->post_status;
$awaiting_status = SCHEDULED_WC_PLUGIN_PREFIX . 'awaiting';

if ( !$appointment->order_id || $appointment->order_id == 'manual' ): ?>

	<a href="#" class="delete" <?php echo $calendar_id ? ' data-calendar-id="'.$calendar_id.'"' : '' ?> ><i class="fa-solid fa-xmark"></i></a>

<?php endif; ?>

<?php if ($post_status != 'publish' && $post_status != 'future'): ?>
	<button data-appt-id="<?php echo $appt_id ?>" class="approve button button-primary"><?php echo __('Approve Appointment', 'scheduled') ?></button>
<?php endif; ?>

<?php if ( !$appointment->is_paid ): ?>

	<span class="scheduled-wc_status-text awaiting">
		<?php
		if ( $appointment->order_id ) {

			if (current_user_can('manage_scheduled_options')) :
				echo '<button data-appt-id="'.$appt_id.'" class="mark-paid button">'.__('Mark as Paid', 'scheduled').'</button>';
				echo '<a target="_blank" href="' . admin_url('/post.php?post=' . $appointment->order_id . '&action=edit') . '">' . $appointment->payment_status_text . '</a>';
			else :
				echo '<span>' . $appointment->payment_status_text . '</span>';
			endif;

		} else {

			if (current_user_can('manage_scheduled_options')) :
				echo '<button data-appt-id="'.$appt_id.'" class="mark-paid button">'.__('Mark as Paid', 'scheduled').'</button>';
			endif;
			echo '<span>' . __('Awaiting Payment', 'scheduled') . '</span>';

		}
		?>
	</span>

<?php else:

	echo '<span class="scheduled-wc_status-text paid">';

		if (current_user_can('manage_scheduled_options') && $appointment->order_id != 'manual') :
			echo '<a target="_blank" href="' . admin_url('/post.php?post=' . $appointment->order_id . '&action=edit') . '"><i class="fa-solid fa-pencil"></i>&nbsp;&nbsp;' . __('Paid', 'scheduled') . '</a>';
		else :
			echo '<span>' . __('Paid', 'scheduled') . '</span>';
		endif;

	echo '</span>';

endif;
