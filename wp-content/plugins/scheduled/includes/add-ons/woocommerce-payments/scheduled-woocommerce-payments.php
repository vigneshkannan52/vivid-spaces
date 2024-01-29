<?php

// Deactivate the original add-on plugin.
add_action('init', 'deactivate_scheduled_wc_payments');
function deactivate_scheduled_wc_payments()
{
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    if (
        in_array(
            'scheduled-woocommerce-payments/scheduled-woocommerce-payments.php',
            apply_filters('active_plugins', get_option('active_plugins'))
        )
    ) {
        deactivate_plugins(
            plugin_basename(
                'scheduled-woocommerce-payments/scheduled-woocommerce-payments.php'
            )
        );
    }
}

// Global constants
define('SCHEDULED_WC_PLUGIN_PREFIX', 'scheduled_wc_');
define('SCHEDULED_WC_POST_TYPE', 'scheduled_appts');
define('SCHEDULED_WC_TAX_CALENDAR', 'scheduled_custom_calendars');
define('SCHEDULED_WC_APPOINTMENTS_PAGE', 'scheduled-appointments');
define('SCHEDULED_WC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SCHEDULED_WC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SCHEDULED_WC_PLUGIN_AJAX_URL', admin_url('admin-ajax.php'));

// Plugin WooCommerce Libraries
require_once SCHEDULED_WC_PLUGIN_DIR .
    'lib/woocommerce/class-wc-prevent-purchasing.php';
require_once SCHEDULED_WC_PLUGIN_DIR .
    'lib/woocommerce/class-wc-meta-box-product.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/woocommerce/class-wc-product.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/woocommerce/class-wc-variation.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/woocommerce/class-wc-order.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/woocommerce/class-wc-order-item.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/woocommerce/class-wc-cart.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/woocommerce/class-wc-helper.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/woocommerce/class-woocommerce.php';

// Default Plugin Libraries
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-settings.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-wp-cron.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-post-status.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-fragments.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-admin-notices.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-enqueue-scripts.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-wp-ajax.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-json-response.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-custom-fields.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-static-functions.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-appointment.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-appointment-payment-status.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/class-cleanup.php';
require_once SCHEDULED_WC_PLUGIN_DIR . 'lib/core.php';

// Setup
add_action('init', ['Scheduled_WC', 'setup']);
