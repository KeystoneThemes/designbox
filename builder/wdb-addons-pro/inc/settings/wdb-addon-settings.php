<?php

namespace WDBAddonsPro\Settings\Tabs;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Settings_Addons extends Tab_Base {

	public function get_id() {
		return 'settings-wdb-cursor';
	}

	public function get_title() {
		return esc_html__( 'Cursor', 'wdb-addons-pro' );
	}

	public function get_group() {
		return 'theme-style';
	}

	public function get_icon() {
		return 'wdb eicon-scroll';
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
			'wdb_enable_cursor',
			[
				'type'               => Controls_Manager::SWITCHER,
				'label'              => esc_html__( 'Cursor', 'wdb-addons-pro' ),
				'default'            => 'yes',
				'label_on'           => esc_html__( 'Show', 'wdb-addons-pro' ),
				'label_off'          => esc_html__( 'Hide', 'wdb-addons-pro' ),
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'wdb_cursor_size',
			[
				'label'      => esc_html__( 'Cursor Size', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 300,
					],
				],
				'selectors'  => [
					'.wdb-cursor' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'wdb_enable_cursor!' => '' ]
			]
		);

		$this->add_control(
			'wdb_cursor_follower_size',
			[
				'label'      => esc_html__( 'Cursor Follower Size', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'.wdb-cursor-follower' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'wdb_enable_cursor!' => '' ]
			]
		);

		$this->add_control(
			'wdb_cursor_color',
			[
				'label'     => esc_html__( 'Cursor Color', 'wdb-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wdb-cursor' => 'border-color: {{VALUE}}',
				],
				'condition' => [ 'wdb_enable_cursor!' => '' ]
			]
		);

		$this->add_control(
			'wdb_cursor_follower_color',
			[
				'label'     => esc_html__( 'Cursor Follower Color', 'wdb-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wdb-cursor-follower' => 'background-color: {{VALUE}}',
				],
				'condition' => [ 'wdb_enable_cursor!' => '' ]
			]
		);

		$this->add_control(
			'wdb_cursor_blend_mode',
			[
				'label'     => esc_html__( 'Blend Mode', 'wdb-addons-pro' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => esc_html__( 'Normal', 'wdb-addons-pro' ),
					'multiply'    => 'Multiply',
					'screen'      => 'Screen',
					'overlay'     => 'Overlay',
					'darken'      => 'Darken',
					'lighten'     => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation'  => 'Saturation',
					'color'       => 'Color',
					'difference'  => 'Difference',
					'exclusion'   => 'Exclusion',
					'hue'         => 'Hue',
					'luminosity'  => 'Luminosity',
				],
				'selectors' => [
					'.wdb-cursor'          => 'mix-blend-mode: {{VALUE}}',
					'.wdb-cursor-follower' => 'mix-blend-mode: {{VALUE}}',
				],
				'condition' => [ 'wdb_enable_cursor!' => '' ]
			]
		);

		$dropdown_options = [];

		foreach ( Plugin::$instance->breakpoints->get_active_breakpoints() as $breakpoint_key => $breakpoint_instance ) {

			$dropdown_options[ $breakpoint_key ] = sprintf(
			/* translators: 1: Breakpoint label, 2: `>` character, 3: Breakpoint value. */
				esc_html__( '%1$s (%2$dpx)', 'wdb-addons-pro' ),
				$breakpoint_instance->get_label(),
				$breakpoint_instance->get_value()
			);
		}

		$this->add_control(
			'wdb_cursor_breakpoint',
			[
				'label'              => esc_html__( 'Breakpoint', 'wdb-addons-pro' ),
				'type'               => Controls_Manager::SELECT,
				'description'        => esc_html__( 'Note: Choose at which breakpoint cursor will work.', 'wdb-addons-pro' ),
				'options'            => $dropdown_options,
				'frontend_available' => true,
				'default'            => 'mobile',
				'condition'          => [
					'wdb_enable_cursor!' => '',
				],
			]
		);

		$this->end_controls_section();
	}
}
