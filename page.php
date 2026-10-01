<?php
/**
 * Page template.
 *
 * @package VisaHouse
 */

get_header();

while ( have_posts() ) : the_post();
?>

<article <?php post_class( 'vs-single vs-single-page' ); ?>>

    <section class="vs-page-hero">
        <div class="vs-wrap vs-page-hero-inner">
            <nav class="vs-breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'visahouse' ); ?></a>
                <i class="fa-solid fa-chevron-right"></i>
                <span><?php the_title(); ?></span>
            </nav>
            <h1><?php the_title(); ?></h1>
        </div>
    </section>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="vs-wrap">
            <div class="vs-single-thumb"><?php the_post_thumbnail( 'large' ); ?></div>
        </div>
    <?php endif; ?>

    <section class="vs-sec">
        <div class="vs-wrap vs-single-wrap">
            <div class="vs-single-content"><?php the_content(); ?></div>
        </div>
    </section>

</article>

<?php endwhile; ?>

<?php get_footer(); ?>
