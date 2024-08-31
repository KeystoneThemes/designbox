<?php

namespace WDB_ADDONS\Widgets;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Plugin;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

class Search_No_Result extends Widget_Base {

	public function get_name() {
		return 'wdb--blog--search--result-message';
	}

	public function get_title() {
		return esc_html__( 'Search No Result', 'designbox-builder' );
	}

	public function get_icon() {
		return 'wdb eicon-search';
	}

	public function get_categories() {
		return [ 'wdb-search-addon' ];
	}

	public function get_keywords() {
		return ['search query','message','no result'];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'important_note',
			[
				'label' => esc_html__( 'Important Note: ', 'designbox-builder' ),
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'Message will be show when no search content found', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'search_text',
			[
				'label'   => esc_html__( 'Search Title', 'designbox-builder' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Nothing found!',
				'ai'      => [
					'active' => false,
				],
				'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
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
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'search_content',
			[
				'label'   => esc_html__( 'Search content', 'designbox-builder' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => 'It looks like nothing was found here. Maybe try a search?',
				'ai'      => [
					'active' => false,
				],
				'dynamic' => [
					'active' => false,
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => esc_html__( 'Alignment', 'designbox-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'designbox-builder' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'designbox-builder' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'designbox-builder' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'designbox-builder' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => 'center',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			[
				'label' => __( 'Title', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .default-search-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .default-search-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name'     => 'text_stroke',
				'selector' => '{{WRAPPER}} .default-search-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'text_shadow',
				'selector' => '{{WRAPPER}} .default-search-title',
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'designbox-builder' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .default-search-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style',
			[
				'label' => __( 'Content', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_q_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb-no-result-para' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'q_typography',
				'selector' => '{{WRAPPER}} .wdb-no-result-para',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() || ( isset( $_GET['preview_id'] ) && isset( $_GET['preview_nonce'] ) ) ) {
			$search_found_title = $settings['search_text'];
		} else {
			$search_found_title = $settings['search_text'];

			if ( is_search() && have_posts() ) {
				return;
			}
		}
		$this->add_render_attribute( 'title', 'class', 'default-search-title' );

		$title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings['title_tag'] ), $this->get_render_attribute_string( 'title' ), $search_found_title );

		echo wp_kses_post( $title_html );
		?>
        <div class="wdb-no-result-para">
			<?php echo wp_kses_post( $this->parse_text_editor( $settings['search_content'] ) ); ?>
        </div>
		<?php
	}
}
