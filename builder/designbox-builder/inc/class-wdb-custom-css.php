<?php

namespace WDB_ADDONS;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Core\DynamicTags\Dynamic_CSS;
use Elementor\Core\Files\CSS\Post;
use Elementor\Element_Base;

defined( 'ABSPATH' ) || die();

class WDB_Custom_CSS {

	public static function init() {
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'register_controls' ], 10, 2 );
		add_action( 'elementor/element/parse_css', [ __CLASS__, 'add_post_css' ], 10, 2 );
	}

	/**
	 * @param $element    Controls_Stack
	 * @param $section_id string
	 */
	public static function register_controls( Controls_Stack $element, $section_id ) {

		if ( 'section_custom_css_pro' !== $section_id ) {
			return;
		}

		$element->start_controls_section(
			'wdb_section_custom_css',
			[
				'label' =>  sprintf('%s <i class="wdb-logo"></i>', esc_html__('Custom CSS', 'designbox-builder')),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'wdb_custom_css',
			[
				'label' => esc_html__( 'Add your own custom CSS', 'designbox-builder' ),
				'type' => Controls_Manager::CODE,
				'description' => sprintf(
				/* translators: 1: Link opening tag, 2: Link opening tag, 3: Link closing tag. */
					esc_html__( 'Use %1$scustom CSS%3$s to style your content or add %2$sthe "selector" prefix%3$s to target specific elements.', 'designbox-builder' ),
					'<a href="https://go.elementor.com/learn-more-panel-custom-css/" target="_blank">',
					'<a href="https://go.elementor.com/learn-more-panel-custom-css-selectors/" target="_blank">',
					'</a>'
				),
				'language' => 'css',
				'render_type' => 'ui',
			]
		);

		$element->end_controls_section();
	}

	/**
	 * @param $post_css Post
	 * @param $element  Element_Base
	 */
	public static function add_post_css( $post_css, $element ) {
		if ( $post_css instanceof Dynamic_CSS ) {
			return;
		}

		$element_settings = $element->get_settings();

		if ( empty( $element_settings['wdb_custom_css'] ) ) {
			return;
		}

		$css = trim( $element_settings['wdb_custom_css'] );

		if ( empty( $css ) ) {
			return;
		}
		$css = str_replace( 'selector', $post_css->get_element_unique_selector( $element ), $css );

		// Add a css comment
		$css = sprintf( '/* Start custom CSS for %s, class: %s */', $element->get_name(), $element->get_unique_selector() ) . $css . '/* End custom CSS */';

		$post_css->get_stylesheet()->add_raw_css( $css );
	}
}

WDB_Custom_CSS::init();
