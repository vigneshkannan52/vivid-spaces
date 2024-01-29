<?php

$cmb->add_field( [
	'name'    => __( '<i class="fas fa-copyright yellow-color"></i> <span>Enable/Disable Right Click Copyright</span>', 'snapster' ),
	'id'      => 'snapster_copyright',
	'type'    => 'radio_inline',
	'desc'    => esc_html__( 'You can enable/disable right click copyright for site.', 'snapster' ),
	'default' => 'off',
	'options' => [
		'off' => esc_html__( 'Off', 'snapster' ),
		'on'  => esc_html__( 'On', 'snapster' ),
	],
] );

$cmb->add_field([
	'id'      => 'snapster_copyright_title',
	'type'    => 'text',
	'name'    => __( '<i class="fas fa-pen yellow-color"></i> <span>Title for Right Click Copyright</span>', 'snapster' ),
]);

$cmb->add_field([
	'id'      => 'snapster_copyright_text',
	'type'    => 'text',
	'name'    => __( '<i class="fas fa-pencil-alt yellow-color"></i> <span>Text for Right Click Copyright</span>', 'snapster' ),
]);
