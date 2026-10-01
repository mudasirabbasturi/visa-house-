<?php
/**
 * Single service.
 *
 * @package VisaHouse
 */

get_header();

while ( have_posts() ) : the_post();

    $post_id    = get_the_ID();
    $icon       = get_post_meta( $post_id, 'vs_service_icon', true ) ?: 'fa-people-roof';
    $color      = get_post_meta( $post_id, 'vs_service_icon_color', true ) ?: 'default';
    $calc_cat   = get_post_meta( $post_id, 'vs_service_calc_category', true );
    $price      = get_post_meta( $post_id, 'vs_service_price', true );
    $price_lbl  = get_post_meta( $post_id, 'vs_service_price_label', true ) ?: __( 'Government fees from', 'visahouse' );
    $icon_class = 'vs-service-detail-icon' . ( 'default' !== $color ? ' ' . $color : '' );
?>

<article <?php post_class( 'vs-single vs-single-service' ); ?>>

    <section class="vs-page-hero">
        <div class="vs-wrap vs-page-hero-inner">
            <nav class="vs-breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'visahouse' ); ?></a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'Services', 'visahouse' ); ?></a>
                <i class="fa-solid fa-chevron-right"></i>
                <span><?php the_title(); ?></span>
            </nav>

            <div class="vs-service-single-head">
                <span class="<?php echo esc_attr( $icon_class ); ?>">
                    <i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i>
                </span>
                <h1><?php the_title(); ?></h1>
                <p class="vs-page-hero-desc"><?php echo esc_html( get_the_excerpt() ); ?></p>
            </div>
        </div>
    </section>

    <section class="vs-sec">
        <div class="vs-wrap vs-single-wrap">
            <div class="vs-single-content"><?php the_content(); ?></div>

            <div class="vs-service-single-foot">
                <?php if ( $price ) : ?>
                    <span class="vs-service-price">
                        <?php echo esc_html( $price_lbl ); ?>
                        <strong><?php echo esc_html( $price ); ?></strong>
                    </span>
                <?php endif; ?>

                <?php if ( $calc_cat ) : ?>
                    <button type="button" class="vs-btn vs-btn-primary" onclick="vsOpenCalculator('<?php echo esc_js( $calc_cat ); ?>')">
                        <i class="fa-solid fa-calculator"></i>
                        <?php esc_html_e( 'Calculate exact cost', 'visahouse' ); ?>
                    </button>
                <?php else : ?>
                    <button type="button" class="vs-btn vs-btn-primary" onclick="vsShowWhatsAppModal()">
                        <i class="fa-brands fa-whatsapp"></i>
                        <?php esc_html_e( 'Get a quote', 'visahouse' ); ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </section>

</article>

<?php endwhile; ?>

<?php get_footer(); ?>