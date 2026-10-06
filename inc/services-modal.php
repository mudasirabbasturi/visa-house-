<?php
/**
 * Services Modal — helpers only (CSS + JS now live in main.css / main.js).
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Shortcode: [vs_services_button label="Services"]
 */
function vs_services_button_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'label' => __( 'Services', 'visahouse' ),
        'class' => 'vs-btn vs-btn-outline',
        'icon'  => 'fa-solid fa-grip',
    ), $atts, 'vs_services_button' );

    return sprintf(
        '<button type="button" class="%s" data-vs-open="services"><i class="%s"></i> %s</button>',
        esc_attr( $atts['class'] ),
        esc_attr( $atts['icon'] ),
        esc_html( $atts['label'] )
    );
}
add_shortcode( 'vs_services_button', 'vs_services_button_shortcode' );

/**
 * Helper: trigger URL for menus.
 */
function vs_services_trigger_url() {
    return '#vs-services-modal';
}

/**
 * Helper: render trigger button inline.
 */
function vs_services_button( $label = 'Services', $class = 'vs-btn vs-btn-outline', $icon = 'fa-solid fa-grip' ) {
    printf(
        '<button type="button" class="%s" data-vs-open="services"><i class="%s"></i> %s</button>',
        esc_attr( $class ),
        esc_attr( $icon ),
        esc_html( $label )
    );
}