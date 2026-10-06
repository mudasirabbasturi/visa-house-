<?php
/**
 * Enqueue styles & scripts.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vs_enqueue_assets() {

    /* FONTS */
    wp_enqueue_style(
        'vs-adobe-clean',
        VS_URI . '/assets/css/fonts.css',
        array(),
        VS_VERSION
    );

    wp_enqueue_style(
        'vs-font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    /* MAIN — contains EVERYTHING (base + hero + modal-services + footer) */
    wp_enqueue_style(
        'vs-main',
        VS_URI . '/assets/css/main.css',
        array( 'vs-adobe-clean', 'vs-font-awesome' ),
        VS_VERSION
    );

    wp_enqueue_style(
        'vs-style',
        get_stylesheet_uri(),
        array( 'vs-main' ),
        VS_VERSION
    );

    /* RTL — loaded last, overrides everything */
    if ( is_rtl() ) {
        wp_enqueue_style(
            'vs-rtl',
            VS_URI . '/assets/css/rtl.css',
            array( 'vs-main', 'vs-style' ),
            VS_VERSION
        );
    }

    /* SCRIPTS — single bundled main.js (includes services modal + everything) */
    wp_enqueue_script(
        'vs-main',
        VS_URI . '/assets/js/main.js',
        array(),
        VS_VERSION,
        true
    );

    wp_localize_script( 'vs-main', 'vsData', array(
        'whatsapp' => get_theme_mod( 'vs_whatsapp', '9718003627' ),
        'homeUrl'  => esc_url( home_url( '/' ) ),
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'i18n'     => array(
            'calculating' => __( 'Calculating…', 'visahouse' ),
            'error'       => __( 'Something went wrong. Please try again.', 'visahouse' ),
        ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'vs_enqueue_assets' );

function vs_resource_hints( $hints, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $hints[] = 'https://cdnjs.cloudflare.com';
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'vs_resource_hints', 10, 2 );

function vs_comment_reply() {
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'vs_comment_reply' );