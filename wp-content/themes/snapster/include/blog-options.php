<?php

$cmb->add_field([
	'id'      => 'snapster_blog_image',
	'type'    => 'file',
	'name'    => __( '<i class="fas fa-image green-color"></i> <span>Banner image</span>', 'snapster' ),
	'desc'    => esc_html__( 'This options only for blog page', 'snapster' ),
]);