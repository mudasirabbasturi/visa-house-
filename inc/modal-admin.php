<?php
/**
 * Services Modal — admin pages.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ============================================================
   PARENT MENU: VisaHouse
   ============================================================ */
function vs_admin_menu() {
    add_menu_page(
        __( 'VisaHouse', 'visahouse' ),
        __( 'VisaHouse', 'visahouse' ),
        'edit_posts',
        'vs-options',
        'vs_admin_homepage_redirect',
        'dashicons-admin-site-alt3',
        59
    );

    // Modal Items (CPT) — its own sub-page
    add_submenu_page(
        'vs-options',
        __( 'Services Modal', 'visahouse' ),
        __( 'Services Modal', 'visahouse' ),
        'edit_posts',
        'edit.php?post_type=vs_modal_item'
    );

    // Modal Groups (taxonomy) — its own sub-page
    add_submenu_page(
        'vs-options',
        __( 'Modal Groups', 'visahouse' ),
        __( 'Modal Groups', 'visahouse' ),
        'manage_categories',
        'edit-tags.php?taxonomy=vs_modal_group&post_type=vs_modal_item'
    );

    // Global Settings
    add_submenu_page(
        'vs-options',
        __( 'Global Settings', 'visahouse' ),
        __( 'Global Settings', 'visahouse' ),
        'manage_options',
        'vs-global-settings',
        'vs_admin_global_settings'
    );
}
add_action( 'admin_menu', 'vs_admin_menu' );

/**
 * Landing page for the parent VisaHouse menu.
 */
function vs_admin_homepage_redirect() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'VisaHouse', 'visahouse' ); ?></h1>
        <p><?php esc_html_e( 'Welcome to the VisaHouse theme control panel. Use the sub-menus on the left to manage content.', 'visahouse' ); ?></p>

        <h2><?php esc_html_e( 'Quick links', 'visahouse' ); ?></h2>
        <ul style="list-style: disc; padding-left: 20px;">
            <li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=vs_modal_item' ) ); ?>"><?php esc_html_e( 'Services Modal — Items', 'visahouse' ); ?></a></li>
            <li><a href="<?php echo esc_url( admin_url( 'edit-tags.php?taxonomy=vs_modal_group&post_type=vs_modal_item' ) ); ?>"><?php esc_html_e( 'Services Modal — Groups', 'visahouse' ); ?></a></li>
            <li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=service' ) ); ?>"><?php esc_html_e( 'Services (CPT)', 'visahouse' ); ?></a></li>
            <li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=review' ) ); ?>"><?php esc_html_e( 'Reviews (CPT)', 'visahouse' ); ?></a></li>
            <li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=faq' ) ); ?>"><?php esc_html_e( 'FAQs (CPT)', 'visahouse' ); ?></a></li>
            <li><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Customizer (WhatsApp, phone, rating)', 'visahouse' ); ?></a></li>
        </ul>

        <h2><?php esc_html_e( 'How to build the Services Modal', 'visahouse' ); ?></h2>
        <ol style="list-style: decimal; padding-left: 20px;">
            <li><?php esc_html_e( 'Go to Modal Groups and create groups (e.g. "Residence Visas", "Other Services", "Property & Support", "Company").', 'visahouse' ); ?></li>
            <li><?php esc_html_e( 'Go to Services Modal and add items. Assign each item to a group.', 'visahouse' ); ?></li>
            <li><?php esc_html_e( 'Set the Page Order on each item to control the sequence inside its group.', 'visahouse' ); ?></li>
            <li><?php esc_html_e( 'Trigger the modal from any menu link with URL #vs-services-modal.', 'visahouse' ); ?></li>
        </ol>
    </div>
    <?php
}

/**
 * Global Settings page (WhatsApp, phone, etc. — mirrors Customizer).
 */
function vs_admin_global_settings() {
    if ( isset( $_POST['vs_global_nonce'] ) && wp_verify_nonce( $_POST['vs_global_nonce'], 'vs_global_save' ) ) {
        set_theme_mod( 'vs_whatsapp', sanitize_text_field( $_POST['vs_whatsapp'] ?? '' ) );
        set_theme_mod( 'vs_google_rating', sanitize_text_field( $_POST['vs_google_rating'] ?? '' ) );
        set_theme_mod( 'vs_phone', sanitize_text_field( $_POST['vs_phone'] ?? '' ) );
        set_theme_mod( 'vs_email', sanitize_email( $_POST['vs_email'] ?? '' ) );
        set_theme_mod( 'vs_address', sanitize_text_field( $_POST['vs_address'] ?? '' ) );
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved.', 'visahouse' ) . '</p></div>';
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Global Settings', 'visahouse' ); ?></h1>
        <form method="post">
            <?php wp_nonce_field( 'vs_global_save', 'vs_global_nonce' ); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="vs_whatsapp"><?php esc_html_e( 'WhatsApp number', 'visahouse' ); ?></label></th>
                    <td><input name="vs_whatsapp" id="vs_whatsapp" type="text" class="regular-text" value="<?php echo esc_attr( get_theme_mod( 'vs_whatsapp', '9718003627' ) ); ?>">
                        <p class="description"><?php esc_html_e( 'Digits only, with country code. E.g. 9718003627', 'visahouse' ); ?></p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="vs_google_rating"><?php esc_html_e( 'Google rating', 'visahouse' ); ?></label></th>
                    <td><input name="vs_google_rating" id="vs_google_rating" type="text" class="small-text" value="<?php echo esc_attr( get_theme_mod( 'vs_google_rating', '4.9' ) ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="vs_phone"><?php esc_html_e( 'Phone (display)', 'visahouse' ); ?></label></th>
                    <td><input name="vs_phone" id="vs_phone" type="text" class="regular-text" value="<?php echo esc_attr( get_theme_mod( 'vs_phone', '800 DOCS (3627)' ) ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="vs_email"><?php esc_html_e( 'Email', 'visahouse' ); ?></label></th>
                    <td><input name="vs_email" id="vs_email" type="email" class="regular-text" value="<?php echo esc_attr( get_theme_mod( 'vs_email', 'info@visahouse.ae' ) ); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="vs_address"><?php esc_html_e( 'Address', 'visahouse' ); ?></label></th>
                    <td><input name="vs_address" id="vs_address" type="text" class="regular-text" value="<?php echo esc_attr( get_theme_mod( 'vs_address', 'Business Village, Deira' ) ); ?>"></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
