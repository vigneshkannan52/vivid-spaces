<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Template used to display the whizzy
 * Available vars:
 * string       $client_name
 * string       $event_date
 * int          $number_of_images
 * string       $file
 */
$whizzy_settings = get_option( 'whizzy_settings' );
$zip_btn = isset($whizzy_settings['whizzy_change_zip_button_text']) && !empty($whizzy_settings['whizzy_change_zip_button_text']) ? $whizzy_settings['whizzy_change_zip_button_text'] : esc_html__('Download ZIP', 'whizzy');
$pdf_btn = isset($whizzy_settings['whizzy_change_pdf_button_text']) && !empty($whizzy_settings['whizzy_change_pdf_button_text']) ? $whizzy_settings['whizzy_change_pdf_button_text'] : esc_html__('Download PDF', 'whizzy');

?>
<div id="whizzy_data" class="whizzy-data">
    <div class="grid clearfix">

        <div class="grid__item one-half lap-and-up-one-quarter push-half--bottom">
            <div class="entry__meta-box">
                <b class="meta-box__title"><?php esc_html_e( 'Client', 'whizzy' ); ?></b>

                <?php
                $client_select = isset( $client_select ) && ! empty( $client_select ) ? $client_select : 'cust';

                if ( isset( $client_list ) && ! empty( $client_list ) && $client_select != 'cust' ) {
	                $term = get_term( $client_list[0], 'whizzy-client' );
					$clients = isset($term->name) ? $term->name : '';
                } else {
	                $clients = $client_name;
                } ?>

                <span><?php echo esc_html( $clients ); ?></span>
            </div>
        </div>
        <div class="grid__item  one-half  lap-and-up-one-quarter  push-half--bottom">
            <div class="entry__meta-box">
                <b class="meta-box__title"><?php esc_html_e( 'Event date', 'whizzy' ); ?></b>
                <span><?php echo esc_html( $event_date ); ?></span>
            </div>
        </div>
        <div class="grid__item  one-half  lap-and-up-one-quarter">
            <div class="entry__meta-box">
                <b class="meta-box__title"><?php esc_html_e( 'Images', 'whizzy' ); ?></b>
                <span><?php echo esc_html( $number_of_images ); ?></span>
            </div>
        </div>
        <div class="grid__item  one-half  lap-and-up-one-quarter">
            <div class="entry__meta-box">
				<?php if ( isset( $show_zip_button ) && $show_zip_button == 'on' ) : ?>
                    <button class="button-download a-btn-2 aheto-btn aheto-btn--primary button js-download" onclick="window.open('<?php echo esc_url( $file ); ?>')">
                        <?php echo esc_html($zip_btn); ?><i class="fa fa-caret-right aheto-btn__icon--right" aria-hidden="true"></i>
                    </button>
				<?php endif; ?>

                <?php if ( isset( $show_pdf_button ) && $show_pdf_button == 'on' ) : ?>
                    <button class="button-download a-btn-2 aheto-btn aheto-btn--primary button js-download" onclick="window.open('<?php echo esc_url( get_permalink() . '?download=pdf'); ?>')">
                        <?php echo esc_html($pdf_btn); ?><i class="fa fa-caret-right aheto-btn__icon--right" aria-hidden="true"></i>
                    </button>
				<?php endif; ?>

                <?php do_action( 'whizzy_extra_gallery_buttons' ); ?>
            </div>
        </div>
    </div>
</div>
