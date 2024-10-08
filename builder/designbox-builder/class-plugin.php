<?php

namespace WDB_ADDONS;

use Elementor\Plugin as ElementorPlugin;

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 1.2.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return Plugin An instance of the class.
	 * @since 1.2.0
	 * @access public
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
		$scripts = [
			'wdb-addons-core' => [
				'handler' => 'wdb--addons',
				'src'     => 'wdb-addons.js',
				'dep'     => [ 'jquery' ],
				'version' => false,
				'arg'     => true,
			],
		];

		foreach ( $scripts as $key => $script ) {
			wp_register_script( $script['handler'], plugins_url( '/assets/js/' . $script['src'], __FILE__ ), $script['dep'], $script['version'], $script['arg'] );
		}

		$data = apply_filters( 'wdb-addons/js/data', [
			'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
			'_wpnonce'       => wp_create_nonce( 'wdb-addons-frontend' ),
			'post_id'        => get_the_ID(),
			'i18n'           => [
				'okay'    => esc_html__( 'Okay', 'designbox-builder' ),
				'cancel'  => esc_html__( 'Cancel', 'designbox-builder' ),
				'submit'  => esc_html__( 'Submit', 'designbox-builder' ),
				'success' => esc_html__( 'Success', 'designbox-builder' ),
				'warning' => esc_html__( 'Warning', 'designbox-builder' ),
			],
			'smoothScroller' => json_decode( get_option( 'wdb_smooth_scroller' ) )
		] );

		wp_localize_script( 'wdb--addons', 'WDB_ADDONS_JS', $data );

		wp_enqueue_script( 'wdb--addons' );

		//widget scripts
		foreach ( self::get_widget_scripts() as $key => $script ) {
			wp_register_script( $script['handler'], plugins_url( '/assets/js/' . $script['src'], __FILE__ ), $script['dep'], $script['version'], $script['arg'] );
		}
	}

	/**
	 * Function widget_styles
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public static function widget_styles() {
		$styles = [
			'wdb-addons-core' => [
				'handler' => 'wdb--addons',
				'src'     => 'wdb-addons.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
		];

		foreach ( $styles as $key => $style ) {
			wp_register_style( $style['handler'], plugins_url( '/assets/css/' . $style['src'], __FILE__ ), $style['dep'], $style['version'], $style['media'] );
		}

		wp_enqueue_style( 'wdb--addons' );

		//widget style
		foreach ( self::get_widget_style() as $key => $style ) {
			wp_register_style( $style['handler'], plugins_url( '/assets/css/' . $style['src'], __FILE__ ), $style['dep'], $style['version'], $style['media'] );
		}
	}

	/**
	 * Editor scripts
	 *
	 * Enqueue plugin javascripts integrations for Elementor editor.
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function editor_scripts() {
		wp_enqueue_script( 'wdb-editor', plugins_url( '/assets/js/editor.js', __FILE__ ), [
			'elementor-editor',
		], WDB_ADDONS_VERSION, true );

		$data = apply_filters( 'wdb-addons-editor/js/data', [
			'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
			'_wpnonce' => wp_create_nonce( 'wdb-addons-editor' ),
		] );

		wp_localize_script( 'wdb-editor', 'WDB_Addons_Editor', $data );
	}

	/**
	 * Editor style
	 *
	 * Enqueue plugin css integrations for Elementor editor.
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function editor_styles() {
		wp_enqueue_style( 'wdb--editor', plugins_url( '/assets/css/editor.css', __FILE__ ), [], WDB_ADDONS_VERSION, 'all' );
	}

	/**
	 * Function widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function get_widget_scripts() {
		return [
			'typed'            => [
				'handler' => 'typed',
				'src'     => 'typed.js',
				'dep'     => [],
				'version' => false,
				'arg'     => true,
			],
			'goodshare'        => [
				'handler' => 'goodshare',
				'src'     => 'goodshare.min.js',
				'dep'     => [],
				'version' => false,
				'arg'     => true,
			],
			'ProgressBar'      => [
				'handler' => 'progressbar',
				'src'     => 'progressbar.min.js',
				'dep'     => [],
				'version' => false,
				'arg'     => true,
			],
			'slider'           => [
				'handler' => 'wdb--slider',
				'src'     => 'widgets/slider.js',
				'dep'     => [],
				'version' => false,
				'arg'     => true,
			],
			'typewriter'       => [
				'handler' => 'wdb--typewriter',
				'src'     => 'widgets/typewriter.js',
				'dep'     => [ 'typed', 'jquery' ],
				'version' => false,
				'arg'     => true,
			],
			'text-hover-image' => [
				'handler' => 'wdb--text-hover-image',
				'src'     => 'widgets/text-hover-image.js',
				'dep'     => [ 'jquery' ],
				'version' => false,
				'arg'     => true,
			],
			'counter'          => [
				'handler' => 'wdb--counter',
				'src'     => 'widgets/counter.js',
				'dep'     => [ 'jquery-numerator' ],
				'version' => false,
				'arg'     => true,
			],
			'progressbar'      => [
				'handler' => 'wdb--progressbar',
				'src'     => 'widgets/progressbar.js',
				'dep'     => [ 'progressbar' ],
				'version' => false,
				'arg'     => true,
			],
			'before-after'     => [
				'handler' => 'beforeAfter',
				'src'     => 'beforeafter.jquery-1.0.0.min.js',
				'dep'     => [ 'jquery' ],
				'version' => false,
				'arg'     => true,
			],
			'image-compare'    => [
				'handler' => 'wdb--image-compare',
				'src'     => 'widgets/image-compare.js',
				'dep'     => [ 'beforeAfter' ],
				'version' => false,
				'arg'     => true,
			],
			'tabs'             => [
				'handler' => 'wdb--tabs',
				'src'     => 'widgets/tabs.js',
				'dep'     => [ 'jquery' ],
				'version' => false,
				'arg'     => true,
			],
			'nav-menu'         => [
				'handler' => 'wdb--nav-menu',
				'src'     => 'widgets/nav-menu.js',
				'dep'     => [ 'jquery' ],
				'version' => false,
				'arg'     => true,
			],
			'chroma'           => [
				'handler' => 'chroma',
				'src'     => 'chroma.min.js',
				'dep'     => [ 'jquery', 'gsap' ],
				'version' => false,
				'arg'     => true,
			],
			'animated-heading' => [
				'handler' => 'wdb--animated-heading',
				'src'     => 'widgets/animated-heading.js',
				'dep'     => [ 'jquery', 'gsap', 'chroma' ],
				'version' => false,
				'arg'     => true,
			],
		];
	}

	/**
	 * Function widget_style
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function get_widget_style() {
		return [
			'icon-box'         => [
				'handler' => 'wdb--icon-box',
				'src'     => 'widgets/icon-box.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'testimonial'      => [
				'handler' => 'wdb--testimonial',
				'src'     => 'widgets/testimonial.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'testimonial2'     => [
				'handler' => 'wdb--testimonial2',
				'src'     => 'widgets/testimonial2.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'testimonial3'     => [
				'handler' => 'wdb--testimonial3',
				'src'     => 'widgets/testimonial3.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'posts'            => [
				'handler' => 'wdb--posts',
				'src'     => 'widgets/posts.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'button'           => [
				'handler' => 'wdb--button',
				'src'     => 'widgets/button.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'progressbar'      => [
				'handler' => 'wdb--progressbar',
				'src'     => 'widgets/progressbar.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'counter'          => [
				'handler' => 'wdb--counter',
				'src'     => 'widgets/counter.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'image-compare'    => [
				'handler' => 'wdb--image-compare',
				'src'     => 'widgets/image-compare.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'brand-slider'     => [
				'handler' => 'wdb--brand-slider',
				'src'     => 'widgets/brand-slider.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'text-hover-image' => [
				'handler' => 'wdb--text-hover-image',
				'src'     => 'widgets/text-hover-image.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'one-page-nav'     => [
				'handler' => 'wdb--one-page-nav',
				'src'     => 'widgets/one-page-nav.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'social-icons'     => [
				'handler' => 'wdb--social-icons',
				'src'     => 'widgets/social-icons.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'image-gallery'    => [
				'handler' => 'wdb--image-gallery',
				'src'     => 'widgets/image-gallery.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'team'             => [
				'handler' => 'wdb--team',
				'src'     => 'widgets/team.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'image-box'        => [
				'handler' => 'wdb--image-box',
				'src'     => 'widgets/image-box.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'timeline'         => [
				'handler' => 'wdb--timeline',
				'src'     => 'widgets/timeline.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'event-slider'     => [
				'handler' => 'wdb--event-slider',
				'src'     => 'widgets/event-slider.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'services-tab'     => [
				'handler' => 'wdb--services-tab',
				'src'     => 'widgets/services-tab.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'countdown'        => [
				'handler' => 'wdb--countdown',
				'src'     => 'widgets/countdown.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
			'meta-info'        => [
				'handler' => 'wdb--meta-info',
				'src'     => 'widgets/meta-info.css',
				'dep'     => [],
				'version' => false,
				'media'   => 'all',
			],
		];
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		foreach ( self::get_widgets() as $slug => $data ) {

			// If upcoming don't register.
			if ( $data['is_upcoming'] ) {
				continue;
			}

			if ( ! $data['is_pro'] && ! $data['is_extension'] ) {
				if ( is_dir( __DIR__ . '/widgets/' . $slug ) ) {
					require_once( __DIR__ . '/widgets/' . $slug . '/' . $slug . '.php' );
				} else {
					require_once( __DIR__ . '/widgets/' . $slug . '.php' );
				}


				$class = explode( '-', $slug );
				$class = array_map( 'ucfirst', $class );
				$class = implode( '_', $class );
				$class = 'WDB_ADDONS\\Widgets\\' . $class;
				ElementorPlugin::instance()->widgets_manager->register( new $class() );
			}
		}
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor Extensions.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_extensions() {
		foreach ( self::get_extensions() as $slug => $data ) {

			// If upcoming don't register.
			if ( $data['is_upcoming'] ) {
				continue;
			}

			if ( ! $data['is_pro'] && ! $data['is_extension'] ) {

				include_once WDB_ADDONS_PATH . 'inc/class-wdb-' . $slug . '.php';
			}
		}
	}

	/**
	 * Get Widgets List.
	 *
	 * @return array
	 */
	public static function get_widgets() {

		$allwidgets = [];
		foreach ( $GLOBALS['wdb_addons_config']['widgets'] as $widget ) {
			$allwidgets = array_merge( $allwidgets, $widget['elements'] );
		}

		$saved_widgets = get_option( 'wdb_save_widgets' );

		$active_widgets = [];

		if ( empty( $saved_widgets ) ) {
			return $active_widgets;
		}

		foreach ( $saved_widgets as $key => $item ) {
			$active_widgets[ $key ] = $allwidgets[ $key ];
		}

		return $active_widgets;
	}

	/**
	 * Get Extension List.
	 *
	 * @return array
	 */
	public static function get_extensions() {

		$allextensions = [];
		foreach ( $GLOBALS['wdb_addons_config']['extensions'] as $extension ) {
			$allextensions = array_merge( $allextensions, $extension['elements'] );
		}

		$saved_extensions = get_option( 'wdb_save_extensions' );

		$active_extensions = [];

		if ( ! empty( $saved_extensions ) ) {
			foreach ( $saved_extensions as $key => $item ) {

				if ( ! array_key_exists( $key, $allextensions ) ) {
					continue;
				}

				$active_extensions[ $key ] = $allextensions[ $key ];
			}
		}

		return $active_extensions;
	}

	/**
	 * Widget Category
	 *
	 * @param $elements_manager
	 */
	public function widget_categories( $elements_manager ) {
		$categories = [];

		$categories['weal-coder-addon'] = [
			'title' => esc_html__( 'DesignBox', 'designbox-builder' ),
			'icon'  => 'fa fa-plug',
		];

		$categories['wdb-hf-addon'] = [
			'title' => esc_html__( 'DesignBox Header/Footer', 'designbox-builder' ),
			'icon'  => 'fa fa-plug',
		];

		$categories['wdb-archive-addon'] = [
			'title' => esc_html__( 'DesignBox Archive', 'designbox-builder' ),
			'icon'  => 'fa fa-plug',
		];

		$categories['wdb-search-addon'] = [
			'title' => esc_html__( 'DesignBox Search', 'designbox-builder' ),
			'icon'  => 'fa fa-plug',
		];

		$categories['wdb-single-addon'] = [
			'title' => esc_html__( 'DesignBox Single', 'designbox-builder' ),
			'icon'  => 'fa fa-plug',
		];

		$old_categories = $elements_manager->get_categories();
		$categories     = array_merge( $categories, $old_categories );

		$set_categories = function ( $categories ) {
			$this->categories = $categories;
		};

		$set_categories->call( $elements_manager, $categories );
	}

	/**
	 * Include Plugin files
	 *
	 * @access private
	 */
	private function include_files() {
		require_once WDB_ADDONS_PATH . 'config.php';

		if ( is_admin() ) {

			if ( 'redirect' === get_option( 'wdb_addons_setup_wizard' ) || 'init' === get_option( 'wdb_addons_setup_wizard' ) ) {
				require_once( WDB_ADDONS_PATH . 'inc/admin/setup-wizard.php' );
			}

			require_once( WDB_ADDONS_PATH . 'inc/admin/dashboard.php' );
		}

		require_once( WDB_ADDONS_PATH . 'inc/theme-builder/theme-builder.php' );

		require_once WDB_ADDONS_PATH . 'inc/helper.php';
		require_once WDB_ADDONS_PATH . 'inc/hook.php';
		require_once WDB_ADDONS_PATH . 'inc/ajax-handler.php';
		include_once WDB_ADDONS_PATH . 'inc/trait-wdb-post-query.php';
		include_once WDB_ADDONS_PATH . 'inc/trait-wdb-button.php';
		include_once WDB_ADDONS_PATH . 'inc/trait-wdb-slider.php';

		//extensions
		$this->register_extensions();
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'widget_categories' ] );

		// Register widget scripts
		add_action( 'wp_enqueue_scripts', [ $this, 'widget_scripts' ] );

		// Register widget style
		add_action( 'wp_enqueue_scripts', [ $this, 'widget_styles' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Register editor scripts
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );

		// Register editor style
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_styles' ] );

		$this->include_files();
	}
}

// Instantiate Plugin Class
Plugin::instance();
