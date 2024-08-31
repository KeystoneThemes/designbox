<?php

namespace WDB_ADDONS;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

trait WDB_Button_Trait {
	protected function register_button_content_controls( $default_value = [], $conditions = [] ) {
		$default = [
			'btn_text' => esc_html__( 'Click here', 'designbox-builder' )
		];

		$default = array_merge(  $default, $default_value );

		$default_conditions = [
			'btn_link' => true
		];

		$default_conditions = array_merge( $default_conditions, $conditions );

		$this->add_control(
			'btn_element_list',
			[
				'label'   => esc_html__( 'Style', 'designbox-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'   => esc_html__( 'Default', 'designbox-builder' ),
					'square'    => esc_html__( 'Square', 'designbox-builder' ),
					'underline' => esc_html__( 'Underline', 'designbox-builder' ),
					'mask'      => esc_html__( 'Mask', 'designbox-builder' ),
					'oval'      => esc_html__( 'Oval', 'designbox-builder' ),
					'circle'    => esc_html__( 'Circle', 'designbox-builder' ),
					'ellipse'   => esc_html__( 'Ellipse', 'designbox-builder' ),
				],
			]
		);

		$this->add_control(
			'btn_hover_list',
			[
				'label'     => esc_html__( 'Hover Style', 'designbox-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'hover-none',
				'options'   => [
					'hover-none'                => esc_html__( 'None', 'designbox-builder' ),
					'hover-divide'    => esc_html__( 'Divided', 'designbox-builder' ),
					'hover-cross'     => esc_html__( 'Cross', 'designbox-builder' ),
					'hover-cropping'  => esc_html__( 'Cropping', 'designbox-builder' ),
					'rollover-top'    => esc_html__( 'Rollover Top', 'designbox-builder' ),
					'rollover-left'   => esc_html__( 'Rollover Left', 'designbox-builder' ),
					'parallal-border' => esc_html__( 'Parallel Border', 'designbox-builder' ),
					'rollover-cross'  => esc_html__( 'Rollover Cross', 'designbox-builder' ),
				],
				'condition' => [
					'btn_element_list' => [ 'default', 'primary', 'square' ],
				],
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label'       => esc_html__( 'Text', 'designbox-builder' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => $default['btn_text'],
				'placeholder' => $default['btn_text'],
			]
		);

		if ( $default_conditions['btn_link'] ) {
			$this->add_control(
				'btn_link',
				[
					'label'   => esc_html__( 'Link', 'designbox-builder' ),
					'type'    => Controls_Manager::URL,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url' => '#',
					],
				]
			);
		}

		$this->add_control(
			'button_icon',
			[
				'label'            => esc_html__( 'Icon', 'designbox-builder' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
			]
		);

		$this->add_control(
			'button_icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'designbox-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Before', 'designbox-builder' ),
					'right' => esc_html__( 'After', 'designbox-builder' ),
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_direction',
			[
				'label'     => esc_html__( 'Direction', 'designbox-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'row'    => [
						'title' => esc_html__( 'Row - horizontal', 'designbox-builder' ),
						'icon'  => 'eicon-arrow-right',
					],
					'column' => [
						'title' => esc_html__( 'Column - vertical', 'designbox-builder' ),
						'icon'  => 'eicon-arrow-down',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .wdb__btn a' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_icon_indend',
			[
				'label'     => esc_html__( 'Icon Spacing', 'designbox-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb__btn a' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
	}

	protected function register_button_style_controls() {
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .wdb__btn a',
			]
		);

		$this->add_responsive_control(
			'button_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wdb__btn a i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wdb__btn a svg' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wdb__btn a'               => 'fill: {{VALUE}}; color: {{VALUE}};',
					'{{WRAPPER}} .wdb__btn a.wdb-btn-underline:after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .wdb__btn a.wdb-btn-mask:after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'btn_background',
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '{{WRAPPER}} .wdb__btn a:not(.wdb-btn-mask, .wdb-btn-ellipse), {{WRAPPER}} .wdb__btn a.wdb-btn-mask:after, {{WRAPPER}} .wdb__btn a.wdb-btn-ellipse:before',
				'condition' => [ 'btn_element_list!' => 'underline' ],
			]
		);

		$this->add_control(
			'ellipse_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb__btn a.wdb-btn-ellipse' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'btn_element_list' => 'ellipse' ],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'button_text_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb__btn a:hover, {{WRAPPER}} .wdb__btn a:focus' => 'color: {{VALUE}};fill: {{VALUE}};',
					'{{WRAPPER}} .wdb__btn a.wdb-btn-underline:hover:after'                  => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'btn_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '{{WRAPPER}} .wdb__btn a:not(.wdb-btn-mask, .btn-item, .btn-parallal-border, .btn-rollover-cross, .wdb-btn-ellipse):after, {{WRAPPER}} .wdb__btn a.wdb-btn-mask, {{WRAPPER}} .wdb__btn .btn-hover-bgchange span, {{WRAPPER}} .wdb__btn .btn-rollover-cross:hover, {{WRAPPER}} .wdb__btn .btn-parallal-border:hover, {{WRAPPER}} .wdb__btn a.wdb-btn-ellipse:hover:before,{{WRAPPER}} .wdb__btn a.btn-hover-none:hover',
				'condition' => [ 'btn_element_list!' => 'underline' ],
			]
		);

		$this->add_control(
			'ellipse_border_hover_color',
			[
				'label'     => esc_html__( 'Border Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb__btn a.wdb-btn-ellipse:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'btn_element_list' => 'ellipse' ],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'designbox-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdb__btn a:hover, {{WRAPPER}} .wdb__btn a:focus, {{WRAPPER}} .wdb__btn a:hover.btn-parallal-border:before, {{WRAPPER}} .wdb__btn a:hover.btn-parallal-border:after, {{WRAPPER}} .wdb__btn a:hover.btn-rollover-cross:before, {{WRAPPER}} .wdb__btn a:hover.btn-rollover-cross:after, {{WRAPPER}} .wdb__btn a.btn-hover-none:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'btn_border_border!' => '',
					'btn_element_list!'      => [ 'underline', 'ellipse' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'btn_border',
				'selector'  => '{{WRAPPER}} .wdb__btn a, {{WRAPPER}} .wdb__btn a.btn-parallal-border:before, {{WRAPPER}} .wdb__btn a.btn-parallal-border:after, {{WRAPPER}} .wdb__btn a.btn-rollover-cross:before, {{WRAPPER}} .wdb__btn a.btn-rollover-cross:after',
				'separator' => 'before',
				'condition' => [ 'btn_element_list!' => [ 'underline', 'ellipse' ] ],
			]
		);

		$this->add_responsive_control(
			'btn_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .wdb__btn a:not(.wdb-btn-ellipse, .wdb-btn-circle, .wdb-btn-oval)'               => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wdb__btn a.btn-parallal-border:before, {{WRAPPER}} .wdb__btn a.btn-parallal-border:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wdb__btn a.btn-rollover-cross:before, {{WRAPPER}} .wdb__btn a.btn-rollover-cross:after'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'btn_element_list!' => [ 'underline', 'circle', 'ellipse', 'oval' ],
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'designbox-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors'  => [
					'{{WRAPPER}} .wdb__btn a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wdb__btn a.wdb-btn-mask:after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'button_shadow',
				'selector'  => '{{WRAPPER}} .wdb__btn a.btn-hover-none',
				'condition' => [
					'btn_hover_list' => 'hover-none'
				],
			]
		);

		$this->add_responsive_control(
			'button_size',
			[
				'label'      => esc_html__( 'Button Size', 'designbox-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 20,
						'max'  => 500,
						'step' => 5,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wdb__btn a' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'btn_element_list' => [ 'circle', 'square' ],
				],
			]
		);
	}

	protected function render_button( $settings = [], $setting = null, $repeater_name = null, $index = null ) {
		if ( ! empty( $settings ) ) {
			$settings = $this->get_settings_for_display();
		}

		$link_key = 'link_';

		if ( $repeater_name ) {
			$repeater = $this->get_settings_for_display( $repeater_name );
			$link     = $repeater[ $index ][ $setting ];

			$link_key = 'link_' . $index;
			if ( ! empty( $link['url'] ) ) {
				$this->add_link_attributes( $link_key, $link );
			}
		} else {
			if ( ! empty( $settings['btn_link']['url'] ) ) {
				$this->add_link_attributes( $link_key, $settings['btn_link'] );
			} else {
				$this->add_render_attribute( $link_key, 'role', 'button' );
			}
		}

		$this->add_render_attribute( 'button_wrapper', 'class', 'wdb__btn' );
		$this->add_render_attribute( $link_key, 'class', 'wdb-btn-' . $settings['btn_element_list'] );

		if ( 'right' === $settings['button_icon_align'] ) {
			$this->add_render_attribute( 'button_wrapper', 'class', 'icon-position-after' );
		}

		if ( ! empty( $settings['btn_hover_list'] ) ) {
			$this->add_render_attribute( $link_key, 'class', 'btn-' . $settings['btn_hover_list'] );
		}

		if ( 'mask' === $settings['btn_element_list'] ) {
			$this->add_render_attribute( $link_key, 'data-text', $settings['btn_text'] );
		}

		$ext_wrap = in_array( $settings['btn_element_list'], [ 'oval', 'circle', 'ellipse' ] );

		if ( $ext_wrap ) {
			$this->add_render_attribute( $link_key, 'class', 'btn-item' );

			if ( 'ellipse' !== $settings['btn_element_list'] ) {
				$this->add_render_attribute( $link_key, 'class', 'btn-hover-bgchange' );
			}
		}

		$migrated = isset( $settings['__fa4_migrated']['button_icon'] );
		$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
		?>
        <div <?php $this->print_render_attribute_string( 'button_wrapper' ); ?>>
			<?php if ( $ext_wrap ) : ?>
            <div class="btn-wrapper">
				<?php endif; ?>
                <a <?php $this->print_render_attribute_string( $link_key ); ?>>
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] );
					else : ?>
                        <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>
					<?php $this->print_unescaped_setting( 'btn_text' ); ?>
                </a>
				<?php if ( $ext_wrap ) : ?>
            </div>
		<?php endif; ?>
        </div>
		<?php
	}
}
