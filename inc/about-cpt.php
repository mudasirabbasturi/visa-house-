<?php
/**
 * About — singleton CPT.
 * One post per language. Meta box holds the 6 About-section fields.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ============================================================
   REGISTER CPT
   ============================================================ */
function vs_register_about_cpt() {
    register_post_type( 'vs_about', array(
        'labels' => array(
            'name'               => __( 'About', 'visahouse' ),
            'singular_name'      => __( 'About', 'visahouse' ),
            'menu_name'          => __( 'About', 'visahouse' ),
            'edit_item'          => __( 'Edit About', 'visahouse' ),
            'view_item'          => __( 'View About', 'visahouse' ),
            'all_items'          => __( 'About', 'visahouse' ),
            'add_new_item'       => __( 'Create About', 'visahouse' ),
            'new_item'           => __( 'About', 'visahouse' ),
            'not_found'          => __( 'No About content yet.', 'visahouse' ),
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-info-outline',
        'menu_position'      => 23,
        'supports'           => array( 'title', 'thumbnail' ),
        'rewrite'            => false,
        'capability_type'    => 'post',
    ) );
}
add_action( 'init', 'vs_register_about_cpt', 5 );

/* ============================================================
   POLYLANG — enable translation
   ============================================================ */
function vs_polylang_about_cpt( $post_types, $is_settings ) {
    $post_types['vs_about'] = 'vs_about';
    return $post_types;
}
add_filter( 'pll_get_post_types', 'vs_polylang_about_cpt', 10, 2 );

/* ============================================================
   META BOX
   ============================================================ */
function vs_about_cpt_meta_box() {
    add_meta_box(
        'vs_about_fields',
        __( 'About Section Content', 'visahouse' ),
        'vs_about_cpt_meta_box_render',
        'vs_about',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'vs_about_cpt_meta_box' );

function vs_about_cpt_meta_box_render( $post ) {
    wp_nonce_field( 'vs_about_cpt_save', 'vs_about_cpt_nonce' );

    $label = get_post_meta( $post->ID, 'vs_about_label', true );
    $title = get_post_meta( $post->ID, 'vs_about_title', true );
    $text  = get_post_meta( $post->ID, 'vs_about_text',  true );

    $s1v   = get_post_meta( $post->ID, 'vs_about_stat1_value', true );
    $s1l   = get_post_meta( $post->ID, 'vs_about_stat1_label', true );
    $s2v   = get_post_meta( $post->ID, 'vs_about_stat2_value', true );
    $s2l   = get_post_meta( $post->ID, 'vs_about_stat2_label', true );
    $s3v   = get_post_meta( $post->ID, 'vs_about_stat3_value', true );
    $s3l   = get_post_meta( $post->ID, 'vs_about_stat3_label', true );
    ?>

    <style>
        .vs-ab-grid { display: grid; grid-template-columns: 160px 1fr; gap: 16px 20px; align-items: start; max-width: 820px; padding: 6px 0; }
        .vs-ab-grid label { font-weight: 700; font-size: 13px; color: #0A1F3D; padding-top: 8px; }
        .vs-ab-grid input[type=text], .vs-ab-grid textarea { width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; font-family: inherit; }
        .vs-ab-grid textarea { min-height: 90px; resize: vertical; }
        .vs-ab-grid .desc { font-size: 12px; color: #64748B; margin-top: 4px; }
        .vs-ab-divider { grid-column: 1 / -1; border-top: 1px solid #E2E8F0; padding-top: 14px; margin-top: 4px; font-weight: 800; font-size: 12px; letter-spacing: .08em; text-transform: uppercase; color: #C2410C; }
        .vs-ab-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; max-width: 520px; }
        .vs-ab-stats input { padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; width: 100%; }
        .vs-ab-tip { margin-top: 18px; padding: 12px 16px; background: #FEF3E7; border: 1px solid rgba(194, 65, 12, .2); border-radius: 8px; font-size: 13px; color: #7C2D12; }
    </style>

    <div class="vs-ab-grid">
        <label for="vs_about_label"><?php esc_html_e( 'Section label', 'visahouse' ); ?></label>
        <div>
            <input type="text" id="vs_about_label" name="vs_about_label" value="<?php echo esc_attr( $label ); ?>" placeholder="About Us">
        </div>

        <label for="vs_about_title"><?php esc_html_e( 'Title', 'visahouse' ); ?></label>
        <div>
            <input type="text" id="vs_about_title" name="vs_about_title" value="<?php echo esc_attr( $title ); ?>" placeholder="We are &lt;em&gt;800 DOCS&lt;/em&gt; — on your side.">
            <div class="desc"><?php esc_html_e( 'Wrap a word in <em>...</em> to make it orange.', 'visahouse' ); ?></div>
        </div>

        <label for="vs_about_text"><?php esc_html_e( 'Paragraph', 'visahouse' ); ?></label>
        <div>
            <textarea id="vs_about_text" name="vs_about_text" placeholder="800 DOCS LLC SOC is the private, licensed documentation company…"><?php echo esc_textarea( $text ); ?></textarea>
        </div>
                <label for="vs_about_read_more"><?php esc_html_e( 'Read more link', 'visahouse' ); ?></label>
        <div>
            <?php
            $read_more = get_post_meta( $post->ID, 'vs_about_read_more', true );
            if ( function_exists( 'vs_link_picker' ) ) {
                vs_link_picker( 'vs_about_read_more', $read_more, 'Search pages, posts, or services…' );
            } else {
                echo '<input type="url" name="vs_about_read_more" value="' . esc_attr( $read_more ) . '" style="width:100%;" placeholder="https://...">';
            }
            ?>
            <div class="desc"><?php esc_html_e( 'The "Read more" button on the homepage About section links here. Type a name or paste any URL.', 'visahouse' ); ?></div>
        </div>

        <div class="vs-ab-divider"><?php esc_html_e( 'Stats', 'visahouse' ); ?></div>

        <label><?php esc_html_e( 'Stat 1', 'visahouse' ); ?></label>
        <div class="vs-ab-stats">
            <input type="text" name="vs_about_stat1_value" value="<?php echo esc_attr( $s1v ); ?>" placeholder="20,000+">
            <input type="text" name="vs_about_stat1_label" value="<?php echo esc_attr( $s1l ); ?>" placeholder="Visas processed">
        </div>

        <label><?php esc_html_e( 'Stat 2', 'visahouse' ); ?></label>
        <div class="vs-ab-stats">
            <input type="text" name="vs_about_stat2_value" value="<?php echo esc_attr( $s2v ); ?>" placeholder="4.9 ★">
            <input type="text" name="vs_about_stat2_label" value="<?php echo esc_attr( $s2l ); ?>" placeholder="Rated on Google">
        </div>

        <label><?php esc_html_e( 'Stat 3', 'visahouse' ); ?></label>
        <div class="vs-ab-stats">
            <input type="text" name="vs_about_stat3_value" value="<?php echo esc_attr( $s3v ); ?>" placeholder="100%">
            <input type="text" name="vs_about_stat3_label" value="<?php echo esc_attr( $s3l ); ?>" placeholder="Online from start to finish">
        </div>
    </div>

    <div class="vs-ab-tip">
        <strong><?php esc_html_e( 'Featured Image:', 'visahouse' ); ?></strong>
        <?php esc_html_e( 'Set the Featured Image on this post — it is used as the image in the homepage About section.', 'visahouse' ); ?>
    </div>

    <?php
}

function vs_about_cpt_save( $post_id ) {
    if ( ! isset( $_POST['vs_about_cpt_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['vs_about_cpt_nonce'], 'vs_about_cpt_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = array(
        'vs_about_label', 'vs_about_title', 'vs_about_text',
        'vs_about_stat1_value', 'vs_about_stat1_label',
        'vs_about_stat2_value', 'vs_about_stat2_label',
        'vs_about_stat3_value', 'vs_about_stat3_label',
    );
    foreach ( $fields as $field ) {
        if ( isset( $_POST['vs_about_read_more'] ) ) {
            update_post_meta( $post_id, 'vs_about_read_more', esc_url_raw( wp_unslash( $_POST['vs_about_read_more'] ) ) );
        }
        if ( ! isset( $_POST[ $field ] ) ) continue;
        $value = wp_unslash( $_POST[ $field ] );
        if ( 'vs_about_title' === $field ) {
            $value = wp_kses( $value, array( 'em' => array() ) );
        } elseif ( 'vs_about_text' === $field ) {
            $value = sanitize_textarea_field( $value );
        } else {
            $value = sanitize_text_field( $value );
        }
        update_post_meta( $post_id, $field, $value );
    }
}
add_action( 'save_post_vs_about', 'vs_about_cpt_save' );

/* ============================================================
   ADMIN — rename title placeholder
   ============================================================ */
function vs_about_cpt_admin_title( $title ) {
    global $post_type;
    if ( 'vs_about' === $post_type ) {
        return __( 'About section (internal name — not shown on the site)', 'visahouse' );
    }
    return $title;
}
add_filter( 'enter_title_here', 'vs_about_cpt_admin_title' );