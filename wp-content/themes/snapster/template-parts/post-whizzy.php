<?php

use Aheto\Helper;

/*
* WHIZZY POST SINGLE
*/

$protected      = post_password_required() ? 'protected-page' : '';
$get_id         = get_the_ID();
$whizzy_clients = array();
$whizzy_clients = get_the_terms( $get_id, 'whizzy-client' );
$banner_width           = get_post_meta( $get_id, 'snapster_whizzy_banner', true );

if ( post_password_required( $get_id ) ) {
	$protected_title = Aheto\Helper::get_settings( 'theme-options.snapster_w_protected_title' );
	$protected_title = ! empty( $protected_title ) ? $protected_title : esc_html__( 'Protected gallery', 'snapster' );

	$protected_descr = Aheto\Helper::get_settings( 'theme-options.snapster_w_protected_descr' );
	$protected_bg    = Aheto\Helper::get_settings( 'theme-options.snapster_w_protected_bg' );
	$protected_img  = get_post_meta($get_id, 'snapster_whizzy_protected_img', true );
	$protected_width = isset($banner_width) && !empty($banner_width) ? 'max-width:' . $banner_width . ';' : 'max-width:100%;';
	$protected_width .= isset($protected_bg) && !empty($protected_bg) ? 'background: url(' . $protected_bg . ');' : '';

	?>

    <div class="snapster--whizzy__protected-page aheto-page-min-height-js">
        <div class="snapster--whizzy__protected-wrap" style="<?php echo esc_attr($protected_width); ?>">
            <div class="snapster--whizzy__protected-left">
				<?php if ( isset($protected_img) && !empty($protected_img) ) {?>
                    <div class="snapster--whizzy__protected-img-wrap">
						<?php $image_url = array();
						$image_url['id']    = attachment_url_to_postid($protected_img);

						echo Helper::get_attachment( $image_url, [], 'medium', [ 'class' => 'img-protected' ] ); ?>
                    </div>
				<?php } ?>
                <h5 class="snapster--whizzy__protected-title">
					<?php the_title(); ?>
                </h5>

				<?php if ( ! empty( $protected_descr ) ) { ?>
                    <div class="snapster--whizzy__protected-excerpt">
						<?php echo esc_html( $protected_descr ); ?>
                    </div>
				<?php } ?>
            </div>
            <div class="snapster--whizzy__protected-right aheto-form-btn aheto-btn--light">
				<?php if ( ! empty( $protected_title ) ) { ?>
                    <h3 class="snapster--whizzy__protected-heading"><?php echo esc_html( $protected_title ); ?></h3>
					<?php
				}
				the_content(); ?>
            </div>
        </div>
    </div>
	<?php
} else {
	if ( ! empty( $whizzy_clients ) ) {
		$portfolio_thumbnail_id = get_post_thumbnail_id( $get_id );
		$banner_overlay           = get_post_meta( $get_id, 'snapster_whizzy_banner_overlay', true );

		$banner_style = is_numeric( $portfolio_thumbnail_id ) && ! empty( $portfolio_thumbnail_id ) ? 'background-image: url(' . wp_get_attachment_image_url( $portfolio_thumbnail_id, 'full' ) . ');' : '';
		$banner_style .= isset( $banner_width ) && ! empty( $banner_width ) ? 'max-width:' . $banner_width . ';' : 'max-width:100%';
		$banner_style .= isset( $banner_overlay ) && ! empty( $banner_overlay ) ? 'background-color:' . $banner_overlay . ';' : ''; ?>

        <div class="snapster--whizzy__banner" style="<?php echo esc_attr($banner_style); ?>">

			<?php foreach ( $whizzy_clients as $client ) {
				$client_img_url = get_term_meta( $client->term_id, 'snapster_whizzy_client_avatar', true ); ?>
                <div class="snapster--whizzy__client">
					<?php if ( ! empty( $client_img_url ) && ! empty( $client->name ) ) { ?>
                        <div class="snapster--whizzy__client-img"
                             style="background-image: url(<?php echo esc_attr( $client_img_url ); ?>);"></div>
					<?php }

					if ( isset( $client->name ) && ! empty( $client->name ) ) { ?>
                        <h4 class="snapster--whizzy__client-name"><?php echo esc_html( $client->name ); ?></h4>
					<?php }
					if ( isset( $client->description ) && ! empty( $client->description ) ) { ?>
                        <div class="snapster--whizzy__client-description"><?php echo esc_html( $client->description ); ?></div>
					<?php } ?>
                </div>
			<?php } ?>
        </div>
	<?php } ?>

    <div class="container snapster--whizzy__content-wrap">
        <div class="row">
            <div class="col-12">
                <div class="snapster--whizzy__content">
					<?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>

	<?php
}

