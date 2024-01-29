<?php

// Deactivate the original add-on plugin.
add_action( 'init', 'deactivate_scheduled_cal_feeds' );
function deactivate_scheduled_cal_feeds(){
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if(in_array('scheduled-calendar-feeds/scheduled-calendar-feeds.php', apply_filters('active_plugins', get_option('active_plugins')))){
		deactivate_plugins(plugin_basename('scheduled-calendar-feeds/scheduled-calendar-feeds.php'));
	}
}

add_action('plugins_loaded','init_scheduled_calendar_feeds');
function init_scheduled_calendar_feeds(){
	
	$secure_hash = md5( 'scheduled_ical_feed_' . get_site_url() );
	define('SCHEDULEDICAL_SECURE_HASH',$secure_hash);
	define('SCHEDULEDICAL_PLUGIN_DIR', dirname(__FILE__));
	
	$Scheduled_Calendar_Feed_Plugin = new Scheduled_Calendar_Feed_Plugin();
	
}

class Scheduled_Calendar_Feed_Plugin {

	public function __construct() {

		add_action('init', array(&$this, 'scheduled_ical_feed') );

	}

	public function scheduled_ical_feed(){

		if (isset($_GET['scheduled_ical'])):
			include(SCHEDULEDICAL_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'calendar-feed.php');
			exit;
		endif;

	}

}
