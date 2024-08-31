<?php

namespace WDB_ADDONS\Widgets;

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Image Gallery
 *
 * Elementor widget for image gallery.
 *
 * @since 1.0.0
 */
class Image_Gallery extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_name() {
		return 'wdb--image-gallery';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_title() {
		return esc_html__( ' Image Gallery', 'designbox-builder' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_icon() {
		return 'wdb eicon-gallery-grid';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_categories() {
		return [ 'weal-coder-addon' ];
	}

	public function get_style_depends() {
		return [ 'wdb--image-gallery' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'layout_style',
			[
				'label'   => esc_html__( 'Layout', 'designbox-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style One', 'designbox-builder' ),
					'2' => esc_html__( 'Style Two', 'designbox-builder' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Image Gallery', 'designbox-builder' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'designbox-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'designbox-builder' ),
				'type'        => Controls_Manager::URL,
				'default'     => [
					'is_external' => 'true',
				],
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'designbox-builder' ),
			]
		);

		$this->add_control(
			'wdb_image_gallery',
			[
				'label'   => esc_html__( 'Image Gallery', 'designbox-builder' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [
					[],
					[],
					[],
					[],
					[],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'large',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'show_icon',
			[
				'label'        => esc_html__( 'Show Icon', 'designbox-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'designbox-builder' ),
				'label_off'    => esc_html__( 'Hide', 'designbox-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label'            => esc_html__( 'Hover Icon', 'designbox-builder' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'fab fa-instagram',
					'library' => 'fa-brand',
				],
				'condition'        => [
					'show_icon' => 'yes',
				],
			]
		);

		$this->add_control(
			'parallax',
			[
				'label'        => esc_html__( 'Scroll Smooth', 'designbox-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'designbox-builder' ),
				'label_off'    => esc_html__( 'No', 'designbox-builder' ),
				'separator'    => 'before',
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'g-data-speed',
			[
				'label'     => esc_html__( 'Data Speed', 'designbox-builder' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0.9,
				'condition' => [ 'parallax' => 'yes' ],
			]
		);

		$this->add_control(
			'g-data-lag',
			[
				'label'     => esc_html__( 'Data Lag', 'designbox-builder' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0.5,
				'condition' => [ 'parallax' => 'yes' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image Gallery', 'designbox-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'     => esc_html__( 'Columns', 'designbox-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '5',
				'options'   => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--image-gallery' => 'display:grid; grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'     => esc_html__( 'Columns Gap', 'designbox-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
					'size' => 30,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--image-gallery' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'     => esc_html__( 'Rows Gap', 'designbox-builder' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
					'size' => 30,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdb--image-gallery' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		//hover effect
		$this->add_control(
			'el_hover_effects',
			[
				'label'        => esc_html__( 'Hover Effect', 'designbox-builder' ),
				'description'  => esc_html__( 'This effect will work only image tag.', 'designbox-builder' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'effect-zoom-in',
				'options'      => [
					''                => esc_html__( 'None', 'designbox-builder' ),
					'effect-zoom-in'  => esc_html__( 'Zoom In', 'designbox-builder' ),
					'effect-zoom-out' => esc_html__( 'Zoom Out', 'designbox-builder' ),
					'left-move'       => esc_html__( 'Left Move', 'designbox-builder' ),
					'right-move'      => esc_html__( 'Right Move', 'designbox-builder' ),
				],
				'prefix_class' => 'wdb--image-',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get attachment image HTML.
	 *
	 * Retrieve the attachment image HTML code.
	 *
	 * Note that some widgets use the same key for the media control that allows
	 * the image selection and for the image size control that allows the user
	 * to select the image size, in this case the third parameter should be null
	 * or the same as the second parameter. But when the widget uses different
	 * keys for the media control and the image size control, when calling this
	 * method you should pass the keys.
	 *
	 * @param array $settings Control settings.
	 * @param string $image_size_key Optional. Settings key for image size.
	 *                               Default is `image`.
	 * @param string $image_key Optional. Settings key for image. Default
	 *                               is null. If not defined uses image size key
	 *                               as the image key.
	 *
	 * @return string Image HTML.
	 * @since 1.0.0
	 * @access public
	 * @static
	 */
	private function get_gallery_attachment_image_html( $settings, $item, $image_size_key = 'image', $image_key = null, $attr_key = '' ) {
		if ( ! $image_key ) {
			$image_key = $image_size_key;
		}

		$image = $item[ $image_key ];

		$has_image_attr = ! empty( $this->get_render_attributes( $attr_key ) );


		// Old version of image settings.
		if ( ! isset( $settings[ $image_size_key . '_size' ] ) ) {
			$settings[ $image_size_key . '_size' ] = '';
		}

		$size = $settings[ $image_size_key . '_size' ];

		$image_class = ! empty( $settings['hover_animation'] ) ? 'elementor-animation-' . $settings['hover_animation'] : '';

		$html = '';

		// If is the new version - with image size.
		$image_sizes = get_intermediate_image_sizes(); //phpcs:ignore

		$image_sizes[] = 'full';

		if ( ! empty( $image['id'] ) && ! wp_attachment_is_image( $image['id'] ) ) {
			$image['id'] = '';
		}

		$is_static_render_mode = Plugin::$instance->frontend->is_static_render_mode();

		// On static mode don't use WP responsive images.
		if ( ! empty( $image['id'] ) && in_array( $size, $image_sizes ) && ! $is_static_render_mode ) {
			$image_class .= " attachment-$size size-$size wp-image-{$image['id']} ";


			if ( ! empty( $attr_key ) && $has_image_attr && array_key_exists( 'class', $this->get_render_attributes( $attr_key ) ) ) {
				$image_class .= implode( ' ', $this->get_render_attributes( $attr_key )['class'] );
			}

			$image_attr = [
				'class' => trim( $image_class ),
			];

			if ( ! empty( $attr_key ) && $has_image_attr ) {
				foreach ( $this->get_render_attributes( $attr_key ) as $key => $value ) {
					if ( 'class' == $key ) {
						continue;
					}

					$image_attr[ $key ] = implode( ' ', $value );
				}
			}

			$html .= wp_get_attachment_image( $image['id'], $size, false, $image_attr );
		} else {
			$image_src = Group_Control_Image_Size::get_attachment_image_src( $image['id'], $image_size_key, $settings );

			if ( ! $image_src && isset( $image['url'] ) ) {
				$image_src = $image['url'];
			}

			if ( ! empty( $image_src ) ) {
				if ( ! empty( $image_class ) ) {
					$this->add_render_attribute( $attr_key, 'class', $image_class );
				}

				$html .= sprintf( '<img src="%1$s" title="%2$s" alt="%3$s"%4$s loading="lazy" />', esc_attr( $image_src ), Control_Media::get_image_title( $image ), Control_Media::get_image_alt( $image ), $this->get_render_attribute_string( $attr_key ) );
			}
		}

		/**
		 * Get Attachment Image HTML
		 *
		 * Filters the Attachment Image HTML
		 *
		 * @param string $html the attachment image HTML string
		 * @param array $settings Control settings.
		 * @param string $image_size_key Optional. Settings key for image size.
		 *                               Default is `image`.
		 * @param string $image_key Optional. Settings key for image. Default
		 *                               is null. If not defined uses image size key
		 *                               as the image key.
		 *
		 * @since 2.4.0
		 */
		return apply_filters( 'wdb/image_size/get_gallery_attachment_image_html', $html, $settings, $image_size_key, $image_key, $attr_key );
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['wdb_image_gallery'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'wdb--image-gallery style-' . $settings['layout_style'] );

		$this->add_render_attribute( 'item', 'class', 'wdb--gallery-item' );

		if ( 'yes' === $settings['parallax'] ) {
			$this->add_render_attribute(
				'image',
				[
					'data-speed' => $settings['g-data-speed'],
					'data-lag'   => $settings['g-data-lag'],
				]
			);
		}

		//icon
		if ( empty( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fa fa-instagram';
		}

		if ( ! empty( $settings['icon'] ) ) {
			$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
		}

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php
			foreach ( $settings['wdb_image_gallery'] as $index => $item ) {
				$link_key = 'link_' . $index;
				$this->add_link_attributes( $link_key, $item['link'] );
				?>
				<div <?php $this->print_render_attribute_string( 'item' ); ?> >
					<a <?php $this->print_render_attribute_string( $link_key ); ?>>
						<?php Utils::print_wp_kses_extended( $this::get_gallery_attachment_image_html( $settings, $item, $image_size_key = 'image', $image_key = null, 'image' ), [ 'image' ] ); ?>

						<?php if ( $settings['show_icon'] ) : ?>
							<div class="icon">
								<?php if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
								else : ?>
									<i <?php $this->print_render_attribute_string( 'icon' ); ?>></i>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</a>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
}
