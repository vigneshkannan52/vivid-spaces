<?php

if ( ! defined( 'ABSPATH' ) || ! class_exists( '\Dompdf\Dompdf' ) ) exit; // Exit if accessed directly


/* Template for PDF */
$dompdf = new \Dompdf\Dompdf();

ob_start();
while ( have_posts() ) : the_post();

	$post = get_post( get_the_ID() );

	if ( post_password_required( $post ) ) {
		esc_html_e( 'The gallery password is required', 'whizzy' );
		die();
	}

	// get this gallery's metadata
	$gallery_data = get_post_meta(  get_the_ID(), '_whizzy_main_gallery', true );
	// quit if there is no gallery data

	if ( empty( $gallery_data ) || ! isset( $gallery_data['gallery'] ) ) {
		esc_html_e( 'No gallery data', 'whizzy' );
		die();
	}

	$gallery_ids = explode( ',', $gallery_data['gallery'] );
	if ( empty( $gallery_ids ) ) {
		esc_html_e( 'Empty gallery', 'whizzy' );
		die();
	}

	// get attachments
	$attachments = get_posts( array(
		'post_status'    => 'any',
		'post_type'      => 'attachment',
		'post__in'       => $gallery_ids,
		'orderby'        => 'post__in',
		'posts_per_page' => '-1',
	) );

	$image_html = '';
	$images_array = array();

    $i = 0;
    foreach ( $attachments as $key => $attachment ) {
		$metadata = wp_get_attachment_metadata( $attachment->ID );

		// only those selected
		if ( isset( $metadata[ 'selected' ] ) && $metadata[ 'selected' ] == 'true' ) {
			$image = get_attached_file( $attachment->ID );
			$type = pathinfo( $image, PATHINFO_EXTENSION );
			$data = file_get_contents( $image );
			$max_x = 950;
			$max_y = $i ? 700 : 620;

            $sz = getimagesize($image);
            if($sz[0] > $sz[1]){
               $width = $max_x . 'px';
               $height = 'auto';
            }else{
               $height = $max_y . 'px';
               $width = 'auto';
            }

			$dataUri = 'data:image/' . $type . ';base64,' . base64_encode( $data );
            $image_html .= "<div style='text-align:center; '>" . PHP_EOL;
            $image_html .= "<img style='width:{$width}; height:{$height};' src='". esc_attr( $dataUri ) ."'>" . PHP_EOL;
            $image_html .= "</div>" . PHP_EOL;
			$images_array[] = $key;

			$current_count = get_post_meta( $attachment->ID, 'attr_download_pdf', true ) ? : 0;
			$current_count = sanitize_text_field( $current_count );
			update_post_meta( $attachment->ID, 'attr_download_pdf', $current_count + 1 );

            $i++;
		}
	}

	$client_select = get_post_meta( get_the_ID(), '_whizzy_client_select', true );
	$client_list = get_post_meta( get_the_ID(), '_whizzy_clients_list', true );
	$client_name = get_post_meta( get_the_ID(), '_whizzy_client_name', true );
	$event_date  = get_post_meta( get_the_ID(), '_whizzy_event_date', true );
	$current_count_gallery = get_post_meta( get_the_ID(), 'attr_download_pdf', true ) ? : 0;
	$current_count_gallery = sanitize_text_field( $current_count_gallery );
	update_post_meta( get_the_ID(), 'attr_download_pdf', $current_count_gallery + 1 );
	$number_of_images = count( $images_array );

	$client_select = isset( $client_select ) && ! empty( $client_select ) ? $client_select : 'cust';

	if ( !empty( $client_list ) && $client_select != 'cust' && $term = get_term( $client_list[0], 'whizzy-client')){
        $clients = $term->name;
	} else {
		$clients = $client_name;
	}
    ?>
    <style type="text/css">
        .entry__meta-box {
            vertical-align: bottom;
            line-height: 20px;
            text-align: left;
        }
        .entry__meta-box .meta-box__title {
            font-size: 14px!important;
            line-height: 20px!important;
            color: #1b1b1b;
            text-transform: uppercase!important;
            letter-spacing: 2.4px!important;
            padding-top: 26px!important;
            padding-right: 10px!important;
        }
        .entry__meta-box span {
            font-size: 16px;
            line-height: 20px;
            letter-spacing: 1.12px;
            color: #b2b2b2;
            padding-top: 20px;
            padding-right: 40px;
        }
		img {
			object-fit: cover;
		}
        hr{
            color: #1b1b1b;
            background: #1b1b1b;
            height: 2px;
            width: 100%;
            border: 0;
            margin-bottom: 10px;
        }
    </style>
    <div class="entry__meta-box">
        <span class="meta-box__title"><?php esc_html_e( 'Client', 'whizzy' ); ?></span>
        <span><?php echo esc_html( $clients ); ?></span>
    </div>
    <div class="grid__item  one-half  lap-and-up-one-quarter  push-half--bottom">
        <div class="entry__meta-box">
            <span class="meta-box__title"><?php esc_html_e( 'Event date', 'whizzy' ); ?></span>
            <span><?php echo esc_html( $event_date ); ?></span>
        </div>
    </div>
    <div class="entry__meta-box">
        <span class="meta-box__title"><?php esc_html_e( 'Images', 'whizzy' ); ?></span>
        <span><?php echo esc_html( $number_of_images ); ?></span>
    </div>
    <hr>

	<?php if ( ! empty( $image_html ) ) {
		echo $image_html;
	} else {
		esc_html_e( "You didn't choose any images!", 'whizzy' );
	}

endwhile;

$dompdf->loadHtml( ob_get_clean() );
$dompdf->set_paper('8.5x11', 'landscape');
$dompdf->render();
$dompdf->stream('gallery');