<?php
/**
 * Services Modal — query helpers.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get all groups with their items, ordered.
 * Returns an array of arrays ready for the template.
 */
function vs_get_modal_groups() {
    $groups = get_terms( array(
        'taxonomy'   => 'vs_modal_group',
        'hide_empty' => true,
        'orderby'    => 'term_order',   // fallback to name if term_order missing
        'order'      => 'ASC',
    ) );

    if ( is_wp_error( $groups ) || empty( $groups ) ) {
        return array();
    }

    $result = array();

    foreach ( $groups as $group ) {
        $items_q = new WP_Query( array(
            'post_type'      => 'vs_modal_item',
            'posts_per_page' => 50,
            'orderby'        => array(
                'menu_order' => 'ASC',
                'title'      => 'ASC',
            ),
            'no_found_rows'  => true,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'vs_modal_group',
                    'field'    => 'term_id',
                    'terms'    => $group->term_id,
                ),
            ),
        ) );

        if ( ! $items_q->have_posts() ) {
            continue;
        }

        $items = array();

        foreach ( $items_q->posts as $post ) {
            $items[] = array(
                'id'    => $post->ID,
                'label' => get_the_title( $post ),
                'icon'  => get_post_meta( $post->ID, 'vs_item_icon', true ) ?: 'fa-star',
                'tint'  => get_post_meta( $post->ID, 'vs_item_tint', true ) ?: 'orange',
                'url'   => get_post_meta( $post->ID, 'vs_item_url',  true ) ?: '#',
            );
        }

        $result[] = array(
            'title'      => $group->name,
            'layout'     => get_term_meta( $group->term_id, 'vs_group_layout', true ) ?: 'list',
            'full_width' => get_term_meta( $group->term_id, 'vs_group_full_width', true ) === '1',
            'items'      => $items,
        );
    }

    return $result;
}

/**
 * Get modal text settings (title, subtitle, footer labels).
 * Stored as theme_mods so Polylang can translate them via Customizer.
 */
function vs_get_modal_text( $key, $default = '' ) {
    return get_theme_mod( $key, $default );
}
