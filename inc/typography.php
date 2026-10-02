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

    $mode = get_theme_mod( 'vs_color_mode', 'light' );
    $dark_css = "
        --paper: " . get_theme_mod( 'vs_dark_paper', '#050A14' ) . ";
        --surface: " . get_theme_mod( 'vs_dark_surface', '#0B1220' ) . ";
        --surface-2: " . get_theme_mod( 'vs_dark_surface_2', '#131C2E' ) . ";
        --line: " . get_theme_mod( 'vs_dark_line', '#1F2A44' ) . ";
        --line-soft: #162034;
        --ink: " . get_theme_mod( 'vs_dark_ink', '#E2E8F0' ) . ";
        --ink-2: " . get_theme_mod( 'vs_dark_ink_2', '#94A3B8' ) . ";
        --ink-3: #64748B;
        --ink-4: #475569;
    ";

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

        <?php if ( $mode === 'dark' ) : ?>
        :root, body.vs-theme-dark {
            <?php echo $dark_css; ?>
        }
        .hv2-hero {
            <?php echo $dark_css; ?>
        }
        <?php elseif ( $mode === 'auto' ) : ?>
        @media (prefers-color-scheme: dark) {
            :root { <?php echo $dark_css; ?> }
            .hv2-hero { <?php echo $dark_css; ?> }
        }
        <?php endif; ?>
        
        /* Explicit mode class for toggles */
        body.vs-theme-dark, body.vs-theme-dark .hv2-hero {
            <?php echo $dark_css; ?>
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
    </style>
    <?php
}
add_action( 'wp_head', 'vs_output_typography_css', 99 );
