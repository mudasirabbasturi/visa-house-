<?php
/**
 * Homepage — FAQ.
 *
 * @package VisaHouse
 */

$faqs = new WP_Query( array(
    'post_type'      => 'faq',
    'posts_per_page' => 8,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'no_found_rows'  => true,
) );

if ( ! $faqs->have_posts() ) {
    return;
}
?>

<section id="vs-faq" class="vs-sec vs-sec-alt vs-reveal">
    <div class="vs-wrap">
        <div class="vs-sec-header">
            <span class="vs-sec-label"><i class="fa-solid fa-circle-question"></i> <?php esc_html_e( 'FAQ', 'visahouse' ); ?></span>
            <h2 class="vs-sec-title">
                <?php
                printf(
                    esc_html__( 'Common %s.', 'visahouse' ),
                    '<em>' . esc_html__( 'questions', 'visahouse' ) . '</em>'
                );
                ?>
            </h2>
            <p class="vs-sec-desc"><?php esc_html_e( 'Everything you need to know before you apply.', 'visahouse' ); ?></p>
        </div>

        <div class="vs-faq-list">
            <?php $first = true; while ( $faqs->have_posts() ) : $faqs->the_post(); ?>
                <details class="vs-faq-item"<?php echo $first ? ' open' : ''; ?>>
                    <summary class="vs-faq-q"><?php the_title(); ?></summary>
                    <div class="vs-faq-a"><?php the_content(); ?></div>
                </details>
            <?php $first = false; endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
