<?php
/**
 * Service CPT — meta box.
 * Fields: icon, icon color, calculator category, price label, price, features.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vs_service_meta_box() {
    add_meta_box(
        'vs_service_meta',
        __( 'Service Details', 'visahouse' ),
        'vs_service_meta_box_render',
        'service',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'vs_service_meta_box' );

function vs_service_meta_box_render( $post ) {
    wp_nonce_field( 'vs_service_meta_save', 'vs_service_meta_nonce' );

    $icon         = get_post_meta( $post->ID, 'vs_service_icon', true ) ?: 'fa-people-roof';
    $icon_color   = get_post_meta( $post->ID, 'vs_service_icon_color', true ) ?: 'default';
    $calc_cat     = get_post_meta( $post->ID, 'vs_service_calc_category', true );
    $price_label  = get_post_meta( $post->ID, 'vs_service_price_label', true ) ?: 'Government fees from';
    $price        = get_post_meta( $post->ID, 'vs_service_price', true );
    $features     = get_post_meta( $post->ID, 'vs_service_features', true );

    if ( ! is_array( $features ) ) {
        $features = array( '', '', '', '' );
    }

    $colors = array(
        'default' => 'Default (brand)',
        'gold'    => 'Gold',
        'green'   => 'Green',
        'blue'    => 'Blue',
        'purple'  => 'Purple',
        'pink'    => 'Pink',
        'cyan'    => 'Cyan',
    );
    ?>
    <style>
        .vs-svc-grid { display: grid; grid-template-columns: 180px 1fr; gap: 14px 18px; align-items: center; max-width: 780px; padding: 10px 0; }
        .vs-svc-grid label { font-weight: 600; }
        .vs-svc-grid input[type=text],
        .vs-svc-grid select { width: 100%; max-width: 520px; }
        .vs-svc-hint { color: #666; font-size: 12px; margin-top: 4px; }
        .vs-svc-preview { display: inline-flex; align-items: center; gap: 8px; margin-top: 6px; font-weight: 600; font-size: 13px; color: #C2410C; }
        .vs-svc-features { display: flex; flex-direction: column; gap: 8px; max-width: 520px; }
        .vs-svc-features input { width: 100%; }
        .vs-svc-features .vs-svc-feature-row { display: flex; align-items: center; gap: 10px; }
        .vs-svc-features .vs-svc-feature-row i { color: #10B981; font-size: 14px; flex-shrink: 0; }
    </style>

    <div class="vs-svc-grid">
        <label for="vs_service_icon"><?php esc_html_e( 'Icon (FA class)', 'visahouse' ); ?></label>
        <div>
            <input type="text" id="vs_service_icon" name="vs_service_icon" value="<?php echo esc_attr( $icon ); ?>">
            <div class="vs-svc-preview">
                <i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i> <span>Preview</span>
            </div>
            <p class="vs-svc-hint">e.g. <code>fa-people-roof</code>, <code>fa-crown</code>, <code>fa-building</code>, <code>fa-baby</code></p>
        </div>

        <label for="vs_service_icon_color"><?php esc_html_e( 'Icon color', 'visahouse' ); ?></label>
        <div>
            <select id="vs_service_icon_color" name="vs_service_icon_color">
                <?php foreach ( $colors as $key => $label ) : ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $icon_color, $key ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <label for="vs_service_calc_category"><?php esc_html_e( 'Calculator category', 'visahouse' ); ?></label>
        <div>
            <input type="text" id="vs_service_calc_category" name="vs_service_calc_category" value="<?php echo esc_attr( $calc_cat ); ?>" placeholder="family, golden, property, newborn">
            <p class="vs-svc-hint">Leave blank to hide the calculator button on this service.</p>
        </div>

        <label for="vs_service_price_label"><?php esc_html_e( 'Price label', 'visahouse' ); ?></label>
        <div>
            <input type="text" id="vs_service_price_label" name="vs_service_price_label" value="<?php echo esc_attr( $price_label ); ?>">
        </div>

        <label for="vs_service_price"><?php esc_html_e( 'Price value', 'visahouse' ); ?></label>
        <div>
            <input type="text" id="vs_service_price" name="vs_service_price" value="<?php echo esc_attr( $price ); ?>" placeholder="AED 1,103">
        </div>

        <label><?php esc_html_e( 'Features (up to 4)', 'visahouse' ); ?></label>
        <div class="vs-svc-features">
            <?php for ( $i = 0; $i < 4; $i++ ) : ?>
                <div class="vs-svc-feature-row">
                    <i class="fa-solid fa-circle-check"></i>
                    <input type="text"
                           name="vs_service_features[]"
                           value="<?php echo esc_attr( $features[ $i ] ?? '' ); ?>"
                           placeholder="<?php echo esc_attr( 'Feature ' . ( $i + 1 ) ); ?>">
                </div>
            <?php endfor; ?>
            <p class="vs-svc-hint">These appear as bullet points on the service card. Leave a field empty to skip it.</p>
        </div>
    </div>
    <?php
}

function vs_service_meta_save( $post_id ) {
    if ( ! isset( $_POST['vs_service_meta_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['vs_service_meta_nonce'], 'vs_service_meta_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = array(
        'vs_service_icon',
        'vs_service_icon_color',
        'vs_service_calc_category',
        'vs_service_price_label',
        'vs_service_price',
    );
    foreach ( $fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
        }
    }

    // Features (repeater as plain array)
    if ( isset( $_POST['vs_service_features'] ) && is_array( $_POST['vs_service_features'] ) ) {
        $features = array();
        foreach ( $_POST['vs_service_features'] as $feature ) {
            $feature = sanitize_text_field( $feature );
            if ( '' !== $feature ) {
                $features[] = $feature;
            }
        }
        update_post_meta( $post_id, 'vs_service_features', $features );
    } else {
        delete_post_meta( $post_id, 'vs_service_features' );
    }
}
add_action( 'save_post_service', 'vs_service_meta_save' );

/**
 * Admin columns for service list.
 */
function vs_service_columns( $columns ) {
    $new = array();
    foreach ( $columns as $key => $label ) {
        $new[ $key ] = $label;
        if ( 'title' === $key ) {
            $new['vs_svc_icon'] = __( 'Icon', 'visahouse' );
        }
    }
    $new['menu_order'] = __( 'Order', 'visahouse' );
    return $new;
}
add_filter( 'manage_service_posts_columns', 'vs_service_columns' );

function vs_service_column_content( $column, $post_id ) {
    if ( 'vs_svc_icon' === $column ) {
        $icon  = get_post_meta( $post_id, 'vs_service_icon', true ) ?: 'fa-star';
        $color = get_post_meta( $post_id, 'vs_service_icon_color', true ) ?: 'default';
        echo '<i class="fa-solid ' . esc_attr( $icon ) . '" style="font-size:18px;color:#C2410C;"></i>';
        if ( $color && 'default' !== $color ) {
            echo ' <span style="color:#666;font-size:11px;">' . esc_html( $color ) . '</span>';
        }
    }
    if ( 'menu_order' === $column ) {
        echo (int) get_post_field( 'menu_order', $post_id );
    }
}
add_action( 'manage_service_posts_custom_column', 'vs_service_column_content', 10, 2 );

/**
 * Enqueue FontAwesome in service admin.
 */
function vs_service_admin_assets( $hook ) {
    $screen = get_current_screen();
    if ( $screen && 'service' === $screen->post_type ) {
        wp_enqueue_style(
            'vs-font-awesome-admin',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
            array(),
            '6.5.1'
        );
    }
}
add_action( 'admin_enqueue_scripts', 'vs_service_admin_assets' );