<?php
if (!defined('ABSPATH')) exit;

class OGP_Media_Folders {
    
    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('admin_footer-upload.php', array($this, 'folder_sidebar_template'));
        add_action('restrict_manage_posts', array($this, 'add_folder_filter'));
        add_filter('ajax_query_attachments_args', array($this, 'filter_media_by_folder'));
        
        // Admin menu for folder management
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'Gallery Folders',
            'Gallery Folders',
            'manage_options',
            'ogp-folders',
            array($this, 'admin_page'),
            'dashicons-portfolio',
            31
        );
    }
    
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'upload.php' && $hook !== 'toplevel_page_ogp-folders' && $hook !== 'post.php') {
            return;
        }
        
        wp_enqueue_style('ogp-admin-folders', OGP_URL . 'assets/css/admin-folders.css', array(), OGP_VERSION);
        wp_enqueue_script('ogp-admin-folders', OGP_URL . 'assets/js/admin-folders.js', array('jquery', 'jquery-ui-draggable', 'jquery-ui-droppable'), OGP_VERSION, true);
        
        wp_localize_script('ogp-admin-folders', 'ogpFolders', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ogp_folders_nonce'),
            'folders' => $this->get_folders_hierarchy(),
        ));
    }
    
    public function get_folders_hierarchy($parent = 0) {
        $folders = array();
        $terms = get_terms(array(
            'taxonomy' => 'gallery_folder',
            'hide_empty' => false,
            'parent' => $parent,
        ));
        
        foreach ($terms as $term) {
            $folders[] = array(
                'id' => $term->term_id,
                'name' => $term->name,
                'slug' => $term->slug,
                'count' => $term->count,
                'parent' => $term->parent,
                'children' => $this->get_folders_hierarchy($term->term_id),
            );
        }
        
        return $folders;
    }
    
    public function folder_sidebar_template() {
        ?>
        <div id="ogp-folder-sidebar">
            <div class="ogp-sidebar-header">
                <h3>📁 Gallery Folders</h3>
                <button type="button" class="button ogp-add-folder-btn" title="Add New Folder">
                    <span class="dashicons dashicons-plus-alt2"></span>
                </button>
            </div>
            
            <div class="ogp-folder-search">
                <input type="text" id="ogp-folder-search" placeholder="Search folders...">
            </div>
            
            <div class="ogp-folders-tree">
                <div class="ogp-folder-item ogp-all-files" data-folder-id="all">
                    <span class="folder-icon">📁</span>
                    <span class="folder-name">All Files</span>
                </div>
                <div class="ogp-folder-item ogp-uncategorized" data-folder-id="uncategorized">
                    <span class="folder-icon">📂</span>
                    <span class="folder-name">Uncategorized</span>
                </div>
                <div id="ogp-folders-container"></div>
            </div>
        </div>
        
        <!-- Add/Edit Folder Modal -->
        <div id="ogp-folder-modal" class="ogp-modal">
            <div class="ogp-modal-content">
                <span class="ogp-modal-close">&times;</span>
                <h3 id="ogp-modal-title">Add New Folder</h3>
                <form id="ogp-folder-form">
                    <div class="form-group">
                        <label for="folder-name">Folder Name</label>
                        <input type="text" id="folder-name" name="folder_name" required>
                    </div>
                    <div class="form-group">
                        <label for="parent-folder">Parent Folder</label>
                        <select id="parent-folder" name="parent_folder">
                            <option value="0">— None (Root Level) —</option>
                        </select>
                    </div>
                    <input type="hidden" id="folder-id" name="folder_id" value="">
                    <div class="form-actions">
                        <button type="button" class="button ogp-modal-cancel">Cancel</button>
                        <button type="submit" class="button button-primary">Save Folder</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    
    public function add_folder_filter($post_type) {
        if ($post_type !== 'attachment') return;
        
        $terms = get_terms(array(
            'taxonomy' => 'gallery_folder',
            'hide_empty' => false,
        ));
        
        if (empty($terms)) return;
        
        $selected = isset($_GET['gallery_folder']) ? $_GET['gallery_folder'] : '';
        
        echo '<select name="gallery_folder" class="postform">';
        echo '<option value="">All Folders</option>';
        
        foreach ($terms as $term) {
            $selected_attr = selected($selected, $term->slug, false);
            echo '<option value="' . esc_attr($term->slug) . '"' . $selected_attr . '>' . esc_html($term->name) . '</option>';
        }
        
        echo '</select>';
    }
    
    public function filter_media_by_folder($query) {
        if (isset($_REQUEST['query']['gallery_folder'])) {
            $folder = sanitize_text_field($_REQUEST['query']['gallery_folder']);
            
            if ($folder === 'uncategorized') {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'gallery_folder',
                        'operator' => 'NOT EXISTS',
                    ),
                );
            } elseif ($folder && $folder !== 'all') {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'gallery_folder',
                        'field' => 'term_id',
                        'terms' => intval($folder),
                        'include_children' => true,
                    ),
                );
            }
        }
        
        return $query;
    }
    
    public function admin_page() {
        ?>
        <div class="wrap ogp-admin-wrap">
            <h1>📂 Gallery Folders Management</h1>
            
            <div class="ogp-admin-container">
                <!-- Folder Tree -->
                <div class="ogp-folder-tree-panel">
                    <div class="panel-header">
                        <h2>Folder Structure</h2>
                        <button type="button" class="button button-primary ogp-add-chapter-btn">
                            + Add Chapter
                        </button>
                    </div>
                    
                    <div class="ogp-tree-container" id="admin-folder-tree">
                        <?php $this->render_folder_tree(); ?>
                    </div>
                </div>
                
                <!-- Folder Contents -->
                <div class="ogp-folder-contents-panel">
                    <div class="panel-header">
                        <h2 id="current-folder-name">Select a folder</h2>
                        <div class="folder-actions" id="folder-actions" style="display:none;">
                            <button class="button ogp-add-subfolder">+ Add Event/Subfolder</button>
                            <button class="button ogp-upload-images">📷 Upload Images</button>
                            <button class="button ogp-rename-folder">✏️ Rename</button>
                            <button class="button button-link-delete ogp-delete-folder">🗑️ Delete</button>
                        </div>
                    </div>
                    
                    <div class="ogp-images-grid" id="folder-images">
                        <p class="select-folder-msg">👈 Select a folder from the left to view images</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upload Modal -->
        <div id="ogp-upload-modal" class="ogp-modal">
            <div class="ogp-modal-content ogp-upload-modal-content">
                <span class="ogp-modal-close">&times;</span>
                <h3>Upload Images</h3>
                <div class="ogp-upload-area" id="ogp-upload-area">
                    <div class="upload-icon">📷</div>
                    <p>Drag & drop images here</p>
                    <p>or</p>
                    <button type="button" class="button button-primary" id="ogp-select-files">Select Files</button>
                    <input type="file" id="ogp-file-input" multiple accept="image/*" style="display:none;">
                </div>
                <div class="ogp-upload-progress" id="ogp-upload-progress"></div>
            </div>
        </div>
        
        <!-- Add Folder Modal -->
        <div id="ogp-add-folder-modal" class="ogp-modal">
            <div class="ogp-modal-content">
                <span class="ogp-modal-close">&times;</span>
                <h3 id="add-folder-modal-title">Add New Folder</h3>
                <form id="ogp-add-folder-form">
                    <div class="form-group">
                        <label for="new-folder-name">Folder Name</label>
                        <input type="text" id="new-folder-name" required>
                    </div>
                    <input type="hidden" id="new-folder-parent" value="0">
                    <div class="form-actions">
                        <button type="button" class="button ogp-modal-cancel">Cancel</button>
                        <button type="submit" class="button button-primary">Create Folder</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    
    private function render_folder_tree($parent = 0, $level = 0) {
        $terms = get_terms(array(
            'taxonomy' => 'gallery_folder',
            'hide_empty' => false,
            'parent' => $parent,
            'orderby' => 'name',
        ));
        
        if (empty($terms)) return;
        
        $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
        $icon = $level === 0 ? '📁' : '📂';
        
        foreach ($terms as $term) {
            ?>
            <div class="ogp-tree-item" data-folder-id="<?php echo esc_attr($term->term_id); ?>" data-level="<?php echo $level; ?>">
                <div class="tree-item-content">
                    <?php echo $indent; ?>
                    <span class="tree-toggle">▶</span>
                    <span class="tree-icon"><?php echo $icon; ?></span>
                    <span class="tree-name"><?php echo esc_html($term->name); ?></span>
                    <span class="tree-count">(<?php echo $term->count; ?>)</span>
                </div>
                <div class="tree-children">
                    <?php $this->render_folder_tree($term->term_id, $level + 1); ?>
                </div>
            </div>
            <?php
        }
    }
}