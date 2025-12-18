<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

header("Content-type: text/css; charset: UTF-8");

// Get customizer settings
$primary_color = get_theme_mod('ukroa_primary_color', '#134e9c');
/*$header_image = get_header_image() ? get_header_image() : get_template_directory_uri() . '/assets/images/headerbanner.jpg';*/
$mission_bg=get_template_directory_uri() . '/assets/images/dance.jpg';
$header_image = get_template_directory_uri() . '/assets/images/headerimage.jpg';
$donate_image = get_template_directory_uri() . '/assets/images/donate_button.png';
$donate_hover = get_template_directory_uri() . '/assets/images/donate_button_hover.png';
$favicon = get_template_directory_uri() . '/assets/images/favicon.jpg';
$wabuflag=get_template_directory_uri() . '/assets/images/wabu.jpg';

?>

   .team-chapter-header::before {
background:url("<?php echo $favicon; ?>");

  }

 .spnc-topbar::before {
background-image: url("<?php echo $wabuflag; ?>");
}