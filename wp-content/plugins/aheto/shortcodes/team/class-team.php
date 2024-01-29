<?php
/**
 * The Team Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     FOX-THEMES <info@foxthemes.me>
 */

namespace Aheto\Shortcodes;

use Aheto\Shortcode;
use Aheto\Sanitize;

defined('ABSPATH') || exit;

/**
 * Team class.
 */
class Team extends Shortcode {

	/**
	 * Setup
	 */
	 public $slug;
	public $title;
	public $icon;
	public $description;
	public $default_layout;
	public function setup() {
		$this->slug        = 'team';
		$this->title       = esc_html__('Team', 'aheto');
		$this->icon        = 'fas fa-users';
		$this->description = esc_html__('Add team', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = plugin_dir_url(__FILE__) . 'previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Classic', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout('layout2', [
			'title' => esc_html__('Modern', 'aheto'),
			'image' => $dir . 'layout2.jpg',
		]);

		// Dependency.

		$this->add_dependecy( 'teams', 'template', ['view', 'layout1', 'layout2'] );

		$this->register();
	}

	/**
	 * Set dependent style
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return ['swiper'];
	}

	/**
	 * Set dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return ['swiper'];
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->add_params([
			'teams'       => [
				'type'    => 'group',
				'heading' => esc_html__('Team', 'aheto'),
				'params'  => [
					'member_image'       => [
						'type'    => 'attach_image',
						'heading' => esc_html__('Display Image', 'aheto'),
					],
					'member_name'        => [
						'type'    => 'text',
						'heading' => esc_html__('Name', 'aheto'),
					],
					'member_designation' => [
						'type'    => 'text',
						'heading' => esc_html__('Designation', 'aheto'),
					],
					'member_description' => [
						'type'    => 'textarea',
						'heading' => esc_html__('Description', 'aheto'),
					],
					'member_social' => [
						'type'    => 'checkbox',
						'heading' => esc_html__('Add socials?', 'aheto'),
					],
				],
			],
			'advanced'    => true,
		]);

		\Aheto\Params::add_networks_params($this, [
			'dependency' => ['member_social', 'true']
		], 'teams');

		\Aheto\Params::add_carousel_params($this, [
			'custom_options' => true,
			'include'        => ['pagination', 'arrows', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch', 'arrows_color', 'arrows_size'],
			'dependency' => ['template', ['view', 'layout1', 'layout2']]
		]);

		\Aheto\Params::add_image_sizer_params($this, [
			'dependency' => ['template',  ['view', 'layout1', 'layout2']]
		]);

	}


	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {
		if ( !empty($this->atts['arrows_color']) ) {
			$css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($this->atts['arrows_color']);
		}

		if ( !empty($this->atts['arrows_size']) ) {
			$css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size($this->atts['arrows_size'] );
		}

		return apply_filters( "aheto_team_dynamic_css", $css, $this );

	}


}
