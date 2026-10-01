<?php
/**
 * Post card (used on homepage, archive, search).
 *
 * @package VisaHouse
 */

$cats = get_the_category();
$cat  = $cats ? $cats[0] : null;
?>

<a href="<?php the_permalink(); ?>" class="vs-art-card">
    <div class="vs-art-cover">
        <?php if ( $cat ) : ?>
            <span class="vs-art-tag"><?php echo esc_html( $cat->name ); ?></span>
        <?php endif; ?>
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'vs-blog-card' ); ?>
        <?php else : ?>
            <img src="<?php echo esc_url( VS_URI . '/assets/img/placeholder.svg' ); ?>" alt="">
        <?php endif; ?>
    </div>

    <div class="vs-art-body">
        <div class="vs-art-meta">
            <span><i class="fa-regular fa-calendar"></i> <?php echo esc_html( get_the_date() ); ?></span>
            <span><i class="fa-regular fa-clock"></i> <?php echo esc_html( vs_reading_time() ); ?> <?php esc_html_e( 'min read', 'visahouse' ); ?></span>
        </div>
        <h3><?php the_title(); ?></h3>
        <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
        <div class="vs-art-foot">
            <div class="vs-art-author">
                <span class="vs-art-author-avatar">
                    <?php
                    $author = get_the_author();
                    echo esc_html( strtoupper( mb_substr( $author, 0, 2 ) ) );
                    ?>
                </span>
                <?php echo esc_html( $author ); ?>
            </div>
            <span class="vs-art-read"><?php esc_html_e( 'Read', 'visahouse' ); ?> <i class="fa-solid fa-arrow-right"></i></span>
        </div>
    </div>
</a>
