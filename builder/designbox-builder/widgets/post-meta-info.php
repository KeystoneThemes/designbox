<?php

namespace WDB_ADDONS\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

class Post_Meta_Info extends Widget_Base {

	public function get_name() {
		return 'wdb--blog--post--meta-info';
	}

	public function get_title() {
		return esc_html__( ' Post Meta', 'designbox-builder' );
	}

	public function get_icon() {
		return 'wdb eicon-meta-data';
	}

	public function get_categories() {
		return [ 'wdb-single-addon' ];
	}

	public function get_keywords() {
		return ['meta data', 'post meta' ];
	}

	public function get_style_depends() {
		return [ 'wdb--button', 'wdb--meta-info' ];
	}

	protected function register_controls() {
	    // Layout
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'layout_style',
			[
				'label' => esc_html__( 'Layout Style', 'designbox-builder' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'One', 'designbox-builder' ),
					'2' => esc_html__( 'Two', 'designbox-builder' ),
				],
			]
		);

		$this->add_responsive_control(
			'layout_align',
			[
				'label'     => esc_html__( 'Alignment', 'designbox-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'designbox-builder' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'designbox-builder' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'designbox-builder' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => '',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Content
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'designbox-builder' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'list_title',
			[
				'label' => esc_html__( 'Title', 'designbox-builder' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'designbox-builder' ),
				'label_block' => true,
			]
		);

		$meta_types = [
			'category'     => esc_html__( 'Category', 'designbox-builder' ),
			'date'         => esc_html__( 'Date', 'designbox-builder' ),
			'view'         => esc_html__( 'View', 'designbox-builder' ),
			'author'       => esc_html__( 'Author', 'designbox-builder' ),
			'reading_time' => esc_html__( 'Reading Time', 'designbox-builder' ),
			'comment'      => esc_html__( 'Comment', 'designbox-builder' ),
		];

		$repeater->add_control(
			'list_type',
			[
				'label' => esc_html__( 'Meta', 'designbox-builder' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => $meta_types,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_icon',
			[
				'label' => esc_html__( 'Icon', 'designbox-builder' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$repeater->add_control(
			'meta_separator',
			[
				'label' => esc_html__( 'Separator', 'designbox-builder' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '|', 'designbox-builder' ),
				'placeholder' => esc_html__( 'Enter your separator', 'designbox-builder' ),
			]
		);

		$repeater->add_control(
			'multiple_category',
			[
				'label' => esc_html__( 'Multiple Category', 'designbox-builder' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designbox-builder' ),
				'label_off' => esc_html__( 'No', 'designbox-builder' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'condition' => [
                        'list_type' => ['category']
                ]
			]
		);

		$repeater->add_responsive_control(
			'category_limit',
			[
				'label' => esc_html__( 'Category Limit', 'designbox-builder' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'condition' => [
					'list_type' => ['category'],
                    'multiple_category' => 'yes',
				]
			]
		);

		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'Social List', 'designbox-builder' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list li, {{WRAPPER}} .wdb--meta-list li a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wdb--meta-date, {{WRAPPER}} .wdb--meta-view' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wdb--meta-list li svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typo',
				'selector' => '{{WRAPPER}} .wdb--meta-list li, {{WRAPPER}} .wdb--meta-list li a, {{WRAPPER}} .wdb--meta-date, {{WRAPPER}} .wdb--meta-view',
			]
		);

		// Label Style
		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Label Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list li .label' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wdb--meta-list li .label svg' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typo',
				'selector' => '{{WRAPPER}} .wdb--meta-list li .label',
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		// Gap
		$this->add_responsive_control(
			'meta_col_gap',
			[
				'label' => esc_html__( 'Column Gap', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
                'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'meta_row_gap',
			[
				'label' => esc_html__( 'Row Gap', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'meta_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Separator Style
		$this->start_controls_section(
			'separator_style',
			[
				'label' => __( 'Separator', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list.style-2 > li::after' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'separator_width',
			[
				'label' => esc_html__( 'width', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list.style-2 > li::after' => 'width: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
                        'layout_style' => '2',
                ],
			]
		);

		$this->add_responsive_control(
			'separator_height',
			[
				'label' => esc_html__( 'Height', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list.style-2 > li::after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'separator_position_2',
			[
				'label' => esc_html__( 'Position', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list.style-2 > li::after' => 'inset-inline-end: -{{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'separator_position',
			[
				'label' => esc_html__( 'Position', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb-separator::after' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '1',
				],
			]
		);

		$this->end_controls_section();

		// Category Styles
        $this->category_styles();

        // Author Styles
        $this->author_styles();

        // Date Styles
        $this->date_styles();

        // View Styles
        $this->view_count_styles();

		// Comment Styles
		$this->comment_styles();
	}

    // Category Styles Control
	protected function category_styles() {
		$this->start_controls_section(
			'category_styles_section',
			[
				'label' => esc_html__( 'Category', 'designbox-builder' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'category_align',
			[
				'label' => esc_html__( 'Alignment', 'designbox-builder' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'designbox-builder' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'designbox-builder' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Right', 'designbox-builder' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-category' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'category_col_gap',
			[
				'label' => esc_html__( 'Column Gap', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--category-list' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'category_row_gap',
			[
				'label' => esc_html__( 'Row Gap', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--category-list' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'category_separator_position',
			[
				'label' => esc_html__( 'Separator Position', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb-separator::after' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'category_hover_list',
			[
				'label'   => esc_html__( 'Hover Style', 'designbox-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hover-none',
				'options' => [
					'hover-none'      => esc_html__( 'None', 'designbox-builder' ),
					'hover-divide'    => esc_html__( 'Divided', 'designbox-builder' ),
					'hover-cross'     => esc_html__( 'Cross', 'designbox-builder' ),
					'hover-cropping'  => esc_html__( 'Cropping', 'designbox-builder' ),
					'rollover-top'    => esc_html__( 'Rollover Top', 'designbox-builder' ),
					'rollover-left'   => esc_html__( 'Rollover Left', 'designbox-builder' ),
					'parallal-border' => esc_html__( 'Parallel Border', 'designbox-builder' ),
					'rollover-cross'  => esc_html__( 'Rollover Cross', 'designbox-builder' ),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typo',
				'selector' => '{{WRAPPER}} .wdb--meta-list .wdb--meta-category a',
			]
		);

		$this->add_control(
			'category_padding',
			[
				'label' => esc_html__( 'Padding', 'designbox-builder' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '1',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'category_border',
				'selector' => '{{WRAPPER}} a, {{WRAPPER}} a.btn-parallal-border:before, {{WRAPPER}} a.btn-parallal-border:after, {{WRAPPER}} a.btn-rollover-cross:before, {{WRAPPER}} a.btn-rollover-cross:after',
				'condition' => [
					'layout_style' => '1',
				],
			]
		);

		$this->add_control(
			'category_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designbox-builder' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '1',
				],
			]
		);

		$this->add_control(
			'category_transition',
			[
				'label' => esc_html__( 'Transition', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => .1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-category a' => 'transition: all {{SIZE}}s;',
				],
			]
		);

		$this->start_controls_tabs(
			'category_tabs'
		);

		$this->start_controls_tab(
			'category_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list .wdb--meta-category a, {{WRAPPER}} .wdb--meta-list .wdb--meta-category' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'category_bg',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} a:not(.wdb-btn-ellipse), {{WRAPPER}} a.wdb-btn-mask:after, {{WRAPPER}} a.wdb-btn-ellipse:before',
				'condition' => [
					'layout_style' => '1',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'category_shadow',
				'selector' => '{{WRAPPER}} .wdb--meta-category a',
				'condition' => [
					'layout_style' => '1',
				],
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'category_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'category_hover_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list .wdb--meta-category a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'category_hover_bg',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} a:not(.btn-item, .btn-parallal-border, .btn-rollover-cross, .wdb-btn-ellipse):after, {{WRAPPER}} .btn-hover-bgchange span, {{WRAPPER}} .btn-rollover-cross:hover, {{WRAPPER}} .btn-parallal-border:hover, {{WRAPPER}} a.wdb-btn-ellipse:hover:before,{{WRAPPER}} a.btn-hover-none:hover',
				'condition' => [
					'layout_style' => '1',
				],
			]
		);

		$this->add_control(
			'category_hover_border',
			[
				'label' => esc_html__( 'Border Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list .wdb--meta-category a:hover, {{WRAPPER}} a:hover, {{WRAPPER}} a:focus, {{WRAPPER}} a:hover.btn-parallal-border:before, {{WRAPPER}} a:hover.btn-parallal-border:after, {{WRAPPER}} a:hover.btn-rollover-cross:before, {{WRAPPER}} a:hover.btn-rollover-cross:after, {{WRAPPER}} a.btn-hover-none:hover' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'layout_style' => '1',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'category_hover_shadow',
				'selector' => '{{WRAPPER}} .wdb--meta-category a:hover',
				'condition' => [
					'layout_style' => '1',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Label
		$this->add_control(
			'category_label_heading',
			[
				'label' => esc_html__( 'Label', 'designbox-builder' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_control(
			'category_label_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--category-title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_label_typo',
				'selector' => '{{WRAPPER}} .wdb--category-title',
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'category_label_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--category-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_control(
			'category_icon_heading',
			[
				'label' => esc_html__( 'Icon', 'designbox-builder' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'category_icon',
			[
				'label' => esc_html__( 'Size', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--category-wrap i, {{WRAPPER}} li.wdb--category-wrap svg' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wdb--category-title i, {{WRAPPER}} .wdb--category-title svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'category_icon_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--category-wrap i, {{WRAPPER}} .wdb--category-title i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wdb--category-wrap svg, {{WRAPPER}} .wdb--category-title svg' => 'fill: {{VALUE}}',

				],
			]
		);

		$this->add_responsive_control(
			'category_icon_space',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 150,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--category-wrap i, {{WRAPPER}} .wdb--category-wrap svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wdb--category-title i, {{WRAPPER}} .wdb--category-title svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
    }

	// Author Styles Control
	protected function author_styles() {
		$this->start_controls_section(
			'author_styles_section',
			[
				'label' => esc_html__( 'Author', 'designbox-builder' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'author_typo',
				'selector' => '{{WRAPPER}} .wdb--meta-list .wdb--meta-author a',
			]
		);

		$this->add_control(
			'author_transition',
			[
				'label' => esc_html__( 'Transition', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => .1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-author a' => 'transition: all {{SIZE}}s;',
				],
			]
		);

		$this->start_controls_tabs(
			'author_tabs'
		);

		$this->start_controls_tab(
			'author_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'author_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list .wdb--meta-author a, {{WRAPPER}} .wdb--meta-list .wdb--meta-author' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'author_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'author_hover_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list .wdb--meta-author a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

        // Label
		$this->add_control(
			'author_label_heading',
			[
				'label' => esc_html__( 'Label', 'designbox-builder' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_control(
			'author_label_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--author-title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'author_label_typo',
				'selector' => '{{WRAPPER}} .wdb--author-title',
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'author_label_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--author-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_control(
			'author_icon_heading',
			[
				'label' => esc_html__( 'Icon', 'designbox-builder' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'author_icon',
			[
				'label' => esc_html__( 'Size', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-author i, {{WRAPPER}} .wdb--meta-author svg' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wdb-author-img img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'author_icon_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-author i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wdb--meta-author svg' => 'fill: {{VALUE}}',

				],
				'condition' => [
					'layout_style' => '1',
				],
			]
		);

		$this->add_responsive_control(
			'author_icon_space',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 150,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-author i, {{WRAPPER}} .wdb--meta-author svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wdb-author-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'author_img_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designbox-builder' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb-author-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->end_controls_section();
	}

	// Date Styles Control
	protected function date_styles() {
		$this->start_controls_section(
			'date_styles_section',
			[
				'label' => esc_html__( 'Date', 'designbox-builder' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'date_align',
			[
				'label' => esc_html__( 'Alignment', 'designbox-builder' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'designbox-builder' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'designbox-builder' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Right', 'designbox-builder' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .wdb--date-wrap' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_control(
			'date_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list .wdb--meta-date' => 'color: {{VALUE}}',
				],
                'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'date_typo',
				'selector' => '{{WRAPPER}} .wdb--meta-list .wdb--meta-date',
			]
		);

		$this->add_control(
			'date_label_heading',
			[
				'label' => esc_html__( 'Label', 'designbox-builder' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_control(
			'date_label_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--date-title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'date_label_typo',
				'selector' => '{{WRAPPER}} .wdb--date-title',
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'date_label_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--date-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_control(
			'date_icon_heading',
			[
				'label' => esc_html__( 'Icon', 'designbox-builder' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'date_icon',
			[
				'label' => esc_html__( 'Size', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-date i, {{WRAPPER}} .wdb--meta-date svg' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wdb--date-title i, {{WRAPPER}} .wdb--date-title svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'date_icon_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-date i, {{WRAPPER}} .wdb--date-title i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wdb--meta-date svg, {{WRAPPER}} .wdb--date-title svg' => 'fill: {{VALUE}}',

				],
			]
		);

		$this->add_responsive_control(
			'date_icon_space',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 150,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-date i, {{WRAPPER}} .wdb--meta-date svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wdb--date-title i, {{WRAPPER}} .wdb--date-title svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	// View Count Styles Control
	protected function view_count_styles() {
		$this->start_controls_section(
			'view_styles_section',
			[
				'label' => esc_html__( 'View Count', 'designbox-builder' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'view_align',
			[
				'label' => esc_html__( 'Alignment', 'designbox-builder' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'designbox-builder' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'designbox-builder' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Right', 'designbox-builder' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .wdb--view-wrap' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'view_direction',
			[
				'label' => esc_html__( 'Direction', 'designbox-builder' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__( 'Row', 'designbox-builder' ),
						'icon' => ' eicon-arrow-right',
					],
					'column' => [
						'title' => esc_html__( 'Column', 'designbox-builder' ),
						'icon' => 'eicon-arrow-down',
					],
					'row-reverse' => [
						'title' => esc_html__( 'Row Reverse', 'designbox-builder' ),
						'icon' => ' eicon-arrow-left',
					],
					'column-reverse' => [
						'title' => esc_html__( 'Column Reverse', 'designbox-builder' ),
						'icon' => 'eicon-arrow-up',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-view' => 'flex-direction: {{VALUE}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'view_gap',
			[
				'label' => esc_html__( 'Gap', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-view' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		// Typo
		$this->add_control(
			'view_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list .wdb--meta-view' => 'color: {{VALUE}}',
				],
                'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'view_typo',
				'selector' => '{{WRAPPER}} .wdb--meta-list .wdb--meta-view',
			]
		);

		$this->add_control(
			'view_label_heading',
			[
				'label' => esc_html__( 'Label', 'designbox-builder' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
                'condition' => [
                        'layout_style' => '2',
                ],
			]
		);

		$this->add_control(
			'view_label_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--view-title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'view_label_typo',
				'selector' => '{{WRAPPER}} .wdb--view-title',
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'view_label_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--view-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_control(
			'view_icon_heading',
			[
				'label' => esc_html__( 'Icon', 'designbox-builder' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'view_icon',
			[
				'label' => esc_html__( 'Size', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-view i, {{WRAPPER}} .wdb--meta-view svg' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wdb--view-title i, {{WRAPPER}} .wdb--view-title svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view_icon_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-view i, {{WRAPPER}} .wdb--view-title i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wdb--meta-view svg, {{WRAPPER}} .wdb--view-title svg' => 'fill: {{VALUE}}',

				],
			]
		);

		$this->add_responsive_control(
			'view_icon_space',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 150,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-view i, {{WRAPPER}} .wdb--meta-view svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wdb--view-title i, {{WRAPPER}} .wdb--view-title svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	// Comment Styles Control
	protected function comment_styles() {
		$this->start_controls_section(
			'comment_styles_section',
			[
				'label' => esc_html__( 'Comment', 'designbox-builder' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'comment_align',
			[
				'label' => esc_html__( 'Alignment', 'designbox-builder' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'designbox-builder' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'designbox-builder' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Right', 'designbox-builder' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .wdb--comment-wrap' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		// Typo
		$this->add_control(
			'comment_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-list .wdb--meta-comment' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'comment_typo',
				'selector' => '{{WRAPPER}} .wdb--meta-list .wdb--meta-comment',
			]
		);

		$this->add_control(
			'comment_label_heading',
			[
				'label' => esc_html__( 'Label', 'designbox-builder' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_control(
			'comment_label_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--comment-title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'comment_label_typo',
				'selector' => '{{WRAPPER}} .wdb--comment-title',
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'comment_label_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--comment-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => '2',
				],
			]
		);

		$this->add_control(
			'comment_icon_heading',
			[
				'label' => esc_html__( 'Icon', 'designbox-builder' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'comment_icon',
			[
				'label' => esc_html__( 'Size', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-comment i, {{WRAPPER}} .wdb--meta-comment svg' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wdb--comment-title i, {{WRAPPER}} .wdb--comment-title svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'comment_icon_color',
			[
				'label' => esc_html__( 'Color', 'designbox-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-comment i, {{WRAPPER}} .wdb--comment-title i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wdb--meta-comment svg, {{WRAPPER}} .wdb--comment-title svg' => 'fill: {{VALUE}}',

				],
			]
		);

		$this->add_responsive_control(
			'comment_icon_space',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 150,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--meta-comment i, {{WRAPPER}} .wdb--meta-comment svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wdb--comment-title i, {{WRAPPER}} .wdb--comment-title svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function switch_post() {
		if ( 'wdb-addons-template' === get_post_type() ) {

			$recent_posts = wp_get_recent_posts( array(
				'numberposts' => 1,
				'post_status' => 'publish'
			) );

			$post_id = get_the_id();

			if ( isset( $recent_posts[0] ) ) {
				$post_id = $recent_posts[0]['ID'];
			}

			Plugin::$instance->db->switch_to_post( $post_id );
		}
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$meta_list = $settings['list'];
		if ( empty( $meta_list ) ) {
			return;
		}

		$this->switch_post();

		?>
        <ul class="wdb--meta-list style-<?php echo esc_html( $settings['layout_style'] ); ?>">
	        <?php foreach ( $meta_list as $meta ) {
		        $this->render_date( $meta, $settings );
		        $this->render_categories( $meta, $settings );
		        $this->render_author( $meta, $settings );
		        $this->render_view_count( $meta, $settings );
		        $this->render_reading_time( $meta, $settings );
		        $this->render_comments( $meta, $settings );
	        }
	        ?>
        </ul>
		<?php

		Plugin::$instance->db->restore_current_post();
	}

	protected function render_date( $meta, $settings ) {
		if($meta['list_type'] == 'date'){ ?>
			<?php if ( '1' == $settings['layout_style'] ): ?>
                <li class="wdb--meta-date wdb-separator" data-separator="<?php echo esc_attr( $meta['meta_separator'] ); ?>">
					<?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					<?php echo get_the_date( get_option( 'date_format' ) ); ?>
                </li>
			<?php endif; ?>

			<?php if( '2' == $settings['layout_style'] ): ?>
                <li class="wdb--date-wrap">
                    <div class="wdb--date-title label">
						<?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php echo esc_html($meta['list_title']); ?>
                    </div>
                    <div class="wdb--meta-date">
					    <?php echo get_the_date(get_option( 'date_format' )); ?>
                    </div>
                </li>
			<?php endif; ?>
		<?php }
	}

	protected function render_categories( $meta, $settings ) {
		if ( $meta['list_type'] == 'category' ) {
			$cat = get_the_category();
			shuffle( $cat );
			?>

			<?php if ( '1' == $settings['layout_style'] ): ?>
				<?php if ( 'yes' === $meta['multiple_category'] ): ?>
                    <li class="wdb--category-wrap">
						<?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <ul class="wdb--category-list">
							<?php foreach ( $cat as $key => $term ) { ?>
                                <li class="wdb--meta-category wdb-separator"
                                    data-separator="<?php echo esc_attr( $meta['meta_separator'] ); ?>">
                                    <a class="wdb-btn-default btn-<?php echo esc_attr( $settings['category_hover_list'] ); ?>"
                                       href="<?php echo esc_url( get_category_link( $term->term_id ) ); ?>">
		                                <?php echo esc_html( get_cat_name( $term->term_id ) ); ?>
                                    </a>
                                </li>
							    <?php
								if( isset($meta['category_limit']) && is_numeric($meta['category_limit'])){
									if($meta['category_limit'] == $key+1 ){
										break;
									}
								}
							}
                            ?>
                        </ul>
                    </li>
				<?php else: ?>
					<?php if ( isset( $cat[0] ) ) { ?>
                        <li class="wdb--meta-category wdb-separator"
                            data-separator="<?php echo esc_attr( $meta['meta_separator'] ); ?>">
                            <?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <a class="wdb-btn-default btn-<?php echo esc_attr( $settings['category_hover_list'] ); ?>" href="<?php echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>">
	                            <?php echo esc_html( get_cat_name( $cat[0]->term_id ) ); ?>
                            </a>
                        </li>
					<?php } ?>
				<?php
				endif;
				?>
			<?php endif; ?>

			<?php if ( '2' == $settings['layout_style'] ): ?>
				<?php if ( 'yes' === $meta['multiple_category'] ): ?>
                    <li class="wdb--category-wrap">
                        <div class="wdb--category-title label">
		                    <?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
		                    <?php echo esc_html($meta['list_title']); ?>
                        </div>
                        <ul class="wdb--category-list">
							<?php foreach ( $cat as $key => $term ) { ?>
                                <li class="wdb--meta-category wdb-separator"
                                    data-separator="<?php echo esc_attr( $meta['meta_separator'] ); ?>">
                                    <a class="wdb-btn-default btn-<?php echo esc_attr( $settings['category_hover_list'] ); ?>" href="<?php echo esc_url( get_category_link( $term->term_id ) ); ?>">
										<?php echo esc_html( get_cat_name( $term->term_id ) ); ?>
                                    </a>
                                </li>
							    <?php
								if( isset($meta['category_limit']) && is_numeric($meta['category_limit'])){
									if($meta['category_limit'] == $key+1 ){
										break;
									}
								}
							} ?>
                        </ul>
                    </li>
				<?php else: ?>
					<?php if ( isset( $cat[0] ) ) { ?>
                        <li class="wdb--meta-category">
                            <div class="wdb--category-title label">
	                            <?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
		                        <?php echo esc_html($meta['list_title']); ?>
                            </div>
                            <a class="wdb-btn-default btn-<?php echo esc_attr( $settings['category_hover_list'] ); ?>" href="<?php echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>">
								<?php echo esc_html( get_cat_name( $cat[0]->term_id ) ); ?>
                            </a>
                        </li>
					<?php } ?>
				<?php
				endif;
				?>
			<?php endif; ?>
		<?php }
	}

	protected function render_author( $meta, $settings ) {
		global $post;
		$author_id = $post->post_author;

		if ( $meta['list_type'] == 'author' ) {
			$get_author = get_the_author_meta( 'display_name', $author_id );
			$avatar     = get_avatar( $author_id, 55 );
			$_posts_url = esc_url( get_author_posts_url( $author_id ) );
			?>
			<?php if ( '1' == $settings['layout_style'] ): ?>
                <li class="wdb--meta-author wdb-separator" data-separator="<?php echo esc_attr( $meta['meta_separator'] ); ?>">
                    <?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <a href="<?php echo esc_url( $_posts_url ); ?>"><?php echo esc_html( $get_author ); ?></a>
                </li>
			<?php endif; ?>

			<?php if ( '2' == $settings['layout_style'] ): ?>
                <li class="wdb--author-wrap">
                    <div class="wdb-author-img">
                        <?php echo wp_kses_post( $avatar ); ?>
                    </div>
                    <div class="wdb--author-info">
                        <div class="wdb--author-title label">
		                    <?php echo esc_html($meta['list_title']); ?>
                        </div>
                        <div class="wdb--meta-author">
                            <a href="<?php echo esc_url( $_posts_url ); ?>"><?php echo esc_html( $get_author ); ?></a>
                        </div>
                    </div>
                </li>
			<?php endif; ?>
		<?php }
	}

	protected function render_view_count( $meta, $settings ) {
		if($meta['list_type'] == 'view'){ ?>
			<?php if ( '1' == $settings['layout_style'] ): ?>
                <li class="wdb--meta-view wdb-separator" data-separator="<?php echo esc_attr( $meta['meta_separator'] ); ?>">
	                <?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
	                <?php echo esc_html( get_post_meta( get_the_id(), 'wdb_post_views_count', true ) ); ?>&nbsp;
	                <?php echo esc_html__( 'Views', 'designbox-builder' ); ?>
                </li>
			<?php endif; ?>

			<?php if ( '2' == $settings['layout_style'] ): ?>
                <li class="wdb--view-wrap">
                    <div class="wdb--view-title label">
		                <?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
		                <?php echo esc_html($meta['list_title']); ?>
                    </div>
                    <div class="wdb--meta-view">
	                    <?php echo esc_html( get_post_meta( get_the_id(), 'wdb_post_views_count', true ) ); ?>&nbsp;
                        <span><?php echo esc_html__( 'Views', 'designbox-builder' ); ?></span>
                    </div>
                </li>
			<?php endif; ?>
		<?php }
	}

	protected function render_reading_time( $meta, $settings ) {
		$time          = 0;
		$content       = get_the_content();
		$clean_content = esc_html( $content );
		$word_count    = str_word_count( $clean_content );
		$time          = ceil( $word_count / 200 );

		if($meta['list_type'] == 'reading_time'){ ?>
			<?php if ( '1' == $settings['layout_style'] ): ?>
                <li class="wdb--meta-view wdb-separator" data-separator="<?php echo esc_attr( $meta['meta_separator'] ); ?>">
                    <?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <?php echo esc_html( $time ); ?>
                    <?php echo $time <= 1 ? esc_html__( 'minute read', 'designbox-builder' ) : esc_html__( 'minutes read', 'designbox-builder' ); ?>
                </li>
			<?php endif; ?>

			<?php if ( '2' == $settings['layout_style'] ): ?>
                <li class="wdb--view-wrap">
                    <div class="wdb--view-title label">
		                <?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
		                <?php echo esc_html($meta['list_title']); ?>
                    </div>
                    <div class="wdb--meta-view">
	                    <?php echo esc_html( $time ); ?>&nbsp;
                        <span><?php echo $time<=1 ? esc_html__('minute read','designbox-builder') : esc_html__('minutes read','designbox-builder'); ?></span>
                    </div>
                </li>
			<?php endif; ?>
		<?php }
	}

	protected function render_comments( $meta, $settings ) {
		if($meta['list_type'] == 'comment'){ ?>
			<?php if ( '1' == $settings['layout_style'] ): ?>
                <li class="wdb--meta-comment wdb-separator" data-separator="<?php echo esc_attr( $meta['meta_separator'] ); ?>">
					<?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <?php comments_number(); ?>
                </li>
			<?php endif; ?>

			<?php if ( '2' == $settings['layout_style'] ): ?>
                <li class="wdb--comment-wrap">
                    <div class="wdb--comment-title label">
						<?php Icons_Manager::render_icon( $meta['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						<?php echo esc_html($meta['list_title']); ?>
                    </div>
                    <div class="wdb--meta-comment">
	                    <?php comments_number(); ?>
                    </div>
                </li>
			<?php endif; ?>
		<?php }
	}

}
