<?php
/**
 * Animation Effects extension class.
 */

namespace WDBAddonsEX\Extensions;

use Elementor\Element_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

defined( 'ABSPATH' ) || die();

class WDB_Animation_Effects {

	public static function init() {

		//animation controls
		add_action( 'elementor/element/common/_section_style/after_section_end', [
			__CLASS__,
			'register_animation_controls',
		] );

		add_action( 'elementor/element/container/section_layout/after_section_end', [
			__CLASS__,
			'register_animation_controls'
		] );

		add_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'wdb_attributes' ] );
		add_action( 'elementor/frontend/container/before_render', [ __CLASS__, 'wdb_attributes' ] );

		add_action( 'elementor/preview/enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
	}

	public static function enqueue_scripts() {

	}

	/**
	 * Set attributes based extension settings
	 *
	 * @param Element_Base $section
	 *
	 * @return void
	 */
	public static function wdb_attributes( $element ) {
		if ( ! empty( $element->get_settings( 'wdb_enable_scroll_smoother' ) ) ) {
			$attributes = [];

			if ( ! empty( $element->get_settings( 'data-speed' ) ) ) {
				$attributes['data-speed'] = $element->get_settings( 'data-speed' );
			}
			if ( ! empty( $element->get_settings( 'data-lag' ) ) ) {
				$attributes['data-lag'] = $element->get_settings( 'data-lag' );
			}

			$element->add_render_attribute( '_wrapper', $attributes );
		}
	}

	public static function register_animation_controls( $element ) {
		$element->start_controls_section(
			'_section_wdb_animation',
			[
				'label' =>  sprintf('%s <i class="wdb-logo"></i>', __('Animation', 'extension')),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'wdb-animation',
			[
				'label'              => esc_html__( 'Animation', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'none',
				'separator'          => 'before',
				'options'            => [
					'none' => esc_html__( 'none', 'extension' ),
					'fade' => esc_html__( 'fade animation', 'extension' ),
				],
				'render_type'        => 'template',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'delay',
			[
				'label'              => esc_html__( 'Delay', 'extension' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 0,
				'max'                => 10,
				'step'               => 0.1,
				'default'            => .15,
				'condition'          => [
					'wdb-animation!' => 'none',
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'on-scroll',
			[
				'label'              => esc_html__( 'Animation on scroll', 'extension' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'extension' ),
				'label_off'          => esc_html__( 'No', 'extension' ),
				'return_value'       => 1,
				'default'            => 1,
				'frontend_available' => true,
				'condition'          => [
					'wdb-animation!' => 'none',
				],
			]
		);

		$element->add_control(
			'fade-from',
			[
				'label'              => esc_html__( 'Fade from', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'top',
				'options'            => [
					'top'    => esc_html__( 'Top', 'extension' ),
					'bottom' => esc_html__( 'Bottom', 'extension' ),
					'left'   => esc_html__( 'Left', 'extension' ),
					'right'  => esc_html__( 'Right', 'extension' ),
					'in'     => esc_html__( 'In', 'extension' ),
				],
				'frontend_available' => true,
				'condition'          => [
					'wdb-animation!' => 'none',
				],
			]
		);

		$element->add_control(
			'data-duration',
			[
				'label'              => esc_html__( 'Duration', 'extension' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 1.5,
				'condition'          => [
					'wdb-animation!' => 'none',
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'ease',
			[
				'label'              => esc_html__( 'Ease', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'power2.out',
				'options'            => [
					'power2.out' => esc_html__( 'Power2.out', 'extension' ),
					'bounce'     => esc_html__( 'Bounce', 'extension' ),
					'back'       => esc_html__( 'Back', 'extension' ),
					'elastic'    => esc_html__( 'Elastic', 'extension' ),
					'slowmo'     => esc_html__( 'Slowmo', 'extension' ),
					'stepped'    => esc_html__( 'Stepped', 'extension' ),
					'sine'       => esc_html__( 'Sine', 'extension' ),
					'expo'       => esc_html__( 'Expo', 'extension' ),
				],
				'condition'          => [
					'wdb-animation!' => 'none',
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'fade-offset',
			[
				'label'              => esc_html__( 'Fade offset', 'extension' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 50,
				'condition'          => [
					'wdb-animation!' => 'none',
				],
				'frontend_available' => true,
			]
		);

		$dropdown_options = [
			'' => esc_html__( 'All', 'extension' ),
		];

		foreach ( Plugin::$instance->breakpoints->get_active_breakpoints() as $breakpoint_key => $breakpoint_instance ) {

			$dropdown_options[ $breakpoint_key ] = sprintf(
			/* translators: 1: Breakpoint label, 2: `>` character, 3: Breakpoint value. */
				esc_html__( '%1$s (%2$dpx)', 'extension' ),
				$breakpoint_instance->get_label(),
				$breakpoint_instance->get_value()
			);
		}

		$element->add_control(
			'fade_animation_breakpoint',
			[
				'label'              => esc_html__( 'Breakpoint', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'description'        => esc_html__( 'Note: Choose at which breakpoint animation will work.', 'extension' ),
				'options'            => $dropdown_options,
				'frontend_available' => true,
				'default'            => '',
				'condition'          => [
					'wdb-animation!' => 'none',
				],
			]
		);

		$element->add_control(
			'fade_breakpoint_min_max',
			[
				'label'     => esc_html__( 'Breakpoint Min/Max', 'extension' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'min',
				'options'   => [
					'min' => esc_html__( 'Min(>)', 'extension' ),
					'max' => esc_html__( 'Max(<)', 'extension' ),
				],
				'frontend_available' => true,
				'condition' => [
					'wdb-animation!'        => 'none',
					'fade_animation_breakpoint!' => '',
				],
			]
		);

		//smooth scroll animation
		$element->add_control(
			'wdb_enable_scroll_smoother',
			[
				'label'        => esc_html__( 'Enable Scroll Smoother', 'extension' ),
				'description'  => esc_html__( 'If you want to use scroll smooth, please enable global settings first', 'extension' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'extension' ),
				'label_off'    => esc_html__( 'No', 'extension' ),
				'return_value' => 'yes',
				'separator'    => 'before',
			]
		);

		$element->add_control(
			'data-speed',
			[
				'label'     => esc_html__( 'Speed', 'extension' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0.9,
				'condition' => [ 'wdb_enable_scroll_smoother' => 'yes' ],
			]
		);

		$element->add_control(
			'data-lag',
			[
				'label'     => esc_html__( 'Lag', 'extension' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => [ 'wdb_enable_scroll_smoother' => 'yes' ],
			]
		);

		$element->end_controls_section();
	}

}

WDB_Animation_Effects::init();
