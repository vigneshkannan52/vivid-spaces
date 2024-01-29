<?php
/**
 * Sidebar navigation.
 *
 * @package Aheto
 */

use Aheto\Helper;

$current            = str_replace( 'aheto-', '', Helper::param_get( 'page', 'aheto-setting-up' ) );
$check_setup_wizard = get_option( 'aheto_finish_wizard' );
$theme_tabs         = array();
$theme_tabs         = apply_filters( "aheto_theme_options", $theme_tabs );


$navigation = aheto()->plugin_dashboard_pages();

if ( empty( $theme_tabs ) ) {
	unset( $navigation["theme-options"] );
}

if ( $check_setup_wizard || 'visual-composer' === Helper::get_settings( 'general.builder' ) ) {
	unset( $navigation["setup"] );
}

if ( 'visual-composer' === Helper::get_settings( 'general.builder' ) ) {
	unset( $navigation["templates"] );
}

// Get aheto option.
$options = get_option( 'aheto-general-settings' ); ?>

<!--<div class="aheto-option-sidebar-info">-->
<!---->
<!--    <div class="aheto-info-block">-->
<!---->
<!--		<span class="icon-document">-->
<!---->
<!--			<svg width="37px" height="51px" viewBox="0 0 37 51" version="1.1" xmlns="http://www.w3.org/2000/svg"-->
<!--                 xmlns:xlink="http://www.w3.org/1999/xlink">-->
<!--				<!-- Generator: Sketch 52.2 (67145) - http://www.bohemiancoding.com/sketch -->
<!--				<title>script</title>-->
<!--				<desc>Created with Sketch.</desc>-->
<!--				<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">-->
<!--					<g id="Aheto_plugin_Import_export" transform="translate(-1434.000000, -296.000000)" fill="#2ab9a5">-->
<!--						<g id="Group-9" transform="translate(1315.000000, 129.000000)">-->
<!--							<g id="script" transform="translate(119.000000, 167.000000)">-->
<!--								<path d="M35.88573,7.1576155 L33.5130863,7.14431814 C33.511528,7.14431814 33.5100736,7.14431814 33.5085153,7.14431814 C33.5040482,7.14431814 33.4997889,7.14494146 33.4954257,7.14494146 L33.4954257,5.56691885 C33.4954257,5.12769044 33.1394097,4.77157052 32.7001813,4.77157052 L30.3143441,4.77157052 L30.3143441,3.18118553 C30.3143441,2.74195712 29.958328,2.38594109 29.5190996,2.38594109 L9.72057769,2.38594109 C9.6193931,1.05340021 8.50366151,0 7.14577254,0 C5.78777968,0 4.67215198,1.05340021 4.57096739,2.38583721 L0.888637614,2.38583721 C0.449409203,2.38583721 0.0933931746,2.74185323 0.0933931746,3.18108165 L0.0933931746,43.7407297 C0.0933931746,44.1799581 0.449409203,44.5359741 0.888637614,44.5359741 L2.47912649,44.5359741 L2.47912649,46.9218113 C2.47912649,47.3610397 2.83514252,47.7170558 3.27437093,47.7170558 L4.8649637,47.7170558 L4.8649637,50.102893 C4.8649637,50.5421214 5.22097973,50.8981374 5.66020814,50.8981374 L35.881159,50.8981374 C36.3203874,50.8981374 36.6764035,50.5421214 36.6764035,50.102893 L36.6764035,7.95285994 C36.6766112,7.51539758 36.3232962,7.16000487 35.88573,7.1576155 Z M7.14577254,1.59059277 C7.62551634,1.59059277 8.02672262,1.93279201 8.11845362,2.38583721 L6.17309146,2.38583721 C6.26471858,1.93279201 6.66592485,1.59059277 7.14577254,1.59059277 Z M1.68398594,42.9454852 L1.68398594,3.97642997 L4.56276042,3.97642997 L4.56276042,9.73408282 C4.56276042,11.1584586 5.72150066,12.3171988 7.14577254,12.3171988 C8.57014831,12.3171988 9.72878466,11.1583547 9.72878466,9.73408282 L9.72878466,6.15854747 C9.72878466,5.71931906 9.37276863,5.36330303 8.93343633,5.36330303 C8.49420792,5.36330303 8.13819189,5.71931906 8.13819189,6.15854747 L8.13819189,9.73408282 C8.13819189,10.2813523 7.69293811,10.7266061 7.14566865,10.7266061 C6.5983992,10.7266061 6.1532493,10.2813523 6.1532493,9.73408282 L6.1532493,3.97642997 L28.7235435,3.97642997 L28.7235435,42.9454852 L1.68398594,42.9454852 Z M4.06961537,46.1266708 L4.06961537,44.536078 L4.06971926,44.536078 L29.5188918,44.536078 C29.9581203,44.536078 30.3141363,44.180062 30.3141363,43.7408336 L30.3141363,6.36226718 L31.9047291,6.36226718 L31.9047291,46.1266708 L4.06961537,46.1266708 Z M6.45566035,49.3078563 L6.45566035,47.7172635 L32.7000774,47.7172635 C33.1393058,47.7172635 33.4953218,47.3612475 33.4953218,46.9220191 L33.4953218,8.73449536 C33.4983345,8.73459925 33.5011394,8.73501479 33.5041521,8.73501479 L35.0859146,8.74384507 L35.0859146,49.3078563 L6.45566035,49.3078563 Z"-->
<!--                                      id="Shape" fill-rule="nonzero"></path>-->
<!--								<path d="M20.7708914,17.4963126 L9.63663811,17.4963126 C9.1974097,17.4963126 8.84128978,17.8523287 8.84128978,18.291661 C8.84139367,18.7307855 9.1974097,19.0869054 9.63663811,19.0869054 L20.7708914,19.0869054 C21.2101198,19.0869054 21.5661358,18.7308894 21.5661358,18.291661 C21.5661358,17.8524326 21.2101198,17.4963126 20.7708914,17.4963126 Z"-->
<!--                                      id="Path"></path>-->
<!--								<path d="M20.7708914,20.6774982 L9.63663811,20.6774982 C9.1974097,20.6774982 8.84128978,21.0335142 8.84128978,21.4728465 C8.84139367,21.911971 9.1974097,22.2680909 9.63663811,22.2680909 L20.7708914,22.2680909 C21.2101198,22.2680909 21.5661358,21.9120749 21.5661358,21.4728465 C21.5661358,21.0336181 21.2101198,20.6774982 20.7708914,20.6774982 Z"-->
<!--                                      id="Path"></path>-->
<!--								<path d="M17.5896019,23.8585798 L12.8178236,23.8585798 C12.3785952,23.8585798 12.0225792,24.2145959 12.0225792,24.6539281 C12.0225792,25.0931566 12.3785952,25.4491726 12.8178236,25.4491726 L17.5896019,25.4491726 C18.0288303,25.4491726 18.3848464,25.0931566 18.3848464,24.6539281 C18.3848464,24.2146997 18.0289342,23.8585798 17.5896019,23.8585798 Z"-->
<!--                                      id="Path"></path>-->
<!--							</g>-->
<!--						</g>-->
<!--					</g>-->
<!--				</g>-->
<!--			</svg>-->
<!--		</span>-->
<!---->
<!--        <strong>--><?php //esc_html_e( 'Documentation', 'aheto' ); ?><!--</strong>-->
<!---->
<!--        <p>-->
<!--			--><?php //esc_html_e( "Use a private browser to check your website's speed and visual appearance.", 'aheto' ); ?>
<!--        </p>-->
<!---->
<!--        <a href="//foxthemes.helpscoutdocs.com/collection/2471-aheto"-->
<!--           class="custom-btn">--><?php //esc_html_e( 'Read the documentation', 'aheto' ); ?><!--</a>-->
<!---->
<!--    </div>-->
<!---->
<!--</div>-->
<div class="aheto-preloader">
    <div class="aheto-preloader__wraper">
        <img src="<?php echo aheto()->plugin_url(); ?>assets/admin/img/sidebar-icon/regenerate.png" id="loader_generating"/>
    </div>
</div>
<div class="aheto-option-sidebar">
    <div class="aheto-logo">
        <img src="<?php echo esc_url( aheto()->plugin_dashboard_desktop_logo() ); ?>"
             alt="<?php aheto()->plugin_name(); ?>"
             class="full-version">
        <img src="<?php echo esc_url( aheto()->plugin_dashboard_mobile_logo() ); ?>"
             alt="<?php aheto()->plugin_name(); ?>"
             class="mob-version">
    </div>

    <nav class="aheto-option-sidebar-nav">

		<?php
		$active_skin    = Helper::get_active_skin();
		$img            = aheto()->assets() . 'admin/img/sidebar-icon/';

		foreach ( $navigation as $id => $label ) :
			$label_title = isset( $label[0] ) && ! empty( $label[0] ) ? $label[0] : '';
			$label_icon = isset( $label[1] ) && ! empty( $label[1] ) ? $label[1] : '';
			$args       = ( $id === 'skin-generator' ) ? [ 'aheto-edit-skin' => $active_skin ] : [];
			?>
            <a<?php echo $id === $current ? ' class="nav-active"' : ''; ?>
                    href="<?php echo esc_url( Helper::get_admin_url( $id, $args ) ); ?>"
                    title="<?php echo esc_attr( $label_title ); ?>">
				<?php echo $label_icon ?>
                <span><?php echo esc_attr( $label_title ); ?></span>
            </a>
		<?php endforeach; ?>

    </nav>
    <div class="aheto-regenerate-button-wrap">
        <a class="regenerating_css_js"><img
                    src="<?php echo aheto()->plugin_url(); ?>assets/admin/img/sidebar-icon/regenerate.png"
                    id="loader_generating"/></a>
        <span class="result"></span>
    </div>

</div>