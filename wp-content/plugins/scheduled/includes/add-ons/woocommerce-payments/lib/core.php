<?php

class Scheduled_WC {

	private function __construct() {
		if ( $this->check_plugin_dependencies() ) {

			$this->setup_woocommerce_support();
			$this->setup_scheduled_custom_fields();
			$this->enqueue_scripts();
			$this->wp_ajax();
			$this->filters_and_actions();
			$this->add_new_post_status();
			$this->add_options_pages();
			$this->setup_wp_cron();

		}
	}

	public static function setup() {
		return new self();
	}

	protected function check_plugin_dependencies() {
		return class_exists('woocommerce');
	}

	protected function filters_and_actions() {

		# ------------------
		# Filters
		# ------------------

		add_filter('scheduled_mailer_actions', array('Scheduled_WC_Functions', 'scheduled_wc_mailer_actions'), 10, 1 );
		add_filter('scheduled_prepare_sending_reminder', array('Scheduled_WC_Functions', 'scheduled_prepare_sending_reminder'), 10, 2);
		add_filter('scheduled_custom_field_data', array('Scheduled_WC_Functions', 'scheduled_custom_field_data'), 10, 1);
		add_filter('scheduled_appts_array', array('Scheduled_WC_Functions', 'scheduled_appts_array'), 10, 1);
		add_filter('scheduled_button_book_appointment', array('Scheduled_WC_Functions', 'scheduled_button_book_appointment'), 10, 1);
		add_filter('scheduled_shortcode_appointments_allow_cancel', array('Scheduled_WC_Functions', 'scheduled_shortcode_appointments_allow_cancel'), 10, 2);
		add_filter('scheduled_admin_pending_post_status',array('Scheduled_WC_Functions', 'scheduled_admin_pending_post_status'), 10, 2);
		add_filter('scheduled_fea_shortcode_appointments_buttons', array('Scheduled_WC_Functions', 'scheduled_fea_shortcode_appointments_buttons'), 10, 2);
		add_filter('woocommerce_cart_item_name', array('Scheduled_WC_Cart_Hooks', 'woocommerce_cart_item_name'), 10, 3);
		add_filter('woocommerce_cart_item_permalink', array('Scheduled_WC_Cart_Hooks', 'woocommerce_cart_item_permalink'), 10, 3);
		add_filter('woocommerce_cart_item_thumbnail', array('Scheduled_WC_Cart_Hooks', 'woocommerce_cart_item_thumbnail'), 10, 2 );
		add_filter('woocommerce_checkout_cart_item_quantity', array('Scheduled_WC_Cart_Hooks', 'woocommerce_checkout_cart_item_quantity'), 10, 3 );
		add_filter('woocommerce_order_item_name', array('Scheduled_WC_Order_Item_Hooks', 'woocommerce_order_item_name'), 10, 2);
		add_filter('woocommerce_attribute_label', array('Scheduled_WC_Order_Item_Hooks', 'woocommerce_attribute_label'), 10, 3);
		add_filter('woocommerce_hidden_order_itemmeta', array('Scheduled_WC_Order_Hooks', 'woocommerce_hidden_order_itemmeta'), 10);
		add_filter('woocommerce_order_items_meta_display', array('Scheduled_WC_Order_Hooks', 'woocommerce_order_items_meta_display'), 10, 2);
		add_filter('woocommerce_checkout_fields', array('Scheduled_WC_Cart_Hooks', 'woocommerce_checkout_fields'), 10, 1 );

		# ------------------
		# Actions
		# ------------------

		add_action('wp_loaded', array('Scheduled_WC_Cart_Hooks', 'woocommerce_remove_missing_appointment_products'), 10, 1);
		add_action('woocommerce_resume_order', array('Scheduled_WC_Order_Hooks', 'woocommerce_validate_order_items'), 10, 1);
		add_action('woocommerce_new_order', array('Scheduled_WC_Order_Hooks', 'woocommerce_validate_order_items'), 10, 1);
		add_action('wp_ajax_scheduled_new_appointment_form', array('Scheduled_WC_Functions', 'scheduled_new_appointment_form'), 5);
		add_action('wp_ajax_nopriv_scheduled_new_appointment_form', array('Scheduled_WC_Functions', 'scheduled_new_appointment_form'), 5);
		add_action('scheduled_new_appointment_created', array('Scheduled_WC_Functions', 'scheduled_new_appointment_created'), 15, 1);
		add_action('scheduled_new_appointment_created', array('Scheduled_WC_Functions', 'scheduled_store_appointment_creation_date'), 10, 1);
		add_action('scheduled_before_creating_appointment', array('Scheduled_WC_Functions', 'remove_default_emails'), 1);
		add_action('scheduled_before_creating_appointment', array('Scheduled_WC_Functions', 'scheduled_before_creating_appointment'), 10);

		// On Order Complete
		add_action('woocommerce_order_status_completed', array('Scheduled_WC_Order_Hooks', 'woocommerce_order_complete'), 10, 1);

		// Trash the appointment on order cancel, refunded or deleted
		add_action('woocommerce_order_status_cancelled', array('Scheduled_WC_Order_Hooks', 'woocommerce_order_remove_appointment'), 10, 1);
		add_action('woocommerce_order_status_refunded', array('Scheduled_WC_Order_Hooks', 'woocommerce_order_remove_appointment'), 10, 1);
		add_action('woocommerce_order_status_trash', array('Scheduled_WC_Order_Hooks', 'woocommerce_order_remove_appointment'), 10, 1);
		add_action('before_delete_post', array('Scheduled_WC_Order_Hooks', 'woocommerce_order_remove_appointment'), 10, 1);

		add_action('scheduled_admin_calendar_buttons_after', array('Scheduled_WC_Functions', 'scheduled_admin_calendar_buttons_after'), 10, 3);
		add_action('scheduled_admin_calendar_buttons_before', array('Scheduled_WC_Functions', 'scheduled_admin_calendar_buttons_before'), 10, 3);
		add_action('scheduled_shortcode_appointments_buttons', array('Scheduled_WC_Functions', 'scheduled_shortcode_appointments_buttons'), 10, 1);
		add_action('scheduled_shortcode_appointments_additional_information', array('Scheduled_WC_Functions', 'scheduled_shortcode_appointments_additional_information'), 10, 1);
		add_action('woocommerce_add_order_item_meta', array('Scheduled_WC_Order_Hooks', 'woocommerce_add_order_item_meta'), 10, 4);

	}

	protected function setup_woocommerce_support() {
		Scheduled_WC_Main::setup();
	}

	protected function setup_scheduled_custom_fields() {
		Scheduled_WC_Custom_Fields::setup();
	}

	protected function enqueue_scripts() {
		Scheduled_WC_EnqueueScript::enqueue();
	}

	protected function wp_ajax() {
		Scheduled_WC_Ajax::setup();
	}

	protected function add_new_post_status() {
		Scheduled_WC_Post_Status::setup();
	}

	protected function add_options_pages() {
		Scheduled_WC_Settings::setup();
	}

	protected function setup_wp_cron() {
		Scheduled_WC_WP_Crons::setup();
	}
}
