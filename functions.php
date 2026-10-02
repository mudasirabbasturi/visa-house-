<?php
/**
 * VisaHouse theme bootstrap.
 *
 * @package VisaHouse
 * @author  Mudasir Abbas
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'VS_VERSION', '1.0.0' );
define( 'VS_DIR', get_template_directory() );
define( 'VS_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function vs_setup() {
    load_theme_textdomain( 'visahouse', VS_DIR . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'comment-list', 'comment-form' ) );

    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    register_nav_menus( array(
        'primary' => __( 'Main Menu', 'visahouse' ),
    ) );

    add_image_size( 'vs-blog-card', 600, 375, true );
    add_image_size( 'vs-hero', 900, 600, true );
    add_image_size( 'vs-about', 800, 600, true );
    add_image_size( 'vs-service-card', 400, 300, true );
}
add_action( 'after_setup_theme', 'vs_setup' );

/**
 * Content width.
 */
function vs_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'vs_content_width', 1200 );
}
add_action( 'after_setup_theme', 'vs_content_width', 0 );

/**
 * Includes — NO ACF anywhere.
 */
require_once VS_DIR . '/inc/enqueue.php';
require_once VS_DIR . '/inc/cpt.php';
require_once VS_DIR . '/inc/service-meta.php';
require_once VS_DIR . '/inc/review-meta.php';
require_once VS_DIR . '/inc/customizer.php';
require_once VS_DIR . '/inc/typography.php'; // NEW INCLUDE
require_once VS_DIR . '/inc/template-tags.php';
require_once VS_DIR . '/inc/class-vs-walker-nav.php';
require_once VS_DIR . '/inc/modal-cpt.php';
require_once VS_DIR . '/inc/modal-admin.php';
require_once VS_DIR . '/inc/modal-helpers.php';
require_once VS_DIR . '/inc/services-modal.php';
require_once VS_DIR . '/inc/menu-icons.php';
require_once VS_DIR . '/inc/service-category-meta.php';

require_once VS_DIR . '/inc/singleton-cpt.php';
require_once VS_DIR . '/inc/about-cpt.php';
require_once VS_DIR . '/inc/footer-cpt.php';
require_once VS_DIR . '/inc/link-picker.php';

/**
 * Body classes.
 */
function vs_body_classes( $classes ) {
    if ( is_front_page() ) {
        $classes[] = 'vs-home';
    }
    if ( is_singular() ) {
        $classes[] = 'vs-singular';
    }
    if ( is_rtl() ) {
        $classes[] = 'vs-rtl';
    }
    return $classes;
}
add_filter( 'body_class', 'vs_body_classes' );

/**
 * Excerpt length.
 */
function vs_excerpt_length( $length ) {
    return 22;
}
add_filter( 'excerpt_length', 'vs_excerpt_length', 999 );

function vs_excerpt_more( $more ) {
    return '…';
}
add_filter( 'excerpt_more', 'vs_excerpt_more' );

/**
 * Disable emoji bloat.
 */
function vs_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'vs_disable_emojis' );

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );