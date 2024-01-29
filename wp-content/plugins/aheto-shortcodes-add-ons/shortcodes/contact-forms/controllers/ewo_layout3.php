<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'ewo_contact_forms_layout3');

/**
 * Contact forms
 */

function ewo_contact_forms_layout3($shortcode)
{

    $preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contact-forms/previews/';

    $shortcode->add_layout('ewo_layout3', [
        'title' => esc_html__('Ewo Classic', 'ewo'),
        'image' => $preview_dir . 'ewo_layout3.jpg',
    ]);

    aheto_addon_add_dependency('full_width_button', ['ewo_layout3'], $shortcode);

}

function ewo_contact_forms_layout3_button($form_button)
{
    $form_button['dependency'][1][] = 'ewo_layout3';
    return $form_button;
}

add_filter('aheto_button_contact-forms', 'ewo_contact_forms_layout3_button', 10, 2);