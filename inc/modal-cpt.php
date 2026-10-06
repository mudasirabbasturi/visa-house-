<?php
/**
 * Services Modal — CPT, taxonomy, meta boxes.
 *
 * @package VisaHouse
 * @author  Mudasir Abbas
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ============================================================
   REGISTER CPT: vs_modal_item
   ============================================================ */
function vs_register_modal_cpt() {
    register_post_type( 'vs_modal_item', array(
        'labels' => array(
            'name'          => __( 'Modal Items', 'visahouse' ),
            'singular_name' => __( 'Modal Item', 'visahouse' ),
            'add_new_item'  => __( 'Add New Modal Item', 'visahouse' ),
            'edit_item'     => __( 'Edit Modal Item', 'visahouse' ),
            'all_items'     => __( 'All Modal Items', 'visahouse' ),
            'menu_name'     => __( 'Modal Items', 'visahouse' ),
            'search_items'  => __( 'Search Modal Items', 'visahouse' ),
            'not_found'     => __( 'No modal items found.', 'visahouse' ),
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => 'vs-options',           // lives under VisaHouse menu
        'show_in_rest'       => true,
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-screenoptions',
        'supports'           => array( 'title', 'page-attributes' ),
        'rewrite'            => false,
    ) );

    register_taxonomy( 'vs_modal_group', 'vs_modal_item', array(
        'labels' => array(
            'name'          => __( 'Modal Groups', 'visahouse' ),
            'singular_name' => __( 'Modal Group', 'visahouse' ),
            'add_new_item'  => __( 'Add New Group', 'visahouse' ),
            'edit_item'     => __( 'Edit Group', 'visahouse' ),
            'all_items'     => __( 'All Groups', 'visahouse' ),
            'menu_name'     => __( 'Groups', 'visahouse' ),
        ),
        'public'            => false,
        'show_ui'           => true,
        'show_in_menu'      => false,                   // manage via custom page / VisaHouse sub-menu
        'show_in_rest'      => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
    ) );
}
add_action( 'init', 'vs_register_modal_cpt', 5 );

/* ============================================================
   POLYLANG — enable translation for the modal CPT and taxonomy.
   ============================================================ */
function vs_polylang_modal_cpts( $post_types, $is_settings ) {
    $post_types['vs_modal_item'] = 'vs_modal_item';
    return $post_types;
}
add_filter( 'pll_get_post_types', 'vs_polylang_modal_cpts', 10, 2 );

function vs_polylang_modal_taxes( $taxonomies, $is_settings ) {
    $taxonomies['vs_modal_group'] = 'vs_modal_group';
    return $taxonomies;
}
add_filter( 'pll_get_taxonomies', 'vs_polylang_modal_taxes', 10, 2 );

/* ============================================================
   ADMIN ENQUEUE: FontAwesome in admin for vs_modal_item
   ============================================================ */
function vs_modal_admin_assets( $hook ) {
    global $post_type, $taxonomy;
    if ( 'vs_modal_item' === $post_type || 'vs_modal_group' === $taxonomy ) {
        wp_enqueue_style(
            'vs-font-awesome-admin',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
            array(),
            '6.5.1'
        );
    }
}
add_action( 'admin_enqueue_scripts', 'vs_modal_admin_assets' );

/* ============================================================
   TERM META: group layout, full width, order
   ============================================================ */
function vs_modal_group_add_fields() {
    ?>
    <div class="form-field">
        <label for="vs_group_layout"><?php esc_html_e( 'Layout', 'visahouse' ); ?></label>
        <select name="vs_group_layout" id="vs_group_layout">
            <option value="list"><?php esc_html_e( 'List (vertical rows)', 'visahouse' ); ?></option>
            <option value="cards"><?php esc_html_e( 'Cards grid', 'visahouse' ); ?></option>
        </select>
        <p><?php esc_html_e( 'Cards = colorful grid. List = vertical rows.', 'visahouse' ); ?></p>
    </div>
    <div class="form-field">
        <label for="vs_group_full_width">
            <input type="checkbox" name="vs_group_full_width" id="vs_group_full_width" value="1">
            <?php esc_html_e( 'Full width on desktop', 'visahouse' ); ?>
        </label>
        <p class="description"><?php esc_html_e( 'Span both columns on desktop.', 'visahouse' ); ?></p>
    </div>
    <?php
}
add_action( 'vs_modal_group_add_form_fields', 'vs_modal_group_add_fields' );

function vs_modal_group_edit_fields( $term ) {
    $layout     = get_term_meta( $term->term_id, 'vs_group_layout', true ) ?: 'list';
    $full_width = get_term_meta( $term->term_id, 'vs_group_full_width', true );
    ?>
    <tr class="form-field">
        <th scope="row"><label for="vs_group_layout"><?php esc_html_e( 'Layout', 'visahouse' ); ?></label></th>
        <td>
            <select name="vs_group_layout" id="vs_group_layout">
                <option value="list" <?php selected( $layout, 'list' ); ?>><?php esc_html_e( 'List (vertical rows)', 'visahouse' ); ?></option>
                <option value="cards" <?php selected( $layout, 'cards' ); ?>><?php esc_html_e( 'Cards grid', 'visahouse' ); ?></option>
            </select>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><?php esc_html_e( 'Full width?', 'visahouse' ); ?></th>
        <td>
            <label>
                <input type="checkbox" name="vs_group_full_width" value="1" <?php checked( $full_width, '1' ); ?>>
                <?php esc_html_e( 'Span both columns on desktop', 'visahouse' ); ?>
            </label>
        </td>
    </tr>
    <?php
}
add_action( 'vs_modal_group_edit_form_fields', 'vs_modal_group_edit_fields' );

function vs_modal_group_save_fields( $term_id ) {
    if ( isset( $_POST['vs_group_layout'] ) ) {
        update_term_meta( $term_id, 'vs_group_layout', sanitize_text_field( $_POST['vs_group_layout'] ) );
    }
    $full = isset( $_POST['vs_group_full_width'] ) ? '1' : '0';
    update_term_meta( $term_id, 'vs_group_full_width', $full );
}
add_action( 'created_vs_modal_group', 'vs_modal_group_save_fields' );
add_action( 'edited_vs_modal_group',  'vs_modal_group_save_fields' );

/* ============================================================
   POST META BOX: icon, tint, URL
   ============================================================ */
function vs_modal_item_meta_box() {
    add_meta_box(
        'vs_modal_item_details',
        __( 'Modal Item Details', 'visahouse' ),
        'vs_modal_item_meta_box_render',
        'vs_modal_item',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'vs_modal_item_meta_box' );

function vs_modal_item_meta_box_render( $post ) {
    wp_nonce_field( 'vs_modal_item_save', 'vs_modal_item_nonce' );

    $icon = get_post_meta( $post->ID, 'vs_item_icon', true ) ?: 'fa-star';
    $url  = get_post_meta( $post->ID, 'vs_item_url',  true ) ?: '';

    ?>
    <style>
        .vs-meta-grid { display: grid; grid-template-columns: 130px 1fr; gap: 14px 18px; align-items: center; max-width: 640px; padding: 10px 0; }
        .vs-meta-grid label { font-weight: 600; }
        .vs-meta-grid input[type=text],
        .vs-meta-grid select { width: 100%; max-width: 480px; }
        .vs-meta-hint { color: #666; font-size: 12px; margin-top: 4px; }
        .vs-icon-preview { display: inline-flex; align-items: center; gap: 8px; margin-top: 6px; font-weight: 600; font-size: 13px; color: #2563EB; }
    </style>

    <div class="vs-meta-grid">
        <label for="vs_item_icon"><?php esc_html_e( 'Icon (FA class)', 'visahouse' ); ?></label>
        <div>
            <input type="text" id="vs_item_icon" name="vs_item_icon" value="<?php echo esc_attr( $icon ); ?>" placeholder="fa-people-roof">
            <div class="vs-icon-preview">
                <i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i> <span>Preview</span>
            </div>
            <p class="vs-meta-hint"><?php esc_html_e( 'FontAwesome class, e.g. fa-people-roof, fa-crown, fa-building, fa-baby, fa-hands-holding-child, fa-id-card', 'visahouse' ); ?></p>
        </div>

        <label for="vs_item_url"><?php esc_html_e( 'URL', 'visahouse' ); ?></label>
        <div>
            <input type="text" id="vs_item_url" name="vs_item_url" value="<?php echo esc_attr( $url ); ?>" placeholder="https://visahouse.ae/family-visa/">
            <p class="vs-meta-hint"><?php esc_html_e( 'Full URL, or a hash like #calculator', 'visahouse' ); ?></p>
        </div>
    </div>
    <?php
}

function vs_modal_item_save_meta( $post_id ) {
    if ( ! isset( $_POST['vs_modal_item_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['vs_modal_item_nonce'], 'vs_modal_item_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['vs_item_icon'] ) ) {
        update_post_meta( $post_id, 'vs_item_icon', sanitize_text_field( $_POST['vs_item_icon'] ) );
    }
    if ( isset( $_POST['vs_item_url'] ) ) {
        update_post_meta( $post_id, 'vs_item_url', esc_url_raw( $_POST['vs_item_url'] ) );
    }
}
add_action( 'save_post_vs_modal_item', 'vs_modal_item_save_meta' );

/* ============================================================
   ADMIN COLUMNS for vs_modal_item: icon preview, group, order
   ============================================================ */
function vs_modal_item_columns( $columns ) {
    $new = array();
    foreach ( $columns as $key => $label ) {
        $new[ $key ] = $label;
        if ( 'title' === $key ) {
            $new['vs_icon'] = __( 'Icon', 'visahouse' );
        }
    }
    $new['menu_order'] = __( 'Order', 'visahouse' );
    return $new;
}
add_filter( 'manage_vs_modal_item_posts_columns', 'vs_modal_item_columns' );

function vs_modal_item_column_content( $column, $post_id ) {
    if ( 'vs_icon' === $column ) {
        $icon = get_post_meta( $post_id, 'vs_item_icon', true ) ?: 'fa-star';
        echo '<i class="fa-solid ' . esc_attr( $icon ) . '" style="font-size:18px;color:#C2410C;"></i> <span style="color:#666;font-size:12px;margin-left:4px;">' . esc_html( $icon ) . '</span>';
    }
    if ( 'menu_order' === $column ) {
        echo (int) get_post_field( 'menu_order', $post_id );
    }
}
add_action( 'manage_vs_modal_item_posts_custom_column', 'vs_modal_item_column_content', 10, 2 );

/**
 * Make the Order column sortable.
 */
function vs_modal_item_sortable( $columns ) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter( 'manage_edit-vs_modal_item_sortable_columns', 'vs_modal_item_sortable' );
