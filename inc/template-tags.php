<?php
/**
 * Template tags.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Reading time in minutes.
 */
function vs_reading_time( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $content = get_post_field( 'post_content', $post_id );
    $words   = str_word_count( wp_strip_all_tags( $content ) );
    return max( 1, (int) ceil( $words / 200 ) );
}

/**
 * Get a theme mod with fallback.
 */
function vs_option( $key, $default = '' ) {
    $val = get_theme_mod( $key, null );
    return ( $val !== null && $val !== '' ) ? $val : $default;
}

/**
 * Alias for vs_option() — kept for compatibility.
 */
function vs_mod( $key, $default = '' ) {
    return vs_option( $key, $default );
}

/**
 * Post meta helper with fallback.
 */
function vs_meta( $key, $post_id = null, $default = '' ) {
    $post_id = $post_id ?: get_the_ID();
    $val     = get_post_meta( $post_id, $key, true );
    return ( $val !== null && $val !== '' ) ? $val : $default;
}

/**
 * Skip link.
 */
function vs_skip_link() {
    echo '<a class="vs-skip-link" href="#vs-main">' . esc_html__( 'Skip to content', 'visahouse' ) . '</a>';
}
add_action( 'wp_body_open', 'vs_skip_link', 5 );

/**
 * Language code (Polylang safe).
 */
function vs_current_lang() {
    if ( function_exists( 'pll_current_language' ) ) {
        return pll_current_language();
    }
    return substr( get_locale(), 0, 2 );
}

/**
 * Logo initials.
 */
function vs_logo_initials() {
    $name = trim( wp_strip_all_tags( get_bloginfo( 'name' ) ) );
    if ( '' === $name ) {
        return 'VS';
    }
    $parts = preg_split( '/\s+/', $name );
    if ( count( $parts ) >= 2 ) {
        return strtoupper( mb_substr( $parts[0], 0, 1 ) . mb_substr( $parts[1], 0, 1 ) );
    }
    return strtoupper( mb_substr( $name, 0, 2 ) );
}

/**
 * Get the blog archive page URL.
 * Looks for a page with the "Articles Archive" template, or falls back by slug.
 */
function vs_get_blog_url() {
    // 1. Find a page using the "page-articles.php" template
    $template_pages = get_pages( array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-articles.php',
        'number'     => 1,
    ) );

    if ( ! empty( $template_pages ) ) {
        return get_permalink( $template_pages[0]->ID );
    }

    // 2. Fall back to common slugs
    foreach ( array( 'articles', 'blog', 'insights', 'news' ) as $slug ) {
        $page = get_page_by_path( $slug );
        if ( $page ) {
            return get_permalink( $page );
        }
    }

    // 3. Last resort — homepage
    return home_url( '/' );
}
