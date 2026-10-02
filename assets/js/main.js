/**
 * VisaHouse main JS.
 * Author: Mudasir Abbas
 */
(function () {
    'use strict';

    var CFG = window.vsData || {};
    var WA = CFG.whatsapp || '9718003627';

    function $(id) { return document.getElementById(id); }

    /* Theme Toggle */
    window.vsToggleTheme = function() {
        if (document.body.classList.contains('vs-theme-dark')) {
            document.body.classList.remove('vs-theme-dark');
            localStorage.setItem('vs-theme', 'light');
        } else {
            document.body.classList.add('vs-theme-dark');
            localStorage.setItem('vs-theme', 'dark');
        }
    };

    (function() {
        if (localStorage.getItem('vs-theme') === 'dark') {
            document.body.classList.add('vs-theme-dark');
        }
    })();

    /* Analytics */
    window.vsTrack = function (name) {
        try {
            if (typeof gtag === 'function') gtag('event', name, { event_category: 'engagement' });
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({ event: 'user_action', action_name: name });
        } catch (e) { }
    };

    /* Modals */
    window.vsShowModal = function (id) {
        var m = $(id); if (!m) return;
        m.classList.remove('vs-hidden');
        void m.offsetWidth;
        m.classList.add('vs-show');
        document.body.classList.add('vs-has-modal');
    };
    window.vsHideModal = function (id) {
        var m = $(id); if (!m) return;
        m.classList.remove('vs-show');
        document.body.classList.remove('vs-has-modal');
        setTimeout(function () { m.classList.add('vs-hidden'); }, 300);
    };

    document.addEventListener('click', function (e) {
        var t = e.target;
        if (t && t.classList && t.classList.contains('vs-modal-bg') && !t.classList.contains('vs-hidden')) {
            window.vsHideModal(t.id);
        }
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            document.querySelectorAll('.vs-modal-bg.vs-show').forEach(function (el) { window.vsHideModal(el.id); });
        }
    });

    /* WhatsApp */
    window.vsShowWhatsAppModal = function () { window.vsShowModal('vsWaModal'); };

    /* Mobile Drawer */
    var drawer = $('vsMobileDrawer');
    var toggle = $('vsMobileToggle');
    var drawerClose = $('vsMobileDrawerClose');

    window.vsOpenMobileDrawer = function () {
        if (!drawer) return;
        drawer.classList.add('vs-open');
        drawer.setAttribute('aria-hidden', 'false');
        if (toggle) toggle.setAttribute('aria-expanded', 'true');
        document.body.classList.add('vs-drawer-open');
    };

    window.vsCloseMobileDrawer = function () {
        if (!drawer) return;
        drawer.classList.remove('vs-open');
        drawer.setAttribute('aria-hidden', 'true');
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('vs-drawer-open');
    };

    if (toggle) toggle.addEventListener('click', window.vsOpenMobileDrawer);
    if (drawerClose) drawerClose.addEventListener('click', window.vsCloseMobileDrawer);

    // Close drawer when clicking the semi-transparent overlay outside the panel
    if (drawer) {
        drawer.addEventListener('click', function (e) {
            if (e.target === drawer) window.vsCloseMobileDrawer();
        });
    }

    window.vsSendToWhatsApp = function (type) {
        var msg;
        switch (type) {
            case 'family-new':
                msg = 'Hello VisaHouse, I want to apply for a NEW UAE family visa. Please help me get started.';
                break;
            case 'family-renew':
                msg = 'Hello VisaHouse, I want to RENEW my UAE family visa. Please help me with the process.';
                break;
            default:
                msg = "Hello VisaHouse, I'm not sure which option I need. Can you advise me?";
        }
        window.vsHideModal('vsWaModal');
        window.open('https://wa.me/' + WA + '?text=' + encodeURIComponent(msg), '_blank');
    };

    /* Calculator bridge (plugin provides window.pvcOpenCalculator) */
    window.vsOpenCalculator = function (look) {
        window.vsTrack('Calculator_Opened');
        if (typeof window.pvcOpenCalculator !== 'function') {
            var tries = 0;
            (function wait() {
                tries++;
                if (typeof window.pvcOpenCalculator === 'function') {
                    window.pvcOpenCalculator();
                    if (look) vsPickLook(look);
                } else if (tries < 30) {
                    setTimeout(wait, 100);
                }
            })();
            return;
        }
        window.pvcOpenCalculator();
        if (look) vsPickLook(look);
    };

    function vsPickLook(look) {
        var tries = 0;
        (function tryPick() {
            tries++;
            var opt = document.querySelector('#pvcLookingOptions .pvc-option[data-look="' + look + '"]');
            if (opt) opt.click();
            else if (tries < 20) setTimeout(tryPick, 100);
        })();
    }

    /* Bind click on [data-vs-calc-open] */
    document.addEventListener('click', function (e) {
        var el = e.target.closest('[data-vs-calc-open]');
        if (!el) return;
        e.preventDefault();
        var cat = el.getAttribute('data-category');
        window.vsOpenCalculator(cat);
    });

    /* Reveal on scroll */
    function vsReveal() {
        var els = document.querySelectorAll('.vs-reveal');
        if (!('IntersectionObserver' in window)) {
            for (var i = 0; i < els.length; i++) els[i].classList.add('vs-in');
            return;
        }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) { en.target.classList.add('vs-in'); io.unobserve(en.target); }
            });
        }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
        for (var j = 0; j < els.length; j++) io.observe(els[j]);
    }

    /* Smooth anchor scroll */
    document.addEventListener('click', function (e) {
        var a = e.target.closest('a[href^="#"]');
        if (!a) return;
        var href = a.getAttribute('href');
        if (href === '#' || href.length < 2) return;
        var target = document.querySelector(href);
        if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
    });
    /* ============================================================
       REVIEWS SLIDER — pause / play toggle
       ============================================================ */
    (function () {
        var toggle = document.getElementById('vsReviewsToggle');
        var track = document.getElementById('vsReviewsTrack');
        if (!toggle || !track) return;

        var autoplay = track.closest('[data-autoplay]');
        var autoplayOn = autoplay ? autoplay.getAttribute('data-autoplay') === '1' : true;

        // If autoplay was turned off from admin, apply the paused state on load
        if (!autoplayOn) {
            track.style.animationPlayState = 'paused';
            toggle.classList.add('is-paused');
            toggle.setAttribute('aria-pressed', 'true');
            toggle.setAttribute('aria-label', 'Play auto-scroll');
        }

        toggle.addEventListener('click', function () {
            var paused = track.style.animationPlayState === 'paused';
            if (paused) {
                // Play
                track.style.animationPlayState = '';
                toggle.classList.remove('is-paused');
                toggle.setAttribute('aria-pressed', 'false');
                toggle.setAttribute('aria-label', 'Pause auto-scroll');
            } else {
                // Pause
                track.style.animationPlayState = 'paused';
                toggle.classList.add('is-paused');
                toggle.setAttribute('aria-pressed', 'true');
                toggle.setAttribute('aria-label', 'Play auto-scroll');
            }
        });

        // Optional: pause on hover (keep this on by default)
        var wrap = track.closest('.vs-reviews-track-wrap');
        if (wrap) {
            wrap.addEventListener('mouseenter', function () {
                if (!toggle.classList.contains('is-paused')) {
                    track.style.animationPlayState = 'paused';
                }
            });
            wrap.addEventListener('mouseleave', function () {
                if (!toggle.classList.contains('is-paused')) {
                    track.style.animationPlayState = '';
                }
            });
        }
    })();

    /* ============================================================
   BACK TO TOP
   ============================================================ */
    (function () {
        var btn = document.getElementById('vsBackToTop');
        if (!btn) return;

        var ticking = false;
        function onScroll() {
            var y = window.pageYOffset || document.documentElement.scrollTop;
            btn.classList.toggle('is-visible', y > 400);
            ticking = false;
        }
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(onScroll);
                ticking = true;
            }
        }, { passive: true });

        btn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        onScroll();
    })();
    document.addEventListener('DOMContentLoaded', function () { vsReveal(); });

    /* ============================================================
       LANGUAGE SWITCHER (Polylang)
       ============================================================ */
    var langSwitcher = document.getElementById('vsLangSwitcher');
    if (langSwitcher) {
        var langBtn = langSwitcher.querySelector('.vs-lang-btn');

        if (langBtn) {
            langBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                var isOpen = langSwitcher.classList.toggle('is-open');
                langBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        }

        // Close when clicking outside
        document.addEventListener('click', function (e) {
            if (!langSwitcher.contains(e.target)) {
                langSwitcher.classList.remove('is-open');
                if (langBtn) langBtn.setAttribute('aria-expanded', 'false');
            }
        });

        // Close on Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                langSwitcher.classList.remove('is-open');
                if (langBtn) langBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

})();
