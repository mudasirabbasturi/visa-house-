<?php
/**
 * Custom Post Types & Taxonomies.
 * Registered on init priority 5 so Polylang detects them.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vs_register_cpts() {

    /* ---------------------------------------------------------
     * SERVICE
     * --------------------------------------------------------- */
    register_post_type( 'service', array(
        'labels' => array(
            'name'          => __( 'Services', 'visahouse' ),
            'singular_name' => __( 'Service', 'visahouse' ),
            'add_new_item'  => __( 'Add New Service', 'visahouse' ),
            'edit_item'     => __( 'Edit Service', 'visahouse' ),
            'all_items'     => __( 'All Services', 'visahouse' ),
            'menu_name'     => __( 'Services', 'visahouse' ),
            'search_items'  => __( 'Search Services', 'visahouse' ),
            'not_found'     => __( 'No services found.', 'visahouse' ),
        ),
        'public'        => true,
        'has_archive'   => 'services',
        'rewrite'       => array( 'slug' => 'services', 'with_front' => false ),
        'menu_icon'     => 'dashicons-portfolio',
        'menu_position' => 20,
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
        'show_in_rest'  => true,
        'hierarchical'  => false,
        'show_in_nav_menus' => true,
        'show_ui'       => true,
    ) );

    register_taxonomy( 'service_category', 'service', array(
        'labels' => array(
            'name'          => __( 'Service Categories', 'visahouse' ),
            'singular_name' => __( 'Service Category', 'visahouse' ),
        ),
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'service-category' ),
    ) );

    /* ---------------------------------------------------------
     * REVIEW
     * --------------------------------------------------------- */
    register_post_type( 'review', array(
        'labels' => array(
            'name'          => __( 'Reviews', 'visahouse' ),
            'singular_name' => __( 'Review', 'visahouse' ),
            'add_new_item'  => __( 'Add New Review', 'visahouse' ),
            'edit_item'     => __( 'Edit Review', 'visahouse' ),
            'all_items'     => __( 'All Reviews', 'visahouse' ),
            'menu_name'     => __( 'Reviews', 'visahouse' ),
        ),
        'public'        => false,
        'show_ui'       => true,
        'menu_icon'     => 'dashicons-star-filled',
        'menu_position' => 21,
        'supports'      => array( 'title', 'editor', 'page-attributes' ),
        'show_in_rest'  => true,
    ) );

    /* ---------------------------------------------------------
     * FAQ
     * --------------------------------------------------------- */
    register_post_type( 'faq', array(
        'labels' => array(
            'name'          => __( 'FAQs', 'visahouse' ),
            'singular_name' => __( 'FAQ', 'visahouse' ),
            'add_new_item'  => __( 'Add New FAQ', 'visahouse' ),
            'edit_item'     => __( 'Edit FAQ', 'visahouse' ),
            'all_items'     => __( 'All FAQs', 'visahouse' ),
            'menu_name'     => __( 'FAQs', 'visahouse' ),
        ),
        'public'        => false,
        'show_ui'       => true,
        'menu_icon'     => 'dashicons-editor-help',
        'menu_position' => 22,
        'supports'      => array( 'title', 'editor', 'page-attributes' ),
        'show_in_rest'  => true,
    ) );

    register_taxonomy( 'faq_category', 'faq', array(
        'labels' => array(
            'name'          => __( 'FAQ Categories', 'visahouse' ),
            'singular_name' => __( 'FAQ Category', 'visahouse' ),
        ),
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
    ) );
}
add_action( 'init', 'vs_register_cpts', 5 );

/**
 * Polylang — enable translation for CPTs.
 */
function vs_polylang_cpts( $post_types, $is_settings ) {
    $post_types['service'] = 'service';
    $post_types['review']  = 'review';
    $post_types['faq']     = 'faq';
    return $post_types;
}
add_filter( 'pll_get_post_types', 'vs_polylang_cpts', 10, 2 );

/**
 * Polylang — enable translation for taxonomies.
 */
function vs_polylang_taxes( $taxonomies, $is_settings ) {
    $taxonomies['service_category'] = 'service_category';
    $taxonomies['faq_category']     = 'faq_category';
    return $taxonomies;
}
add_filter( 'pll_get_taxonomies', 'vs_polylang_taxes', 10, 2 );
