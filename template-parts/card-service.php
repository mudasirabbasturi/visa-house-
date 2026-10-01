<?php
/**
 * Service card — used on homepage, archive, etc.
 *
 * @package VisaHouse
 */

$post_id    = get_the_ID();
$icon       = get_post_meta( $post_id, 'vs_service_icon', true ) ?: 'fa-people-roof';
$color      = get_post_meta( $post_id, 'vs_service_icon_color', true ) ?: 'default';
$calc_cat   = get_post_meta( $post_id, 'vs_service_calc_category', true );
$price      = get_post_meta( $post_id, 'vs_service_price', true );
$price_lbl  = get_post_meta( $post_id, 'vs_service_price_label', true ) ?: __( 'Government fees from', 'visahouse' );
$features   = get_post_meta( $post_id, 'vs_service_features', true );

// WhatsApp number from Customizer (with fallback)
$wa_number  = get_theme_mod( 'vs_whatsapp', '9718003627' );

// Pre-filled WhatsApp message with the service name
$wa_message = sprintf(
    /* translators: %s: service name */
    __( 'Hello VisaHouse, I need help with: %s', 'visahouse' ),
    get_the_title()
);
$wa_url     = 'https://wa.me/' . rawurlencode( $wa_number ) . '?text=' . rawurlencode( $wa_message );

$icon_class = 'vs-service-detail-icon' . ( 'default' !== $color ? ' ' . $color : '' );

if ( ! is_array( $features ) ) {
    $features = array();
}
?>
<article <?php post_class( 'vs-service-detail' ); ?>>
    <div class="vs-service-detail-head">
        <span class="<?php echo esc_attr( $icon_class ); ?>">
            <i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i>
        </span>
        <div class="vs-service-detail-head-text">
            <h3><?php the_title(); ?></h3>
            <p><?php echo esc_html( get_the_excerpt() ); ?></p>
        </div>
    </div>

    <div class="vs-service-detail-body">

        <?php if ( ! empty( $features ) ) : ?>
            <ul class="vs-service-features">
                <?php foreach ( $features as $feature ) :
                    if ( empty( $feature ) ) { continue; }
                    ?>
                    <li>
                        <i class="fa-solid fa-circle-check"></i>
                        <?php echo esc_html( $feature ); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="vs-service-detail-foot">

            <!-- Row 1: Price + Read more -->
            <div class="vs-service-foot-row vs-service-foot-row-top">
                <?php if ( $price ) : ?>
                    <span class="vs-service-price">
                        <?php echo esc_html( $price_lbl ); ?>
                        <strong><?php echo esc_html( $price ); ?></strong>
                    </span>
                <?php endif; ?>

                <a class="vs-service-link" href="<?php the_permalink(); ?>">
                    <?php esc_html_e( 'Read more', 'visahouse' ); ?>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <!-- Row 2: Two buttons side-by-side -->
            <div class="vs-service-foot-row vs-service-foot-row-ctas">

                <!-- Left: Get Started (calculator) -->
                <?php if ( $calc_cat ) : ?>
                    <button type="button"
                            class="vs-service-cta vs-service-cta-primary"
                            onclick="vsOpenCalculator('<?php echo esc_js( $calc_cat ); ?>')">
                        <i class="fa-solid fa-calculator"></i>
                        <?php esc_html_e( 'Get Started', 'visahouse' ); ?>
                    </button>
                <?php else : ?>
                    <a class="vs-service-cta vs-service-cta-primary" href="<?php the_permalink(); ?>">
                        <i class="fa-solid fa-arrow-right"></i>
                        <?php esc_html_e( 'Learn more', 'visahouse' ); ?>
                    </a>
                <?php endif; ?>

                <!-- Right: WhatsApp -->
                <a class="vs-service-cta vs-service-cta-wa"
                   href="<?php echo esc_url( $wa_url ); ?>"
                   target="_blank"
                   rel="noopener"
                   aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'visahouse' ); ?>">
                    <i class="fa-brands fa-whatsapp"></i>
                    <?php esc_html_e( 'WhatsApp', 'visahouse' ); ?>
                </a>

            </div>

        </div>
    </div>
</article>