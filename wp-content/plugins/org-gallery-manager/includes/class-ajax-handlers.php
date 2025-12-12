<?php
if (!defined('ABSPATH')) exit;

class OGP_Ajax_Handlers {
    
    public function __construct() {
        // Admin AJAX
        add_action('wp_ajax_ogp_create_folder', array($this, 'create_folder'));
        add_action('wp_ajax_ogp_rename_folder', array($this, 'rename_folder'));
        add_action('wp_ajax_ogp_delete_folder', array($this, 'delete_folder'));
        add_action('wp_ajax_ogp_get_folder_images', array($this, 'get_folder_images'));
        add_action('wp_ajax_ogp_assign_image_folder', array($this, 'assign_image_folder'));
        add_action('wp_ajax_ogp_upload_to_folder', array($this, 'upload_to_folder'));
        add_action('wp_ajax_ogp_delete_image', array($this, 'delete_image'));
        add_action('wp_ajax_ogp_get_folder_tree', array($this, 'get_folder_tree'));
        
        // Frontend AJAX
        add_action('wp_ajax_ogp_get_folder_content', array($this, 'get_folder_content'));
        add_action('wp_ajax_nopriv_ogp_get_folder_content', array($this, 'get_folder_content'));
        add_action('wp_ajax_ogp_search_gallery', array($this, 'search_gallery'));
        add_action('wp_ajax_nopriv_ogp_search_gallery', array($this, 'search_gallery'));
    }
    
    // Create Folder
    public function create_folder() {
        check_ajax_referer('ogp_folders_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }
        
        $name = sanitize_text_field($_POST['name']);
        $parent = intval($_POST['parent']);
        
        $term = wp_insert_term($name, 'gallery_folder', array(
            'parent' => $parent,
        ));
        
        if (is_wp_error($term)) {
            wp_send_json_error($term->get_error_message());
        }
        
        wp_send_json_success(array(
            'id' => $term['term_id'],
            'name' => $name,
            'message' => 'Folder created successfully',
        ));
    }
    
    // Rename Folder
    public function rename_folder() {
        check_ajax_referer('ogp_folders_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }
        
        $folder_id = intval($_POST['folder_id']);
        $new_name = sanitize_text_field($_POST['new_name']);
        
        $result = wp_update_term($folder_id, 'gallery_folder', array(
            'name' => $new_name,
        ));
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }
        
        wp_send_json_success('Folder renamed successfully');
    }
    
    // Delete Folder
    public function delete_folder() {
        check_ajax_referer('ogp_folders_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }
        
        $folder_id = intval($_POST['folder_id']);
        $delete_images = isset($_POST['delete_images']) && $_POST['delete_images'] === 'true';
        
        // Get all images in folder
        if ($delete_images) {
            $images = get_posts(array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'gallery_folder',
                        'field' => 'term_id',
                        'terms' => $folder_id,
                    ),
                ),
            ));
            
            foreach ($images as $image) {
                wp_delete_attachment($image->ID, true);
            }
        }
        
        // Delete child folders
        $children = get_terms(array(
            'taxonomy' => 'gallery_folder',
            'parent' => $folder_id,
            'hide_empty' => false,
        ));
        
        foreach ($children as $child) {
            $_POST['folder_id'] = $child->term_id;
            $this->delete_folder_recursive($child->term_id, $delete_images);
        }
        
        // Delete the folder
        $result = wp_delete_term($folder_id, 'gallery_folder');
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }
        
        wp_send_json_success('Folder deleted successfully');
    }
    
    private function delete_folder_recursive($folder_id, $delete_images) {
        if ($delete_images) {
            $images = get_posts(array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'gallery_folder',
                        'field' => 'term_id',
                        'terms' => $folder_id,
                    ),
                ),
            ));
            
            foreach ($images as $image) {
                wp_delete_attachment($image->ID, true);
            }
        }
        
        $children = get_terms(array(
            'taxonomy' => 'gallery_folder',
            'parent' => $folder_id,
            'hide_empty' => false,
        ));
        
        foreach ($children as $child) {
            $this->delete_folder_recursive($child->term_id, $delete_images);
        }
        
        wp_delete_term($folder_id, 'gallery_folder');
    }
    
    // Get Folder Images
    public function get_folder_images() {
        check_ajax_referer('ogp_folders_nonce', 'nonce');
        
        $folder_id = intval($_POST['folder_id']);
        
        $images = get_posts(array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'gallery_folder',
                    'field' => 'term_id',
                    'terms' => $folder_id,
                ),
            ),
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        
        $image_data = array();
        
        foreach ($images as $image) {
            $image_data[] = array(
                'id' => $image->ID,
                'title' => $image->post_title,
                'thumbnail' => wp_get_attachment_image_url($image->ID, 'thumbnail'),
                'medium' => wp_get_attachment_image_url($image->ID, 'medium'),
                'full' => wp_get_attachment_image_url($image->ID, 'full'),
                'date' => get_the_date('Y-m-d', $image->ID),
            );
        }
        
        wp_send_json_success($image_data);
    }
    
    // Assign Image to Folder (Drag & Drop)
    public function assign_image_folder() {
        check_ajax_referer('ogp_folders_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }
        
        $image_id = intval($_POST['image_id']);
        $folder_id = intval($_POST['folder_id']);
        
        $result = wp_set_object_terms($image_id, $folder_id, 'gallery_folder');
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }
        
        wp_send_json_success('Image moved to folder');
    }
    
    // Upload to Folder
    public function upload_to_folder() {
        check_ajax_referer('ogp_folders_nonce', 'nonce');
        
        if (!current_user_can('upload_files')) {
            wp_send_json_error('Unauthorized');
        }
        
        $folder_id = intval($_POST['folder_id']);
        
        if (empty($_FILES['file'])) {
            wp_send_json_error('No file uploaded');
        }
        
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        $attachment_id = media_handle_upload('file', 0);
        
        if (is_wp_error($attachment_id)) {
            wp_send_json_error($attachment_id->get_error_message());
        }
        
        // Assign to folder
        wp_set_object_terms($attachment_id, $folder_id, 'gallery_folder');
        
        wp_send_json_success(array(
            'id' => $attachment_id,
            'thumbnail' => wp_get_attachment_image_url($attachment_id, 'thumbnail'),
        ));
    }
    
    // Delete Image
    public function delete_image() {
        check_ajax_referer('ogp_folders_nonce', 'nonce');
        
        if (!current_user_can('delete_posts')) {
            wp_send_json_error('Unauthorized');
        }
        
        $image_id = intval($_POST['image_id']);
        
        $result = wp_delete_attachment($image_id, true);
        
        if (!$result) {
            wp_send_json_error('Failed to delete image');
        }
        
        wp_send_json_success('Image deleted');
    }
    
    // Get Folder Content (Frontend)
    public function get_folder_content() {
        $folder_id = intval($_POST['folder_id']);
        
        $term = get_term($folder_id, 'gallery_folder');
        
        if (!$term || is_wp_error($term)) {
            wp_send_json_error('Folder not found');
        }
        
        // Get subfolders
        $subfolders = get_terms(array(
            'taxonomy' => 'gallery_folder',
            'parent' => $folder_id,
            'hide_empty' => false,
        ));
        
        // Get images
        $images = get_posts(array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'gallery_folder',
                    'field' => 'term_id',
                    'terms' => $folder_id,
                ),
            ),
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        
        $folders_html = '';
        $images_html = '';
        
        // Build subfolders HTML
        foreach ($subfolders as $subfolder) {
            $cover = $this->get_folder_cover_url($subfolder->term_id);
            $count = $this->count_folder_images($subfolder->term_id);
            
            $folders_html .= '
            <div class="ogp-folder-card event" data-folder-id="' . esc_attr($subfolder->term_id) . '" data-folder-name="' . esc_attr($subfolder->name) . '">
                <div class="folder-card-image">
                    ' . ($cover ? '<img src="' . esc_url($cover) . '" alt="">' : '<div class="folder-placeholder">📂</div>') . '
                    <div class="folder-overlay">
                        <button class="open-folder-btn">Open</button>
                    </div>
                </div>
                <div class="folder-card-info">
                    <h3 class="folder-title">' . esc_html($subfolder->name) . '</h3>
                    <div class="folder-meta">
                        <span class="meta-item">🖼️ ' . $count . ' images</span>
                    </div>
                </div>
            </div>';
        }
        
        // Build images HTML
        foreach ($images as $image) {
            $thumb = wp_get_attachment_image_url($image->ID, 'medium');
            $full = wp_get_attachment_image_url($image->ID, 'full');
            $title = $image->post_title;
            
            $images_html .= '
            <div class="ogp-image-card" data-image-id="' . $image->ID . '" data-full="' . esc_url($full) . '" data-title="' . esc_attr($title) . '">
                <img src="' . esc_url($thumb) . '" alt="' . esc_attr($title) . '" loading="lazy">
                <div class="image-overlay">
                    <span class="view-icon">🔍</span>
                </div>
            </div>';
        }
        
        // Build breadcrumb
        $breadcrumb = $this->build_breadcrumb($folder_id);
        
        wp_send_json_success(array(
            'folder_name' => $term->name,
            'breadcrumb' => $breadcrumb,
            'has_subfolders' => !empty($subfolders),
            'has_images' => !empty($images),
            'subfolders_html' => $folders_html,
            'images_html' => $images_html,
            'images' => array_map(function($img) {
                return array(
                    'id' => $img->ID,
                    'title' => $img->post_title,
                    'thumbnail' => wp_get_attachment_image_url($img->ID, 'thumbnail'),
                    'full' => wp_get_attachment_image_url($img->ID, 'full'),
                );
            }, $images),
        ));
    }
    
    // Search Gallery
    public function search_gallery() {
        $search = sanitize_text_field($_POST['search']);
        
        if (strlen($search) < 2) {
            wp_send_json_error('Search term too short');
        }
        
        // Search folders
        $folders = get_terms(array(
            'taxonomy' => 'gallery_folder',
            'hide_empty' => false,
            'name__like' => $search,
        ));
        
        // Search images
        $images = get_posts(array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => 50,
            's' => $search,
        ));
        
        $results = array(
            'folders' => array(),
            'images' => array(),
        );
        
        foreach ($folders as $folder) {
            $results['folders'][] = array(
                'id' => $folder->term_id,
                'name' => $folder->name,
                'cover' => $this->get_folder_cover_url($folder->term_id),
                'count' => $this->count_folder_images($folder->term_id),
            );
        }
        
        foreach ($images as $image) {
            $results['images'][] = array(
                'id' => $image->ID,
                'title' => $image->post_title,
                'thumbnail' => wp_get_attachment_image_url($image->ID, 'medium'),
                'full' => wp_get_attachment_image_url($image->ID, 'full'),
            );
        }
        
        wp_send_json_success($results);
    }
    
    private function get_folder_cover_url($folder_id) {
        $images = get_posts(array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => 1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'gallery_folder',
                    'field' => 'term_id',
                    'terms' => $folder_id,
                ),
            ),
        ));
        
        if (!empty($images)) {
            return wp_get_attachment_image_url($images[0]->ID, 'medium');
        }
        
        return false;
    }
    
    private function count_folder_images($folder_id) {
        return count(get_posts(array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'tax_query' => array(
                array(
                    'taxonomy' => 'gallery_folder',
                    'field' => 'term_id',
                    'terms' => $folder_id,
                    'include_children' => true,
                ),
            ),
        )));
    }
    
    private function build_breadcrumb($folder_id) {
        $breadcrumb = array();
        $term = get_term($folder_id, 'gallery_folder');
        
        while ($term && !is_wp_error($term)) {
            array_unshift($breadcrumb, array(
                'id' => $term->term_id,
                'name' => $term->name,
            ));
            
            if ($term->parent) {
                $term = get_term($term->parent, 'gallery_folder');
            } else {
                break;
            }
        }
        
        return $breadcrumb;
    }
}