<?php
/**
 * Home Steps — singleton CPT.
 * One post per language. Meta box holds 4 step rows.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ============================================================
   REGISTER CPT
   ============================================================ */
function vs_register_steps_cpt() {
    register_post_type( 'vs_steps', array(
        'labels' => array(
            'name'          => __( 'Home Steps', 'visahouse' ),
            'singular_name' => __( 'Home Steps', 'visahouse' ),
            'menu_name'     => __( 'Home Steps', 'visahouse' ),
            'edit_item'     => __( 'Edit Home Steps', 'visahouse' ),
            'view_item'     => __( 'View Home Steps', 'visahouse' ),
            'all_items'     => __( 'Home Steps', 'visahouse' ),
            'add_new_item'  => __( 'Create Home Steps', 'visahouse' ),
            'new_item'      => __( 'Home Steps', 'visahouse' ),
            'not_found'     => __( 'No Home Steps content yet.', 'visahouse' ),
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-list-view',
        'menu_position'      => 24,
        'supports'           => array( 'title' ),
        'rewrite'            => false,
        'capability_type'    => 'post',
    ) );
}
add_action( 'init', 'vs_register_steps_cpt', 5 );

/* ============================================================
   POLYLANG — enable translation
   ============================================================ */
function vs_polylang_steps_cpt( $post_types, $is_settings ) {
    $post_types['vs_steps'] = 'vs_steps';
    return $post_types;
}
add_filter( 'pll_get_post_types', 'vs_polylang_steps_cpt', 10, 2 );

/* ============================================================
   META BOX
   ============================================================ */
function vs_steps_cpt_meta_box() {
    add_meta_box(
        'vs_steps_fields',
        __( 'Steps Content (4 steps)', 'visahouse' ),
        'vs_steps_cpt_meta_box_render',
        'vs_steps',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'vs_steps_cpt_meta_box' );

function vs_steps_cpt_meta_box_render( $post ) {
    wp_nonce_field( 'vs_steps_cpt_save', 'vs_steps_cpt_nonce' );

    // Section header fields
    $sec_label    = get_post_meta( $post->ID, 'vs_steps_label',    true ) ?: 'How It Works';
    $sec_title    = get_post_meta( $post->ID, 'vs_steps_title',    true ) ?: 'Everything handled %s.';
    $sec_title_em = get_post_meta( $post->ID, 'vs_steps_title_em', true ) ?: '100% online';

    $defaults = array(
        1 => array( 'badge' => 'Step 01', 'number' => '1', 'title' => 'Check Cost & Eligibility',   'text' => 'Use our free calculator to see exact government fees for your family member. No signup, no hidden charges.',          'visual' => 'Instant estimate', 'visual_sub' => 'in under 30 seconds' ),
        2 => array( 'badge' => 'Step 02', 'number' => '2', 'title' => 'Share Documents',             'text' => 'Send photos of passports and certificates on WhatsApp. We verify everything to GDRFA & ICP standards.',            'visual' => '100% mobile',      'visual_sub' => 'no office visit needed' ),
        3 => array( 'badge' => 'Step 03', 'number' => '3', 'title' => 'We File & Follow Up',         'text' => 'Entry permit, status change, and visa stamping — submitted and tracked by our team with updates at every stage.', 'visual' => '5–10 working days', 'visual_sub' => 'for a new visa' ),
        4 => array( 'badge' => 'Step 04', 'number' => '4', 'title' => 'Medical & Emirates ID',       'text' => 'We book the medical fitness test and biometrics appointment. Emirates ID delivered to your door.',                'visual' => 'Door delivery',    'visual_sub' => 'of Emirates ID' ),
    );
    ?>
    <style>
        .vs-st-wrap  { max-width: 860px; }
        .vs-st-header { border: 1px solid #BAE6FD; border-radius: 8px; padding: 18px 20px; margin-bottom: 20px; background: #F0F9FF; }
        .vs-st-header h4 { margin: 0 0 14px; font-size: 13px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; color: #0369A1; }
        .vs-st-step  { border: 1px solid #E2E8F0; border-radius: 8px; padding: 18px 20px; margin-bottom: 16px; background: #FAFAFA; }
        .vs-st-step h4 { margin: 0 0 14px; font-size: 13px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; color: #C2410C; }
        .vs-st-grid  { display: grid; grid-template-columns: 160px 1fr; gap: 10px 16px; align-items: center; }
        .vs-st-grid label { font-weight: 600; font-size: 13px; }
        .vs-st-grid input[type=text], .vs-st-grid textarea { width: 100%; padding: 7px 10px; border: 1px solid #CBD5E1; border-radius: 5px; font-size: 13px; font-family: inherit; box-sizing: border-box; }
        .vs-st-grid textarea { min-height: 70px; resize: vertical; }
        .vs-st-row2  { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .vs-st-desc  { font-size: 12px; color: #64748B; margin-top: 3px; }
    </style>

    <div class="vs-st-wrap">

        <!-- Section header -->
        <div class="vs-st-header">
            <h4><?php esc_html_e( 'Section Header', 'visahouse' ); ?></h4>
            <div class="vs-st-grid">

                <label for="vs_steps_label"><?php esc_html_e( 'Label (small pill)', 'visahouse' ); ?></label>
                <div>
                    <input type="text" id="vs_steps_label" name="vs_steps_label" value="<?php echo esc_attr( $sec_label ); ?>" placeholder="How It Works">
                    <p class="vs-st-desc"><?php esc_html_e( 'The small badge above the heading, e.g. "How It Works".', 'visahouse' ); ?></p>
                </div>

                <label for="vs_steps_title"><?php esc_html_e( 'Heading', 'visahouse' ); ?></label>
                <div>
                    <input type="text" id="vs_steps_title" name="vs_steps_title" value="<?php echo esc_attr( $sec_title ); ?>" placeholder="Everything handled %s.">
                    <p class="vs-st-desc"><?php esc_html_e( 'Use %s where the highlighted word should appear. E.g. "Everything handled %s."', 'visahouse' ); ?></p>
                </div>

                <label for="vs_steps_title_em"><?php esc_html_e( 'Highlighted word', 'visahouse' ); ?></label>
                <div>
                    <input type="text" id="vs_steps_title_em" name="vs_steps_title_em" value="<?php echo esc_attr( $sec_title_em ); ?>" placeholder="100% online">
                    <p class="vs-st-desc"><?php esc_html_e( 'Replaces %s in the heading — rendered in orange italic.', 'visahouse' ); ?></p>
                </div>

            </div>
        </div>
        <?php for ( $i = 1; $i <= 4; $i++ ) :
            $d          = $defaults[ $i ];
            $badge      = get_post_meta( $post->ID, "vs_step_{$i}_badge",      true ) ?: $d['badge'];
            $number     = get_post_meta( $post->ID, "vs_step_{$i}_number",     true ) ?: $d['number'];
            $title      = get_post_meta( $post->ID, "vs_step_{$i}_title",      true ) ?: $d['title'];
            $text       = get_post_meta( $post->ID, "vs_step_{$i}_text",       true ) ?: $d['text'];
            $visual     = get_post_meta( $post->ID, "vs_step_{$i}_visual",     true ) ?: $d['visual'];
            $visual_sub = get_post_meta( $post->ID, "vs_step_{$i}_visual_sub", true ) ?: $d['visual_sub'];
        ?>
        <div class="vs-st-step">
            <h4><?php printf( esc_html__( 'Step %d', 'visahouse' ), $i ); ?></h4>
            <div class="vs-st-grid">

                <label><?php esc_html_e( 'Badge label', 'visahouse' ); ?></label>
                <input type="text" name="vs_step_<?php echo $i; ?>_badge" value="<?php echo esc_attr( $badge ); ?>" placeholder="<?php echo esc_attr( $d['badge'] ); ?>">

                <label><?php esc_html_e( 'Big number', 'visahouse' ); ?></label>
                <input type="text" name="vs_step_<?php echo $i; ?>_number" value="<?php echo esc_attr( $number ); ?>" placeholder="<?php echo $i; ?>">

                <label><?php esc_html_e( 'Title', 'visahouse' ); ?></label>
                <input type="text" name="vs_step_<?php echo $i; ?>_title" value="<?php echo esc_attr( $title ); ?>" placeholder="<?php echo esc_attr( $d['title'] ); ?>">

                <label><?php esc_html_e( 'Description', 'visahouse' ); ?></label>
                <textarea name="vs_step_<?php echo $i; ?>_text"><?php echo esc_textarea( $text ); ?></textarea>

                <label><?php esc_html_e( 'Visual line', 'visahouse' ); ?></label>
                <div class="vs-st-row2">
                    <input type="text" name="vs_step_<?php echo $i; ?>_visual"     value="<?php echo esc_attr( $visual ); ?>"     placeholder="<?php echo esc_attr( $d['visual'] ); ?>">
                    <input type="text" name="vs_step_<?php echo $i; ?>_visual_sub" value="<?php echo esc_attr( $visual_sub ); ?>" placeholder="<?php echo esc_attr( $d['visual_sub'] ); ?>">
                </div>

            </div>
        </div>
        <?php endfor; ?>
    </div>
    <?php
}

/* ============================================================
   SAVE META
   ============================================================ */
function vs_steps_cpt_save( $post_id ) {
    if ( ! isset( $_POST['vs_steps_cpt_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['vs_steps_cpt_nonce'], 'vs_steps_cpt_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // Section header fields
    $header_fields = array( 'vs_steps_label', 'vs_steps_title', 'vs_steps_title_em' );
    foreach ( $header_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
        }
    }

    for ( $i = 1; $i <= 4; $i++ ) {
        $text_fields = array( "vs_step_{$i}_badge", "vs_step_{$i}_number", "vs_step_{$i}_title", "vs_step_{$i}_visual", "vs_step_{$i}_visual_sub" );
        foreach ( $text_fields as $field ) {
            if ( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
            }
        }
        if ( isset( $_POST["vs_step_{$i}_text"] ) ) {
            update_post_meta( $post_id, "vs_step_{$i}_text", sanitize_textarea_field( wp_unslash( $_POST["vs_step_{$i}_text"] ) ) );
        }
    }
}
add_action( 'save_post_vs_steps', 'vs_steps_cpt_save' );

/* ============================================================
   ADMIN — rename title placeholder
   ============================================================ */
function vs_steps_cpt_admin_title( $title ) {
    global $post_type;
    if ( 'vs_steps' === $post_type ) {
        return __( 'Home Steps (internal name — not shown on the site)', 'visahouse' );
    }
    return $title;
}
add_filter( 'enter_title_here', 'vs_steps_cpt_admin_title' );
