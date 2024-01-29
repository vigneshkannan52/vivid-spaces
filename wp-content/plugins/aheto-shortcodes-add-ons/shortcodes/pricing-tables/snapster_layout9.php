<?php
/**
 * The Pricing Tables Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing-tables--snapster' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing-tables--snapster-cf_simple' );

$random             = substr( md5( rand() ), 0, 7 );
$mail               = isset( $mail ) && ! empty( $mail ) ? $mail : '';
$snapster_cf_submit = isset( $snapster_cf_submit ) && ! empty( $snapster_cf_submit ) ? $snapster_cf_submit : esc_attr__( 'Submit', 'snapster' );
$snapster_cf_pdf    = isset( $snapster_cf_pdf ) && ! empty( $snapster_cf_pdf ) ? $snapster_cf_pdf : esc_html__('Download PDF', 'snapster');

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'snapster-pricing-tables-layout9', $shortcode_dir . 'assets/css/snapster_layout9.css', null, null );
}

wp_enqueue_script( 'snapster-pricing-tables-layout9-js', $shortcode_dir . 'assets/js/snapster_layout9.min.js', array( 'jquery' ), null ); ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $snapster_cf_mail ) ) { ?>
		<div class="aheto-pricing-tables__form <?php echo Helper::get_button( $this, $atts, 'snapster_cf_simple_', true ); ?>">
			<form id="aheto-pricing-tables__pricelistform" class="aheto-pricing-tables__send-email"
			      data-mail="<?php echo esc_attr( $snapster_cf_mail ); ?>" data-price="0">

				<input type="text" name="snapster_name"
				       placeholder="<?php esc_html_e( 'Name *', 'snapster' ); ?>" required>

				<input type="email" name="snapster_email"
				       placeholder="<?php esc_html_e( 'Email *', 'snapster' ); ?>"
				       required>

				<textarea name="snapster_message" cols="30" rows="10"
				          placeholder="<?php echo esc_attr( $snapster_cf_placeholder ); ?>"></textarea>
				<div class="aheto-pricing-tables__button-wrap">
					<?php if ( isset( $snapster_cf_term ) && ! empty( $snapster_cf_term ) ) { ?>
						<div class="aheto-pricing-tables__term-wrap">
							<label>
								<input type="checkbox" name="snapster_term" required>
								<span></span>
								<?php esc_html_e( 'I agree with the', 'snapster' ); ?> <a
									href="<?php echo esc_url( $snapster_cf_term ); ?>"
									target="_blank"><?php esc_html_e( 'Term', 'snapster' ); ?></a>
							</label>
						</div>
					<?php } ?>
					<input type="submit" id="snapster-send" value="<?php echo esc_attr( $snapster_cf_submit ); ?>">
				</div>
				<div class="aheto-pricing-tables__send-popup">
					<div class="aheto-pricing-tables__content">
						<div class="aheto-pricing-tables__close">
							<span class="aheto-pricing-tables__line"></span>
							<span class="aheto-pricing-tables__line"></span>
						</div>
						<h4 class="aheto-pricing-tables__popup-title">
							<?php esc_html_e( 'Thank you!', 'snapster' ); ?>
						</h4>
						<p class="aheto-pricing-tables__done"><?php esc_html_e( 'Your message is sent!', 'snapster' ); ?></p>
						<p class="aheto-pricing-tables__error"><?php esc_html_e( "Oooops! Your message isn't sent!", "snapster" ); ?></p>
						<a href="" class="aheto-pricing-tables__pdf-wrap aheto-btn aheto-btn--light" download>
							<?php echo esc_html( $snapster_cf_pdf ); ?>
						</a>
					</div>
				</div>
			</form>
		</div>
		<div class="aheto-pricing-tables__price-send-loader">
			<div class="aheto-pricing-tables__lds-dual-ring"></div>
		</div>

	<?php } ?>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/snapster_layout9.css'?>" rel="stylesheet">
	<script>
jQuery(function ($) {

    $(() => {

        if (typeof window.snapsterPricelistForm === 'undefined') {
            window.snapsterPricelistForm = function () {


                if($('.aheto-pricing-tables__send-email input[type="checkbox"]').length){
                    if($('.aheto-pricing-tables__email input[type="checkbox"]').prop("checked") == true){
                        $('.aheto-pricing-tables__send-email').find('input[type="submit"]').removeAttr('disabled');
                    } else{
                        $('.aheto-pricing-tables__send-email').find('input[type="submit"]').attr('disabled',true);
                    }

                    $('.aheto-pricing-tables__send-email input[type="checkbox"]').on('change', function () {
                        if($(this).prop("checked") == true){
                            $(this).closest('.aheto-pricing-tables__send-email').find('input[type="submit"]').removeAttr('disabled');
                        } else{
                            $(this).closest('.aheto-pricing-tables__send-email').find('input[type="submit"]').attr('disabled',true);
                        }
                    })
                }

            };

            snapsterPricelistForm();
        }



        if (typeof window.snapsterPricelistFormSend === 'undefined') {
            window.snapsterPricelistFormSend = function () {

                if (window.get) {
                    $('#aheto-pricing-tables__pricelistform .aheto-pricing-tables__close').on('click', function (e) {
                        $('#aheto-pricing-tables__pricelistform').find('.aheto-pricing-tables__send-popup').removeClass('active');
                    });
                    $('#aheto-pricing-tables__pricelistform').submit( function (e) {

                        e.preventDefault();

                        let wrapp_elements = $(this).closest('.aheto-pricing-tables__send-email'),
                            mail_to = wrapp_elements.attr('data-mail'),
                            placeholder = wrapp_elements.find('textarea[name="snapster_message"]').attr('placeholder'),
                            price = wrapp_elements.attr('data-price'),
                            packages = [],
                            packagesString;


                        $('.aheto-pricing-tables--snapster .aheto-pricing-tables__wrap.active').each(function (index ) {
                            let dataTitle = $(this).find('.aheto-pricing-tables__pricelist-value').attr('data-price-title'),
                                dataPrice = $(this).find('.aheto-pricing-tables__pricelist-value').attr('data-price-value');

                            packages[index] = dataTitle + '=' + dataPrice;

                        });

                        if(packages.length > 0){
                            packagesString = packages.join('&');
                        }

                        let form = $(this).serialize();

                        $.ajax({
                            type: "POST",
                            url: get.ajaxurl,
                            data: {
                                'action': 'aheto_pricing_tables',
                                'mail_to': mail_to,
                                'price': price,
                                'packages': packagesString,
                                'placeholder': placeholder,
                                form: form
                            },
                            beforeSend: function() {
                                $(".aheto-pricing-tables__price-send-loader").addClass('active');
                            },
                            success: function() {
                                $(".aheto-pricing-tables__price-send-loader").removeClass('active');
                            }
                        }).done(function($data) {
                            wrapp_elements.find('.aheto-pricing-tables__send-popup').addClass('active');

                            if ( $data !== 'error') {
                                wrapp_elements.find('.aheto-pricing-tables__done').show();
                                wrapp_elements.find('.aheto-pricing-tables__error').hide();
                                if(packages.length > 0){
                                    wrapp_elements.find('.aheto-pricing-tables__pdf-wrap').attr('href', $data ).show();
                                }

                            } else {
                                wrapp_elements.find('.aheto-pricing-tables__done').hide();
                                wrapp_elements.find('.aheto-pricing-tables__popup-title').hide();
                                wrapp_elements.find('.aheto-pricing-tables__error').show();
                            }

                            wrapp_elements.find('input:not([type="submit"]), textarea').val('');
                        });
                    });
                }


            };

            $(window).on('load', function () {
                snapsterPricelistFormSend();
            });
        }
    });

});
	</script>
	<?php
endif;