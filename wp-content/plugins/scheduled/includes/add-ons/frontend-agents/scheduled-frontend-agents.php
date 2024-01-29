<?php

// Deactivate the original add-on plugin.
add_action('init', 'deactivate_scheduled_fea');
function deactivate_scheduled_fea()
{
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    if (
        in_array(
            'scheduled-frontend-agents/scheduled-frontend-agents.php',
            apply_filters('active_plugins', get_option('active_plugins'))
        )
    ) {
        deactivate_plugins(
            plugin_basename('scheduled-frontend-agents/scheduled-frontend-agents.php')
        );
    }
}

add_action('plugins_loaded', 'init_scheduled_fea');
function init_scheduled_fea()
{
    define('SCHEDULEDFEA_PLUGIN_DIR', dirname(__FILE__));
    define('SCHEDULEDFEA_PLUGIN_URL', SCHEDULED_PLUGIN_URL . '/includes/add-ons/frontend-agents');
    $scheduledfea_plugin = new Scheduled_FEA_Plugin();
}

class Scheduled_FEA_Plugin
{
    public function __construct()
    {
        add_action('init', [&$this, 'scheduled_fea_init']);
        add_action('wp_enqueue_scripts', [&$this, 'front_end_scripts']);

        require_once sprintf('%s/includes/functions.php', SCHEDULEDFEA_PLUGIN_DIR);
        require_once sprintf(
            '%s/includes/shortcodes.php',
            SCHEDULEDFEA_PLUGIN_DIR
        );
        require_once sprintf('%s/includes/ajax.php', SCHEDULEDFEA_PLUGIN_DIR);

        $scheduledfea_ajax = new ScheduledFEA_Ajax();
    }

    public function scheduled_fea_init()
    {
        if (
            is_user_logged_in() &&
            current_user_can('edit_scheduled_appts')
        ):
            add_filter(
                'scheduled_profile_tab_content',
                [&$this, 'scheduled_fea_tabs'],
                1
            );
            add_filter('scheduled_profile_tabs', [&$this, 'scheduled_fea_tabs'], 1);
        endif;
    }

    public static function front_end_scripts()
    {
        wp_register_script(
            'scheduled-fea-js',
            SCHEDULEDFEA_PLUGIN_URL . '/js/functions.js',
            [],
            SCHEDULED_VERSION,
            true
        );
        $scheduled_fea_vars = [
            'ajax_url' => admin_url('admin-ajax.php'),
            'i18n_confirm_appt_delete' => __(
                'Are you sure you want to cancel this appointment?',
                'scheduled'
            ),
            'i18n_confirm_appt_approve' => __(
                'Are you sure you want to approve this appointment?',
                'scheduled'
            ),
        ];
        wp_localize_script(
            'scheduled-fea-js',
            'scheduled_fea_vars',
            $scheduled_fea_vars
        );
        wp_enqueue_script('scheduled-fea-js');
    }

    public function scheduled_fea_tabs($custom_tabs)
    {
        $custom_tabs = [
            'fea_appointments' => [
                'title' => __(
                    'Upcoming Appointments',
                    'scheduled'
                ),
                'fa-icon' => 'calendar-days',
                'class' => false,
            ],
            'fea_pending' => [
                'title' =>
                    __('Pending Appointments', 'scheduled') .
                    '<div class="counter"></div>',
                'fa-icon' => 'clock',
                'class' => false,
            ],
            'fea_history' => [
                'title' => __('Appointment History', 'scheduled'),
                'fa-icon' => 'calendar-days',
                'class' => false,
            ],
            'edit' => [
                'title' => __('Edit Profile', 'scheduled'),
                'fa-icon' => 'pencil',
                'class' => 'edit-button',
            ],
        ];

        return $custom_tabs;
    }
}
