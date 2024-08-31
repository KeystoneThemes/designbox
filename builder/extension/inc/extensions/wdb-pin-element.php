<?php
/**
 * Animation Effects extension class.
 */

namespace WDBAddonsEX\Extensions;

use Elementor\Controls_Manager;
use Elementor\Plugin;

defined( 'ABSPATH' ) || die();

class WDB_Pin_Effects {

	public static function init() {
		//ping area controls
		add_action( 'elementor/element/section/section_advanced/after_section_end', [
			__CLASS__,
			'register_ping_area_controls'
		] );

		add_action( 'elementor/element/container/section_layout/after_section_end', [
			__CLASS__,
			'register_ping_area_controls'
		] );
	}

	public static function register_ping_area_controls( $element ) {
		$element->start_controls_section(
			'_section_pin-area',
			[
				'label' =>  sprintf('%s <i class="wdb-logo"></i>', __('Pin Element', 'extension')),
				'tab'           => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'wdb_enable_pin_area',
			[
				'label'              => esc_html__( 'Enable Pin', 'extension' ),
				'description'        => esc_html__( 'If you changed any options value, please reload the browser.', 'extension' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'return_value'       => 'yes',
			]
		);

		$element->add_control(
			'wdb_pin_area_trigger',
			[
				'label'     => esc_html__( 'Pin Wrapper', 'extension' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''       => esc_html__( 'Default', 'extension' ),
					'custom' => esc_html__( 'Custom', 'extension' ),
				],
				'condition' => [ 'wdb_enable_pin_area!' => '' ],
			]
		);

		$element->add_control(
			'wdb_custom_pin_area',
			[
				'label'       => esc_html__( 'Custom Pin Area', 'extension' ),
				'description' => esc_html__( 'Add the section class where the element will be pin. please use the parent section or container class.', 'extension' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => false,
				'placeholder' => esc_html__( '.pin_area', 'extension' ),
				'frontend_available' => true,
				'condition'   => [
					'wdb_pin_area_trigger' => 'custom',
					'wdb_enable_pin_area!' => '',
				]
			]
		);

		$element->add_control(
			'wdb_pin_area_start',
			[
				'label'              => esc_html__( 'Start', 'extension' ),
				'description'        => esc_html__( 'First value is element position, Second value is display position', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'separator'          => 'before',
				'default'            => 'top top',
				'frontend_available' => true,
				'options'            => [
					'top top'       => esc_html__( 'Top Top', 'extension' ),
					'top center'    => esc_html__( 'Top Center', 'extension' ),
					'top bottom'    => esc_html__( 'Top Bottom', 'extension' ),
					'center top'    => esc_html__( 'Center Top', 'extension' ),
					'center center' => esc_html__( 'Center Center', 'extension' ),
					'center bottom' => esc_html__( 'Center Bottom', 'extension' ),
					'bottom top'    => esc_html__( 'Bottom Top', 'extension' ),
					'bottom center' => esc_html__( 'Bottom Center', 'extension' ),
					'bottom bottom' => esc_html__( 'Bottom Bottom', 'extension' ),
					'custom'        => esc_html__( 'custom', 'extension' ),
				],
				'condition'          => [ 'wdb_enable_pin_area!' => '' ],
			]
		);

		$element->add_control(
			'wdb_pin_area_start_custom',
			[
				'label'       => esc_html__( 'Custom', 'extension' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'top top', 'extension' ),
				'placeholder' => esc_html__( 'top top+=100', 'extension' ),
				'frontend_available' => true,
				'condition'          => [
					'wdb_enable_pin_area!' => '',
					'wdb_pin_area_start' => 'custom',
				],
			]
		);

		$element->add_control(
			'wdb_pin_area_end',
			[
				'label'              => esc_html__( 'End', 'extension' ),
				'description'        => esc_html__( 'First value is element position, Second value is display position', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'separator'          => 'before',
				'default'            => 'bottom top',
				'frontend_available' => true,
				'options'            => [
					'top top'       => esc_html__( 'Top Top', 'extension' ),
					'top center'    => esc_html__( 'Top Center', 'extension' ),
					'top bottom'    => esc_html__( 'Top Bottom', 'extension' ),
					'center top'    => esc_html__( 'Center Top', 'extension' ),
					'center center' => esc_html__( 'Center Center', 'extension' ),
					'center bottom' => esc_html__( 'Center Bottom', 'extension' ),
					'bottom top'    => esc_html__( 'Bottom Top', 'extension' ),
					'bottom center' => esc_html__( 'Bottom Center', 'extension' ),
					'bottom bottom' => esc_html__( 'Bottom Bottom', 'extension' ),
					'custom'        => esc_html__( 'custom', 'extension' ),
				],
				'condition'          => [ 'wdb_enable_pin_area!' => '' ],
			]
		);

		$element->add_control(
			'wdb_pin_area_end_custom',
			[
				'label'       => esc_html__( 'Custom', 'extension' ),
				'type'        => Controls_Manager::TEXT,
				'frontend_available' => true,
				'default'     => esc_html__( 'bottom top', 'extension' ),
				'placeholder' => esc_html__( 'bottom top+=100', 'extension' ),
				'condition'          => [
					'wdb_enable_pin_area!' => '',
					'wdb_pin_area_end' => 'custom',
				],
			]
		);

		$dropdown_options = [
			'' => esc_html__( 'None', 'extension' ),
		];

		$excluded_breakpoints = [
			'laptop',
			'tablet_extra',
			'widescreen',
		];

		foreach ( Plugin::$instance->breakpoints->get_active_breakpoints() as $breakpoint_key => $breakpoint_instance ) {
			// Exclude the larger breakpoints from the dropdown selector.
			if ( in_array( $breakpoint_key, $excluded_breakpoints, true ) ) {
				continue;
			}

			$dropdown_options[ $breakpoint_key ] = sprintf(
			/* translators: 1: Breakpoint label, 2: `>` character, 3: Breakpoint value. */
				esc_html__( '%1$s (%2$s %3$dpx)', 'extension' ),
				$breakpoint_instance->get_label(),
				'>',
				$breakpoint_instance->get_value()
			);
		}

		$element->add_control(
			'wdb_pin_breakpoint',
			[
				'label'        => esc_html__( 'Breakpoint', 'extension' ),
				'type'         => Controls_Manager::SELECT,
				'separator'    => 'before',
				'description'  => esc_html__( 'Note: Choose at which breakpoint Pin element will work.', 'extension' ),
				'options'      => $dropdown_options,
				'frontend_available' => true,
				'default'      => 'mobile',
			]
		);

		$element->end_controls_section();
	}
}

WDB_Pin_Effects::init();
