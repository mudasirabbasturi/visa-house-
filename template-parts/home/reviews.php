<?php
/**
 * Homepage — Reviews marquee with pause/play control.
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

$rating       = get_theme_mod( 'vs_google_rating', '4.9' );
$rating_count = get_theme_mod( 'vs_google_rating_count', '500+' );
$google_url   = get_theme_mod( 'vs_google_reviews_url', '' );
$autoplay     = get_theme_mod( 'vs_reviews_autoplay', true );
$speed        = get_theme_mod( 'vs_reviews_speed', '45' ); // seconds
?>

<section class="vs-sec vs-sec-alt vs-reveal vs-reviews-section" data-autoplay="<?php echo $autoplay ? '1' : '0'; ?>">

    <div class="vs-wrap">
        <div class="vs-sec-header">

            <span class="vs-sec-label">
                <i class="fa-solid fa-star" aria-hidden="true"></i>
                <?php esc_html_e( 'Reviews', 'visahouse' ); ?>
            </span>

            <h2 class="vs-sec-title">
                <?php
                printf(
                    /* translators: %s: rating value in orange */
                    esc_html__( 'Rated %s on Google.', 'visahouse' ),
                    '<em>' . esc_html( $rating ) . '</em>'
                );
                ?>
            </h2>

            <p class="vs-sec-desc">
                <?php esc_html_e( "Real stories from families we've helped reunite in the UAE.", 'visahouse' ); ?>
            </p>

            <!-- Google badge + slider control row -->
            <div class="vs-reviews-toolbar">

                <!-- LEFT: Rating + review count -->
                <div class="vs-reviews-rating">
                    <span class="vs-google-stars" aria-hidden="true">
                        <span class="vs-google-stars-fill" style="width: <?php echo esc_attr( ( (float) $rating / 5 ) * 100 ); ?>%">★★★★★</span>
                        <span class="vs-google-stars-base">★★★★★</span>
                    </span>
                    <strong class="vs-google-rating"><?php echo esc_html( $rating ); ?></strong>
                    <?php if ( $rating_count ) : ?>
                        <span class="vs-google-count">(<?php echo esc_html( $rating_count ); ?><?php esc_html_e( ' reviews', 'visahouse' ); ?>)</span>
                    <?php endif; ?>
                </div>

                <!-- CENTER: Pause / Play -->
                <button type="button"
                        class="vs-reviews-toggle"
                        id="vsReviewsToggle"
                        aria-label="<?php esc_attr_e( 'Pause auto-scroll', 'visahouse' ); ?>"
                        aria-pressed="<?php echo $autoplay ? 'false' : 'true'; ?>">
                    <i class="fa-solid fa-pause vs-toggle-icon-pause" aria-hidden="true"></i>
                    <i class="fa-solid fa-play vs-toggle-icon-play" aria-hidden="true"></i>
                    <span class="vs-toggle-text vs-toggle-text-pause"><?php esc_html_e( 'Pause', 'visahouse' ); ?></span>
                    <span class="vs-toggle-text vs-toggle-text-play"><?php esc_html_e( 'Play', 'visahouse' ); ?></span>
                </button>

                <!-- RIGHT: Google badge -->
                <?php
                $badge_tag   = $google_url ? 'a' : 'div';
                $badge_attrs = $google_url
                    ? ' href="' . esc_url( $google_url ) . '" target="_blank" rel="noopener noreferrer"'
                    : '';
                ?>
                <<?php echo $badge_tag . $badge_attrs; ?> class="vs-google-badge" aria-label="<?php esc_attr_e( 'View on Google', 'visahouse' ); ?>">

                    <span class="vs-google-logo" aria-hidden="true">
                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                            <path fill="#4285F4" d="M45.12 24.5c0-1.56-.14-3.06-.4-4.5H24v8.51h11.84c-.51 2.75-2.06 5.08-4.39 6.64v5.52h7.11c4.16-3.83 6.56-9.47 6.56-16.17z"/>
                            <path fill="#34A853" d="M24 46c5.94 0 10.92-1.97 14.56-5.33l-7.11-5.52c-1.97 1.32-4.49 2.1-7.45 2.1-5.73 0-10.58-3.87-12.31-9.07H4.34v5.7C7.96 41.07 15.4 46 24 46z"/>
                            <path fill="#FBBC05" d="M11.69 28.18C11.25 26.86 11 25.45 11 24s.25-2.86.69-4.18v-5.7H4.34C2.85 17.09 2 20.45 2 24c0 3.55.85 6.91 2.34 9.88l7.35-5.7z"/>
                            <path fill="#EA4335" d="M24 10.75c3.23 0 6.13 1.11 8.41 3.29l6.31-6.31C34.91 4.18 29.93 2 24 2 15.4 2 7.96 6.93 4.34 14.12l7.35 5.7c1.73-5.2 6.58-9.07 12.31-9.07z"/>
                        </svg>
                    </span>

                    <span class="vs-google-text"><?php esc_html_e( 'Reviews on Google', 'visahouse' ); ?></span>

                    <i class="fa-solid fa-arrow-up-right-from-square vs-google-arrow" aria-hidden="true"></i>

                </<?php echo $badge_tag; ?>>

            </div>
        </div>
    </div>

    <div class="vs-reviews-track-wrap">
        <div class="vs-reviews-track"
             id="vsReviewsTrack"
             style="animation-duration: <?php echo esc_attr( $speed ); ?>s;">
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