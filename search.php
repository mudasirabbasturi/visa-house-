<?php
/**
 * Search results.
 *
 * @package VisaHouse
 */

get_header();
?>

<section class="vs-page-hero">
    <div class="vs-wrap vs-page-hero-inner">
        <nav class="vs-breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'visahouse' ); ?></a>
            <i class="fa-solid fa-chevron-right"></i>
            <span><?php esc_html_e( 'Search', 'visahouse' ); ?></span>
        </nav>
        <h1>
            <?php
            /* translators: %s: search query */
            printf( esc_html__( 'Results for “%s”', 'visahouse' ), esc_html( get_search_query() ) );
            ?>
        </h1>
        <div class="vs-search-form-wrap"><?php get_search_form(); ?></div>
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
            <div class="vs-pagination"><?php the_posts_pagination(); ?></div>
        <?php else : ?>
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
