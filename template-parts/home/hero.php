<?php
/**
 * Homepage — Hero (full-width slider + floating dynamic calculator).
 *
 * @package VisaHouse
 */

/* -------------------------------------------------------------------------
 * 1. Global settings
 * ---------------------------------------------------------------------- */
$whatsapp      = vs_option( 'vs_whatsapp', '9718003627' );
$rating        = vs_option( 'vs_google_rating', '4.9' );
$badge         = vs_option( 'vs_hero_badge', 'DET-Licensed Provider' );
$trust_label   = vs_option( 'vs_trust_label', 'Trusted by thousands' );

/* -------------------------------------------------------------------------
 * 2. Slides — one per service_category term
 * ---------------------------------------------------------------------- */
$hero_cats = get_terms( array(
    'taxonomy'   => 'service_category',
    'hide_empty' => true,
    'number'     => 5,
    'meta_key'   => 'vs_cat_section_order',
    'orderby'    => 'meta_value_num',
    'order'      => 'ASC',
) );

if ( is_wp_error( $hero_cats ) || empty( $hero_cats ) ) {
    $hero_cats = array();
}

// Fallback backgrounds if term meta is empty
$fallback_images = array(
    'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=2000&q=80',
    'https://images.unsplash.com/photo-1546412414-e1885259563a?w=2000&q=80',
    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=2000&q=80',
    'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=2000&q=80',
    'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=2000&q=80',
);

$slides = array();

if ( ! empty( $hero_cats ) ) {
    $i = 0;
    foreach ( $hero_cats as $cat ) {
        $icon  = get_term_meta( $cat->term_id, 'vs_cat_slide_icon', true ) ?: 'fa-grip';
        $image = get_term_meta( $cat->term_id, 'vs_cat_slide_image', true );
        if ( ! $image ) {
            $image = $fallback_images[ $i % count( $fallback_images ) ];
        }

        $section_title = get_term_meta( $cat->term_id, 'vs_cat_section_title', true ) ?: $cat->name;
        $section_desc  = get_term_meta( $cat->term_id, 'vs_cat_section_desc', true );

        if ( '' === $section_desc ) {
            /* translators: %s: category name */
            $section_desc = sprintf(
                __( 'Explore our %s services — 100%% online, itemized government fees, handled end to end.', 'visahouse' ),
                strtolower( $cat->name )
            );
        }

        $slides[] = array(
            'image'    => $image,
            'tag'      => $cat->name,
            'tag_icon' => $icon,
            'big_icon' => $icon,
            'title'    => $section_title,
            'text'     => $section_desc,
            'link'     => get_term_link( $cat ),
            'cta'      => sprintf( __( 'Explore %s', 'visahouse' ), $cat->name ),
            'wa_text'  => sprintf( __( 'Hello VisaHouse, I would like a quote for %s.', 'visahouse' ), $cat->name ),
        );
        $i++;
    }
}

// Absolute fallback — one generic slide
if ( empty( $slides ) ) {
    $slides[] = array(
        'image'    => $fallback_images[0],
        'tag'      => __( 'Trusted & Licensed', 'visahouse' ),
        'tag_icon' => 'fa-shield-halved',
        'big_icon' => 'fa-award',
        'title'    => __( 'Your UAE visa, <em>done for you</em>.', 'visahouse' ),
        'text'     => __( 'Sponsor your spouse, children, or parents. Exact government fees in under 30 seconds — then we handle the whole application from your phone.', 'visahouse' ),
        'link'     => get_post_type_archive_link( 'service' ) ?: home_url( '/' ),
        'cta'      => __( 'Explore Services', 'visahouse' ),
        'wa_text'  => __( 'Hello VisaHouse, I would like a quote.', 'visahouse' ),
    );
}

/* -------------------------------------------------------------------------
 * 3. Calculator rows — same categories, using the same meta
 * ---------------------------------------------------------------------- */
$calc_rows = array();
foreach ( $hero_cats as $cat ) {
    $calc_rows[] = array(
        'slug' => $cat->slug,
        'name' => $cat->name,
        'desc' => wp_trim_words( get_term_meta( $cat->term_id, 'vs_cat_section_desc', true ), 6, '' ) ?: __( 'Get an instant estimate', 'visahouse' ),
        'icon' => get_term_meta( $cat->term_id, 'vs_cat_slide_icon', true ) ?: 'fa-grip',
    );
}

// Guaranteed at least 4 rows so the card never looks empty
if ( count( $calc_rows ) < 4 ) {
    $default_rows = array(
        array( 'slug' => 'family',   'name' => __( 'Family Visa', 'visahouse' ),   'desc' => __( 'Spouse, children or parents', 'visahouse' ), 'icon' => 'fa-people-roof' ),
        array( 'slug' => 'golden',   'name' => __( 'Golden Visa', 'visahouse' ),   'desc' => __( '10-year residency', 'visahouse' ),           'icon' => 'fa-crown' ),
        array( 'slug' => 'property', 'name' => __( 'Property Visa', 'visahouse' ), 'desc' => __( 'Ownership-based residency', 'visahouse' ),   'icon' => 'fa-building' ),
        array( 'slug' => 'newborn',  'name' => __( 'Newborn Visa', 'visahouse' ),  'desc' => __( 'Register a newborn in the UAE', 'visahouse' ), 'icon' => 'fa-baby' ),
    );
    foreach ( $default_rows as $row ) {
        if ( count( $calc_rows ) >= 4 ) break;
        $exists = false;
        foreach ( $calc_rows as $existing ) {
            if ( $existing['slug'] === $row['slug'] ) { $exists = true; break; }
        }
        if ( ! $exists ) $calc_rows[] = $row;
    }
}
?>

<section class="hv2-hero" id="vs-hero">

    <!-- ============================================================
         SLIDER (full width, absolutely positioned)
         ============================================================ -->
    <div class="hv2-slider" id="hv2Slider">
        <div class="hv2-track" id="hv2Track">

            <?php foreach ( $slides as $slide ) :
                $wa_url = 'https://wa.me/' . rawurlencode( $whatsapp ) . '?text=' . rawurlencode( $slide['wa_text'] );
                ?>
                <div class="hv2-slide" style="background-image:url('<?php echo esc_url( $slide['image'] ); ?>')">
                    <div class="hv2-slide-inner">

                        <!-- Left content -->
                        <div class="hv2-slide-content">
                            <span class="hv2-tag">
                                <span class="hv2-tag-icon"><i class="fa-solid <?php echo esc_attr( $slide['tag_icon'] ); ?>"></i></span>
                                <?php echo esc_html( $slide['tag'] ); ?>
                            </span>

                            <h1><?php echo wp_kses_post( $slide['title'] ); ?></h1>
                            <p><?php echo esc_html( $slide['text'] ); ?></p>

                            <div class="hv2-slide-ctas">
                                <a href="<?php echo esc_url( $slide['link'] ); ?>" class="hv2-slide-btn">
                                    <?php echo esc_html( $slide['cta'] ); ?>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>

                                <!-- WhatsApp — uses Customizer number, WhatsApp icon, direct link -->
                                <a href="<?php echo esc_url( $wa_url ); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="hv2-slide-btn-ghost hv2-slide-btn-wa">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <?php esc_html_e( 'Get a quote', 'visahouse' ); ?>
                                </a>
                            </div>

                            <div class="hv2-trust-pills">
                                <span class="hv2-pill"><i class="fa-solid fa-bolt"></i> <?php esc_html_e( '30-second estimate', 'visahouse' ); ?></span>
                                <span class="hv2-pill"><i class="fa-solid fa-shield-halved"></i> <?php esc_html_e( 'DET Licensed', 'visahouse' ); ?></span>
                                <span class="hv2-pill">
                                    <i class="fa-solid fa-star"></i>
                                    <?php printf( esc_html__( '%s Google rating', 'visahouse' ), esc_html( $rating ) ); ?>
                                </span>
                            </div>
                        </div>

                        <!-- Right decorative icon -->
                        <div class="hv2-slide-big-icon" aria-hidden="true">
                            <div class="hv2-slide-big-icon-inner">
                                <i class="fa-solid <?php echo esc_attr( $slide['big_icon'] ); ?>"></i>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <div class="hv2-progress" id="hv2Progress"></div>
    </div>

    <!-- ============================================================
         SLIDER CONTROLS
         ============================================================ -->
    <div class="hv2-controls">
        <div class="hv2-dots" id="hv2Dots">
            <?php foreach ( $slides as $i => $slide ) : ?>
                <button type="button"
                        class="hv2-dot<?php echo 0 === $i ? ' is-active' : ''; ?>"
                        data-index="<?php echo (int) $i; ?>"
                        aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d', 'visahouse' ), $i + 1 ) ); ?>"></button>
            <?php endforeach; ?>
        </div>
        <div class="hv2-arrows">
            <button type="button" class="hv2-arrow" id="hv2Prev" aria-label="<?php esc_attr_e( 'Previous slide', 'visahouse' ); ?>">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <button type="button" class="hv2-arrow" id="hv2Next" aria-label="<?php esc_attr_e( 'Next slide', 'visahouse' ); ?>">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </div>

    <!-- ============================================================
         FLOATING CALCULATOR CARD (static structure, dynamic rows)
         ============================================================ -->
    <div class="hv2-calc-wrap">
        <div class="hv2-calc">

            <div class="hv2-calc-head">
                <div class="hv2-calc-icon"><i class="fa-solid fa-calculator"></i></div>
                <div class="hv2-calc-title-wrap">
                    <div class="hv2-calc-title"><?php esc_html_e( 'Visa Calculator', 'visahouse' ); ?></div>
                    <div class="hv2-calc-sub"><?php esc_html_e( 'Select a service to begin', 'visahouse' ); ?></div>
                </div>
                <span class="hv2-calc-live"><?php esc_html_e( 'LIVE', 'visahouse' ); ?></span>
            </div>

            <div class="hv2-crumbs">
                <span class="hv2-crumb is-current"><?php esc_html_e( 'All Services', 'visahouse' ); ?></span>
            </div>

            <div class="hv2-calc-body">
                <div class="hv2-group">
                    <div class="hv2-group-head">
                        <h4><?php esc_html_e( 'Residence Visas', 'visahouse' ); ?></h4>
                        <span><?php echo esc_html( str_pad( count( $calc_rows ), 2, '0', STR_PAD_LEFT ) ); ?></span>
                    </div>
                    <div class="hv2-row-list">
                        <?php foreach ( $calc_rows as $row ) : ?>
                            <button type="button"
                                    class="hv2-row"
                                    data-vs-calc-open
                                    data-category="<?php echo esc_attr( $row['slug'] ); ?>">
                                <span class="hv2-row-icon">
                                    <i class="fa-solid <?php echo esc_attr( $row['icon'] ); ?>"></i>
                                </span>
                                <span class="hv2-row-text">
                                    <span class="hv2-row-name"><?php echo esc_html( $row['name'] ); ?></span>
                                    <span class="hv2-row-desc"><?php echo esc_html( $row['desc'] ); ?></span>
                                </span>
                                <span class="hv2-radio"></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="hv2-calc-foot">
                <div class="hv2-summary">
                    <span class="hv2-summary-label"><?php esc_html_e( 'Estimated total', 'visahouse' ); ?></span>
                    <span class="hv2-summary-total">
                        <?php esc_html_e( 'AED 0', 'visahouse' ); ?>
                        <small><?php esc_html_e( 'excl. VAT', 'visahouse' ); ?></small>
                    </span>
                </div>
                <div class="hv2-calc-actions">
                    <button type="button" class="hv2-btn hv2-btn-ghost" aria-label="<?php esc_attr_e( 'Reset', 'visahouse' ); ?>">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                    <button type="button" class="hv2-btn hv2-btn-primary" disabled>
                        <i class="fa-solid fa-calculator"></i>
                        <span><?php esc_html_e( 'Calculate', 'visahouse' ); ?></span>
                    </button>
                </div>
            </div>

        </div>
    </div>

</section>

<script>
/* ============================================================================
   Hero slider — self-contained, no dependencies
   Uses data from PHP. If a category is clicked in the calc card, it triggers
   vsOpenCalculator(slug), which main.js already handles.
   ========================================================================= */
(function () {
    'use strict';

    var track   = document.getElementById('hv2Track');
    var dotsEl  = document.getElementById('hv2Dots');
    var progEl  = document.getElementById('hv2Progress');
    var prevBtn = document.getElementById('hv2Prev');
    var nextBtn = document.getElementById('hv2Next');
    var slider  = document.getElementById('hv2Slider');

    if (!track || !dotsEl) return;

    var total    = track.children.length;
    if (total < 1) return;

    var current  = 0;
    var autoInt  = null;
    var progInt  = null;
    var progW    = 0;
    var DURATION = 7000;
    var STEP     = 20;

    function go(i) {
        current = (i + total) % total;
        track.style.transform = 'translateX(-' + (current * 100) + '%)';
        var dots = dotsEl.querySelectorAll('.hv2-dot');
        for (var d = 0; d < dots.length; d++) {
            dots[d].classList.toggle('is-active', d === current);
        }
        progW = 0;
        if (progEl) progEl.style.width = '0%';
    }

    function startAuto() {
        stopAuto();
        progW = 0;
        if (progEl) progEl.style.width = '0%';
        if (total > 1) {
            autoInt = setInterval(function () { go(current + 1); }, DURATION);
            progInt = setInterval(function () {
                progW += (STEP / DURATION) * 100;
                if (progW > 100) progW = 100;
                if (progEl) progEl.style.width = progW + '%';
            }, STEP);
        }
    }

    function stopAuto() {
        if (autoInt) clearInterval(autoInt);
        if (progInt) clearInterval(progInt);
        autoInt = null;
        progInt = null;
    }

    if (prevBtn) prevBtn.addEventListener('click', function () { go(current - 1); startAuto(); });
    if (nextBtn) nextBtn.addEventListener('click', function () { go(current + 1); startAuto(); });

    dotsEl.addEventListener('click', function (e) {
        var dot = e.target.closest('.hv2-dot');
        if (!dot) return;
        go(parseInt(dot.getAttribute('data-index'), 10) || 0);
        startAuto();
    });

    if (slider) {
        slider.addEventListener('mouseenter', stopAuto);
        slider.addEventListener('mouseleave', startAuto);

        var tx0 = 0;
        slider.addEventListener('touchstart', function (e) {
            tx0 = e.touches[0].clientX;
            stopAuto();
        }, { passive: true });

        slider.addEventListener('touchend', function (e) {
            var tx1 = e.changedTouches[0].clientX;
            var diff = tx0 - tx1;
            if (Math.abs(diff) > 50) {
                go(diff > 0 ? current + 1 : current - 1);
            }
            startAuto();
        }, { passive: true });
    }

    /* Calculator row selection → delegates to main.js */
    var rows = document.querySelectorAll('.hv2-row[data-vs-calc-open]');
    for (var i = 0; i < rows.length; i++) {
        rows[i].addEventListener('click', function (e) {
            e.preventDefault();

            /* Visual selection */
            for (var r = 0; r < rows.length; r++) rows[r].classList.remove('is-selected');
            this.classList.add('is-selected');

            var cat = this.getAttribute('data-category');
            if (cat && typeof window.vsOpenCalculator === 'function') {
                window.vsOpenCalculator(cat);
            }

            /* Enable the Calculate button (visual feedback only — real calc lives in the plugin) */
            var calcBtn = document.querySelector('.hv2-btn-primary');
            if (calcBtn) calcBtn.disabled = false;
        });
    }

    startAuto();
})();
</script>