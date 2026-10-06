<?php
/**
 * Single service — full-width canvas.
 *
 * @package VisaHouse
 */

get_header();

while ( have_posts() ) : the_post();
?>

<article <?php post_class( 'vs-single vs-single-service vfam-page' ); ?>>

    <div class="vfam-content">
        <?php the_content(); ?>
    </div>

</article>

<?php endwhile; ?>

<?php get_footer(); ?>