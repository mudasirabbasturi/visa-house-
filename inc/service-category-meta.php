<?php
/**
 * Service Category — extra term meta for homepage section headers
 * and the hero v2 slider.
 *
 * Fields:
 *   - vs_cat_section_title  (homepage section headline)
 *   - vs_cat_section_desc   (homepage section description)
 *   - vs_cat_section_order  (homepage + hero ordering)
 *   - vs_cat_slide_icon     (FontAwesome icon for hero slider + calc card)
 *   - vs_cat_slide_image    (hero slider background image URL)
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
        <p><?php esc_html_e( 'Big headline for this category on the homepage. HTML allowed (e.g. <em>needs</em> for accent).', 'visahouse' ); ?></p>
    </div>
    <div class="form-field">
        <label for="vs_cat_section_desc"><?php esc_html_e( 'Section description', 'visahouse' ); ?></label>
        <textarea name="vs_cat_section_desc" id="vs_cat_section_desc" rows="3"></textarea>
        <p><?php esc_html_e( 'Short sentence under the title. Also used as the hero slider description and calculator row subtext.', 'visahouse' ); ?></p>
    </div>
    <div class="form-field">
        <label for="vs_cat_section_order"><?php esc_html_e( 'Section order', 'visahouse' ); ?></label>
        <input type="number" name="vs_cat_section_order" id="vs_cat_section_order" value="0" min="0" step="1">
        <p><?php esc_html_e( 'Lower numbers appear first on the homepage and in the hero slider.', 'visahouse' ); ?></p>
    </div>
    <div class="form-field">
        <label for="vs_cat_slide_icon"><?php esc_html_e( 'Slider icon (FA class)', 'visahouse' ); ?></label>
        <input type="text" name="vs_cat_slide_icon" id="vs_cat_slide_icon" value="" placeholder="fa-people-roof">
        <p><?php esc_html_e( 'FontAwesome 6 Solid class, e.g. fa-people-roof, fa-crown, fa-building. Shown in the hero slider and calculator card.', 'visahouse' ); ?></p>
    </div>
    <div class="form-field">
        <label for="vs_cat_slide_image"><?php esc_html_e( 'Slider background image URL', 'visahouse' ); ?></label>
        <input type="url" name="vs_cat_slide_image" id="vs_cat_slide_image" value="" placeholder="https://...">
        <p><?php esc_html_e( 'Optional. If empty, a default Unsplash image is used for that slide.', 'visahouse' ); ?></p>
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
        <td>
            <input type="text" name="vs_cat_section_title" id="vs_cat_section_title" value="<?php echo esc_attr( $title ); ?>">
            <p class="description"><?php esc_html_e( 'Big headline for this category on the homepage. HTML allowed (e.g. <em>needs</em> for accent).', 'visahouse' ); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="vs_cat_section_desc"><?php esc_html_e( 'Section description', 'visahouse' ); ?></label></th>
        <td>
            <textarea name="vs_cat_section_desc" id="vs_cat_section_desc" rows="3" style="width:100%;max-width:520px;"><?php echo esc_textarea( $desc ); ?></textarea>
            <p class="description"><?php esc_html_e( 'Also used as the hero slider description and calculator row subtext.', 'visahouse' ); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="vs_cat_section_order"><?php esc_html_e( 'Section order', 'visahouse' ); ?></label></th>
        <td>
            <input type="number" name="vs_cat_section_order" id="vs_cat_section_order" value="<?php echo esc_attr( $order ); ?>" min="0" step="1">
            <p class="description"><?php esc_html_e( 'Lower numbers appear first on the homepage and in the hero slider.', 'visahouse' ); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="vs_cat_slide_icon"><?php esc_html_e( 'Slider icon (FA class)', 'visahouse' ); ?></label></th>
        <td>
            <input type="text" name="vs_cat_slide_icon" id="vs_cat_slide_icon" value="<?php echo esc_attr( $icon ); ?>" placeholder="fa-people-roof" style="width:100%;max-width:520px;">
            <p class="description"><?php esc_html_e( 'FontAwesome 6 Solid class, e.g. fa-people-roof, fa-crown, fa-building. Shown in the hero slider and calculator card.', 'visahouse' ); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="vs_cat_slide_image"><?php esc_html_e( 'Slider background image URL', 'visahouse' ); ?></label></th>
        <td>
            <input type="url" name="vs_cat_slide_image" id="vs_cat_slide_image" value="<?php echo esc_attr( $image ); ?>" placeholder="https://..." style="width:100%;max-width:520px;">
            <p class="description"><?php esc_html_e( 'Optional. If empty, a default Unsplash image is used for that slide.', 'visahouse' ); ?></p>
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