<?php

namespace WDBAddonsPro\Settings\Tabs;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Group_Control_Background;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Preloader extends Tab_Base {

	public function get_id() {
		return 'settings-wdb-preloader';
	}

	public function get_title() {
		return esc_html__( 'Preloader', 'wdb-addons-pro' );
	}

	public function get_group() {
		return 'theme-style';
	}

	public function get_icon() {
		return 'wdb eicon-loading';
	}

	protected function register_tab_controls() {
		$this->start_controls_section(
			'section_' . $this->get_id(),
			[
				'label' => $this->get_title(),
				'tab'   => $this->get_id(),
			]
		);

		$this->add_control(
			'wdb_enable_preloader',
			[
				'type'               => Controls_Manager::SWITCHER,
				'label'              => esc_html__( 'Preloader', 'wdb-addons-pro' ),
				'default'            => '',
				'label_on'           => esc_html__( 'Show', 'wdb-addons-pro' ),
				'label_off'          => esc_html__( 'Hide', 'wdb-addons-pro' ),
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'wdb_preloader_layout',
			[
				'label'       => esc_html__( 'Layout', 'wdb-addons-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'whirlpool',
				'label_block' => false,
				'options'     => [
					'whirlpool'          => esc_html__( 'Whirlpool', 'wdb-addons-pro' ),
					'floating-circles'   => esc_html__( 'Floating Circle', 'wdb-addons-pro' ),
					'eight-spinning'     => esc_html__( 'Eight Spinning', 'wdb-addons-pro' ),
					'double-torus'       => esc_html__( 'Double Torus', 'wdb-addons-pro' ),
					'tube-tunnel'        => esc_html__( 'Tube Tunnel', 'wdb-addons-pro' ),
					'speeding-wheel'     => esc_html__( 'Speeding Wheel', 'wdb-addons-pro' ),
					'loading'            => esc_html__( 'Loading', 'wdb-addons-pro' ),
					'dot-loading'        => esc_html__( 'Dot Loading', 'wdb-addons-pro' ),
					'fountainTextG'      => esc_html__( 'FountainTextG', 'wdb-addons-pro' ),
					'circle-loading'     => esc_html__( 'Circle Loading', 'wdb-addons-pro' ),
					'dot-circle-rotator' => esc_html__( 'Dot Circle Rotator', 'wdb-addons-pro' ),
					'bubblingG'          => esc_html__( 'BubblingG', 'wdb-addons-pro' ),
					'coffee'          => esc_html__( 'Coffee', 'wdb-addons-pro' ),
					'orbit-loading'          => esc_html__( 'Orbit Loading', 'wdb-addons-pro' ),
					'battery'          => esc_html__( 'Battery', 'wdb-addons-pro' ),
					'equalizer'          => esc_html__( 'Equalizer', 'wdb-addons-pro' ),
					'square-swapping'          => esc_html__( 'Square Swapping', 'wdb-addons-pro' ),
					'jackhammer'          => esc_html__( 'Jackhammer', 'wdb-addons-pro' ),

				],
				'separator'   => 'before',
				'condition'   => [
					'wdb_enable_preloader!' => '',
				],
			]
		);

		$this->add_control(
			'wdb_preloader_background',
			[
				'label' => esc_html__( 'Background Color', 'wdb-addons-pro' ),
				'type'  => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'wdb_preloader_color',
			[
				'label' => esc_html__( 'Primary Color', 'wdb-addons-pro' ),
				'type'  => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'wdb_preloader_color2',
			[
				'label' => esc_html__( 'Secondary Color', 'wdb-addons-pro' ),
				'type'  => Controls_Manager::COLOR,
			]
		);

		$this->end_controls_section();
	}
}
