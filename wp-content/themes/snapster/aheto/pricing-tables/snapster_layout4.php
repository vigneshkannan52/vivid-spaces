<?php
/**
 * The Pricing Tables Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$pricing_items = $this->parse_group( $snapster_simple );

if ( empty( $pricing_items ) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing-tables--snapster' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing-tables--snapster-simple' );

$random = substr( md5( rand() ), 0, 7 );

/**
 * Set dependent style
 */
$shortcode_dir = SNAPSTER_T_URI . '/aheto/pricing-tables/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'snapster-pricing-tables-layout4', $shortcode_dir . 'assets/css/snapster_layout4.css', null, null );
}

wp_enqueue_script( 'snapster-pricing-tables-layout4-js', $shortcode_dir . 'assets/js/snapster_layout4.min.js', array( 'jquery' ), null ); ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php foreach ( $pricing_items as $item ) {

		$background_image = ! empty( $item['snapster_bg_image'] ) ? \Aheto\Helper::get_background_attachment( $item['snapster_bg_image'], $snapster_simple_image_size, $atts, 'snapster_simple_' ) : ''; ?>

		<div class="aheto-pricing-tables__wrap" <?php echo esc_attr( $background_image ); ?>>
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-6">
						<div class="aheto-pricing-tables__inner-wrap">
							<?php

							if ( ! empty( $item['snapster_price'] ) ) { ?>

								<div class="aheto-pricing-tables__price-wrap">
									<div class="aheto-pricing-tables__price">
										<?php if ( ! empty( $item['snapster_currency'] ) ) { ?>
											<span class="aheto-pricing-tables__currency"><?php echo esc_html( $item['snapster_currency'] ); ?></span>
										<?php }
										echo esc_html( $item['snapster_price'] ); ?>
									</div>
									<div class="aheto-pricing-tables__input-check-wrap">
										<input type="radio"
										       name="<?php echo esc_attr( $random ); ?>simple"
										       value="<?php echo esc_attr( $item['snapster_price'] ); ?>"
										       class="aheto-pricing-tables__pricelist-value"
										       data-price-title="<?php echo esc_attr( $item['snapster_title'] ); ?>"
										       data-price-value="<?php echo esc_attr( $item['snapster_currency'] . $item['snapster_price'] ); ?>">
										<span></span>
									</div>
								</div>
							<?php }

							if ( ! empty( $item['snapster_title'] ) ) { ?>
								<div class="aheto-pricing-tables__title">
									<?php echo esc_html( $item['snapster_title'] ); ?>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<?php if ( ! empty( $item['snapster_text'] ) ) { ?>
							<div class="aheto-pricing-tables__text">
								<?php echo wp_kses_post( $item['snapster_text'] ); ?>
							</div>
						<?php }

						if ( ! empty( $item['snapster_subtitle'] ) ) { ?>
							<div class="aheto-pricing-tables__subtitle">
								<?php echo esc_html( $item['snapster_subtitle'] ); ?>
							</div>
						<?php }

						if ( ! empty( $item['snapster_list'] ) ) {
							$list = explode( '|', $item['snapster_list'] ); ?>
							<ul class="aheto-pricing-tables__list-wrap">
								<?php foreach ( $list as $listitem ) {
									$icon_font  = $item['snapster_simple_icon_font'];
									$icon_style = '';
									if ( ! empty( $item['snapster_simple_icon_fz'] ) || ! empty( $item['snapster_simple_icon_color'] ) ) {
									$icon_style = 'style=';
									}
									$icon_style .= ! empty( $item['snapster_simple_icon_fz'] ) ? 'font-size:' . $item['snapster_simple_icon_fz'] . ';' : '';
									$icon_style .= ! empty( $item['snapster_simple_icon_color'] ) ? 'color:' . $item['snapster_simple_icon_color'] . ';' : ''; ?>
									<li>
										<?php if ( $item['snapster_simple_add_icon'] && ! empty( $icon_font ) ) { ?>
											<i class="<?php echo esc_attr( $item[ 'snapster_simple_icon_' . $icon_font ] ); ?>" <?php echo esc_attr( $icon_style ); ?>></i>
										<?php }
										echo esc_html( $listitem ); ?>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>