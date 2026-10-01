<?php
/**
 * Footer — reads everything from the Customizer.
 *
 * @package VisaHouse
 */

$rating = get_theme_mod( 'vs_google_rating', '4.9' );

// Brand
$brand_tagline = get_theme_mod( 'vs_footer_brand_tagline', 'Global Mobility Solutions' );
$brand_desc    = get_theme_mod( 'vs_footer_brand_desc', 'Your trusted partner for 100% online UAE visa processing.' );

// Socials
$socials = array();
foreach ( array( 'facebook', 'instagram', 'tiktok', 'linkedin', 'youtube' ) as $key ) {
    $url = get_theme_mod( "vs_social_{$key}", '' );
    if ( $url ) {
        $socials[ $key ] = $url;
    }
}
?>

<footer class="vs-footer-main">
    <div class="vs-wrap">
        <div class="vs-footer-grid">

            <!-- Column 1: Brand -->
            <div class="vs-footer-brand-col">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vs-footer-brand">
                    <?php if ( has_custom_logo() ) : ?>
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

            <!-- Column 2: Services -->
            <div class="vs-footer-col">
                <h4 class="vs-footer-col-title"><?php echo esc_html( get_theme_mod( 'vs_footer_services_title', 'Services' ) ); ?></h4>
                <ul class="vs-footer-col-list">
                    <?php for ( $i = 1; $i <= 5; $i++ ) :
                        $label = get_theme_mod( "vs_footer_services_{$i}_label", '' );
                        if ( ! $label ) { continue; }
                        $url  = get_theme_mod( "vs_footer_services_{$i}_url", '#' );
                        $icon = get_theme_mod( "vs_footer_services_{$i}_icon", '' );
                        ?>
                        <li>
                            <a href="<?php echo esc_url( $url ); ?>">
                                <?php if ( $icon ) : ?>
                                    <i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i>
                                <?php endif; ?>
                                <?php echo esc_html( $label ); ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>

            <!-- Column 3: Company -->
            <div class="vs-footer-col">
                <h4 class="vs-footer-col-title"><?php echo esc_html( get_theme_mod( 'vs_footer_company_title', 'Company' ) ); ?></h4>
                <ul class="vs-footer-col-list">
                    <?php for ( $i = 1; $i <= 5; $i++ ) :
                        $label = get_theme_mod( "vs_footer_company_{$i}_label", '' );
                        if ( ! $label ) { continue; }
                        $url  = get_theme_mod( "vs_footer_company_{$i}_url", '#' );
                        $icon = get_theme_mod( "vs_footer_company_{$i}_icon", '' );
                        ?>
                        <li>
                            <a href="<?php echo esc_url( $url ); ?>">
                                <?php if ( $icon ) : ?>
                                    <i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i>
                                <?php endif; ?>
                                <?php echo esc_html( $label ); ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>

            <!-- Column 4: Contact -->
            <div class="vs-footer-col">
                <h4 class="vs-footer-col-title"><?php echo esc_html( get_theme_mod( 'vs_footer_contact_title', 'Contact' ) ); ?></h4>
                <ul class="vs-footer-col-list">
                    <?php
                    $phone   = get_theme_mod( 'vs_footer_contact_phone', '800 DOCS (3627)' );
                    $email   = get_theme_mod( 'vs_footer_contact_email', 'info@visahouse.ae' );
                    $address = get_theme_mod( 'vs_footer_contact_address', 'Business Village, Deira' );
                    $hours   = get_theme_mod( 'vs_footer_contact_hours', 'Sun–Thu · 9am–6pm' );
                    ?>
                    <?php if ( $phone ) : ?>
                        <li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><i class="fa-solid fa-phone"></i> <?php echo esc_html( $phone ); ?></a></li>
                    <?php endif; ?>
                    <?php if ( $email ) : ?>
                        <li><a href="mailto:<?php echo esc_attr( $email ); ?>"><i class="fa-solid fa-envelope"></i> <?php echo esc_html( $email ); ?></a></li>
                    <?php endif; ?>
                    <?php if ( $address ) : ?>
                        <li><a href="#"><i class="fa-solid fa-location-dot"></i> <?php echo esc_html( $address ); ?></a></li>
                    <?php endif; ?>
                    <?php if ( $hours ) : ?>
                        <li><a href="#"><i class="fa-solid fa-clock"></i> <?php echo esc_html( $hours ); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>

        <!-- Trust row -->
        <div class="vs-footer-trust">
            <span class="vs-footer-trust-label"><?php echo esc_html( get_theme_mod( 'vs_footer_trust_label', 'Trusted by thousands' ) ); ?></span>
            <div class="vs-footer-trust-items">

                <?php for ( $i = 1; $i <= 3; $i++ ) :
                    $label = get_theme_mod( "vs_footer_trust_{$i}_label", '' );
                    if ( ! $label ) { continue; }
                    $icon = get_theme_mod( "vs_footer_trust_{$i}_icon", 'fa-newspaper' );
                    ?>
                    <span class="vs-footer-trust-item">
                        <i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i>
                        <?php echo esc_html( $label ); ?>
                    </span>
                    <span class="vs-footer-trust-divider"></span>
                <?php endfor; ?>

                <span class="vs-footer-trust-item vs-footer-trust-google">
                    <svg viewBox="0 0 48 48" width="16" height="16" aria-hidden="true">
                        <path fill="#4285F4" d="M45.12 24.5c0-1.56-.14-3.06-.4-4.5H24v8.51h11.84c-.51 2.75-2.06 5.08-4.39 6.64v5.52h7.11c4.16-3.83 6.56-9.47 6.56-16.17z"/>
                        <path fill="#34A853" d="M24 46c5.94 0 10.92-1.97 14.56-5.33l-7.11-5.52c-1.97 1.32-4.49 2.1-7.45 2.1-5.73 0-10.58-3.87-12.31-9.07H4.34v5.7C7.96 41.07 15.4 46 24 46z"/>
                        <path fill="#FBBC05" d="M11.69 28.18C11.25 26.86 11 25.45 11 24s.25-2.86.69-4.18v-5.7H4.34C2.85 17.09 2 20.45 2 24c0 3.55.85 6.91 2.34 9.88l7.35-5.7z"/>
                        <path fill="#EA4335" d="M24 10.75c3.23 0 6.13 1.11 8.41 3.29l6.31-6.31C34.91 4.18 29.93 2 24 2 15.4 2 7.96 6.93 4.34 14.12l7.35 5.7c1.73-5.2 6.58-9.07 12.31-9.07z"/>
                    </svg>
                    <strong><?php echo esc_html( $rating ); ?></strong>
                    <?php esc_html_e( 'on Google', 'visahouse' ); ?>
                </span>

            </div>
        </div>

        <!-- Legal strip -->
        <div class="vs-footer-legal">
            <div class="vs-footer-legal-left">
                <p class="vs-footer-copyright"><?php echo esc_html( get_theme_mod( 'vs_footer_copyright', '© 2026 VisaHouse.ae. All rights reserved.' ) ); ?></p>
                <p class="vs-footer-disclaimer"><?php echo esc_html( get_theme_mod( 'vs_footer_disclaimer', '' ) ); ?></p>
            </div>

            <div class="vs-footer-legal-right">
                <ul class="vs-footer-legal-links">
                    <?php for ( $i = 1; $i <= 3; $i++ ) :
                        $label = get_theme_mod( "vs_footer_legal_{$i}_label", '' );
                        if ( ! $label ) { continue; }
                        $url = get_theme_mod( "vs_footer_legal_{$i}_url", '#' );
                        ?>
                        <li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
                    <?php endfor; ?>
                </ul>
            </div>
        </div>

    </div>
</footer>

<!-- Back to top -->
<button type="button" class="vs-back-to-top" id="vsBackToTop" aria-label="<?php esc_attr_e( 'Back to top', 'visahouse' ); ?>">
    <i class="fa-solid fa-arrow-up"></i>
</button>