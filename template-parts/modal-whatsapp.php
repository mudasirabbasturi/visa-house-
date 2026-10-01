<?php
/**
 * WhatsApp modal — loaded globally in footer.
 *
 * @package VisaHouse
 */
?>
<div id="vsWaModal" class="vs-modal-bg vs-hidden" role="dialog" aria-modal="true" aria-labelledby="vs-wa-title">
    <div class="vs-modal">
        <div class="vs-modal-grab"></div>
        <div class="vs-modal-icon vs-wa"><i class="fa-brands fa-whatsapp"></i></div>
        <h3 id="vs-wa-title"><?php esc_html_e( 'How can we help?', 'visahouse' ); ?></h3>
        <p><?php esc_html_e( "Tap one and we'll connect you on WhatsApp.", 'visahouse' ); ?></p>

        <div class="vs-modal-options">
            <button type="button" onclick="vsSendToWhatsApp('family-new')" class="vs-modal-option">
                <span class="vs-modal-option-icon"><i class="fa-solid fa-people-roof"></i></span>
                <span class="vs-modal-option-text">
                    <b><?php esc_html_e( 'New Family Visa', 'visahouse' ); ?></b>
                    <span><?php esc_html_e( 'Sponsor spouse / children / parents', 'visahouse' ); ?></span>
                </span>
                <span class="vs-modal-option-arrow"><i class="fa-solid fa-chevron-right"></i></span>
            </button>
            <button type="button" onclick="vsSendToWhatsApp('family-renew')" class="vs-modal-option">
                <span class="vs-modal-option-icon"><i class="fa-solid fa-arrows-rotate"></i></span>
                <span class="vs-modal-option-text">
                    <b><?php esc_html_e( 'Family Visa Renewal', 'visahouse' ); ?></b>
                    <span><?php esc_html_e( 'Renew existing dependent visa', 'visahouse' ); ?></span>
                </span>
                <span class="vs-modal-option-arrow"><i class="fa-solid fa-chevron-right"></i></span>
            </button>
            <button type="button" onclick="vsSendToWhatsApp('unsure')" class="vs-modal-option">
                <span class="vs-modal-option-icon"><i class="fa-solid fa-circle-question"></i></span>
                <span class="vs-modal-option-text">
                    <b><?php esc_html_e( 'Not sure / Need advice', 'visahouse' ); ?></b>
                    <span><?php esc_html_e( 'Help me with my situation', 'visahouse' ); ?></span>
                </span>
                <span class="vs-modal-option-arrow"><i class="fa-solid fa-chevron-right"></i></span>
            </button>
        </div>

        <button type="button" onclick="vsHideModal('vsWaModal')" class="vs-modal-cancel">
            <?php esc_html_e( 'Cancel', 'visahouse' ); ?>
        </button>
    </div>
</div>
