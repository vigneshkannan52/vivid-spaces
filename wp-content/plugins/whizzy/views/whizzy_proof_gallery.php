<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Template used to display the whizzy
 * Available vars:
 * array        $gallery_ids        An array with all attachments ids
 * object       $attachments        An object with all the attachments
 * string       $number_of_images   Count attachments
 * string       $columns            Number of columns
 * string       $thumbnails_size    The size of the thumbnail
 */

$whizzy_style   = isset( $whizzy_style ) && $whizzy_style ? $whizzy_style : 'grid';
$whizzy_columns = isset( $whizzy_columns ) && $whizzy_columns ? $whizzy_columns : '3';
$whizzy_space   = isset( $whizzy_space ) && is_numeric( $whizzy_space ) ? $whizzy_space : '15';
$whizzy_popup   = isset( $whizzy_popup ) && $whizzy_popup == 'mod' ? 'lightpopup' : '';
$show_filters   = isset( $show_filters ) ? $show_filters : 'no';
// Watermark
// $has_enable_watermark = ('on' === get_post_meta( get_the_ID(), '_whizzy_advanced_watermark', true ) );
$has_enable_watermark = false;
?>


<?php if ( isset( $show_filters ) && $show_filters == 'yes' && $whizzy_style == 'masonry'){ ?>
    <div class="whizzy-filters">
        <button class="button is-checked" data-selector="*">
            <b><?php esc_html_e('All', 'whizzy'); ?></b>
        </button>
        <button class="button" data-selector=".selected">
			<b><?php esc_html_e('Selected', 'whizzy'); ?></b>
        </button>
        <button class="button" data-selector=":not(.selected)">
            <b><?php esc_html_e('Rejected', 'whizzy'); ?></b>
        </button>
    </div>
<?php } ?>

<div id="whizzy_proof_gallery" class="gallery row gallery-columns-<?php echo esc_attr( $whizzy_columns . ' ' . $whizzy_style . ' ' . $whizzy_popup ); ?>  cf  js-whizzy-gallery" data-space="<?php echo esc_attr( $whizzy_space ); ?>">
    <?php
	$idx = 1;
	foreach ( $attachments as $attachment ) {
		if ( 'selected' == self::get_attachment_class( $attachment ) ) {
			$select_label = esc_html__( 'Deselect', 'whizzy' );
		} else {
			$select_label = esc_html__( 'Select', 'whizzy' );
		}

		$thumb_img  = wp_get_attachment_image_url( $attachment->ID, $thumbnails_size );
		$image_full = wp_get_attachment_image_url( $attachment->ID, 'full-size' );

		// Watermark
		$thumb_img_data_or_url = apply_filters( 'whizzy_watermark_gallery_image', $thumb_img, $attachment->ID, $has_enable_watermark );
		$full_img_data_or_url = apply_filters( 'whizzy_watermark_gallery_image', $image_full, $attachment->ID, $has_enable_watermark );

		//lets determine what should we display under each image according to settings
		// also what id should we assign to that image so the auto comments linking works
		$image_name   = '';
		$image_id_tag = '';

		if ( isset( $photo_display_name ) ) {
			switch ( $photo_display_name ) {
				case 'unique_ids':
					$image_name   = '#' . $attachment->ID;
					$image_id_tag = 'item-' . $attachment->ID;
					break;
				case 'consecutive_ids':
					$image_name   = '#' . $idx;
					$image_id_tag = 'item-' . $idx;
					break;
				case 'file_name':
					$image_name   = '#' . $attachment->post_name;
					$image_id_tag = 'item-' . $attachment->post_name;
					break;
				case 'unique_ids_photo_title':
					$image_name   = '#' . $attachment->ID . ' ' . $attachment->post_title;
					$image_id_tag = 'item-' . $attachment->ID;
					break;
				case 'consecutive_ids_photo_title':
					$image_name   = $attachment->post_title;
					$image_id_tag = 'item-' . $idx;
					break;
			}
		} else {
			//default to unique ids aka attachment id
			$image_name   = '#' . $attachment->ID;
			$image_id_tag = 'item-' . $attachment->ID;
		} ?>
        <div class="proof-photo col-xs-12 col-sm-6 col-md-<?php echo esc_attr( $whizzy_columns ); ?> js-proof-photo gallery-itemA <?php echo esc_attr( self::attachment_class( $attachment ) ); ?>" <?php echo esc_html( self::attachment_data( $attachment ) ); ?> id="<?php echo esc_attr( $image_id_tag ); ?>">
            <div class="proof-photo__bg">
                <div class="proof-photo__container">
                    <div class="img-wrap">
						<?php $imgClass = $whizzy_style == 'grid' ? 's-img-switch' : ''; ?>
                        <img src="<?php echo esc_attr( $thumb_img_data_or_url ); ?>" alt="<?php echo esc_attr( $attachment->post_excerpt ); ?>" class="<?php echo esc_attr( $imgClass ); ?>">
                    </div>
                    <div class="proof-photo__meta">
                        <div class="flexbox">
                            <div class="flexbox__item">
                                <ul class="actions-nav  nav  nav--stacked">
                                    <li>
                                        <a class="meta__action zoom-action" href="<?php echo esc_attr( $full_img_data_or_url ); ?>" data-photoid="<?php echo esc_attr( $image_id_tag ); ?>">
                                            <span class="button-text"><?php esc_html_e( 'Zoom', 'whizzy' ); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="meta__action  w-select-action" href="#" data-photoid="<?php echo esc_attr( $image_id_tag ); ?>">
                                            <span class="button-text"><?php echo esc_html( $select_label ); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="proof-photo__status">
                        <span class="ticker">&check;</span>
                        <span class="spinner"></span>
                    </div>
                </div>
                <span class="proof-photo__id"><?php echo esc_html( $image_name ); ?></span>
            </div>
        </div>
		<?php
		$idx ++;
	} ?>
</div>
