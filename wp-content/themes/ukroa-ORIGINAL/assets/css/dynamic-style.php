<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

header("Content-type: text/css; charset: UTF-8");

// Get customizer settings
$primary_color = get_theme_mod('ukroa_primary_color', '#134e9c');
$header_image = get_header_image() ? get_header_image() : get_template_directory_uri() . '/assets/images/headerbanner.jpg';
?>

header {
    background-image: url("<?php echo esc_url($header_image); ?>");
    background-color: <?php echo esc_attr($primary_color); ?>;
}

/* Additional dynamic styles */
a, .button {
    color: <?php echo esc_attr($primary_color); ?>;
}
.button:hover {
    background-color: <?php echo esc_attr($primary_color); ?>;
    color: #fff;
}