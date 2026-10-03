<?php
/**
 * Customizer — extended with Typography, Colors, and Appearance.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Custom range-slider control for the Customizer.
 * Layout: label / description / [————slider————] [48] px
 */
if ( class_exists( 'WP_Customize_Control' ) ) :
class VS_Range_Control extends WP_Customize_Control {

    public $type = 'vs-range';

    public function enqueue() {
        add_action( 'customize_controls_print_styles', function() {
            echo '<style>
                /* Layout row */
                .customize-control-vs-range .vs-range-row {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    margin-top: 8px;
                    width: 100%;
                }

                /* Slider — the star of the show */
                .customize-control-vs-range .vs-range-row input[type="range"] {
                    flex: 1 1 auto !important;
                    width: auto !important;
                    min-width: 0 !important;
                    max-width: none !important;
                    height: 4px !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    accent-color: #C2410C;
                    cursor: pointer;
                    background: transparent;
                    -webkit-appearance: auto !important;
                    appearance: auto !important;
                }

                /* Number input — small, fixed */
                .customize-control-vs-range .vs-range-row input[type="number"] {
                    flex: 0 0 52px !important;
                    width: 52px !important;
                    min-width: 52px !important;
                    max-width: 52px !important;
                    height: 30px !important;
                    padding: 2px 4px !important;
                    border: 1px solid #c3c4c7 !important;
                    border-radius: 4px !important;
                    font-size: 12px !important;
                    line-height: 1.2 !important;
                    text-align: center;
                    background: #fff !important;
                    color: #1e1e1e !important;
                    box-shadow: none !important;
                    margin: 0 !important;
                    -moz-appearance: textfield;
                }

                /* Hide the number spinners (they push content around) */
                .customize-control-vs-range .vs-range-row input[type="number"]::-webkit-outer-spin-button,
                .customize-control-vs-range .vs-range-row input[type="number"]::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }

                /* The "px" unit */
                .customize-control-vs-range .vs-range-row .vs-ru {
                    flex: 0 0 auto;
                    font-size: 11px;
                    color: #888;
                    line-height: 1;
                }
            </style>';
        }, 2 );
    }

    public function render_content() {
        $attrs = $this->input_attrs;
        $min   = isset( $attrs['min'] )  ? (int) $attrs['min']  : 0;
        $max   = isset( $attrs['max'] )  ? (int) $attrs['max']  : 100;
        $step  = isset( $attrs['step'] ) ? (int) $attrs['step'] : 1;
        $val   = (int) $this->value();
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
            <input type="range"
                   id="<?php echo $id; ?>"
                   min="<?php echo $min; ?>" max="<?php echo $max; ?>" step="<?php echo $step; ?>"
                   value="<?php echo esc_attr( $val ); ?>"
                   <?php echo $link; ?>
                   oninput="document.getElementById('<?php echo $id; ?>-num').value=this.value">
            <input type="number"
                   id="<?php echo $id; ?>-num"
                   min="<?php echo $min; ?>" max="<?php echo $max; ?>" step="<?php echo $step; ?>"
                   value="<?php echo esc_attr( $val ); ?>"
                   oninput="var r=document.getElementById('<?php echo $id; ?>');r.value=this.value;r.dispatchEvent(new Event('input'));">
            <span class="vs-ru">px</span>
        </div>
        <?php
    }
}
endif; // class_exists WP_Customize_Control


/**
 * Color preset swatch picker — shows colored rectangles instead of radio buttons.
 */
if ( class_exists( 'WP_Customize_Control' ) ) :
class VS_Color_Preset_Control extends WP_Customize_Control {

    public $type    = 'vs-color-preset';
    public $presets = array();

    public function enqueue() {
        add_action( 'customize_controls_print_styles', function() {
            echo '<style>
                .vs-swatch-grid {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 8px;
                    margin-top: 10px;
                }
                .vs-swatch {
                    position: relative;
                    cursor: pointer;
                    border-radius: 8px;
                    overflow: hidden;
                    border: 2px solid transparent;
                    transition: border-color .15s, transform .15s;
                    aspect-ratio: 1;
                }
                .vs-swatch:hover { transform: scale(1.06); }
                .vs-swatch.active { border-color: #fff; box-shadow: 0 0 0 2px #C2410C; }
                .vs-swatch-inner {
                    width: 100%;
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                }
                .vs-swatch-top { flex: 2; }
                .vs-swatch-bot { flex: 1; }
                .vs-swatch-name {
                    position: absolute;
                    bottom: 3px;
                    left: 0; right: 0;
                    text-align: center;
                    font-size: 9px;
                    font-weight: 600;
                    color: rgba(255,255,255,.9);
                    text-shadow: 0 1px 2px rgba(0,0,0,.5);
                    letter-spacing: .04em;
                    text-transform: uppercase;
                }
                .vs-swatch input[type=radio] { display:none !important; }
            </style>';
        }, 2 );
    }

    public function render_content() {
        if ( $this->label ) :
            echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
        endif;
        if ( $this->description ) :
            echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';
        endif;

        $current = $this->value();
        echo '<div class="vs-swatch-grid">';
        foreach ( $this->presets as $key => $p ) :
            $active = ( $current === $key ) ? ' active' : '';
            ?>
            <label class="vs-swatch<?php echo $active; ?>" title="<?php echo esc_attr( $p['name'] ); ?>">
                <input type="radio"
                    <?php $this->link(); ?>
                    value="<?php echo esc_attr( $key ); ?>"
                    <?php checked( $current, $key ); ?>
                    onchange="this.closest('.vs-swatch-grid').querySelectorAll('.vs-swatch').forEach(function(s){s.classList.remove('active')});this.closest('.vs-swatch').classList.add('active');">
                <span class="vs-swatch-inner">
                    <span class="vs-swatch-top" style="background:<?php echo esc_attr( $p['primary'] ); ?>"></span>
                    <span class="vs-swatch-bot" style="background:<?php echo esc_attr( $p['accent'] ); ?>"></span>
                </span>
                <span class="vs-swatch-name"><?php echo esc_html( $p['name'] ); ?></span>
            </label>
            <?php
        endforeach;
        echo '</div>';
    }
}
endif; // class_exists WP_Customize_Control


function vs_customize_register( $wp_customize ) {


    /* ============================================================
       GLOBAL
       ============================================================ */
    $wp_customize->add_section( 'vs_global', array(
        'title'    => __( 'VisaHouse — Global', 'visahouse' ),
        'priority' => 30,
    ) );

    $global_fields = array(
        'vs_whatsapp'       => array( 'label' => 'WhatsApp number (digits + country code)', 'default' => '9718003627', 'type' => 'text' ),
        'vs_google_rating'  => array( 'label' => 'Google rating',                            'default' => '4.9',        'type' => 'text' ),
        'vs_phone'          => array( 'label' => 'Phone (display)',                          'default' => '800 DOCS (3627)', 'type' => 'text' ),
        'vs_email'          => array( 'label' => 'Email',                                    'default' => 'info@visahouse.ae', 'type' => 'email' ),
        'vs_address'        => array( 'label' => 'Address',                                  'default' => 'Business Village, Deira', 'type' => 'text' ),
    );
    foreach ( $global_fields as $key => $cfg ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $cfg['default'],
            'sanitize_callback' => 'vs_sanitize_text_or_email',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $cfg['label'],
            'section' => 'vs_global',
            'type'    => $cfg['type'],
        ) );
    }


    /* ============================================================
       LOGO SIZE — Site Identity (title_tagline)
       ============================================================ */

    // Desktop logo height
    $wp_customize->add_setting( 'vs_logo_height', array(
        'default'           => 48,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new VS_Range_Control( $wp_customize, 'vs_logo_height', array(
        'label'       => __( 'Logo height — Desktop (px)', 'visahouse' ),
        'description' => __( 'Max-height of the header logo image on desktop.', 'visahouse' ),
        'section'     => 'title_tagline',
        'input_attrs' => array( 'min' => 20, 'max' => 120, 'step' => 1 ),
    ) ) );

    // Mobile logo height
    $wp_customize->add_setting( 'vs_logo_height_mobile', array(
        'default'           => 36,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new VS_Range_Control( $wp_customize, 'vs_logo_height_mobile', array(
        'label'       => __( 'Logo height — Mobile (px)', 'visahouse' ),
        'description' => __( 'Max-height of the header logo on mobile screens (≤768px).', 'visahouse' ),
        'section'     => 'title_tagline',
        'input_attrs' => array( 'min' => 16, 'max' => 80, 'step' => 1 ),
    ) ) );


    /* ============================================================
       TYPOGRAPHY
       ============================================================ */
    $wp_customize->add_section( 'vs_typography', array(
        'title'    => __( 'VisaHouse — Typography', 'visahouse' ),
        'priority' => 40,
    ) );

    $font_choices = array(
        'Adobe Clean'                => 'Adobe Clean',
        'Adobe Clean Semi Condensed' => 'Adobe Clean Semi Condensed',
        'Manrope'                    => 'Manrope',
        'system-ui'                  => 'System UI',
    );

    // Font family selects
    foreach ( array( 'body' => 'Body font', 'heading' => 'Heading font' ) as $type => $label ) {
        $wp_customize->add_setting( "vs_font_{$type}", array(
            'default'           => 'Adobe Clean',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( "vs_font_{$type}", array(
            'label'   => $label,
            'section' => 'vs_typography',
            'type'    => 'select',
            'choices' => $font_choices,
        ) );
    }

    // Font sizes
    $sizes = array(
        'body'        => array( 'Body size',          16, 12, 24 ),
        'body_mobile' => array( 'Body size — Mobile', 15, 12, 20 ),
        'h1'          => array( 'H1 size',            48, 28, 72 ),
        'h2'          => array( 'H2 size',            36, 24, 56 ),
        'h3'          => array( 'H3 size',            24, 18, 40 ),
        'h4'          => array( 'H4 size',            20, 16, 32 ),
    );
    foreach ( $sizes as $key => $cfg ) {
        $wp_customize->add_setting( "vs_font_size_{$key}", array(
            'default'           => $cfg[1],
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( new VS_Range_Control( $wp_customize, "vs_font_size_{$key}", array(
            'label'       => $cfg[0] . ' (px)',
            'section'     => 'vs_typography',
            'input_attrs' => array( 'min' => $cfg[2], 'max' => $cfg[3], 'step' => 1 ),
        ) ) );
    }

    // Weights
    $wp_customize->add_setting( 'vs_weight_body', array( 'default' => '400', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vs_weight_body', array( 'label' => 'Body weight', 'section' => 'vs_typography', 'type' => 'select', 'choices' => array('300'=>'300','400'=>'400','500'=>'500','600'=>'600','700'=>'700') ) );

    $wp_customize->add_setting( 'vs_weight_heading', array( 'default' => '700', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vs_weight_heading', array( 'label' => 'Heading weight', 'section' => 'vs_typography', 'type' => 'select', 'choices' => array('400'=>'400','500'=>'500','600'=>'600','700'=>'700','800'=>'800') ) );


    /* ============================================================
       COLORS
       ============================================================ */
    $wp_customize->add_section( 'vs_colors', array(
        'title'    => __( 'VisaHouse — Colors', 'visahouse' ),
        'priority' => 41,
    ) );

    $presets = array(
        'brand'  => array( 'name' => 'Brand',   'primary' => '#0A1F3D', 'accent' => '#C2410C', 'hover' => '#9A3309' ),
        'ocean'  => array( 'name' => 'Ocean',   'primary' => '#0C2340', 'accent' => '#0284C7', 'hover' => '#0369A1' ),
        'forest' => array( 'name' => 'Forest',  'primary' => '#14342B', 'accent' => '#16A34A', 'hover' => '#15803D' ),
        'slate'  => array( 'name' => 'Slate',   'primary' => '#1E293B', 'accent' => '#475569', 'hover' => '#334155' ),
        'violet' => array( 'name' => 'Violet',  'primary' => '#1E0A3D', 'accent' => '#7C3AED', 'hover' => '#6D28D9' ),
        'sunset' => array( 'name' => 'Sunset',  'primary' => '#3D0A1F', 'accent' => '#E11D48', 'hover' => '#BE123C' ),
        'rose'   => array( 'name' => 'Rose',    'primary' => '#2D0A1F', 'accent' => '#EC4899', 'hover' => '#DB2777' ),
        'custom' => array( 'name' => 'Custom',  'primary' => '#333333', 'accent' => '#666666', 'hover' => '#444444' ),
    );

    $wp_customize->add_setting( 'vs_color_preset', array(
        'default'           => 'brand',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new VS_Color_Preset_Control( $wp_customize, 'vs_color_preset', array(
        'label'   => __( 'Color Palette', 'visahouse' ),
        'section' => 'vs_colors',
        'presets' => $presets,
    ) ) );

    $wp_customize->add_setting( 'vs_color_primary', array( 'default' => '#0A1F3D', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_primary', array( 'label' => 'Primary Color (custom override)', 'section' => 'vs_colors' ) ) );

    $wp_customize->add_setting( 'vs_color_accent', array( 'default' => '#C2410C', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_accent', array( 'label' => 'Accent Color (custom override)', 'section' => 'vs_colors' ) ) );

    $wp_customize->add_setting( 'vs_color_accent_hover', array( 'default' => '#9A3309', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vs_color_accent_hover', array( 'label' => 'Accent Hover (custom override)', 'section' => 'vs_colors' ) ) );


}
add_action( 'customize_register', 'vs_customize_register' );


/**
 * Custom sanitizer — allows text or email.
 */
function vs_sanitize_text_or_email( $value ) {
    if ( is_email( $value ) ) {
        return sanitize_email( $value );
    }
    return sanitize_text_field( $value );
}

function vs_sanitize_float( $value ) {
    return (float) $value;
}

/**
 * Enqueue the live-preview script inside the Customizer preview iframe.
 * Only runs when the Customizer is active (customize_preview_init).
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
        'primary' => get_theme_mod( 'vs_color_primary',      '#0A1F3D' ),
        'accent'  => get_theme_mod( 'vs_color_accent',       '#C2410C' ),
        'hover'   => get_theme_mod( 'vs_color_accent_hover', '#9A3309' ),
    ) );
}
add_action( 'customize_preview_init', 'vs_customize_preview_scripts' );