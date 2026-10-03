<?php
/**
 * Homepage — Hero (single-column slider + glow waves + floating calculator / FAB).
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* -------------------------------------------------------------------------
 * 1. Global settings
 * ---------------------------------------------------------------------- */
$whatsapp = vs_option( 'vs_whatsapp', '9718003627' );

/* -------------------------------------------------------------------------
 * 2. Slides
 * ---------------------------------------------------------------------- */
$hero_cats = get_terms( array(
    'taxonomy'   => 'service_category',
    'hide_empty' => false,
    'number'     => 10,
) );

if ( ! is_wp_error( $hero_cats ) && ! empty( $hero_cats ) ) {
    usort( $hero_cats, function( $a, $b ) {
        $oa = (int) get_term_meta( $a->term_id, 'vs_cat_section_order', true );
        $ob = (int) get_term_meta( $b->term_id, 'vs_cat_section_order', true );
        return $oa <=> $ob;
    });
    $hero_cats = array_slice( $hero_cats, 0, 5 );
} else {
    $hero_cats = array();
}

$slides = array();

if ( ! empty( $hero_cats ) ) {
    foreach ( $hero_cats as $cat ) {
        $icon  = get_term_meta( $cat->term_id, 'vs_cat_slide_icon', true ) ?: 'fa-grip';

        $section_title = get_term_meta( $cat->term_id, 'vs_cat_section_title', true ) ?: $cat->name;
        $section_desc  = get_term_meta( $cat->term_id, 'vs_cat_section_desc', true );

        if ( '' === $section_desc ) {
            $section_desc = sprintf(
                __( 'Explore our %s services — 100%% online, itemized government fees, handled end to end.', 'visahouse' ),
                strtolower( $cat->name )
            );
        }

        $slides[] = array(
            'tag'      => $cat->name,
            'tag_icon' => $icon,
            'title'    => $section_title,
            'text'     => $section_desc,
            'link'     => get_term_link( $cat ),
            'cta'      => sprintf( __( 'Explore %s', 'visahouse' ), $cat->name ),
            'wa_text'  => sprintf( __( 'Hello VisaHouse, I would like a quote for %s.', 'visahouse' ), $cat->name ),
        );
    }
}

if ( empty( $slides ) ) {
    $slides[] = array(
        'tag'      => __( 'Trusted & Licensed', 'visahouse' ),
        'tag_icon' => 'fa-shield-halved',
        'title'    => __( 'Your UAE visa, <em>done for you</em>.', 'visahouse' ),
        'text'     => __( 'Sponsor your spouse, children, or parents. Exact government fees in under 30 seconds — then we handle the whole application from your phone.', 'visahouse' ),
        'link'     => get_post_type_archive_link( 'service' ) ?: home_url( '/' ),
        'cta'      => __( 'Explore Services', 'visahouse' ),
        'wa_text'  => __( 'Hello VisaHouse, I would like a quote.', 'visahouse' ),
    );
}

/* -------------------------------------------------------------------------
 * 3. Calculator content
 * ---------------------------------------------------------------------- */
$trigger_query = new WP_Query( array(
    'post_type'      => 'page',
    'meta_key'       => '_wp_page_template',
    'meta_value'     => 'template-calc-triggers.php',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'no_found_rows'  => true,
) );

$trigger_content = '';
if ( $trigger_query->have_posts() ) {
    $trigger_content = $trigger_query->posts[0]->post_content;
    $trigger_content = do_shortcode( $trigger_content );
}
wp_reset_postdata();
?>

<section class="hv3-hero" id="vs-hero">
    <div class="hv3-orb-b" aria-hidden="true"></div>

    <div class="hv3-stage">

        <!-- ============================================================
             SLIDER
             ============================================================ -->
        <div class="hv3-slider" id="hv3Slider">
            <div class="hv3-track" id="hv3Track">

                <?php foreach ( $slides as $i => $slide ) :
                    $wa_url = 'https://wa.me/' . rawurlencode( $whatsapp ) . '?text=' . rawurlencode( $slide['wa_text'] );
                    ?>
                    <div class="hv3-slide<?php echo 0 === $i ? ' is-active' : ''; ?>" data-index="<?php echo (int) $i; ?>">

                        <div class="hv3-graphics" aria-hidden="true">
                            <div class="hv3-glow-pulse"></div>

                            <svg class="hv3-wave w1" viewBox="0 0 1200 400" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="hv3Wave1_<?php echo (int) $i; ?>" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%"   stop-color="#f1243a" stop-opacity="0"/>
                                        <stop offset="35%"  stop-color="#f1243a" stop-opacity=".55"/>
                                        <stop offset="65%"  stop-color="#ff5a5f" stop-opacity=".75"/>
                                        <stop offset="100%" stop-color="#f1243a" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <path d="M -100,320 C 200,220 450,340 700,200 S 1100,120 1300,180"
                                      stroke="url(#hv3Wave1_<?php echo (int) $i; ?>)"
                                      fill="none" stroke-width="2.2" stroke-linecap="round"/>
                            </svg>

                            <svg class="hv3-wave w2" viewBox="0 0 1200 400" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="hv3Wave2_<?php echo (int) $i; ?>" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%"   stop-color="#ff8a94" stop-opacity="0"/>
                                        <stop offset="40%"  stop-color="#ff8a94" stop-opacity=".45"/>
                                        <stop offset="70%"  stop-color="#f1243a" stop-opacity=".6"/>
                                        <stop offset="100%" stop-color="#ff8a94" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <path d="M -100,180 C 250,320 500,120 750,260 S 1150,180 1300,280"
                                      stroke="url(#hv3Wave2_<?php echo (int) $i; ?>)"
                                      fill="none" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>

                            <svg class="hv3-wave w3" viewBox="0 0 1200 400" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="hv3Wave3_<?php echo (int) $i; ?>" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%"   stop-color="#0A1F3D" stop-opacity="0"/>
                                        <stop offset="40%"  stop-color="#0A1F3D" stop-opacity=".3"/>
                                        <stop offset="75%"  stop-color="#1E3A5F" stop-opacity=".5"/>
                                        <stop offset="100%" stop-color="#0A1F3D" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <path d="M -100,80 C 300,220 550,40 800,180 S 1200,80 1300,160"
                                      stroke="url(#hv3Wave3_<?php echo (int) $i; ?>)"
                                      fill="none" stroke-width="1.2" stroke-linecap="round"/>
                            </svg>

                            <svg class="hv3-wave w4" viewBox="0 0 1200 400" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="hv3Wave4_<?php echo (int) $i; ?>" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%"   stop-color="#f1243a" stop-opacity="0"/>
                                        <stop offset="45%"  stop-color="#ff5a5f" stop-opacity=".4"/>
                                        <stop offset="75%"  stop-color="#f1243a" stop-opacity=".55"/>
                                        <stop offset="100%" stop-color="#ff5a5f" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <path d="M -100,260 C 180,140 420,300 680,160 S 1080,240 1300,120"
                                      stroke="url(#hv3Wave4_<?php echo (int) $i; ?>)"
                                      fill="none" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>

                            <svg class="hv3-wave w5" viewBox="0 0 1200 400" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="hv3Wave5_<?php echo (int) $i; ?>" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%"   stop-color="#0A1F3D" stop-opacity="0"/>
                                        <stop offset="50%"  stop-color="#64748B" stop-opacity=".2"/>
                                        <stop offset="80%"  stop-color="#0A1F3D" stop-opacity=".3"/>
                                        <stop offset="100%" stop-color="#0A1F3D" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <path d="M -100,340 C 220,220 480,380 740,220 S 1140,300 1300,220"
                                      stroke="url(#hv3Wave5_<?php echo (int) $i; ?>)"
                                      fill="none" stroke-width="1" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <div class="hv3-slide-inner">
                            <span class="hv3-tag">
                                <span class="hv3-tag-icon">
                                    <i class="fa-solid <?php echo esc_attr( $slide['tag_icon'] ); ?>"></i>
                                </span>
                                <?php echo esc_html( $slide['tag'] ); ?>
                            </span>

                            <h1><?php echo wp_kses_post( $slide['title'] ); ?></h1>
                            <p><?php echo esc_html( $slide['text'] ); ?></p>

                            <div class="hv3-ctas">
                                <a href="<?php echo esc_url( $slide['link'] ); ?>" class="hv3-btn">
                                    <span class="hv3-btn-label"><?php echo esc_html( $slide['cta'] ); ?></span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>

                                <a href="<?php echo esc_url( $wa_url ); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="hv3-btn-ghost hv3-btn-wa">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <?php esc_html_e( 'Get a quote', 'visahouse' ); ?>
                                </a>
                            </div>
                        </div>

                        <span class="hv3-ghost" aria-hidden="true">
                            <?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?>
                        </span>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="hv3-controls">
                <div class="hv3-dots" id="hv3Dots">
                    <?php foreach ( $slides as $i => $slide ) : ?>
                        <button type="button"
                                class="hv3-dot<?php echo 0 === $i ? ' is-active' : ''; ?>"
                                data-index="<?php echo (int) $i; ?>"
                                aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d', 'visahouse' ), $i + 1 ) ); ?>"></button>
                    <?php endforeach; ?>
                </div>
                <div class="hv3-arrows">
                    <button type="button" class="hv3-arrow" id="hv3Prev" aria-label="<?php esc_attr_e( 'Previous slide', 'visahouse' ); ?>">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button type="button" class="hv3-arrow" id="hv3Next" aria-label="<?php esc_attr_e( 'Next slide', 'visahouse' ); ?>">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <div class="hv3-progress" id="hv3Progress"></div>

            <!-- ============ MOBILE FAB (inside the slider) ============ -->
            <?php if ( $trigger_content ) : ?>
            <button type="button" class="hv3-fab" id="hv3Fab" aria-label="<?php esc_attr_e( 'Open visa calculator', 'visahouse' ); ?>">
                <span class="hv3-fab-icon"><i class="fa-solid fa-calculator"></i></span>
                <span class="hv3-fab-text">
                    <b><?php esc_html_e( 'Calculate', 'visahouse' ); ?></b>
                    <span><?php esc_html_e( 'Instant estimate', 'visahouse' ); ?></span>
                </span>
                <span class="hv3-fab-arrow"><i class="fa-solid fa-arrow-up"></i></span>
            </button>
            <?php endif; ?>

        </div>

        <!-- ============================================================
             FLOATING CALCULATOR (desktop) — with collapse toggle
             ============================================================ -->
        <?php if ( $trigger_content ) : ?>
            <aside class="hv3-calc-float" id="hv3CalcFloat" aria-label="<?php esc_attr_e( 'Visa calculator', 'visahouse' ); ?>">

                <!-- Collapse button (top-right corner of the card) -->
                <button type="button"
                        class="hv3-calc-collapse"
                        id="hv3CalcCollapse"
                        aria-label="<?php esc_attr_e( 'Minimize calculator', 'visahouse' ); ?>"
                        aria-expanded="true">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <?php echo $trigger_content; ?>
            </aside>

            <!-- Desktop collapsed FAB (shown when calc is collapsed) -->
            <button type="button"
                    class="hv3-fab hv3-fab--desktop"
                    id="hv3FabDesktop"
                    aria-label="<?php esc_attr_e( 'Open visa calculator', 'visahouse' ); ?>">
                <span class="hv3-fab-icon"><i class="fa-solid fa-calculator"></i></span>
                <span class="hv3-fab-text">
                    <b><?php esc_html_e( 'Calculate', 'visahouse' ); ?></b>
                    <span><?php esc_html_e( 'Instant estimate', 'visahouse' ); ?></span>
                </span>
                <span class="hv3-fab-arrow"><i class="fa-solid fa-arrow-left"></i></span>
            </button>
        <?php endif; ?>

    </div>
</section>

<script>
/* ============================================================================
   Hero slider + calculator FAB / collapse.
   ========================================================================= */
(function () {
  'use strict';

  /* ============================================================
     SLIDER
     ============================================================ */
  var track   = document.getElementById('hv3Track');
  var dotsEl  = document.getElementById('hv3Dots');
  var progEl  = document.getElementById('hv3Progress');
  var prevBtn = document.getElementById('hv3Prev');
  var nextBtn = document.getElementById('hv3Next');
  var slider  = document.getElementById('hv3Slider');

  if (!track || !dotsEl) return;

  var slides = Array.prototype.slice.call(track.querySelectorAll('.hv3-slide'));
  var total = slides.length;
  if (total < 1) return;

  var current = 0;
  var isAnimating = false;
  var autoInt = null, progInt = null, progW = 0;
  var DURATION = 7000, STEP = 20, TOTAL_MS = 1000;

  function go(nextIndex, direction) {
    if (isAnimating) return;
    nextIndex = ((nextIndex % total) + total) % total;
    if (nextIndex === current) return;

    var outgoing = slides[current];
    var incoming = slides[nextIndex];

    var dir = direction || (nextIndex > current ? 'next' : 'prev');
    if (nextIndex === 0 && current === total - 1) dir = 'next';
    if (nextIndex === total - 1 && current === 0) dir = 'prev';

    isAnimating = true;

    outgoing.classList.remove('is-active','is-entering','is-leaving','dir-next','dir-prev');
    incoming.classList.remove('is-active','is-entering','is-leaving','dir-next','dir-prev');
    outgoing.classList.add('is-leaving', 'dir-' + dir);
    incoming.classList.add('is-entering', 'dir-' + dir, 'is-active');

    var dots = dotsEl.querySelectorAll('.hv3-dot');
    for (var d = 0; d < dots.length; d++) {
      dots[d].classList.toggle('is-active', d === nextIndex);
    }
    progW = 0;
    if (progEl) progEl.style.width = '0%';

    setTimeout(function () {
      outgoing.classList.remove('is-leaving','dir-next','dir-prev');
      incoming.classList.remove('is-entering','dir-next','dir-prev');
      current = nextIndex;
      isAnimating = false;
    }, TOTAL_MS + 100);
  }

  function startAuto() {
    stopAuto();
    progW = 0;
    if (progEl) progEl.style.width = '0%';
    if (total > 1) {
      autoInt = setInterval(function () {
        if (!isAnimating) go(current + 1, 'next');
      }, DURATION);
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
    autoInt = null; progInt = null;
  }

  if (prevBtn) prevBtn.addEventListener('click', function () { go(current - 1, 'prev'); startAuto(); });
  if (nextBtn) nextBtn.addEventListener('click', function () { go(current + 1, 'next'); startAuto(); });

  dotsEl.addEventListener('click', function (e) {
    var dot = e.target.closest('.hv3-dot');
    if (!dot) return;
    var idx = parseInt(dot.getAttribute('data-index'), 10) || 0;
    go(idx, idx > current ? 'next' : 'prev');
    startAuto();
  });

  if (slider) {
    slider.addEventListener('mouseenter', stopAuto);
    slider.addEventListener('mouseleave', startAuto);

    var tx0 = 0;
    slider.addEventListener('touchstart', function (e) {
      tx0 = e.touches[0].clientX; stopAuto();
    }, { passive: true });

    slider.addEventListener('touchend', function (e) {
      var tx1 = e.changedTouches[0].clientX;
      var diff = tx0 - tx1;
      if (Math.abs(diff) > 50) {
        go(diff > 0 ? current + 1 : current - 1, diff > 0 ? 'next' : 'prev');
      }
      startAuto();
    }, { passive: true });
  }
  startAuto();

  /* ============================================================
     CALCULATOR — collapse / expand
     Shared between desktop float and mobile FAB.
     ============================================================ */
  var calcFloat     = document.getElementById('hv3CalcFloat');
  var calcCollapse  = document.getElementById('hv3CalcCollapse');
  var fabDesktop    = document.getElementById('hv3FabDesktop');
  var fabMobile     = document.getElementById('hv3Fab');

  function collapseCalc() {
    if (!calcFloat) return;
    calcFloat.classList.add('is-collapsed');
    if (calcCollapse) calcCollapse.setAttribute('aria-expanded', 'false');
    if (fabDesktop) fabDesktop.classList.add('is-visible');
  }
  function expandCalc() {
    if (!calcFloat) return;
    calcFloat.classList.remove('is-collapsed');
    if (calcCollapse) calcCollapse.setAttribute('aria-expanded', 'true');
    if (fabDesktop) fabDesktop.classList.remove('is-visible');
  }

  if (calcCollapse) calcCollapse.addEventListener('click', collapseCalc);
  if (fabDesktop)  fabDesktop.addEventListener('click', expandCalc);

  /* Mobile FAB → open the calculator by scrolling to the trigger page's hash */
  if (fabMobile) {
    fabMobile.addEventListener('click', function () {
      /* Bridge to the theme's calculator opener if present */
      if (typeof window.vsOpenCalculator === 'function') {
        try { window.vsOpenCalculator(); } catch (e) {}
      } else if (typeof window.openCalculator === 'function') {
        try { window.openCalculator(); } catch (e) {}
      } else if (typeof window.pvcOpenCalculator === 'function') {
        try { window.pvcOpenCalculator(); } catch (e) {}
      } else {
        /* Fallback: scroll to the calculator section if it exists */
        var target = document.querySelector('#calculator');
        if (target) target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  }
})();
</script>