<?php
/**
 * Service archive (/services/).
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
            <span><?php esc_html_e( 'Services', 'visahouse' ); ?></span>
        </nav>
        <h1><?php esc_html_e( 'Every UAE visa,', 'visahouse' ); ?> <em><?php esc_html_e( 'under one roof', 'visahouse' ); ?></em>.</h1>
        <p><?php esc_html_e( 'From family visas to document attestation — explore our full range of services, all processed 100% online.', 'visahouse' ); ?></p>
    </div>
</section>

<?php
// Category pills
$terms = get_terms( array(
    'taxonomy'   => 'service_category',
    'hide_empty' => true,
) );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
    <div class="vs-wrap">
        <div class="vs-cat-pills">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>" class="vs-cat-pill vs-active">
                <i class="fa-solid fa-layer-group"></i> <?php esc_html_e( 'All Services', 'visahouse' ); ?>
            </a>
            <?php foreach ( $terms as $term ) : ?>
                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="vs-cat-pill">
                    <?php echo esc_html( $term->name ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<section class="vs-sec">
    <div class="vs-wrap">
        <?php if ( have_posts() ) : ?>
            <div class="vs-service-detail-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/card', 'service' ); ?>
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
