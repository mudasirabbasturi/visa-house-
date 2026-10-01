<?php
/**
 * Review CPT — meta box.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vs_review_meta_box() {
    add_meta_box(
        'vs_review_meta',
        __( 'Review Details', 'visahouse' ),
        'vs_review_meta_box_render',
        'review',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'vs_review_meta_box' );

function vs_review_meta_box_render( $post ) {
    wp_nonce_field( 'vs_review_meta_save', 'vs_review_meta_nonce' );

    $stars    = (int) get_post_meta( $post->ID, 'vs_review_stars', true ) ?: 5;
    $author   = get_post_meta( $post->ID, 'vs_review_author_name', true );
    $meta     = get_post_meta( $post->ID, 'vs_review_author_meta', true );
    $initials = get_post_meta( $post->ID, 'vs_review_initials', true );
    ?>
    <div style="display:grid;grid-template-columns:160px 1fr;gap:14px 18px;max-width:640px;padding:10px 0;">
        <label for="vs_review_stars"><strong><?php esc_html_e( 'Stars (1–5)', 'visahouse' ); ?></strong></label>
        <input type="number" id="vs_review_stars" name="vs_review_stars" value="<?php echo esc_attr( $stars ); ?>" min="1" max="5" style="max-width:100px;">

        <label for="vs_review_author_name"><strong><?php esc_html_e( 'Author name', 'visahouse' ); ?></strong></label>
        <input type="text" id="vs_review_author_name" name="vs_review_author_name" value="<?php echo esc_attr( $author ); ?>" style="max-width:480px;">

        <label for="vs_review_author_meta"><strong><?php esc_html_e( 'Meta', 'visahouse' ); ?></strong></label>
        <input type="text" id="vs_review_author_meta" name="vs_review_author_meta" value="<?php echo esc_attr( $meta ); ?>" placeholder="Spouse visa · June 2026" style="max-width:480px;">

        <label for="vs_review_initials"><strong><?php esc_html_e( 'Initials', 'visahouse' ); ?></strong></label>
        <input type="text" id="vs_review_initials" name="vs_review_initials" value="<?php echo esc_attr( $initials ); ?>" placeholder="MS" maxlength="3" style="max-width:100px;">
    </div>
    <?php
}

function vs_review_meta_save( $post_id ) {
    if ( ! isset( $_POST['vs_review_meta_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['vs_review_meta_nonce'], 'vs_review_meta_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['vs_review_stars'] ) ) {
        $stars = max( 1, min( 5, (int) $_POST['vs_review_stars'] ) );
        update_post_meta( $post_id, 'vs_review_stars', $stars );
    }
    foreach ( array( 'vs_review_author_name', 'vs_review_author_meta', 'vs_review_initials' ) as $f ) {
        if ( isset( $_POST[ $f ] ) ) {
            update_post_meta( $post_id, $f, sanitize_text_field( $_POST[ $f ] ) );
        }
    }
}
add_action( 'save_post_review', 'vs_review_meta_save' );