<?php
/**
 * Homepage — Services grid.
 *
 * @package VisaHouse
 */

$services = new WP_Query( array(
    'post_type'      => 'service',
    'posts_per_page' => 6,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'no_found_rows'  => true,
) );

if ( ! $services->have_posts() ) {
    return;
}
?>

<section id="vs-services" class="vs-sec vs-reveal">
    <div class="vs-wrap">
        <div class="vs-sec-header">
            <span class="vs-sec-label"><i class="fa-solid fa-grip"></i> <?php esc_html_e( 'Our Services', 'visahouse' ); ?></span>
            <h2 class="vs-sec-title">
                <?php
                printf(
                    esc_html__( 'Everything your family %s.', 'visahouse' ),
                    '<em>' . esc_html__( 'needs', 'visahouse' ) . '</em>'
                );
                ?>
            </h2>
            <p class="vs-sec-desc"><?php esc_html_e( 'From family visas to document attestation — we handle it all, 100% online.', 'visahouse' ); ?></p>
        </div>

        <div class="vs-service-detail-grid">
            <?php while ( $services->have_posts() ) : $services->the_post(); ?>
                <?php get_template_part( 'template-parts/card', 'service' ); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
