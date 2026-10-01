<?php
/**
 * Homepage — Latest posts.
 *
 * @package VisaHouse
 */

$posts_q = new WP_Query( array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'no_found_rows'  => true,
    'ignore_sticky_posts' => true,
) );

if ( ! $posts_q->have_posts() ) {
    return;
}
?>

<section id="vs-blog" class="vs-sec vs-reveal">
    <div class="vs-wrap">
        <div class="vs-sec-header">
            <span class="vs-sec-label"><i class="fa-solid fa-newspaper"></i> <?php esc_html_e( 'From Our Blog', 'visahouse' ); ?></span>
            <h2 class="vs-sec-title">
                <?php
                printf(
                    esc_html__( 'Guides & %s.', 'visahouse' ),
                    '<em>' . esc_html__( 'insights', 'visahouse' ) . '</em>'
                );
                ?>
            </h2>
            <p class="vs-sec-desc"><?php esc_html_e( 'Practical, up-to-date articles about UAE visas, Emirates ID, attestation and more.', 'visahouse' ); ?></p>
        </div>

        <div class="vs-article-grid">
            <?php while ( $posts_q->have_posts() ) : $posts_q->the_post(); ?>
                <?php get_template_part( 'template-parts/card', 'post' ); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <div class="vs-blog-cta">
            <?php
            $blog_page = get_option( 'page_for_posts' );
            $blog_url  = $blog_page ? get_permalink( $blog_page ) : home_url( '/blog/' );
            ?>
            <a href="<?php echo esc_url( $blog_url ); ?>" class="vs-btn vs-btn-outline">
                <?php esc_html_e( 'View all articles', 'visahouse' ); ?>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
