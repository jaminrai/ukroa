<?php
/*
* Plugin Name:			Spice Post Slider
* Plugin URI:  			https://spicethemes.com/spice-post-slider/
* Description: 			This plugin allows you to showcase your blog posts in a beautiful slider with multiple options, It is responsive ready so it will work perfectly on different devices like mobile and iPad.
* Version:     			2.2
* Requires at least: 	5.3
* Requires PHP: 		5.2
* Tested up to: 		6.7.1
* Author:      			Spicethemes
* Author URI:  			https://spicethemes.com
* License: 				GPLv2 or later
* License URI: 			https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: 			spice-post-slider
* Domain Path:  		/languages
*/

// Prevent direct access to the file
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Assuming WC_PLUGIN_VERSION is defined somewhere in your plugin
if ( ! defined( 'SPS_PLUGIN_VERSION' ) ) {
    define( 'SPS_PLUGIN_VERSION', '2.2' );
}

if ( ! function_exists( 'sps_fs' ) ) {
    // Create a helper function for easy SDK access.
    function sps_fs() {
        global $sps_fs;
        if ( ! isset( $sps_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';
            $sps_fs = fs_dynamic_init( array(
                'id'                  => '10387',
                'slug'                => 'spice-post-slider',
                'premium_slug'        => 'spice-slider-pro',
                'type'                => 'plugin',
                'public_key'          => 'pk_797717fa803cad604c2d361303c8f',
                'is_premium'          => false,
                'premium_suffix'      => 'Pro',
                // If your plugin is a serviceware, set this option to false.
                'has_premium_version' => true,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'menu'                => array(
                    'slug'           => 'edit.php?post_type=spice_post_slider',
                    'first-path'     => 'edit.php?post_type=spice_post_slider&page=sps-about',
                ),
            ) );
        }
        return $sps_fs;
    }
    // Init Freemius.
    sps_fs();
    // Signal that SDK was initiated.
    do_action( 'sps_fs_loaded' );
}

// Exit if accessed directly
if( ! defined('ABSPATH'))
{
	die('Do not open this file directly.');
}

/**
 * Main Spice_Post_Slider Class
 *
 * @class Spice_Post_Slider
 * @version 2.1
 * @since 0.1
 * @package Spice_Post_Slider
 */

final class Spice_Post_Slider {

	/**
	 * The version number, plugin url and path.
	 *
	 * @var     string
	 * @access  public
	 * @since   0.1
	 */
	public $version;
	public $plugin_url;
    public $plugin_path;

	/**
	 * Constructor function.
	 *
	 * @access  public
	 * @since   0.1
	 * @return  void
	 */
	public function __construct() {
		$this->plugin_url  = plugin_dir_url( __FILE__ );
		$this->plugin_path = plugin_dir_path( __FILE__ );
		$this->version     = '2.2';

		define( 'SPS_URL', $this->plugin_url );
		define( 'SPS_PATH', $this->plugin_path );
		define( 'SPS_VERSION', $this->version );

		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		//Register spice_post_slider CPT
		require_once SPS_PATH . 'include/admin/sps-cpt.php';

		//Output file to view post slider
		require_once SPS_PATH . '/include/view/shortcode.php';

		//Font file
		require_once SPS_PATH . '/include/admin/sps-fonts.php';
	}

	/**
	 * Load the localisation file.
	 *
	 * @access  public
	 * @since   0.1
	 * @return  void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'spice-post-slider' , false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}


}

new Spice_Post_Slider;

/* option page submenu */
add_action( 'admin_menu', 'sps_admin_about_page' );
function sps_admin_about_page() {
    add_submenu_page('edit.php?post_type=spice_post_slider', 'Spice Post Slider', 'About', 'manage_options', 'sps-about', 'sps_admin_about_page_detail', '2');

    function sps_admin_about_page_detail() {
        include( plugin_dir_path( __FILE__ ) . 'include/admin/sps-about-page.php');
    }
}


function sps_save_image_to_media_library($image_url, $image_name = 'image') {
    // Get the upload directory
    $upload_dir = wp_upload_dir();
    
    // Get the file name and path
    $filename = basename($image_url);
    $file_path = trailingslashit($upload_dir['path']) . $filename;
    
    // Check if the image exists in the upload directory (if it's already uploaded)
    if (file_exists($file_path)) {
        // Check if this file is already in the Media Library
        $attachment_id = attachment_url_to_postid($upload_dir['url'] . '/' . $filename);
        if ($attachment_id) { return $attachment_id; }
    }

    // Fetch the image data if it's not found
    $response = wp_remote_get($image_url);
    
    if (is_wp_error($response)) {
        return new WP_Error('download_error', 'Failed to fetch the image.');
    }

    $image_data = wp_remote_retrieve_body($response);
    if (empty($image_data)) {
        return new WP_Error('invalid_image_data', 'The image data is empty.');
    }

    // Save the image data to the upload directory
    global $wp_filesystem;
    if (!function_exists('WP_Filesystem')) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }
    WP_Filesystem();

    // Save the image using WP_Filesystem
    if (!$wp_filesystem->put_contents($file_path, $image_data, FS_CHMOD_FILE)) {
        return new WP_Error('file_write_error', 'Failed to write the image file.');
    }

    // Prepare the file array for insertion
    $filetype = wp_check_filetype($filename, null);
    $attachment_data = array(
        'post_mime_type' => $filetype['type'],
        'post_title'     => sanitize_file_name($image_name),
        'post_content'   => '',
        'post_status'    => 'inherit',
    );

    // Insert the attachment into the WordPress Media Library
    $attachment_id = wp_insert_attachment($attachment_data, $file_path);

    if (is_wp_error($attachment_id)) { return $attachment_id; }

    // Generate and save the attachment metadata
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attachment_metadata = wp_generate_attachment_metadata($attachment_id, $file_path);
    wp_update_attachment_metadata($attachment_id, $attachment_metadata);
    return $attachment_id; // Return the attachment ID
}