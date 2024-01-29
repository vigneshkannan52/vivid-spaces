<?php

if ( function_exists( 'vc_map' ) ) {
	vc_map( array(
		'base' => 'whizzy_albums',
		'name' => __( 'Whizzy Album', 'whizzy' ),
		'content_element' => true,
		'show_settings_on_create' => true,
		'description' => __( 'List of portfolio items', 'whizzy' ),
		'category' => __( 'Whizzy', 'whizzy' ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'whizzy' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Grid', 'whizzy' ) => 'grid',
					__( 'Masonry', 'whizzy' ) => 'masonry',
				)
			),
			array(
				'type' => 'vc_efa_chosen',
				'heading' => __( 'Select Categories', 'whizzy' ),
				'param_name' => 'categories',
				'placeholder' => __( 'Select category', 'whizzy' ),
				'value' => whizzy_get_categories_for_vc(),
				'std' => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Order by', 'whizzy' ),
				'param_name' => 'orderby',
				'value' => array(
					__( 'ID', 'whizzy' ) => 'ID',
					__( 'Date', 'whizzy' ) => 'date',
					__( 'Title', 'whizzy' ) => 'title',
					__( 'Author', 'whizzy' ) => 'author',
					__( 'Modified', 'whizzy' ) => 'modified',
					__( 'Comment count', 'whizzy' ) => 'comment_count',
					__( 'Random', 'whizzy' ) => 'rand',
				),
				'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'whizzy' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Sort order', 'whizzy' ),
				'param_name' => 'order',
				'value' => array(
					__( 'Descending', 'whizzy' ) => 'DESC',
					__( 'Ascending', 'whizzy' ) => 'ASC',
				),
				'description' => sprintf( __( 'Select ascending or descending order. More at %s.', 'whizzy' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Select count of columns', 'whizzy' ),
				'param_name' => 'columns_number',
				'value' => array(
					__( 'Four', 'whizzy' ) => 'col-4',
					__( 'Three', 'whizzy' ) => 'col-3',
					__( 'Two', 'whizzy' ) => 'col-6',
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Add category filter?', 'whizzy' ),
				'param_name' => 'filter',
				'value' => array(
					__( 'Yes, please', 'whizzy' ) => 'yes',
				),
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
				'dependency' => array( 'element' => 'style', 'value' => array( 'grid' ) )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Count items', 'whizzy' ),
				'param_name' => 'count',
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Enable button "Load more"', 'whizzy' ),
				'param_name' => 'loadmore',
				'description' => __( 'Enable/Disabled button "Load more"', 'whizzy' ),
				'value' => array( '' => 'yes' ),
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
	class WPBakeryShortCode_whizzy_albums extends WPBakeryShortCode {
		protected function content( $atts, $content = null ) {
			/**
			 * @var string $style
			 * @var string $categories
			 * @var string $orderby
			 * @var string $order
			 * @var string $hover
			 * @var string $columns_number
			 * @var string $filter
			 * @var integer $count
			 * @var string $loadmore
			 * @var string $el_class
			 * @var mixed $css
			 */
			extract( shortcode_atts( array(
				'style' => 'grid',
				'order' => 'DESC',
				'filter' => 'See',
				'hover' => 'default',
				'orderby' => 'ID',
				'categories' => '',
				'columns_number' => 'col-4',
				'el_class' => '',
				'loadmore' => '',
				'count' => 9,
				'css' => '',
			), $atts ) );

			// base args
			$paged_type = is_front_page() ? 'page' : 'paged';
			$args = array(
				'post_type' => 'whizzy_proof_gallery',
				'posts_per_page' => ( ! empty( $count ) && is_numeric( $count ) ) ? $count : 9,
				'paged' => get_query_var( $paged_type ) ?: 1,
			);

			// Order posts
			if ( null !== $orderby ) {
				$args['orderby'] = $orderby;
			}
			$args['order'] = $order;

			// category
			if ( ! empty( $categories ) ) {
				$term_array = explode( ',', $categories );
				$cats = array();

				foreach ( $term_array as $term_slug ) {
					$term_info = get_term_by( 'slug', $term_slug, 'whizzy-category' );
					$cats[] = $term_info->term_id;
				}

				$cats = implode( ',', $cats );
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'whizzy-category',
						'field' => 'term_id',
						'terms' => explode( ',', $cats ),
					)
				);
			}

			$counter = 0;
			$posts = new WP_Query( $args );

			wp_localize_script( 'whizzy-advanced-main', 'load_more_post', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'maxPage' => $posts->max_num_pages,
				'nextLink' => next_posts( 0, false ),
				'startPage' => $args['paged'],
			) );

            $paginated = $posts->max_num_pages > 1 ? true : false;

			ob_start();

			if ( $filter == 'yes' ) { ?>
                <div class="filter <?php echo esc_attr( $style ); ?>" style="padding: 0 15px">
                    <ul>
                        <li data-selector="*" class="button is-checked"><?php _e( 'All', 'whizzy' ); ?></li>
						<?php
						$terms = get_terms( array( 'taxonomy' => 'whizzy-category' ) );

						foreach ( $terms as $category ) {
							if ( ! empty( $cats ) ) {
								if ( in_array( $category->term_id, explode( ',', $cats ) ) !== false ) { ?>
                                    <li data-selector=".<?php echo esc_attr( $category->slug ); ?>"
                                        class="button"><?php echo esc_html( $category->name ); ?></li>
								<?php }
							} else { ?>
                                <li data-selector=".<?php echo esc_attr( $category->slug ); ?>"
                                    class="button"><?php echo esc_html( $category->name ); ?></li>
							<?php }
						} ?>
                    </ul>
                </div>
			<?php }

			if ( $posts->have_posts() ) {

				global $post; ?>
                <div class="whizzy-plugin whizzy-popup whizzy-portfolio-wrapper <?php echo esc_attr( $style ); ?>">
                    <div class="portfolio <?php echo esc_attr( $columns_number ); ?>">
						<?php while ( $posts->have_posts() ) : $posts->the_post();
							$portfolio_category = '';
							$portfolio_category_items = '';
							$post_categories = get_the_terms( $posts->ID, 'whizzy-category' );

							if ( $post_categories ) {
								foreach ( $post_categories as $category ) {
									$portfolio_category .= $category->slug . ' ';
									$portfolio_category_items .= '<span>' . trim( $category->slug ) . '</span>';
								}
							}

							$portfolio_meta = get_post_meta( $post->ID, '_whizzy_main_gallery', true );
							$images = explode( ',', $portfolio_meta['gallery'] );
							?>

                            <div class="item <?php echo esc_attr(trim( $portfolio_category ) ); ?>">
                                <a href="<?php echo esc_url( get_the_permalink() ); ?>"
                                   class="item-link <?php echo esc_attr( $hover ); ?>">

									<?php
									if ( $style == 'masonry' ) {
										if ( has_post_thumbnail( $post->ID ) || ! empty( $images[0] ) ) {
											$image = has_post_thumbnail( $post->ID ) ? get_post_thumbnail_id( $post->ID ) : $images[0];
											$image_url = ( ! empty( $image ) && is_numeric( $image ) ) ? wp_get_attachment_image_src( $image, 'full' ) : '';
											$alt = get_post_meta( $image, '_wp_attachment_image_alt', true ); ?>
                                            <img src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
										<?php }
									} else { ?>
                                        <span class="img-wrap">
									        <?php if ( ! has_post_thumbnail( $post->ID ) ) {
												$image = has_post_thumbnail( $post->ID ) ? get_post_thumbnail_id( $post->ID ) : $images[0];
												$image_url = ( ! empty( $image ) && is_numeric( $image ) ) ? wp_get_attachment_image_src( $image, 'full' ) : '';

												if ( ! empty( $image ) ) {
													$alt = get_post_meta( $image, '_wp_attachment_image_alt', true ); ?>

                                                        <img src="<?php echo esc_attr( $image_url[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="s-img-switch">

													<?php
												}
                                            } ?>
                                        </span>
									<?php } ?>
                                </a>

                                <div class="item-portfolio-content port <?php echo esc_attr( $style ); ?>">
                                    <?php the_title( '<h5 class="portfolio-title"><a href="' . get_the_permalink() . '">', '</a></h5>' ); ?>
                                </div>
                            </div>
							<?php

							$counter ++;

						endwhile; ?>
                    </div>
                </div>
			<?php }

			if ( $paginated && 'yes' == $loadmore) : ?>
                <div class="text-center">
                    <button class="load-more button">
                        <span><?php esc_html_e( 'load more', 'whizzy' ); ?></span>
                    </button>
                </div>
			<?php endif;

			wp_reset_postdata();

			return ob_get_clean();
		}
	}
}
