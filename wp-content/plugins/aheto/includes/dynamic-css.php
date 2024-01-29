<?php
/**
 * The skin generator.
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     FOX-THEMES <info@foxthemes.me>
 */

namespace Aheto;

use Aheto\Helper;
use Aheto\Helpers\Color;

defined ( 'ABSPATH' ) || exit;

include_once aheto () -> plugin_dir () . 'includes/' . 'aheto-core-functions.php';

/**
 * Format of the $css array:
 * $css['media-query']['element']['property'] = value
 * If no media query is required then set it to 'global'
 * If we want to add multiple values for the same property then we have to make it an array like this:
 * $css[media-query][element]['property'][] = value1
 * $css[media-query][element]['property'][] = value2
 * Multiple values defined as an array above will be parsed separately.
 * @param array $settings Array of current skin settings.
 */
function aheto_dynamic_css_array ( $settings )
{
	$css = [];

	// Sanitize Common Values.
	$settings[ 'white' ] = '#fff';
	$settings[ 'black' ] = '#000';

	$colors = [ 'active', 'alter', 'alter2', 'alter3', 'grey', 'light', 'dark', 'dark2', 'white', 'black' ];
	foreach ( $colors as $color ) {
		if ( !empty( $settings[ $color ] ) ) {
			$colorAlpha = Color ::setAlpha ( $settings[ $color ], 1 );
			$colorAlpha = str_replace ( [ 'rgba(', ',1)' ], '', $colorAlpha );

			$css[ 'global' ][ ':root' ][ '--c-' . $color ] = Sanitize ::color ( $settings[ $color ] );
			$css[ 'global' ][ ':root' ][ '--ca-' . $color ] = $colorAlpha;
		}
	}


	// Typography Text.
	if ( !empty( $settings[ 'text_font' ] ) ) {
		$css[ 'global' ][ aheto_implode ( [ 'html', 'body', 'p' ] ) ] = Sanitize ::typography ( $settings[ 'text_font' ] );
	}

	// Links.
	if ( !empty( $settings[ 'links' ] ) ) {

		$link = $settings[ 'links' ];
		$link_hover = isset($settings[ 'links' ][ 'color_hover' ]) && !empty($settings[ 'links' ][ 'color_hover' ]) ? $settings[ 'links' ][ 'color_hover' ] : '';
		unset( $link[ 'color_hover' ] );

		$css[ 'global' ][ 'a' ] = Sanitize ::typography ( $link );

		if ( isset( $link_hover ) && !empty( $link_hover ) ) {
			$css[ 'global' ][ 'a:hover' ][ 'color' ] = $link_hover;
		} else if ( isset( $link_hover ) && !empty( $link_hover ) ) {
			$css[ 'global' ][ 'a:hover' ][ 'color' ] = $link_hover;
		}
	}
	// Fonts.
	if ( isset( $settings[ 'headings' ]['font-family'] ) ) {
		$css[ 'global' ][ ':root' ][ '--t-primary-font-family' ] = $settings[ 'headings' ]['font-family'];
	}
	if ( isset( $settings[ 'text_font' ]['font-family']) ) {
		$css[ 'global' ][ ':root' ][ '--t-secondary-font-family' ] = $settings[ 'text_font' ]['font-family'];
	}
	if ( isset( $settings[ 'tertiary_font' ] ) ) {
		$css[ 'global' ][ ':root' ][ '--t-tertiary-font-family' ] = $settings[ 'tertiary_font' ][ 'font-family' ];
	}

	// Sanitize buttons.
	$settings[ 'button' ] = aheto_sanitize_button ( 'button', $settings );
	$settings[ 'button_primary' ] = aheto_sanitize_button ( 'button_primary', $settings );
	$settings[ 'button_dark' ] = aheto_sanitize_button ( 'button_dark', $settings );
	$settings[ 'button_small' ] = aheto_sanitize_button ( 'button_small', $settings );
	$settings[ 'button_large' ] = aheto_sanitize_button ( 'button_large', $settings );
	$settings[ 'button_light' ] = aheto_sanitize_button ( 'button_light', $settings );
	$settings[ 'button_inline' ] = aheto_sanitize_button ( 'button_inline', $settings );
	$settings[ 'button_video' ] = aheto_sanitize_button ( 'button_video', $settings );
	$settings[ 'button_video_small' ] = aheto_sanitize_button ( 'button_video_small', $settings );
	$settings[ 'button_video_large' ] = aheto_sanitize_button ( 'button_video_large', $settings );



	aheto_headings ( $css, $settings );
	aheto_blockquote ( $css, $settings );
	aheto_buttons ( $css, $settings );
	aheto_blocks ( $css, $settings );
	aheto_partials ( $css, $settings );
	aheto_vendors ( $css, $settings );
	aheto_widgets ( $css, $settings );
	aheto_google_fonts ( $css, $settings );
	aheto_forms ( $css, $settings );

	return $css;
}

/**
 * Own  dynamic style for admin panel
 */
function aheto_dynamic_admin_css_array ( $settings )
{
	$css = [];

	// Sanitize Common Values.
	$settings[ 'white' ] = '#fff';
	$settings[ 'black' ] = '#000';

	$colors = [ 'active', 'alter', 'alter2', 'alter3', 'grey', 'light', 'dark', 'dark2', 'white', 'black' ];
	foreach ( $colors as $color ) {
		if ( !empty( $settings[ $color ] ) ) {
			$colorAlpha = Color ::setAlpha ( $settings[ $color ], 1 );
			$colorAlpha = str_replace ( [ 'rgba(', ',1)' ], '', $colorAlpha );

			$css[ 'global' ][ 'body .editor-styles-wrapper' ][ '--c-' . $color ] = Sanitize ::color ( $settings[ $color ] );
			$css[ 'global' ][ 'body .editor-styles-wrapper' ][ '--ca-' . $color ] = $colorAlpha;
		}
	}


	// Typography Text.
	if ( !empty( $settings[ 'text_font' ] ) ) {
		$css[ 'global' ][ aheto_implode ( [ 'body .editor-styles-wrapper, body .editor-styles-wrapper p' ] ) ] = Sanitize ::typography ( $settings[ 'text_font' ] );

	}

	// Links.
	if ( !empty( $settings[ 'links' ] ) ) {
		$css[ 'global' ][ 'body .editor-styles-wrapper a' ] = Sanitize ::typography ( $settings[ 'links' ] );
	}

	// Fonts.
	if ( isset( $settings[ 'primary_font' ] ) ) {
		$css[ 'global' ][ 'body .editor-styles-wrapper' ][ '--t-primary-font-family' ] = $settings[ 'primary_font' ][ 'font-family' ];
	}
	if ( isset( $settings[ 'secondary_font' ] ) ) {
		$css[ 'global' ][ 'body .editor-styles-wrapper' ][ '--t-secondary-font-family' ] = $settings[ 'secondary_font' ][ 'font-family' ];
	}
	if ( isset( $settings[ 'tertiary_font' ] ) ) {
		$css[ 'global' ][ 'body .editor-styles-wrapper' ][ '--t-tertiary-font-family' ] = $settings[ 'tertiary_font' ][ 'font-family' ];
	}

	// Sanitize buttons.
	$settings[ 'button' ] = aheto_sanitize_button ( 'button', $settings );
	$settings[ 'button_primary' ] = aheto_sanitize_button ( 'button_primary', $settings );
	$settings[ 'button_primary_large' ] = aheto_sanitize_button ( 'button_primary_large', $settings );
	$settings[ 'button_primary_small' ] = aheto_sanitize_button ( 'button_primary_small', $settings );

	$settings[ 'button_dark' ] = aheto_sanitize_button ( 'button_dark', $settings );
	$settings[ 'button_dark_large' ] = aheto_sanitize_button ( 'button_dark_large', $settings );
	$settings[ 'button_dark_small' ] = aheto_sanitize_button ( 'button_dark_small', $settings );

	$settings[ 'button_light' ] = aheto_sanitize_button ( 'button_light', $settings );
	$settings[ 'button_light_large' ] = aheto_sanitize_button ( 'button_light_large', $settings );
	$settings[ 'button_light_small' ] = aheto_sanitize_button ( 'button_light_small', $settings );

	$settings[ 'button_small' ] = aheto_sanitize_button ( 'button_small', $settings );
	$settings[ 'button_large' ] = aheto_sanitize_button ( 'button_large', $settings );
	$settings[ 'button_inline' ] = aheto_sanitize_button ( 'button_inline', $settings );
	$settings[ 'button_inline_dark' ] = aheto_sanitize_button ( 'button_inline_dark', $settings );
	$settings[ 'button_inline_light' ] = aheto_sanitize_button ( 'button_inline_light', $settings );


	$settings[ 'button_video' ] = aheto_sanitize_button ( 'button_video', $settings );
	$settings[ 'button_video_small' ] = aheto_sanitize_button ( 'button_video_small', $settings );
	$settings[ 'button_video_large' ] = aheto_sanitize_button ( 'button_video_large', $settings );

	aheto_headings ( $css, $settings, true );
	aheto_blockquote ( $css, $settings, true );
	aheto_buttons ( $css, $settings );
	aheto_google_fonts ( $css, $settings );
	aheto_forms ( $css, $settings );
	aheto_breakpoints ( $css, $settings );

	return $css;
}

/**
 * Button border-radius mixin
 * @param  mixed $radius Border-radius to asses.
 * @param  int $line_height Button Line height.
 * @param  int $font_size Button font size.
 * @param  int $padding Button padding.
 * @param  int $border_width Button border width.
 * @return string
 */
function aheto_mixin_btn_radius ( $radius, $line_height, $font_size, $padding, $border_width )
{
	if ( true === $radius || 'true' === $radius ) {
		return ( ( ( $line_height * $font_size ) + ( $padding * 2 ) + ( $border_width * 2 ) ) / 2 ) . 'px';
	}

	$radius = absint ( $radius );
	if ( is_int ( $radius ) ) {
		return $radius . 'px';
	}

	return 0;
}

/**
 * Sanitize button values.
 * @param  array $button Settings to sanitize.
 * @param  array $settings Settings to get values from.
 * @return array
 */
function aheto_sanitize_button ( $button, $settings )
{
	$defaults = [
		'font_size' => '',
		'letter_spacing' => '',
		'padding' => [],
		'border' => '',
		'background' => '',
		'color' => '',
		'box_shadow' => [],
	];

	if ( !isset( $settings[ $button ], $settings[ $button ][ 0 ] ) ) {
		return $defaults;
	}

	return wp_parse_args ( $settings[ $button ][ 0 ], $defaults );
}

/**
 * Sanitize form values.
 * @param  array $form Settings to sanitize.
 * @param  array $settings Settings to get values from.
 * @return array
 */
function aheto_sanitize_form ( $form, $settings )
{
	$defaults = [
		'font_size' => '',
		'letter_spacing' => '',
		'padding' => [],
		'border' => '',
		'background' => '',
		'color' => '',
		'box_shadow' => [],
	];

	if ( !isset( $settings[ $form ], $settings[ $form ][ 0 ] ) ) {
		return $defaults;
	}

	return wp_parse_args ( $settings[ $form ][ 0 ], $defaults );
}

/**
 * Gather google fonts.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_google_fonts ( &$css, $settings )
{

	$fonts = [];

	// Goes through all our fields and then populates the $fonts property.
	$fields = [
		'primary_font',
		'secondary_font',
		'tertiary_font',
		'text_font',
		'heading1',
		'heading2',
		'heading3',
		'heading4',
		'heading5',
		'heading6',
		'links',
		'widget_title',
		'headings',
		'button',
		'button_primary',
		'button_primary_large',
		'button_primary_small',
		'button_dark',
		'button_dark_large',
		'button_dark_small',
		'button_light',
		'button_light_large',
		'button_light_small',
		'button_inline',
		'button_inline_dark',
		'button_inline_light',
		'blockquote',
		'textarea',
		'input'
	];

	// Load all variants for these.
	$load_all = [
		'primary_font',
		'secondary_font',
		'tertiary_font',
		'text_font',
	];


	foreach ( $fields as $field ) {


//			var_dump ($field);
		if ( !isset( $settings[ $field ] ) ) {
			continue;
		}

		// Get the value.
		$value = $settings[ $field ];


		$btnsDef = [ 'button_primary', 'button_dark', 'button_light', 'button_inline' ];
		foreach ( $btnsDef as $btn ) {
			if ( $btn === $field && isset( $value ) ) {
				$value = isset($value[ 'font' ]) ? $value[ 'font' ] : array();
			}
		}


		$btns = [ 'button', 'button_primary_large', 'button_primary_small', 'button_dark', 'button_dark_large', 'button_dark_small', 'button_light_large', 'button_light_small', 'button_inline_dark', 'button_inline_light' ];

		foreach ( $btns as $btn ) {
			if ( $btn === $field && isset( $value[ 0 ] ) ) {
				$value = isset($value[ 0 ][ 'font' ]) && !empty($value[ 0 ][ 'font' ]) ? $value[ 0 ][ 'font' ] : array();
			}
		}


		// If we don't have a font-family then we can skip this.
		if ( !isset( $value[ 'font-family' ] ) || empty( $value[ 'font-family' ] ) ) {
			continue;
		}

		// Add the requested google-font.
		if ( !isset( $fonts[ $value[ 'font-family' ] ] ) ) {
			$fonts[ $value[ 'font-family' ] ] = [];
		}

		if ( in_array ( $field, $load_all ) ) {
			$fonts[ $value[ 'font-family' ] ] = [
				'200',
				'200i',
				'300',
				'300i',
				'400',
				'400i',
				'500',
				'500i',
				'600',
				'600i',
				'700',
				'700i',
				'800',
				'800i',
				'900',
				'900i',
			];
			continue;
		}

		$variant = '400';

		// Convert font-weight to variant.
		if ( !empty( $value[ 'font-weight' ] ) ) {
			$variant = str_replace ( 'italic', 'i', $value[ 'font-weight' ] );
		}

		if ( !in_array ( $variant, $fonts[ $value[ 'font-family' ] ], true ) ) {
			$fonts[ $value[ 'font-family' ] ][] = $variant;
		}
	}

	// If we don't have any fonts then we can exit.
	if ( empty( $fonts ) ) {
		return;
	}

	// Get font-family + subsets.
	$link_fonts = [];
	foreach ( $fonts as $font => $variants ) {

		$variants = implode ( ',', $variants );

		$link_font = str_replace ( ' ', '+', $font );
		if ( !empty( $variants ) ) {
			$link_font .= ':' . $variants;
		}
		$link_fonts[] = $link_font;
	}

	$link = add_query_arg ( [
		'family' => str_replace ( '%2B', '+', implode ( '%7C', $link_fonts ) . "&display=swap" ),
	], 'https://fonts.googleapis.com/css' );

	$css[ 'google_fonts' ] = $link;


}

//	die;
/**
 * Heading CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_headings ( &$css, $settings, $type = null )
{


	if ( $type ) {

		$elements = [ 'body .editor-styles-wrapper .wp-block h1',
			'body .editor-styles-wrapper .wp-block h2',
			'body .editor-styles-wrapper .wp-block h3',
			'body .editor-styles-wrapper .wp-block h4',
			'body .editor-styles-wrapper .wp-block h5',
			'body .editor-styles-wrapper .wp-block h6' ];

	} else {
		$elements = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
	}


	if ( !empty( $settings[ 'headings' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $elements ) ] = Sanitize ::typography ( $settings[ 'headings' ] );
		$css[ 'global' ][ 'body.woocommerce-page div.product form.cart .variations label,
		body.woocommerce-page table.shop_attributes th,
		body.woocommerce-page table.shop_table th,
		body.woocommerce-page .woocommerce-MyAccount-content legend' ] = Sanitize ::typography ( $settings[ 'headings' ] );
	}

	$elements = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];

	foreach ( $elements as $element ) {

		$index = str_replace ( 'h', 'heading', $element );
		if ( !isset( $settings[ $index ] ) ) {
			continue;
		}
		if ( isset($settings[ $index ] ) && !empty( $settings[ $index ] ) ) {
			$value = Sanitize ::typography ( $settings[ $index ] );

			if ( $type ) {
				$element = 'body .editor-styles-wrapper .wp-block ' . $element;
			}

			if( isset( $value[ 'font-size' ] ) && is_string ( $value[ 'font-size' ] ) ) {	
				$val_font_size = $value[ 'font-size' ];	
			} else {	
				$val_font_size = isset ( $value[ 'font-size' ][ 'desktop' ] ) ? $value[ 'font-size' ][ 'desktop' ] : '';
			}

			if(isset($value[ 'line-height' ]) && is_string ( $value[ 'line-height' ] ) ){	
				$val_line_height = $value[ 'line-height' ];	
			}else{	
				$val_line_height = isset ( $value[ 'line-height' ][ 'desktop' ] ) ? $value[ 'line-height' ][ 'desktop' ] : '';	
			}
			if(isset($value[ 'letter-spacing' ]) && is_string ( $value[ 'letter-spacing' ] ) ){	
				$val_letter_space = $value[ 'letter-spacing' ];	
			}else{	
				$val_letter_space = isset ( $value[ 'letter-spacing' ][ 'desktop' ] ) ? $value[ 'letter-spacing' ][ 'desktop' ] : '';	
			}
			
			$css[ 'global' ][ $element ] = [
				'font-size' => $val_font_size,
				'line-height' => $val_line_height,
				'letter-spacing' => $val_letter_space,
			];

			$breakpoints = [
				'tablet' => '@media (max-width: 991px)',
				'mobile' => '@media (max-width: 767px)',
			];

			foreach ( $breakpoints as $key => $breakpoint ) {

				if ( isset( $value[ 'font-size' ] ) && is_array ( $value[ 'font-size' ] ) && !empty( $value[ 'font-size' ][ $key ] ) ) {
					$css[ $breakpoint ][ $element ][ 'font-size' ] = $value[ 'font-size' ][ $key ];
				}

				if ( isset( $value[ 'line-height' ] ) && is_array ( $value[ 'line-height' ] ) && !empty( $value[ 'line-height' ][ $key ] ) ) {
					$css[ $breakpoint ][ $element ][ 'line-height' ] = $value[ 'line-height' ][ $key ];
				}

				if ( isset( $value[ 'letter-spacing' ] ) && is_array ( $value[ 'letter-spacing' ] ) && !empty( $value[ 'letter-spacing' ][ $key ] ) ) {
					$css[ $breakpoint ][ $element ][ 'letter-spacing' ] = $value[ 'letter-spacing' ][ $key ];
				}
			}

			if ( !empty( $value[ 'font-family' ] ) ) {
				$css[ 'global' ][ $element ][ 'font-family' ] = $value[ 'font-family' ];
			}
			if ( !empty( $value[ 'font-weight' ] ) ) {
				$variant = str_replace ( 'italic', 'i', $value[ 'font-weight' ] );
				$css[ 'global' ][ $element ][ 'font-weight' ] = $variant;
			}
			if (isset($value['color']) and !empty( $value[ 'color' ] ) ) {
				$css[ 'global' ][ $element ][ 'color' ] = $value[ 'color' ];
			}

//				$css['global'][$element]['font-style'] = $value['font-style'];

			if ( !empty( $value[ 'text-align' ] ) ) {
				$css[ 'global' ][ $element ][ 'text-align' ] = $value[ 'text-align' ];
			}
			if ( !empty( $value[ 'text-transform' ] ) ) {
				$css[ 'global' ][ $element ][ 'text-transform' ] = $value[ 'text-transform' ];
			}
			if ( !empty( $value[ 'word-spacing' ] ) ) {
				$css[ 'global' ][ $element ][ 'word-spacing' ] = $value[ 'word-spacing' ];
			}
			if ( !empty( $value[ 'margin-top' ] ) ) {
				$css[ 'global' ][ $element ][ 'margin-top' ] = $value[ 'margin-top' ];
			}
			if ( !empty( $value[ 'margin-bottom' ] ) ) {
				$css[ 'global' ][ $element ][ 'margin-bottom' ] = $value[ 'margin-bottom' ];
			}
			if ( !empty( $value[ 'font-style' ] ) ) {
				$css[ 'global' ][ $element ][ 'font-style' ] = $value[ 'font-style' ];
			}

		}

	}
}

/**
 * Blockquote CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_blockquote ( &$css, $settings, $type = null )
{
	$blockquote = $settings[ 'quoutes' ][ 0 ];
	$blockquote_bg = $settings[ 'quoutes_bg' ][ 0 ];
	$blockquote_line = $settings[ 'quoutes_line' ][ 0 ];
	$blockquote_border = $settings[ 'quoutes_border' ][ 0 ];

	$blockquote[ 'select' ] = '';
	$blockquote_bg[ 'select' ] = '.aheto-quote--bg';
	$blockquote_border[ 'select' ] = '.aheto-quote--border';
	$blockquote_line[ 'select' ] = '.aheto-quote--line';

	$blockquote_wrap = $type ? '.wp-block ' : '';
	$blockquote_cite = $type ? ' .wp-block-quote__citation' : ' cite';
	$pullquote_cite = $type ? ' .wp-block-pullquote__citation' : ' cite';

	foreach ( [ $blockquote, $blockquote_bg, $blockquote_line ] as $block ) {
		$css[ 'global' ][ $blockquote_wrap . 'blockquote' . $block[ 'select' ] ] = Sanitize ::typography ( $block[ 'quote' ] );
		if ( $type ) {
			$css[ 'global' ][ $blockquote_wrap . $block[ 'select' ] . $blockquote_cite . ',' . $blockquote_wrap . $block[ 'select' ] . $pullquote_cite ] = Sanitize ::typography ( $block[ 'author' ] );
		} else {
			$css[ 'global' ][ $blockquote_wrap . $block[ 'select' ] . $blockquote_cite ] = Sanitize ::typography ( $block[ 'author' ] );
		}

	}

	if ( isset( $blockquote_bg[ 'qoute_bg' ] ) ) {
		$css[ 'global' ][ $blockquote_wrap . $blockquote_bg[ 'select' ] ][ 'background-color' ] = Sanitize ::color ( $blockquote_bg[ 'qoute_bg' ] );
	}
	if ( isset( $blockquote_bg[ 'qoute_border' ] ) ) {
		$css[ 'global' ][ $blockquote_wrap . $blockquote_border[ 'select' ] ][ 'border-color' ] = Sanitize ::color ( $blockquote_border[ 'qoute_border' ] );
	}
	if ( isset( $blockquote_bg[ 'qoute_line' ] ) ) {
		$css[ 'global' ][ $blockquote_wrap . $blockquote_line[ 'select' ] ][ 'border-color' ] = Sanitize ::color ( $blockquote_line[ 'qoute_line' ] );
	}
}

/**
 * Button CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_buttons ( &$css, $settings )
{

	$button_selector = '.aheto-btn';
	$link_selector = '.aheto-link';
	$video_selector = '.aheto-btn-video';

	$button = isset( $settings[ 'button' ] ) ? $settings[ 'button' ] : array();
	$button_primary = isset( $settings[ 'button_primary' ] ) ? $settings[ 'button_primary' ] : array();
	
	$button_primary_large = isset( $settings[ 'button_primary_large' ] ) ? $settings[ 'button_primary_large' ] : array();
	$button_primary_small = isset( $settings[ 'button_primary_small' ] ) ? $settings[ 'button_primary_small' ] : array();

	$button_dark = isset( $settings[ 'button_dark' ] ) ? $settings[ 'button_dark' ] : array();	
	$button_dark_large = isset( $settings[ 'button_dark_large' ] ) ? $settings[ 'button_dark_large' ] : array();	
	$button_dark_small = isset( $settings[ 'button_dark_small' ] ) ? $settings[ 'button_dark_small' ] : array();

	$button_light = isset( $settings[ 'button_light' ] ) ? $settings[ 'button_light' ] : array();	
	$button_light_large = isset( $settings[ 'button_light_large' ] ) ? $settings[ 'button_light_large' ] : array();	
	$button_light_small = isset( $settings[ 'button_light_small' ] ) ? $settings[ 'button_light_small' ] : array();

	$button_small = isset( $settings[ 'button_small' ] ) ? $settings[ 'button_small' ] : array();	
	$button_large = isset( $settings[ 'button_large' ] ) ? $settings[ 'button_large' ] : array();

	$button_inline = isset( $settings[ 'button_inline' ] ) ? $settings[ 'button_inline' ] : array();	
	$button_inline_dark = isset( $settings[ 'button_inline_dark' ] ) ? $settings[ 'button_inline_dark' ] : array();
	$button_inline_light = isset( $settings[ 'button_inline_light' ] ) ? $settings[ 'button_inline_light' ] : array();

	$button_video = isset( $settings[ 'button_video' ] ) ? $settings[ 'button_video' ] : array();	
	$button_video_small = isset( $settings[ 'button_video_small' ] ) ? $settings[ 'button_video_small' ] : array();	
	$button_video_large = isset( $settings[ 'button_video_large' ] ) ? $settings[ 'button_video_large' ] : array();


	$elements = [
		$button_selector,
		'.aheto-form-btn [type="submit"]'
	];

	$shop_elements = [
		'.woocommerce #respond input#submit',
		'.woocommerce a.button',
		'.woocommerce button.button',
		'.woocommerce input.button',
		'.woocommerce #respond input#submit.alt',
		'.woocommerce a.button.alt',
		'.woocommerce button.button.alt',
		'.woocommerce input.button.alt',
		'.woocommerce button.button.alt.disabled',
		'.woocommerce button.button:disabled',
		'.woocommerce button.button:disabled[disabled]',
		'.woocommerce .widget_price_filter .price_slider_amount .button'
	];

	$shop_elements_hover = [
		'.woocommerce #respond input#submit:hover',
		'.woocommerce a.button:hover',
		'.woocommerce button.button:hover',
		'.woocommerce input.button:hover',
		'.woocommerce #respond input#submit.alt:hover',
		'.woocommerce a.button.alt:hover',
		'.woocommerce button.button.alt:hover',
		'.woocommerce input.button.alt:hover',
		'.woocommerce button.button.alt.disabled:hover',
		'.woocommerce button.button:disabled:hover',
		'.woocommerce button.button:disabled[disabled]:hover',
		'.woocommerce .widget_price_filter .price_slider_amount .button:hover'
	];

	if( isset( $button[ 'font' ] )  && !empty( $button[ 'font' ] ) ){
		aheto_add_props ( $css[ 'global' ][ aheto_implode ( $elements ) ], Sanitize ::typography ( $button[ 'font' ] ) );	
		aheto_add_props ( $css[ 'global' ][ aheto_implode ( $shop_elements ) ], Sanitize ::typography ( $button[ 'font' ] ) );
	}
	
	if( isset( $button[ 'padding' ] )  && !empty( $button[ 'padding' ] ) ){
		aheto_add_props ( $css[ 'global' ][ aheto_implode ( $elements ) ], Sanitize ::spacing ( $button[ 'padding' ] ) );	
		aheto_add_props ( $css[ 'global' ][ 'body.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
		body.woocommerce-account .woocommerce-MyAccount-content form .button,
		.woocommerce #review_form #respond .form-submit .submit,
		.woocommerce-page #review_form #respond .form-submit .submit, body.woocommerce-account:not(.logged-in) form button' ], Sanitize ::spacing ( $button[ 'padding' ] ) );
	}
	
	if( isset( $button[ 'border' ] ) && !empty( $button[ 'border' ] ) ) {	
		aheto_add_props ( $css[ 'global' ][ aheto_implode ( $elements ) ], Sanitize ::border ( $button[ 'border' ] ) );	
		aheto_add_props ( $css[ 'global' ][ aheto_implode ( $shop_elements ) ], Sanitize ::border ( $button[ 'border' ] ) );	
	}

	$css[ 'global' ][ aheto_implode ( $elements ) ][ 'border-radius' ] = aheto_mixin_btn_radius (
		isset( $button[ 'border_radius' ] ) ? $button[ 'border_radius' ] : 0,
		isset( $css[ 'global' ][ $button_selector ][ 'line-height' ] ) ? absint ( $css[ 'global' ][ $button_selector ][ 'line-height' ] ) : 0,
		isset( $css[ 'global' ][ $button_selector ][ 'font-size' ] ) ? absint ( $css[ 'global' ][ $button_selector ][ 'font-size' ] ) : 0,
		absint ( $button[ 'padding' ][ 'vertical' ] ),
		absint ( $button[ 'border' ][ 'all' ] )
	);

	$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'border-radius' ] = aheto_mixin_btn_radius (
		isset( $button[ 'border_radius' ] ) ? $button[ 'border_radius' ] : 0,
		isset( $css[ 'global' ][ $button_selector ][ 'line-height' ] ) ? absint ( $css[ 'global' ][ $button_selector ][ 'line-height' ] ) : 0,
		isset( $css[ 'global' ][ $button_selector ][ 'font-size' ] ) ? absint ( $css[ 'global' ][ $button_selector ][ 'font-size' ] ) : 0,
		absint ( $button[ 'padding' ][ 'vertical' ] ),
		absint ( $button[ 'border' ][ 'all' ] )
	);


	$breakpoints = [
//		'tablet' => '@media (max-width: 991px)',
		'mobile' => '@media (max-width: 767px)',
	];

	foreach ( $breakpoints as $key => $breakpoint ) {
		if ( is_array ( $button[ 'mobile_padding' ] ) && !empty( $button[ 'mobile_padding' ] ) ) {
			aheto_add_props ( $css[ $breakpoint ][ aheto_implode ( $elements ) ], Sanitize ::spacing ( $button[ 'mobile_padding' ] ) );
		}
	}


	if ( isset( $button[ 'icon_margin' ] ) ) {
		/* ----- BUTTON ICON LEFT ----- */
		$elements = [
			$button_selector . '__icon--left',
			'.aheto-form-btn' . $button_selector . '__icon--left [type="submit"]'
		];

		$css[ 'global' ][ aheto_implode ( $elements ) ][ 'margin-right' ] = Sanitize ::size ( $button[ 'icon_margin' ] );

		/* ----- BUTTON ICON RIGHT ----- */
		$elements = [
			$button_selector . '__icon--right',
			'.aheto-form-btn' . $button_selector . '__icon--right [type="submit"]'
		];

		$css[ 'global' ][ aheto_implode ( $elements ) ][ 'margin-left' ] = Sanitize ::size ( $button[ 'icon_margin' ] );
	}

	/* ----- BUTTON ICON SIZE ----- */
	if ( isset( $button[ 'icon_size' ] ) ) {
		$elements = [
			$button_selector . ' i',
			$button_selector . ' span',
			$link_selector . ' i',
			$link_selector . ' span',
		];

		$css[ 'global' ][ aheto_implode ( $elements ) ][ 'font-size' ] = Sanitize ::size ( $button[ 'icon_size' ] );
		//$css['global'][aheto_implode($elements)]['height']    = Sanitize::size($button['icon_size']);
	}

	/* ----- ALL BUTTON VARIABLES ----- */
	$button_shadow = $button_selector . '--shadow';
	$button_reverse = $button_selector . '--reverse';
	$button_transparent = $button_selector . '--transparent';
	$button_primary[ 'selector' ] = $button_selector . '--primary';
	$button_dark[ 'selector' ] = $button_selector . '--dark';
	$button_light[ 'selector' ] = $button_selector . '--light';
	$button_primary_large[ 'selector' ] = $button_selector . '--primary' . $button_selector . '--large';
	$button_primary_small[ 'selector' ] = $button_selector . '--primary' . $button_selector . '--small';
	$button_dark_large[ 'selector' ] = $button_selector . '--dark' . $button_selector . '--large';
	$button_dark_small[ 'selector' ] = $button_selector . '--dark' . $button_selector . '--small';
	$button_light_large[ 'selector' ] = $button_selector . '--light' . $button_selector . '--large';
	$button_light_small[ 'selector' ] = $button_selector . '--light' . $button_selector . '--small';

	foreach ( [ $button_primary, $button_dark, $button_light ] as $button ) {
		/* ----- video button ----- */
		$css[ 'global' ][ $video_selector . $button[ 'selector' ] ][ 'color' ] = Sanitize ::color ( $button[ 'color' ] );
		$css[ 'global' ][ $video_selector . $button[ 'selector' ] ][ 'background' ] = Sanitize ::color ( $button[ 'background' ] );
		$css[ 'global' ][ $video_selector . $button[ 'selector' ] . '::before' ][ 'border-color' ] = Sanitize ::color ( $button[ 'background' ] );
	}

	if ( !empty( $button_primary[ 'background' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'background' ] = Sanitize ::color ( $button_primary[ 'background' ] );
	}
	if ( !empty( $button_primary[ 'color' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'color' ] = Sanitize ::color ( $button_primary[ 'color' ] );
	}
	if ( !empty( $button_primary[ 'border-color' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'border-color' ] = Sanitize ::color ( $button_primary[ 'border' ] );
	}
	if ( !empty( $button_primary[ 'border_radius' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'border-radius' ] = Sanitize ::size ( $button_primary[ 'border_radius' ] );
	}

	if ( !empty( $button_primary[ 'letter-spacing' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements ) ][ 'border-radius' ] = Sanitize ::size ( $button_primary[ 'border_radius' ] );
	}
	if ( !empty( $button_primary[ 'background_hover' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements_hover ) ][ 'background' ] = Sanitize ::color ( $button_primary[ 'background_hover' ] );
	}
	if ( !empty( $button_primary[ 'color_hover' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements_hover ) ][ 'color' ] = Sanitize ::color ( $button_primary[ 'color_hover' ] );
	}
	if ( !empty( $button_primary[ 'border_hover' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements_hover ) ][ 'border-color' ] = Sanitize ::color ( $button_primary[ 'border_hover' ] );
	}
	if ( !empty( $button_primary[ 'box_shadow' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $shop_elements_hover ) ][ 'box-shadow' ] = Sanitize ::box_shadow ( $button_primary[ 'box_shadow' ] );
	}

	foreach ( [ $button_primary, $button_dark, $button_light, $button_primary_large, $button_primary_small, $button_dark_large, $button_dark_small, $button_light_large, $button_light_small ] as $index => $button ) {
		$example = !empty( $button[ 0 ] ) ? $button[ 0 ] : $button;

		/* --- Button Icon --- */

		if ( isset( $button[ 'icon_margin' ] ) ) {
			/* ----- BUTTON ICON LEFT ----- */
			$elements = [
				$button_selector . '__icon--left',
				'.aheto-form-btn' . $button_selector . '__icon--left [type="submit"]'
			];

			$css[ 'global' ][ aheto_implode ( $elements ) ][ 'margin-right' ] = Sanitize ::size ( $button[ 'icon_margin' ] );

			/* ----- BUTTON ICON RIGHT ----- */
			$elements = [
				$button_selector . '__icon--right',
				'.aheto-form-btn' . $button_selector . '__icon--right [type="submit"]'
			];

			$css[ 'global' ][ aheto_implode ( $elements ) ][ 'margin-left' ] = Sanitize ::size ( $button[ 'icon_margin' ] );
		}

		$elements = [
			$button_selector . $button[ 'selector' ],
			'.aheto-form-btn' . $button[ 'selector' ] . ' input[type="submit"]',
		];

		if($index === 0){
			$elements = array_merge($elements, $shop_elements);
		}
		
		$value = isset( $example[ 'font' ] ) && !empty( $example[ 'font' ] ) ? Sanitize ::typography ( $example[ 'font' ] ) : array();

		if( isset( $example[ 'font' ] ) && !empty( $value ) ){
			$css[ 'global' ][ aheto_implode ( $elements ) ] = [
				'font-size' => is_string ( $value[ 'font-size' ] ) ? $value[ 'font-size' ] : $value[ 'font-size' ][ 'desktop' ],
				'line-height' => is_string ( $value[ 'line-height' ] ) ? $value[ 'line-height' ] : $value[ 'line-height' ][ 'desktop' ],
				'letter-spacing' => is_string ( $value[ 'letter-spacing' ] ) ? $value[ 'letter-spacing' ] : $value[ 'letter-spacing' ][ 'desktop' ],
			];

			$breakpoints = [
				'tablet' => '@media (max-width: 991px)',
				'mobile' => '@media (max-width: 767px)',
			];

			foreach ( $breakpoints as $key => $breakpoint ) {

				if ( is_array ( $value[ 'font-size' ] ) && !empty( $value[ 'font-size' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'font-size' ] = $value[ 'font-size' ][ $key ];
				}

				if ( is_array ( $value[ 'line-height' ] ) && !empty( $value[ 'line-height' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'line-height' ] = $value[ 'line-height' ][ $key ];
				}

				if ( is_array ( $value[ 'letter-spacing' ] ) && !empty( $value[ 'letter-spacing' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'letter-spacing' ] = $value[ 'letter-spacing' ][ $key ];
				}
			}

			if ( !empty( $value[ 'font-family' ] ) ) {
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'font-family' ] = $value[ 'font-family' ];
			}
			if ( !empty( $value[ 'font-weight' ] ) ) {
				$variant = str_replace ( 'italic', 'i', $value[ 'font-weight' ] );
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'font-weight' ] = $variant;
			}
			if (isset($value['color']) and !empty( $value[ 'color' ] ) ) {
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'color' ] = $value[ 'color' ];
			}
		}
		if ( isset( $example[ 'padding' ] ) && !empty( $example[ 'padding' ] ) ) {
			aheto_add_props ( $css[ 'global' ][ aheto_implode ( $elements ) ], Sanitize ::spacing ( $example[ 'padding' ] ) );
		}
		if ( isset( $example[ 'border' ] ) && !empty( $example[ 'border' ] ) ) {
			aheto_add_props ( $css[ 'global' ][ aheto_implode ( $elements ) ], Sanitize ::border ( $example[ 'border' ] ) );
		}
		if ( isset( $example[ 'background' ] ) && !empty( $example[ 'background' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements ) ][ 'background' ] = Sanitize ::color ( $example[ 'background' ] );
		}
		if ( isset( $example[ 'color' ] ) && !empty( $example[ 'color' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements ) ][ 'color' ] = Sanitize ::color ( $example[ 'color' ] );
		}
		if ( isset( $example[ 'border_radius' ] ) && !empty( $example[ 'border_radius' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements ) ][ 'border-radius' ] = Sanitize ::size ( $example[ 'border_radius' ] );
		}
		/* ----- hover state ----- */
		$elements_hover = [
			$button_selector . $button[ 'selector' ] . ':hover',
			'.aheto-form-btn' . $button[ 'selector' ] . ' input[type="submit"]:hover',
		];
		if ( isset( $example[ 'border_hover' ] ) && !empty( $example[ 'border_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_hover ) ][ 'border-color' ] = Sanitize ::color ( $example[ 'border_hover' ] );
		}
		if ( isset( $example[ 'background_hover' ] ) && !empty( $example[ 'background_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_hover ) ][ 'background' ] = Sanitize ::color ( $example[ 'background_hover' ] );
		}
		if ( isset( $example[ 'color_hover' ] ) && !empty( $example[ 'color_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_hover ) ][ 'color' ] = Sanitize ::color ( $example[ 'color_hover' ] );
		}

		/* ----- shadow state ----- */
		$elements_shadow = [
			$button_selector . $button[ 'selector' ] . $button_shadow,
			'.aheto-form-btn' . $button[ 'selector' ] . $button_shadow . ' input[type="submit"]',
		];
		if ( isset( $example[ 'box_shadow' ] ) && !empty( $example[ 'box_shadow' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_shadow ) ][ 'box-shadow' ] = Sanitize ::box_shadow ( $example[ 'box_shadow' ] );
		}

		/* ----- reverse state ----- */
		$elements_reverse = [
			$button_selector . $button[ 'selector' ] . $button_reverse,
			'.aheto-form-btn' . $button[ 'selector' ] . $button_reverse . ' input[type="submit"]',
		];
		if ( isset( $example[ 'background_hover' ] ) && !empty( $example[ 'background_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse ) ][ 'background' ] = Sanitize ::color ( $example[ 'background_hover' ] );
		}
		if ( isset( $example[ 'color_hover' ] ) && !empty( $example[ 'color_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse ) ][ 'color' ] = Sanitize ::color ( $example[ 'color_hover' ] );
		}
		if ( isset( $example[ 'border_hover' ] ) && !empty( $example[ 'border_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse ) ][ 'border-color' ] = Sanitize ::color ( $example[ 'border_hover' ] );
		}
		/* ----- reverse hover state ----- */
		$elements_reverse_hover = [
			$button_selector . $button[ 'selector' ] . $button_reverse . ':hover',
			'.aheto-form-btn' . $button[ 'selector' ] . $button_reverse . ' input[type="submit"]:hover',
		];
		if ( isset( $example[ 'background' ] ) && !empty( $example[ 'background' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse_hover ) ][ 'background' ] = Sanitize ::color ( $example[ 'background' ] );
		}
		if ( isset( $example[ 'color' ] ) && !empty( $example[ 'color' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse_hover ) ][ 'color' ] = Sanitize ::color ( $example[ 'color' ] );
		}
		if ( isset( $example[ 'border' ] ) && !empty( $example[ 'border' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_reverse_hover ) ][ 'border-color' ] = Sanitize ::color ( $example[ 'border' ] );
		}

		/* ----- transparent state ----- */
		$elements_transparent = [
			$button_selector . $button[ 'selector' ] . $button_transparent,
			'.aheto-form-btn' . $button[ 'selector' ] . $button_transparent . ' input[type="submit"]',
		];

		$css[ 'global' ][ aheto_implode ( $elements_transparent ) ][ 'background' ] = 'transparent';

		$elements_transparent_hover = [
			$button_selector . $button[ 'selector' ] . $button_transparent . ':hover',
			'.aheto-form-btn' . $button[ 'selector' ] . $button_transparent . ' input[type="submit"]:hover',
		];

		if ( isset( $example[ 'background_hover' ] ) && !empty( $example[ 'background_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_transparent_hover ) ][ 'background' ] = Sanitize ::color ( $example[ 'background_hover' ] );
		}

		/* ----- brekpoint state ----- */

		if ( isset ( $example[ 'tablet_padding' ] ) && !empty( $example[ 'tablet_padding' ] ) ) {
			aheto_add_props ( $css[ '@media (max-width: 991px)' ][ aheto_implode ( $elements ) ], Sanitize ::spacing ( $example[ 'tablet_padding' ] ) );
		}
		if ( isset ( $example[ 'mobile_padding' ] ) && !empty( $example[ 'mobile_padding' ] ) ) {
			aheto_add_props ( $css[ '@media (max-width: 767px)' ][ aheto_implode ( $elements ) ], Sanitize ::spacing ( $example[ 'mobile_padding' ] ) );
		}

	}

	/* ----- BUTTON INLINE ----- */
	$button_inline[ 'selector' ] = $button_selector . '--primary';
	$button_inline_dark[ 'selector' ] = $button_selector . '--dark';
	$button_inline_light[ 'selector' ] = $button_selector . '--light';
	
	foreach ( [ $button_inline, $button_inline_dark, $button_inline_light ] as $button ) {
		
		if( isset($button[ 'font' ] ) && !empty( $button[ 'font' ] ) ) {
			$example = $button[ 'font' ];	
		} elseif( isset($button[ 0 ][ 'font' ] ) ) {	
			$example = $button[ 0 ][ 'font' ];	
		} else {	
			$example = array();	
		}	
		$example_hover = isset($example[ 'color_hover' ]) ? $example[ 'color_hover' ] : '';
		
		unset( $example[ 'color_hover' ] );
		
		$elements = [
			$link_selector . $button[ 'selector' ],
			'.aheto-form-link' . $button[ 'selector' ] . ' input[type="submit"]'
		];
		$elements_hover = [
			$link_selector . $button[ 'selector' ] . ':hover',
		];
		
		if( is_array( $example ) && count( $example ) > 0){
			
			$value = Sanitize ::typography ( $example );

			$css[ 'global' ][ aheto_implode ( $elements ) ] = [
				'font-size' => ( isset ( $value[ 'font-size' ] ) && is_string ( $value[ 'font-size' ] ) ) ? $value[ 'font-size' ] : $value[ 'font-size' ][ 'desktop' ],
				'line-height' => ( isset ( $value[ 'line-height' ] ) && is_string ( $value[ 'line-height' ] ) ) ? $value[ 'line-height' ] : $value[ 'line-height' ][ 'desktop' ],
				'letter-spacing' => ( isset ( $value[ 'letter-spacing' ] ) && is_string ( $value[ 'letter-spacing' ] ) ) ? $value[ 'letter-spacing' ] : $value[ 'letter-spacing' ][ 'desktop' ],
			];

			$breakpoints = [
				'tablet' => '@media (max-width: 991px)',
				'mobile' => '@media (max-width: 767px)',
			];

			foreach ( $breakpoints as $key => $breakpoint ) {

				if ( isset ( $value[ 'font-size' ] ) && !empty( $value[ 'font-size' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'font-size' ] = $value[ 'font-size' ][ $key ];
				}

				if ( isset ( $value[ 'line-height' ] ) && !empty( $value[ 'line-height' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'line-height' ] = $value[ 'line-height' ][ $key ];
				}

				if ( isset ( $value[ 'letter-spacing' ] ) && !empty( $value[ 'letter-spacing' ][ $key ] ) ) {
					$css[ $breakpoint ][ aheto_implode ( $elements ) ][ 'letter-spacing' ] = $value[ 'letter-spacing' ][ $key ];
				}
			}

			if ( isset( $value[ 'font-family' ] ) && !empty( $value[ 'font-family' ] ) ) {
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'font-family' ] = $value[ 'font-family' ];
			}
			if ( isset( $value[ 'font-weight' ] ) && !empty( $value[ 'font-weight' ] ) ) {
				$variant = str_replace ( 'italic', 'i', $value[ 'font-weight' ] );
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'font-weight' ] = $variant;
			}
			if ( isset( $value[ 'color' ] ) && isset( $value[ 'color' ] ) and !empty( $value[ 'color' ] ) ) {
				$css[ 'global' ][ aheto_implode ( $elements ) ][ 'color' ] = $value[ 'color' ];
			}
		}

		$css[ 'global' ][ aheto_implode ( $elements_hover ) ][ 'color' ] = Sanitize ::color ( $example_hover );
	}

	/* ----- BUTTON LARGE ----- */
//		$elements = [
//			$button_selector . $button_selector . '--large',
//			'.aheto-form-btn' . $button_selector . '--large' . ' [type="submit"]'
//		];
//
//		aheto_add_props($css['global'][aheto_implode($elements)], Sanitize::spacing($button_large['padding']));
//		$css['global'][aheto_implode($elements)]['font-size']      = Sanitize::size($button_large['font_size']);
//		$css['global'][aheto_implode($elements)]['letter-spacing'] = Sanitize::size($button_large['letter_spacing']);


//		$breakpoints = [
////		'tablet' => '@media (max-width: 991px)',
//			'mobile' => '@media (max-width: 767px)',
//		];
//
//		foreach ( $breakpoints as $key => $breakpoint ) {
//
//			if ( is_array( $button_large['mobile_padding'] ) && ! empty( $button_large['mobile_padding'] ) ) {
//				aheto_add_props($css[$breakpoint][aheto_implode($elements)], Sanitize::spacing($button_large['mobile_padding']));
//			}
//		}


	/* ----- BUTTON SMALL ----- */
//		$elements = [
//			$button_selector . $button_selector . '--small',
//			'.aheto-form-btn' . $button_selector . '--small' . ' [type="submit"]'
//		];
//
//		aheto_add_props($css['global'][aheto_implode($elements)], Sanitize::spacing($button_small['padding']));
//		$css['global'][aheto_implode($elements)]['font-size']      = Sanitize::size($button_small['font_size']);
//		$css['global'][aheto_implode($elements)]['letter-spacing'] = Sanitize::size($button_small['letter_spacing']);


	/* ----- VIDEO BUTTON ----- */
	$button_video[ 'selector' ] = $video_selector;
	$button_video_small[ 'selector' ] = $video_selector . '--small';
	$button_video_large[ 'selector' ] = $video_selector . '--large';

	foreach ( [ $button_video, $button_video_small, $button_video_large ] as $button ) {
		
		if( isset( $button[ 'font_size' ] ) ) {
			$css[ 'global' ][ $button[ 'selector' ] ][ 'font-size' ] = Sanitize ::size ( $button[ 'font_size' ] );
		}
		if( isset( $button[ 'btn_size' ] ) ) {
			$css[ 'global' ][ $button[ 'selector' ] ][ 'width' ] = isset( $button[ 'btn_size' ] ) && !empty( $button[ 'btn_size' ] ) ? Sanitize ::size ( $button[ 'btn_size' ] ) : '';
			$css[ 'global' ][ $button[ 'selector' ] ][ 'height' ] = isset( $button[ 'btn_size' ] ) && !empty( $button[ 'btn_size' ] ) ? Sanitize ::size ( $button[ 'btn_size' ] ) : '';
		}
	}

//	if ( isset( $button['icon_size_large'] ) ) {
//		$elements = [
//			'.aheto-btn i.aheto-btn__icon--box',
//			'.aheto-btn span.aheto-btn__icon--box',
//		];
//		$css['global'][ aheto_implode( $elements ) ]['font-size'] = Sanitize::size( $button['icon_size_large'] );
//	}

//	$css['global']['.aheto-btn:hover']['color']               = $settings['active'];
//	$css['global']['.aheto-btn.aheto-btn--outline']['border'] = '1px solid ' . Color::fadeOut( $settings['grey'], 0.8 );
//	$css['global']['.aheto-btn.aheto-btn--outline:hover']     = [
//		'border-color' => $settings['active'],
//		'background'   => $settings['active'],
//		'color'        => $settings['white'],
//	];

//	$elements = [
//		'.aheto-btn.aheto-btn--trans',
//		'.aheto-btn.aheto-btn--inline',
//		'.aheto-btn.aheto-btn--underline',
//	];
//	$css['global'][ aheto_implode( $elements ) ]['color']                                 = Sanitize::color( $button['background'] );
//	$css['global'][ aheto_implode( aheto_map_selector( $elements, ':hover' ) ) ]['color'] = Color::setAlpha( $button['background'], 0.6 );
//	$css['global']['.aheto-btn.aheto-btn--underline:after']['background-color']           = Sanitize::color( $button['background'] );
//	$css['global']['.aheto-btn.aheto-btn--underline:hover:after']['background-color']     = Color::setAlpha( $button['background'], 0.6 );

	// Box Shadow.
//	$css['global']['.aheto-btn.aheto-btn--shadow:not(.aheto-btn--circle)']['box-shadow'] = Sanitize::box_shadow( $button['box_shadow'] );
//	$button_circle_shadow['color'] = isset( $button['background'] ) ? $button['background'] : '';
//	$css['global']['.aheto-btn.aheto-btn--shadow.aheto-btn--circle']['box-shadow'] = Sanitize::box_shadow( $button_circle_shadow );

//	$css['global']['.aheto-btn--large']['border-radius']  = aheto_mixin_btn_radius(
//		isset( $button['border_radius'] ) ? $button['border_radius'] : 0,
//		absint( $css['global']['.aheto-btn']['line-height'] ),
//		absint( $css['global']['.aheto-btn--large']['font-size'] ),
//		absint( $button_large['padding']['vertical'] ),
//		absint( $button['border']['all'] )
//	);

//	$css['global']['.aheto-btn--small']['border-radius']  = aheto_mixin_btn_radius(
//		isset( $button['border_radius'] ) ? $button['border_radius'] : 0,
//		absint( $css['global']['.aheto-btn']['line-height'] ),
//		absint( $css['global']['.aheto-btn--small']['font-size'] ),
//		absint( $button_small['padding']['vertical'] ),
//		absint( $button['border']['all'] )
//	);

	// Button Light.
//	$button_light                       = $settings['button_light'];
//	$css['global']['.aheto-btn--light'] = [
//		'border-color' => Sanitize::color( $button_light['border'] ),
//		'background'   => Sanitize::color( $button_light['background'] ),
//		'color'        => Sanitize::color( $button_light['color'] ),
//	];
//
//	$elements = [
//		'.aheto-btn--light.aheto-btn--trans',
//		'.aheto-btn--light.aheto-btn--inline',
//		'.aheto-btn--light.aheto-btn--underline',
//	];
//	$css['global'][ aheto_implode( $elements ) ]['color']                                 = Sanitize::color( $button_light['background'] );
//	$css['global'][ aheto_implode( aheto_map_selector( $elements, ':hover' ) ) ]['color'] = '#fff';
//	$css['global']['.aheto-btn--light.aheto-btn--underline:after']['color']               = Sanitize::color( $button_light['background'] );
//	$css['global']['.aheto-btn--light.aheto-btn--shadow:hover']['color']                  = '#fff';
//	$css['global']['.aheto-btn--light.aheto-btn--shadow:hover']['border']                 = '1px solid ' . Color::setAlpha( '#fff', 0.7 );

//	$elements = [
//		'.aheto-btn--dark.aheto-btn--trans',
//		'.aheto-btn--dark.aheto-btn--inline',
//		'.aheto-btn--dark.aheto-btn--underline',
//	];
//	$css['global'][ aheto_implode( $elements ) ]['color']                  = Sanitize::color( $button_dark['background'] );
//	$css['global']['.aheto-btn--dark.aheto-btn--underline:after']['color'] = Sanitize::color( $button_dark['background'] );

	// Dark Box Shadow.
//	$css['global']['.aheto-btn--dark.aheto-btn--shadow:not(.aheto-btn--circle)']['box-shadow'] = Sanitize::box_shadow( $button_dark['box_shadow'] );
//	$button_circle_shadow['color'] = $button_dark['background'];
//	$css['global']['.aheto-btn--dark.aheto-btn--shadow.aheto-btn--circle']['box-shadow'] = Sanitize::box_shadow( $button_circle_shadow );

	// Button Alter.
//	$button_alter                       = $settings['button_secondary'];
//	$css['global']['.aheto-btn--alter'] = [
//		'border-color' => Sanitize::color( $button_alter['border'] ),
//		'background'   => Sanitize::color( $button_alter['background'] ),
//		'color'        => Sanitize::color( $button_alter['color'] ),
//	];
//
//	$elements = [
//		'.aheto-btn--alter.aheto-btn--trans',
//		'.aheto-btn--alter.aheto-btn--inline',
//		'.aheto-btn--alter.aheto-btn--underline',
//	];
//	$css['global'][ aheto_implode( $elements ) ]['color']                              = Sanitize::color( $button_alter['background'] );
//	$css['global']['.aheto-btn--alter.aheto-btn--underline:after']['background-color'] = Sanitize::color( $button_alter['background'] );
//	$css['global']['.aheto-btn--alter.aheto-btn--shadow:hover']['color']               = '#fff';
//	$css['global']['.aheto-btn .aheto-btn__icon--box:after']['background-color']       = Sanitize::color( $button_alter['background'] );

	// Alter Box Shadow.
//	$elements = [
//		'.aheto-btn--alter.aheto-btn--shadow.aheto-btn--circle',
//		'.aheto-btn--gradient.aheto-btn--shadow.aheto-btn--circle',
//	];
//	$css['global']['.aheto-btn--alter.aheto-btn--shadow:not(.aheto-btn--circle)']['box-shadow'] = Sanitize::box_shadow( $button_alter['box_shadow'] );
//	$button_circle_shadow['color']                             = $button_alter['background'];
//	$css['global'][ aheto_implode( $elements ) ]['box-shadow'] = Sanitize::box_shadow( $button_circle_shadow );
//	$css['global']['.aheto-btn--alter .aheto-btn__icon--box:after']['background-color'] = Sanitize::color( $button['background'] );

	// Button Transparent.
//	$css['global']['.aheto-btn--trans']['background-color'] = 'transparent';

	// Big Button.
//	$button_big = $settings['button_big'];
//	aheto_add_props( $css['global']['.aheto-btn--rect'], Sanitize::spacing( $button_big['padding'] ) );
//	$css['global']['.aheto-btn--rect']['font-size']      = Sanitize::size( $button_large['font_size'] );
//	$css['global']['.aheto-btn--rect']['letter-spacing'] = Sanitize::size( $button_large['letter_spacing'] );

//	// Big Gradient.
//	$button_gradient                       = $settings['button_gradient'][0];
//	$css['global']['.aheto-btn--gradient'] = [
//		'border'     => '0',
//		'background' => [ sprintf( 'linear-gradient( %s, %s, %s )', $button_gradient['default'], $settings['active'], $settings['alter'] ) ],
//	];
//	$css['global']['.aheto-btn--gradient.aheto-btn--circle'] = [
//		'background' => [ sprintf( 'linear-gradient( %s, %s 10%%, %s 80%% )', $button_gradient['circle'], $settings['active'], $settings['alter'] ) ],
//	];

//	// Button Circle.
//	$css['global']['.aheto-btn--circle']['width']       = Sanitize::size( $button_circle['width'] );
//	$css['global']['.aheto-btn--circle']['height']      = Sanitize::size( $button_circle['height'] );
//	$css['global']['.aheto-btn--circle i']['font-size'] = Sanitize::size( $button_circle['icon_size'] );

//	$css['global']['.aheto-btn__icon--default-color']['color']     = $css['global']['.aheto-btn']['color'];
//	$css['global']['.aheto-btn__icon--box:after']['border-radius'] = aheto_mixin_btn_radius(
//		$button['border_radius'],
//		absint( $css['global']['.aheto-btn']['line-height'] ),
//		absint( $css['global']['.aheto-btn']['font-size'] ),
//		absint( $button['padding']['vertical'] ),
//		absint( $button['border']['all'] )
//	);
}

/**
 * Form CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_forms ( &$css, $settings ){
	
	$input = isset( $settings[ "input" ] ) ? $settings[ "input" ] : array();
	$textarea = isset( $settings[ "textarea" ] ) ? $settings[ "textarea" ] : array();
	$input[ 'selector' ] = 'body input';
	$textarea[ 'selector' ] = 'body textarea';

	$select = isset( $settings[ "select" ] ) ? $settings[ "select" ] : array();
	$select[ 'selector' ] = 'body select';


	foreach ( [ $input, $textarea, $select] as $item ) {

		if( isset( $item[ 0 ][ 'font' ] ) && !empty( $item[ 0 ][ 'font' ] ) ) {
			aheto_add_props ( $css[ 'global' ][ $item[ 'selector' ] ], Sanitize ::typography ( $item[ 0 ][ 'font' ] ) );
		}
		
		if( isset( $item[ 0 ][ 'border' ] ) && !empty( $item[ 0 ][ 'border' ] ) ) {
			aheto_add_props ( $css[ 'global' ][ $item[ 'selector' ] ], Sanitize ::border ( $item[ 0 ][ 'border' ] ) );
		}
		
		if ( isset( $item[ 0 ][ 'box_shadow' ] ) && !empty( $item[ 0 ][ 'box_shadow' ] ) ) {
			$css[ 'global' ][ $item[ 'selector' ] ][ 'box-shadow' ] = Sanitize ::box_shadow ( $item[ 0 ][ 'box_shadow' ] );
		}
		
		if ( isset( $item[ 0 ][ 'padding' ] ) && !empty( $item[ 0 ][ 'padding' ] ) ) {
			aheto_add_props ( $css[ 'global' ][ $item[ 'selector' ] ], Sanitize ::spacing ( $item[ 0 ][ 'padding' ] ) );
		}


		if ( isset( $item[ 0 ][ 'background' ] ) && !empty( $item[ 0 ][ 'background' ] ) ) {
			$css[ 'global' ] [ $item[ 'selector' ] ] [ 'background' ] = Sanitize ::color ( $item[ 0 ][ 'background' ] );
		}

		$elements_hover = [
			$item[ 'selector'] . ':hover ',
		];
		if ( isset( $item[ 0 ][ 'border_hover' ] ) && !empty( $item[ 0 ][ 'border_hover' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_hover )]['border-color'] = Sanitize::color( $item[ 0 ][ 'border_hover' ] );
		}
		if ( isset( $item[ 0 ][ 'border_radius' ] ) && !empty( $item[ 0 ][ 'border_radius' ] ) ) {
			$css[ 'global' ] [ $item[ 'selector' ] ] [ 'border-radius' ] = Sanitize ::size ( $item[ 0 ][ 'border_radius' ] );
		}
		if ( isset( $item[ 0 ][ 'height_textarea' ] ) && !empty( $item[ 0 ][ 'height_textarea' ] ) ) {
			$css[ 'global' ] [ $item[ 'selector' ] ] [ 'min-height' ] = Sanitize ::size ( $item[ 0 ][ 'height_textarea' ] );
		}
		if ( isset( $item[ 0 ][ 'width_textarea' ] ) && !empty( $item[ 0 ][ 'width_textarea' ] ) ) {
			$css[ 'global' ] [ $item[ 'selector' ] ] [ 'min-width' ] = Sanitize ::size ( $item[ 0 ][ 'width_textarea' ] );
		}

	}

	foreach ( [ $input, $textarea] as $item ) {
		$elements_placeholder = [
			$item[ 'selector'] . '::-webkit-input-placeholder ',
		];
		if ( isset( $item[ 0 ][ 'color_placeholder' ] ) && !empty( $item[ 0 ][ 'color_placeholder' ] ) ) {
			$css[ 'global' ][ aheto_implode ( $elements_placeholder )]['color'] = Sanitize::color( $item[ 0 ][ 'color_placeholder' ] );
		}
	}

	$checkbox = isset( $settings[ "checkbox" ] ) ? $settings[ "checkbox" ] : array();
	$checkbox[ 'selector' ] = 'body input[type=checkbox]';


	if ( isset( $checkbox[ 0 ][ 'box_shadow' ] ) && !empty( $checkbox[ 0 ][ 'box_shadow' ] ) ) {
		$css[ 'global' ][ $checkbox[ 'selector' ] ][ 'box-shadow' ] = Sanitize ::box_shadow ( $checkbox[ 0 ][ 'box_shadow' ] );
	}
	
	if ( isset( $checkbox[ 0 ][ 'border' ] ) && !empty( $checkbox[ 0 ][ 'border' ] ) ) {
		aheto_add_props ( $css[ 'global' ][ $checkbox[ 'selector' ] ], Sanitize ::border ( $checkbox[ 0 ][ 'border' ] ) );
	}

	if ( isset( $checkbox[ 0 ][ 'border_radius' ] ) && !empty( $checkbox[ 0 ][ 'border_radius' ] ) ) {
		$css[ 'global' ] [ $checkbox[ 'selector' ] ] [ 'border-radius' ] = Sanitize ::size ( $checkbox[ 0 ][ 'border_radius' ] );
	}

	if ( isset( $checkbox[ 0 ][ 'background' ] ) && !empty( $checkbox[ 0 ][ 'background' ] ) ) {
		$css[ 'global' ] [ $checkbox[ 'selector' ] ] [ 'background' ] = Sanitize ::color ( $checkbox[ 0 ][ 'background' ] );
	}

	$elements_hover = [
		'body input[type="submit"]:hover',
	];
	if ( isset( $checkbox[ 0 ][ 'border_hover' ] ) && !empty( $checkbox[ 0 ][ 'border_hover' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $elements_hover )]['border-color'] = Sanitize::color( $checkbox[ 0 ][ 'border_hover' ] );
	}

}

/**
 * Form CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_breakpoints ( &$css, $settings ){
	
	if ( !isset( $content_width ) ) {
		$content_width = array();
	}
	
	if ( !isset( $tablet_breakpoint ) ) {
		$tablet_breakpoint = array();
	}
	
	if ( !isset( $mobile_breakpoint ) ) {
		$mobile_breakpoint = array();
	}
	
	if ( isset( $settings[ "content_width" ] ) && !empty( $settings[ "content_width" ] ) ) {
		$content_width = $settings[ "content_width" ];
	}
	
	if ( isset( $settings[ "tablet_breakpoint" ] ) && !empty( $settings[ "tablet_breakpoint" ] ) ) {
		$tablet_breakpoint = $settings[ "tablet_breakpoint" ];
	}
	
	if ( isset( $settings[ "mobile_breakpoint" ] ) && !empty( $settings[ "mobile_breakpoint" ] ) ) {
		$mobile_breakpoint = $settings[ "mobile_breakpoint" ];
	}
}


/**
 * Blocks CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_blocks ( &$css, $settings )
{

	// Titlebar.
//	$css['global']['.aheto-titlebar__overlay--grad']['background'][]            = sprintf('linear-gradient( 36deg, %s 0%%, %s 100%% )', $settings['black'], $settings['dark']);
//	$css['global']['.aheto-titlebar__input form input[type=text]::placeholder'] = $settings['primary_font'];

//	 Titlebar Colors.
//	$css['global']['.aheto-titlebar .c-light']['background-color']   = $settings['light'];
//	$css['global']['.aheto-titlebar .c-dark-2']['background-color']  = $settings['dark2'];
//	$css['global']['.aheto-titlebar .c-alter']['background-color']   = $settings['alter'];
//	$css['global']['.aheto-titlebar .c-alter-2']['background-color'] = $settings['alter2'];
//	$css['global']['.aheto-titlebar .c-alter-3']['background-color'] = $settings['alter3'];

	// Portfolio.
//	$css['global']['.aheto-pf__close']['color']                                      = $settings['light'];
//	$css['global']['.aheto-pf--metro .aheto-pf__content:before']['background-color'] = Color::setAlpha($settings['dark'], 0.9);
//	$css['global']['.aheto-pf--grid .aheto-pf__content:hover']['box-shadow']         = '0 0 43px 0 ' . Color::setAlpha($settings['active'], 0.09);
//	$css['global']['.portfolio-new .aheto-heading__desc']['color']                   = Color::fadeOut($settings['grey'], 0.5);

//	$elements                                                                              = [
//		'.single__portfolio--2 .aheto-socials--circle .aht-socials__link',
//		'.single__portfolio--3 .aheto-socials--circle .aht-socials__link',
//		'.single__portfolio--4 .aheto-socials--circle .aht-socials__link',
//		'.single__portfolio--5 .aheto-socials--circle .aht-socials__link',
//		'.single__portfolio--7 .aheto-socials--circle .aht-socials__link',
//	];
//	$css['global'][aheto_implode($elements)]['border-color']                               = Color::fadeOut($settings['grey'], 0.7);
//	$css['global'][aheto_implode(aheto_map_selector($elements, ':hover'))]['border-color'] = $settings['active'];

	// Courses.
//	$css['global']['.aht-course--edu .aht-course__ovrl']['background-color']                                   = Color::setAlpha($settings['active'], 0.9);
//	$css['global']['.aht-course-det--edu .aht-course-det__cmnts .comment-form textarea::placeholder']['color'] = $settings['grey'];
//	$css['global']['.aht-course-det--edu .aht-course-det__cmnts .column input::placeholder']['color']          = $settings['grey'];

//	$elements = [
//		'.aht-course-det--edu .aht-course-det__cmnts .comment-form textarea:focus',
//		'.aht-course-det--edu .aht-course-det__cmnts .column input:focus',
//	];
//
//	$css['global'][aheto_implode($elements)] = [
//		'border'     => '1px solid ' . $settings['dark'],
//		'box-shadow' => '0 15px 30px 0 ' . Color::setAlpha($settings['dark'], 0.1),
//	];
//
//	// Event Chruch.
//	$elements = [
//		'.aht-event--chr-1 .aht-event__link:hover',
//		'.aht-event--chr-2 .aht-event__link:hover',
//	];
//
//	$css['global'][aheto_implode($elements)] = [
//		'border-color'     => $settings['dark2'],
//		'background-color' => $settings['dark2'],
//	];
//
//	// Event Education.
//	$elements                                          = [
//		'.aht-event--edu-2 .aht-event__link',
//		'.aht-ev-det--edu .aht-ev-det__number-q',
//	];
//	$css['global'][aheto_implode($elements)]['border'] = '2px solid ' . $settings['dark'];
//
//	$css['global']['.aht-ev-det--edu .aht-ev-det__sched-unit.active']['border-bottom'] = '2px solid ' . $settings['dark'];
//	$css['global']['.aht-ev-det--edu .aht-ev-det__sb']['box-shadow']                   = '0 0 40px 0 ' . Color::setAlpha($settings['dark'], 0.1);
//	$css['global']['.aht-ev-det--edu .aht-ev-det__select:focus']['box-shadow']         = '0 15px 30px 0 ' . Color::setAlpha($settings['dark'], 0.1);
//
//	// Grid.
//	$css['@media screen and (min-width: 1025px)']['.aht-grid-1--edu .aht-grid-1__item-inner:hover']['box-shadow'] = '0 0 43px 0 ' . Color::setAlpha($settings['dark'], 0.09);
//	$css['@media screen and (max-width: 1024px)']['.aht-grid-1--edu .aht-grid-1__item-inner:hover']['box-shadow'] = '0 0 43px 0 ' . Color::setAlpha($settings['dark'], 0.09);
//
//	// Blog - Yoga.
//	$css['global']['.aht-sidebar-yoga .search-field::placeholder']['color']     = $settings['grey'];
//	$css['global']['.aht-blog-yoga__img:after']['background-color']             = Color::setAlpha($settings['dark'], 0.8);
//	$css['global']['.aht-blog-yoga__cat']['background-color']                   = $settings['alter2'];
//	$css['global']['.aht-blog-yoga__cat--c-2']['background-color']              = $settings['alter'];
//	$css['global']['.aht-blog-yoga__cat--c-4']['background-color']              = $settings['alter3'];
//	$css['@media screen and (min-width: 1025px)']['.aht-blog-yoga__link:hover'] = [
//		'border-color'     => $settings['alter2'],
//		'background-color' => $settings['alter2'],
//	];
//	$css['global']['.aht-post-yoga__likes:hover']['box-shadow']                 = '0 0 20px 0 ' . Color::setAlpha($settings['active'], 0.13);
//
//	$elements                                                = [
//		'.aht-post-yoga__likes:active',
//		'.aht-sidebar-yoga .widget_categories a:hover',
//		'.aht-sidebar-yoga .aht-widget-advert__link:hover',
//	];
//	$css['global'][aheto_implode($elements)]['border-color'] = $settings['active'];
//
//	$css['global']['.aht-sidebar-yoga .aht-widget-posts__button.active']['border-bottom'] = '2px solid ' . $settings['active'];
//
//	$css['global']['.aht-sidebar-yoga .search-field:focus'] = [
//		'border'     => '1px solid ' . $settings['active'],
//		'box-shadow' => '0 15px 30px 0 ' . Color::setAlpha($settings['active'], 0.1),
//	];
//
//	// Blog - Education.
//	$css['global']['.aht-post-edu__likes:hover']['box-shadow']                   = '0 0 20px 0 ' . Color::setAlpha($settings['dark'], 0.13);
//	$css['global']['.aht-comm-edu .column input::placeholder']['color']          = $settings['grey'];
//	$css['global']['.aht-comm-edu .comment-form textarea::placeholder']['color'] = $settings['grey'];
//
//	$elements = [
//		'.aht-comm-edu .comment-form textarea:focus',
//		'.aht-comm-edu .column input:focus',
//	];
//
//	$css['global'][aheto_implode($elements)] = [
//		'border'     => '1px solid ' . $settings['dark'],
//		'box-shadow' => '0 15px 30px 0 ' . Color::setAlpha($settings['dark'], 0.1),
//	];
//
//	// Blog - Travel.
//	$elements                                                   = [
//		'.aht-blog-trvl__icon',
//		'.aht-post-trvl__tags-link:hover',
//		'.aht-post-trvl__author-link:hover',
//	];
//	$css['global'][aheto_implode($elements)]['color']           = $settings['alter'];
//	$css['global']['.aht-post-trvl__likes:hover']['box-shadow'] = '0 0 20px 0 ' . Color::setAlpha($settings['dark'], 0.13);
//
//	// Header.
//	$elements                                                    = [
//		'.main-header__toolbar-wrap--solid',
//		'.aheto-header-4__logo',
//		'.aheto-header-6__search input[type=text]',
//	];
//	$css['global'][aheto_implode($elements)]['background-color'] = $settings['light'];
//
//	$elements                                                 = [
//		'.aheto-header-1__toolbar',
//		'.aheto-header-1 .mega-menu__title',
//	];
//	$css['global'][aheto_implode($elements)]['border-bottom'] = '1px solid ' . $settings['alter3'];
//
//	$elements                                         = [
//		'.aheto-header-1__detail-icon',
//		'.aheto-header-1 .mega-menu__title',
//	];
//	$css['global'][aheto_implode($elements)]['color'] = $settings['alter3'];
//
//	$css['global']['.aheto-header-1__nav-wrap']['background'][] = sprintf('linear-gradient( %1$s, %1$s ) no-repeat 950px 0', $settings['alter']);
//
//	$css['global']['.aheto-header-1__nav'] = [
//		'background-color' => $settings['alter'],
//		'box-shadow'       => '0 0 30px 0 ' . Color::setAlpha($settings['alter'], 0.3),
//	];
//
//	$css['global']['.aheto-header-1 .aheto-socials__icon']['color']               = Color::lighten($settings['grey'], 15);
//	$css['global']['.aheto-header-3 .aheto-btn--light:hover']['border']           = '1px solid ' . Color::setAlpha($settings['button_light']['border'], 0.5);
//	$css['global']['.aheto-header-3 .aheto-btn--light:hover']['background-color'] = $settings['button_light']['background'];
//
//	$elements                                                       = [
//		'.aheto-header-6 .aht-socials__link:hover',
//		'.aheto-header-6 .aht-socials.aheto-socials--circle .aht-socials__link:hover',
//	];
//	$css['global'][aheto_implode($elements)]['border-color']        = $settings['active'];
//	$css['global']['.aheto-header-7__inner']['background-color']    = $settings['dark2'];
//	$css['global']['.aheto-header-7__contact .logo__text']['color'] = $settings['dark2'];
//
//	$css['global']['.aheto-header-8 .aheto-btn:hover']['background-color'] = $settings['alter2'];
//	$css['global']['.aheto-header-8__search-icon:hover']['color']          = $settings['alter2'];
//
//	$elements                                         = [
//		'.aheto-header-9 .menu-item > a:hover',
//		'.aheto-header-9 .menu-item > a:hover + span',
//		'.aheto-header-9 .menu-item:hover > a',
//		'.aheto-header-9 .menu-item:hover > a + span',
//	];
//	$css['global'][aheto_implode($elements)]['color'] = 'rgba(255, 255, 255, 0.75)';
//
//	$elements                                         = [
//		'.aheto-header-9 .sub-menu .menu-item:hover > a',
//		'.aheto-header-9 .sub-menu .menu-item:hover > a + span',
//		'.aheto-header-9 .sub-menu .menu-item a:hover',
//		'.aheto-header-9 .sub-menu .menu-item a:hover + span',
//		'.aheto-header-9 .authentication__sign-in:hover',
//	];
//	$css['global'][aheto_implode($elements)]['color'] = $settings['alter'];
//
//	$css['global']['.aheto-header-9 .authentication__sign-up:hover']['background-color'] = $settings['alter'];
//	$css['global']['.aheto-header-9 .authentication__sign-up:hover']['color']            = '#fff';
//
//	$css['global']['.aheto-header-11 .hamburger-inner']['border-top']    = '1px solid ' . Color::setAlpha($settings['dark'], 0.5);
//	$css['global']['.aheto-header-11 .hamburger-inner']['border-bottom'] = '1px solid ' . Color::setAlpha($settings['dark'], 0.5);
//	$css['global']['.aheto-header-11 .aheto-socials__icon']['color']     = $settings['light'];
//
//	$css['global']['.aheto-header-12 form input']['border-bottom']      = '1px solid ' . $settings['light'];
//	$css['global']['.aheto-header-12 form input:focus']['border-color'] = $settings['active'];
//
//	$css['global']['.aheto-header-14__logo']['background-color']         = $settings['alter'];
//	$css['global']['.aheto-header-14__button-icon:hover']['color']       = $settings['alter'];
//	$css['global']['.aheto-header-14 .aht-socials__icon:hover']['color'] = $settings['alter'];
//
//	$css['global']['.main-header__widgets-area .aht-socials__item a']['border-color'] = $settings['grey'];
//
//	$active_40                                                                       = Color::ligthen($settings['active'], 40);
//	$active_40                                                                       = is_array($active_40) ? $active_40[0] : $active_40;
//	$css['global']['.main-header--grad .main-header__menu-wrap']['background'][]     = sprintf('linear-gradient( to bottom, %1$s 0%%, %2$s 100%% )', '#fff', $active_40);
//	$css['global']['.main-header--grad-hor .main-header__menu-wrap']['background'][] = sprintf('linear-gradient( to right, %1$s 0%%, %2$s 100%% )', '#fff', $active_40);
//
//	$css['global']['.main-header--solid .main-header__menu-wrap']['background-color'] = $settings['active'];
//
//	$elements                                         = [
//		'.main-header__toolbar-wrap .widget a:hover',
//		'.aht-socials__link:hover',
//		'.aht-socials__link:hover .aht-socials__icon.icon',
//	];
//	$css['global'][aheto_implode($elements)]['color'] = $settings['active'];
//
//	// Header - Responsive.
//	$css['@media screen and (max-width: 1230px)']['.aheto-header-1__nav-wrap']       = $css['global']['.aheto-header-1__nav'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-1 .mega-menu__col'] = [
//		'border' => '1px solid ' . $settings['alter3'],
//	];
//
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-2__line']['background-color']          = $settings['dark'];
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-2__menu']['border-bottom']             = '1px solid ' . Color::setAlpha($settings['dark'], 0.1);
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-2 .sub-menu .dropdown-btn']['color']   = $settings['dark'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-2 .mega-menu__title']['border-bottom'] = '1px solid ' . Color::setAlpha($settings['dark'], 0.1);
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-2 .mega-menu__col']                    = [
//		'padding'      => '30px 20px',
//		'border-right' => '1px solid ' . Color::setAlpha($settings['dark'], 0.1),
//	];
//
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-3__menu']['background-color']            = $settings['dark'];
//	$css['@media screen and (max-width: 1230px)']['.aheto-header-3__inner']['background-color']           = $settings['dark'];
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-3 .main-menu > .menu-item > a']['color'] = Color::lighten($settings['active'], 20);
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-3 .sub-menu']['box-shadow']              = '1.169px 3.825px 15.66px 2.34px ' . Color::setAlpha($settings['active'], 0.2);
//
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-4 .main-menu .menu-item a']['color']                    = $settings['dark'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-4 .main-menu > .menu-item > a']['color']                = $settings['dark'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-4 .sub-menu .menu-item a']['color']                     = $settings['dark'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-4 .sub-menu .menu-item:hover > a']['color']             = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-4 .sub-menu .menu-item:hover > .dropdown-btn']['color'] = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-4 .mega-menu__title']['color']                          = $settings['grey'];
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-4 .mega-menu__title']['color']                          = $settings['active'];
//
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-5 .mega-menu__title']['color']                           = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-5 .main-menu > .menu-item:before']['background-color']   = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-5 .main-menu .menu-item:hover > a']['color']             = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-5 .main-menu .menu-item:hover > .dropdown-btn']['color'] = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-5 .sub-menu']['border-top']                              = '2px solid ' . $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-5 .mega-menu__col']['border-top']                        = '2px solid ' . $settings['active'];
//
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-6 .main-menu > .menu-item > a:before']['background-color'] = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-6 .sub-menu']['background-color']                          = $settings['dark'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-6 .sub-menu .menu-item:hover > a']['color']                = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-6 .sub-menu .menu-item:hover > .dropdown-btn']['color']    = $settings['active'];
//
//	$elements = [
//		'.aheto-header-7__inner',
//		'.aheto-header-7__menu',
//	];
//
//	$dark2_7                                                                                = Color::ligthen($settings['dark2'], 7);
//	$dark2_7                                                                                = is_array($dark2_7) ? $dark2_7[0] : $dark2_7;
//	$css['@media screen and (max-width: 1024px)'][aheto_implode($elements)]['background'][] = sprintf('linear-gradient( to right, %1$s, %2$s )', $settings['dark2'], $dark2_7);
//
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-7 .main-menu .menu-item a']['color'] = $settings['grey'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-7 .sub-menu']['background-color']    = $settings['dark2'];
//
//	$elements                                                                               = [
//		'.aheto-header-8__inner',
//		'.aheto-header-8__menu',
//	];
//	$css['@media screen and (max-width: 1024px)'][aheto_implode($elements)]['background'][] = sprintf('linear-gradient( to right, %1$s, %2$s )', Color::darken($settings['active'], 10), $settings['active']);
//
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-8 .sub-menu .menu-item a']['color']                     = $settings['grey'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-8 .sub-menu .menu-item:hover > a']['color']             = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-8 .sub-menu .menu-item:hover > .dropdown-btn']['color'] = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-8 .sub-menu .dropdown-btn']['color']                    = $settings['grey'];
//
//	$elements                                                                                   = [
//		'.aheto-header-9__line',
//		'.aheto-header-9__menu',
//	];
//	$css['@media screen and (max-width: 1024px)'][aheto_implode($elements)]['background-color'] = $settings['active'];
//	$css['@media screen and (max-width: 1024px)'][aheto_implode($elements)]['background-image'] = sprintf('linear-gradient( to right, %1$s 0%%, %2$s 180%%)', $settings['active'], $settings['alter']);
//
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-10__menu']['background-color'] = $settings['active'];
//	$elements                                                                                   = [
//		'.aheto-header-10__menu .main-menu > .menu-item > a:hover',
//		'.aheto-header-10__menu .main-menu > .menu-item:hover > a',
//	];
//	$css['@media screen and (min-width: 1025px)'][aheto_implode($elements)]['background-color'] = Color::fadeOut($settings['dark'], 0.85);
//
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-10 .main-menu .menu-item a']['color']                  = $settings['dark'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-10 .sub-menu .menu-item a']['color']                   = $settings['grey'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-10 .sub-menu .menu-item:hover > a']['color']           = $settings['dark'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-10 .sub-menu .menu-item:hover .dropdown-btn']['color'] = $settings['dark'];
//
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-11 .dropdown-btn']['color'] = $settings['dark'];
//
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-12 .main-menu .menu-item a']['color']                     = $settings['grey'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-12 .main-menu .menu-item:hover > a']['color']             = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-12 .main-menu .menu-item:hover > .dropdown-btn']['color'] = $settings['active'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-12 .main-menu > .menu-item > a']['color']                 = $settings['dark'];
//
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-12 .main-menu .menu-item a']['color']     = $settings['active'];
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-12 .main-menu > .menu-item > a']['color'] = $settings['dark'];
//
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-12 .sub-menu']['box-shadow'] = '0px 0px 5px 0px ' . Color::setAlpha($settings['active'], 0.1);
//
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-12 .mega-menu__title']['color']                 = $settings['dark'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-12 .mega-menu__col:before']['background-color'] = $settings['light'];
//
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-12 .mega-menu__title ']['color'] = $settings['grey'];
//
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-12 .hamburger.is-active .hamburger-inner']['background-color'] = $settings['dark'];
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-12 .hamburger.is-active .hamburger-inner']['background-color'] = $settings['dark'];
//
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-12 .dropdown-btn']['border'] = '1px solid ' . $settings['light'];
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-12 .dropdown-btn']['color']  = $settings['dark'];
//
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-12__aside-overlay.is-open']['background-color'] = Color::setAlpha($settings['dark'], 0.7);
//
//	$elements                                                                        = [
//		'.aheto-header-13 .sub-menu .menu-item:hover > a',
//		'.aheto-header-13 .sub-menu .menu-item:hover > .dropdown-btn',
//		'.aheto-header-14 .sub-menu .menu-item a',
//		'.aheto-header-14 .sub-menu .dropdown-btn',
//		'.main-header .main-menu--ddt-classic .sub-menu .menu-item:hover > a',
//		'.main-header .main-menu--ddt-classic .sub-menu .menu-item:hover > .dropdown-btn',
//		'.main-header .menu-item:hover > a',
//		'.main-header .menu-item:hover > .dropdown-btn',
//		'.main-header .menu-item.current-menu-item > .dropdown-btn:before',
//	];
//	$css['@media screen and (min-width: 1025px)'][aheto_implode($elements)]['color'] = $settings['active'];
//
//	$elements                                                                        = [
//		'.main-header--fullscreen-menu .dropdown-btn:hover',
//		'.main-header--fullscreen-menu .menu-item a:hover',
//		'.main-header--fullscreen-menu.main-header--menu-dark .dropdown-btn:hover',
//		'.main-header--fullscreen-menu.main-header--menu-dark .menu-item a:hover',
//	];
//	$css['@media screen and (min-width: 1025px)'][aheto_implode($elements)]['color'] = $settings['active'] . '!important';
//
//	$elements                                                                        = [
//		'.aheto-header-13 .mega-menu__title',
//		'.aheto-header-14 .main-menu .menu-item a',
//		'.aheto-header-14 .mega-menu__title',
//		'.main-header .menu-item > a:hover',
//	];
//	$css['@media screen and (max-width: 1024px)'][aheto_implode($elements)]['color'] = $settings['active'];
//
//	$elements                                                                        = [
//		'.aheto-header-13 .sub-menu .menu-item a',
//		'.aheto-header-13 .sub-menu .dropdown-btn',
//		'.main-header .main-menu--ddt-default .sub-menu .menu-item > a:hover',
//		'.main-header .main-menu--ddt-default .sub-menu .menu-item:hover > .dropdown-btn',
//		'.main-header .main-menu--ddt-classic .sub-menu .menu-item > a',
//		'.main-header .main-menu--ddt-classic .sub-menu .menu-item > .dropdown-btn',
//	];
//	$css['@media screen and (min-width: 1025px)'][aheto_implode($elements)]['color'] = $settings['dark'];
//
//	$elements                                                                        = [
//		'.main-header--fullscreen-menu .dropdown-btn',
//		'.main-header--fullscreen-menu .menu-item a',
//		'.main-header--fullscreen-menu .mega-menu__title',
//	];
//	$css['@media screen and (min-width: 1025px)'][aheto_implode($elements)]['color'] = $settings['dark'] . '!important';
//
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-13__inner']['background-color'] = $settings['dark'];
//	$css['@media screen and (max-width: 1024px)']['.aheto-header-13__menu']['background'][]      = sprintf('linear-gradient( to bottom %1$s, %2$s )', $settings['dark'], Color::setAlpha($settings['dark'], 0.85));
//
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-13 .main-menu > .menu-item:before']['background-color'] = $settings['active'];
//
//	$elements                                                                        = [
//		'.aheto-header-14 .main-menu > .menu-item:hover > a',
//		'.aheto-header-14 .main-menu > .menu-item:hover > .dropdown-btn',
//		'.aheto-header-14 .sub-menu .menu-item:hover > a',
//		'.aheto-header-14 .sub-menu .menu-item:hover > .dropdown-btn',
//	];
//	$css['@media screen and (min-width: 1025px)'][aheto_implode($elements)]['color'] = $settings['alter'];
//
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-14 .sub-menu']['border-top']    = '3px solid ' . $settings['alter'];
//	$css['@media screen and (min-width: 1025px)']['.aheto-header-14 .mega-menu__title']['color'] = $settings['grey'];
//
//	$css['@media screen and (min-width: 1025px)']['.main-header .main-menu--ci-rounded-solid-bg > .menu-item:hover > a']['background-color'] = Color::setAlpha($settings['active'], 0.1);
//
//	$css['@media screen and (min-width: 1025px)']['.main-header .main-menu--ddt-default .sub-menu']['box-shadow'] = '0px 0px 13px 0px ' . Color::setAlpha($settings['active'], 0.09);
//
//	$elements                                                                        = [
//		'.main-header .main-menu--ddt-default .sub-menu .menu-item > a',
//		'.main-header .main-menu--ddt-classic .mega-menu__title',
//	];
//	$css['@media screen and (min-width: 1025px)'][aheto_implode($elements)]['color'] = $settings['grey'];
//
//	$elements                                                                                   = [
//		'.main-header .main-menu--ddt-default.main-menu--ddc-light .sub-menu',
//		'.main-header .main-menu--ddt-classic.main-menu--ddc-light .sub-menu',
//		'.main-header .main-menu--ddt-clean.main-menu--ddc-light .sub-menu',
//	];
//	$css['@media screen and (min-width: 1025px)'][aheto_implode($elements)]['background-color'] = $settings['light'];
//
//	$elements                                                                                   = [
//		'.main-header .main-menu--ddt-default.main-menu--ddc-dark .sub-menu',
//		'.main-header .main-menu--ddt-classic.main-menu--ddc-dark .sub-menu',
//		'.main-header .main-menu--ddt-clean.main-menu--ddc-dark .sub-menu',
//		'.main-header--fullscreen-menu.is-open .hamburger-inner',
//	];
//	$css['@media screen and (min-width: 1025px)'][aheto_implode($elements)]['background-color'] = $settings['dark'];
//
//	$elements                                                                             = [
//		'.main-header .main-menu--ddt-classic .sub-menu',
//		'.main-header .main-menu--ddt-clean .sub-menu',
//	];
//	$css['@media screen and (min-width: 1025px)'][aheto_implode($elements)]['box-shadow'] = '0px 0px 2px 0px ' . Color::setAlpha($settings['active'], 0.2);
//
//	$css['@media screen and (min-width: 1025px)']['.main-header .main-menu--ddt-clean.main-menu--ddc-dark .mega-menu__title']['color'] = $settings['light'];
//
//	$css['@media screen and (min-width: 1025px)']['.main-header--fullscreen-menu.main-header--menu-dark .main-header__menu-box']['background-color'] = Color::setAlpha($settings['dark'], 0.95);
//
//	$css['@media screen and (max-width: 1024px)']['.main-header--solid .main-header__menu-box']['background-color'] = $settings['active'];
//
//	$css['@media screen and (max-width: 1024px)']['.main-header--grad-hor .main-header__menu-box']['background-image'] = sprintf('linear-gradient( to right %1$s 0%%, %2$s 100%% )', $settings['white'], $active_40);
//
//	// Wrapp.
//	$css['global']['.bg-wrap-c-light']['background-color']   = $settings['light'];
//	$css['global']['.bg-wrap-c-dark-2']['background-color']  = $settings['dark2'];
//	$css['global']['.bg-wrap-c-alter']['background-color']   = $settings['alter'];
//	$css['global']['.bg-wrap-c-alter-2']['background-color'] = $settings['alter2'];
//	$css['global']['.bg-wrap-c-alter-3']['background-color'] = $settings['alter3'];
//
//	$css['global']['.home-event-wrap-upc-event']['background-image'][] = sprintf('linear-gradient( 140deg rgb(108,32,124) 0%%, %1$s 100%% )', $settings['active']);
//	$css['global']['.edu-wrap-2']['background-image'][]                = sprintf('linear-gradient( to right, %1$s, %1$s )', $settings['active']);
//	$css['global']['hr']['background']                                 = '#eee';
//	$css['global']['hr']['background-image'][]                         = 'linear-gradient( to right, rgba(238, 238, 238, 0), rgba(238, 238, 238, 1), rgba(238, 238, 238, 0) )';
//
//	// Footers.
//	$css['global']['.aheto-footer-1 .widget-title']['border-bottom'] = '1px solid ' . Color::setAlpha($settings['grey'], 0.25);
//	$elements                                                        = [
//		'.aheto-footer-11 .widget_aheto__link:hover',
//		'.aheto-footer-11 .widget_aheto__desc a:hover',
//		'.aheto-footer-11 .widget_nav_menu .menu-item a:hover',
//	];
//	$css['global'][aheto_implode($elements)]['color']                = $settings['alter'];
//
//	$elements                                              = [
//		'.aheto-footer-5 .widget_mc4wp_form_widget.aheto_mc_2 button[type=submit]:hover',
//		'.aheto-footer-5 .widget_mc4wp_form_widget.aheto_mc_2 input[type=submit]:hover',
//		'.aheto-footer-6 .widget_mc4wp_form_widget.aheto_mc_1 button[type=submit]:hover',
//		'.aheto-footer-6 .widget_mc4wp_form_widget.aheto_mc_1 input[type=submit]:hover',
//		'.aheto-footer-10 .widget_mc4wp_form_widget.aheto_mc_2 button[type=submit]:hover',
//		'.aheto-footer-10 .widget_mc4wp_form_widget.aheto_mc_2 input[type=submit]:hover',
//		'.aheto-footer-15 .widget_mc4wp_form_widget.aheto_mc_1 button[type=submit]:hover',
//		'.aheto-footer-15 .widget_mc4wp_form_widget.aheto_mc_1 input[type=submit]:hover',
//	];
//	$css['global'][aheto_implode($elements)]['background'] = Color::fadeOut($settings['active'], 0.2) . ' !important';
//
//	$css['global']['.aheto-footer-9 .widget_aheto__info--tel a:hover']['border-bottom'] = '1px solid ' . $settings['active'];
}

/**
 * Partials CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_partials ( &$css, $settings )
{

	// Partial - Heading.
//	$css['global']['.aheto-heading__title:after']['background-color']                            = $settings['alter'];
//	$css['global']['.aheto-heading--classic .aheto-heading__subtitle:after']['background-color'] = $settings['alter3'];

	// Partial - Titlebar.
//	$css['global']['.aht-tb--trvl .aht-tb__subtitle'] = $settings['tertiary_font'];

	// Partial - Filter.
//	$css['global']['.aht-filter--edu .aht-filter__input::placeholder']['color'] = $settings['dark'];

	// Partial - Filter - Travel.
//	$css['global']['.aht-filter-trvl__icon']['color']                    = $settings['alter'];
//	$css['global']['.aht-filter-trvl__submit:hover']['background-color'] = $settings['alter'];

	// Partial - Info block.
//	$css['global']['.aht-info__subtitle.c-light']['color']                = $settings['light'];
//	$css['global']['.aht-info__subtitle.c-dark-2']['color']               = $settings['dark2'];
//	$css['global']['.aht-info__subtitle.c-alter']['color']                = $settings['alter'];
//	$css['global']['.aht-info__subtitle.c-alter-2']['color']              = $settings['alter2'];
//	$css['global']['.aht-info__subtitle.c-alter-3']['color']              = $settings['alter3'];
//	$css['global']['.aht-info--yoga-course .aht-info__subtitle']['color'] = $settings['alter2'];

	// Partial - BG Image.
//	$elements                                         = [
//		'.aht-bq-img__bq:before',
//		'.aht-bq-img__bq:after',
//	];
//	$css['global'][aheto_implode($elements)]['color'] = Color::setAlpha($settings['active'], 0.9);
//
//	// Partial - Button.
//	$css['global']['.aheto-btn-container--fullwidth .aheto-btn:hover']['border-color'] = $settings['dark'];

	// Partial - Call to Action.
//	$elements                                          = [
//		'.aht-cta--classic .aht-cta__link',
//		'.aht-cta--classic .aht-cta__link:hover',
//	];
//	$css['global'][aheto_implode($elements)]['border'] = '1px solid ' . $settings['active'];

//	$elements                                          = [
//		'.aht-cta--modern .aht-cta__link.aheto-btn--trans',
//		'.aht-cta--modern .aht-cta__link:hover',
//	];
//	$css['global'][aheto_implode($elements)]['border'] = '1px solid ' . Color::setAlpha($settings['white'], 0.7);

//	$elements                                         = [
//		'.aht-cta--t-white .aht-cta__sub-title',
//		'.aht-cta--t-white .aht-cta__title',
//		'.aht-cta--t-white .aht-cta__desc',
//		'.aht-cta--t-white .aht-cta__tel',
//	];
//	$css['global'][aheto_implode($elements)]['color'] = $settings['white'];
//
//	$elements                                                    = [
//		'.aht-cta--yoga .aht-cta__link:hover',
//		'.aht-cta--trvl-2 .aht-cta__form [type=submit]:hover',
//	];
//	$css['global'][aheto_implode($elements)]['background-color'] = $settings['alter'];
//
//	$css['global']['.aht-cta--yoga .aht-cta__link:hover']['border-color'] = $settings['alter'];

	// Partial - Tour Detail.
//	$elements                                         = [
//		'.aht-td__tb-star',
//		'.aht-td__spec-icon',
//		'.aht-td__why-icon',
//	];
//	$css['global'][aheto_implode($elements)]['color'] = $settings['alter'];
//
//	$css['global']['.aht-td__submit:hover']['border-color']    = $settings['active'];
//	$css['global']['.aht-td__menu:before']['background-color'] = $settings['light'];
//	$css['global']['.aht-td__book-cost']['background'][]       = sprintf('linear-gradient( 24deg, %1$s, %2$s, %2$s )', $settings['alter'], $settings['active']);

//	$css['global']['.aht-td__element:focus']['border']     = '1px solid ' . $settings['active'];
//	$css['global']['.aht-td__element:focus']['box-shadow'] = '0 10px 20px 0 ' . Color::setAlpha($settings['dark'], 0.07);
//
//	// Partial - Tour.
//	$css['global']['.aht-tour--trvl .aht-tour__link:hover']['border-color'] = $settings['active'];
//	$css['global']['.aht-tour--trvl-2 .aht-tour__promo']['background'][]    = sprintf('linear-gradient( to right, %1$s, %2$s, %2$s )', $settings['alter'], $settings['active']);
//
//	// Partial - Services.
//	$css['global']['.aheto-services .c-light']['color']   = $settings['light'];
//	$css['global']['.aheto-services .c-dark-2']['color']  = $settings['dark2'];
//	$css['global']['.aheto-services .c-alter']['color']   = $settings['alter'];
//	$css['global']['.aheto-services .c-alter-2']['color'] = $settings['alter2'];
//	$css['global']['.aheto-services .c-alter-3']['color'] = $settings['alter3'];

//	$elements                                         = [
//		'.aheto-services--busns-event .aheto-services__link:hover',
//		'.aht-service--trvl .aht-service__link:hover',
//	];
//	$css['global'][aheto_implode($elements)]['color'] = $settings['alter'];
//
//	$css['global']['.aht-service--chr .aht-service__link:hover']['color'] = $settings['dark2'];
//
//	$elements                                                    = [
//		'.aheto-services__time',
//		'.aheto-services--chess .aheto-services__link:hover',
//	];
//	$css['global'][aheto_implode($elements)]['background-color'] = $settings['alter'];
//
//	$css['global']['.aheto-services--busns-event .aheto-services__time']['box-shadow'] = '0 0 32px 0 ' . Color::setAlpha($settings['active'], 0.3);

	// Partial - WPML Switcher.
//	$elements                                          = [
//		'.wpml-ls-legacy-dropdown-click a.wpml-ls-item-toggle:after',
//		'.wpml-ls-legacy-dropdown a.wpml-ls-item-toggle:after',
//	];
//	$css['global'][aheto_implode($elements)]['border'] = '1px solid ' . $settings['grey'];
//
//	// Partial - Searchbox.
//	$css['global']['.site-search .search-field']['color']                            = $settings['dark'];
//	$css['global']['.site-search .search-field::-webkit-input-placeholder']['color'] = $settings['dark'];
//	$css['global']['.site-search .search-field:-moz-placeholder']['color']           = $settings['dark'];
//	$css['global']['.site-search .search-field::-moz-placeholder']['color']          = $settings['dark'];
//	$css['global']['.site-search .search-field:-ms-input-placeholder']['color']      = $settings['dark'];
//
//	// Partial - Banner.
//	$elements                                                = [
//		'.aht-banner--travel-2 .aht-banner__link',
//		'.aht-banner--travel-3 .aht-banner__link',
//		'.aht-banner--yoga .aht-banner__link',
//		'.aht-banner--yoga-2 .aht-banner__link:nth-child(odd)',
//		'.aht-banner--construction .aht-banner__links a:nth-child(odd)',
//		'.aht-banner--edu--1 .aht-banner__link:not(:hover)',
//		'.aht-banner--edu--3 .aht-banner__link:nth-child(even)',
//	];
//	$css['global'][aheto_implode($elements)]['border-color'] = $settings['active'];
//
//	$elements                                                = [
//		'.aht-banner--yoga-3 .aht-banner__link',
//		'.aht-banner--yoga-3 .aht-banner__link:nth-child(even)',
//		'.aht-banner--edu--3 .aht-banner__link:hover',
//	];
//	$css['global'][aheto_implode($elements)]['border-color'] = $settings['dark'];
//
//	$elements                                                    = [
//		'.aht-banner--yoga-2 .aht-banner__link:hover',
//		'.aht-banner--yoga-3 .aht-banner__link:hover',
//	];
//	$css['global'][aheto_implode($elements)]['border-color']     = $settings['alter'];
//	$css['global'][aheto_implode($elements)]['background-color'] = $settings['alter'];
//
//	$css['global']['.aht-banner__overlay--2']['background'][]                    = sprintf('linear-gradient( 36deg, %1$s 0%%, %2$s 100%% )', $settings['black'], $settings['alter']);
//	$css['global']['.aht-banner__overlay--3']['background'][]                    = sprintf('linear-gradient( to right, transparent 10%%, %1$s )', Color::darken($settings['dark'], 30));
//	$css['global']['.aht-banner--with-promo .aht-banner__promo']['background'][] = sprintf('linear-gradient( 24deg, %1$s, %2$s )', $settings['alter'], $settings['active']);
//
//	// Partial - Pricing.
//	$css['global']['.aheto-pricing--alternative .aheto-pricing__header']['background-color'] = Color::setAlpha($settings['grey'], 0.1);
//	$css['global']['.aheto-pricing--alternative .aheto-pricing__btn']['border-color']        = Color::setAlpha($settings['grey'], 0.2);
//
//	$elements                                                    = [
//		'.aheto-pricing__footer .aheto-btn:hover',
//		'.aheto-pricing--tableColumn .aheto-pricing__btn:hover',
//	];
//	$button                                                      = $settings['button'];
//	$css['global'][aheto_implode($elements)]['color']            = $button['font']['color'];
//	$css['global'][aheto_implode($elements)]['background-color'] = $button['background'];
//
//	$css['global']['.aheto-pricing--home-event .aheto-pricing__header']['border-bottom']        = '1px dotted ' . $settings['active'];
//	$css['global']['.aheto-pricing--home-event .aheto-pricing__detail::after']['border-bottom'] = '1px solid ' . Color::setAlpha($settings['active'], 0.2);
//
//	$elements                                                = [
//		'.aheto-pricing--home-event .aheto-pricing__btn:hover',
//		'.aheto-pricing--home-education .aheto-pricing__btn:hover',
//		'.aht-pricing--business .aht-pricing__item-link:hover',
//		'.aht-pricing--edu .aht-pricing__link:hover',
//		'.aht-pricing--trvl .aht-pricing__link:hover',
//	];
//	$css['global'][aheto_implode($elements)]['border-color'] = $settings['active'];
//
//	$css['global']['.aheto-pricing--home-education']['border'] = '1px solid ' . Color::darken($settings['active'], 2);
//
//	$css['global']['.aht-pricing--business .aht-pricing__head-content']['border-right']     = '1px solid ' . Color::darken($settings['light'], 3);
//	$css['global']['.aht-pricing--business .aht-pricing__head-caption']['background-color'] = Color::darken($settings['light'], 3);
//	$css['global']['.aht-pricing--business .aht-pricing__item-caption']['background-color'] = Color::lighten($settings['alter'], 16);
//	$css['global']['.aht-pricing--business .aht-pricing__item-link']['border-color']        = Color::lighten($settings['light'], 2);
//	$css['global']['.aht-pricing--business .aht-pricing__item-link']['background-color']    = Color::lighten($settings['light'], 2);
//	$css['global']['.aht-pricing--business .aht-pricing__item-link:hover']['box-shadow']    = '0 0 32px 0 ' . Color::setAlpha($settings['active'], 0.3);
//	$css['global']['.aht-pricing--edu .aht-pricing__item:hover']['box-shadow']              = '0 0 46.98px 7.02px ' . Color::setAlpha($settings['dark2'], 0.05);
//
//	$elements                                                    = [
//		'.aht-pricing--edu .aht-pricing__item',
//		'.aht-pricing--trvl .aht-pricing__inner',
//	];
//	$css['global'][aheto_implode($elements)]['background-color'] = $settings['light'];
//
//	$css['@media screen and (min-width: 768px)']['.aheto-pricing--alternative:hover']['background-color']                     = $settings['active'];
//	$css['@media screen and (min-width: 768px)']['.aheto-pricing--alternative:hover .aheto-pricing__content']['border-color'] = $settings['active'];
//
//	$elements                                                                                  = [
//		'.aheto-pricing--alternative:hover .aheto-pricing__header',
//		'.aheto-pricing--tableColumn:hover .aheto-pricing__header',
//	];
//	$css['@media screen and (min-width: 768px)'][aheto_implode($elements)]['background-color'] = Color::darken($settings['active'], 6);
//
//	$button_light                                                                                                             = $settings['button_light'];
//	$css['@media screen and (min-width: 768px)']['.aheto-pricing--alternative:hover .aheto-pricing__btn']['color']            = Sanitize::color($button_light['color']);
//	$css['@media screen and (min-width: 768px)']['.aheto-pricing--alternative:hover .aheto-pricing__btn']['background-color'] = Sanitize::color($button_light['background']);
//
//	$css['@media screen and (max-width: 991px)']['.aheto-pricing--home-education:hover']['background-color'] = $settings['active'];
//
//	$css['@media screen and (min-width: 768px)']['.aht-pricing--business .aht-pricing__item:hover .aht-pricing__item-caption']['background-color'] = $settings['alter'];
//
//	$css['@media screen and (max-width: 991px)']['.aht-pricing--business .aht-pricing__item-link']['border-color']     = $settings['active'];
//	$css['@media screen and (max-width: 991px)']['.aht-pricing--business .aht-pricing__item-link']['background-color'] = $settings['active'];
//
//	// Partial - Time Scale.
//	$css['global']['.aheto-time-scale__item:before']['background-color'] = Color::setAlpha($settings['active'], 0.15);
//
//	// Partial - Instagram.
//	$css['global']['.aheto-instagram-gallery .aheto-btn.aheto-btn--light:hover']['border-color'] = $settings['active'];
//
//	// Partial - Single Elements.
//	$elements                                              = [
//		'.aheto-pricing--alternative:hover .aheto-pricing__header',
//		'.aheto-pricing--tableColumn:hover .aheto-pricing__header',
//	];
//	$css['global'][aheto_implode($elements)]['box-shadow'] = '0 15px 30px 0 ' . Color::setAlpha($settings['active'], 0.1);
//
//	$css['global']['.aheto-single-item:before']['font-family'] = $settings['headings']['font-family'];
//	$css['global']['.aheto-single-item:before']['font-size']   = $css['global']['h2']['font-size'];
//	$css['global']['.aheto-single-item:before']['line-height'] = $css['global']['h2']['line-height'];
//
//	// Partial - Content Blocks.
//	$css['global']['.aheto-content-block--business .aheto-btn:hover']['color'] = $settings['alter'];
//	$css['global']['.aheto-content-block--construction']['border-bottom']      = '1px solid ' . $settings['light'];
//
//	// Partial - Testimonials.
//	$css['global']['.tm--default:after']['background'] = $settings['active'];
//	$css['global']['.tm--default:hover']['box-shadow'] = '0 15px 30px 0 ' . Color::setAlpha($settings['button']['background'], 0.1);
//
//	$css['global']['.tm--business .tm__content']['box-shadow'] = '0 0 40px 10px ' . Color::setAlpha($settings['alter'], 0.08);
//	$css['global']['.tm--edu-2 .tm__content']['box-shadow']    = '0 0 40px 10px ' . Color::setAlpha($settings['dark'], 0.08);
//	$css['global']['.tm--yoga .tm__content:before']['color']   = $settings['alter3'];
//	$css['global']['.aht-tm--trvl .aht-tm__stars']['color']    = $settings['alter'];
//
//	$css['@media screen and (min-width: 1025px)']['.tm--edu:hover']['background-color'] = $settings['dark'];
//	$css['@media screen and (min-width: 1025px)']['.tm--edu:hover:before']['color']     = $settings['active'];
//
//	// Partial - Tabs.
//	$css['global']['.aheto-tab__box--overlay-1:before']['background-color'] = Color::setAlpha($settings['active'], 0.8);
//	$css['global']['.aheto-tab__box--overlay-2:before']['background'][]     = sprintf('linear-gradient( to right, %1$s, %2$s )', $settings['active'], $settings['alter']);
//	$css['global']['.aheto-tab__box--overlay-3:before']['background'][]     = sprintf('linear-gradient( to right, transparent, transparent 35%%, %1$s )', $settings['active']);
//	$css['global']['.aheto-tab__box--overlay-4:before']['background-color'] = Color::setAlpha($settings['black'], 0.5);
//
//	$css['global']['.aheto-tab--simple .aheto-tab__head']['box-shadow'] = '0 10px 30px 0 ' . Color::setAlpha($settings['active'], 0.1);
//	$css['global']['.aheto-tab--simple .aheto-tab__list-link']          = [
//		'color'         => $css['global']['p']['color'],
//		'border-right'  => '1px solid ' . Color::setAlpha($settings['button_dark']['background'], 0.1),
//		'border-bottom' => '1px solid ' . Color::setAlpha($settings['button_dark']['background'], 0.1),
//	];
//
//	$elements                                                = [
//		'.aheto-tab--simple .aheto-tab__list-link:hover',
//		'.aheto-tab--simple .aheto-tab__list-item.active a',
//	];
//	$css['global'][aheto_implode($elements)]['border-color'] = Color::setAlpha($settings['button']['background'], 0.33);
//	$css['global'][aheto_implode($elements)]['box-shadow']   = '1.169px 3.825px 15.66px 2.34px ' . Color::setAlpha($settings['button']['background'], 0.2);
//
//	$css['global']['.aheto-tab--business .aheto-tab__list-item']['color']                    = Color::darken($settings['light'], 2);
//	$css['global']['.aheto-tab--business .aheto-tab__list-link']['color']                    = $settings['alter'];
//	$css['global']['.aheto-tab--business .aheto-btn--light.aheto-btn--trans:hover']['color'] = $settings['alter'];
//	$css['global']['.aheto-tab--construction-home .aheto-tab__list-link']['color']           = $settings['light'];
//
//	$css['@media screen and (max-width: 1230px)']['.aheto-tab__box--overlay-3:before']['background'][]    = sprintf('linear-gradient( to right, transparent, %1$s )', $settings['active']);
//	$css['@media screen and (max-width: 991px)']['.aheto-tab__box--overlay-3:before']['background-color'] = $settings['active'];
//
////	// Partial - Progress.
////	$elements                                          = [
////		'.aheto-progress__chart-circle',
////		'.aheto-progress--simple .aheto-progress__chart-circle',
////	];
////	$css['global'][aheto_implode($elements)]['stroke'] = $settings['active'];
//
//	// Partial - Form.
//	$elements                                          = [
//		'.aheto-form--default .wpcf7-form-control:focus',
//		'.aheto-form--default .wpcf7-form-control.wpcf7-select:focus',
//	];
//	$css['global'][aheto_implode($elements)]['border'] = '1px solid ' . $settings['active'];
//
//	$elements                                                = [
//		'.aheto-form--yoga .wpcf7-form-control:focus',
//		'.aht-form--edu .wpcf7-submit:hover',
//		'.aht-form--trvl .wpcf7-form-control:focus',
//	];
//	$css['global'][aheto_implode($elements)]['border-color'] = $settings['active'];
//
//	$elements                                                = [
//		'.aht-form--edu .wpcf7-form-control:focus',
//		'.aht-form--edu .wpcf7-submit',
//	];
//	$css['global'][aheto_implode($elements)]['border-color'] = $settings['dark'];
//
//	$css['global']['.aheto-form--default .wpcf7-form-control:focus']['box-shadow']          = '0 15px 30px 0 ' . Color::setAlpha($settings['active'], 0.1);
//	$css['global']['.aheto-form--default .wpcf7-form-control.wpcf7-submit']['border-color'] = Color::setAlpha($settings['active'], 0);
//	$css['global']['.aheto-form--default .wpcf7-form-control.wpcf7-submit']['box-shadow']   = '1.169px 3.825px 15.66px 2.34px ' . Color::setAlpha($settings['active'], 0.2);
//
//	$css['global']['.aheto-form--pop-up .wpcf7-form .wpcf7-form-control:focus']['border-bottom']       = '1px solid ' . $settings['dark'];
//	$css['global']['.aheto-form--pop-up .wpcf7-form .wpcf7-form-control.wpcf7-submit']['border-color'] = Color::setAlpha($settings['active'], 0.5);
//
//	$css['global']['.aheto-form--saas .wpcf7-form .wpcf7-form-control.wpcf7-submit']['border-color'] = $settings['alter'];
//
//	$css['global']['.aheto-form--business .wpcf7-form-control.wpcf7-submit']['box-shadow'] = '0 0 32px 0 ' . Color::setAlpha($settings['alter'], 0.3);
//
//	$elements                                                    = [
//		'.aheto-form--saas .wpcf7-form .wpcf7-form-control.wpcf7-submit',
//		'.aheto-form-email--business .mc4wp-form-fields',
//		'.aht-form--trvl .wpcf7-submit:hover',
//	];
//	$css['global'][aheto_implode($elements)]['background-color'] = $settings['alter'];
//
//	$elements                                              = [
//		'.aht-form--edu .wpcf7-form-control:focus',
//		'.aht-form--trvl .wpcf7-form-control:focus',
//	];
//	$css['global'][aheto_implode($elements)]['box-shadow'] = '0 15px 30px 0 ' . Color::setAlpha($settings['dark'], 0.1);
//
//	// Partial - Socials.
//	$elements                                                             = [
//		'.aheto-socials--circle .aht-socials__link:hover',
//		'.aheto-socials--circle .active',
//		'.aheto-socials__item a:hover',
//	];
//	$css['global'][aheto_implode($elements)]['border-color']              = $settings['active'];
//	$css['global']['.aheto-socials--circle .aht-socials__link']['border'] = '1px solid ' . $settings['grey'];
//	$css['global']['.aht-socials--circle .aht-socials__link']['border']   = '1px solid ' . $settings['grey'];
//
//	// Partial - Contact.
//	$elements                                         = [
//		'.aheto-contact--business .aheto-contact__title',
//		'.aheto-contact--business .aheto-contact__link-map:hover',
//		'.aheto-contact--business .aheto-contact__link--email',
//		'.aht-contact--trvl .aht-contact__icon',
//		'.aht-contact--trvl .aht-contact__link:hover',
//		'.aht-contact--trvl .aht-contact__marker:hover',
//	];
//	$css['global'][aheto_implode($elements)]['color'] = $settings['alter'];
//
//	$elements                                                    = [
//		'.aht-contact--trvl .aht-contact__link:hover:after',
//		'.aht-contact--trvl .aht-contact__marker:hover:after',
//	];
//	$css['global'][aheto_implode($elements)]['background-color'] = $settings['alter'];
//
//	$css['global']['.aheto-contact--home-event .aheto-contact__link:hover']['text-shadow'] = '0 0 0.5px ' . $settings['dark'];
//	$css['global']['.aheto-contact--business .aheto-contact__icon']['color']               = Color::darken($settings['alter3'], 13);
//
//	// Partial - Accordion.
//	$css['global']['.aheto-accordion__title.active']['border-bottom'] = '2px solid ' . $settings['active'];
//
//	// Partial - Counter.
//	$css['global']['.aheto-counter--divider::after']['background-color'] = Color::setAlpha($settings['dark'], 0.1);
//
//	// Partial - Video.
//	$css['global']['.aheto-video__play:before']['border'] = '4px solid ' . $settings['active'];
//
//	// Partial - Team Member.
//	$elements                                              = [
//		'.aheto-member--home-page .aheto-member__contact',
//		'.aheto-member--border:hover',
//	];
//	$css['global'][aheto_implode($elements)]['box-shadow'] = '0 15px 30px 0 ' . Color::setAlpha($settings['active'], 0.1);
//
//	$css['global']['.aheto-member--home-event .aheto-member__img-holder:after']['background'] = Color::setAlpha($settings['dark'], 0.7);
//	$css['global']['.aheto-member--home-education .aheto-member__link-plus:hover']['border']  = '1px solid ' . $settings['dark'];
//
//	$elements                                              = [
//		'.aheto-member--saas .aheto-member__contact:before',
//		'.aheto-member--saas .aheto-member__contact:after',
//	];
//	$css['global'][aheto_implode($elements)]['background'] = Color::setAlpha($settings['dark'], 0.6);
//
//	$elements                                         = [
//		'.aheto-member--business .aheto-member__icon-plus',
//		'.aheto-member--business .aheto-member__link',
//	];
//	$css['global'][aheto_implode($elements)]['color'] = Color::lighten($settings['grey'], 14);
//
//	$css['global']['.aheto-member--yoga .aheto-member__position.c-2']['background-color'] = $settings['alter'];
//	$css['global']['.aheto-member--yoga .aheto-member__position.c-3']['background-color'] = $settings['alter2'];
//	$css['global']['.aheto-member--yoga .aheto-member__position.c-4']['background-color'] = $settings['alter3'];
//	$css['global']['.aht-team--edu:hover .aht-team__img:before']['background-color']      = Color::setAlpha($settings['black'], 0.2);
//
//	$css['global']['.aheto-member--business']['border']                                      = '1px solid ' . $settings['alter3'];
//	$css['global']['.aheto-member--business .aheto-member__link-plus']['border']             = '1px solid ' . Color::lighten($settings['grey'], 14);
//	$css['global']['.aheto-member--business .aheto-member__link-plus:hover']['border-color'] = $settings['active'];
//
//	$css['@media screen and (max-width: 767px)']['.aheto-member--home-event .aheto-member__icon-plus']['color']                = $settings['dark'];
//	$css['@media screen and (max-width: 575px)']['.aheto-member--home-education .aheto-member__link-plus']['border-color']     = $settings['dark'];
//	$css['@media screen and (max-width: 575px)']['.aheto-member--home-education .aheto-member__link-plus']['background-color'] = $settings['dark'];
//
//	$elements                                                                            = [
//		'.aheto-member--business:hover',
//		'.aheto-member--business:hover .aheto-member__img',
//	];
//	$css['@media screen and (min-width: 992px)'][aheto_implode($elements)]['box-shadow'] = '0 15px 30px 0 ' . Color::setAlpha($settings['active'], 0.1);
//
//	$css['@media screen and (min-width: 481)']['.aheto-member--border-2:hover']['box-shadow']       = '0 15px 30px 0 ' . Color::setAlpha($settings['alter'], 0.1);
//	$css['@media screen and (min-width: 481)']['.aheto-member--border-2:after']['background-color'] = $settings['active'];
//
//	// Partial - Author.
//	$css['global']['.aht-author__pos']['color'] = $settings['alter3'];
//
//	// Partial - 404page.
//	$css['global']['.aheto-404 .fil1']['fill']                                      = Color::ligthen($settings['active'], 20);
//	$css['global']['.aheto-404 .fil2']['fill']                                      = $settings['active'];
//	$css['global']['.aheto-404__wrap .aheto-btn.aheto-btn--outline:hover']['color'] = $settings['white'];
}

/**
 * Vendors CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_vendors ( &$css, $settings )
{
//	$elements                                          = [
//		'body .swiper--home-event .swiper-button-prev',
//		'body .swiper--home-event .swiper-button-next',
//	];
//	$css['global'][aheto_implode($elements)]['border'] = '1px solid ' . Color::setAlpha($settings['dark'], 0.1);
//
//	$css['global']['body .swiper--shop-item .gallery-thumbs .swiper-slide-active > div']['border'] = '1px solid ' . $settings['dark'];
//	$css['global']['body .swiper--websites .swiper-slide img']['box-shadow']                       = '0 10px 30px 0 ' . Color::setAlpha($settings['active'], 0.1);
//	$css['global']['body .swiper--testimonials .swiper-pagination-bullet-active']['background']    = Color::setAlpha($settings['grey'], 0.4);
//	$css['global']['body .swiper--business .swiper-pagination-bullet']['border']                   = '1px solid ' . $settings['alter'];
//	$css['global']['body .swiper--business .swiper-pagination-bullet-active']['background-color']  = $settings['alter'];
//	$css['global']['body .swiper--vert-pag .swiper-pagination-bullet']['border']                   = '1px solid ' . $settings['grey'];
//
//	$elements                                          = [
//		'body .swiper--constrution-service .swiper-button-prev',
//		'body .swiper--constrution-service .swiper-button-next',
//	];
//	$css['global'][aheto_implode($elements)]['border'] = '1px solid ' . Color::setAlpha($settings['grey'], 0.7);
//
//	$elements                                              = [
//		'body .swiper--twitter .swiper-button-prev:hover',
//		'body .swiper--twitter .swiper-button-next:hover',
//	];
//	$css['global'][aheto_implode($elements)]['box-shadow'] = '0 5px 10px 0 ' . Color::setAlpha($settings['dark'], 0.1);
//
//	$elements                                          = [
//		'body .swiper--chr-2 .swiper-pagination-bullet',
//		'body .swiper--chr-3 .swiper-pagination-bullet',
//	];
//	$css['global'][aheto_implode($elements)]['border'] = '1px solid ' . $settings['dark2'];
//
//	$elements                                                    = [
//		'body .swiper--chr-2 .swiper-pagination-bullet-active',
//		'body .swiper--chr-3 .swiper-pagination-bullet-active',
//	];
//	$css['global'][aheto_implode($elements)]['background-color'] = $settings['dark2'];
}

/**
 * Widgets CSS.
 * @param array $css Dynamic CSS holder.
 * @param array $settings Array of current skin settings.
 */
function aheto_widgets ( &$css, $settings )
{
//	$elements                                         = [
//		'.widget_aheto .aheto-socials__link',
//		'.widget_aheto .aheto-socials__link__icon',
//	];
//	$css['global'][aheto_implode($elements)]['color'] = Color::darken($settings['grey'], 19);

//	$elements                                                = [
//		'.widget_nav_menu_1 .menu-item a:before',
//	];
//	$css['global'][aheto_implode($elements)]['border-color'] = 'transparent ' . $settings['grey'];

//	$elements                                                = [
//		'.widget_nav_menu_1 .menu-item:hover a:hover:before',
//		'.widget_nav_menu_1 .menu-item.current-menu-item a:before',
//		'.widget_nav_menu_3 .menu-item:hover a:hover:before',
//	];
//	$css['global'][aheto_implode($elements)]['border-color'] = 'transparent ' . $settings['active'];

//	$elements                                                 = [
//		'.widget_recent_entries_3 li',
//	];
//	$css['global'][aheto_implode($elements)]['border-bottom'] = '1px solid ' . Color::setAlpha($settings['grey'], 0.3);

//	$elements                                              = [
//		'.widget_mc4wp_form_widget.aheto_mc_1 input[type=submit]:hover',
//		'.widget_custom_form button[type=submit]:hover',
//		'.widget_custom_form input[type=submit]:hover',
//	];
//	$css['global'][aheto_implode($elements)]['background'] = Color::fadeOut($settings['active'], 0.2) . ' !important';

//	$elements                                              = [
//		'.widget_mc4wp_form_widget.aheto_mc_2 button[type=submit]',
//		'.widget_mc4wp_form_widget.aheto_mc_2 input[type=submit]',
//	];
//	$css['global'][aheto_implode($elements)]['background'] = $settings['alter'];

	$elements = [
		'.widget_mc4wp_form_widget.aheto_mc_2 button[type=submit]:hover',
		'.widget_mc4wp_form_widget.aheto_mc_2 input[type=submit]:hover',
	];

	if( isset( $settings[ 'alter' ] ) && !empty( $settings[ 'alter' ] ) ) {
		$css[ 'global' ][ aheto_implode ( $elements ) ][ 'background' ] = Color ::fadeOut ( $settings[ 'alter' ], 0.2 ) . ' !important';
	}
	if( isset( $settings[ 'widget_title' ] ) && !empty( $settings[ 'widget_title' ] ) ) {
		$css[ 'global' ][ '.widget-title' ] = Sanitize ::typography ( $settings[ 'widget_title' ] );
	}
	if( isset( $settings[ 'widget_title_border' ] ) && !empty( $settings[ 'widget_title_border' ] ) ) {
		aheto_add_props ( $css[ 'global' ][ '.widget-title' ], Sanitize ::border ( $settings[ 'widget_title_border' ] ) );
	}
	if( isset( $settings[ 'widget_title_padding' ] ) && !empty( $settings[ 'widget_title_padding' ] ) ) {
		aheto_add_props ( $css[ 'global' ][ '.widget-title' ], Sanitize ::spacing ( $settings[ 'widget_title_padding' ] ) );
	}
}
