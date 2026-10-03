<?php
/**
 * Header — logo, primary menu, mobile drawer, top-bar actions.
 *
 * @package VisaHouse
 * @author  Mudasir Abbas
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="theme-color" content="#0A1F3D">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="vs-skip-link" href="#vs-main"><?php esc_html_e( 'Skip to content', 'visahouse' ); ?></a>

<?php do_action( 'vs_before_header' ); ?>

<!-- ============================================================
     TOP BAR
     ============================================================ -->
<header class="vs-topbar" id="vsTopbar">
    <div class="vs-wrap vs-topbar-in">

        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vs-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
            <?php if ( has_custom_logo() ) : ?>
                <?php
                $logo_id  = get_theme_mod( 'custom_logo' );
                $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                ?>
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="vs-logo-img">
            <?php else : ?>
                <span class="vs-logo-icon"><?php echo esc_html( vs_logo_initials() ); ?></span>
                <span class="vs-logo-text">
                    <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
                    <?php if ( get_bloginfo( 'description' ) ) : ?>
                        <span class="vs-logo-tagline"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></span>
                    <?php endif; ?>
                </span>
            <?php endif; ?>
        </a>

        <!-- Primary Menu -->
        <nav class="vs-nav-main" aria-label="<?php esc_attr_e( 'Primary navigation', 'visahouse' ); ?>">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'vs-menu',
                    'menu_id'        => 'vs-primary-menu',
                    'depth'          => 2,
                    'walker'         => new VS_Walker_Nav(),
                    'fallback_cb'    => false,
                ) );
            } else {
                echo '<ul class="vs-menu">';
                echo '<li class="vs-nav-item"><a class="vs-nav-link" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Set up your menu →', 'visahouse' ) . '</a></li>';
                echo '</ul>';
            }
            ?>
        </nav>

        <!-- Actions -->
        <div class="vs-topbar-actions">

            <!-- ================================================
                 LANGUAGE SWITCHER (Polylang) — Desktop
                 Button shows globe + code. Dropdown shows flags.
                 ================================================ -->
            <?php if ( function_exists( 'pll_the_languages' ) ) : ?>
                <?php
                $langs = pll_the_languages( array(
                    'raw'           => 1,
                    'hide_if_empty' => 0,
                    'hide_current'  => 0,
                    'show_flags'    => 1,
                    'show_names'    => 1,
                ) );
                ?>
                <?php if ( ! empty( $langs ) ) : ?>
                    <div class="vs-lang-switcher vs-hide-mobile" id="vsLangSwitcher">

                        <!-- Trigger button — flag of current language + code -->
                        <button type="button"
                                class="vs-lang-btn"
                                aria-haspopup="true"
                                aria-expanded="false"
                                aria-label="<?php esc_attr_e( 'Change language', 'visahouse' ); ?>">
                            <?php
                            // Get the current language's flag
                            $vs_current_flag_html = '';
                            if ( function_exists( 'pll_current_language' ) && ! empty( $langs ) ) {
                                $vs_current_slug = pll_current_language();
                                foreach ( $langs as $vs_l ) {
                                    if ( isset( $vs_l['slug'] ) && $vs_l['slug'] === $vs_current_slug ) {
                                        if ( ! empty( $vs_l['flag'] ) ) {
                                            $vs_current_flag_html = $vs_l['flag'];
                                        }
                                        break;
                                    }
                                }
                            }
                            ?>

                            <?php if ( $vs_current_flag_html ) : ?>
                                <span class="vs-lang-flag vs-lang-flag-current">
                                    <?php echo $vs_current_flag_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </span>
                            <?php else : ?>
                                <i class="fa-solid fa-globe" aria-hidden="true"></i>
                            <?php endif; ?>

                            <span class="vs-lang-cur">
                                <?php echo esc_html( strtoupper( pll_current_language() ) ); ?>
                            </span>
                            <i class="fa-solid fa-chevron-down vs-lang-chevron" aria-hidden="true"></i>
                        </button>

                        <!-- Dropdown menu — flags INSIDE each option -->
                        <ul class="vs-lang-menu" role="menu">
                            <?php foreach ( $langs as $lang ) : ?>
                                <li role="none" class="<?php echo ! empty( $lang['current_lang'] ) ? 'is-current' : ''; ?>">
                                    <a role="menuitem"
                                       href="<?php echo esc_url( $lang['url'] ); ?>"
                                       hreflang="<?php echo esc_attr( $lang['locale'] ); ?>"
                                       lang="<?php echo esc_attr( $lang['locale'] ); ?>">
                                        <?php if ( ! empty( $lang['flag'] ) ) : ?>
                                            <span class="vs-lang-flag"><?php echo $lang['flag']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                                        <?php endif; ?>
                                        <span class="vs-lang-name"><?php echo esc_html( $lang['name'] ); ?></span>
                                        <span class="vs-lang-code"><?php echo esc_html( strtoupper( $lang['slug'] ) ); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- WhatsApp -->
            <button type="button" onclick="vsShowWhatsAppModal()" class="vs-btn vs-btn-wa vs-hide-mobile" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'visahouse' ); ?>">
                <i class="fa-brands fa-whatsapp"></i>
            </button>

            <button type="button" onclick="vsOpenCalculator();vsCloseMobileDrawer();" class="vs-btn vs-btn-outline">
                <i class="fa-solid fa-calculator"></i>                   
            </button>

            <!-- Mobile toggle -->
            <button type="button" class="vs-icon-btn vs-mobile-toggle" id="vsMobileToggle" aria-label="<?php esc_attr_e( 'Open menu', 'visahouse' ); ?>" aria-expanded="false">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<!-- ============================================================
     MOBILE DRAWER
     ============================================================ -->
<div class="vs-mobile-drawer" id="vsMobileDrawer" aria-hidden="true" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Mobile navigation', 'visahouse' ); ?>">
    <div class="vs-mobile-drawer-panel">
        <div class="vs-mobile-drawer-head">
            <?php if ( has_custom_logo() ) : ?>
                <?php
                $logo_id  = get_theme_mod( 'custom_logo' );
                $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                ?>
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="vs-logo-img" style="max-height:36px;width:auto;">
            <?php else : ?>
                <span class="vs-logo-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
            <?php endif; ?>
            <button type="button" class="vs-mobile-drawer-close" id="vsMobileDrawerClose" aria-label="<?php esc_attr_e( 'Close menu', 'visahouse' ); ?>">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="vs-mobile-drawer-body">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'vs-mobile-menu',
                    'menu_id'        => 'vs-mobile-menu',
                    'depth'          => 2,
                    'walker'         => new VS_Walker_Nav(),
                    'fallback_cb'    => false,
                ) );
            }
            ?>

            <!-- ================================================
                 LANGUAGE SWITCHER (Polylang) — Mobile drawer
                 ================================================ -->
            <?php if ( function_exists( 'pll_the_languages' ) ) : ?>
                <?php
                $langs_m = pll_the_languages( array(
                    'raw'           => 1,
                    'hide_if_empty' => 0,
                    'hide_current'  => 0,
                    'show_flags'    => 1,
                    'show_names'    => 1,
                ) );
                ?>
                <?php if ( ! empty( $langs_m ) ) : ?>
                    <div class="vs-mobile-lang">
                        <div class="vs-mobile-lang-title"><?php esc_html_e( 'Language', 'visahouse' ); ?></div>
                        <ul class="vs-mobile-lang-list">
                            <?php foreach ( $langs_m as $lang ) : ?>
                                <li class="<?php echo ! empty( $lang['current_lang'] ) ? 'is-current' : ''; ?>">
                                    <a href="<?php echo esc_url( $lang['url'] ); ?>"
                                       hreflang="<?php echo esc_attr( $lang['locale'] ); ?>"
                                       lang="<?php echo esc_attr( $lang['locale'] ); ?>">
                                        <?php if ( ! empty( $lang['flag'] ) ) : ?>
                                            <span class="vs-lang-flag"><?php echo $lang['flag']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                                        <?php endif; ?>
                                        <span class="vs-lang-name"><?php echo esc_html( $lang['name'] ); ?></span>
                                        <span class="vs-lang-code"><?php echo esc_html( strtoupper( $lang['slug'] ) ); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="vs-mobile-drawer-foot">
            <button type="button" onclick="vsShowWhatsAppModal();vsCloseMobileDrawer();" class="vs-btn vs-btn-wa" style="width:100%;height:50px;">
                <i class="fa-brands fa-whatsapp"></i>
                <?php esc_html_e( 'Chat on WhatsApp', 'visahouse' ); ?>
            </button>
        </div>
    </div>
</div>

<?php do_action( 'vs_after_header' ); ?>

<?php /* [vfc_trigger] — rendered globally so the calculator modal is available on every page */ ?>
<?php echo do_shortcode( '[vfc_trigger]' ); ?>

<main id="vs-main" class="vs-main">