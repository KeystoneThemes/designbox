<?php
/**
 * Animation Effects extension class.
 */

namespace WDBAddonsEX\Extensions;

use Elementor\Element_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

defined( 'ABSPATH' ) || die();

class WDB_Image_Animation_Effects {

	public static function init() {

		$image_elements = [
			[
				'name'    => 'image',
				'section' => 'section_image',
			],
			[
				'name'    => 'wdb--image',
				'section' => 'section_content',
			],
		];
		foreach ( $image_elements as $element ) {
			add_action( 'elementor/element/' . $element['name'] . '/' . $element['section'] . '/after_section_end', [
				__CLASS__,
				'register_image_animation_controls',
			], 10, 2 );
		}

		//image reveal
		$image_reveal_elements = [
			[
				'name'    => 'wdb--image-box',
				'section' => 'section_button_content',
			],
			[
				'name'    => 'wdb--timeline',
				'section' => 'section_timeline',
			],
		];
		foreach ( $image_reveal_elements as $element ) {
			add_action( 'elementor/element/' . $element['name'] . '/' . $element['section'] . '/after_section_end', [
				__CLASS__,
				'register_image_reveal_animation_controls',
			], 10, 2 );
		}
	}


	public static function register_image_animation_controls( $element ) {
		$element->start_controls_section(
			'_section_wdb_image_animation',
			[
				'label' =>  sprintf('%s <i class="wdb-logo"></i>', __('Image Animation', 'extension')),
			]
		);

		$element->add_control(
			'wdb-image-animation',
			[
				'label'              => esc_html__( 'Animation', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'none',
				'separator'          => 'before',
				'options'            => [
					'none'    => esc_html__( 'none', 'extension' ),
					'reveal'  => esc_html__( 'Reveal', 'extension' ),
					'scale'   => esc_html__( 'Scale', 'extension' ),
					'stretch' => esc_html__( 'Stretch', 'extension' ),
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'wdb-scale-start',
			[
				'label'     => esc_html__( 'Start Scale', 'extension' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0.7,
				'condition' => [ 'wdb-image-animation' => 'scale' ],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'wdb-scale-end',
			[
				'label'     => esc_html__( 'End Scale', 'extension' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'condition' => [ 'wdb-image-animation' => 'scale' ],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'wdb-animation-start',
			[
				'label'              => esc_html__( 'Animation Start', 'extension' ),
				'description'        => esc_html__( 'First value is element position, Second value is display position', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'top top',
				'frontend_available' => true,
				'render_type'        => 'template',
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
					'custom'        => esc_html__( 'Custom', 'extension' ),
				],
				'condition'          => [ 'wdb-image-animation' => 'scale' ],
			]
		);

		$element->add_control(
			'wdb_animation_custom_start',
			[
				'label'       => esc_html__( 'Custom', 'extension' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'top 90%', 'extension' ),
				'placeholder' => esc_html__( 'top 90%', 'extension' ),
				'render_type'        => 'template',
				'condition'   => [
					'wdb-image-animation' => 'scale',
					'wdb-animation-start' => 'custom'
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'image-ease',
			[
				'label'              => esc_html__( 'Data ease', 'extension' ),
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
				'condition'          => [ 'wdb-image-animation' => 'reveal' ],
				'frontend_available' => true,
			]
		);

		$element->end_controls_section();
	}

	public static function register_image_reveal_animation_controls( $element ) {
		$element->start_controls_section(
			'_section_wdb_image_animation',
			[
				'label' =>  sprintf('%s <i class="wdb-logo"></i>', __('Image Animation', 'extension')),
			]
		);

		$element->add_control(
			'wdb-image-animation',
			[
				'label'              => esc_html__( 'Animation', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'none',
				'separator'          => 'before',
				'options'            => [
					'none'   => esc_html__( 'none', 'extension' ),
					'reveal' => esc_html__( 'Reveal', 'extension' ),
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'image-ease',
			[
				'label'              => esc_html__( 'Data ease', 'extension' ),
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
				'condition'          => [ 'wdb-image-animation' => 'reveal' ],
				'frontend_available' => true,
			]
		);

		$element->end_controls_section();
	}

}

WDB_Image_Animation_Effects::init();
