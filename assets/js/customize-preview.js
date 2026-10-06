(function () {
    'use strict';

    function getStyle(id) {
        var el = document.getElementById(id);
        if (!el) { el = document.createElement('style'); el.id = id; document.head.appendChild(el); }
        return el;
    }

    /* ---------------------------------------------------------------- LOGO HEIGHT */
    var logoDesktop = parseInt(vsLogoPreview.desktop, 10), logoMobile = parseInt(vsLogoPreview.mobile, 10);
    function applyLogo() {
        getStyle('vs-logo-live').textContent = '.vs-logo-img { max-height: ' + logoDesktop + 'px !important; width: auto !important; } @media (max-width:768px) { .vs-logo-img { max-height: ' + logoMobile + 'px !important; width: auto !important; } }';
    }
    applyLogo();

    // Logo live preview is currently disabled because we removed postMessage transport in customizer.php 
    // to allow iframe refresh for typography. If re-enabled, uncomment below:
    wp.customize('vs_logo_height', function (v) { v.bind(function (val) { logoDesktop = parseInt(val, 10); applyLogo(); }); });
    wp.customize('vs_logo_height_mobile', function (v) { v.bind(function (val) { logoMobile = parseInt(val, 10); applyLogo(); }); });

})();
