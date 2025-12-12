<?php

// Enhanced security headers
function ukroa_security_headers() {
    // Prevent clickjacking
    header('X-Frame-Options: SAMEORIGIN');
    // XSS protection
    header('X-XSS-Protection: 1; mode=block');
    // Prevent MIME type sniffing
    header('X-Content-Type-Options: nosniff');
    // Referrer policy
    header('Referrer-Policy: strict-origin-when-cross-origin');
    // Content Security Policy (adjust as needed)
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://ajax.googleapis.com; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:;");
}
add_action('send_headers', 'ukroa_security_headers');

// Disable XML-RPC for security
add_filter('xmlrpc_enabled', '__return_false');

// Remove WordPress version info from head and feeds
function ukroa_remove_version_info() {
    return '';
}
add_filter('the_generator', 'ukroa_remove_version_info');

// Sanitize file upload names
function ukroa_sanitize_file_name($filename) {
    $sanitized_filename = remove_accents($filename);
    $sanitized_filename = preg_replace('/[^a-zA-Z0-9\-\._]/', '', $sanitized_filename);
    return $sanitized_filename;
}
add_filter('sanitize_file_name', 'ukroa_sanitize_file_name', 10);

// Limit login attempts (you might want to use a plugin for this)
function ukroa_login_protection() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log'])) {
        $log = sanitize_text_field($_POST['log']);
        if (is_email($log)) {
            $_POST['log'] = sanitize_email($log);
        } else {
            $_POST['log'] = sanitize_user($log);
        }
    }
}
add_action('login_init', 'ukroa_login_protection');
/*security check completed*/


// Theme setup
function ukroa_theme_setup() {
    // Theme supports
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('custom-logo', array('height' => 100, 'width' => 100, 'flex-height' => true));
    add_theme_support('custom-background');
    add_theme_support('automatic-feed-links');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');

    // Register menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'ukroa'),
    ));

    // Register sidebars
    register_sidebar(array(
        'name' => __('Main Sidebar', 'ukroa'),
        'id' => 'main-sidebar',
        'description' => __('Widgets in this area will be shown on all posts and pages.', 'ukroa'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('after_setup_theme', 'ukroa_theme_setup');


  // Enqueue styles and scripts
  function ukroa_scripts() {

wp_localize_script('ukroa-script', 'ukroaData', array(
        'homeUrl' => home_url(),
        'ajaxUrl' => admin_url('admin-ajax.php'),
    ));

/*css*/
      wp_enqueue_style('ukroa-style', get_stylesheet_uri(), array(), '1.0');
      wp_enqueue_style("style.css",get_template_directory_uri()."/assets/css/style.css");


/*font awesome*/
wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

/*javascript*/
      wp_enqueue_script('ukroa-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0', true);

// Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

  }
  add_action('wp_enqueue_scripts', 'ukroa_scripts');

  // Register navigation menu
/*  register_nav_menus(array(
      'primary' => 'Primary Menu',
  ));
*/

 

/****************************************
           dynamic css
   THIS IS THE BEST METHOD TO POST CSS.PHP 
********************************************/


function theme_custom_style_script() {
  wp_enqueue_style( 'dynamic-css', admin_url('admin-ajax.php').'?action=dynamic_css', '', 1.5);
}
add_action( 'wp_enqueue_scripts', 'theme_custom_style_script', 11 );

add_action('wp_ajax_dynamic_css', 'dynamic_css');
add_action('wp_ajax_nopriv_dynamic_css', 'dynamic_css');
function dynamic_css() {
  require( get_template_directory().'/assets/css/dynamic-style.php' );
  exit;
}
/*end of dynamic css*/


// Customizer settings
function ukroa_customize_register($wp_customize) {
    // Section: UKROA Settings
    $wp_customize->add_section('ukroa_settings', array(
        'title' => __('UKROA Theme Settings', 'ukroa'),
        'priority' => 30,
    ));

    // Setting: Primary Color
    $wp_customize->add_setting('ukroa_primary_color', array(
        'default' => '#134e9c',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage', // Changed for live preview
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ukroa_primary_color', array(
        'label' => __('Primary Color', 'ukroa'),
        'section' => 'ukroa_settings',
        'settings' => 'ukroa_primary_color',
    )));



 // Address
    $wp_customize->add_setting('address_setting', array(
        'default' => '2918 E 135 Place,Thornton, CO 80241',
    ));
    $wp_customize->add_control('address_setting', array(
        'label' => 'ADDRESS',
        'section' => 'ukroa_settings',
        'type' => 'text',
    ));

    // Contact
    $wp_customize->add_setting('contact_setting', array(
        'default' => '',
    ));
    $wp_customize->add_control('contact_setting', array(
        'label' => 'CONTACT NUMBER',
        'section' => 'ukroa_settings',
        'type' => 'text',
    ));

    // Email
    $wp_customize->add_setting('email_setting', array(
        'default' => 'ukroa@gmail.com',
    ));
    $wp_customize->add_control('email_setting', array(
        'label' => 'EMAIL ADDRESS',
        'section' => 'ukroa_settings',
        'type' => 'text',
    ));

    // Setting: Footer Copyright Text
    $wp_customize->add_setting('ukroa_footer_text', array(
        'default' => __('&copy; 2025 UKROA. All rights reserved.', 'ukroa'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'postMessage', // Changed for live preview
    ));
    $wp_customize->add_control('ukroa_footer_text', array(
        'label' => __('Footer Copyright Text', 'ukroa'),
        'section' => 'ukroa_settings',
        'type' => 'textarea',
    ));

    // Setting: Social Media Links
    $socials = array(
        'facebook' => __('Facebook URL', 'ukroa'),
        'twitter' => __('Twitter URL', 'ukroa'),
        'instagram' => __('Instagram URL', 'ukroa'),
        'youtube' => __('Youtube URL', 'ukroa'),
    );
    foreach ($socials as $key => $label) {
        $wp_customize->add_setting("ukroa_social_$key", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage', // Changed for live preview
        ));
        $wp_customize->add_control("ukroa_social_$key", array(
            'label' => $label,
            'section' => 'ukroa_settings',
            'type' => 'url',
        ));
    }

    // Setting: Header Image (already supported via custom-header)
    $wp_customize->add_setting('header_image', array(
        'default' => get_template_directory_uri() . '/assets/images/headerbanner.jpg',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage', // Changed for live preview
    ));
}
add_action('customize_register', 'ukroa_customize_register');

// Add editor styles
function ukroa_add_editor_styles() {
    add_editor_style(get_stylesheet_uri());
}
add_action('admin_init', 'ukroa_add_editor_styles');

// Security: Remove WP version from header
remove_action('wp_head', 'wp_generator');

// SEO: Add pingback URL
add_action('wp_head', 'ukroa_pingback_header');
function ukroa_pingback_header() {
    if (is_singular() && pings_open()) {
        echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
    }
}

// Internationalization
load_theme_textdomain('ukroa', get_template_directory() . '/languages');

// Custom Walker for Navigation Menu
class UKROA_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown\" role=\"menu\">\n";
    }
}


// Pagination
add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_archive()) {
        $query->set('posts_per_page', 6);
    }
});

/*dynamic content for gallery*/
$gallery_query = new WP_Query(array('post_type' => 'gallery', 'posts_per_page' => 4));
while ($gallery_query->have_posts()) : $gallery_query->the_post();
    the_post_thumbnail('medium', ['class' => 'gallery-image']);
endwhile;
wp_reset_postdata();