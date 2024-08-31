<?php

namespace WDB_ADDONS\Widgets;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use WDB_ADDONS\Widgets\Nav_Menu\WDB_Menu_Walker;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Nav Menu
 *
 * Elementor widget for navigation manu
 *
 * @since 1.0.0
 */
class Nav_Menu extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_name() {
		return 'wdb--nav-menu';
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
		return esc_html__( ' Nav Menu', 'designbox-builder' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'wdb eicon-nav-menu';
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
	 *
	 */
	public function get_categories() {
		return [ 'wdb-hf-addon' ];
	}

	/**
	 * Requires css files.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return [
//		        'wdb--nav-menu'
		];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @return array Widget scripts dependencies.
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_script_depends() {
		return [ 'wdb--nav-menu' ];
	}

	public function get_menus(){
		$list = [];
		$menus = wp_get_nav_menus();
		foreach($menus as $menu){
			$list[$menu->slug] = $menu->name;
		}

		return $list;
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
		$this->start_controls_section(
			'section_menu_settings',
			[
				'label' => esc_html__( 'Menu Settings', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'nav_menu',
			[
				'label'     => esc_html__( 'Select menu', 'designbox-builder' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_menus(),
			]
		);

		$this->add_control(
			'submenu_indicator',
			[
				'label'       => esc_html__( 'Submenu Indicator', 'designbox-builder' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-angle-down',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'menu_layout',
			[
				'label'       => esc_html__( 'Layout', 'designbox-builder' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => [
					'horizontal' => esc_html__( 'Horizontal', 'designbox-builder' ),
					'vertical'   => esc_html__( 'Vertical', 'designbox-builder' ),
				],
				'default'     => 'horizontal',
			]
		);

		$this->add_responsive_control(
			'menu_alignment',
			[
				'label'       => esc_html__( 'Menu Alignment', 'designbox-builder' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default'     => '',
				'options'     => [
					'flex-start'    => [
						'title' => esc_html__( 'Start', 'designbox-builder' ),
						'icon'  => 'eicon-flex eicon-align-start-h',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'designbox-builder' ),
						'icon'  => 'eicon-flex eicon-align-center-h',
					],
					'flex-end'      => [
						'title' => esc_html__( 'End', 'designbox-builder' ),
						'icon'  => 'eicon-flex eicon-align-end-h',
					],
					'space-between' => [
						'title' => esc_html__( 'Space Between', 'designbox-builder' ),
						'icon'  => 'eicon-flex eicon-align-stretch-h',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .wdb-nav-menu-nav' => 'justify-content: {{VALUE}};',
				],
				'condition'   => [ 'menu_layout' => 'horizontal' ]
			]
		);

		$this->add_control(
			'menu_hover_pointer',
			[
				'label'       => esc_html__( 'Hover Pointer', 'designbox-builder' ),
				'description' => esc_html__( 'Apply on desktop menu first depth', 'designbox-builder' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					''             => esc_html__( 'None', 'designbox-builder' ),
					'dot'          => esc_html__( 'Dot', 'designbox-builder' ),
					'underline'    => esc_html__( 'Underline', 'designbox-builder' ),
					'overline'     => esc_html__( 'Overline', 'designbox-builder' ),
					'line-through' => esc_html__( 'Line Through', 'designbox-builder' ),
					'flip' => esc_html__( 'Flip', 'designbox-builder' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_mobile_menu_settings',
			[
				'label' => esc_html__( 'Mobile Menu Settings', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'hamburger_icon',
			[
				'label'       => esc_html__( 'Hamburger Icon', 'designbox-builder' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-bars',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'mobile_close',
			[
				'label'       => esc_html__( 'Mobile Icon', 'designbox-builder' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-times',
					'library' => 'fa-solid',
				],
			]
		);

		$dropdown_options = [
			'' => esc_html__( 'None', 'extension' ),
			'all' => esc_html__( 'All', 'extension' ),
		];

		$excluded_breakpoints = [
			'widescreen',
		];

		foreach ( Plugin::$instance->breakpoints->get_active_breakpoints() as $breakpoint_key => $breakpoint_instance ) {
			// Exclude the larger breakpoints from the dropdown selector.
			if ( in_array( $breakpoint_key, $excluded_breakpoints, true ) ) {
				continue;
			}

			$dropdown_options[ $breakpoint_key ] = sprintf(
			/* translators: 1: Breakpoint label, 2: `>` character, 3: Breakpoint value. */
				esc_html__( '%1$s (%2$s %3$dpx)', 'designbox-builder' ),
				$breakpoint_instance->get_label(),
				'>',
				$breakpoint_instance->get_value()
			);
		}

		$this->add_control(
			'mobile_menu_breakpoint',
			[
				'label'        => esc_html__( 'Breakpoint', 'designbox-builder' ),
				'type'         => Controls_Manager::SELECT,
				'separator'    => 'before',
				'description'  => esc_html__( 'Note: Choose at which breakpoint Mobile Menu will Show.', 'designbox-builder' ),
				'options'      => $dropdown_options,
				'frontend_available' => true,
				'default'      => 'mobile',
			]
		);

		$this->end_controls_section();

		//desktop menu item style
        $this->register_desktop_menu_item_style();

		//desktop submenu item style
        $this->register_desktop_submenu_item_style();

		//desktop submenu indicator style
        $this->register_submenu_indicator_style();

        //hover pointer style
        $this->register_hover_pointer_style();

        //mobile menu item
        $this->register_mobile_menu_style();

        //hamburger
        $this->register_hamburger_style();

        //mobile menu close
        $this->register_mobile_menu_close_style();

        //mobile menu back style
		$this->register_mobile_menu_back_style();
	}

	protected function register_desktop_menu_item_style() {
		$this->start_controls_section(
			'section_desktop_menu_item_style',
			[
				'label' => esc_html__( 'Desktop Menu Item', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desktop_menu_item_typography',
				'selector' => '{{WRAPPER}} .desktop-menu-active .menu-item a',
			]
		);

		$this->add_responsive_control(
			'desktop_menu_item_gap',
			[
				'label'      => esc_html__( 'Gap', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .desktop-menu-active .wdb-nav-menu-nav' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'desktop_menu_item_border',
				'selector' => '{{WRAPPER}} .desktop-menu-active .menu-item a',
			]
		);

		$this->add_responsive_control(
			'desktop_menu_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .desktop-menu-active .menu-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'desktop_menu_item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .desktop-menu-active .menu-item a.wdb-nav-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'desktop_menu_item_style_tabs'
		);

		$this->start_controls_tab(
			'desktop_menu_item_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'desktop_menu_item_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .desktop-menu-active .menu-item a' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'desktop_menu_item_background',
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '{{WRAPPER}} .desktop-menu-active .menu-item a',
			]
		);

		$this->end_controls_tab();

		//hover
		$this->start_controls_tab(
			'desktop_menu_item_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'desktop_menu_item_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .desktop-menu-active .menu-item a:hover, {{WRAPPER}} .desktop-menu-active .menu-item a:focus' => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'desktop_menu_item_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '{{WRAPPER}} .desktop-menu-active .menu-item a:hover, {{WRAPPER}} .desktop-menu-active .menu-item a:focus',
			]
		);

		$this->add_control(
			'desktop_menu_item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .desktop-menu-active .menu-item a:hover, {{WRAPPER}} .desktop-menu-active .menu-item a:focus' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'desktop_menu_item_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();

		//active
		$this->start_controls_tab(
			'desktop_menu_item_style_active_tab',
			[
				'label' => esc_html__( 'Active', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'desktop_menu_item_active_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .desktop-menu-active .menu-item.current-menu-item > a' => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'desktop_menu_item_active_background',
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '{{WRAPPER}} .desktop-menu-active .menu-item.current-menu-item > a',
			]
		);

		$this->add_control(
			'desktop_menu_item_active_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .desktop-menu-active .menu-item.current-menu-item > a' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'desktop_menu_item_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_desktop_submenu_item_style() {
		$this->start_controls_section(
			'section_desktop_submenu_item_style',
			[
				'label' => esc_html__( 'Desktop Submenu Item', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'desktop_submenu_width',
			[
				'label' => esc_html__( 'Width', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .desktop-menu-active .sub-menu' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'desktop_submenu_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .desktop-menu-active .sub-menu',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'desktop_submenu_border',
				'selector' => '{{WRAPPER}} .desktop-menu-active .sub-menu',
			]
		);

		$this->add_responsive_control(
			'desktop_submenu_padding',
			[
				'label'      => esc_html__( 'Wrapper Padding', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .desktop-menu-active .sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'desktop_submenu_border_radius',
			[
				'label'      => esc_html__( 'Wrapper Border Radius', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator' => 'after',
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .desktop-menu-active .sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'desktop_submenu_heading',
			[
				'label' => esc_html__( 'Submenu Items', 'designbox-builder' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desktop_submenu_item_typography',
				'selector' => '{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'desktop_submenu_item_border',
				'selector' => '{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a',
			]
		);

		$this->add_responsive_control(
			'desktop_submenu_item_padding',
			[
				'label'      => esc_html__( 'Item Padding', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'desktop_submenu_item_border_radius',
			[
				'label'      => esc_html__( 'Item Border Radius', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'desktop_submenu_item_style_tabs'
		);

		$this->start_controls_tab(
			'desktop_submenu_item_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'desktop_submenu_item_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'desktop_submenu_item_background',
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a',
			]
		);

		$this->end_controls_tab();

		//hover
		$this->start_controls_tab(
			'desktop_submenu_item_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'desktop_submenu_item_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a:hover, {{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a:focus' => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'desktop_submenu_item_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a:hover, {{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a:focus',
			]
		);

		$this->add_control(
			'desktop_submenu_item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a:hover, {{WRAPPER}} .desktop-menu-active .sub-menu .menu-item a:focus' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'desktop_submenu_item_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();

		//active
		$this->start_controls_tab(
			'desktop_submenu_item_style_active_tab',
			[
				'label' => esc_html__( 'Active', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'desktop_submenu_item_active_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item.current-menu-item > a' => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'desktop_submenu_item_active_background',
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item.current-menu-item > a',
			]
		);

		$this->add_control(
			'desktop_submenu_item_active_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .desktop-menu-active .sub-menu .menu-item.current-menu-item > a' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'desktop_submenu_item_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_submenu_indicator_style() {
		$this->start_controls_section(
			'section_submenu_indicator_style',
			[
				'label' => esc_html__( 'Submenu Indicator', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'submenu_indicator_size',
			[
				'label'      => esc_html__( 'Font Size', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .wdb-submenu-indicator' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'submenu_indicator_margin',
			[
				'label'      => esc_html__( 'Margin', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .wdb-submenu-indicator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_mobile_menu_style() {
		$this->start_controls_section(
			'section_mobile_menu_style',
			[
				'label' => esc_html__( 'Mobile Menu', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'mobile_menu_position',
			[
				'label'       => esc_html__( 'Position', 'designbox-builder' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'  => [
						'title' => esc_html__( 'left', 'designbox-builder' ),
						'icon'  => 'fa fa-angle-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'designbox-builder' ),
						'icon'  => 'fa fa-angle-right',
					],
				],
				'default'     => 'right',
			]
		);

		$this->add_responsive_control(
			'mobile_menu_width',
			[
				'label'      => esc_html__( 'Width', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .mobile-menu-active .wdb-nav-menu-container' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'mobile_menu_background',
				'types'     => [ 'classic', 'gradient' ],
				'separator' => 'after',
				'selector'  => '{{WRAPPER}} .mobile-menu-active .wdb-nav-menu-container, {{WRAPPER}} .mobile-menu-active .menu-item-has-children .sub-menu',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'mobile_menu_item_typography',
				'selector' => '{{WRAPPER}} .mobile-menu-active .menu-item a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'mobile_menu_item_border',
				'selector' => '{{WRAPPER}} .mobile-menu-active .menu-item a, {{WRAPPER}} .mobile-menu-active .menu-item-has-children .sub-menu .menu-item a',
			]
		);

		$this->add_responsive_control(
			'mobile_menu_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .mobile-menu-active .menu-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'mobile_menu_item_style_tabs'
		);

		$this->start_controls_tab(
			'mobile_menu_item_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'mobile_menu_item_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .mobile-menu-active .menu-item a' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'mobile_menu_item_background',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .mobile-menu-active .menu-item a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'mobile_menu_item_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'mobile_menu_item_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mobile-menu-active .menu-item a:hover, {{WRAPPER}} .mobile-menu-active .menu-item a:focus' => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'mobile_menu_item_hover_background',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .mobile-menu-active .menu-item a:hover, {{WRAPPER}} .mobile-menu-active .menu-item a:focus',
			]
		);

		$this->add_control(
			'mobile_menu_item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mobile-menu-active .menu-item a:hover, {{WRAPPER}} .mobile-menu-active .menu-item a:focus' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'mobile_menu_item_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_hamburger_style() {
		$this->start_controls_section(
			'section_hamburger_style',
			[
				'label' => esc_html__( 'Hamburger', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'hamburger_size',
			[
				'label'      => esc_html__( 'Font Size', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .wdb-menu-hamburger' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'hamburger_border',
				'selector' => '{{WRAPPER}} .wdb-menu-hamburger',
			]
		);

		$this->add_responsive_control(
			'hamburger_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'designbox-builder' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .wdb-menu-hamburger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'hamburger_padding',
			[
				'label'      => esc_html__( 'Padding', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .wdb-menu-hamburger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'hamburger_style_tabs'
		);

		$this->start_controls_tab(
			'hamburger_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'hamburger_color',
			[
				'label'     => esc_html__( 'Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wdb-menu-hamburger' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'hamburger_background',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .wdb-menu-hamburger',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hamburger_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'hamburger_hover_color',
			[
				'label'     => esc_html__( 'Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb-menu-hamburger:hover, {{WRAPPER}} .wdb-menu-hamburger:focus' => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'hamburger_hover_background',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .wdb-menu-hamburger:hover, {{WRAPPER}} .wdb-menu-hamburger:focus',
			]
		);

		$this->add_control(
			'hamburger_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb-menu-hamburger:hover, {{WRAPPER}} .wdb-menu-hamburger:focus' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'hamburger_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_mobile_menu_close_style() {
		$this->start_controls_section(
			'section_mobile_menu_close_style',
			[
				'label' => esc_html__( 'Mobile Menu Close', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'mobile_menu_close_size',
			[
				'label'      => esc_html__( 'Font Size', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .wdb-menu-close' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'mobile_menu_close_border',
				'selector' => '{{WRAPPER}} .wdb-menu-close',
			]
		);

		$this->add_responsive_control(
			'mobile_menu_close_padding',
			[
				'label'      => esc_html__( 'Padding', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .wdb-menu-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mobile_menu_close_margin',
			[
				'label'      => esc_html__( 'Margin', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .wdb-menu-close' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'mobile_menu_close_style_tabs'
		);

		$this->start_controls_tab(
			'mobile_menu_close_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'mobile_menu_close_color',
			[
				'label'     => esc_html__( 'Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wdb-menu-close' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'mobile_menu_close_background',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .wdb-menu-close',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'mobile_menu_close_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'mobile_menu_close_hover_color',
			[
				'label'     => esc_html__( 'Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb-menu-close:hover, {{WRAPPER}} .wdb-menu-close:focus' => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'mobile_menu_close_hover_background',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .wdb-menu-close:hover, {{WRAPPER}} .wdb-menu-close:focus',
			]
		);

		$this->add_control(
			'mobile_menu_close_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb-menu-close:hover, {{WRAPPER}} .wdb-menu-close:focus' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'mobile_menu_close_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_mobile_menu_back_style() {
		$this->start_controls_section(
			'section_mobile_menu_back_style',
			[
				'label' => esc_html__( 'Mobile Menu Back', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'back_icon',
			[
				'label'              => esc_html__( 'Icon', 'designbox-builder' ),
				'type'               => Controls_Manager::ICONS,
				'default'            => [
					'value'   => 'fas fa-arrow-left',
					'library' => 'fa-solid',
				],
				'skin'               => 'inline',
				'label_block'        => false,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'mobile_menu_back__typography',
				'selector' => '{{WRAPPER}} .mobile-menu-active a.nav-back-link',
			]
		);

		$this->add_responsive_control(
			'mobile_menu_back_padding',
			[
				'label'      => esc_html__( 'Padding', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .mobile-menu-active a.nav-back-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'mobile_menu_back_style_tabs'
		);

		$this->start_controls_tab(
			'mobile_menu_back_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'mobile_menu_back_color',
			[
				'label'     => esc_html__( 'Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .mobile-menu-active a.nav-back-link' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'mobile_menu_back_background',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .mobile-menu-active a.nav-back-link',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'mobile_menu_back_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'mobile_menu_back_hover_color',
			[
				'label'     => esc_html__( 'Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mobile-menu-active a.nav-back-link:hover, {{WRAPPER}} .mobile-menu-active a.nav-back-link:focus' => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'mobile_menu_back_hover_background',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .mobile-menu-active a.nav-back-link:hover, {{WRAPPER}} .mobile-menu-active a.nav-back-link:focus',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_hover_pointer_style() {
		$this->start_controls_section(
			'section_hover_pointer_style',
			[
				'label'     => esc_html__( 'Hover Pointer', 'designbox-builder' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'menu_hover_pointer!' => '',
				],
			]
		);

		$this->add_control(
			'hover_pointer_width',
			[
				'label'      => esc_html__( 'Hover Pointer Width', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .menu-item a:after' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'hover_pointer_height',
			[
				'label'      => esc_html__( 'Hover Pointer Height', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .menu-item a:after' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'hover_pointer_color',
			[
				'label'     => esc_html__( 'Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .menu-item a:after' => 'background-color: {{VALUE}} !important',
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

		// Return if menu not selected
		if ( empty( $settings['nav_menu'] ) ) {
			return;
		}

		//include nav menu walker
		if ( ! class_exists( 'WDB_ADDONS\Widgets\Nav_Menu\WDB_Menu_Walker' ) ) {
			include_once WDB_ADDONS_PATH . 'widgets/nav-menu/walker-nav-menu.php';
		}

		$close_button = '<button class="wdb-menu-close" type="button">' . Icons_Manager::try_get_icon_html( $settings['mobile_close'], [ 'aria-hidden' => 'true' ] ) . '</button>';

		//nav menu arguments
		$arg = [
			'items_wrap'             => '<ul id="%1$s" class="%2$s">%3$s</ul>' . $close_button,
			'menu'                   => $settings['nav_menu'],
			'fallback_cb'            => 'wp_page_menu',
			'container'              => 'div',
			'container_class'        => 'wdb-nav-menu-container',
			'menu_class'             => 'wdb-nav-menu-nav ' . 'menu-layout-' . $settings['menu_layout'],
			//this is custom argument
			'submenu_indicator_icon' => Icons_Manager::try_get_icon_html( $settings['submenu_indicator'], [ 'aria-hidden' => 'true' ] ),
			'walker'                 => ( class_exists( 'WDB_ADDONS\Widgets\Nav_Menu\WDB_Menu_Walker' ) ? new WDB_Menu_Walker() : '' )
		];

		//necessary preloaded class for style breaking
		$active_menu_class = 'mobile-menu-active';
		if ( empty( $settings['mobile_menu_breakpoint'] ) ) {
			$active_menu_class = 'desktop-menu-active';
		}

		//wrapper class
		$this->add_render_attribute( 'wrapper', 'class', [
			'wdb__nav-menu ' . $active_menu_class,
			'mobile-menu-' . $settings['mobile_menu_position'],
			'hover-pointer-' . $settings['menu_hover_pointer']
		] );
		?>
        <style>
            .wdb__nav-menu{display:none}.wdb__nav-menu svg{width:1em;height:1em}.wdb__nav-menu .wdb-submenu-indicator{display:inline-flex;justify-content:center;align-items:center;margin-left:auto;padding-left:5px}.wdb__nav-menu .wdb-menu-badge{display:none;font-size:12px;font-weight:500;line-height:1;position:absolute;right:15px;padding:5px 10px;border-radius:5px;background-color:var(--badge-bg);box-shadow:0 2px 5px 2px rgba(0,0,0,.1);margin-top:-22px}.wdb__nav-menu .wdb-menu-badge:after{content:"";position:absolute;top:100%;left:50%;transform:translateX(-50%);border:5px solid var(--badge-bg);border-bottom-color:transparent!important;border-inline-end-color:transparent!important;border-inline-end-width:7px;border-inline-start-width:0}.wdb__nav-menu .wdb-menu-hamburger{margin-left:auto;cursor:pointer;font-size:25px;padding:4px 8px;border:1px solid #dee1e7;outline:0;background:0 0;line-height:1;display:inline-flex;align-items:center;justify-content:center}.wdb__nav-menu.mobile-menu-active{display:block}.wdb__nav-menu.mobile-menu-active .wdb-submenu-indicator{padding:8px 10px;margin:-8px -10px -8px auto}.wdb__nav-menu.mobile-menu-active .wdb-menu-hamburger{display:inline-block}.wdb__nav-menu.mobile-menu-active .wdb-menu-close{align-self:flex-end;margin:10px 10px 10px auto;padding:8px 10px;border:1px solid #555;outline:0;background:0 0;font-size:15px;line-height:1;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;border-radius:50%;min-width:40px;min-height:40px}.wdb__nav-menu.mobile-menu-active .wdb-menu-overlay{position:fixed;top:0;left:0;z-index:1000;background-color:rgba(0,0,0,.5);height:100%;width:100%;transition:.4s;opacity:0;visibility:hidden}.wdb__nav-menu.mobile-menu-active.wdb-nav-is-toggled .wdb-nav-menu-container{transform:translateX(0)!important}.wdb__nav-menu.mobile-menu-active.wdb-nav-is-toggled .wdb-menu-overlay{opacity:1;visibility:visible}.wdb__nav-menu.mobile-menu-active .wdb-nav-menu-container{display:flex;flex-direction:column;position:fixed;z-index:1001;top:0;bottom:0;width:250px;background-color:#fff;overflow-y:auto;overflow-x:hidden;-webkit-overflow-scrolling:touch;transition:.45s}.wdb__nav-menu.mobile-menu-active .wdb-nav-menu-container .wdb-nav-menu-nav{flex:0 0 100%;padding:0;margin:0;order:1}.wdb__nav-menu.mobile-menu-active .menu-item{list-style:none}.wdb__nav-menu.mobile-menu-active .menu-item:not(:last-child) a{border-bottom:solid 1px #dee1e7}.wdb__nav-menu.mobile-menu-active .menu-item a{text-decoration:none;display:flex;padding:.5em 1em;font-size:1rem;line-height:1.5em;transition:.4s}.wdb__nav-menu.mobile-menu-active .menu-item-has-children .sub-menu{position:absolute;top:0;left:0;width:100%;height:100%;background:#fff;transform:translateX(100%);transition:.3s;visibility:hidden;padding:0;margin:0;flex:0 0 100%}.wdb__nav-menu.mobile-menu-active .menu-item-has-children .sub-menu .nav-back-link{display:flex;align-items:center;background-color:#064af3;color:#fff;border:none!important}.wdb__nav-menu.mobile-menu-active .menu-item-has-children.active>.sub-menu{transform:translateX(0);visibility:visible}.wdb__nav-menu.mobile-menu-active .wdb-mega-menu .sub-menu{display:none}.wdb__nav-menu.mobile-menu-active .wdb-mega-menu .wdb-mega-menu-panel{display:none;max-width:100%!important;transition:.3s;opacity:0;visibility:hidden}.wdb__nav-menu.mobile-menu-active .wdb-mega-menu.active>.wdb-mega-menu-panel{display:block;opacity:1;visibility:visible}.wdb__nav-menu.mobile-menu-active .wdb-mega-menu.mobile-wp-submenu .wdb-mega-menu-panel{display:none!important}.wdb__nav-menu.mobile-menu-active .wdb-mega-menu.mobile-wp-submenu .sub-menu{display:block}.wdb__nav-menu.mobile-menu-active.mobile-menu-right .wdb-nav-menu-container{transform:translateX(100%);right:0}.wdb__nav-menu.mobile-menu-active.mobile-menu-left .wdb-nav-menu-container{transform:translateX(-100%);left:0}.wdb__nav-menu.desktop-menu-active{display:block}.wdb__nav-menu.desktop-menu-active .wdb-menu-close,.wdb__nav-menu.desktop-menu-active .wdb-menu-hamburger{display:none}.wdb__nav-menu.desktop-menu-active .wdb-menu-badge{display:block}.wdb__nav-menu.desktop-menu-active .wdb-nav-menu-nav{display:flex;flex-wrap:wrap;margin:0;padding:0}.wdb__nav-menu.desktop-menu-active .wdb-nav-menu-nav.menu-layout-vertical{flex-direction:column}.wdb__nav-menu.desktop-menu-active .wdb-nav-menu-nav.menu-layout-vertical .menu-item-has-children .sub-menu,.wdb__nav-menu.desktop-menu-active .wdb-nav-menu-nav.menu-layout-vertical .wdb-mega-menu .wdb-mega-menu-panel{left:100%;top:auto}.wdb__nav-menu.desktop-menu-active .menu-item{list-style:none;position:relative;white-space:nowrap}.wdb__nav-menu.desktop-menu-active .menu-item a{position:relative;text-decoration:none;display:flex;padding:.5em 1em;transition:.4s;color:#1c1d20;fill:#1c1d20}.wdb__nav-menu.desktop-menu-active .menu-item a:after{content:"";position:absolute;left:0;transition:transform .25s ease-out;transform:scaleX(0);transform-origin:bottom right;height:2px;width:100%;background-color:#3f444b;z-index:2}.wdb__nav-menu.desktop-menu-active .menu-item-has-children .sub-menu{position:absolute;top:100%;left:0;transform:translateY(-10px);background:#fff;transition:.3s;padding:0;margin:0;box-shadow:2px 2px 6px rgba(0,0,0,.2);min-width:12em;z-index:99;opacity:0;visibility:hidden}.wdb__nav-menu.desktop-menu-active .menu-item-has-children .sub-menu a{border-top:solid 1px #dee1e7}.wdb__nav-menu.desktop-menu-active .menu-item-has-children .sub-menu .sub-menu{top:0;left:100%}.wdb__nav-menu.desktop-menu-active .menu-item-has-children:not(.wdb-mega-menu):hover>.sub-menu{transform:translateY(0);opacity:1;visibility:visible}.wdb__nav-menu.desktop-menu-active .wdb-mega-menu.mega-position-static{position:static!important}.wdb__nav-menu.desktop-menu-active .wdb-mega-menu .wdb-mega-menu-panel{position:absolute;top:100%;left:0;transform:translateY(-10px);transition:.3s;padding:0;margin:0;min-width:12em;z-index:99;opacity:0;visibility:hidden}.wdb__nav-menu.desktop-menu-active .wdb-mega-menu:hover>.wdb-mega-menu-panel{transform:translateY(0);opacity:1;visibility:visible}.wdb__nav-menu.desktop-menu-active.hover-pointer-dot a:after{width:6px;height:6px;border-radius:100px;bottom:0;left:50%;transform:translateX(-50%) scale(0);transform-origin:center}.wdb__nav-menu.desktop-menu-active.hover-pointer-dot a:hover:after{transform:translateX(-50%) scale(1)}.wdb__nav-menu.desktop-menu-active.hover-pointer-underline a:after{bottom:0}.wdb__nav-menu.desktop-menu-active.hover-pointer-underline a:hover:after{transform:scaleX(1);transform-origin:bottom left}.wdb__nav-menu.desktop-menu-active.hover-pointer-overline a:after{top:0}.wdb__nav-menu.desktop-menu-active.hover-pointer-overline a:hover:after{transform:scaleX(1);transform-origin:bottom left}.wdb__nav-menu.desktop-menu-active.hover-pointer-line-through a:after{top:50%;transform:translateY(-50%) scaleX(0)}.wdb__nav-menu.desktop-menu-active.hover-pointer-line-through a:hover:after{transform:translateY(-50%) scaleX(1);transform-origin:bottom left}.wdb__nav-menu.desktop-menu-active.hover-pointer-flip a .menu-text{position:relative;transition:transform .3s;transform-origin:50% 0;transform-style:preserve-3d}.wdb__nav-menu.desktop-menu-active.hover-pointer-flip a .menu-text:before{position:absolute;top:100%;left:0;width:100%;height:100%;content:attr(data-text);transform:rotateX(-90deg);transform-origin:50% 0;text-align:center}.wdb__nav-menu.desktop-menu-active.hover-pointer-flip a:hover .menu-text{transform:rotateX(90deg) translateY(-12px)}
        </style>
        <div class="mobile-sub-back" style="display: none">
			<?php Icons_Manager::render_icon( $settings['back_icon'], [ 'aria-hidden' => 'true' ] ); ?>
			<?php esc_html_e( 'Back', 'designbox-builder' ) ?>
        </div>

        <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
            <button class="wdb-menu-hamburger" type="button" aria-label="hamburger-icon">
	            <?php Icons_Manager::render_icon( $settings['hamburger_icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </button>
			<?php wp_nav_menu( $arg ); ?>
            <div class="wdb-menu-overlay"></div>
		</div>
		<?php if ( ! empty( $settings['mobile_menu_breakpoint'] ) && 'all' !== $settings['mobile_menu_breakpoint'] ): ?>
            <script type="text/javascript">
				<?php $breakpoint = Plugin::$instance->breakpoints->get_active_breakpoints()[ $settings['mobile_menu_breakpoint'] ]->get_value(); ?>
                (function () {
                    const windowWidth = window.innerWidth;
                    const menu = document.querySelector('[data-id="<?php echo esc_attr( $this->get_id() ) ?>"] .wdb__nav-menu');

                    //desktop menu active
                    if (windowWidth > <?php echo esc_attr( $breakpoint ) ?>) {
                        menu.classList.remove('mobile-menu-active');
                        menu.classList.add('desktop-menu-active');
                    }
                })();
            </script>
		<?php endif; ?>

		<?php
	}
}
