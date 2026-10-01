<?php
/**
 * Review card — no ACF.
 *
 * @package VisaHouse
 */

$post_id  = get_the_ID();
$stars    = (int) ( get_post_meta( $post_id, 'vs_review_stars', true ) ?: 5 );
$author   = get_post_meta( $post_id, 'vs_review_author_name', true ) ?: get_the_title();
$meta     = get_post_meta( $post_id, 'vs_review_author_meta', true );
$initials = get_post_meta( $post_id, 'vs_review_initials', true ) ?: strtoupper( mb_substr( $author, 0, 2 ) );
?>
<div class="vs-review-card">
    <div class="vs-review-stars"><?php echo esc_html( str_repeat( '★', max( 1, min( 5, $stars ) ) ) ); ?></div>
    <p class="vs-review-text">"<?php echo esc_html( get_the_content() ); ?>"</p>
    <div class="vs-review-author">
        <span class="vs-review-avatar"><?php echo esc_html( $initials ); ?></span>
        <div>
            <b><?php echo esc_html( $author ); ?></b>
            <span><?php echo esc_html( $meta ); ?></span>
        </div>
    </div>
</div>