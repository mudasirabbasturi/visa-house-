<?php
/**
 * Footer — Customizer fields.
 * All footer text and links, editable from Appearance → Customize → Footer.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vs_footer_customize_register( $wp_customize ) {

    /* ============================================================
       MAIN SECTION
       ============================================================ */
    $wp_customize->add_section( 'vs_footer', array(
        'title'    => __( 'Footer', 'visahouse' ),
        'priority' => 36,
    ) );

    /**
     * Helper — register a text field.
     */
    $add_text = function ( $key, $label, $default, $type = 'text', $section = 'vs_footer' ) use ( $wp_customize ) {
        $sanitize = 'sanitize_text_field';
        if ( 'textarea' === $type ) {
            $sanitize = 'sanitize_textarea_field';
        } elseif ( 'url' === $type ) {
            $sanitize = 'esc_url_raw';
        } elseif ( 'email' === $type ) {
            $sanitize = 'sanitize_email';
        } elseif ( 'html' === $type ) {
            $sanitize = 'wp_kses_post';
        }
        $wp_customize->add_setting( $key, array(
            'default'           => $default,
            'sanitize_callback' => $sanitize,
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $label,
            'section' => $section,
            'type'    => 'html' === $type ? 'text' : ( 'textarea' === $type ? 'textarea' : $type ),
        ) );
    };

    /* ============================================================
       BRAND COLUMN
       ============================================================ */
    $add_text( 'vs_footer_brand_tagline', __( 'Brand tagline', 'visahouse' ), 'Global Mobility Solutions' );
    $add_text( 'vs_footer_brand_desc', __( 'Brand description', 'visahouse' ), 'Your trusted partner for 100% online UAE visa processing — replacing the need for physical typing centre visits.', 'textarea' );

    /* ============================================================
       SERVICES COLUMN
       ============================================================ */
    $add_text( 'vs_footer_services_title', __( 'Services — column title', 'visahouse' ), 'Services' );

    $services_defaults = array(
        array( 'label' => 'Family Visa',   'url' => '/family-visa/',   'icon' => 'fa-people-roof' ),
        array( 'label' => 'Golden Visa',   'url' => '/golden-visa/',   'icon' => 'fa-crown' ),
        array( 'label' => 'Property Visa', 'url' => '/property-visa/', 'icon' => 'fa-building' ),
        array( 'label' => 'Newborn Visa',  'url' => '/newborn-visa/',  'icon' => 'fa-baby' ),
        array( 'label' => 'Maid Visa',     'url' => '/maid-visa/',     'icon' => 'fa-hand-sparkles' ),
    );
    for ( $i = 1; $i <= 5; $i++ ) {
        $d = $services_defaults[ $i - 1 ];
        $add_text( "vs_footer_services_{$i}_label", sprintf( __( 'Services #%d — label', 'visahouse' ), $i ), $d['label'] );
        $add_text( "vs_footer_services_{$i}_url",   sprintf( __( 'Services #%d — URL', 'visahouse' ), $i ),   $d['url'], 'url' );
        $add_text( "vs_footer_services_{$i}_icon",  sprintf( __( 'Services #%d — icon', 'visahouse' ), $i ),  $d['icon'] );
    }

    /* ============================================================
       COMPANY COLUMN
       ============================================================ */
    $add_text( 'vs_footer_company_title', __( 'Company — column title', 'visahouse' ), 'Company' );

    $company_defaults = array(
        array( 'label' => 'About Us',   'url' => '/about-us/',   'icon' => 'fa-building' ),
        array( 'label' => 'Articles',   'url' => '/articles/',   'icon' => 'fa-newspaper' ),
        array( 'label' => 'Career',     'url' => '/career/',     'icon' => 'fa-user-tie' ),
        array( 'label' => 'Contact Us', 'url' => '/contact-us/', 'icon' => 'fa-envelope' ),
        array( 'label' => 'FAQ',        'url' => '/faq/',        'icon' => 'fa-circle-question' ),
    );
    for ( $i = 1; $i <= 5; $i++ ) {
        $d = $company_defaults[ $i - 1 ];
        $add_text( "vs_footer_company_{$i}_label", sprintf( __( 'Company #%d — label', 'visahouse' ), $i ), $d['label'] );
        $add_text( "vs_footer_company_{$i}_url",   sprintf( __( 'Company #%d — URL', 'visahouse' ), $i ),   $d['url'], 'url' );
        $add_text( "vs_footer_company_{$i}_icon",  sprintf( __( 'Company #%d — icon', 'visahouse' ), $i ),  $d['icon'] );
    }

    /* ============================================================
       CONTACT COLUMN
       ============================================================ */
    $add_text( 'vs_footer_contact_title', __( 'Contact — column title', 'visahouse' ), 'Contact' );
    $add_text( 'vs_footer_contact_phone',   __( 'Contact — phone', 'visahouse' ),   '800 DOCS (3627)' );
    $add_text( 'vs_footer_contact_email',   __( 'Contact — email', 'visahouse' ),   'info@visahouse.ae', 'email' );
    $add_text( 'vs_footer_contact_address', __( 'Contact — address', 'visahouse' ), 'Business Village, Deira' );
    $add_text( 'vs_footer_contact_hours',   __( 'Contact — hours', 'visahouse' ),   'Sun–Thu · 9am–6pm' );

    /* ============================================================
       SOCIAL LINKS
       ============================================================ */
    $socials = array(
        'facebook'  => 'Facebook URL',
        'instagram' => 'Instagram URL',
        'tiktok'    => 'TikTok URL',
        'linkedin'  => 'LinkedIn URL',
        'youtube'   => 'YouTube URL',
    );
    foreach ( $socials as $key => $label ) {
        $add_text( "vs_social_{$key}", $label, '', 'url' );
    }

    /* ============================================================
       TRUST ROW
       ============================================================ */
    $add_text( 'vs_footer_trust_label', __( 'Trust row label', 'visahouse' ), 'Trusted by thousands' );

    $trust_defaults = array(
        array( 'label' => 'Gulf News',     'icon' => 'fa-newspaper' ),
        array( 'label' => 'Khaleej Times', 'icon' => 'fa-newspaper' ),
        array( 'label' => 'DET Licensed',  'icon' => 'fa-shield-halved' ),
    );
    for ( $i = 1; $i <= 3; $i++ ) {
        $d = $trust_defaults[ $i - 1 ];
        $add_text( "vs_footer_trust_{$i}_label", sprintf( __( 'Trust #%d — label', 'visahouse' ), $i ), $d['label'] );
        $add_text( "vs_footer_trust_{$i}_icon",  sprintf( __( 'Trust #%d — icon', 'visahouse' ), $i ),  $d['icon'] );
    }

    /* ============================================================
       LEGAL STRIP
       ============================================================ */
    $add_text( 'vs_footer_copyright',  __( 'Copyright text', 'visahouse' ),  '© 2026 VisaHouse.ae. All rights reserved.' );
    $add_text( 'vs_footer_disclaimer', __( 'Legal disclaimer', 'visahouse' ), 'VisaHouse.ae is operated by 800 DOCS LLC SOC, a private third-party service provider. We are not a government authority.', 'textarea' );

    $legal_defaults = array(
        array( 'label' => 'Terms & Privacy', 'url' => '/terms-privacy/' ),
        array( 'label' => 'Sitemap',         'url' => '/sitemap/' ),
        array( 'label' => 'Contact',         'url' => '/contact-us/' ),
    );
    for ( $i = 1; $i <= 3; $i++ ) {
        $d = $legal_defaults[ $i - 1 ];
        $add_text( "vs_footer_legal_{$i}_label", sprintf( __( 'Legal #%d — label', 'visahouse' ), $i ), $d['label'] );
        $add_text( "vs_footer_legal_{$i}_url",   sprintf( __( 'Legal #%d — URL', 'visahouse' ), $i ),   $d['url'], 'url' );
    }
}
add_action( 'customize_register', 'vs_footer_customize_register' );