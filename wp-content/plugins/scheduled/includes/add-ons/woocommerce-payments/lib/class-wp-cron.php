<?php
// https://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules
add_filter('cron_schedules', array('Scheduled_WC_WP_Crons', 'cron_schedules'));

class Scheduled_WC_WP_Crons {

	private function __construct() {

		if ( Scheduled_WC_Settings::get_option('enable_auto_cleanup') === 'enable' ) {
			$this->activate_scheduler();
		}
	}

	public static function setup(){
		return new self();
	}

	public static function cron_schedules( $schedules ) {
		$schedules['weekly'] = array(
			'interval' => 60 * 60 * 24 * 7,
			'display' => __('Weekly', 'scheduled')
		);

		$schedules['twiceweekly'] = array(
			'interval' => 60 * 60 * 24 * 3.5,
			'display' => __('Twice Weekly', 'scheduled')
		);

		$schedules['monthly'] = array(
			'interval' => 60 * 60 * 24 * 30.5,
			'display' => __('Monthly', 'scheduled')
		);

		$schedules['twicemonthly'] = array(
			'interval' => 60 * 60 * 24 * 15,
			'display' => __('Twice Monthly', 'scheduled')
		);

		$schedules['twicehourly'] = array(
			'interval' => 60 * 30,
			'display' => __('Every 30 Minutes', 'scheduled')
		);

		$schedules['everyfifteen'] = array(
			'interval' => 60 * 15,
			'display' => __('Every 15 Minutes', 'scheduled')
		);

		$schedules['everyfive'] = array(
			'interval' => 60 * 5,
			'display' => __('Every 5 Minutes', 'scheduled')
		);

		return $schedules;
	}

	protected function activate_scheduler() {
		$mode = Scheduled_WC_Settings::get_option('cleanup_mode');

		$recurrence = $mode;
		$schedule_name = SCHEDULED_WC_PLUGIN_PREFIX . 'cron_' . $recurrence;

		if ($recurrence && !wp_next_scheduled( $schedule_name) ) {
			wp_schedule_event(time(), $recurrence, $schedule_name);
		}

		add_action($schedule_name, array($this, 'execute_cron'), 20 );
	}

	public function execute_cron() {
		Scheduled_WC_Cleanup::start();
	}
}