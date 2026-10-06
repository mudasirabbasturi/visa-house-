<?php
/**
 * Services Modal — bento style, CPT-driven.
 *
 * @package VisaHouse
 */

$title  = vs_get_modal_text( 'vs_modal_title', 'VisaHouse.ae' );

$groups = vs_get_modal_groups();

if ( empty( $groups ) ) {
    return;
}
?>

<div id="vsServicesModal" class="vh-modal" hidden role="dialog" aria-modal="true" aria-labelledby="vhTitle">
    <div class="vh-panel">

        <!-- HEADER -->
        <div class="vh-head">
            <div id="vhTitle" class="vh-title">
                <span class="mark"><i class="fa-solid fa-grip"></i></span>
                <?php echo esc_html( $title ); ?>
            </div>
            <button type="button" class="vh-x" aria-label="<?php esc_attr_e( 'Close', 'visahouse' ); ?>" id="vhClose" onclick="vsCloseServicesModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- SCROLL -->
        <div class="vh-scroll">
            <?php
            $group_index = 0;
            foreach ( $groups as $group ) :
                $group_index++;
                $group_title = $group['title'] ?? '';
                $group_layout = $group['layout'] ?? 'list';       // 'cards' or 'list'
                $items = $group['items'] ?? array();

                if ( empty( $items ) ) {
                    continue;
                }

                // Determine layout:
                // - If group layout is 'cards' AND has 5+ items → bento cards
                // - Otherwise → rows
                $use_cards = ( 'cards' === $group_layout && count( $items ) >= 5 );
                ?>
                <section class="vh-block" aria-label="<?php echo esc_attr( $group_title ); ?>">

                    <?php if ( $group_title ) : ?>
                        <div class="vh-block-h">
                            <h3><?php echo esc_html( $group_title ); ?></h3>
                            <span><?php printf( '%02d', $group_index ); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ( $use_cards ) : ?>

                        <!-- BENTO CARDS GRID -->
                        <div class="bento">
                            <?php
                            $i = 0;
                            foreach ( $items as $item ) :
                                $i++;
                                $label = $item['label'] ?? '';
                                $icon  = $item['icon']  ?? 'fa-star';
                                $url   = $item['url']   ?? '#';
                                $is_feature = ( 1 === $i );
                                $tile_class = 'btile';
                                if ( $is_feature ) {
                                    $tile_class .= ' btile--feature';
                                }
                                ?>
                                <a class="<?php echo esc_attr( $tile_class ); ?>" href="<?php echo esc_url( $url ); ?>">
                                <?php
                            endforeach;
                            ?>
                        </div>

                    <?php else : ?>

                        <!-- ROWS -->
                        <div class="bento bento--services">
                            <?php foreach ( $items as $item ) :
                                $label = $item['label'] ?? '';
                                $icon  = $item['icon']  ?? 'fa-star';
                                $url   = $item['url']   ?? '#';
                                ?>
                                <a class="btile btile--row" href="<?php echo esc_url( $url ); ?>">
                                    <span class="btile-ic"><i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i></span>
                                    <span class="btile-name"><?php echo esc_html( $label ); ?></span>
                                    <i class="fa-solid fa-arrow-right btile-arrow"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>

                </section>
            <?php endforeach; ?>
        </div>

    </div>
</div>