<?php
/**
 * Footer — reads everything from the single vs_footer CPT post
 * in the current language. Falls back to defaults if none exists.
 *
 * @package VisaHouse
 */

/* -----------------------------------------------------------------
 * Find the Footer post (Polylang-aware — vs_singleton_get_post()
 * returns the post in the current language).
 * ----------------------------------------------------------------- */
$pid = function_exists( 'vs_singleton_get_post' )
    ? vs_singleton_get_post( 'vs_footer' )
    : 0;

/* Helper — read meta with fallback */
$fm = function ( $key, $fallback = '' ) use ( $pid ) {
    if ( ! $pid ) return $fallback;
    $val = get_post_meta( $pid, $key, true );
    return ( '' !== $val && null !== $val ) ? $val : $fallback;
};

/* -----------------------------------------------------------------
 * Brand
 * ----------------------------------------------------------------- */
$brand_tagline = $fm( 'vs_footer_brand_tagline', 'Global Mobility Solutions' );
$brand_desc    = $fm( 'vs_footer_brand_desc',    'Your trusted partner for 100% online UAE visa processing.' );

/* Featured image of the footer post = optional override logo */
$footer_logo_url = '';
if ( $pid ) {
    $thumb_id = get_post_thumbnail_id( $pid );
    if ( $thumb_id ) {
        $footer_logo_url = wp_get_attachment_image_url( $thumb_id, 'full' );
    }
}

/* Socials */
$socials = array();
foreach ( array( 'facebook', 'instagram', 'tiktok', 'linkedin', 'youtube' ) as $key ) {
    $url = $fm( "vs_social_{$key}", '' );
    if ( $url ) $socials[ $key ] = $url;
}

/* Services column */
$services_title = $fm( 'vs_footer_services_title', 'Services' );
$services       = $pid ? get_post_meta( $pid, 'vs_footer_services', true ) : array();
if ( ! is_array( $services ) ) $services = array();

/* Company column */
$company_title = $fm( 'vs_footer_company_title', 'Company' );
$company       = $pid ? get_post_meta( $pid, 'vs_footer_company', true ) : array();
if ( ! is_array( $company ) ) $company = array();

/* Contact column */
$contact_title   = $fm( 'vs_footer_contact_title',   'Contact' );
$contact_phone   = $fm( 'vs_footer_contact_phone',   '800 DOCS (3627)' );
$contact_email   = $fm( 'vs_footer_contact_email',   'info@visahouse.ae' );
$contact_address = $fm( 'vs_footer_contact_address', 'Business Village, Deira' );
$contact_hours   = $fm( 'vs_footer_contact_hours',   'Sun–Thu · 9am–6pm' );

/* Trust */
$trust_label = $fm( 'vs_footer_trust_label', 'Trusted by thousands' );
$trust_items = $pid ? get_post_meta( $pid, 'vs_footer_trust_items', true ) : array();
if ( ! is_array( $trust_items ) ) $trust_items = array();
$google_rating = $fm( 'vs_footer_google_rating', '4.9' );
$google_url    = $fm( 'vs_footer_google_url',    '' );

/* Legal */
$copyright  = $fm( 'vs_footer_copyright',  '© 2026 VisaHouse.ae. All rights reserved.' );
$disclaimer = $fm( 'vs_footer_disclaimer', '' );
$legal      = $pid ? get_post_meta( $pid, 'vs_footer_legal', true ) : array();
if ( ! is_array( $legal ) ) $legal = array();
?>

<footer class="vs-footer-main">
    <div class="vs-wrap">
        <div class="vs-footer-grid">

            <!-- Brand -->
            <div class="vs-footer-brand-col">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vs-footer-brand">
                    <?php if ( $footer_logo_url ) : ?>
                        <img src="<?php echo esc_url( $footer_logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="vs-footer-logo">
                    <?php elseif ( has_custom_logo() ) : ?>
                        <?php
                        $logo_id  = get_theme_mod( 'custom_logo' );
                        $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                        ?>
                        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="vs-footer-logo">
                    <?php else : ?>
                        <span class="vs-footer-logo-icon"><?php echo esc_html( vs_logo_initials() ); ?></span>
                        <span class="vs-footer-logo-text">
                            <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
                            <?php if ( $brand_tagline ) : ?>
                                <span class="vs-footer-logo-tagline"><?php echo esc_html( $brand_tagline ); ?></span>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                </a>

                <?php if ( $brand_desc ) : ?>
                    <p class="vs-footer-desc"><?php echo esc_html( $brand_desc ); ?></p>
                <?php endif; ?>

                <?php if ( ! empty( $socials ) ) : ?>
                    <div class="vs-footer-socials">
                        <?php foreach ( $socials as $key => $url ) : ?>
                            <a href="<?php echo esc_url( $url ); ?>"
                               class="vs-footer-social"
                               target="_blank"
                               rel="noopener noreferrer"
                               aria-label="<?php echo esc_attr( ucfirst( $key ) ); ?>">
                                <i class="fa-brands fa-<?php echo esc_attr( $key ); ?>"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Services -->
            <?php if ( ! empty( $services ) ) : ?>
                <div class="vs-footer-col">
                    <h4 class="vs-footer-col-title"><?php echo esc_html( $services_title ); ?></h4>
                    <ul class="vs-footer-col-list">
                        <?php foreach ( $services as $row ) :
                            if ( empty( $row['label'] ) ) continue;
                            ?>
                            <li>
                                <a href="<?php echo esc_url( ! empty( $row['url'] ) ? $row['url'] : '#' ); ?>">
                                    <?php if ( ! empty( $row['icon'] ) ) : ?>
                                        <i class="fa-solid <?php echo esc_attr( $row['icon'] ); ?>"></i>
                                    <?php endif; ?>
                                    <?php echo esc_html( $row['label'] ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Company -->
            <?php if ( ! empty( $company ) ) : ?>
                <div class="vs-footer-col">
                    <h4 class="vs-footer-col-title"><?php echo esc_html( $company_title ); ?></h4>
                    <ul class="vs-footer-col-list">
                        <?php foreach ( $company as $row ) :
                            if ( empty( $row['label'] ) ) continue;
                            ?>
                            <li>
                                <a href="<?php echo esc_url( ! empty( $row['url'] ) ? $row['url'] : '#' ); ?>">
                                    <?php if ( ! empty( $row['icon'] ) ) : ?>
                                        <i class="fa-solid <?php echo esc_attr( $row['icon'] ); ?>"></i>
                                    <?php endif; ?>
                                    <?php echo esc_html( $row['label'] ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Contact -->
            <div class="vs-footer-col">
                <h4 class="vs-footer-col-title"><?php echo esc_html( $contact_title ); ?></h4>
                <ul class="vs-footer-col-list">
                    <?php if ( $contact_phone ) : ?>
                        <li>
                            <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $contact_phone ) ); ?>">
                                <i class="fa-solid fa-phone"></i>
                                <?php echo esc_html( $contact_phone ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ( $contact_email ) : ?>
                        <li>
                            <a href="mailto:<?php echo esc_attr( $contact_email ); ?>">
                                <i class="fa-solid fa-envelope"></i>
                                <?php echo esc_html( $contact_email ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ( $contact_address ) : ?>
                        <li>
                            <a href="#">
                                <i class="fa-solid fa-location-dot"></i>
                                <?php echo esc_html( $contact_address ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ( $contact_hours ) : ?>
                        <li>
                            <a href="#">
                                <i class="fa-solid fa-clock"></i>
                                <?php echo esc_html( $contact_hours ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>

        <!-- Trust row -->
        <div class="vs-footer-trust">
            <span class="vs-footer-trust-label"><?php echo esc_html( $trust_label ); ?></span>
            <div class="vs-footer-trust-items">

                <?php foreach ( $trust_items as $row ) :
                    if ( empty( $row['label'] ) ) continue;
                    ?>
                    <span class="vs-footer-trust-item">
                        <i class="fa-solid <?php echo esc_attr( ! empty( $row['icon'] ) ? $row['icon'] : 'fa-newspaper' ); ?>"></i>
                        <?php echo esc_html( $row['label'] ); ?>
                    </span>
                    <span class="vs-footer-trust-divider"></span>
                <?php endforeach; ?>

                <?php
                $google_tag   = $google_url ? 'a' : 'span';
                $google_attrs = $google_url
                    ? ' href="' . esc_url( $google_url ) . '" target="_blank" rel="noopener noreferrer"'
                    : '';
                ?>
                <<?php echo $google_tag . $google_attrs; ?> class="vs-footer-trust-item vs-footer-trust-google">
                    <svg viewBox="0 0 48 48" width="16" height="16" aria-hidden="true">
                        <path fill="#4285F4" d="M45.12 24.5c0-1.56-.14-3.06-.4-4.5H24v8.51h11.84c-.51 2.75-2.06 5.08-4.39 6.64v5.52h7.11c4.16-3.83 6.56-9.47 6.56-16.17z"/>
                        <path fill="#34A853" d="M24 46c5.94 0 10.92-1.97 14.56-5.33l-7.11-5.52c-1.97 1.32-4.49 2.1-7.45 2.1-5.73 0-10.58-3.87-12.31-9.07H4.34v5.7C7.96 41.07 15.4 46 24 46z"/>
                        <path fill="#FBBC05" d="M11.69 28.18C11.25 26.86 11 25.45 11 24s.25-2.86.69-4.18v-5.7H4.34C2.85 17.09 2 20.45 2 24c0 3.55.85 6.91 2.34 9.88l7.35-5.7z"/>
                        <path fill="#EA4335" d="M24 10.75c3.23 0 6.13 1.11 8.41 3.29l6.31-6.31C34.91 4.18 29.93 2 24 2 15.4 2 7.96 6.93 4.34 14.12l7.35 5.7c1.73-5.2 6.58-9.07 12.31-9.07z"/>
                    </svg>
                    <strong><?php echo esc_html( $google_rating ); ?></strong>
                    <?php esc_html_e( 'on Google', 'visahouse' ); ?>
                </<?php echo $google_tag; ?>>

            </div>
        </div>

        <!-- Legal strip -->
        <div class="vs-footer-legal">
            <div class="vs-footer-legal-left">
                <?php if ( $copyright ) : ?>
                    <p class="vs-footer-copyright"><?php echo esc_html( $copyright ); ?></p>
                <?php endif; ?>
                <?php if ( $disclaimer ) : ?>
                    <p class="vs-footer-disclaimer"><?php echo esc_html( $disclaimer ); ?></p>
                <?php endif; ?>
            </div>

            <?php if ( ! empty( $legal ) ) : ?>
                <div class="vs-footer-legal-right">
                    <ul class="vs-footer-legal-links">
                        <?php foreach ( $legal as $row ) :
                            if ( empty( $row['label'] ) ) continue;
                            ?>
                            <li>
                                <a href="<?php echo esc_url( ! empty( $row['url'] ) ? $row['url'] : '#' ); ?>">
                                    <?php echo esc_html( $row['label'] ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

    </div>
</footer>

<!-- Back to top -->
<button type="button" class="vs-back-to-top" id="vsBackToTop" aria-label="<?php esc_attr_e( 'Back to top', 'visahouse' ); ?>">
    <i class="fa-solid fa-arrow-up"></i>
</button>