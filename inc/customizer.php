<?php
/**
 * Customizer — all homepage text fields.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vs_customize_register( $wp_customize ) {

    /* ============================================================
       GLOBAL
       ============================================================ */
    $wp_customize->add_section( 'vs_global', array(
        'title'    => __( 'VisaHouse — Global', 'visahouse' ),
        'priority' => 30,
    ) );

    $global_fields = array(
        'vs_whatsapp'       => array( 'label' => 'WhatsApp number (digits + country code)', 'default' => '9718003627', 'type' => 'text' ),
        'vs_google_rating'  => array( 'label' => 'Google rating',                            'default' => '4.9',        'type' => 'text' ),
        'vs_phone'          => array( 'label' => 'Phone (display)',                          'default' => '800 DOCS (3627)', 'type' => 'text' ),
        'vs_email'          => array( 'label' => 'Email',                                    'default' => 'info@visahouse.ae', 'type' => 'email' ),
        'vs_address'        => array( 'label' => 'Address',                                  'default' => 'Business Village, Deira', 'type' => 'text' ),
    );
    foreach ( $global_fields as $key => $cfg ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $cfg['default'],
            'sanitize_callback' => 'vs_sanitize_text_or_email',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $cfg['label'],
            'section' => 'vs_global',
            'type'    => $cfg['type'],
        ) );
    }

    /* ============================================================
       HERO
       ============================================================ */
    $wp_customize->add_section( 'vs_hero', array(
        'title'    => __( 'Homepage — Hero', 'visahouse' ),
        'priority' => 31,
    ) );

    $hero_fields = array(
        'vs_hero_badge'  => array( 'label' => 'Badge text',  'default' => 'DET-Licensed Provider', 'html' => false ),
        'vs_hero_title'  => array( 'label' => 'Title (HTML allowed, use <em>)', 'default' => "Your family's UAE visa, <em>done for you</em>.", 'html' => true ),
        'vs_hero_sub'    => array( 'label' => 'Subtitle',    'default' => 'Sponsor your spouse, children, or parents. Exact government fees in under 30 seconds — then we handle the whole application from your phone.', 'html' => false ),
        'vs_hero_foot'   => array( 'label' => 'Footline',    'default' => 'Free calculator · Itemized government fees · No signup', 'html' => false ),
        'vs_trust_label' => array( 'label' => 'Trust bar label', 'default' => 'Trusted by thousands', 'html' => false ),
    );
    foreach ( $hero_fields as $key => $cfg ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $cfg['default'],
            'sanitize_callback' => $cfg['html'] ? 'wp_kses_post' : 'sanitize_text_field',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $cfg['label'],
            'section' => 'vs_hero',
            'type'    => 'text',
        ) );
    }

    /* ============================================================
       ABOUT
       ============================================================ */
    $wp_customize->add_section( 'vs_about', array(
        'title'    => __( 'Homepage — About', 'visahouse' ),
        'priority' => 32,
    ) );

    $about_text_fields = array(
        'vs_about_title'  => array( 'label' => 'Title (HTML allowed, use <em>)', 'default' => 'We are <em>800 DOCS</em> — on your side.', 'html' => true ),
        'vs_about_text'   => array( 'label' => 'About text', 'default' => '800 DOCS LLC SOC is the private, licensed documentation company behind VisaHouse.ae. We check your eligibility free, file every application correctly through official GDRFA and ICP channels, and follow it up until your family\'s Emirates IDs are in your hand.', 'html' => true ),
        'vs_stat_1_value' => array( 'label' => 'Stat 1 — Value', 'default' => '20,000+', 'html' => false ),
        'vs_stat_1_label' => array( 'label' => 'Stat 1 — Label', 'default' => 'Visas processed', 'html' => false ),
        'vs_stat_2_value' => array( 'label' => 'Stat 2 — Value', 'default' => '4.9 ★', 'html' => false ),
        'vs_stat_2_label' => array( 'label' => 'Stat 2 — Label', 'default' => 'Rated on Google', 'html' => false ),
        'vs_stat_3_value' => array( 'label' => 'Stat 3 — Value', 'default' => '100%', 'html' => false ),
        'vs_stat_3_label' => array( 'label' => 'Stat 3 — Label', 'default' => 'Online from start to finish', 'html' => false ),
    );
    foreach ( $about_text_fields as $key => $cfg ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $cfg['default'],
            'sanitize_callback' => $cfg['html'] ? 'wp_kses_post' : 'sanitize_text_field',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $cfg['label'],
            'section' => 'vs_about',
            'type'    => 'text',
        ) );
    }

    // About image
    $wp_customize->add_setting( 'vs_about_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'vs_about_image', array(
        'label'   => __( 'About image', 'visahouse' ),
        'section' => 'vs_about',
    ) ) );

    /* ============================================================
       CTA
       ============================================================ */
    $wp_customize->add_section( 'vs_cta', array(
        'title'    => __( 'Homepage — Final CTA', 'visahouse' ),
        'priority' => 33,
    ) );

    $wp_customize->add_setting( 'vs_cta_title', array(
        'default'           => 'Ready to bring your family together?',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'vs_cta_title', array(
        'label'   => __( 'CTA title', 'visahouse' ),
        'section' => 'vs_cta',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'vs_cta_text', array(
        'default'           => 'Calculate your exact government fees, or send us a message — a family visa specialist replies on WhatsApp within minutes.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'vs_cta_text', array(
        'label'   => __( 'CTA text', 'visahouse' ),
        'section' => 'vs_cta',
        'type'    => 'textarea',
    ) );

    /* ============================================================
       STEPS (4 fixed steps)
       ============================================================ */
    $wp_customize->add_section( 'vs_steps', array(
        'title'    => __( 'Homepage — Steps', 'visahouse' ),
        'priority' => 34,
    ) );

    $step_defaults = array(
        1 => array(
            'badge'      => 'Step 01',
            'number'     => '1',
            'title'      => 'Check Cost & Eligibility',
            'text'       => 'Use our free calculator to see exact government fees for your family member. No signup, no hidden charges.',
            'visual'     => 'Instant estimate',
            'visual_sub' => 'in under 30 seconds',
        ),
        2 => array(
            'badge'      => 'Step 02',
            'number'     => '2',
            'title'      => 'Share Documents',
            'text'       => 'Send photos of passports and certificates on WhatsApp. We verify everything to GDRFA & ICP standards.',
            'visual'     => '100% mobile',
            'visual_sub' => 'no office visit needed',
        ),
        3 => array(
            'badge'      => 'Step 03',
            'number'     => '3',
            'title'      => 'We File & Follow Up',
            'text'       => 'Entry permit, status change, and visa stamping — submitted and tracked by our team with updates at every stage.',
            'visual'     => '5–10 working days',
            'visual_sub' => 'for a new visa',
        ),
        4 => array(
            'badge'      => 'Step 04',
            'number'     => '4',
            'title'      => 'Medical & Emirates ID',
            'text'       => 'We book the medical fitness test and biometrics appointment. Emirates ID delivered to your door.',
            'visual'     => 'Door delivery',
            'visual_sub' => 'of Emirates ID',
        ),
    );

    for ( $i = 1; $i <= 4; $i++ ) {
        $d = $step_defaults[ $i ];
        $fields = array(
            "vs_step_{$i}_badge"      => array( 'label' => "Step {$i} — Badge",           'default' => $d['badge'] ),
            "vs_step_{$i}_number"     => array( 'label' => "Step {$i} — Big number",      'default' => $d['number'] ),
            "vs_step_{$i}_title"      => array( 'label' => "Step {$i} — Title",           'default' => $d['title'] ),
            "vs_step_{$i}_visual"     => array( 'label' => "Step {$i} — Visual bold line",'default' => $d['visual'] ),
            "vs_step_{$i}_visual_sub" => array( 'label' => "Step {$i} — Visual sub line", 'default' => $d['visual_sub'] ),
        );
        foreach ( $fields as $key => $cfg ) {
            $wp_customize->add_setting( $key, array(
                'default'           => $cfg['default'],
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( $key, array(
                'label'   => $cfg['label'],
                'section' => 'vs_steps',
                'type'    => 'text',
            ) );
        }
        // Textarea for text
        $wp_customize->add_setting( "vs_step_{$i}_text", array(
            'default'           => $d['text'],
            'sanitize_callback' => 'sanitize_textarea_field',
        ) );
        $wp_customize->add_control( "vs_step_{$i}_text", array(
            'label'   => "Step {$i} — Description",
            'section' => 'vs_steps',
            'type'    => 'textarea',
        ) );
    }

    /* ============================================================
       SERVICES MODAL
       ============================================================ */
    $wp_customize->add_section( 'vs_modal', array(
        'title'    => __( 'Services Modal', 'visahouse' ),
        'priority' => 35,
    ) );

    $modal_fields = array(
        'vs_modal_title'      => array( 'label' => 'Modal title',        'default' => 'VisaHouse.ae' ),
        'vs_modal_subtitle'   => array( 'label' => 'Modal subtitle',     'default' => 'All services in one place' ),
        'vs_modal_calc_label' => array( 'label' => 'Calculator label',   'default' => 'Visa Calculator' ),
        'vs_modal_calc_url'   => array( 'label' => 'Calculator URL',     'default' => '#calculator' ),
        'vs_modal_wa_label'   => array( 'label' => 'WhatsApp label',     'default' => 'WhatsApp' ),
    );
    foreach ( $modal_fields as $key => $cfg ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $cfg['default'],
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $cfg['label'],
            'section' => 'vs_modal',
            'type'    => 'text',
        ) );
    }
}
add_action( 'customize_register', 'vs_customize_register' );

/**
 * Custom sanitizer — allows text or email.
 */
function vs_sanitize_text_or_email( $value ) {
    if ( is_email( $value ) ) {
        return sanitize_email( $value );
    }
    return sanitize_text_field( $value );
}