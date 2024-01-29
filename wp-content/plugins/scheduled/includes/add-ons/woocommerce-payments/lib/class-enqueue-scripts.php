<?php

class Scheduled_WC_EnqueueScript {

	protected $prefix;

	protected $plugin_url;

	private function __construct() {
		$this->prefix = SCHEDULED_WC_PLUGIN_PREFIX;
		$this->plugin_url = SCHEDULED_WC_PLUGIN_URL;

		add_action('wp_enqueue_scripts', array($this, 'enqueue_front_end_script'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_back_end_script'));
	}

	public static function enqueue() {
		return new self();
	}

	public function add_js_variables() {

		$redirect_page = Scheduled_WC_Settings::get_option('redirect_page');

		if ( $redirect_page == 'cart' ):
			$checkout_page_id = Scheduled_WC_Helper::get_cart_page();
		else:
			$checkout_page_id = Scheduled_WC_Helper::get_checkout_page();
		endif;

		$checkout_page_link = get_permalink( $checkout_page_id );
		$checkout_page_link = apply_filters( 'scheduled_wc_redirect_url', $checkout_page_link );

		$js_variables_array = array(
			'prefix' => SCHEDULED_WC_PLUGIN_PREFIX,
			'ajaxurl' => admin_url('admin-ajax.php'),
			'i18n_confirm_appt_edit' => __('Are you sure you want to change the appointment date? By doing so, the appointment date will need to be approved again.', 'scheduled'),
			'i18n_pay' => __('Are you sure you want to add the appointment to cart and go to checkout?', 'scheduled'),
			'i18n_mark_paid' => __('Are you sure you want to mark this appointment as "Paid"?', 'scheduled'),
			'i18n_paid' => __('Paid', 'scheduled'),
			'i18n_awaiting_payment' => __('Awaiting Payment', 'scheduled'),
			'checkout_page' => $checkout_page_link
		);

		$default_post_status = get_option('scheduled_new_appointment_default','draft');
		if ($default_post_status != 'draft'):
			$js_variables_array['i18n_confirm_appt_edit'] = false;
		endif;

		wp_localize_script( 'scheduled-wc-fe-functions', 'scheduled_wc_variables', $js_variables_array );
		wp_localize_script( 'scheduled-wc-admin-functions', 'scheduled_wc_variables', $js_variables_array );

	}

	public function enqueue_front_end_script() {
		if ( !is_admin() ):
			wp_register_script( 'scheduled-wc-fe-functions', $this->plugin_url . '/js/frontend-functions.js', array('jquery') );
			wp_enqueue_style( 'scheduled-wc-fe-styles', $this->plugin_url . '/css/frontend-style.css' );
			$this->add_js_variables();
			wp_enqueue_script( 'scheduled-wc-fe-functions' );
		endif;
	}

	public function enqueue_back_end_script() {
		wp_register_script( 'scheduled-wc-admin-functions', $this->plugin_url . '/js/admin-functions.js', array('jquery') );
		wp_enqueue_style( 'scheduled-wc-admin-styles', $this->plugin_url . '/css/admin-style.css' );
		$this->add_js_variables();
		wp_enqueue_script( 'scheduled-wc-admin-functions' );
	}
}