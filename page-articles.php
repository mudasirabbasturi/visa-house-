<?php
/**
 * Template Name: Articles Archive
 * Description: Lists all blog posts with category filters and pagination.
 *
 * @package VisaHouse
 */

get_header();
?>

<!-- ============================================================
     PAGE HERO
     ============================================================ -->
<section class="vs-page-hero">
    <div class="vs-wrap vs-page-hero-inner">

        <nav class="vs-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'visahouse' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'visahouse' ); ?></a>
            <i class="fa-solid fa-chevron-right"></i>
            <span><?php esc_html_e( 'Articles', 'visahouse' ); ?></span>
        </nav>

        <h1>
            <?php
            printf(
                esc_html__( 'Guides & %s.', 'visahouse' ),
                '<em>' . esc_html__( 'insights', 'visahouse' ) . '</em>'
            );
            ?>
        </h1>

        <p class="vs-page-hero-desc">
            <?php esc_html_e( 'Practical, up-to-date articles about UAE visas, Emirates ID, attestation and more.', 'visahouse' ); ?>
        </p>
    </div>
</section>

<!-- ============================================================
     CATEGORY PILLS
     ============================================================ -->
<?php
// Get current category filter from query string
$current_cat = isset( $_GET['cat'] ) ? sanitize_title( wp_unslash( $_GET['cat'] ) ) : '';

$cats = get_categories( array(
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
) );

if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) : ?>
    <div class="vs-wrap">
        <div class="vs-cat-pills">

            <!-- "All" pill -->
            <a href="<?php echo esc_url( get_permalink() ); ?>"
               class="vs-cat-pill <?php echo empty( $current_cat ) ? 'vs-active' : ''; ?>">
                <i class="fa-solid fa-layer-group"></i>
                <?php esc_html_e( 'All articles', 'visahouse' ); ?>
            </a>

            <!-- Category pills -->
            <?php foreach ( $cats as $cat ) : ?>
                <a href="<?php echo esc_url( add_query_arg( 'cat', $cat->slug, get_permalink() ) ); ?>"
                   class="vs-cat-pill <?php echo ( $current_cat === $cat->slug ) ? 'vs-active' : ''; ?>">
                    <?php echo esc_html( $cat->name ); ?>
                    <span class="vs-cat-count"><?php echo (int) $cat->count; ?></span>
                </a>
            <?php endforeach; ?>

        </div>
    </div>
<?php endif; ?>

<!-- ============================================================
     ARTICLES GRID
     ============================================================ -->
<section class="vs-sec vs-reveal">
    <div class="vs-wrap">

        <?php
        // Pagination-aware query
        $paged = max( 1, (int) ( get_query_var( 'paged' ) ?: get_query_var( 'page' ) ?: 1 ) );

        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 9,
            'paged'          => $paged,
        );

        // Add category filter if set
        if ( ! empty( $current_cat ) ) {
            $args['category_name'] = $current_cat;
        }

        $posts_query = new WP_Query( $args );

        if ( $posts_query->have_posts() ) : ?>

            <div class="vs-article-grid">
                <?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
                    <?php get_template_part( 'template-parts/card', 'post' ); ?>
                <?php endwhile; ?>
            </div>

            <div class="vs-pagination">
                <?php
                echo paginate_links( array(
                    'total'     => $posts_query->max_num_pages,
                    'current'   => $paged,
                    'mid_size'  => 2,
                    'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                    'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                    'base'      => add_query_arg( 'paged', '%#%' ),
                    'format'    => '',
                ) );
                ?>
            </div>

            <?php wp_reset_postdata(); ?>

        <?php else : ?>

            <?php get_template_part( 'template-parts/content', 'none' ); ?>

        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>