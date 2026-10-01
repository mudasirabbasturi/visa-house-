<?php
/**
 * Add an Icon field to every WordPress menu item.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ============================================================
   RENDER — add Icon field to the menu item edit panel
   ============================================================ */
function vs_menu_item_icon_field( $item_id, $item, $depth, $args ) {
    $icon = get_post_meta( $item_id, '_vs_menu_icon', true );
    ?>
    <p class="field-vs-menu-icon description description-wide">
        <label for="edit-menu-item-vs-icon-<?php echo esc_attr( $item_id ); ?>">
            <strong><?php esc_html_e( 'Icon (FontAwesome class)', 'visahouse' ); ?></strong><br>
            <input type="text"
                   id="edit-menu-item-vs-icon-<?php echo esc_attr( $item_id ); ?>"
                   class="widefat code edit-menu-item-vs-icon"
                   name="menu-item-vs-icon[<?php echo esc_attr( $item_id ); ?>]"
                   value="<?php echo esc_attr( $icon ); ?>"
                   placeholder="fa-people-roof">
            <span class="description">
                <?php esc_html_e( 'Enter a FontAwesome 6 Solid icon class, e.g. fa-crown, fa-building, fa-id-card.', 'visahouse' ); ?>
            </span>
            <?php if ( $icon ) : ?>
                <span class="vs-menu-icon-preview" style="display:inline-flex;align-items:center;gap:6px;margin-top:6px;font-size:13px;color:#C2410C;">
                    <i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i>
                    <code><?php echo esc_html( $icon ); ?></code>
                </span>
            <?php endif; ?>
        </label>
    </p>
    <?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'vs_menu_item_icon_field', 10, 4 );

/* ============================================================
   SAVE — store the icon in post meta on menu save
   ============================================================ */
function vs_menu_item_icon_save( $menu_id, $menu_item_db_id, $args ) {
    if ( isset( $_POST['menu-item-vs-icon'][ $menu_item_db_id ] ) ) {
        $icon = sanitize_text_field( wp_unslash( $_POST['menu-item-vs-icon'][ $menu_item_db_id ] ) );
        update_post_meta( $menu_item_db_id, '_vs_menu_icon', $icon );
    }
}
add_action( 'wp_update_nav_menu_item', 'vs_menu_item_icon_save', 10, 3 );

/* ============================================================
   ENQUEUE — FontAwesome in the menu admin screen
   ============================================================ */
function vs_menu_admin_fontawesome() {
    $screen = get_current_screen();
    if ( $screen && 'nav-menus' === $screen->id ) {
        wp_enqueue_style(
            'vs-font-awesome-menu-admin',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
            array(),
            '6.5.1'
        );
    }
}
add_action( 'admin_enqueue_scripts', 'vs_menu_admin_fontawesome' );

/* ============================================================
   HELPERS — get an item's icon in the frontend
   ============================================================ */
function vs_get_menu_icon( $menu_item_id ) {
    return get_post_meta( $menu_item_id, '_vs_menu_icon', true );
}