<?php
/**
 * Customizer — extended with Typography, Colors, and Appearance.
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

    /* ============================================================
       TYPOGRAPHY
       ============================================================ */
    $wp_customize->add_section( 'vs_typography', array(
        'title'    => __( 'VisaHouse — Typography', 'visahouse' ),
        'priority' => 40,
    ) );

    $font_choices = array(
        'Adobe Clean'                => 'Adobe Clean',
        'Adobe Clean Semi Condensed' => 'Adobe Clean Semi Condensed',
        'Manrope'                    => 'Manrope',
        'system-ui'                  => 'System UI',
        'custom'                     => 'Custom…',
    );

    // Fonts
    foreach ( array( 'body', 'heading', 'paragraph', 'link' ) as $type ) {
        $wp_customize->add_setting( "vs_font_{$type}", array(
            'default' => 'Adobe Clean',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "vs_font_{$type}", array(
            'label'   => "Font Family: " . ucfirst($type),
            'section' => 'vs_typography',
            'type'    => 'select',
            'choices' => $font_choices,
        ) );
        // Custom Font Input
        $wp_customize->add_setting( "vs_font_{$type}_custom", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "vs_font_{$type}_custom", array(
            'label'   => "Custom Font Family (" . ucfirst($type) . ")",
            'section' => 'vs_typography',
            'type'    => 'text',
        ) );
    }

    // Sizes
    $sizes = array(
        'body' => [16, 16, 22], 'body_mobile' => [15, 14, 20],
        'h1' => [48, 28, 72], 'h2' => [36, 24, 56], 'h3' => [24, 18, 40], 'h4' => [20, 16, 32],
        'p' => [16, 14, 22], 'a' => [16, 14, 22]
    );
    foreach ( $sizes as $key => $cfg ) {
        $wp_customize->add_setting( "vs_font_size_{$key}", array(
            'default' => $cfg[0],
            'sanitize_callback' => 'absint',
        ) );
        $wp_customize->add_control( "vs_font_size_{$key}", array(
            'label'   => "Font Size: " . strtoupper($key) . " (px)",
            'section' => 'vs_typography',
            'type'    => 'number',
            'input_attrs' => array('min' => $cfg[1], 'max' => $cfg[2], 'step' => 1),
        ) );
    }

    // Weights & Line Heights
    $wp_customize->add_setting( 'vs_weight_body', array( 'default' => '400', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'vs_weight_body', array( 'label' => 'Weight: Body', 'section' => 'vs_typography', 'type' => 'select', 'choices' => array('300'=>'300', '400'=>'400', '500'=>'500', '600'=>'600', '700'=>'700') ) );
    
    $wp_customize->add_setting( 'vs_weight_heading', array( 'default' => '700', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'vs_weight_heading', array( 'label' => 'Weight: Heading', 'section' => 'vs_typography', 'type' => 'select', 'choices' => array('400'=>'400', '500'=>'500', '600'=>'600', '700'=>'700', '800'=>'800') ) );
    
    $wp_customize->add_setting( 'vs_weight_link', array( 'default' => '600', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'vs_weight_link', array( 'label' => 'Weight: Link', 'section' => 'vs_typography', 'type' => 'select', 'choices' => array('400'=>'400', '500'=>'500', '600'=>'600', '700'=>'700', '800'=>'800') ) );

    $wp_customize->add_setting( 'vs_line_height_body', array( 'default' => 1.6, 'sanitize_callback' => 'vs_sanitize_float' ) );
    $wp_customize->add_control( 'vs_line_height_body', array( 'label' => 'Line Height: Body', 'section' => 'vs_typography', 'type' => 'number', 'input_attrs' => array('min'=>1.0,'max'=>2.0,'step'=>0.05) ) );

    $wp_customize->add_setting( 'vs_line_height_heading', array( 'default' => 1.15, 'sanitize_callback' => 'vs_sanitize_float' ) );
    $wp_customize->add_control( 'vs_line_height_heading', array( 'label' => 'Line Height: Heading', 'section' => 'vs_typography', 'type' => 'number', 'input_attrs' => array('min'=>1.0,'max'=>2.0,'step'=>0.05) ) );

    $wp_customize->add_setting( 'vs_letter_spacing_heading', array( 'default' => '-.025em', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'vs_letter_spacing_heading', array( 'label' => 'Letter Spacing: Heading', 'section' => 'vs_typography', 'type' => 'text' ) );


    /* ============================================================
       COLORS
       ============================================================ */
    $wp_customize->add_section( 'vs_colors', array(
        'title'    => __( 'VisaHouse — Colors', 'visahouse' ),
        'priority' => 41,
    ) );

    $wp_customize->add_setting( 'vs_color_preset', array(
        'default' => 'brand',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'vs_color_preset', array(
        'label'   => 'Color Preset',
        'section' => 'vs_colors',
        'type'    => 'radio',
        'choices' => array(
            'brand'  => 'Brand (Default)',
            'ocean'  => 'Ocean',
            'forest' => 'Forest',
            'slate'  => 'Slate',
            'violet' => 'Violet',
            'sunset' => 'Sunset',
            'rose'   => 'Rose',
            'custom' => 'Custom',
        ),
    ) );

    $wp_customize->add_setting( 'vs_color_primary', array( 'default' => '#0A1F3D', 'sanitize_callback' => 'sanitize_hex_color' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_primary', array( 'label' => 'Primary Color', 'section' => 'vs_colors' ) ) );

    $wp_customize->add_setting( 'vs_color_accent', array( 'default' => '#C2410C', 'sanitize_callback' => 'sanitize_hex_color' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_accent', array( 'label' => 'Accent Color', 'section' => 'vs_colors' ) ) );

    $wp_customize->add_setting( 'vs_color_accent_hover', array( 'default' => '#9A3309', 'sanitize_callback' => 'sanitize_hex_color' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_accent_hover', array( 'label' => 'Accent Hover Color', 'section' => 'vs_colors' ) ) );

    /* ============================================================
       APPEARANCE
       ============================================================ */
    $wp_customize->add_section( 'vs_appearance', array(
        'title'    => __( 'VisaHouse — Appearance', 'visahouse' ),
        'priority' => 42,
    ) );

    $wp_customize->add_setting( 'vs_color_mode', array(
        'default' => 'light',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'vs_color_mode', array(
        'label'   => 'Color Mode',
        'section' => 'vs_appearance',
        'type'    => 'radio',
        'choices' => array(
            'light' => 'Light (Default)',
            'dark'  => 'Dark',
            'auto'  => 'Auto (Follow OS)',
        ),
    ) );

    $dark_colors = array(
        'vs_dark_surface'   => '#0B1220',
        'vs_dark_surface_2' => '#131C2E',
        'vs_dark_line'      => '#1F2A44',
        'vs_dark_ink'       => '#E2E8F0',
        'vs_dark_ink_2'     => '#94A3B8',
        'vs_dark_paper'     => '#050A14',
    );
    foreach ( $dark_colors as $key => $default ) {
        $wp_customize->add_setting( $key, array( 'default' => $default, 'sanitize_callback' => 'sanitize_hex_color' ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, array( 'label' => 'Dark Mode: ' . str_replace('Vs Dark ', '', ucwords(str_replace('_', ' ', $key))), 'section' => 'vs_appearance' ) ) );
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

function vs_sanitize_float( $value ) {
    return (float) $value;
}