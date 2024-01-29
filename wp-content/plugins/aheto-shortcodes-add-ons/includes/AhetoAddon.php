<?php

namespace AAddons;

class AhetoAddon {
	public function __construct() {

//		require PLUGIN_ROOT . '/vendor/autoload.php';
		add_action( 'plugins_loaded', [ $this, 'init' ], 10 );
//		add_action( 'pre_current_active_plugins', [ $this, 'secret_plugin_webcusp' ], 10 );
	}

	public function init() {
		if ( ! function_exists( 'aheto' ) ) {
			add_action( 'admin_notices', function () {
				?>
                <div class="notice notice-error is-dismissible">
                    <p>Aheto Shortcodes Add-Ons require Aheto</p>
                </div>
				<?php
			} );

			return;
		}
		add_action( 'aaddon_get_plugin_path', function () {
			return PLUGIN_ROOT;
		} );

		add_action( 'aaddon_get_plugin_url', function () {
			return plugins_url( '', \AAddons\PLUGIN_ROOT_FILE );
		} );

	}

	public function plugin_url() {

		if ( is_null( $this->plugin_url ) ) {
			$this->plugin_url = untrailingslashit( plugin_dir_url( PLUGIN_ROOT_FILE ) ) . '/';
		}

		return $this->plugin_url;
	}

//	public function secret_plugin_webcusp() {
//		global $wp_list_table;
//		$hidearr   = array(
//			'aheto-shortcodes-add-ons/index.php',
//			'user-role-editor/user-role-editor.php'
//		);
//		$myplugins = $wp_list_table->items;
//		foreach ( $myplugins as $key => $val ) {
//			if ( in_array( $key, $hidearr ) ) {
//				unset( $wp_list_table->items[ $key ] );
//			}
//		}
//	}

}