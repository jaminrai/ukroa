<?php
/**
 * Plugin Name: Org Gallery Pro
 * Description: Media Library folder management with beautiful frontend gallery & slideshow
 * Version: 2.0
 * Author: Your Organization
 */

if (!defined('ABSPATH')) exit;

define('OGP_VERSION', '2.0');
define('OGP_PATH', plugin_dir_path(__FILE__));
define('OGP_URL', plugin_dir_url(__FILE__));

class Org_Gallery_Pro {
    
    public function __construct() {
        $this->includes();
        $this->init_hooks();
    }
    
    private function includes() {
        require_once OGP_PATH . 'includes/class-media-folders.php';
        require_once OGP_PATH . 'includes/class-frontend-gallery.php';
        require_once OGP_PATH . 'includes/class-ajax-handlers.php';
    }
    
    private function init_hooks() {
        register_activation_hook(__FILE__, array($this, 'activate'));
        add_action('init', array($this, 'register_taxonomy'));
    }
    
    public function activate() {
        $this->register_taxonomy();
        flush_rewrite_rules();
    }
    
    public function register_taxonomy() {
        $labels = array(
            'name' => 'Gallery Folders',
            'singular_name' => 'Gallery Folder',
            'search_items' => 'Search Folders',
            'all_items' => 'All Folders',
            'parent_item' => 'Parent Folder',
            'parent_item_colon' => 'Parent Folder:',
            'edit_item' => 'Edit Folder',
            'update_item' => 'Update Folder',
            'add_new_item' => 'Add New Folder',
            'new_item_name' => 'New Folder Name',
            'menu_name' => 'Gallery Folders',
        );
        
        register_taxonomy('gallery_folder', 'attachment', array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'gallery-folder'),
            'show_in_rest' => true,
        ));
    }
}

new Org_Gallery_Pro();
new OGP_Media_Folders();
new OGP_Frontend_Gallery();
new OGP_Ajax_Handlers();