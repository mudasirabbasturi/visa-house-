<?php
/**
 * Service Category — extra term meta for homepage section headers
 * and the hero v2 slider.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ============================================================
   ADD FIELDS on "Add New" screen
   ============================================================ */
function vs_service_category_add_fields() {
    ?>
    <div class="form-field">
        <label for="vs_cat_section_title"><?php esc_html_e( 'Section title', 'visahouse' ); ?></label>
        <input type="text" name="vs_cat_section_title" id="vs_cat_section_title" value="">
        <p><?php esc_html_e( 'Big headline for this category on the homepage. HTML allowed.', 'visahouse' ); ?></p>
    </div>
    <div class="form-field">
        <label for="vs_cat_section_desc"><?php esc_html_e( 'Section description', 'visahouse' ); ?></label>
        <textarea name="vs_cat_section_desc" id="vs_cat_section_desc" rows="3"></textarea>
    </div>
    <div class="form-field">
        <label for="vs_cat_section_order"><?php esc_html_e( 'Section order', 'visahouse' ); ?></label>
        <input type="number" name="vs_cat_section_order" id="vs_cat_section_order" value="0" min="0" step="1">
    </div>
    <div class="form-field">
        <label for="vs_cat_slide_icon"><?php esc_html_e( 'Slider icon (FA class)', 'visahouse' ); ?></label>
        <input type="text" name="vs_cat_slide_icon" id="vs_cat_slide_icon" value="" placeholder="fa-people-roof">
    </div>
    <div class="form-field vs-media-wrap">
        <label for="vs_cat_slide_image"><?php esc_html_e( 'Slider background image URL', 'visahouse' ); ?></label>
        <input type="hidden" name="vs_cat_slide_image" id="vs_cat_slide_image" value="">
        <button class="button vs-media-pick">Choose image</button>
        <button class="button vs-media-clear">Remove</button>
        <div class="vs-media-preview" style="margin-top: 10px;"></div>
    </div>
    <?php
}
add_action( 'service_category_add_form_fields', 'vs_service_category_add_fields' );

/* ============================================================
   ADD FIELDS on "Edit" screen
   ============================================================ */
function vs_service_category_edit_fields( $term ) {
    $title = get_term_meta( $term->term_id, 'vs_cat_section_title', true );
    $desc  = get_term_meta( $term->term_id, 'vs_cat_section_desc', true );
    $order = (int) get_term_meta( $term->term_id, 'vs_cat_section_order', true );
    $icon  = get_term_meta( $term->term_id, 'vs_cat_slide_icon', true );
    $image = get_term_meta( $term->term_id, 'vs_cat_slide_image', true );
    ?>
    <tr class="form-field">
        <th scope="row"><label for="vs_cat_section_title"><?php esc_html_e( 'Section title', 'visahouse' ); ?></label></th>
        <td><input type="text" name="vs_cat_section_title" id="vs_cat_section_title" value="<?php echo esc_attr( $title ); ?>"></td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="vs_cat_section_desc"><?php esc_html_e( 'Section description', 'visahouse' ); ?></label></th>
        <td><textarea name="vs_cat_section_desc" id="vs_cat_section_desc" rows="3" style="width:100%;max-width:520px;"><?php echo esc_textarea( $desc ); ?></textarea></td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="vs_cat_section_order"><?php esc_html_e( 'Section order', 'visahouse' ); ?></label></th>
        <td><input type="number" name="vs_cat_section_order" id="vs_cat_section_order" value="<?php echo esc_attr( $order ); ?>" min="0" step="1"></td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="vs_cat_slide_icon"><?php esc_html_e( 'Slider icon (FA class)', 'visahouse' ); ?></label></th>
        <td><input type="text" name="vs_cat_slide_icon" id="vs_cat_slide_icon" value="<?php echo esc_attr( $icon ); ?>" placeholder="fa-people-roof" style="width:100%;max-width:520px;"></td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="vs_cat_slide_image"><?php esc_html_e( 'Slider background image URL', 'visahouse' ); ?></label></th>
        <td class="vs-media-wrap">
            <input type="hidden" name="vs_cat_slide_image" id="vs_cat_slide_image" value="<?php echo esc_attr( $image ); ?>">
            <button class="button vs-media-pick">Choose image</button>
            <button class="button vs-media-clear">Remove</button>
            <div class="vs-media-preview" style="margin-top: 10px;">
                <?php if ( $image ) : ?>
                    <img src="<?php echo esc_url( $image ); ?>" style="max-width:80px;border-radius:6px;display:block;">
                <?php endif; ?>
            </div>
        </td>
    </tr>
    <?php
}
add_action( 'service_category_edit_form_fields', 'vs_service_category_edit_fields' );

/* ============================================================
   SAVE FIELDS
   ============================================================ */
function vs_service_category_save_fields( $term_id ) {
    if ( isset( $_POST['vs_cat_section_title'] ) ) {
        update_term_meta( $term_id, 'vs_cat_section_title', wp_kses_post( $_POST['vs_cat_section_title'] ) );
    }
    if ( isset( $_POST['vs_cat_section_desc'] ) ) {
        update_term_meta( $term_id, 'vs_cat_section_desc', sanitize_textarea_field( $_POST['vs_cat_section_desc'] ) );
    }
    if ( isset( $_POST['vs_cat_section_order'] ) ) {
        update_term_meta( $term_id, 'vs_cat_section_order', (int) $_POST['vs_cat_section_order'] );
    }
    if ( isset( $_POST['vs_cat_slide_icon'] ) ) {
        update_term_meta( $term_id, 'vs_cat_slide_icon', sanitize_text_field( $_POST['vs_cat_slide_icon'] ) );
    }
    if ( isset( $_POST['vs_cat_slide_image'] ) ) {
        update_term_meta( $term_id, 'vs_cat_slide_image', esc_url_raw( $_POST['vs_cat_slide_image'] ) );
    }
}
add_action( 'created_service_category', 'vs_service_category_save_fields' );
add_action( 'edited_service_category',  'vs_service_category_save_fields' );

/* ============================================================
   MEDIA SCRIPTS
   ============================================================ */
function vs_service_category_media_scripts( $hook ) {
    $screen = get_current_screen();
    if ( ! $screen || $screen->taxonomy !== 'service_category' ) {
        return;
    }
    wp_enqueue_media();
    wp_add_inline_script( 'media-editor', "
        jQuery(document).on('click', '.vs-media-pick', function(e){
            e.preventDefault();
            var \$wrap = jQuery(this).closest('.vs-media-wrap');
            var frame = wp.media({ title: 'Select image', multiple: false, library: { type: 'image' } });
            frame.on('select', function(){
                var att = frame.state().get('selection').first().toJSON();
                \$wrap.find('input[type=hidden]').val(att.url);
                \$wrap.find('.vs-media-preview').html(
                    '<img src=\"' + att.url + '\" style=\"max-width:80px;border-radius:6px;display:block;\">'
                );
            });
            frame.open();
        });
        jQuery(document).on('click', '.vs-media-clear', function(e){
            e.preventDefault();
            var \$wrap = jQuery(this).closest('.vs-media-wrap');
            \$wrap.find('input[type=hidden]').val('');
            \$wrap.find('.vs-media-preview').html('');
        });
    " );
}
add_action( 'admin_enqueue_scripts', 'vs_service_category_media_scripts' );