/**
 * VisaHouse Live Customizer Preview.
 *
 * Real-time postMessage bindings for Logo, Colors, and Typography.
 */
(function ($) {
    'use strict';

    if (typeof wp === 'undefined' || !wp.customize) {
        return;
    }

    function setVar(prop, val) {
        document.documentElement.style.setProperty(prop, val);
    }

    function getStyle(id) {
        var el = document.getElementById(id);
        if (!el) {
            el = document.createElement('style');
            el.id = id;
            document.head.appendChild(el);
        }
        return el;
    }

    /* ---------------------------------------------------------------- LOGO HEIGHT */
    var logoDesktop = parseInt((window.vsLogoPreview && vsLogoPreview.desktop) || 48, 10);
    var logoMobile  = parseInt((window.vsLogoPreview && vsLogoPreview.mobile) || 36, 10);

    function applyLogo() {
        getStyle('vs-logo-live').textContent =
            '.vs-logo-img { max-height: ' + logoDesktop + 'px !important; width: auto !important; } ' +
            '@media (max-width:768px) { .vs-logo-img { max-height: ' + logoMobile + 'px !important; width: auto !important; } }';
    }
    applyLogo();

    wp.customize('vs_logo_height', function (v) {
        v.bind(function (val) {
            logoDesktop = parseInt(val, 10);
            applyLogo();
        });
    });
    wp.customize('vs_logo_height_mobile', function (v) {
        v.bind(function (val) {
            logoMobile = parseInt(val, 10);
            applyLogo();
        });
    });

    /* ---------------------------------------------------------------- GLOBAL COLORS */
    wp.customize('vs_color_primary', function (v) {
        v.bind(function (val) { setVar('--primary', val); });
    });
    wp.customize('vs_color_primary_light', function (v) {
        v.bind(function (val) { setVar('--primary-light', val); });
    });
    wp.customize('vs_color_accent', function (v) {
        v.bind(function (val) {
            setVar('--accent', val);
            setVar('--btn-bg', val);
            setVar('--read-more', val);
        });
    });
    wp.customize('vs_color_accent_hover', function (v) {
        v.bind(function (val) {
            setVar('--accent-hover', val);
            setVar('--btn-hover', val);
        });
    });
    wp.customize('vs_color_gold', function (v) {
        v.bind(function (val) { setVar('--gold', val); });
    });
    wp.customize('vs_color_body_bg', function (v) {
        v.bind(function (val) { setVar('--body-bg', val); });
    });
    wp.customize('vs_color_ink', function (v) {
        v.bind(function (val) { setVar('--ink', val); });
    });

    /* ---------------------------------------------------------------- HEADER COLORS */
    wp.customize('vs_color_header_bg', function (v) {
        v.bind(function (val) {
            setVar('--header-bg', val);
            setVar('--nav-bg', val);
        });
    });
    wp.customize('vs_color_nav_link', function (v) {
        v.bind(function (val) { setVar('--nav-link', val); });
    });
    wp.customize('vs_color_nav_link_hover', function (v) {
        v.bind(function (val) { setVar('--nav-link-hover', val); });
    });
    wp.customize('vs_color_nav_link_active', function (v) {
        v.bind(function (val) { setVar('--nav-link-active', val); });
    });

    /* ---------------------------------------------------------------- FOOTER COLORS */
    wp.customize('vs_color_footer_bg', function (v) {
        v.bind(function (val) { setVar('--footer-bg', val); });
    });
    wp.customize('vs_color_footer_text', function (v) {
        v.bind(function (val) { setVar('--footer-text', val); });
    });
    wp.customize('vs_color_footer_link', function (v) {
        v.bind(function (val) { setVar('--footer-link', val); });
    });
    wp.customize('vs_color_footer_link_hover', function (v) {
        v.bind(function (val) { setVar('--footer-link-hover', val); });
    });
    wp.customize('vs_color_footer_social_hover', function (v) {
        v.bind(function (val) { setVar('--footer-social-hover', val); });
    });

    /* ---------------------------------------------------------------- TYPOGRAPHY */
    wp.customize('vs_font_family', function (v) {
        v.bind(function (val) {
            setVar('--font-family', val);
            setVar('--font-bold', val);
            setVar('--font-light', val);
        });
    });
    wp.customize('vs_font_heading', function (v) {
        v.bind(function (val) { setVar('--font-heading', val); });
    });
    wp.customize('vs_font_body_size', function (v) {
        v.bind(function (val) { setVar('--font-body-size', val + 'px'); });
    });
    wp.customize('vs_font_body_line_height', function (v) {
        v.bind(function (val) { setVar('--font-body-line-height', val); });
    });
    wp.customize('vs_font_heading_weight', function (v) {
        v.bind(function (val) { setVar('--font-heading-weight', val); });
    });
    wp.customize('vs_font_heading_transform', function (v) {
        v.bind(function (val) { setVar('--font-heading-transform', val); });
    });

})(jQuery);
