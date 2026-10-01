<?php
/**
 * Homepage — Final CTA.
 *
 * @package VisaHouse
 */

$title = get_theme_mod( 'vs_cta_title', 'Ready to bring your family together?' );
$text  = get_theme_mod( 'vs_cta_text', 'Calculate your exact government fees, or send us a message — a family visa specialist replies on WhatsApp within minutes.' );
?>

<section class="vs-final-cta vs-reveal">
    <div class="vs-wrap">
        <h2><?php echo esc_html( $title ); ?></h2>
        <p><?php echo esc_html( $text ); ?></p>
        <div class="vs-final-btns">
            <button type="button" onclick="vsOpenCalculator()" class="vs-btn vs-btn-primary">
                <i class="fa-solid fa-calculator"></i>
                <?php esc_html_e( 'Calculate My Cost', 'visahouse' ); ?>
            </button>
            <button type="button" onclick="vsShowWhatsAppModal()" class="vs-btn vs-btn-outline">
                <i class="fa-brands fa-whatsapp"></i>
                <?php esc_html_e( 'Chat on WhatsApp', 'visahouse' ); ?>
            </button>
        </div>
    </div>
</section>