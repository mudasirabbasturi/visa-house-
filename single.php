<?php
/**
 * Single post.
 *
 * @package VisaHouse
 */

get_header();

while ( have_posts() ) : the_post();
    $cats = get_the_category();
    $cat  = $cats ? $cats[0] : null;
?>

<article <?php post_class( 'vs-single' ); ?>>

    <section class="vs-page-hero">
        <div class="vs-wrap vs-page-hero-inner">
            <nav class="vs-breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'visahouse' ); ?></a>
                <i class="fa-solid fa-chevron-right"></i>
                <?php if ( $cat ) : ?>
                    <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
                    <i class="fa-solid fa-chevron-right"></i>
                <?php endif; ?>
                <span><?php the_title(); ?></span>
            </nav>
            <h1><?php the_title(); ?></h1>
            <div class="vs-single-meta">
                <span><i class="fa-regular fa-calendar"></i> <?php echo esc_html( get_the_date() ); ?></span>
                <span><i class="fa-regular fa-clock"></i> <?php echo esc_html( vs_reading_time() ); ?> <?php esc_html_e( 'min read', 'visahouse' ); ?></span>
                <span><i class="fa-regular fa-user"></i> <?php the_author(); ?></span>
            </div>
        </div>
    </section>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="vs-wrap">
            <div class="vs-single-thumb">
                <?php the_post_thumbnail( 'large' ); ?>
            </div>
        </div>
    <?php endif; ?>

    <section class="vs-sec">
        <div class="vs-wrap vs-single-wrap">
            <div class="vs-single-content">
                <?php the_content(); ?>
                <?php
                wp_link_pages( array(
                    'before' => '<div class="vs-page-links">' . esc_html__( 'Pages:', 'visahouse' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>
        </div>
    </section>

    <?php
    // Related posts
    $related = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post__not_in'   => array( get_the_ID() ),
        'category__in'   => $cat ? array( $cat->term_id ) : array(),
        'no_found_rows'  => true,
    ) );
    if ( $related->have_posts() ) : ?>
        <section class="vs-sec vs-sec-alt">
            <div class="vs-wrap">
                <div class="vs-sec-header">
                    <span class="vs-sec-label"><i class="fa-solid fa-book-open"></i> <?php esc_html_e( 'Keep reading', 'visahouse' ); ?></span>
                    <h2 class="vs-sec-title"><?php esc_html_e( 'Related articles', 'visahouse' ); ?></h2>
                </div>
                <div class="vs-article-grid">
                    <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                        <?php get_template_part( 'template-parts/card', 'post' ); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ( comments_open() || get_comments_number() ) : ?>
        <section class="vs-sec">
            <div class="vs-wrap vs-single-wrap">
                <?php comments_template(); ?>
            </div>
        </section>
    <?php endif; ?>

</article>

<?php endwhile; ?>

<?php get_footer(); ?>
