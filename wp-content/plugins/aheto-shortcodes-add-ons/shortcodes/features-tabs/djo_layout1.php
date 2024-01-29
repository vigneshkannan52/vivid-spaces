<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$tabs = $this->parse_group( $djo_tabs );
if ( empty( $djo_tabs ) ) {
	return '';
}

/**
 * Set carousel params
*/


$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-features-tabs--modern' );
$this->add_render_attribute( 'wrapper', 'class', 'js-djo-tab' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/features-tabs/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('djo-features-tabs-layout1', $shortcode_dir . 'assets/css/djo_layout1.css', null, null);
}
wp_enqueue_script( 'djo-features-tabs-layout1-js', $shortcode_dir . 'assets/js/djo_layout1.min.js', array( 'jquery' ), null );

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-features-tabs__head">
        <ul class="aheto-features-tabs__list ">

			<?php foreach ( $djo_tabs as $index => $item ) :

				$heading_tag = isset( $item['heading_tag'] ) && ! empty( $item['heading_tag'] ) ? $item['heading_tag'] : 'h1';
				$active = $index > 0 ? '' : 'active'; 
				
			?>
				
				<?php if( ! empty ( $item['djo_main_heading'] ) ) : ?>
					<li class="aheto-features-tabs__list-item <?php echo esc_attr( $active ); ?>">

						<a href="#" class="aheto-features-tabs__list-link js-djo-tab-list">

							<?php echo esc_html( $item['djo_main_heading'] ); ?>
						</a>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
        </ul>
    </div>


    <div class="aheto-features-tabs__content">
		<?php foreach ( $djo_tabs as $index => $item ) :
			$active = $index > 0 ? '' : 'active';
		?>
			
			<div class="aheto-features-tabs__box js-djo-tab-box <?php echo esc_attr( $active ); ?>">

				<div class="aheto-features-tabs__box--modern">

					<div class="swiper aheto-features-tabs-swiper--vertical js-vertical-swiper">
						<div class="swiper-container js-container" data-slides="3" data-direction="vertical" data-simulate_touch="1" data-mousewheel="1">
							<div class="swiper-wrapper">
								<?php 
									$temp = 0;
									for( $count = 1; $count < 11; $count++ ) :
										$emptyClass = empty( $item['djo_image' . $count]['url'] ) ? 'disabled' : '';
								?>								
									<?php if( ! empty( $item['djo_image' . $count]['url'] )) {
										$temp++;
										$image_sl = \Aheto\Helper::get_attachment($item['djo_image' . $count], [], 'medium', $atts, 'djo_');
									?>
										<div class="swiper-slide aheto-features-tabs-swiper__slide js-slide s-back-switch <?php echo esc_attr($emptyClass); ?>">
											<?php  echo wp_kses_post($image_sl); ?>
											<span></span>
											<div class="aheto-features-tabs-swiper__shadow"></div>
										</div>	
									<?php } ?>
								<?php endfor; ?>
								<?php if( $temp == 1 ) { ?>
									<div class="swiper-slide aheto-features-tabs-swiper__slide js-slide disabled">
										<span></span>
									</div>	
									<div class="swiper-slide aheto-features-tabs-swiper__slide js-slide disabled">
										<span></span>
									</div>	
								<?php } else if( $temp == 2 ) { ?>
									<div class="swiper-slide aheto-features-tabs-swiper__slide js-slide disabled">
										<span></span>
									</div>	
								<?php } ?>
							</div>
						</div>
						<div class="swiper-button-prev js-nav"></div>
						<div class="swiper-button-next js-nav"></div>
					</div>
					
					<div class="swiper aheto-features-tabs-swiper--horizontal">
						<div class="swiper-container" data-slides="1" data-thumbs="1">
							<div class="swiper-wrapper">
								<?php for( $count = 1; $count < 11; $count++ ) :
									
									$title_tag = isset( $item['djo_title_tag' . $count] ) && ! empty( $item['djo_title_tag' . $count] ) ? $item['djo_title_tag' . $count] : 'h2';
									$subtitle_tag = isset( $item['djo_subtitle_tag' . $count] ) && ! empty( $item['djo_subtitle_tag' . $count] ) ? $item['djo_subtitle_tag' . $count] : 'p';
								?>
									<?php if( ! empty( $item['djo_image' . $count]['url'] )) { ?>
										<div class="swiper-slide">
											<?php if ( ! empty( $item['djo_image' . $count] ) ) : ?>
												<?php 
													$image_sl = \Aheto\Helper::get_attachment($item['djo_image' . $count], [], 'medium_large', $atts, 'djo_');
												?>
											<?php endif; ?>
											<div class="aheto-features-tabs__box-inner s-back-switch">
												<?php echo wp_kses_post($image_sl); ?>
												<div class="aheto-features-tabs__box-content">
													<?php if (  ! empty($item['djo_subtitle' . $count] )) :

														echo '<' . $subtitle_tag . ' class="aheto-features-tabs__box-subtitle">' . esc_html( $item['djo_subtitle' . $count] ) . '</' . $subtitle_tag . '>';

													endif; ?>
													<?php if (  ! empty($item['djo_title' . $count]) ) :

														echo '<' . $title_tag . ' class="aheto-features-tabs__box-title">' . esc_html( $item['djo_title' . $count] ) . '</' . $title_tag . '>';

													endif; ?>

													<?php if ( ! empty( $item['djo_info' . $count] ) ) : ?>

														<div class="aheto-features-tabs__box-info">
															<?php echo esc_html( $item['djo_info' . $count] ); ?>
														</div>

													<?php endif; ?>

													<?php if ( ! empty( $item['djo_description' . $count] ) ) : ?>

														<p class="aheto-features-tabs__box-description">
															<?php echo esc_html( $item['djo_description' . $count] ); ?>
														</p>

													<?php endif; ?>

													<?php if ( ! empty( $item['djo_link_title' . $count] ) && ! empty( $item['djo_link_url' . $count]['url'] ) ) {
														$djo_link_attr	= '';
														$djo_link_attr 	.= $item['djo_link_url' . $count]['is_external'] ? ' target="_blank"' : '';
														$djo_link_attr 	.= $item['djo_link_url' . $count]['nofollow'] ? ' rel="nofollow"' : '';
														$djo_link_attr 	.= $item['djo_link_url' . $count]['custom_attributes'] ? ' '. $item['djo_link_url' . $count]['custom_attributes'] : '';
														?>
														
														<div class="aheto-features-tabs__box-buttons">

															<a href="<?php echo esc_url( $item['djo_link_url' . $count]['url'] ); ?>" class="cs-btn aheto-btn--light djo_layout2"
																<?php echo wp_kses_post($djo_link_attr); ?>
															>
																<?php echo esc_html( $item['djo_link_title' . $count] ); ?>
															</a>

														</div>

													<?php } ?>

												</div>
											</div>
										</div>
									<?php } ?>
								<?php endfor; ?>
							</div>
						</div>
						<div class="swiper-pagination"></div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
    </div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/djo_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
	"use strict";

	/**
	 * Tabs
	 *
	 * @param $target $('.class') - tab item
	 * @param $selector1 '.class' - tabs main wrapper
	 * @param $selector2 '.class' - tabs content item
	 */

	function tabChange($target, $selector1, $selector2) {
		$target.on('click', function (e) {
			e.preventDefault();

			const indexEl = $(this).parent().index();

			$(this)
				.parent()
				.addClass('active')
				.siblings()
				.removeClass('active')
				.closest($selector1)
				.find($selector2)
				.removeClass('active')
				.eq(indexEl)
				.addClass('active');
		});
	}

	if ($('.aheto-features-tabs--modern').length) {
		tabChange($('.aheto-features-tabs--modern .js-djo-tab-list'), '.aheto-features-tabs--modern .js-djo-tab', '.aheto-features-tabs--modern .js-djo-tab-box');
	}
	/**
	 * Hide swiper navigation
	 */
	if ($('.aheto-features-tabs--modern').length) {
		$('.aheto-features-tabs--modern .js-vertical-swiper').each(function () {
			const $this = $(this);

			if ($this.find('.js-slide').not('.disabled').length <= 3) {

				$(this)
					.find('.js-nav')
					.hide();
			}
		});
	}
})(jQuery, window, document);
	</script>
	<?php
endif;