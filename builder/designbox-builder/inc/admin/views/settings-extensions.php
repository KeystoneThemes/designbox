<?php
/**
 * Admin View: Settings Extensions
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$extensions = apply_filters( 'wdb_extensions', $GLOBALS['wdb_addons_config']['extensions'] );
?>
<form action="POST" class="wdb-settings" name="wdb_save_extensions">
<div class="settings-wrap">
    <div class="section-header">
        <div class="info">
            <h3><?php echo esc_html__( 'Extension Settings', 'designbox-builder' ); ?></h3>
            <span>
                <?php
                $total = wdb_addons_get_all_extensions_count();
                /* translators: %s: total */
                printf( esc_html__( 'Total %s Extensions', 'designbox-builder' ), esc_html( $total ) );
                ?>
            </span>
        </div>
        <div class="header-right">
            <div class="switcher">
                <input type="checkbox" id="view-global-extensions" class="wdb-global-switch">
                <label for="view-global-extensions">
		            <?php esc_html_e( 'Disable All', 'designbox-builder' ); ?>
                    <span class="control-label-switch" data-active="ON" data-inactive="OFF"></span>
		            <?php esc_html_e( 'Enable All', 'designbox-builder' ); ?>
                </label>
            </div>
            <button type="button" class="wdb-admin-btn wdb-settings-save"><?php esc_html_e( 'Save Settings', 'designbox-builder' ); ?></button>
        </div>
    </div>

	<?php foreach ( $extensions as $groupkey => $group ) { ?>
        <div class="settings-group">
            <div class="title-area">
                <div>
                    <h4><?php echo esc_html( $group['title'] ); ?></h4>
	                <?php if ( 'gsap-extensions' === $groupkey ) { ?>
                        <i><?php echo esc_html__( 'N.B : Without Enabling Gsap Settings, the related Extensions will not work.', 'designbox-builder' ); ?></i>
	                <?php } ?>
                </div>

	            <?php if ( 'gsap-extensions' === $groupkey ) { ?>
                    <div class="header-right">
                        <div class="switcher">
	                        <?php $status = ! defined( 'WDB_ADDONS_EX_VERSION' ) ? 'disabled' : checked( 1, wdb_addons_get_settings( 'wdb_save_extensions', 'wdb-gsap' ), false ); ?>
                            <input type="checkbox" id="view-gsap" class="wdb-gsap-switch wdb-settings-item" name="wdb-gsap" <?php echo esc_attr( $status ); ?>>
                            <label for="view-gsap">
					            <?php esc_html_e( 'Gsap', 'designbox-builder' ); ?>
                                <span class="control-label-switch" data-active="ON" data-inactive="OFF"></span>
                            </label>
                        </div>
                        <div class="switcher smooth-scroll">
	                        <?php $status = ! defined( 'WDB_ADDONS_EX_VERSION' ) ? 'disabled' : checked( 1, wdb_addons_get_settings( 'wdb_save_extensions', 'wdb-smooth-scroller' ), false ); ?>
                            <input type="checkbox" id="view-smooth-scroller" class="wdb-smooth-scroller-switch wdb-settings-item" name="wdb-smooth-scroller" <?php echo esc_attr( $status ); ?>>
                            <label for="view-smooth-scroller">
			                    <?php esc_html_e( 'Smooth Scroller', 'designbox-builder' ); ?>
                                <span class="control-label-switch" data-active="ON" data-inactive="OFF"></span>
                            </label>
                            <div class="smooth-settings">
                                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 12.7 13"><path d="M11.53,7a1,1,0,0,1,0-1l.62-.7a1.6,1.6,0,0,0,.56-.94,1.74,1.74,0,0,0-.35-1h0L12,2.82c-.25-.44-.42-.73-.77-.88A1.71,1.71,0,0,0,10.11,2l-.71.2a.62.62,0,0,1-.45,0l-.19-.1a.66.66,0,0,1-.26-.32l-.21-.6A1.68,1.68,0,0,0,7.76.21,1.69,1.69,0,0,0,6.68,0H6A1.69,1.69,0,0,0,4.94.21a1.69,1.69,0,0,0-.54,1l-.19.58A.71.71,0,0,1,4,2.07l-.18.1a.69.69,0,0,1-.46.07L2.59,2a1.71,1.71,0,0,0-1.16-.09c-.35.14-.51.43-.77.88l-.3.51a1.72,1.72,0,0,0-.35,1,1.65,1.65,0,0,0,.56,1l.6.67a1,1,0,0,1,.15.51A1,1,0,0,1,1.19,7l-.62.69a1.65,1.65,0,0,0-.56,1,1.72,1.72,0,0,0,.35,1l.31.52c.25.44.41.73.76.87A1.71,1.71,0,0,0,2.59,11l.71-.2a.62.62,0,0,1,.45.05l.19.1a.66.66,0,0,1,.26.32l.2.6a1.69,1.69,0,0,0,.54.95A1.69,1.69,0,0,0,6,13h.66a1.69,1.69,0,0,0,1.08-.21,1.75,1.75,0,0,0,.54-.95l.19-.58a.67.67,0,0,1,.26-.33l.17-.1a.69.69,0,0,1,.46-.07l.73.21a1.71,1.71,0,0,0,1.16.09c.35-.14.52-.44.77-.88l.3-.51a1.68,1.68,0,0,0,.35-1,1.65,1.65,0,0,0-.56-1Zm-.06,2.15-.3.51a3.13,3.13,0,0,1-.27.45,2.47,2.47,0,0,1-.52-.12l-.76-.22A1.75,1.75,0,0,0,8.44,10l-.22.13a1.7,1.7,0,0,0-.67.84l-.2.61a3.77,3.77,0,0,1-.17.45,3,3,0,0,1-.5,0H5.53a3.13,3.13,0,0,1-.18-.47l-.2-.62a1.79,1.79,0,0,0-.69-.83l-.23-.13a1.72,1.72,0,0,0-.77-.19,2,2,0,0,0-.41.05L2.32,10a4.7,4.7,0,0,1-.5.13h0a2.19,2.19,0,0,1-.29-.46l-.3-.51C1.13,9,1,8.78,1,8.74a2.17,2.17,0,0,1,.32-.39L2,7.64A2,2,0,0,0,2.32,6.5a2,2,0,0,0-.38-1.16l-.62-.69A3.73,3.73,0,0,1,1,4.28a3.18,3.18,0,0,1,.23-.45l.3-.52a3.47,3.47,0,0,1,.27-.44A4,4,0,0,1,2.32,3l.76.22a1.77,1.77,0,0,0,1.17-.16l.22-.13a1.67,1.67,0,0,0,.68-.84l.2-.6A4.19,4.19,0,0,1,5.52,1,2.92,2.92,0,0,1,6,1H7.17a3.13,3.13,0,0,1,.18.47l.2.62a1.69,1.69,0,0,0,.69.83l.23.13a1.7,1.7,0,0,0,1.18.14L10.38,3a4.7,4.7,0,0,1,.5-.13h0a2.19,2.19,0,0,1,.29.46l.3.51c.1.18.22.39.23.43a2.75,2.75,0,0,1-.32.39l-.64.72a1.93,1.93,0,0,0-.36,1.13,2,2,0,0,0,.38,1.16l.63.69c.13.16.29.33.31.37A2.35,2.35,0,0,1,11.47,9.17Z" style="fill:#203263"/><path d="M6.32,3.9A2.6,2.6,0,1,0,8.93,6.5,2.6,2.6,0,0,0,6.32,3.9Zm0,4.2A1.6,1.6,0,1,1,7.93,6.5,1.6,1.6,0,0,1,6.32,8.1Z" /></svg>
                            </div>
                        </div>
                    </div>
	            <?php } ?>
            </div>
            <div class="settings-wrapper">
				<?php foreach ( $group['elements'] as $key => $extension ) { ?>
                    <div class="item">
                        <div class="title"><?php echo esc_html( $extension['label'] ); ?></div>
                        <div class="actions">
                            <div class="switcher">
								<?php $status = wdb_addons_element_status('wdb_save_extensions', $key, $extension) ?>
                                <input type="checkbox" class="wdb-settings-item" id="<?php echo esc_attr( $key ); ?>"
                                       name="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $status ); ?>>
                                <label for="<?php echo esc_attr( $key ); ?>">
                                    <span class="control-label-switch" data-active="ON" data-inactive="OFF"></span>
                                </label>
                            </div>
                        </div>
						<?php if ( $extension['is_pro'] ) { ?>
                            <div class="ribbon"><?php echo esc_html__( 'Pro', 'designbox-builder' ); ?></div>
						<?php } ?>
                    </div>
				<?php } ?>
            </div>
        </div>
	<?php } ?>

</div>
</form>


