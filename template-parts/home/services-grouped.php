<?php
/**
 * Homepage — Services grouped by category.
 * Each category becomes its own section with header + grid of services.
 *
 * @package VisaHouse
 */

// Get all service categories that have services in them, ordered by our custom order field
$categories = get_terms( array(
    'taxonomy'   => 'service_category',
    'hide_empty' => true,
    'meta_key'   => 'vs_cat_section_order',
    'orderby'    => 'meta_value_num',
    'order'      => 'ASC',
) );

if ( is_wp_error( $categories ) || empty( $categories ) ) {
    // Fallback: single grid of all services if no categories exist yet
    get_template_part( 'template-parts/home/services' );
    return;
}

foreach ( $categories as $category ) :

    // Fetch services in this category
    $services = new WP_Query( array(
        'post_type'      => 'service',
        'posts_per_page' => 12,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'no_found_rows'  => true,
        'tax_query'      => array(
            array(
                'taxonomy' => 'service_category',
                'field'    => 'term_id',
                'terms'    => $category->term_id,
            ),
        ),
    ) );

    if ( ! $services->have_posts() ) {
        continue;
    }

    $section_title = get_term_meta( $category->term_id, 'vs_cat_section_title', true );
    $section_desc  = get_term_meta( $category->term_id, 'vs_cat_section_desc', true );

    if ( '' === $section_title ) {
        $section_title = $category->name;
    }
    ?>

    <section id="vs-services-<?php echo esc_attr( $category->slug ); ?>" class="vs-sec vs-reveal">
        <div class="vs-wrap">

            <div class="vs-sec-header">
                <span class="vs-sec-label">
                    <i class="fa-solid fa-grip" aria-hidden="true"></i>
                    <?php echo esc_html( $category->name ); ?>
                </span>

                <h2 class="vs-sec-title">
                    <?php echo wp_kses_post( $section_title ); ?>
                </h2>

                <?php if ( $section_desc ) : ?>
                    <p class="vs-sec-desc"><?php echo esc_html( $section_desc ); ?></p>
                <?php endif; ?>
            </div>

            <div class="vs-service-detail-grid">
                <?php while ( $services->have_posts() ) : $services->the_post(); ?>
                    <?php get_template_part( 'template-parts/card', 'service' ); ?>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

        </div>
    </section>

<?php endforeach; ?>