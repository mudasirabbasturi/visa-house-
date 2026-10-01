<?php
/**
 * Homepage — About.
 *
 * @package VisaHouse
 */

$title = get_theme_mod( 'vs_about_title', 'We are <em>800 DOCS</em> — on your side.' );
$text  = get_theme_mod( 'vs_about_text', '' );
$img   = get_theme_mod( 'vs_about_image', '' );

$stats = array(
    array(
        'value' => get_theme_mod( 'vs_stat_1_value', '20,000+' ),
        'label' => get_theme_mod( 'vs_stat_1_label', 'Visas processed' ),
    ),
    array(
        'value' => get_theme_mod( 'vs_stat_2_value', '4.9 ★' ),
        'label' => get_theme_mod( 'vs_stat_2_label', 'Rated on Google' ),
    ),
    array(
        'value' => get_theme_mod( 'vs_stat_3_value', '100%' ),
        'label' => get_theme_mod( 'vs_stat_3_label', 'Online from start to finish' ),
    ),
);
?>

<section id="vs-about" class="vs-sec vs-reveal">
    <div class="vs-wrap">
        <div class="vs-about-grid">
            <div class="vs-about-img">
                <?php if ( $img ) : ?>
                    <img src="<?php echo esc_url( $img ); ?>" alt="">
                <?php else : ?>
                    <img src="<?php echo esc_url( VS_URI . '/assets/img/placeholder.svg' ); ?>" alt="">
                <?php endif; ?>
            </div>
            <div class="vs-about-content">
                <span class="vs-sec-label"><i class="fa-solid fa-building"></i> <?php esc_html_e( 'About Us', 'visahouse' ); ?></span>
                <h2><?php echo wp_kses_post( $title ); ?></h2>
                <?php if ( $text ) : ?>
                    <p><?php echo wp_kses_post( $text ); ?></p>
                <?php endif; ?>

                <div class="vs-about-stats">
                    <?php foreach ( $stats as $s ) : ?>
                        <div class="vs-about-stat">
                            <b><?php echo esc_html( $s['value'] ); ?></b>
                            <span><?php echo esc_html( $s['label'] ); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>