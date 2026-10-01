/**
 * Services Modal controller — bento style.
 * Author: Mudasir Abbas
 *
 * ID: #vsServicesModal
 * Trigger: #vs-services-modal  OR  [data-vs-open="services"]
 * Functions: vsOpenServicesModal(), vsCloseServicesModal()
 */
(function () {
    'use strict';

    var modal = document.getElementById('vsServicesModal');
    if (!modal) return;

    var closeBtn = modal.querySelector('.vh-x');

    /* ---------- OPEN ---------- */
    window.vsOpenServicesModal = function () {
        modal.hidden = false;
        void modal.offsetWidth;
        modal.classList.add('is-open');
        document.documentElement.style.overflow = 'hidden';
        document.body.classList.add('vs-modal-open');
        if (closeBtn) setTimeout(function () { closeBtn.focus(); }, 400);
    };

    /* ---------- CLOSE ---------- */
    window.vsCloseServicesModal = function () {
        modal.classList.remove('is-open');
        document.documentElement.style.overflow = '';
        document.body.classList.remove('vs-modal-open');
        setTimeout(function () {
            if (!modal.classList.contains('is-open')) modal.hidden = true;
        }, 520);
    };

    /* ---------- EVENTS ---------- */
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

    /* ---------- AUTO-TRIGGER ---------- */
    document.addEventListener('click', function (e) {
        var trigger = e.target.closest('a[href="#vs-services-modal"], [data-vs-open="services"]');
        if (!trigger) return;
        e.preventDefault();
        window.vsOpenServicesModal();
    });

    /* Open on page load if URL already has the hash */
    if (window.location.hash === '#vs-services-modal') {
        setTimeout(function () { window.vsOpenServicesModal(); }, 400);
    }
})();