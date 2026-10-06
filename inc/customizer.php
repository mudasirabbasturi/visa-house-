<?php
/**
 * Customizer — Logo Settings.
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
    public function enqueue() {
        add_action( 'customize_controls_print_styles', function() {
            echo '<style>
                .customize-control-vs-range .vs-range-row { display: flex; align-items: center; gap: 8px; margin-top: 8px; width: 100%; }
                .customize-control-vs-range .vs-range-row input[type="range"] { flex: 1 1 auto !important; width: auto !important; min-width: 0 !important; max-width: none !important; height: 4px !important; margin: 0 !important; padding: 0 !important; accent-color: #007cba; cursor: pointer; background: transparent; -webkit-appearance: auto !important; appearance: auto !important; }
                .customize-control-vs-range .vs-range-row input[type="number"] { flex: 0 0 52px !important; width: 52px !important; min-width: 52px !important; max-width: 52px !important; height: 30px !important; padding: 2px 4px !important; border: 1px solid #c3c4c7 !important; border-radius: 4px !important; font-size: 12px !important; line-height: 1.2 !important; text-align: center; background: #fff !important; color: #1e1e1e !important; box-shadow: none !important; margin: 0 !important; -moz-appearance: textfield; }
                .customize-control-vs-range .vs-range-row input[type="number"]::-webkit-outer-spin-button, .customize-control-vs-range .vs-range-row input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
                .customize-control-vs-range .vs-range-row .vs-ru { flex: 0 0 auto; font-size: 11px; color: #888; line-height: 1; }
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
            <input type="range" id="<?php echo $id; ?>" min="<?php echo $min; ?>" max="<?php echo $max; ?>" step="<?php echo $step; ?>" value="<?php echo esc_attr( $val ); ?>" <?php echo $link; ?> oninput="document.getElementById('<?php echo $id; ?>-num').value=this.value">
            <input type="number" id="<?php echo $id; ?>-num" min="<?php echo $min; ?>" max="<?php echo $max; ?>" step="<?php echo $step; ?>" value="<?php echo esc_attr( $val ); ?>" oninput="var r=document.getElementById('<?php echo $id; ?>');r.value=this.value;r.dispatchEvent(new Event('input'));">
            <span class="vs-ru">px</span>
        </div>
        <?php
    }
}
endif; // class_exists WP_Customize_Control


function vs_customize_register( $wp_customize ) {

    /* ============================================================
       LOGO SIZE
       ============================================================ */
    $wp_customize->add_setting( 'vs_logo_height', array( 'default' => 48, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new VS_Range_Control( $wp_customize, 'vs_logo_height', array( 'label' => __( 'Logo height — Desktop (px)', 'visahouse' ), 'section' => 'title_tagline', 'input_attrs' => array( 'min' => 20, 'max' => 120, 'step' => 1 ) ) ) );

    $wp_customize->add_setting( 'vs_logo_height_mobile', array( 'default' => 36, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new VS_Range_Control( $wp_customize, 'vs_logo_height_mobile', array( 'label' => __( 'Logo height — Mobile (px)', 'visahouse' ), 'section' => 'title_tagline', 'input_attrs' => array( 'min' => 16, 'max' => 80, 'step' => 1 ) ) ) );

}
add_action( 'customize_register', 'vs_customize_register' );


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
