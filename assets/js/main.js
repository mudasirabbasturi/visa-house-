/**
 * VisaHouse main JS.
 * Author: Mudasir Abbas
 *
 * Includes:
 *  - Modals (WhatsApp, services)
 *  - Mobile drawer
 *  - Language switcher (Polylang)
 *  - Calculator bridge
 *  - Reviews slider pause/play
 *  - Back-to-top button
 *  - Reveal on scroll
 *  - Smooth anchor scroll
 *  - Services modal controller (was modal-services.js)
 */
(function () {
    'use strict';

    var CFG = window.vsData || {};
    var WA = CFG.whatsapp || '9718003627';

    function $(id) { return document.getElementById(id); }


    /* ============================================================
       TRACKING HELPER
       ============================================================ */
    window.vsTrack = function (name) {
        try {
            if (typeof gtag === 'function') gtag('event', name, { event_category: 'engagement' });
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({ event: 'user_action', action_name: name });
        } catch (e) { }
    };


    /* ============================================================
       GENERIC MODALS (WhatsApp, etc.)
       ============================================================ */
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


    /* ============================================================
       MOBILE DRAWER
       ============================================================ */
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

    if (drawer) {
        drawer.addEventListener('click', function (e) {
            if (e.target === drawer) window.vsCloseMobileDrawer();
        });
    }


    /* ============================================================
       SERVICES MODAL (was modal-services.js)
       ID: #vsServicesModal
       Trigger: #vs-services-modal  OR  [data-vs-open="services"]
       ============================================================ */
    (function () {
        var modal = document.getElementById('vsServicesModal');
        if (!modal) return;

        var closeBtn = modal.querySelector('.vh-x');

        window.vsOpenServicesModal = function () {
            modal.hidden = false;
            void modal.offsetWidth;
            modal.classList.add('is-open');
            document.documentElement.style.overflow = 'hidden';
            document.body.classList.add('vs-modal-open');
            if (closeBtn) setTimeout(function () { closeBtn.focus(); }, 400);
        };

        window.vsCloseServicesModal = function () {
            modal.classList.remove('is-open');
            document.documentElement.style.overflow = '';
            document.body.classList.remove('vs-modal-open');
            setTimeout(function () {
                if (!modal.classList.contains('is-open')) modal.hidden = true;
            }, 520);
        };

        if (closeBtn) closeBtn.addEventListener('click', window.vsCloseServicesModal);

        modal.addEventListener('click', function (e) {
            if (e.target === modal) window.vsCloseServicesModal();
        });

        document.addEventListener('keydown', function (e) {
            if ((e.key === 'Escape' || e.keyCode === 27) && modal.classList.contains('is-open')) {
                window.vsCloseServicesModal();
            }
        });

        /* Focus trap */
        modal.addEventListener('keydown', function (e) {
            if (e.key !== 'Tab') return;
            var f = modal.querySelectorAll('a[href], button:not([disabled])');
            if (!f.length) return;
            var first = f[0], last = f[f.length - 1];
            if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
            else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        });

        /* Auto-trigger */
        document.addEventListener('click', function (e) {
            var trigger = e.target.closest('a[href="#vs-services-modal"], [data-vs-open="services"]');
            if (!trigger) return;
            e.preventDefault();
            window.vsOpenServicesModal();
        });

        /* Open on page load if URL has the hash */
        if (window.location.hash === '#vs-services-modal') {
            setTimeout(function () { window.vsOpenServicesModal(); }, 400);
        }
    })();


    /* ============================================================
       CALCULATOR BRIDGE (plugin provides window.pvcOpenCalculator)
       ============================================================ */
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

    document.addEventListener('click', function (e) {
        var el = e.target.closest('[data-vs-calc-open]');
        if (!el) return;
        e.preventDefault();
        var cat = el.getAttribute('data-category');
        window.vsOpenCalculator(cat);
    });


    /* ============================================================
       REVEAL ON SCROLL
       ============================================================ */
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


    /* ============================================================
       SMOOTH ANCHOR SCROLL
       ============================================================ */
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

        if (!autoplayOn) {
            track.style.animationPlayState = 'paused';
            toggle.classList.add('is-paused');
            toggle.setAttribute('aria-pressed', 'true');
            toggle.setAttribute('aria-label', 'Play auto-scroll');
        }

        toggle.addEventListener('click', function () {
            var paused = track.style.animationPlayState === 'paused';
            if (paused) {
                track.style.animationPlayState = '';
                toggle.classList.remove('is-paused');
                toggle.setAttribute('aria-pressed', 'false');
                toggle.setAttribute('aria-label', 'Pause auto-scroll');
            } else {
                track.style.animationPlayState = 'paused';
                toggle.classList.add('is-paused');
                toggle.setAttribute('aria-pressed', 'true');
                toggle.setAttribute('aria-label', 'Play auto-scroll');
            }
        });

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


    /* ============================================================
       LANGUAGE SWITCHER (Polylang)
       ============================================================ */
    (function () {
        var langSwitcher = document.getElementById('vsLangSwitcher');
        if (!langSwitcher) return;

        var langBtn = langSwitcher.querySelector('.vs-lang-btn');

        if (langBtn) {
            langBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                var isOpen = langSwitcher.classList.toggle('is-open');
                langBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        }

        document.addEventListener('click', function (e) {
            if (!langSwitcher.contains(e.target)) {
                langSwitcher.classList.remove('is-open');
                if (langBtn) langBtn.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                langSwitcher.classList.remove('is-open');
                if (langBtn) langBtn.setAttribute('aria-expanded', 'false');
            }
        });
    })();


    /* ============================================================
       INIT
       ============================================================ */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', vsReveal);
    } else {
        vsReveal();
    }

})();