/**
 * Customizer live preview.
 * Handles: logo sizes, font families, font sizes, font weights, colors.
 *
 * Runs inside the Customizer preview iframe (postMessage transport).
 */
( function () {
    'use strict';

    /* ----------------------------------------------------------------
       Utility: get or create a <style> tag by ID
    ---------------------------------------------------------------- */
    function getStyle( id ) {
        var el = document.getElementById( id );
        if ( ! el ) {
            el = document.createElement( 'style' );
            el.id = id;
            document.head.appendChild( el );
        }
        return el;
    }

    /* ----------------------------------------------------------------
       COLOR PRESET MAP (must mirror customizer.php $presets)
    ---------------------------------------------------------------- */
    var PRESETS = {
        brand:  { primary: '#0A1F3D', accent: '#C2410C', hover: '#9A3309' },
        ocean:  { primary: '#0C2340', accent: '#0284C7', hover: '#0369A1' },
        forest: { primary: '#14342B', accent: '#16A34A', hover: '#15803D' },
        slate:  { primary: '#1E293B', accent: '#475569', hover: '#334155' },
        violet: { primary: '#1E0A3D', accent: '#7C3AED', hover: '#6D28D9' },
        sunset: { primary: '#3D0A1F', accent: '#E11D48', hover: '#BE123C' },
        rose:   { primary: '#2D0A1F', accent: '#EC4899', hover: '#DB2777' },
        custom: { primary: '#333333', accent: '#666666', hover: '#444444' },
    };

    /* ----------------------------------------------------------------
       LOGO HEIGHT
    ---------------------------------------------------------------- */
    var logoDesktop = parseInt( vsLogoPreview.desktop, 10 );
    var logoMobile  = parseInt( vsLogoPreview.mobile,  10 );

    function applyLogo() {
        getStyle( 'vs-logo-live' ).textContent =
            '.vs-logo-img { max-height: ' + logoDesktop + 'px !important; width: auto !important; }' +
            ' @media (max-width:768px) { .vs-logo-img { max-height: ' + logoMobile + 'px !important; width: auto !important; } }';
    }
    applyLogo();

    wp.customize( 'vs_logo_height', function( v ) {
        v.bind( function( val ) { logoDesktop = parseInt( val, 10 ); applyLogo(); } );
    } );
    wp.customize( 'vs_logo_height_mobile', function( v ) {
        v.bind( function( val ) { logoMobile = parseInt( val, 10 ); applyLogo(); } );
    } );

    /* ----------------------------------------------------------------
       TYPOGRAPHY — font families
    ---------------------------------------------------------------- */
    wp.customize( 'vs_font_body', function( v ) {
        v.bind( function( val ) {
            document.documentElement.style.setProperty( '--font-family', val );
        } );
    } );
    wp.customize( 'vs_font_heading', function( v ) {
        v.bind( function( val ) {
            document.documentElement.style.setProperty( '--font-heading', val );
        } );
    } );

    /* ----------------------------------------------------------------
       TYPOGRAPHY — font sizes
    ---------------------------------------------------------------- */
    var sizeMap = {
        vs_font_size_body:        function( v ) { document.body.style.fontSize        = v + 'px'; },
        vs_font_size_h1:          function( v ) { getStyle('vs-h1-live').textContent  = 'h1 { font-size: ' + v + 'px !important; }'; },
        vs_font_size_h2:          function( v ) { getStyle('vs-h2-live').textContent  = 'h2 { font-size: ' + v + 'px !important; }'; },
        vs_font_size_h3:          function( v ) { getStyle('vs-h3-live').textContent  = 'h3 { font-size: ' + v + 'px !important; }'; },
        vs_font_size_h4:          function( v ) { getStyle('vs-h4-live').textContent  = 'h4 { font-size: ' + v + 'px !important; }'; },
        vs_font_size_body_mobile: function( v ) { getStyle('vs-body-mob-live').textContent = '@media(max-width:768px){body{font-size:' + v + 'px!important;}}'; },
    };
    Object.keys( sizeMap ).forEach( function( key ) {
        wp.customize( key, function( val ) {
            val.bind( function( newVal ) { sizeMap[ key ]( parseInt( newVal, 10 ) ); } );
        } );
    } );

    /* ----------------------------------------------------------------
       TYPOGRAPHY — weights
    ---------------------------------------------------------------- */
    wp.customize( 'vs_weight_body', function( v ) {
        v.bind( function( val ) { document.body.style.fontWeight = val; } );
    } );
    wp.customize( 'vs_weight_heading', function( v ) {
        v.bind( function( val ) {
            getStyle( 'vs-hw-live' ).textContent = 'h1,h2,h3,h4,h5,h6{font-weight:' + val + '!important;}';
        } );
    } );

    /* ----------------------------------------------------------------
       COLORS — apply CSS custom properties live
    ---------------------------------------------------------------- */
    function hexToRgba( hex, opacity ) {
        var r = parseInt( hex.slice( 1, 3 ), 16 );
        var g = parseInt( hex.slice( 3, 5 ), 16 );
        var b = parseInt( hex.slice( 5, 7 ), 16 );
        return 'rgba(' + r + ',' + g + ',' + b + ',' + opacity + ')';
    }

    function applyColors( primary, accent, hover ) {
        var root = document.documentElement;
        root.style.setProperty( '--primary',      primary );
        root.style.setProperty( '--accent',       accent );
        root.style.setProperty( '--accent-hover', hover );
        root.style.setProperty( '--accent-grad',  'linear-gradient(135deg,' + accent + ' 0%,' + hover + ' 100%)' );
        root.style.setProperty( '--accent-soft',  hexToRgba( accent, 0.07 ) );
        root.style.setProperty( '--accent-soft-2', hexToRgba( accent, 0.03 ) );
    }

    // Track current values
    var colors = {
        primary: vsLogoPreview.primary,
        accent:  vsLogoPreview.accent,
        hover:   vsLogoPreview.hover,
    };

    // Preset swatch picker
    wp.customize( 'vs_color_preset', function( v ) {
        v.bind( function( preset ) {
            var p = PRESETS[ preset ];
            if ( p ) {
                colors.primary = p.primary;
                colors.accent  = p.accent;
                colors.hover   = p.hover;
                applyColors( colors.primary, colors.accent, colors.hover );
            }
        } );
    } );

    // Manual color pickers (override)
    wp.customize( 'vs_color_primary', function( v ) {
        v.bind( function( val ) { colors.primary = val; applyColors( colors.primary, colors.accent, colors.hover ); } );
    } );
    wp.customize( 'vs_color_accent', function( v ) {
        v.bind( function( val ) { colors.accent = val; applyColors( colors.primary, colors.accent, colors.hover ); } );
    } );
    wp.customize( 'vs_color_accent_hover', function( v ) {
        v.bind( function( val ) { colors.hover = val; applyColors( colors.primary, colors.accent, colors.hover ); } );
    } );

} )();
