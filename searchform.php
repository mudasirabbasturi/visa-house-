<?php
/**
 * Search form.
 *
 * @package VisaHouse
 */
?>
<form role="search" method="get" class="vs-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="vs-searchform-label">
        <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'visahouse' ); ?></span>
        <input type="search" class="vs-searchform-input" placeholder="<?php esc_attr_e( 'Search articles…', 'visahouse' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
    </label>
    <button type="submit" class="vs-searchform-btn" aria-label="<?php esc_attr_e( 'Search', 'visahouse' ); ?>">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
</form>
