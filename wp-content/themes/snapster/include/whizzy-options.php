<?php

$cmb->add_field([
	'id'      => 'snapster_w_protected_title',
	'type'    => 'text',
	'name'    => __( '<i class="fas fa-pen yellow-color"></i> <span>Title for protected portfolio</span>', 'snapster' ),
	'desc'    => esc_html__( 'This options only for whizzy portfolio', 'snapster' ),
]);

$cmb->add_field([
	'id'      => 'snapster_w_protected_descr',
	'type'    => 'text',
	'name'    => __( '<i class="fas fa-pencil-alt green-color"></i> <span>Description for protected portfolio</span>', 'snapster' ),
	'desc'    => esc_html__( 'This options only for whizzy portfolio', 'snapster' ),
]);

$cmb->add_field([
	'id'      => 'snapster_w_protected_bg',
	'type'    => 'file',
	'name'    => __( '<i class="fas fa-image blue-color"></i> <span>Background for protected portfolio</span>', 'snapster' ),
	'desc'    => esc_html__( 'This options only for blog page', 'snapster' ),
]);