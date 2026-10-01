<?php
/**
 * No content found.
 *
 * @package VisaHouse
 */
?>
<div class="vs-no-results">
    <h2><?php esc_html_e( 'Nothing found here.', 'visahouse' ); ?></h2>
    <p><?php esc_html_e( 'Try a different search, or head back to the homepage.', 'visahouse' ); ?></p>
    <div class="vs-no-results-actions">
        <?php get_search_form(); ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vs-btn vs-btn-outline">
            <?php esc_html_e( 'Back to Home', 'visahouse' ); ?>
        </a>
    </div>
</div>
