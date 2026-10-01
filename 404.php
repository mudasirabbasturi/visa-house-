<?php
/**
 * 404.
 *
 * @package VisaHouse
 */

get_header();
?>

<section class="vs-404">
    <div class="vs-wrap vs-404-inner">
        <div class="vs-404-num">404</div>
        <h1><?php esc_html_e( 'Page not found.', 'visahouse' ); ?></h1>
        <p><?php esc_html_e( 'The page you\'re looking for may have moved or no longer exists. Let\'s get you back on track.', 'visahouse' ); ?></p>
        <div class="vs-404-actions">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vs-btn vs-btn-primary">
                <i class="fa-solid fa-house"></i>
                <?php esc_html_e( 'Back to Home', 'visahouse' ); ?>
            </a>
            <button type="button" onclick="vsShowWhatsAppModal()" class="vs-btn vs-btn-outline">
                <i class="fa-brands fa-whatsapp"></i>
                <?php esc_html_e( 'Chat on WhatsApp', 'visahouse' ); ?>
            </button>
        </div>

        <div class="vs-404-search"><?php get_search_form(); ?></div>

        <div class="vs-404-links">
            <h3><?php esc_html_e( 'Popular links', 'visahouse' ); ?></h3>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'Services', 'visahouse' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Articles', 'visahouse' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/#vs-faq' ) ); ?>"><?php esc_html_e( 'FAQ', 'visahouse' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/#vs-about' ) ); ?>"><?php esc_html_e( 'About Us', 'visahouse' ); ?></a></li>
            </ul>
        </div>
    </div>
</section>

<?php get_footer(); ?>
