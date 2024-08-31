<?php
/**
 * Animation Effects extension class.
 */

namespace WDBAddonsEX\Extensions;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class WDB_Popup {

	public static function init() {
		//popup controls
		add_action( 'elementor/element/container/section_layout/after_section_end', [
			__CLASS__,
			'register_popup_controls'
		] );
	}

	public static function register_popup_controls( $element ) {
		$element->start_controls_section(
			'_section_wdb_popup_area',
			[
				'label' => sprintf( '%s <i class="wdb-logo"></i>', __( 'Popup', 'extension' ) ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);

		$element->add_control(
			'wdb_enable_popup',
			[
				'label'              => esc_html__( 'Enable Popup', 'extension' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'return_value'       => 'yes',
			]
		);

		$element->add_control(
			'wdb_enable_popup_editor',
			[
				'label'              => esc_html__( 'Enable On Editor', 'extension' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'return_value'       => 'yes',
				'condition'          => [ 'wdb_enable_popup!' => '' ]
			]
		);

		$element->add_control(
			'popup_content_type',
			[
				'label'     => esc_html__( 'Content Type', 'extension' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'content'  => esc_html__( 'Content', 'extension' ),
					'template' => esc_html__( 'Saved Templates', 'extension' ),
				],
				'default'   => 'content',
				'condition' => [ 'wdb_enable_popup!' => '' ]
			]
		);

		$element->add_control(
			'popup_elementor_templates',
			[
				'label'       => esc_html__( 'Save Template', 'extension' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => false,
				'multiple'    => false,
				'options'     => wdb_addons_get_saved_template_list(),
				'condition'   => [
					'popup_content_type' => 'template',
					'wdb_enable_popup!'  => '',
				],
			]
		);

		$element->add_control(
			'popup_content',
			[
				'label'     => esc_html__( 'Content', 'extension' ),
				'default'   => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'extension' ),
				'type'      => Controls_Manager::WYSIWYG,
				'condition' => [
					'popup_content_type' => 'content',
					'wdb_enable_popup!'  => '',
				],
			]
		);

		$element->add_control(
			'popup_trigger_cursor',
			[
				'label'     => esc_html__( 'Cursor', 'extension' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'default',
				'options'   => [
					'default'  => esc_html__( 'Default', 'extension' ),
					'none'     => esc_html__( 'None', 'extension' ),
					'pointer'  => esc_html__( 'Pointer', 'extension' ),
					'grabbing' => esc_html__( 'Grabbing', 'extension' ),
					'move'     => esc_html__( 'Move', 'extension' ),
					'text'     => esc_html__( 'Text', 'extension' ),
				],
				'selectors' => [
					'{{WRAPPER}}' => 'cursor: {{VALUE}};',
				],
				'condition' => [ 'wdb_enable_popup!' => '' ],
			]
		);

		$element->add_control(
			'popup_animation',
			[
				'label'              => esc_html__( 'Animation', 'extension' ),
				'type'               => Controls_Manager::SELECT,
				'frontend_available' => true,
				'default'            => 'default',
				'options'            => [
					'default'             => esc_html__( 'Default', 'extension' ),
					'mfp-zoom-in'         => esc_html__( 'Zoom', 'extension' ),
					'mfp-zoom-out'        => esc_html__( 'Zoom-out', 'extension' ),
					'mfp-newspaper'       => esc_html__( 'Newspaper', 'extension' ),
					'mfp-move-horizontal' => esc_html__( 'Horizontal move', 'extension' ),
					'mfp-move-from-top'   => esc_html__( 'Move from top', 'extension' ),
					'mfp-3d-unfold'       => esc_html__( '3d unfold', 'extension' ),
				],
				'condition'          => [ 'wdb_enable_popup!' => '' ],
			]
		);

		$element->add_control(
			'popup_animation_delay',
			[
				'label'              => esc_html__( 'Removal Delay', 'extension' ),
				'type'               => Controls_Manager::NUMBER,
				'frontend_available' => true,
				'default'            => 500,
				'condition'          => [ 'wdb_enable_popup!' => '' ],
			]
		);

		$element->end_controls_section();
	}
}

WDB_Popup::init();
