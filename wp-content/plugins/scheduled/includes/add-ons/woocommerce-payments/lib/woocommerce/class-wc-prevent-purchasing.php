<?php

class Scheduled_WC_Prevent_Purchasing {

	private function __construct() {

		add_action('pre_get_posts', array($this, 'remove_products_from_shop_listing'), 90, 1);
		
	}

	public static function setup() {
		return new self();
	}

	public function remove_products_from_shop_listing( $query ) {

		if ( is_admin() ) {
			return $query;
		}

		if ( $query->get('post_type')!=='product' ) {
			return $query;
		}

		global $wpdb;
		$scheduled_products = $wpdb->get_col("SELECT DISTINCT `posts`.`ID` FROM `{$wpdb->posts}` AS `posts`
				INNER JOIN `{$wpdb->postmeta}` AS `meta` ON ( `posts`.`ID` = `meta`.`post_id` AND `meta`.`meta_key` = '_scheduled_appointment' )
				WHERE `posts`.`post_type` = 'product'
				AND `posts`.`post_status` = 'publish'
				AND `meta`.`meta_value` = 'yes'");

		if ( !$scheduled_products ) {
			return $query;
		}

		$post__no_in = (array) $query->get('post__not_in');

		$query->set('post__not_in', array_merge($post__no_in, $scheduled_products));
		
		return $query;
		
	}
}
