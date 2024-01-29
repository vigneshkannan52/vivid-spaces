<?php

if ( function_exists( 'vc_map' ) ) {
	vc_map( array(
		'base' => 'whizzy_gallery',
		'name' => __( 'Whizzy Gallery', 'whizzy' ),
		'content_element' => true,
		'show_settings_on_create' => true,
		'description' => __( 'Simple Gallery and For Justified Gallery Plugins', 'whizzy' ),
		'category' => __( 'Whizzy', 'whizzy' ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Gallery Type', 'whizzy' ),
				'param_name' => 'type',
				'value' => array(
					__( 'Boxed Grid', 'whiizy-pro' ) => 'boxed_grid',
					__( 'Modern Masonry', 'whizzy' ) => 'boxed_masonry',
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Select hover for items', 'whizzy' ),
				'param_name' => 'hover',
				'value' => array(
					__( 'Default', 'whizzy' ) => 'default',
					__( 'Zoom Out', 'whizzy' ) => 'hover1',
					__( 'Rotate', 'whizzy' ) => 'hover3',
					__( 'Slide', 'whizzy' ) => 'hover2',
					__( 'Blur', 'whizzy' ) => 'hover4',
					__( 'Sepia', 'whizzy' ) => 'hover6',
					__( 'Shine', 'whizzy' ) => 'hover9',
					__( 'Opacity', 'whizzy' ) => 'hover8',
					__( 'Gray Scale', 'whizzy' ) => 'hover5',
					__( 'Blur + Gray Scale', 'whizzy' ) => 'hover7',
				),
				'dependency' => array( 'element' => 'type', 'value' => array( 'boxed_grid' ) )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Select Gallery', 'whizzy' ),
				'param_name'  => 'post_id',
				'placeholder' => __( 'Select Gallery', 'whizzy' ),
				'value' => whizzy_get_galleries_for_vc(),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'whizzy' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'whizzy' ),
				'value' => '',
			),
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS box', 'whizzy' ),
				'param_name' => 'css',
				'group' => __( 'Design options', 'whizzy' ),
			),
		),
	) );
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_whizzy_gallery extends WPBakeryShortCode {
		protected function content( $atts, $content = null ) {
			/**
			 * @var string $type
			 * @var string $hover
			 * @var integer $post_id
			 * @var string $el_class
			 * @var mixed  $css
			 */
			extract( shortcode_atts( array(
				'type' => 'boxed_grid',
				'hover' => 'default',
				'post_id' => 0,
				'el_class' => '',
				'css' => '',
			), $atts ) );

			// el class
			$css_classes = array( $this->getExtraClass( $el_class ) );
			$wrap_class  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts );

			// get custom css as class
			$wrap_class .= vc_shortcode_custom_css_class( $css, ' ' );
			$wrap_class .= ( ! empty( $el_class ) ) ? " {$el_class}" : '';

			// custom class
			$css_class = ( ! empty( $wrap_class ) ) ? " {$wrap_class}" : '';

			// get posts
            $galleries = new WP_Query( array(
                'post_type' => 'whizzy_proof_gallery',
                'page_id' => intval( $post_id ),
            ) );

			ob_start(); ?>

			<!-- Row -->
			<?php if ( $galleries->have_posts() ): ?>

				<div class="whizzy-plugin portfolio-single-content whizzy-popup <?php echo esc_attr( "{$type} {$css_class}" ); ?>">
                    <div class="izotope-container">
                        <div class="grid-sizer"></div>
                        <?php
                        $item_class = ( 'boxed_grid' === $type ) ? 's-img-switch' : '';
                        $gallery = ( ! empty( $galleries->posts ) ) ? reset( $galleries->posts ) : 0;

                        if ( isset( $gallery->ID ) ):
                            $gallery_data = get_post_meta( $gallery->ID, '_whizzy_main_gallery', true );
                            $gallery_images = isset( $gallery_data['gallery'] ) ? explode( ',', $gallery_data['gallery'] ) : array();

                            if ( ! empty( $gallery_images ) ):
                                foreach ( $gallery_images as $gallery_image ): ?>
                                    <div class="item-single">
                                        <a href="<?php echo esc_url( wp_get_attachment_image_url( $gallery_image, 'full' ) ); ?>" class="gallery-item <?php echo esc_attr( $hover ); ?>" title="">
                                            <span class="img-wrap">
                                                <?php echo wp_get_attachment_image( $gallery_image, 'large', false, array( 'class' => $item_class ) ); ?>
                                            </span>
                                             <div class="info-content">
                                                <div class="vertical-align">
                                                    <h5><?php echo esc_html( get_post( $gallery_image )->post_excerpt ); ?></h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
				</div>

			<?php endif;

			return ob_get_clean();
		}
	}
}
