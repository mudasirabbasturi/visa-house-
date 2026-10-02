<?php
/**
 * Simple link picker — text input with dynamic content dropdown.
 *
 * @package VisaHouse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vs_link_picker_options() {
    ob_start();
    ?>
    <option value="">+ Content</option>
    <optgroup label="Pages">
        <?php
        $pages = get_pages( array( 'post_status' => 'publish' ) );
        foreach ( $pages as $p ) {
            echo '<option value="' . esc_attr( get_permalink( $p->ID ) ) . '">' . esc_html( $p->post_title ) . '</option>';
        }
        ?>
    </optgroup>
    <optgroup label="Services">
        <?php
        $services = get_posts( array( 'post_type' => 'service', 'numberposts' => -1, 'post_status' => 'publish' ) );
        foreach ( $services as $s ) {
            echo '<option value="' . esc_attr( get_permalink( $s->ID ) ) . '">' . esc_html( $s->post_title ) . '</option>';
        }
        ?>
    </optgroup>
    <optgroup label="Posts">
        <?php
        $posts = get_posts( array( 'post_type' => 'post', 'numberposts' => 50, 'post_status' => 'publish' ) );
        foreach ( $posts as $p ) {
            echo '<option value="' . esc_attr( get_permalink( $p->ID ) ) . '">' . esc_html( $p->post_title ) . '</option>';
        }
        ?>
    </optgroup>
    <?php
    return ob_get_clean();
}

function vs_link_picker( $name, $value = '', $placeholder = 'Paste URL…' ) {
    ?>
    <div class="vs-lp" style="display:flex; gap: 8px; width: 100%;">
        <input type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" style="flex:1; width:100%;">
        <select style="width: 120px; flex-shrink: 0; padding: 0 5px; font-size: 13px;" onchange="if(this.value) { this.previousElementSibling.value = this.value; this.value = ''; }">
            <?php echo vs_link_picker_options(); ?>
        </select>
    </div>
    <?php
}

function vs_link_picker_admin_assets( $hook ) {
    if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
        return;
    }
    $screen = get_current_screen();
    if ( ! $screen || ! in_array( $screen->post_type, array( 'vs_about', 'vs_footer' ), true ) ) {
        return;
    }
    ?>
    <script>
        var vsLpOptions = <?php echo wp_json_encode( vs_link_picker_options() ); ?>;
    </script>
    <?php
}
add_action( 'admin_footer-post.php',     'vs_link_picker_admin_assets' );
add_action( 'admin_footer-post-new.php', 'vs_link_picker_admin_assets' );