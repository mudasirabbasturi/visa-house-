<?php
/**
 * Customizer — Logo, Colors & Typography.
 *
 * Professional panel-based customizer architecture with live preview.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Custom range-slider control for the Customizer.
 */
if ( class_exists( 'WP_Customize_Control' ) ) :
class VS_Range_Control extends WP_Customize_Control {
    public $type = 'vs-range';
    public $unit = 'px';

    public function enqueue() {
        add_action( 'customize_controls_print_styles', function() {
            echo '<style>
                .customize-control-vs-range .vs-range-row { display: flex; align-items: center; gap: 8px; margin-top: 8px; width: 100%; }
                .customize-control-vs-range .vs-range-row input[type="range"] { flex: 1 1 auto !important; width: auto !important; min-width: 0 !important; max-width: none !important; height: 4px !important; margin: 0 !important; padding: 0 !important; accent-color: #2563EB; cursor: pointer; background: transparent; -webkit-appearance: auto !important; appearance: auto !important; }
                .customize-control-vs-range .vs-range-row input[type="number"] { flex: 0 0 54px !important; width: 54px !important; min-width: 54px !important; max-width: 54px !important; height: 30px !important; padding: 2px 4px !important; border: 1px solid #c3c4c7 !important; border-radius: 4px !important; font-size: 12px !important; line-height: 1.2 !important; text-align: center; background: #fff !important; color: #1e1e1e !important; box-shadow: none !important; margin: 0 !important; -moz-appearance: textfield; }
                .customize-control-vs-range .vs-range-row input[type="number"]::-webkit-outer-spin-button, .customize-control-vs-range .vs-range-row input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
                .customize-control-vs-range .vs-range-row .vs-ru { flex: 0 0 auto; font-size: 11px; color: #888; line-height: 1; }
            </style>';
        }, 2 );
    }

    public function render_content() {
        $attrs = $this->input_attrs;
        $min   = isset( $attrs['min'] )  ? (float) $attrs['min']  : 0;
        $max   = isset( $attrs['max'] )  ? (float) $attrs['max']  : 100;
        $step  = isset( $attrs['step'] ) ? (float) $attrs['step'] : 1;
        $val   = (float) $this->value();
        $id    = 'vs-range-' . esc_attr( $this->id );
        $link  = $this->get_link();
        ?>
        <?php if ( $this->label ) : ?>
            <label for="<?php echo $id; ?>"><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span></label>
        <?php endif; ?>
        <?php if ( $this->description ) : ?>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
        <?php endif; ?>
        <div class="vs-range-row">
            <input type="range" id="<?php echo $id; ?>" min="<?php echo $min; ?>" max="<?php echo $max; ?>" step="<?php echo $step; ?>" value="<?php echo esc_attr( $val ); ?>" <?php echo $link; ?> oninput="document.getElementById('<?php echo $id; ?>-num').value=this.value">
            <input type="number" id="<?php echo $id; ?>-num" min="<?php echo $min; ?>" max="<?php echo $max; ?>" step="<?php echo $step; ?>" value="<?php echo esc_attr( $val ); ?>" oninput="var r=document.getElementById('<?php echo $id; ?>');r.value=this.value;r.dispatchEvent(new Event('input'));">
            <span class="vs-ru"><?php echo esc_html( $this->unit ); ?></span>
        </div>
        <?php
    }
}
endif;

/**
 * List of selectable font families.
 */
function vs_get_font_choices() {
    return array(
        '"Adobe Clean", system-ui, -apple-system, "Segoe UI", sans-serif' => __( 'Adobe Clean (Theme Default)', 'visahouse' ),
        '"Avenir LT Std", "Helvetica Neue", sans-serif'                   => __( 'Avenir LT Std (Local WOFF2)', 'visahouse' ),
        'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif' => __( 'System Default (San Francisco / Segoe)', 'visahouse' ),
        '"Inter", -apple-system, BlinkMacSystemFont, sans-serif'          => __( 'Inter', 'visahouse' ),
        '"Roboto", sans-serif'                                            => __( 'Roboto', 'visahouse' ),
        '"Plus Jakarta Sans", sans-serif'                                 => __( 'Plus Jakarta Sans', 'visahouse' ),
        '"Playfair Display", Georgia, serif'                              => __( 'Playfair Display (Serif)', 'visahouse' ),
        '"Pacifico", cursive'                                             => __( 'Pacifico (Display)', 'visahouse' ),
        '"Caveat", cursive'                                               => __( 'Caveat (Handwriting)', 'visahouse' ),
        '"Great Vibes", cursive'                                          => __( 'Great Vibes (Script)', 'visahouse' ),
        '"Kalam", cursive'                                                => __( 'Kalam', 'visahouse' ),
        '"Amatic SC", cursive'                                            => __( 'Amatic SC (Caps Display)', 'visahouse' ),
        '"Indie Flower", cursive'                                         => __( 'Indie Flower', 'visahouse' ),
        '"Patrick Hand", cursive'                                         => __( 'Patrick Hand', 'visahouse' ),
        '"Rock Salt", cursive'                                            => __( 'Rock Salt', 'visahouse' ),
    );
}

/**
 * Register customizer panels, sections, and controls.
 */
function vs_customize_register( $wp_customize ) {

    /* ============================================================
       0. LOGO SIZE (in Site Identity)
       ============================================================ */
    $wp_customize->add_setting( 'vs_logo_height', array(
        'default'           => 48,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new VS_Range_Control( $wp_customize, 'vs_logo_height', array(
        'label'       => __( 'Logo height — Desktop (px)', 'visahouse' ),
        'section'     => 'title_tagline',
        'input_attrs' => array( 'min' => 20, 'max' => 120, 'step' => 1 ),
    ) ) );

    $wp_customize->add_setting( 'vs_logo_height_mobile', array(
        'default'           => 36,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new VS_Range_Control( $wp_customize, 'vs_logo_height_mobile', array(
        'label'       => __( 'Logo height — Mobile (px)', 'visahouse' ),
        'section'     => 'title_tagline',
        'input_attrs' => array( 'min' => 16, 'max' => 80, 'step' => 1 ),
    ) ) );

    /* ============================================================
       MAIN THEME OPTIONS PANEL
       ============================================================ */
    $wp_customize->add_panel( 'vs_theme_options', array(
        'title'       => __( 'VisaHouse Theme Settings', 'visahouse' ),
        'description' => __( 'Manage global colors, typography, header, and footer styling.', 'visahouse' ),
        'priority'    => 25,
    ) );

    /* ------------------------------------------------------------
       1. GLOBAL BRAND COLORS
       ------------------------------------------------------------ */
    $wp_customize->add_section( 'vs_colors_global', array(
        'title'    => __( 'Global Brand Colors', 'visahouse' ),
        'panel'    => 'vs_theme_options',
        'priority' => 10,
    ) );

    // Primary
    $wp_customize->add_setting( 'vs_color_primary', array(
        'default'           => '#0A1F3D',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_primary', array(
        'label'    => __( 'Primary Brand Color', 'visahouse' ),
        'section'  => 'vs_colors_global',
    ) ) );

    // Primary Light
    $wp_customize->add_setting( 'vs_color_primary_light', array(
        'default'           => '#1E3A5F',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_primary_light', array(
        'label'    => __( 'Primary Light (Hover / Gradients)', 'visahouse' ),
        'section'  => 'vs_colors_global',
    ) ) );

    // Accent
    $wp_customize->add_setting( 'vs_color_accent', array(
        'default'           => '#2563EB',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_accent', array(
        'label'    => __( 'Accent / Button Color', 'visahouse' ),
        'section'  => 'vs_colors_global',
    ) ) );

    // Accent Hover
    $wp_customize->add_setting( 'vs_color_accent_hover', array(
        'default'           => '#1D4ED8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_accent_hover', array(
        'label'    => __( 'Accent Hover', 'visahouse' ),
        'section'  => 'vs_colors_global',
    ) ) );

    // Gold / Highlight
    $wp_customize->add_setting( 'vs_color_gold', array(
        'default'           => '#C9A227',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_gold', array(
        'label'    => __( 'Gold Highlight (Stars & Badges)', 'visahouse' ),
        'section'  => 'vs_colors_global',
    ) ) );

    // Body Background
    $wp_customize->add_setting( 'vs_color_body_bg', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_body_bg', array(
        'label'    => __( 'Site Body Background', 'visahouse' ),
        'section'  => 'vs_colors_global',
    ) ) );

    // Text / Ink
    $wp_customize->add_setting( 'vs_color_ink', array(
        'default'           => '#0A1F3D',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_ink', array(
        'label'    => __( 'Primary Text / Ink Color', 'visahouse' ),
        'section'  => 'vs_colors_global',
    ) ) );

    /* ------------------------------------------------------------
       2. HEADER & NAVIGATION COLORS
       ------------------------------------------------------------ */
    $wp_customize->add_section( 'vs_colors_header', array(
        'title'    => __( 'Header & Navigation Colors', 'visahouse' ),
        'panel'    => 'vs_theme_options',
        'priority' => 20,
    ) );

    // Header Background
    $wp_customize->add_setting( 'vs_color_header_bg', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_header_bg', array(
        'label'    => __( 'Header Background', 'visahouse' ),
        'section'  => 'vs_colors_header',
    ) ) );

    // Nav Link
    $wp_customize->add_setting( 'vs_color_nav_link', array(
        'default'           => '#475569',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_nav_link', array(
        'label'    => __( 'Menu Link Color', 'visahouse' ),
        'section'  => 'vs_colors_header',
    ) ) );

    // Nav Link Hover
    $wp_customize->add_setting( 'vs_color_nav_link_hover', array(
        'default'           => '#0A1F3D',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_nav_link_hover', array(
        'label'    => __( 'Menu Link Hover', 'visahouse' ),
        'section'  => 'vs_colors_header',
    ) ) );

    // Nav Link Active
    $wp_customize->add_setting( 'vs_color_nav_link_active', array(
        'default'           => '#2563EB',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_nav_link_active', array(
        'label'    => __( 'Menu Link Active', 'visahouse' ),
        'section'  => 'vs_colors_header',
    ) ) );

    /* ------------------------------------------------------------
       3. FOOTER COLORS
       ------------------------------------------------------------ */
    $wp_customize->add_section( 'vs_colors_footer', array(
        'title'    => __( 'Footer Colors', 'visahouse' ),
        'panel'    => 'vs_theme_options',
        'priority' => 30,
    ) );

    // Footer BG
    $wp_customize->add_setting( 'vs_color_footer_bg', array(
        'default'           => '#0A1F3D',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_footer_bg', array(
        'label'    => __( 'Footer Background', 'visahouse' ),
        'section'  => 'vs_colors_footer',
    ) ) );

    // Footer Text
    $wp_customize->add_setting( 'vs_color_footer_text', array(
        'default'           => '#B3C5D8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_footer_text', array(
        'label'    => __( 'Footer Text Color', 'visahouse' ),
        'section'  => 'vs_colors_footer',
    ) ) );

    // Footer Link
    $wp_customize->add_setting( 'vs_color_footer_link', array(
        'default'           => '#B3C5D8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_footer_link', array(
        'label'    => __( 'Footer Link Color', 'visahouse' ),
        'section'  => 'vs_colors_footer',
    ) ) );

    // Footer Link Hover
    $wp_customize->add_setting( 'vs_color_footer_link_hover', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_footer_link_hover', array(
        'label'    => __( 'Footer Link Hover', 'visahouse' ),
        'section'  => 'vs_colors_footer',
    ) ) );

    // Footer Social Hover
    $wp_customize->add_setting( 'vs_color_footer_social_hover', array(
        'default'           => '#2563EB',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_footer_social_hover', array(
        'label'    => __( 'Footer Social Icon Hover', 'visahouse' ),
        'section'  => 'vs_colors_footer',
    ) ) );

    /* ------------------------------------------------------------
       4. TYPOGRAPHY
       ------------------------------------------------------------ */
    $wp_customize->add_section( 'vs_typography', array(
        'title'    => __( 'Typography', 'visahouse' ),
        'panel'    => 'vs_theme_options',
        'priority' => 40,
    ) );

    $font_choices = vs_get_font_choices();

    // Body Font Family
    $wp_customize->add_setting( 'vs_font_family', array(
        'default'           => '"Adobe Clean", system-ui, -apple-system, "Segoe UI", sans-serif',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'vs_font_family', array(
        'label'    => __( 'Body Font Family', 'visahouse' ),
        'section'  => 'vs_typography',
        'type'     => 'select',
        'choices'  => $font_choices,
    ) );

    // Headings Font Family
    $wp_customize->add_setting( 'vs_font_heading', array(
        'default'           => '"Adobe Clean", system-ui, -apple-system, "Segoe UI", sans-serif',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'vs_font_heading', array(
        'label'    => __( 'Headings Font Family (h1 - h6)', 'visahouse' ),
        'section'  => 'vs_typography',
        'type'     => 'select',
        'choices'  => $font_choices,
    ) );

    // Body Font Size
    $wp_customize->add_setting( 'vs_font_body_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new VS_Range_Control( $wp_customize, 'vs_font_body_size', array(
        'label'       => __( 'Body Font Size (px)', 'visahouse' ),
        'section'     => 'vs_typography',
        'unit'        => 'px',
        'input_attrs' => array( 'min' => 12, 'max' => 24, 'step' => 1 ),
    ) ) );

    // Body Line Height
    $wp_customize->add_setting( 'vs_font_body_line_height', array(
        'default'           => 1.6,
        'sanitize_callback' => function( $val ) { return (float) $val; },
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new VS_Range_Control( $wp_customize, 'vs_font_body_line_height', array(
        'label'       => __( 'Body Line Height', 'visahouse' ),
        'section'     => 'vs_typography',
        'unit'        => 'em',
        'input_attrs' => array( 'min' => 1.2, 'max' => 2.2, 'step' => 0.05 ),
    ) ) );

    // Headings Weight
    $wp_customize->add_setting( 'vs_font_heading_weight', array(
        'default'           => '700',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'vs_font_heading_weight', array(
        'label'   => __( 'Headings Font Weight', 'visahouse' ),
        'section' => 'vs_typography',
        'type'    => 'select',
        'choices' => array(
            '400' => __( '400 — Regular', 'visahouse' ),
            '500' => __( '500 — Medium', 'visahouse' ),
            '600' => __( '600 — Semi Bold', 'visahouse' ),
            '700' => __( '700 — Bold', 'visahouse' ),
            '800' => __( '800 — Extra Bold', 'visahouse' ),
            '900' => __( '900 — Black', 'visahouse' ),
        ),
    ) );

    // Headings Text Transform
    $wp_customize->add_setting( 'vs_font_heading_transform', array(
        'default'           => 'none',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'vs_font_heading_transform', array(
        'label'   => __( 'Headings Text Transform', 'visahouse' ),
        'section' => 'vs_typography',
        'type'    => 'select',
        'choices' => array(
            'none'       => __( 'Normal (None)', 'visahouse' ),
            'capitalize' => __( 'Capitalize Words', 'visahouse' ),
            'uppercase'  => __( 'UPPERCASE', 'visahouse' ),
        ),
    ) );

}
add_action( 'customize_register', 'vs_customize_register' );

/**
 * Compile dynamic CSS tokens for frontend and preview.
 */
function vs_get_customizer_css() {
    $css = ':root {';

    // Global Brand
    $primary       = get_theme_mod( 'vs_color_primary', '#0A1F3D' );
    $primary_light = get_theme_mod( 'vs_color_primary_light', '#1E3A5F' );
    $accent        = get_theme_mod( 'vs_color_accent', '#2563EB' );
    $accent_hover  = get_theme_mod( 'vs_color_accent_hover', '#1D4ED8' );
    $gold          = get_theme_mod( 'vs_color_gold', '#C9A227' );
    $body_bg       = get_theme_mod( 'vs_color_body_bg', '#FFFFFF' );
    $ink           = get_theme_mod( 'vs_color_ink', '#0A1F3D' );

    $css .= '--primary:' . esc_attr( $primary ) . ';';
    $css .= '--primary-light:' . esc_attr( $primary_light ) . ';';
    $css .= '--accent:' . esc_attr( $accent ) . ';';
    $css .= '--accent-hover:' . esc_attr( $accent_hover ) . ';';
    $css .= '--btn-bg:' . esc_attr( $accent ) . ';';
    $css .= '--btn-hover:' . esc_attr( $accent_hover ) . ';';
    $css .= '--read-more:' . esc_attr( $accent ) . ';';
    $css .= '--gold:' . esc_attr( $gold ) . ';';
    $css .= '--body-bg:' . esc_attr( $body_bg ) . ';';
    $css .= '--ink:' . esc_attr( $ink ) . ';';

    // Header
    $header_bg   = get_theme_mod( 'vs_color_header_bg', '#FFFFFF' );
    $nav_link    = get_theme_mod( 'vs_color_nav_link', '#475569' );
    $nav_hover   = get_theme_mod( 'vs_color_nav_link_hover', '#0A1F3D' );
    $nav_active  = get_theme_mod( 'vs_color_nav_link_active', '#2563EB' );

    $css .= '--header-bg:' . esc_attr( $header_bg ) . ';';
    $css .= '--nav-bg:' . esc_attr( $header_bg ) . ';';
    $css .= '--nav-link:' . esc_attr( $nav_link ) . ';';
    $css .= '--nav-link-hover:' . esc_attr( $nav_hover ) . ';';
    $css .= '--nav-link-active:' . esc_attr( $nav_active ) . ';';

    // Footer
    $footer_bg     = get_theme_mod( 'vs_color_footer_bg', '#0A1F3D' );
    $footer_text   = get_theme_mod( 'vs_color_footer_text', '#B3C5D8' );
    $footer_link   = get_theme_mod( 'vs_color_footer_link', '#B3C5D8' );
    $footer_hover  = get_theme_mod( 'vs_color_footer_link_hover', '#FFFFFF' );
    $social_hover  = get_theme_mod( 'vs_color_footer_social_hover', '#2563EB' );

    $css .= '--footer-bg:' . esc_attr( $footer_bg ) . ';';
    $css .= '--footer-text:' . esc_attr( $footer_text ) . ';';
    $css .= '--footer-link:' . esc_attr( $footer_link ) . ';';
    $css .= '--footer-link-hover:' . esc_attr( $footer_hover ) . ';';
    $css .= '--footer-social-hover:' . esc_attr( $social_hover ) . ';';

    // Typography
    $font_body      = get_theme_mod( 'vs_font_family', '"Adobe Clean", system-ui, -apple-system, "Segoe UI", sans-serif' );
    $font_heading   = get_theme_mod( 'vs_font_heading', '"Adobe Clean", system-ui, -apple-system, "Segoe UI", sans-serif' );
    $font_size      = get_theme_mod( 'vs_font_body_size', 16 );
    $line_height    = get_theme_mod( 'vs_font_body_line_height', 1.6 );
    $heading_weight = get_theme_mod( 'vs_font_heading_weight', '700' );
    $heading_trans  = get_theme_mod( 'vs_font_heading_transform', 'none' );

    $css .= '--font-family:' . $font_body . ';';
    $css .= '--font-bold:' . $font_body . ';';
    $css .= '--font-light:' . $font_body . ';';
    $css .= '--font-heading:' . $font_heading . ';';
    $css .= '--font-body-size:' . absint( $font_size ) . 'px;';
    $css .= '--font-body-line-height:' . esc_attr( $line_height ) . ';';
    $css .= '--font-heading-weight:' . esc_attr( $heading_weight ) . ';';
    $css .= '--font-heading-transform:' . esc_attr( $heading_trans ) . ';';

    $css .= '}';

    // Logo size
    $logo_d = absint( get_theme_mod( 'vs_logo_height', 48 ) );
    $logo_m = absint( get_theme_mod( 'vs_logo_height_mobile', 36 ) );
    $css .= '.vs-logo-img { max-height: ' . $logo_d . 'px !important; width: auto !important; }';
    $css .= '@media (max-width:768px) { .vs-logo-img { max-height: ' . $logo_m . 'px !important; width: auto !important; } }';

    return $css;
}

/**
 * Output dynamic inline CSS on frontend.
 */
function vs_output_customizer_css() {
    $css = vs_get_customizer_css();
    if ( ! empty( $css ) ) {
        wp_add_inline_style( 'vs-main', $css );
    }
}
add_action( 'wp_enqueue_scripts', 'vs_output_customizer_css', 20 );

/**
 * Enqueue scripts for real-time live preview in Customizer.
 */
function vs_customize_preview_scripts() {
    wp_enqueue_script(
        'vs-customize-preview',
        get_template_directory_uri() . '/assets/js/customize-preview.js',
        array( 'customize-preview', 'jquery' ),
        VS_VERSION,
        true
    );

    wp_localize_script( 'vs-customize-preview', 'vsLogoPreview', array(
        'desktop' => (int) get_theme_mod( 'vs_logo_height',        48 ),
        'mobile'  => (int) get_theme_mod( 'vs_logo_height_mobile', 36 ),
    ) );
}
add_action( 'customize_preview_init', 'vs_customize_preview_scripts' );
