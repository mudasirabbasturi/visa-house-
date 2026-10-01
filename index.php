<?php
/**
 * Fallback template (blog listing when no specific archive matches).
 *
 * @package VisaHouse
 */

get_header();
?>

<section class="vs-page-hero">
    <div class="vs-wrap vs-page-hero-inner">
        <nav class="vs-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'visahouse' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'visahouse' ); ?></a>
            <i class="fa-solid fa-chevron-right"></i>
            <span><?php echo esc_html( wp_get_document_title() ); ?></span>
        </nav>
        <h1><?php echo esc_html( get_the_archive_title() ?: get_bloginfo( 'name' ) ); ?></h1>
    </div>
</section>

<section class="vs-sec">
    <div class="vs-wrap">
        <?php if ( have_posts() ) : ?>
            <div class="vs-article-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/card', 'post' ); ?>
                <?php endwhile; ?>
            </div>

            <div class="vs-pagination">
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                    'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                ) );
                ?>
            </div>
        <?php else : ?>
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
