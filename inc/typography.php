<?php
/**
 * Dynamic CSS generator for Typography, Colors, and Appearance settings.
 * Outputs via wp_head.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vs_hex_to_rgba( $color, $opacity = false ) {
    $default = 'rgb(0,0,0)';
    if ( empty( $color ) ) return $default;
    if ( $color[0] == '#' ) {
        $color = substr( $color, 1 );
    }
    if ( strlen( $color ) == 6 ) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }
    $rgb =  array_map( 'hexdec', $hex );
    if ( $opacity !== false ) {
        if ( abs( $opacity ) > 1 ) $opacity = 1.0;
        $output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode( ",", $rgb ) . ')';
    }
    return $output;
}

function vs_output_typography_css() {
    // Fonts
    $f_body = get_theme_mod( 'vs_font_body', 'Adobe Clean' ) === 'custom' ? get_theme_mod( 'vs_font_body_custom' ) : get_theme_mod( 'vs_font_body', 'Adobe Clean' );
    $f_heading = get_theme_mod( 'vs_font_heading', 'Adobe Clean' ) === 'custom' ? get_theme_mod( 'vs_font_heading_custom' ) : get_theme_mod( 'vs_font_heading', 'Adobe Clean' );
    
    // Colors
    $c_primary = get_theme_mod( 'vs_color_primary', '#0A1F3D' );
    $c_accent  = get_theme_mod( 'vs_color_accent', '#C2410C' );
    $c_accent_hover = get_theme_mod( 'vs_color_accent_hover', '#9A3309' );
    $c_accent_soft = vs_hex_to_rgba( $c_accent, 0.07 );
    $c_accent_soft_2 = vs_hex_to_rgba( $c_accent, 0.03 );


    ?>
    <style id="vs-typography-css">
        :root {
            --font-family: <?php echo esc_attr( $f_body ); ?>;
            --font-heading: <?php echo esc_attr( $f_heading ); ?>;
            --primary: <?php echo esc_attr( $c_primary ); ?>;
            --accent: <?php echo esc_attr( $c_accent ); ?>;
            --accent-hover: <?php echo esc_attr( $c_accent_hover ); ?>;
            --accent-grad: linear-gradient(135deg, <?php echo esc_attr( $c_accent ); ?> 0%, <?php echo esc_attr( $c_accent_hover ); ?> 100%);
            --accent-soft: <?php echo esc_attr( $c_accent_soft ); ?>;
            --accent-soft-2: <?php echo esc_attr( $c_accent_soft_2 ); ?>;
        }

        /* Hero v2 Override */
        .hv2-hero, .hv2-root {
            --primary: <?php echo esc_attr( $c_primary ); ?>;
            --accent: <?php echo esc_attr( $c_accent ); ?>;
            --font-family: <?php echo esc_attr( $f_body ); ?>;
        }

        body { font-family: var(--font-family); font-size: <?php echo (int) get_theme_mod('vs_font_size_body', 16); ?>px; line-height: <?php echo (float) get_theme_mod('vs_line_height_body', 1.6); ?>; font-weight: <?php echo esc_attr( get_theme_mod('vs_weight_body', '400') ); ?>; }
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-heading); font-weight: <?php echo esc_attr( get_theme_mod('vs_weight_heading', '700') ); ?>; line-height: <?php echo (float) get_theme_mod('vs_line_height_heading', 1.15); ?>; letter-spacing: <?php echo esc_attr( get_theme_mod('vs_letter_spacing_heading', '-.025em') ); ?>; }
        h1 { font-size: <?php echo (int) get_theme_mod('vs_font_size_h1', 48); ?>px; }
        h2 { font-size: <?php echo (int) get_theme_mod('vs_font_size_h2', 36); ?>px; }
        h3 { font-size: <?php echo (int) get_theme_mod('vs_font_size_h3', 24); ?>px; }
        h4 { font-size: <?php echo (int) get_theme_mod('vs_font_size_h4', 20); ?>px; }
        p { font-size: <?php echo (int) get_theme_mod('vs_font_size_p', 16); ?>px; }
        a { font-weight: <?php echo esc_attr( get_theme_mod('vs_weight_link', '600') ); ?>; font-size: <?php echo (int) get_theme_mod('vs_font_size_a', 16); ?>px; }
        
        @media (max-width: 768px) {
            body { font-size: <?php echo (int) get_theme_mod('vs_font_size_body_mobile', 15); ?>px; }
        }

        <?php
        // Desktop logo height
        $logo_h = (int) get_theme_mod( 'vs_logo_height', 48 );
        echo '.vs-logo-img { max-height: ' . $logo_h . 'px; width: auto; }';

        // Mobile logo height
        $logo_h_mob = (int) get_theme_mod( 'vs_logo_height_mobile', 36 );
        echo ' @media (max-width:768px) { .vs-logo-img { max-height: ' . $logo_h_mob . 'px; width: auto; } }';
        ?>
    </style>
    <?php
}
add_action( 'wp_head', 'vs_output_typography_css', 99 );
