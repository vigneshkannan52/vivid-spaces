<?php

class Scheduled_WC_Main {

	private function __construct() {
		$this->setup_product_meta_box();

		$this->setup_product_restrictions();
	}

	public static function setup() {
		return new self();
	}

	protected function setup_product_meta_box() {
		Scheduled_WC_Meta_Box_Product_Data::setup();
	}

	protected function setup_product_restrictions() {
		Scheduled_WC_Prevent_Purchasing::setup();
	}
}
