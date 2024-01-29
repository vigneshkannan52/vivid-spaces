<?php

/**
 * Skin 7 Event.
 */

$ID = get_the_ID();

$classes   = [];
$classes[] = 'aheto-cpt-article aheto-cpt-article__vestry-7';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];

if (!class_exists('Tribe__Events__Main')) :
	return '';
endif;

$vestry_address = tribe_get_address();
$vestry_city = tribe_get_city();
$vestry_country = tribe_get_country();
$vestry_start_time = tribe_get_start_time();
$vestry_end_time = tribe_get_end_time();


$vestry_detail = '';

if (!empty($vestry_address)) {
	$vestry_detail = $vestry_address . '. ';
}

if (!empty($vestry_city)) {
	$vestry_detail .= $vestry_city . '. ';
}

if (!empty($vestry_country)) {
	$vestry_detail .= $vestry_country;
}

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/custom-post-types/';
wp_enqueue_style('vestry-skin-7', $shortcode_dir . 'assets/css/vestry_skin-7.css', null, null);

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

	<div class="aheto-cpt-article__inner">

		<div class="aheto-cpt-article__content">
			<div class="aheto-cpt-article__date">
				<p><?php the_time('j'); ?></p>
				<span><?php the_time('M'); ?></span>
			</div>
			<div class="aheto-cpt-article__title-wrapper">
				<?php $this->getTitle(); ?>
			</div>

			<div class="aheto-cpt-article__infos">
				<?php if (!empty($vestry_start_time) || !empty($vestry_end_time)) { ?>
					<div class="aheto-cpt-article__info aheto-cpt-article__date-dur">
						<i class="widget_aheto__icon ion-android-time t-left widget_aheto__icon ion-android-time t-left widget_aheto__icon ion-android-time t-left widget_aheto__icon ion-android-time t-left widget_aheto__icon ion-android-time t-left"></i>
						<div>
							<p><?php echo tribe_get_start_time($ID, 'l, g:i a'); ?></p>
							<p><?php echo tribe_get_end_time($ID, 'l, g:i a'); ?></p>
						</div>
					</div>
				<?php } ?>

				<?php if (!empty($vestry_address) || !empty($vestry_city) || !empty($vestry_country)) { ?>
					<div class="aheto-cpt-article__info aheto-cpt-article__address">
						<i class="widget_aheto__icon ion-map t-left widget_aheto__icon ion-map t-left widget_aheto__icon ion-map t-left widget_aheto__icon ion-map t-left"></i>
						<div>
							<p>
								<?php
								echo esc_html($vestry_detail);
								?>
							</p>
						</div>
					</div>
				<?php } ?>
			</div>
			<?php if (!empty($atts['vestry_link_text'])) { ?>
				<div class="aheto-cpt-article__link">
					<a href="<?php the_permalink(); ?>" class="cs-btn  aheto-btn--primary vestry_layout1">
						<?php echo esc_html($atts['vestry_link_text']); ?>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
</article>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/vestry_skin-7.css'?>" rel="stylesheet">
	<?php
endif;