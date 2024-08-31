<?php
/**
 * Animation Effects extension class.
 */

namespace WDBAddonsEX\Extensions;

use Elementor\Element_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

defined( 'ABSPATH' ) || die();

class WDB_Text_Animation_Effects {

	public static function init() {
		$text_elements = [
			[
				'name'    => 'heading',
				'section' => 'section_title',
			],
			[
				'name'    => 'text-editor',
				'section' => 'section_editor',
			],
			[
				'name'    => 'wdb--title',
				'section' => 'section_content',
			],
			[
				'name'    => 'wdb--text',
				'section' => 'section_content',
			],
		];
		foreach ( $text_elements as $element ) {
			add_action( 'elementor/element/' . $element['name'] . '/' . $element['section'] . '/after_section_end', [
				__CLASS__,
				'register_text_animation_controls',
			], 10, 2 );
		}
	}

	public static function register_text_animation_controls( $element ) {
		$element->start_controls_section(
			'_section_wdb_text_animation',
			[
				'label' => sprintf( '%s <i class="wdb-logo"></i>', __( 'Text Animation', 'extension' ) ),
			]
		);

		$animation = [
			'none'        => esc_html__( 'none', 'extension' ),
			'char'        => esc_html__( 'Character', 'extension' ),
			'word'        => esc_html__( 'Word', 'extension' ),
			'text_move'   => esc_html__( 'Text Move', 'extension' ),
			'text_reveal' => esc_html__( 'Text Reveal', 'extension' ),
		];

		if ( in_array( $element->get_name(), [ 'heading', 'wdb--title' ] ) ) {
			$animation['text_invert'] = esc_html__( 'Text Invert', 'extension' );
		}

		$element->add_control(
			'wdb_text_animation',
			[
				'label'              => esc_html__( 'Animation', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'none',
				'separator'          => 'before',
				'options'            => $animation,
				'render_type'        => 'template',
				'prefix_class'       => 'wdb-t-animation-',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'text_delay',
			[
				'label'              => esc_html__( 'Delay', 'extension' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 0,
				'max'                => 10,
				'step'               => 0.1,
				'default'            => 0.15,
				'condition'          => [
					'wdb_text_animation!' => 'none',
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'text_stagger',
			[
				'label'              => esc_html__( 'Stagger', 'extension' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 0,
				'max'                => 10,
				'step'               => 0.01,
				'default'            => 0.02,
				'condition'          => [
					'wdb_text_animation' => [ 'char', 'word', 'text_reveal' ],
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'text_on_scroll',
			[
				'label'              => esc_html__( 'Animation on scroll', 'extension' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'extension' ),
				'label_off'          => esc_html__( 'No', 'extension' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'condition'          => [
					'wdb_text_animation!' => 'none',
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'text_translate_x',
			[
				'label'              => esc_html__( 'Translate-X', 'extension' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 20,
				'condition'          => [
					'wdb_text_animation' => [ 'char', 'word' ],
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'text_translate_y',
			[
				'label'              => esc_html__( 'Translate-Y', 'extension' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 0,
				'condition'          => [
					'wdb_text_animation' => [ 'char', 'word' ],
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
			'text_animation_breakpoint',
			[
				'label'              => esc_html__( 'Breakpoint', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'description'        => esc_html__( 'Note: Choose at which breakpoint animation will work.', 'extension' ),
				'options'            => $dropdown_options,
				'frontend_available' => true,
				'default'            => '',
				'condition'          => [
					'wdb_text_animation!' => 'none',
				],
			]
		);

		$element->add_control(
			'text_breakpoint_min_max',
			[
				'label'              => esc_html__( 'Breakpoint Min/Max', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'min',
				'options'            => [
					'min' => esc_html__( 'Min(>)', 'extension' ),
					'max' => esc_html__( 'Max(<)', 'extension' ),
				],
				'frontend_available' => true,
				'condition'          => [
					'wdb_text_animation!'        => 'none',
					'text_animation_breakpoint!' => '',
				],
			]
		);

		$element->end_controls_section();
	}

}

WDB_Text_Animation_Effects::init();
