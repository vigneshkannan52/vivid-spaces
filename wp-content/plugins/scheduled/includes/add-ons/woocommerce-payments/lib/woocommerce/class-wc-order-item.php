<?php

class Scheduled_WC_Order_Item_Hooks {

	// changes order item meta label and value
	// replaces the appointmenr ID with it's date label
	public static function woocommerce_attribute_label($label, $name, $product=null) {

		if ( preg_match('~cfield_\d+$~', strtolower($label)) ) {
			$label = __('Form Field', 'scheduled');
			add_filter('woocommerce_order_item_display_meta_value', array('Scheduled_WC_Order_Item_Hooks', 'woocommerce_order_item_display_custom_field_meta_value'), 10, 1);
		} else if ( SCHEDULED_WC_PLUGIN_PREFIX . 'appointment_cal_name' === strtolower($label) ) {
			$label = __('Calendar', 'scheduled');
		} else if ( SCHEDULED_WC_PLUGIN_PREFIX . 'appointment_assignee_name' === strtolower($label) ) {
			$label = __('Booking Agent', 'scheduled');
		}

		if ( $label && !strstr( SCHEDULED_WC_PLUGIN_PREFIX . 'appointment_id', strtolower($label) ) ) {
			return $label;
		}

		add_filter('woocommerce_order_item_display_meta_value', array('Scheduled_WC_Order_Item_Hooks', 'woocommerce_order_item_display_meta_value'), 10, 1);

		if ( is_admin() ) {
			add_filter('pre_kses', array('Scheduled_WC_Order_Item_Hooks', 'pre_kses'), 10, 3);
		}

		$label = __('Appointment', 'scheduled');

		return $label;
	}

	public static function woocommerce_order_item_display_meta_value( $meta_value ) {
		remove_filter('woocommerce_order_item_display_meta_value', array('Scheduled_WC_Order_Item_Hooks', 'woocommerce_order_item_display_meta_value'), 10, 1);

		try {
			$appointment = Scheduled_WC_Appointment::get(intval($meta_value));
		} catch (Exception $e) {
			$appointment = false;
		}

		if ( $appointment ) {
			$meta_value = $appointment->timeslot_text;
		}

		return $meta_value;
	}

	public static function woocommerce_order_item_display_custom_field_meta_value( $meta_value ) {
		remove_filter('woocommerce_order_item_display_meta_value', array('Scheduled_WC_Order_Item_Hooks', 'woocommerce_order_item_display_custom_field_meta_value'), 10, 1);
		$separator = '--SEP--';
		$parts = explode($separator, $meta_value);

		$meta_value = $parts[0] . ':' . $parts[1];

		return $meta_value;
	}

	// changes the Order Item app_id to text in Back End
	public static function pre_kses($string, $allowed_html, $allowed_protocols) {
		if ( $string===__('Appointment', 'scheduled') ) {
			return $string;
		}

		remove_filter('pre_kses', array('Scheduled_WC_Order_Item_Hooks', 'pre_kses'), 10, 3);

		$app_id = intval(strip_tags($string));

		if ( !$app_id ) {
			return $string;
		}

		try {
			$appointment = Scheduled_WC_Appointment::get($app_id);
		} catch (Exception $e) {
			$appointment = false;
		}

		if ( $appointment ) {
			$string = $appointment->timeslot_text;
		}

		return $string;
	}

	// change the product title on the order details page if it is assigned to a appointment
	public static function woocommerce_order_item_name($title, $item) {

		if ( isset($item['scheduled_wc_appointment_id']) ) {
			// remove product title link, so the visitors can't acess the product details page
			$title = preg_replace('~<a[^>]+>([^<]+)</a>~i', '$1', $title);
		}

		return $title;
	}

}
