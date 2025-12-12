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


?>

   .team-chapter-header::before {
background:url("<?php echo $favicon; ?>");

  }

.ukroa-mission-bg {
  background: linear-gradient(rgba(5, 51, 102, 0.7), rgba(3, 3, 70, 0.97)), 
                url('<?php echo esc_url($mission_bg); ?>?w=2000&h=1200&fit=crop') center/cover no-repeat;
}






<!-- .header-1.spnc-header-center .spnc-navbar .spnc-header{
  background-image: url("<?php echo esc_url($header_image); ?>");
  } -->
  
  <!-- header 2 -->
<!--   .header-sidebar.header-1 .spnc-navbar .spnc-container{
    background-image: url("<?php echo esc_url($header_image); ?>");
 -->
<!--   }
.header-sidebar.header-1 .spnc-navbar .spnc-container{
 background-image: url("<?php echo esc_url($header_image); ?>");
} -->

<!-- end of header 2 -->






