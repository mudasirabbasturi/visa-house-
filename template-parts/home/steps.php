<?php
/**
 * Homepage — Steps (4 fixed steps from Home Steps CPT).
 *
 * @package VisaHouse
 */

$post_id = vs_singleton_get_post( 'vs_steps' );
if ( ! $post_id ) {
    return;
}

$steps = array();
for ( $i = 1; $i <= 4; $i++ ) {
    $title = get_post_meta( $post_id, "vs_step_{$i}_title", true );
    if ( ! $title ) {
        continue;
    }
    $steps[] = array(
        'badge'      => get_post_meta( $post_id, "vs_step_{$i}_badge",      true ) ?: "Step 0{$i}",
        'number'     => get_post_meta( $post_id, "vs_step_{$i}_number",     true ) ?: (string) $i,
        'title'      => $title,
        'text'       => get_post_meta( $post_id, "vs_step_{$i}_text",       true ),
        'visual'     => get_post_meta( $post_id, "vs_step_{$i}_visual",     true ),
        'visual_sub' => get_post_meta( $post_id, "vs_step_{$i}_visual_sub", true ),
    );
}

if ( empty( $steps ) ) {
    return;
}

$sec_label    = get_post_meta( $post_id, 'vs_steps_label',    true ) ?: __( 'How It Works', 'visahouse' );
$sec_title    = get_post_meta( $post_id, 'vs_steps_title',    true ) ?: __( 'Everything handled %s.', 'visahouse' );
$sec_title_em = get_post_meta( $post_id, 'vs_steps_title_em', true ) ?: __( '100% online', 'visahouse' );
?>

<section id="vs-how" class="vs-sec vs-sec-alt vs-reveal">
    <div class="vs-wrap">
        <div class="vs-sec-header">
            <span class="vs-sec-label"><i class="fa-solid fa-list-check"></i> <?php echo esc_html( $sec_label ); ?></span>
            <h2 class="vs-sec-title">
                <?php
                printf(
                    esc_html( $sec_title ),
                    '<em>' . esc_html( $sec_title_em ) . '</em>'
                );
                ?>
            </h2>
        </div>

        <div class="vs-steps-creative">
            <?php foreach ( $steps as $step ) : ?>
                <div class="vs-step-creative">
                    <?php if ( $step['badge'] ) : ?>
                        <span class="vs-step-badge"><i class="fa-solid fa-bolt"></i> <?php echo esc_html( $step['badge'] ); ?></span>
                    <?php endif; ?>
                    <?php if ( $step['number'] ) : ?>
                        <div class="vs-step-num-big"><?php echo esc_html( $step['number'] ); ?></div>
                    <?php endif; ?>
                    <?php if ( $step['title'] ) : ?>
                        <h3><?php echo esc_html( $step['title'] ); ?></h3>
                    <?php endif; ?>
                    <?php if ( $step['text'] ) : ?>
                        <p><?php echo esc_html( $step['text'] ); ?></p>
                    <?php endif; ?>
                    <?php if ( $step['visual'] || $step['visual_sub'] ) : ?>
                        <div class="vs-step-visual">
                            <span class="vs-step-visual-icon"><i class="fa-solid fa-check"></i></span>
                            <span class="vs-step-visual-text">
                                <?php if ( $step['visual'] ) : ?>
                                    <strong><?php echo esc_html( $step['visual'] ); ?></strong>
                                <?php endif; ?>
                                <?php echo esc_html( $step['visual_sub'] ); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>