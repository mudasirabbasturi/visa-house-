<?php
/**
 * Sidebar.
 *
 * @package VisaHouse
 */

if ( ! is_active_sidebar( 'vs-sidebar' ) ) {
    return;
}
?>
<aside id="vs-sidebar" class="vs-sidebar">
    <?php dynamic_sidebar( 'vs-sidebar' ); ?>
</aside>
