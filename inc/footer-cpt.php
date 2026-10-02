<?php
/**
 * Footer — singleton CPT.
 * One post per language. Meta box holds all footer content.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ============================================================
   REGISTER CPT
   ============================================================ */
function vs_register_footer_cpt() {
    register_post_type( 'vs_footer', array(
        'labels' => array(
            'name'               => __( 'Footer', 'visahouse' ),
            'singular_name'      => __( 'Footer', 'visahouse' ),
            'menu_name'          => __( 'Footer', 'visahouse' ),
            'edit_item'          => __( 'Edit Footer', 'visahouse' ),
            'view_item'          => __( 'View Footer', 'visahouse' ),
            'all_items'          => __( 'Footer', 'visahouse' ),
            'add_new_item'       => __( 'Create Footer', 'visahouse' ),
            'new_item'           => __( 'Footer', 'visahouse' ),
            'not_found'          => __( 'No Footer content yet.', 'visahouse' ),
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-editor-insertmore',
        'menu_position'      => 24,
        'supports'           => array( 'title', 'thumbnail' ),
        'rewrite'            => false,
        'capability_type'    => 'post',
    ) );
}
add_action( 'init', 'vs_register_footer_cpt', 5 );

/* ============================================================
   POLYLANG — enable translation
   ============================================================ */
function vs_polylang_footer_cpt( $post_types, $is_settings ) {
    $post_types['vs_footer'] = 'vs_footer';
    return $post_types;
}
add_filter( 'pll_get_post_types', 'vs_polylang_footer_cpt', 10, 2 );

/* ============================================================
   META BOX — full footer editor
   ============================================================ */
function vs_footer_cpt_meta_box() {
    add_meta_box(
        'vs_footer_fields',
        __( 'Footer Content', 'visahouse' ),
        'vs_footer_cpt_meta_box_render',
        'vs_footer',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'vs_footer_cpt_meta_box' );

function vs_footer_cpt_meta_box_render( $post ) {
    wp_nonce_field( 'vs_footer_cpt_save', 'vs_footer_cpt_nonce' );

    $pid = $post->ID;

    $brand_tagline = get_post_meta( $pid, 'vs_footer_brand_tagline', true );
    $brand_desc    = get_post_meta( $pid, 'vs_footer_brand_desc',    true );

    $services_title = get_post_meta( $pid, 'vs_footer_services_title', true );
    $services       = get_post_meta( $pid, 'vs_footer_services',       true );
    if ( ! is_array( $services ) ) $services = array();

    $company_title = get_post_meta( $pid, 'vs_footer_company_title', true );
    $company       = get_post_meta( $pid, 'vs_footer_company',       true );
    if ( ! is_array( $company ) ) $company = array();

    $contact_title   = get_post_meta( $pid, 'vs_footer_contact_title',   true );
    $contact_phone   = get_post_meta( $pid, 'vs_footer_contact_phone',   true );
    $contact_email   = get_post_meta( $pid, 'vs_footer_contact_email',   true );
    $contact_address = get_post_meta( $pid, 'vs_footer_contact_address', true );
    $contact_hours   = get_post_meta( $pid, 'vs_footer_contact_hours',   true );

    $socials = array();
    foreach ( array( 'facebook', 'instagram', 'tiktok', 'linkedin', 'youtube' ) as $key ) {
        $socials[ $key ] = get_post_meta( $pid, "vs_social_{$key}", true );
    }

    $trust_label        = get_post_meta( $pid, 'vs_footer_trust_label', true );
    $trust_items        = get_post_meta( $pid, 'vs_footer_trust_items', true );
    if ( ! is_array( $trust_items ) ) $trust_items = array();
    $google_rating      = get_post_meta( $pid, 'vs_footer_google_rating', true );
    $google_reviews_url = get_post_meta( $pid, 'vs_footer_google_url', true );

    $copyright  = get_post_meta( $pid, 'vs_footer_copyright',  true );
    $disclaimer = get_post_meta( $pid, 'vs_footer_disclaimer', true );
    $legal      = get_post_meta( $pid, 'vs_footer_legal',      true );
    if ( ! is_array( $legal ) ) $legal = array();

    $has_picker = function_exists( 'vs_link_picker' );
    ?>

    <style>
        .vs-fb-wrap { padding: 6px 0; }
        .vs-fb-row { display: grid; grid-template-columns: 160px 1fr; gap: 14px 20px; align-items: center; margin-bottom: 16px; max-width: 900px; }
        .vs-fb-row label { font-weight: 700; font-size: 13px; color: #0A1F3D; padding-top: 8px; }
        .vs-fb-row input[type=text], .vs-fb-row input[type=url], .vs-fb-row input[type=email], .vs-fb-row textarea, .vs-fb-row select { width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; font-family: inherit; }
        .vs-fb-row textarea { min-height: 70px; resize: vertical; }
        .vs-fb-section { border-top: 1px solid #E2E8F0; margin-top: 26px; padding-top: 22px; }
        .vs-fb-section > h3 { font-size: 13px; font-weight: 800; color: #C2410C; text-transform: uppercase; letter-spacing: .08em; margin: 0 0 16px; display: flex; align-items: center; gap: 8px; }
        .vs-fb-repeater { display: flex; flex-direction: column; gap: 8px; max-width: 900px; }
        .vs-fb-item { display: grid; grid-template-columns: 1fr 2fr 130px 40px; gap: 8px; padding: 10px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; align-items: center; }
        .vs-fb-item.vs-fb-item-trust { grid-template-columns: 2fr 130px 40px; }
        .vs-fb-item.vs-fb-item-legal { grid-template-columns: 1fr 2fr 40px; }
        .vs-fb-item input { padding: 7px 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; width: 100%; }
        .vs-fb-remove { background: #fff; border: 1px solid #E2E8F0; border-radius: 8px; color: #94A3B8; cursor: pointer; font-size: 14px; height: 36px; display: flex; align-items: center; justify-content: center; transition: .15s; }
        .vs-fb-remove:hover { color: #DC2626; border-color: #DC2626; background: #FEF2F2; }
        .vs-fb-add { display: inline-flex; align-items: center; gap: 6px; background: #fff; border: 1px solid #C2410C; color: #C2410C; padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; transition: .15s; margin-top: 10px; }
        .vs-fb-add:hover { background: #C2410C; color: #fff; }
        .vs-fb-social-grid { display: grid; grid-template-columns: 160px 1fr; gap: 10px 20px; max-width: 900px; align-items: center; }
        .vs-fb-social-grid label { font-weight: 700; font-size: 13px; color: #0A1F3D; }
        .vs-fb-tip { margin-top: 20px; padding: 12px 16px; background: #FEF3E7; border: 1px solid rgba(194, 65, 12, .2); border-radius: 8px; font-size: 13px; color: #7C2D12; }
    </style>

    <div class="vs-fb-wrap">

        <div class="vs-fb-tip">
            <strong><?php esc_html_e( 'Tip:', 'visahouse' ); ?></strong>
            <?php esc_html_e( 'Set the Featured Image to override the footer logo. Leave it empty to use the site logo.', 'visahouse' ); ?>
        </div>

        <!-- ==============================
             BRAND COLUMN
             ============================== -->
        <div class="vs-fb-section">
            <h3><i class="fa-solid fa-building"></i> <?php esc_html_e( 'Brand Column', 'visahouse' ); ?></h3>
            <div class="vs-fb-row">
                <label for="vs_footer_brand_tagline"><?php esc_html_e( 'Tagline', 'visahouse' ); ?></label>
                <div><input type="text" id="vs_footer_brand_tagline" name="vs_footer_brand_tagline" value="<?php echo esc_attr( $brand_tagline ); ?>" placeholder="Global Mobility Solutions"></div>
            </div>
            <div class="vs-fb-row">
                <label for="vs_footer_brand_desc"><?php esc_html_e( 'Description', 'visahouse' ); ?></label>
                <div><textarea id="vs_footer_brand_desc" name="vs_footer_brand_desc" placeholder="Your trusted partner…"><?php echo esc_textarea( $brand_desc ); ?></textarea></div>
            </div>
        </div>

        <!-- ==============================
             SERVICES COLUMN
             ============================== -->
        <div class="vs-fb-section">
            <h3><i class="fa-solid fa-grip"></i> <?php esc_html_e( 'Services Column', 'visahouse' ); ?></h3>
            <div class="vs-fb-row">
                <label for="vs_footer_services_title"><?php esc_html_e( 'Column title', 'visahouse' ); ?></label>
                <div><input type="text" id="vs_footer_services_title" name="vs_footer_services_title" value="<?php echo esc_attr( $services_title ?: 'Services' ); ?>"></div>
            </div>
            <div class="vs-fb-repeater" id="vs-fb-services">
                <?php foreach ( $services as $i => $row ) :
                    $row = wp_parse_args( $row, array( 'label' => '', 'url' => '', 'icon' => '' ) );
                    ?>
                    <div class="vs-fb-item">
                        <input type="text" name="vs_footer_services[<?php echo (int) $i; ?>][label]" value="<?php echo esc_attr( $row['label'] ); ?>" placeholder="Label">
                        <?php
                        if ( $has_picker ) {
                            vs_link_picker( "vs_footer_services[{$i}][url]", $row['url'], 'Search or paste URL…' );
                        } else {
                            echo '<input type="text" name="vs_footer_services[' . (int) $i . '][url]" value="' . esc_attr( $row['url'] ) . '" placeholder="/url/">';
                        }
                        ?>
                        <input type="text" name="vs_footer_services[<?php echo (int) $i; ?>][icon]" value="<?php echo esc_attr( $row['icon'] ); ?>" placeholder="fa-crown">
                        <button type="button" class="vs-fb-remove"><span class="dashicons dashicons-no-alt"></span></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="vs-fb-add" data-target="vs-fb-services" data-base="vs_footer_services" data-template="link"><i class="fa-solid fa-plus"></i> <?php esc_html_e( 'Add link', 'visahouse' ); ?></button>
        </div>

        <!-- ==============================
             COMPANY COLUMN
             ============================== -->
        <div class="vs-fb-section">
            <h3><i class="fa-solid fa-briefcase"></i> <?php esc_html_e( 'Company Column', 'visahouse' ); ?></h3>
            <div class="vs-fb-row">
                <label for="vs_footer_company_title"><?php esc_html_e( 'Column title', 'visahouse' ); ?></label>
                <div><input type="text" id="vs_footer_company_title" name="vs_footer_company_title" value="<?php echo esc_attr( $company_title ?: 'Company' ); ?>"></div>
            </div>
            <div class="vs-fb-repeater" id="vs-fb-company">
                <?php foreach ( $company as $i => $row ) :
                    $row = wp_parse_args( $row, array( 'label' => '', 'url' => '', 'icon' => '' ) );
                    ?>
                    <div class="vs-fb-item">
                        <input type="text" name="vs_footer_company[<?php echo (int) $i; ?>][label]" value="<?php echo esc_attr( $row['label'] ); ?>" placeholder="Label">
                        <?php
                        if ( $has_picker ) {
                            vs_link_picker( "vs_footer_company[{$i}][url]", $row['url'], 'Search or paste URL…' );
                        } else {
                            echo '<input type="text" name="vs_footer_company[' . (int) $i . '][url]" value="' . esc_attr( $row['url'] ) . '" placeholder="/url/">';
                        }
                        ?>
                        <input type="text" name="vs_footer_company[<?php echo (int) $i; ?>][icon]" value="<?php echo esc_attr( $row['icon'] ); ?>" placeholder="fa-building">
                        <button type="button" class="vs-fb-remove"><span class="dashicons dashicons-no-alt"></span></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="vs-fb-add" data-target="vs-fb-company" data-base="vs_footer_company" data-template="link"><i class="fa-solid fa-plus"></i> <?php esc_html_e( 'Add link', 'visahouse' ); ?></button>
        </div>

        <!-- ==============================
             CONTACT COLUMN
             ============================== -->
        <div class="vs-fb-section">
            <h3><i class="fa-solid fa-envelope"></i> <?php esc_html_e( 'Contact Column', 'visahouse' ); ?></h3>
            <div class="vs-fb-row"><label for="vs_footer_contact_title"><?php esc_html_e( 'Column title', 'visahouse' ); ?></label><div><input type="text" id="vs_footer_contact_title" name="vs_footer_contact_title" value="<?php echo esc_attr( $contact_title ?: 'Contact' ); ?>"></div></div>
            <div class="vs-fb-row"><label for="vs_footer_contact_phone"><?php esc_html_e( 'Phone', 'visahouse' ); ?></label><div><input type="text" id="vs_footer_contact_phone" name="vs_footer_contact_phone" value="<?php echo esc_attr( $contact_phone ); ?>" placeholder="800 DOCS (3627)"></div></div>
            <div class="vs-fb-row"><label for="vs_footer_contact_email"><?php esc_html_e( 'Email', 'visahouse' ); ?></label><div><input type="email" id="vs_footer_contact_email" name="vs_footer_contact_email" value="<?php echo esc_attr( $contact_email ); ?>" placeholder="info@visahouse.ae"></div></div>
            <div class="vs-fb-row"><label for="vs_footer_contact_address"><?php esc_html_e( 'Address', 'visahouse' ); ?></label><div><input type="text" id="vs_footer_contact_address" name="vs_footer_contact_address" value="<?php echo esc_attr( $contact_address ); ?>" placeholder="Business Village, Deira"></div></div>
            <div class="vs-fb-row"><label for="vs_footer_contact_hours"><?php esc_html_e( 'Hours', 'visahouse' ); ?></label><div><input type="text" id="vs_footer_contact_hours" name="vs_footer_contact_hours" value="<?php echo esc_attr( $contact_hours ); ?>" placeholder="Sun–Thu · 9am–6pm"></div></div>
        </div>

        <!-- ==============================
             SOCIALS
             ============================== -->
        <div class="vs-fb-section">
            <h3><i class="fa-solid fa-share-nodes"></i> <?php esc_html_e( 'Social Links', 'visahouse' ); ?></h3>
            <div class="vs-fb-social-grid">
                <?php foreach ( array( 'facebook', 'instagram', 'tiktok', 'linkedin', 'youtube' ) as $key ) : ?>
                    <label for="vs_social_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( ucfirst( $key ) ); ?></label>
                    <input type="url" id="vs_social_<?php echo esc_attr( $key ); ?>" name="vs_social_<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $socials[ $key ] ); ?>" placeholder="https://...">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ==============================
             TRUST ROW
             ============================== -->
        <div class="vs-fb-section">
            <h3><i class="fa-solid fa-shield-halved"></i> <?php esc_html_e( 'Trust Row', 'visahouse' ); ?></h3>
            <div class="vs-fb-row"><label for="vs_footer_trust_label"><?php esc_html_e( 'Row label', 'visahouse' ); ?></label><div><input type="text" id="vs_footer_trust_label" name="vs_footer_trust_label" value="<?php echo esc_attr( $trust_label ?: 'Trusted by thousands' ); ?>"></div></div>

            <div class="vs-fb-repeater" id="vs-fb-trust">
                <?php foreach ( $trust_items as $i => $row ) :
                    $row = wp_parse_args( $row, array( 'label' => '', 'icon' => '' ) );
                    ?>
                    <div class="vs-fb-item vs-fb-item-trust">
                        <input type="text" name="vs_footer_trust_items[<?php echo (int) $i; ?>][label]" value="<?php echo esc_attr( $row['label'] ); ?>" placeholder="e.g. Gulf News">
                        <input type="text" name="vs_footer_trust_items[<?php echo (int) $i; ?>][icon]" value="<?php echo esc_attr( $row['icon'] ); ?>" placeholder="fa-newspaper">
                        <button type="button" class="vs-fb-remove"><span class="dashicons dashicons-no-alt"></span></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="vs-fb-add" data-target="vs-fb-trust" data-base="vs_footer_trust_items" data-template="trust"><i class="fa-solid fa-plus"></i> <?php esc_html_e( 'Add trust item', 'visahouse' ); ?></button>

            <div class="vs-fb-row" style="margin-top:16px;"><label for="vs_footer_google_rating"><?php esc_html_e( 'Google rating', 'visahouse' ); ?></label><div><input type="text" id="vs_footer_google_rating" name="vs_footer_google_rating" value="<?php echo esc_attr( $google_rating ?: '4.9' ); ?>" style="max-width:120px;"></div></div>
            <div class="vs-fb-row"><label for="vs_footer_google_url"><?php esc_html_e( 'Google reviews URL', 'visahouse' ); ?></label><div><input type="url" id="vs_footer_google_url" name="vs_footer_google_url" value="<?php echo esc_attr( $google_reviews_url ); ?>" placeholder="https://g.page/..."></div></div>
        </div>

        <!-- ==============================
             LEGAL STRIP
             ============================== -->
        <div class="vs-fb-section">
            <h3><i class="fa-solid fa-scale-balanced"></i> <?php esc_html_e( 'Legal Strip', 'visahouse' ); ?></h3>
            <div class="vs-fb-row"><label for="vs_footer_copyright"><?php esc_html_e( 'Copyright', 'visahouse' ); ?></label><div><input type="text" id="vs_footer_copyright" name="vs_footer_copyright" value="<?php echo esc_attr( $copyright ); ?>" placeholder="© 2026 VisaHouse.ae"></div></div>
            <div class="vs-fb-row"><label for="vs_footer_disclaimer"><?php esc_html_e( 'Disclaimer', 'visahouse' ); ?></label><div><textarea id="vs_footer_disclaimer" name="vs_footer_disclaimer"><?php echo esc_textarea( $disclaimer ); ?></textarea></div></div>

            <div class="vs-fb-repeater" id="vs-fb-legal">
                <?php foreach ( $legal as $i => $row ) :
                    $row = wp_parse_args( $row, array( 'label' => '', 'url' => '' ) );
                    ?>
                    <div class="vs-fb-item vs-fb-item-legal">
                        <input type="text" name="vs_footer_legal[<?php echo (int) $i; ?>][label]" value="<?php echo esc_attr( $row['label'] ); ?>" placeholder="Terms & Privacy">
                        <?php
                        if ( $has_picker ) {
                            vs_link_picker( "vs_footer_legal[{$i}][url]", $row['url'], 'Search or paste URL…' );
                        } else {
                            echo '<input type="text" name="vs_footer_legal[' . (int) $i . '][url]" value="' . esc_attr( $row['url'] ) . '" placeholder="/url/">';
                        }
                        ?>
                        <button type="button" class="vs-fb-remove"><span class="dashicons dashicons-no-alt"></span></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="vs-fb-add" data-target="vs-fb-legal" data-base="vs_footer_legal" data-template="legal"><i class="fa-solid fa-plus"></i> <?php esc_html_e( 'Add legal link', 'visahouse' ); ?></button>
        </div>

    </div>

    <script>
    (function () {
        'use strict';

        /* Re-number every input/select inside the repeater so names are sequential */
        function reindex(container, base) {
            var items = container.querySelectorAll('.vs-fb-item');
            items.forEach(function (item, i) {
                item.querySelectorAll('input, select').forEach(function (field) {
                    var name = field.getAttribute('name') || '';
                    name = name.replace(new RegExp(base + '\\[\\d+\\]'), base + '[' + i + ']');
                    field.setAttribute('name', name);
                });
            });
        }

        /* Build the markup for one picker row */
        function pickerHtml(name) {
            return '<div class="vs-lp" style="display:flex; gap: 8px; width: 100%;">' +
                '<input type="text" name="' + name + '" placeholder="Paste URL…" style="flex:1; width:100%;">' +
                '<select style="width: 120px; flex-shrink: 0; padding: 0 5px; font-size: 13px;" onchange="if(this.value) { this.previousElementSibling.value = this.value; this.value = \'\'; }">' +
                (window.vsLpOptions || '<option value="">+ Content</option>') +
                '</select></div>';
        }

        /* Build the markup for one repeater row */
        function makeRow(base, index, template) {
            var row = document.createElement('div');
            row.className = 'vs-fb-item' +
                (template === 'trust' ? ' vs-fb-item-trust' : '') +
                (template === 'legal' ? ' vs-fb-item-legal' : '');

            if (template === 'link') {
                row.innerHTML =
                    '<input type="text" name="' + base + '[' + index + '][label]" placeholder="Label">' +
                    pickerHtml(base + '[' + index + '][url]') +
                    '<input type="text" name="' + base + '[' + index + '][icon]" placeholder="fa-crown">' +
                    '<button type="button" class="vs-fb-remove"><span class="dashicons dashicons-no-alt"></span></button>';
            } else if (template === 'trust') {
                row.innerHTML =
                    '<input type="text" name="' + base + '[' + index + '][label]" placeholder="e.g. Gulf News">' +
                    '<input type="text" name="' + base + '[' + index + '][icon]" placeholder="fa-newspaper">' +
                    '<button type="button" class="vs-fb-remove"><span class="dashicons dashicons-no-alt"></span></button>';
            } else if (template === 'legal') {
                row.innerHTML =
                    '<input type="text" name="' + base + '[' + index + '][label]" placeholder="Terms & Privacy">' +
                    pickerHtml(base + '[' + index + '][url]') +
                    '<button type="button" class="vs-fb-remove"><span class="dashicons dashicons-no-alt"></span></button>';
            }

            return row;
        }

        /* Initialize any picker inside a container (called after rows are added) */
        function initPickersIn(container) {
            if (typeof window.vsLinkPickerInit !== 'function') return;
            container.querySelectorAll('.vs-lp').forEach(function (el) {
                window.vsLinkPickerInit(el);
            });
        }

        /* Add-link button */
        document.querySelectorAll('.vs-fb-add').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var targetId = btn.getAttribute('data-target');
                var base     = btn.getAttribute('data-base');
                var template = btn.getAttribute('data-template');
                var container = document.getElementById(targetId);
                if (!container) return;

                var row = makeRow(base, container.children.length, template);
                container.appendChild(row);
                initPickersIn(row);
            });
        });

        /* Remove button (delegated) */
        document.addEventListener('click', function (e) {
            var removeBtn = e.target.closest('.vs-fb-remove');
            if (!removeBtn) return;
            var row = removeBtn.closest('.vs-fb-item');
            if (!row) return;
            var container = row.parentNode;
            row.remove();

            /* Reindex remaining rows */
            var firstInput = container.querySelector('input, select');
            if (firstInput) {
                var name = firstInput.getAttribute('name') || '';
                var base = name.replace(/\[\d+\].*$/, '');
                reindex(container, base);
            }
        });
    })();
    </script>

    <?php
}

/* ============================================================
   SAVE
   ============================================================ */
function vs_footer_cpt_save( $post_id ) {
    if ( ! isset( $_POST['vs_footer_cpt_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['vs_footer_cpt_nonce'], 'vs_footer_cpt_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    /* Simple text fields */
    $simple = array(
        'vs_footer_brand_tagline', 'vs_footer_brand_desc',
        'vs_footer_services_title', 'vs_footer_company_title',
        'vs_footer_contact_title', 'vs_footer_contact_phone', 'vs_footer_contact_email',
        'vs_footer_contact_address', 'vs_footer_contact_hours',
        'vs_footer_trust_label', 'vs_footer_google_rating', 'vs_footer_google_url',
        'vs_footer_copyright', 'vs_footer_disclaimer',
    );
    foreach ( $simple as $key ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) ) );
        }
    }

    /* Socials */
    foreach ( array( 'facebook', 'instagram', 'tiktok', 'linkedin', 'youtube' ) as $key ) {
        $meta_key = "vs_social_{$key}";
        if ( isset( $_POST[ $meta_key ] ) ) {
            update_post_meta( $post_id, $meta_key, esc_url_raw( wp_unslash( $_POST[ $meta_key ] ) ) );
        }
    }

    /* Repeaters */
    $repeaters = array(
        'vs_footer_services'    => array( 'label', 'url', 'icon' ),
        'vs_footer_company'     => array( 'label', 'url', 'icon' ),
        'vs_footer_trust_items' => array( 'label', 'icon' ),
        'vs_footer_legal'       => array( 'label', 'url' ),
    );
    foreach ( $repeaters as $key => $fields ) {
        $rows = array();
        if ( isset( $_POST[ $key ] ) && is_array( $_POST[ $key ] ) ) {
            foreach ( wp_unslash( $_POST[ $key ] ) as $row ) {
                $clean = array();
                $empty = true;
                foreach ( $fields as $f ) {
                    $val = isset( $row[ $f ] ) ? $row[ $f ] : '';
                    $clean[ $f ] = ( 'url' === $f ) ? esc_url_raw( $val ) : sanitize_text_field( $val );
                    if ( '' !== $clean[ $f ] ) $empty = false;
                }
                if ( ! $empty ) $rows[] = $clean;
            }
        }
        if ( ! empty( $rows ) ) {
            update_post_meta( $post_id, $key, $rows );
        } else {
            delete_post_meta( $post_id, $key );
        }
    }
}
add_action( 'save_post_vs_footer', 'vs_footer_cpt_save' );

/* ============================================================
   ADMIN — friendly title placeholder
   ============================================================ */
function vs_footer_cpt_admin_title( $title ) {
    global $post_type;
    if ( 'vs_footer' === $post_type ) {
        return __( 'Footer (internal name — not shown on the site)', 'visahouse' );
    }
    return $title;
}
add_filter( 'enter_title_here', 'vs_footer_cpt_admin_title' );