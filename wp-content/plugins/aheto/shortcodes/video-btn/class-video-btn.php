<?php
/**
 * The Video Button Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     FOX-THEMES <info@foxthemes.me>
 */

namespace Aheto\Shortcodes;

use Aheto\Shortcode;
use Aheto\Params;
use Aheto\Helper;

defined('ABSPATH') || exit;

/**
 * VideoButton class.
 */
class VideoButton extends Shortcode {

	/**
	 * Setup
	 */
	 public $slug;
	public $title;
	public $icon;
	public $description;
	public $default_layout;
	public function setup() {
		$this->slug        = 'video-btn';
		$this->title       = esc_html__('Video Button', 'aheto');
		$this->icon        = 'fas fa-play-circle';
		$this->description = esc_html__('Add video button', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = plugin_dir_url(__FILE__) . 'previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Classic', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);

		$this->register();
	}

	/**
	 * Set shortcode params
	 */



	public function set_params() {

		Params::add_video_button_params($this, [
			'add_button' => false,
			'group'      => esc_html__('General', 'aheto'),
		]);

		$this->add_params([
			'align'         => [
				'type'    => 'select',
				'heading' => esc_html__('Align', 'aheto'),
				'options' => Helper::choices_alignment(),
				'group'      => esc_html__('General', 'aheto'),
			],
			'advanced'      => true,
		]);
	}
}
