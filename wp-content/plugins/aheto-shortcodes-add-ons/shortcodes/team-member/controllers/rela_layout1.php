<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'rela_team_member_layout1');


/**
 * Team Member
 */
function rela_team_member_layout1($shortcode)
{

    $shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/team-member/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Rela Simple', 'rela'),
        'image' => $shortcode_dir . 'rela_layout1.jpg',
    ]);

    aheto_addon_add_dependency(['name', 'designation'], ['rela_layout1'], $shortcode);

}