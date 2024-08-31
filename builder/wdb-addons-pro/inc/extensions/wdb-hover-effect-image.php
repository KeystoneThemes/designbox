<?php
/**
 * Test Effects extension class.
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

class WDB_Hover_Effect_Image {

	public static function init() {
		add_action( 'elementor/element/container/section_layout/after_section_end', [
			__CLASS__,
			'register_hover_image_controls'
		] );
	}

	public static function enqueue_scripts() {

	}

	public static function register_hover_image_controls( $element ) {
		$element->start_controls_section(
			'_section_wdb_hover_image_area',
			[
				'label' =>  sprintf('%s <i class="wdb-logo"></i>', __('Hover effect image', 'wdb-addons-pro')),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);

		$element->add_control(
			'wdb_enable_hover_image',
			[
				'label'              => esc_html__( 'Enable', 'wdb-addons-pro' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'return_value'       => 'yes',
			]
		);

		$element->add_control(
			'wdb_enable_hover_image_editor',
			[
				'label'              => esc_html__( 'Enable On Editor', 'wdb-addons-pro' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'return_value'       => 'yes',
				'condition' => [ 'wdb_enable_hover_image!' => '' ]
			]
		);

		$element->add_control(
			'wdb_hover_image',
			[
				'label' => esc_html__( 'Choose Image', 'wdb-addons-pro' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'selectors'  => [
					'{{WRAPPER}} .wdb-image-hover' => 'background-image: url( {{URL}} );',
				],
			]
		);

		$element->add_responsive_control(
			'wdb_hover_image_width',
			[
				'label'      => esc_html__( 'Width', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wdb-image-hover' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$element->add_responsive_control(
			'wdb_hover_image_height',
			[
				'label'      => esc_html__( 'Height', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'separator'  => 'after',
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wdb-image-hover' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$element->add_responsive_control(
			'wdb_hover_image_position_top',
			[
				'label'      => esc_html__( 'Position Top', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'%'  => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wdb-image-hover' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$element->add_responsive_control(
			'wdb_hover_image_position_left',
			[
				'label'      => esc_html__( 'Position Left', 'wdb-addons-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => - 1000,
						'max' => 1000,
					],
					'%'  => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wdb-image-hover' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$element->add_control(
			'wdb_hover_image_zindex',
			[
				'label' => esc_html__( 'Z-index', 'wdb-addons-pro' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => - 9999,
				'max'   => 9999,
				'selectors'  => [
					'{{WRAPPER}} .wdb-image-hover' => 'z-index: {{VALUE}};',
				],
			]
		);

		$element->end_controls_section();
	}
}

WDB_Hover_Effect_Image::init();
