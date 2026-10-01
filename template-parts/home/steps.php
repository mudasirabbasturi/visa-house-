<?php
/**
 * Homepage — Steps (4 fixed steps from Customizer).
 *
 * @package VisaHouse
 */

$steps = array();
for ( $i = 1; $i <= 4; $i++ ) {
    $title = get_theme_mod( "vs_step_{$i}_title", '' );
    if ( ! $title ) {
        continue;
    }
    $steps[] = array(
        'badge'      => get_theme_mod( "vs_step_{$i}_badge", "Step 0{$i}" ),
        'number'     => get_theme_mod( "vs_step_{$i}_number", (string) $i ),
        'title'      => $title,
        'text'       => get_theme_mod( "vs_step_{$i}_text", '' ),
        'visual'     => get_theme_mod( "vs_step_{$i}_visual", '' ),
        'visual_sub' => get_theme_mod( "vs_step_{$i}_visual_sub", '' ),
    );
}

if ( empty( $steps ) ) {
    return;
}
?>

<section id="vs-how" class="vs-sec vs-sec-alt vs-reveal">
    <div class="vs-wrap">
        <div class="vs-sec-header">
            <span class="vs-sec-label"><i class="fa-solid fa-list-check"></i> <?php esc_html_e( 'How It Works', 'visahouse' ); ?></span>
            <h2 class="vs-sec-title">
                <?php
                printf(
                    esc_html__( 'Everything handled %s.', 'visahouse' ),
                    '<em>' . esc_html__( '100% online', 'visahouse' ) . '</em>'
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