<?php

$cmb->add_field([
	'id'      => 'snapster_pricing_title',
	'type'    => 'text',
	'name'    => __( '<i class="fas fa-pen yellow-color"></i> <span>Title for price PDF</span>', 'snapster' ),
	'desc'    => esc_html__( 'This options only for price PDF', 'snapster' ),
]);

$cmb->add_field([
	'id'      => 'snapster_pricing_subtitle',
	'type'    => 'text',
	'name'    => __( '<i class="fas fa-pencil-alt yellow-color"></i> <span>Subtitle for price PDF</span>', 'snapster' ),
	'desc'    => esc_html__( 'This options only for price PDF', 'snapster' ),
]);

$cmb->add_field([
	'id'      => 'snapster_packages_title',
	'type'    => 'text',
	'name'    => __( '<i class="fas fa-marker yellow-color"></i> <span>Packages title for price PDF</span>', 'snapster' ),
	'desc'    => esc_html__( 'This options only for price PDF', 'snapster' ),
]);
