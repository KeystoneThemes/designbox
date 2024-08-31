<?php

namespace WDBAddonsPro\Settings\Tabs;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Scroll_To_Top extends Tab_Base {

	public function get_id() {
		return 'settings-wdb-scroll-to-top';
	}

	public function get_title() {
		return esc_html__( 'Scroll To Top', 'wdb-addons-pro' );
	}

	public function get_group() {
		return 'theme-style';
	}

	public function get_icon() {
		return 'wdb eicon-upload-circle-o';
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
			'wdb_enable_scroll_to_top',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Scroll to Top', 'wdb-addons-pro' ),
				'default'   => '',
				'label_on'  => esc_html__( 'Show', 'wdb-addons-pro' ),
				'label_off' => esc_html__( 'Hide', 'wdb-addons-pro' ),
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_layout',
			[
				'label'       => esc_html__( 'Layout', 'wdb-addons-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'label_block' => false,
				'options'     => [
					''       => esc_html__( 'Default', 'wdb-addons-pro' ),
					'circle' => esc_html__( 'Progress Circle', 'wdb-addons-pro' ),
				],
				'separator'   => 'before',
				'condition'   => [
					'wdb_enable_scroll_to_top!' => '',
				],
			]
		);


		$this->add_control(
			'scroll_to_icon',
			[
				'label'       => esc_html__( 'Icon', 'wdb-addons-pro' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-arrow-up',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'wdb_enable_scroll_to_top!' => '' ]
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default'    => [
					'unit' => 'px',
					'size' => 18,
				],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 300,
					],
				],
				'selectors'  => [
					'.wdb-scroll-to-top' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'wdb_enable_scroll_to_top!' => '' ]
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_width',
			[
				'label'      => esc_html__( 'Width', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 46,
				],
				'selectors'  => [
					'.wdb-scroll-to-top' => 'width: {{SIZE}}{{UNIT}};',
					'.wdb-scroll-to-top.scroll-to-circle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'wdb_enable_scroll_to_top!' => '',
				],
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_height',
			[
				'label'      => esc_html__( 'Height', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 46,
				],
				'selectors'  => [
					'.wdb-scroll-to-top' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'wdb_enable_scroll_to_top!' => '',
					'wdb_scroll_to_top_layout' => '',
				],
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors'  => [
					'.wdb-scroll-to-top' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'wdb_enable_scroll_to_top!' => '',
					'wdb_scroll_to_top_layout' => '',
				],
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_position',
			[
				'label'       => esc_html__( 'Position', 'wdb-addons-pro' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'bottom-right',
				'label_block' => false,
				'options'     => [
					'bottom-left'  => esc_html__( 'Bottom Left', 'wdb-addons-pro' ),
					'bottom-right' => esc_html__( 'Bottom Right', 'wdb-addons-pro' ),
				],
				'separator'   => 'before',
				'condition'   => [
					'wdb_enable_scroll_to_top!' => '',
				],
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_position_bottom',
			[
				'label'      => esc_html__( 'Bottom', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors'  => [
					'.wdb-scroll-to-top' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'wdb_enable_scroll_to_top!' => '',
				],
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_position_left',
			[
				'label'      => esc_html__( 'Left', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors'  => [
					'.wdb-scroll-to-top' => 'left: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'wdb_enable_scroll_to_top!'  => '',
					'wdb_scroll_to_top_position' => 'bottom-left',
				],
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_position_right',
			[
				'label'      => esc_html__( 'Right', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors'  => [
					'.wdb-scroll-to-top' => 'right: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'wdb_enable_scroll_to_top!'  => '',
					'wdb_scroll_to_top_position' => 'bottom-right',
				],
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_z_index',
			[
				'label'      => esc_html__( 'Z Index', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 9999,
						'step' => 10,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 9999,
				],
				'selectors'  => [
					'.wdb-scroll-to-top' => 'z-index: {{SIZE}}',
				],
				'condition'  => [
					'wdb_enable_scroll_to_top!' => '',
				],
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_progress_color',
			[
				'label'     => esc_html__( 'Progress Color', 'wdb-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'.wdb-scroll-to-top.scroll-to-circle svg.progress-circle path' => 'stroke: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'wdb_enable_scroll_to_top!' => '',
					'wdb_scroll_to_top_layout'  => 'circle',
				],
			]
		);

		$this->start_controls_tabs(
			'style_wdb_scroll_tabs'
		);

		$this->start_controls_tab(
			'style_wdb_scroll_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'wdb-addons-pro' ),
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'wdb-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'.wdb-scroll-to-top' => 'color: {{VALUE}}; fill: {{VALUE}}',
				],
				'separator' => 'before',
				'condition' => [
					'wdb_enable_scroll_to_top!' => '',
				],
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'wdb-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'.wdb-scroll-to-top' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'wdb_enable_scroll_to_top!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_wdb_scroll_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'wdb-addons-pro' ),
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Color', 'wdb-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wdb-scroll-to-top:hover' => 'color: {{VALUE}}; fill: {{VALUE}}',
				],
				'separator' => 'before',
				'condition' => [
					'wdb_enable_scroll_to_top!' => '',
				],
			]
		);

		$this->add_control(
			'wdb_scroll_to_top_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'wdb-addons-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.wdb-scroll-to-top:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'wdb_enable_scroll_to_top!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'wdb_scroll_to_top_blend_mode',
			[
				'label'     => esc_html__( 'Blend Mode', 'wdb-addons-pro' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'normal'      => esc_html__( 'Normal', 'wdb-addons-pro' ),
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
					'.wdb-scroll-to-top' => 'mix-blend-mode: {{VALUE}}',
				],
				'condition' => [ 'wdb_enable_scroll_to_top!' => '' ]
			]
		);

		$this->end_controls_section();
	}
}
