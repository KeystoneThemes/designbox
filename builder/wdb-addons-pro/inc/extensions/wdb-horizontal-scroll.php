<?php
/**
 * Horizontal Scroll extension class.
 */

namespace WDBAddonsPro\Extensions;

use Elementor\Element_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class WDB_Horizontal_Scroll {

	public static function init() {
		add_action( 'elementor/element/container/section_layout/after_section_end', [
			__CLASS__,
			'register_horizontal_scroll_controls'
		] );
	}

	public static function enqueue_scripts() {

	}

	public static function register_horizontal_scroll_controls( $element ) {

		$element->start_controls_section(
			'_section_wdb_horizontal_scroll_area',
			[
				'label' =>  sprintf('%s <i class="wdb-logo"></i>', __('Horizontal Scroll', 'wdb-addons-pro')),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'important_note',
			[
				'label'           => esc_html__( 'Important Note', 'wdb-addons-pro' ),
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Please use full width Container to work properly.', 'wdb-addons-pro' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);

		$element->add_control(
			'wdb_enable_horizontal_scroll',
			[
				'label'              => esc_html__( 'Enable', 'wdb-addons-pro' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'return_value'       => 'yes',
			]
		);

		$element->add_control(
			'horizontal_scroll_width',
			[
				'label'              => esc_html__( 'Width', 'wdb-addons-pro' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'              => [
					'px' => [
						'min' => 100,
						'max' => 50000,
					],
					'%'  => [
						'min' => 10,
						'max' => 1000,
					],
				],
				'default'            => [
					'unit' => '%',
					'size' => 500,
				],
				'frontend_available' => true,
				'condition'          => [ 'wdb_enable_horizontal_scroll!' => '' ]
			]
		);

		$dropdown_options = [
			'' => esc_html__( 'All', 'wdb-addons-pro' ),
		];

		foreach ( Plugin::$instance->breakpoints->get_active_breakpoints() as $breakpoint_key => $breakpoint_instance ) {

			$dropdown_options[ $breakpoint_key ] = sprintf(
			/* translators: 1: Breakpoint label, 2: `>` character, 3: Breakpoint value. */
				esc_html__( '%1$s (%2$dpx)', 'wdb-addons-pro' ),
				$breakpoint_instance->get_label(),
				$breakpoint_instance->get_value()
			);
		}

		$element->add_control(
			'horizontal_scroll_breakpoint',
			[
				'label'              => esc_html__( 'Breakpoint', 'wdb-addons-pro' ),
				'type'               => Controls_Manager::SELECT,
				'description'        => esc_html__( 'Note: Choose at which breakpoint horizontal scroll will work.', 'wdb-addons-pro' ),
				'options'            => $dropdown_options,
				'frontend_available' => true,
				'default'            => 'mobile',
				'condition'          => [
					'wdb_enable_horizontal_scroll!' => '',
				],
			]
		);

		$element->end_controls_section();
	}
}

WDB_Horizontal_Scroll::init();
