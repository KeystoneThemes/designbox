<?php
/**
 * Admin View: Settings Widgets
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$widgets = apply_filters( 'wdb_widgets', $GLOBALS['wdb_addons_config']['widgets'] );
?>
<form action="POST" class="wdb-settings" name="wdb_save_widgets">
    <div class="settings-wrap">
        <div class="section-header">
            <div class="info">
                <h3><?php echo esc_html__( 'Widgets Settings', 'designbox-builder' ); ?></h3>
                <span>
                <?php
                $total = wdb_addons_get_all_widgets_count();
                /* translators: %s: total */
                printf( esc_html__( 'Total %s Widgets', 'designbox-builder' ), esc_html( $total ) );
                ?>
                </span>
            </div>
            <div class="header-right">
                <div class="switcher">
                    <input type="checkbox" id="view-global-widget" class="wdb-global-switch">
                    <label for="view-global-widget">
	                    <?php esc_html_e( 'Disable All', 'designbox-builder' ); ?>
                        <span class="control-label-switch" data-active="ON" data-inactive="OFF"></span>
	                    <?php esc_html_e( 'Enable All', 'designbox-builder' ); ?>
                    </label>
                </div>
                <button type="button" class="wdb-admin-btn wdb-settings-save"><?php esc_html_e( 'Save Settings', 'designbox-builder' ); ?></button>
            </div>
        </div>

		<?php foreach ( $widgets as $group ) { ?>
            <div class="settings-group">
                <div class="title-area">
                    <h4><?php echo esc_html( $group['title'] ); ?></h4>
                </div>
                <div class="settings-wrapper">
					<?php foreach ($group['elements'] as $key => $widget ) { ?>
                        <div class="item">
                            <div class="title"><?php echo esc_html( $widget['label'] ); ?></div>
                            <div class="actions">
                                <div class="switcher">
	                                <?php $status = wdb_addons_element_status('wdb_save_widgets', $key, $widget) ?>
                                    <input type="checkbox" class="wdb-settings-item" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $status ); ?>>
                                    <label for="<?php echo esc_attr( $key ); ?>">
                                        <span class="control-label-switch" data-active="ON" data-inactive="OFF"></span>
                                    </label>
                                </div>
                            </div>
							<?php if ( $widget['is_pro'] ) { ?>
                                <div class="ribbon"><?php echo esc_html__( 'Pro', 'designbox-builder' ); ?></div>
							<?php } ?>
                        </div>
					<?php } ?>
                </div>
            </div>
		<?php } ?>

    </div>
</form>
