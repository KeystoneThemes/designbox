<?php

namespace WDB_ADDONS\Widgets;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use WDB_ADDONS\WDB_Button_Trait;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Image_Box extends Widget_Base {
	use  WDB_Button_Trait;

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_name() {
		return 'wdb--image-box';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_title() {
		return esc_html__( ' Image Box', 'designbox-builder' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_icon() {
		return 'wdb eicon-image-box';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_categories() {
		return [ 'weal-coder-addon' ];
	}

	/**
	 * Requires css files.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return [ 'wdb--image-box', 'wdb--button', ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {

		// Layout Controls
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'image_box_style',
			[
				'label'   => esc_html__( 'Style', 'designbox-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style One', 'designbox-builder' ),
					'2' => esc_html__( 'Style Two', 'designbox-builder' ),
					'3' => esc_html__( 'Style Three', 'designbox-builder' ),
					'4' => esc_html__( 'Style Four', 'designbox-builder' ),
					'5' => esc_html__( 'Style Five', 'designbox-builder' ),
				],
			]
		);

		$this->add_responsive_control(
			'img_content_direction',
			[
				'label'     => esc_html__( 'Direction', 'designbox-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'column'         => [
						'title' => esc_html__( 'Row', 'designbox-builder' ),
						'icon'  => 'eicon-section',
					],
					'column-reverse' => [
						'title' => esc_html__( 'Row Reverse', 'designbox-builder' ),
						'icon'  => 'eicon-exchange',
					],
					'row'            => [
						'title' => esc_html__( 'Column', 'designbox-builder' ),
						'icon'  => 'eicon-column',
					],
					'row-reverse'    => [
						'title' => esc_html__( 'Column Reverse', 'designbox-builder' ),
						'icon'  => 'eicon-wrap',
					],
				],
				'toggle'    => true,
				'default'   => 'column',
				'selectors' => [
					'{{WRAPPER}} .wdb--image-box' => 'flex-direction: {{VALUE}};',
				],
				'condition' => [
					'image_box_style' => [ '1', '2' ],
				],
			]
		);

		$this->add_control(
			'content_align',
			[
				'label'     => esc_html__( 'Vertically Alignment', 'designbox-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'designbox-builder' ),
						'icon'  => 'eicon-arrow-up',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'designbox-builder' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'designbox-builder' ),
						'icon'  => 'eicon-arrow-down',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .wdb--image-box' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'img_content_direction' => [ 'row', 'row-reverse' ],
				],
			]
		);

		$this->add_responsive_control(
			'img_content_gap',
			[
				'label'      => esc_html__( 'Gap', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wdb--image-box' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'image_box_style' => [ '1', '2' ],
				],
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'     => esc_html__( 'Link Type', 'designbox-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'button',
				'separator' => 'before',
				'options'   => [
					'none'    => esc_html__( 'None', 'designbox-builder' ),
					'button'  => esc_html__( 'Button', 'designbox-builder' ),
					'wrapper' => esc_html__( 'Wrapper', 'designbox-builder' ),
				],
			]
		);

		$this->add_control(
			'details_link',
			[
				'label'       => esc_html__( 'Link', 'designbox-builder' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'designbox-builder' ),
				'condition'   => [
					'link_type' => 'wrapper',
				],
			]
		);

		$this->add_control(
			'image_box_align',
			[
				'label'        => esc_html__( 'Alignment', 'designbox-builder' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'designbox-builder' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'designbox-builder' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'designbox-builder' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'      => 'left',
				'toggle'       => true,
				'prefix_class' => 'img-box-wrap-',
				'selectors'    => [
					'{{WRAPPER}} .wdb--image-box' => 'text-align: {{VALUE}};',
				],
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'content_position',
			[
				'label'     => esc_html__( 'Vertically Alignment', 'designbox-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'designbox-builder' ),
						'icon'  => 'eicon-arrow-up',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'designbox-builder' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'designbox-builder' ),
						'icon'  => 'eicon-arrow-down',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .content' => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'image_box_style' => '4',
				],
			]
		);

		$this->add_control(
			'image_box_icon',
			[
				'label'            => esc_html__( 'Icon', 'designbox-builder' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
				'recommended'      => [
					'fa-solid' => [
						'arrow-up',
						'arrow-down',
						'arrow-left',
						'arrow-right',
					],
				],
			]
		);

		$this->end_controls_section();

		// Style
		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Image Box', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label'      => esc_html__( 'Padding', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'box_border',
				'selector' => '{{WRAPPER}} .wdb--image-box',
			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .wdb--image-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		//hover effect
		$this->add_control(
			'el_hover_effects',
			[
				'label'        => esc_html__( 'Hover Effect', 'designbox-builder' ),
				'description'  => esc_html__( 'This effect will work only image tag.', 'designbox-builder' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'effect-zoom-in',
				'options'      => [
					''            => esc_html__( 'None', 'designbox-builder' ),
					'effect-zoom-in' => esc_html__( 'Zoom In', 'designbox-builder' ),
					'effect-zoom-out'  => esc_html__( 'Zoom Out', 'designbox-builder' ),
					'left-move'   => esc_html__( 'Left Move', 'designbox-builder' ),
					'right-move'  => esc_html__( 'Right Move', 'designbox-builder' ),
				],
				'prefix_class' => 'wdb--image-',
			]
		);

		$this->end_controls_section();

		// Image Controls
		$this->register_image_controls();

		// Content Controls
		$this->register_content_controls();

		//button
		$this->start_controls_section(
			'section_button_content',
			[
				'label'     => esc_html__( 'Button', 'designbox-builder' ),
				'condition' => [
					'link_type' => 'button',
				],
			]
		);

		//button content
		$this->register_button_content_controls();

		$this->end_controls_section();

		//button style
		$this->start_controls_section(
			'section_btn_style',
			[
				'label'     => esc_html__( 'Button', 'designbox-builder' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'link_type' => 'button',
				],
			]
		);

		$this->register_button_style_controls();

		$this->end_controls_section();

	}

	protected function register_image_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'designbox-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image_size',
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'full',
			]
		);

		$this->end_controls_section();

		// Style
		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Image', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'img_width',
			[
				'label'      => esc_html__( 'Width', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .thumb img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'img_height',
			[
				'label'      => esc_html__( 'Height', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min'  => 1,
						'max'  => 700,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .thumb img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'object_fit',
			[
				'label'     => esc_html__( 'Object Fit', 'designbox-builder' ),
				'type'      => Controls_Manager::SELECT,
				'condition' => [
					'img_height[size]!' => '',
				],
				'options'   => [
					''        => esc_html__( 'Default', 'designbox-builder' ),
					'fill'    => esc_html__( 'Fill', 'designbox-builder' ),
					'cover'   => esc_html__( 'Cover', 'designbox-builder' ),
					'contain' => esc_html__( 'Contain', 'designbox-builder' ),
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thumb img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'object_position',
			[
				'label'     => esc_html__( 'Object Position', 'designbox-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'center center' => esc_html__( 'Center Center', 'designbox-builder' ),
					'center left'   => esc_html__( 'Center Left', 'designbox-builder' ),
					'center right'  => esc_html__( 'Center Right', 'designbox-builder' ),
					'top center'    => esc_html__( 'Top Center', 'designbox-builder' ),
					'top left'      => esc_html__( 'Top Left', 'designbox-builder' ),
					'top right'     => esc_html__( 'Top Right', 'designbox-builder' ),
					'bottom center' => esc_html__( 'Bottom Center', 'designbox-builder' ),
					'bottom left'   => esc_html__( 'Bottom Left', 'designbox-builder' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'designbox-builder' ),
				],
				'default'   => 'center center',
				'selectors' => [
					'{{WRAPPER}} .thumb img' => 'object-position: {{VALUE}};',
				],
				'condition' => [
					'object_fit' => 'cover',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'designbox-builder' ),
			]
		);

		// Title
		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'designbox-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Siyantika Glory', 'designbox-builder' ),
				'placeholder' => esc_html__( 'Type your title', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'designbox-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h4',
			]
		);

		// Sub Title
		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Sub Title', 'designbox-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Modelling - 2012', 'designbox-builder' ),
				'placeholder' => esc_html__( 'Type your sub title', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'subtitle_position',
			[
				'label'     => esc_html__( 'Sub Title Position', 'designbox-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'column'         => [
						'title' => esc_html__( 'Before Title', 'designbox-builder' ),
						'icon'  => 'eicon-arrow-up',
					],
					'column-reverse' => [
						'title' => esc_html__( 'After Title', 'designbox-builder' ),
						'icon'  => 'eicon-arrow-down',
					],
				],
				'default'   => 'column',
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .title-wrap' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		// Description
		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'designbox-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 10,
				'default'     => esc_html__( 'Hatha yoga built on a harmonious balance between body strength and softness', 'designbox-builder' ),
				'placeholder' => esc_html__( 'Type your description', 'designbox-builder' ),
			]
		);

		$this->end_controls_section();


		// Style
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Title
		$this->add_control(
			'title_heading',
			[
				'label'     => esc_html__( 'Title', 'designbox-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_space',
			[
				'label'     => esc_html__( 'Spacing', 'designbox-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_hover_space',
			[
				'label'     => esc_html__( 'Hover Spacing', 'designbox-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--image-box.style-3:hover .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image_box_style' => '3',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .title',
			]
		);

		// Sub Title
		$this->add_control(
			'subtitle_heading',
			[
				'label'     => esc_html__( 'Sub Title', 'designbox-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'subtitle_space',
			[
				'label'     => esc_html__( 'Spacing', 'designbox-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .subtitle',
			]
		);

		// Description
		$this->add_control(
			'desc_heading',
			[
				'label'     => esc_html__( 'Description', 'designbox-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'desc_space',
			[
				'label'     => esc_html__( 'Spacing', 'designbox-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .description',
			]
		);

		// Icon
		$this->add_control(
			'icon_heading',
			[
				'label'     => esc_html__( 'Icon', 'designbox-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label'     => esc_html__( 'Spacing', 'designbox-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .icon' => 'color: {{VALUE}}; fill: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Size', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_rotate',
			[
				'label'      => esc_html__( 'Rotate', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'range'      => [
					'deg' => [
						'min' => -360,
						'max' => 360,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .icon i, {{WRAPPER}} .icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		//Wrapper
		$this->add_render_attribute( 'wrapper', 'class', 'wdb--image-box style-' . $settings['image_box_style'] );

		// Wrapper Tag
		$link_tag = 'div';
		if ( ! empty( $settings['details_link']['url'] ) && 'wrapper' === $settings['link_type'] ) {
			$link_tag = 'a';
			$this->add_link_attributes( 'wrapper', $settings['details_link'] );
		}

		// Font Awesome
		$migrated = isset( $settings['__fa4_migrated']['image_box_icon'] );
		$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
		?>

		<<?php Utils::print_validated_html_tag($link_tag); ?> <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div class="thumb">
				<?php
                Group_Control_Image_Size::print_attachment_image_html($settings, 'image_size', 'image');

				if ( '2' === $settings['image_box_style'] && 'button' === $settings['link_type'] ) {
					$this->render_button( $settings );
				}
				?>
			</div>
			<div class="content">
				<div class="wrap">
					<?php
						if ( '' != $settings['image_box_icon']['value'] ) : ?>
							<div class="icon">
								<?php if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $settings['image_box_icon'], [ 'aria-hidden' => 'true' ] );
								else : ?>
									<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
								<?php endif; ?>
							</div>
							<?php
						endif;
					?>

					<?php if ( '3' === $settings['image_box_style'] ) : ?>
						<?php if ( ! empty($settings['subtitle']) ) : ?>
							<div class="subtitle"><?php echo esc_html($settings['subtitle']); ?></div>
						<?php endif; ?>

						<<?php Utils::print_validated_html_tag($settings['title_tag']); ?> class="title">
							<?php $this->print_unescaped_setting('title'); ?>
						</<?php Utils::print_validated_html_tag($settings['title_tag']); ?>>
					<?php endif; ?>

					<?php if ( '3' != $settings['image_box_style'] ) : ?>
						<div class="title-wrap">
							<?php if ( ! empty($settings['subtitle']) ) : ?>
								<div class="subtitle"><?php echo esc_html($settings['subtitle']); ?></div>
							<?php endif; ?>

							<<?php Utils::print_validated_html_tag($settings['title_tag']); ?> class="title">
								<?php $this->print_unescaped_setting('title'); ?>
							</<?php Utils::print_validated_html_tag($settings['title_tag']); ?>>
						</div>
					<?php endif; ?>

					<?php if ( ! empty($settings['description']) ) : ?>
						<div class="description"><?php echo esc_html($settings['description']); ?></div>
					<?php endif; ?>

					<?php
					if ( '2' != $settings['image_box_style'] && 'button' === $settings['link_type'] ) {
						$this->render_button( $settings );
					}
					?>
				</div>
			</div>
		</<?php Utils::print_validated_html_tag($link_tag); ?>>
		<?php
	}
}
