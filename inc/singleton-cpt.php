<?php
/**
 * Singleton CPT helpers.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return the single post for a CPT in the current language, or 0 if none.
 * Polylang-aware: if Polylang is active, only returns posts in the current language.
 */
function vs_singleton_get_post( $post_type ) {
    $args = array(
        'post_type'      => $post_type,
        'post_status'    => array( 'publish', 'draft', 'private' ),
        'posts_per_page' => 1,
        'orderby'        => 'ID',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    );

    if ( function_exists( 'pll_current_language' ) ) {
        $args['lang'] = pll_current_language();
    }

    $q = new WP_Query( $args );
    return $q->have_posts() ? (int) $q->posts[0]->ID : 0;
}

/**
 * Hide "Add New" submenu link when at least one post already exists.
 */
function vs_singleton_hide_add_new() {
    global $submenu;

    foreach ( array( 'vs_about', 'vs_footer', 'vs_steps' ) as $post_type ) {
        if ( ! isset( $submenu[ 'edit.php?post_type=' . $post_type ] ) ) {
            continue;
        }
        if ( vs_singleton_get_post( $post_type ) ) {
            foreach ( $submenu[ 'edit.php?post_type=' . $post_type ] as $i => $item ) {
                if ( isset( $item[2] ) && 'post-new.php?post_type=' . $post_type === $item[2] ) {
                    unset( $submenu[ 'edit.php?post_type=' . $post_type ][ $i ] );
                }
            }
        }
    }
}
add_action( 'admin_menu', 'vs_singleton_hide_add_new', 999 );

/**
 * Remove the "Trash" and "Quick Edit" row actions to protect the singleton.
 */
function vs_singleton_row_actions( $actions, $post ) {
    if ( in_array( $post->post_type, array( 'vs_about', 'vs_footer', 'vs_steps' ), true ) ) {
        unset( $actions['trash'] );
        unset( $actions['inline hide-if-no-js'] );
    }
    return $actions;
}
add_filter( 'post_row_actions', 'vs_singleton_row_actions', 10, 2 );