<?php

namespace WDB_ADDONS\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
} // Exit if accessed directly

class WDB_Admin_Init {

	/**
	 * Parent Menu Page Slug
	 */
	const MENU_PAGE_SLUG = 'wdb_addons_page';

	/**
	 * Menu capability
	 */
	const MENU_CAPABILITY = 'manage_options';

	/**
	 * [$parent_menu_hook] Parent Menu Hook
	 * @var string
	 */
	static $parent_menu_hook = '';

	/**
	 * [$_instance]
	 * @var null
	 */
	private static $_instance = null;

	/**
	 * [instance] Initializes a singleton instance
	 * @return [Woolentor_Admin_Init]
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		$this->remove_all_notices();
		$this->include();
		$this->init();
	}

	/**
	 * [init] Assets Initializes
	 * @return [void]
	 */
	public function init() {
		add_action( 'admin_menu', [ $this, 'add_menu' ], 25 );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'wp_ajax_save_settings_with_ajax', [ $this, 'save_settings' ] );
		add_action( 'wp_ajax_save_smooth_scroller_settings', [ $this, 'save_smooth_scroller_settings' ] );
	}

	/**
	 * [include] Load Necessary file
	 * @return [void]
	 */
	public function include() {
		require_once( 'template-functions.php' );
		require_once( 'plugin-installer.php' );
	}

	/**
	 * [add_menu] Admin Menu
	 */
	public function add_menu() {

		self::$parent_menu_hook = add_menu_page(
			esc_html__( 'DesignBox', 'designbox-builder' ),
			esc_html__( 'DesignBox', 'designbox-builder' ),
			self::MENU_CAPABILITY,
			self::MENU_PAGE_SLUG,
			'',
			WDB_ADDONS_URL . '/assets/images/wdb.svg',
			100
		);

		add_submenu_page(
			self::MENU_PAGE_SLUG,
			esc_html__( 'Dashboard', 'designbox-builder' ),
			esc_html__( 'Dashboard', 'designbox-builder' ),
			'manage_options',
			'wdb_addons_settings',
			[ $this, 'plugin_page' ]
		);

		// Remove Parent Submenu
		remove_submenu_page( self::MENU_PAGE_SLUG, self::MENU_PAGE_SLUG );

	}

	/**
	 * [enqueue_scripts] Add Scripts Base Menu Slug
	 *
	 * @param  [string] $hook
	 *
	 * @return [void]
	 */
	public function enqueue_scripts( $hook ) {
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'wdb_addons_settings' ) {

			// CSS
			wp_enqueue_style( 'sweetalert2', WDB_ADDONS_URL . '/assets/css/sweetalert2.min.css' );
			wp_enqueue_style( 'wdb-admin', WDB_ADDONS_URL . '/assets/css/wdb-admin.css' );

			// JS
			wp_enqueue_script( 'jquery-ui-accordion' );

			wp_enqueue_script( 'sweetalert2', WDB_ADDONS_URL . '/assets/js/sweetalert2.all.min.js', array( 'jquery' ), WDB_ADDONS_VERSION, true );

			wp_enqueue_script( 'wdb-admin', WDB_ADDONS_URL . '/assets/js/wdb-admin.js', array( 'jquery' ), WDB_ADDONS_VERSION, true );

			$localize_data = [
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'wdb_admin_nonce' ),
				'adminURL' => admin_url(),
				'smoothScroller' => json_decode( get_option( 'wdb_smooth_scroller' ) )
			];
			wp_localize_script( 'wdb-admin', 'WDB_ADDONS_ADMIN', $localize_data );

		}
	}

	/**
	 * get Settings tabs to admin panel.
	 *
	 * @param array $tabs Array of tabs.
	 *
	 * @return bool|true|void
	 */
	protected function get_settings_tab() {
		$settings_tab = [
			'home'         => [
				'title'    => esc_html__( 'Statistics', 'designbox-builder' ),
				'callback' => 'wdb_admin_settings_home_tab',
			],
			'widgets'      => [
				'title'    => esc_html__( 'Widgets', 'designbox-builder' ),
				'callback' => 'wdb_admin_settings_widget_tab',
			],
			'extensions'   => [
				'title'    => esc_html__( 'Extensions', 'designbox-builder' ),
				'callback' => 'wdb_admin_settings_extension_tab',
			],
		];

		return apply_filters( 'wdb_settings_tabs', $settings_tab );
	}

	/**
	 * [plugin_page] Load plugin page template
	 * @return [void]
	 */
	public function plugin_page() {
		?>
        <div class="wrap wdb-admin-wrapper">

			<?php
			$tabs = $this->get_settings_tab();

			if ( ! empty( $tabs ) ) {
				?>
                <div class="wdb-admin-tab">
					<?php
					foreach ( $tabs as $key => $el ) {
						?>
                        <button class="tablinks <?php echo esc_attr( $key ); ?>-tab"
                                data-target="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $el['title'] ); ?></button>
						<?php
					}
					?>
                </div>

                <div class="wdb-admin-tab-content">
					<?php
					foreach ( $tabs as $key => $el ) {
						?>
                        <div id="<?php echo esc_attr( $key ); ?>" class="wdb-tab-pane">
							<?php
							if ( isset( $el['callback'] ) ) {
								call_user_func( $el['callback'], $key, $el );
							}
							?>
                        </div>
						<?php
					}
					?>
                </div>
				<?php
			}
			?>
            <div class="wdb-settings-footer">
               

                <div class="footer-right">
                </div>
            </div>
        </div>
		<?php
	}

	/**
	 * [remove_all_notices] remove addmin notices
	 * @return [void]
	 */
	public function remove_all_notices() {
		add_action( 'in_admin_header', function () {
			if ( isset( $_GET['page'] ) && $_GET['page'] == 'wdb_addons_settings' ) {
				remove_all_actions( 'admin_notices' );
				remove_all_actions( 'all_admin_notices' );
			}
		}, 1000 );
	}

	/**
	 * Save Settings
	 * Save EA settings data through ajax request
	 *
	 * @access public
	 * @return  void
	 * @since 1.1.2
	 */
	public function save_settings() {

		check_ajax_referer( 'wdb_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'you are not allowed to do this action', 'designbox-builder' ) );
		}

		if ( ! isset( $_POST['fields'] ) ) {
			return;
		}

		$option_name = isset( $_POST['settings'] ) ? sanitize_text_field( $_POST['settings'] ) : '';

		wp_parse_str( $_POST['fields'], $settings );

		$settings = array_map( 'sanitize_text_field', $settings );

		$settings = array_fill_keys( array_keys( $settings ), true );

		// update new settings
		if ( ! empty( $option_name ) ) {
			$updated = update_option( $option_name, $settings );
			wp_send_json( $updated );
		}
		wp_send_json( __( 'Option name not found!', 'designbox-builder' ) );
	}

	/**
	 * Save smooth scroller Settings
	 * settings data through ajax request
	 *
	 * @access public
	 * @return  void
	 * @since 1.1.2
	 */
	public function save_smooth_scroller_settings() {

		check_ajax_referer( 'wdb_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'you are not allowed to do this action', 'designbox-builder' ) );
		}

		if ( ! isset( $_POST['smooth'] ) ) {
			return;
		}

		$settings = [
			'smooth' => $_POST['smooth'],
		];

		if ( isset( $_POST['mobile'] ) ) {
			$settings['mobile'] = $_POST['mobile'];
		}

		$option = sanitize_text_field( wp_json_encode( $settings ) );

		// update new settings
		if ( ! empty( $_POST['smooth'] ) ) {
			update_option( 'wdb_smooth_scroller', $option );
			wp_send_json( $option );
		}

		wp_send_json( __( 'Option name not found!', 'designbox-builder' ) );
	}

}

WDB_Admin_Init::instance();

