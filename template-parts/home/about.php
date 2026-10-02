<?php
/**
 * Homepage — About section.
 * Reads values from the single vs_about CPT post in the current language.
 *
 * @package VisaHouse
 */

$about_id = function_exists( 'vs_singleton_get_post' ) ? vs_singleton_get_post( 'vs_about' ) : 0;
$about_url = $about_id ? get_permalink( $about_id ) : '';

if ( $about_id ) {
    $label = get_post_meta( $about_id, 'vs_about_label', true ) ?: __( 'About Us', 'visahouse' );
    $title = get_post_meta( $about_id, 'vs_about_title', true ) ?: 'We are <em>800 DOCS</em> — on your side.';
    $text  = get_post_meta( $about_id, 'vs_about_text',  true );

    $img_id = get_post_thumbnail_id( $about_id );
    $img    = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : '';

    $stats = array();
    for ( $i = 1; $i <= 3; $i++ ) {
        $v = get_post_meta( $about_id, "vs_about_stat{$i}_value", true );
        $l = get_post_meta( $about_id, "vs_about_stat{$i}_label", true );
        if ( '' !== $v || '' !== $l ) {
            $stats[] = array( 'value' => $v, 'label' => $l );
        }
    }
} else {
    $label = __( 'About Us', 'visahouse' );
    $title = 'We are <em>800 DOCS</em> — on your side.';
    $text  = '';
    $img   = '';
    $stats = array();
}

if ( ! $title && ! $text && empty( $stats ) ) {
    return;
}
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
                <?php if ( $label ) : ?>
                    <span class="vs-sec-label">
                        <i class="fa-solid fa-building"></i>
                        <?php echo esc_html( $label ); ?>
                    </span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2><?php echo wp_kses_post( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <p><?php echo wp_kses_post( $text ); ?></p>
                <?php endif; ?>

                <?php if ( ! empty( $stats ) ) : ?>
                    <div class="vs-about-stats">
                        <?php foreach ( $stats as $s ) : ?>
                            <div class="vs-about-stat">
                                <b><?php echo esc_html( $s['value'] ); ?></b>
                                <span><?php echo esc_html( $s['label'] ); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php
                $read_more = get_post_meta( $about_id, 'vs_about_read_more', true );
                if ( $read_more ) :
                    ?>
                    <div class="vs-about-read-more">
                        <a href="<?php echo esc_url( $read_more ); ?>" class="vs-btn vs-btn-primary">
                            <?php esc_html_e( 'Read more', 'visahouse' ); ?>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>