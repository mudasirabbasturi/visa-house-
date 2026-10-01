<?php
/**
 * Comments.
 *
 * @package VisaHouse
 */

if ( post_password_required() ) {
    return;
}
?>
<div id="vs-comments" class="vs-comments">
    <?php if ( have_comments() ) : ?>
        <h3 class="vs-comments-title">
            <?php
            printf(
                /* translators: %s: comment count */
                esc_html( _n( '%s comment', '%s comments', get_comments_number(), 'visahouse' ) ),
                esc_html( number_format_i18n( get_comments_number() ) )
            );
            ?>
        </h3>

        <ol class="vs-comment-list">
            <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
            ) );
            ?>
        </ol>

        <?php the_comments_pagination(); ?>
    <?php endif; ?>

    <?php comment_form(); ?>
</div>
