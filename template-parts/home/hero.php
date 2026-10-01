<?php
/**
 * Homepage — Hero.
 *
 * @package VisaHouse
 */

$whatsapp    = vs_option( 'vs_whatsapp', '9718003627' );
$rating      = vs_option( 'vs_google_rating', '4.9' );
$badge       = vs_option( 'vs_hero_badge', 'DET-Licensed Provider' );
$title       = vs_option( 'vs_hero_title', "Your family's UAE visa, <em>done for you</em>." );
$sub         = vs_option( 'vs_hero_sub', 'Sponsor your spouse, children, or parents. Exact government fees in under 30 seconds — then we handle the whole application from your phone.' );
$foot        = vs_option( 'vs_hero_foot', 'Free calculator · Itemized government fees · No signup' );
$trust_label = vs_option( 'vs_trust_label', 'Trusted by thousands' );
?>

<section class="vs-hero">
    <div class="vs-wrap vs-hero-grid">

        <div class="vs-hero-content">
            <span class="vs-hero-badge">
                <span class="vs-badge-dot"></span>
                <?php echo esc_html( $badge ); ?>
            </span>

            <h1><?php echo wp_kses_post( $title ); ?></h1>

            <p class="vs-hero-sub"><?php echo esc_html( $sub ); ?></p>

            <div class="vs-hero-cta">
                <button type="button" onclick="vsOpenCalculator()" class="vs-btn vs-btn-primary">
                    <i class="fa-solid fa-calculator"></i>
                    <?php esc_html_e( 'Calculate My Visa Cost', 'visahouse' ); ?>
                </button>
                <button type="button" onclick="vsShowWhatsAppModal()" class="vs-btn vs-btn-wa" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'visahouse' ); ?>">
                    <i class="fa-brands fa-whatsapp"></i>
                </button>
                <a href="#vs-how" class="vs-btn vs-btn-outline"><?php esc_html_e( 'How It Works', 'visahouse' ); ?></a>
            </div>

            <p class="vs-hero-foot">
                <i class="fa-solid fa-circle-check"></i>
                <?php echo esc_html( $foot ); ?>
            </p>

            <div class="vs-hero-trust-pills">
                <span class="vs-hero-pill"><i class="fa-solid fa-bolt"></i> <?php esc_html_e( '30-second estimate', 'visahouse' ); ?></span>
                <span class="vs-hero-pill"><i class="fa-solid fa-shield-halved"></i> <?php esc_html_e( 'DET Licensed', 'visahouse' ); ?></span>
                <span class="vs-hero-pill">
                    <i class="fa-solid fa-star"></i>
                    <?php printf( esc_html__( '%s Google rating', 'visahouse' ), esc_html( $rating ) ); ?>
                </span>
            </div>
        </div>

        <div class="vs-hero-visual">
            <div class="vs-calc-card">
                <div class="vs-calc-head">
                    <h3>
                        <svg class="vs-icon" viewBox="0 0 24 24" fill="currentColor" fill-rule="evenodd">
                            <path d="M6 2h12a2.5 2.5 0 0 1 2.5 2.5v15a2.5 2.5 0 0 1-2.5 2.5H6a2.5 2.5 0 0 1-2.5-2.5v-15A2.5 2.5 0 0 1 6 2zm0 3.2h12v3.4H6zM6 11h2.6v2.4H6zm4.7 0h2.6v2.4h-2.6zm4.7 0H18v2.4h-2.6zM6 15h2.6v2.4H6zm4.7 0h2.6v2.4h-2.6zm4.7 0H18v2.4h-2.6z"/>
                        </svg>
                        <?php esc_html_e( 'Family Visa Calculator', 'visahouse' ); ?>
                    </h3>
                    <span class="vs-calc-live"><?php esc_html_e( 'LIVE FEES', 'visahouse' ); ?></span>
                </div>

                <div class="vs-calc-body">
                    <div class="vs-calc-q"><?php esc_html_e( 'What visa are you looking for?', 'visahouse' ); ?></div>
                    <div class="vs-calc-sub"><?php esc_html_e( 'Tap a category — itemized government fees in under 30 seconds.', 'visahouse' ); ?></div>

                    <!-- STATIC calculator options -->
                    <div class="vs-opt-list">
                        <button type="button" class="vs-opt" data-vs-calc-open data-category="family">
                            <span class="vs-dot"></span>
                            <span class="vs-ot">
                                <b><?php esc_html_e( 'Family / Dependent Visa', 'visahouse' ); ?></b>
                                <span><?php esc_html_e( 'Spouse, children or parents', 'visahouse' ); ?></span>
                            </span>
                            <span class="vs-op"><?php esc_html_e( 'from 1,103', 'visahouse' ); ?></span>
                        </button>

                        <button type="button" class="vs-opt" data-vs-calc-open data-category="golden">
                            <span class="vs-dot"></span>
                            <span class="vs-ot">
                                <b><?php esc_html_e( 'Golden Visa', 'visahouse' ); ?></b>
                                <span><?php esc_html_e( '10-Year long-term UAE residency', 'visahouse' ); ?></span>
                            </span>
                            <span class="vs-op"><?php esc_html_e( 'from 3,864', 'visahouse' ); ?></span>
                        </button>

                        <button type="button" class="vs-opt" data-vs-calc-open data-category="property">
                            <span class="vs-dot"></span>
                            <span class="vs-ot">
                                <b><?php esc_html_e( 'Property Visa', 'visahouse' ); ?></b>
                                <span><?php esc_html_e( 'Residency through property investment', 'visahouse' ); ?></span>
                            </span>
                            <span class="vs-op"><?php esc_html_e( 'from 6,311', 'visahouse' ); ?></span>
                        </button>

                        <button type="button" class="vs-opt" data-vs-calc-open data-category="newborn">
                            <span class="vs-dot"></span>
                            <span class="vs-ot">
                                <b><?php esc_html_e( 'Newborn Visa', 'visahouse' ); ?></b>
                                <span><?php esc_html_e( 'For a baby just born in the UAE', 'visahouse' ); ?></span>
                            </span>
                            <span class="vs-op"><?php esc_html_e( 'from 1,029', 'visahouse' ); ?></span>
                        </button>
                    </div>

                    <p class="vs-consult-line">
                        <?php
                        printf(
                            esc_html__( 'Still doubtful? %s', 'visahouse' ),
                            '<a class="vs-wa-gate" href="https://wa.me/' . esc_attr( $whatsapp ) . '">' . esc_html__( 'Get a free consultation →', 'visahouse' ) . '</a>'
                        );
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="vs-wrap">
        <div class="vs-trust-bar vs-reveal">
            <span class="vs-trust-label"><?php echo esc_html( $trust_label ); ?></span>
            <div class="vs-trust-logos">
                <span class="vs-trust-logo"><i class="fa-solid fa-newspaper"></i> <?php esc_html_e( 'Gulf News', 'visahouse' ); ?></span>
                <span class="vs-trust-divider"></span>
                <span class="vs-trust-logo"><i class="fa-solid fa-newspaper"></i> <?php esc_html_e( 'Khaleej Times', 'visahouse' ); ?></span>
                <span class="vs-trust-divider"></span>
                <span class="vs-trust-rating">
                    <span class="vs-trust-stars">★★★★★</span>
                    <strong><?php echo esc_html( $rating ); ?></strong>
                    <?php esc_html_e( 'on Google', 'visahouse' ); ?>
                </span>
            </div>
        </div>
    </div>
</section>