<?php
/**
 * Homepage — Reviews marquee.
 *
 * @package VisaHouse
 */

$reviews = new WP_Query( array(
    'post_type'      => 'review',
    'posts_per_page' => 12,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'no_found_rows'  => true,
) );

if ( ! $reviews->have_posts() ) {
    return;
}
?>

<section class="vs-sec vs-sec-alt vs-reveal vs-reviews-section">
    <div class="vs-wrap">
        <div class="vs-sec-header">
            <span class="vs-sec-label"><i class="fa-solid fa-star"></i> <?php esc_html_e( 'Reviews', 'visahouse' ); ?></span>
            <h2 class="vs-sec-title">
                <?php
                printf(
                    esc_html__( 'Rated %s on Google.', 'visahouse' ),
                    '<em>' . esc_html( vs_mod( 'vs_google_rating', '4.9' ) ) . '</em>'
                );
                ?>
            </h2>
            <p class="vs-sec-desc"><?php esc_html_e( "Real stories from families we've helped reunite in the UAE.", 'visahouse' ); ?></p>
        </div>
    </div>

    <div class="vs-reviews-track-wrap">
        <div class="vs-reviews-track" id="vsReviewsTrack">
            <?php for ( $pass = 0; $pass < 2; $pass++ ) : ?>
                <?php while ( $reviews->have_posts() ) : $reviews->the_post(); ?>
                    <?php get_template_part( 'template-parts/card', 'review' ); ?>
                <?php endwhile; ?>
                <?php $reviews->rewind_posts(); ?>
            <?php endfor; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</section>
