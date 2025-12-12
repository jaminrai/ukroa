<?php
if (!defined('ABSPATH')) exit;

class OGP_Frontend_Gallery {
    
    public function __construct() {
        add_shortcode('org_gallery', array($this, 'render_gallery'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    public function enqueue_scripts() {
        wp_enqueue_style('ogp-frontend', OGP_URL . 'assets/css/frontend-gallery.css', array(), OGP_VERSION);
        wp_enqueue_script('ogp-frontend', OGP_URL . 'assets/js/frontend-gallery.js', array('jquery'), OGP_VERSION, true);
        
        wp_localize_script('ogp-frontend', 'ogpGallery', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ogp_gallery_nonce'),
        ));
    }
    
    public function render_gallery($atts) {
        $atts = shortcode_atts(array(
            'columns' => 4,
            'effect' => 'fade', // fade, slide, zoom, flip
        ), $atts);
        
        ob_start();
        ?>
        <div class="ogp-gallery-container" data-effect="<?php echo esc_attr($atts['effect']); ?>">
            
            <!-- Search & Filter Bar -->
            <div class="ogp-gallery-header">
                <div class="ogp-search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="ogp-search-input" placeholder="Search galleries, events, images...">
                    <button type="button" class="clear-search" id="ogp-clear-search">&times;</button>
                </div>
                
                <div class="ogp-view-options">
                    <button class="view-btn active" data-view="grid" title="Grid View">
                        <span>▦</span>
                    </button>
                    <button class="view-btn" data-view="list" title="List View">
                        <span>☰</span>
                    </button>
                </div>
            </div>
            
            <!-- Breadcrumb -->
            <div class="ogp-breadcrumb" id="ogp-breadcrumb">
                <span class="breadcrumb-item active" data-folder="all">🏠 All Galleries</span>
            </div>
            
            <!-- Gallery Content -->
            <div class="ogp-gallery-content" id="ogp-gallery-content">
                <?php echo $this->render_folders(); ?>
            </div>
            
        </div>
        
        <!-- Lightbox / Slideshow -->
        <div class="ogp-lightbox" id="ogp-lightbox">
            <div class="lightbox-backdrop"></div>
            
            <div class="lightbox-container">
                <!-- Close Button -->
                <button class="lightbox-close" id="lightbox-close">×</button>
                
                <!-- Main Image Area -->
                <div class="lightbox-main">
                    <button class="lightbox-nav prev" id="lightbox-prev">❮</button>
                    
                    <div class="lightbox-image-wrapper">
                        <img src="" alt="" class="lightbox-image" id="lightbox-image">
                        <div class="lightbox-loader">
                            <div class="loader-spinner"></div>
                        </div>
                    </div>
                    
                    <button class="lightbox-nav next" id="lightbox-next">❯</button>
                </div>
                
                <!-- Bottom Bar -->
                <div class="lightbox-bottom">
                    <!-- Thumbnails Strip -->
                    <div class="lightbox-thumbnails" id="lightbox-thumbnails"></div>
                    
                    <!-- Controls -->
                    <div class="lightbox-controls">
                        <div class="control-group left">
                            <span class="image-counter" id="image-counter">1 / 10</span>
                        </div>
                        
                        <div class="control-group center">
                            <button class="control-btn" id="btn-first" title="First">⏮</button>
                            <button class="control-btn" id="btn-prev" title="Previous">⏪</button>
                            <button class="control-btn play-btn" id="btn-play" title="Play Slideshow">▶</button>
                            <button class="control-btn" id="btn-next" title="Next">⏩</button>
                            <button class="control-btn" id="btn-last" title="Last">⏭</button>
                        </div>
                        
                        <div class="control-group right">
                            <select id="slideshow-speed" class="speed-select">
                                <option value="2000">2s</option>
                                <option value="3000" selected>3s</option>
                                <option value="5000">5s</option>
                                <option value="7000">7s</option>
                            </select>
                            <button class="control-btn" id="btn-zoom" title="Zoom">🔍</button>
                            <button class="control-btn" id="btn-fullscreen" title="Fullscreen">⛶</button>
                            <button class="control-btn" id="btn-download" title="Download">⬇</button>
                        </div>
                    </div>
                </div>
                
                <!-- Image Caption -->
                <div class="lightbox-caption" id="lightbox-caption"></div>
            </div>
        </div>
        
        <!-- Transition Effects Container -->
        <div class="ogp-transition-overlay" id="transition-overlay">
            <img src="" alt="" class="transition-image" id="transition-image">
        </div>
        
        <?php
        return ob_get_clean();
    }
    
    private function render_folders($parent = 0) {
        $terms = get_terms(array(
            'taxonomy' => 'gallery_folder',
            'hide_empty' => false,
            'parent' => $parent,
            'orderby' => 'name',
        ));
        
        if (empty($terms) && $parent === 0) {
            return '<div class="ogp-no-galleries">
                <div class="no-galleries-icon">📷</div>
                <h3>No galleries yet</h3>
                <p>Create folders and upload images from the admin panel.</p>
            </div>';
        }
        
        $output = '<div class="ogp-folders-grid">';
        
        foreach ($terms as $term) {
            $children = get_terms(array(
                'taxonomy' => 'gallery_folder',
                'parent' => $term->term_id,
                'hide_empty' => false,
            ));
            
            // Get cover image
            $cover_image = $this->get_folder_cover($term->term_id);
            $image_count = $this->get_folder_image_count($term->term_id);
            $subfolder_count = count($children);
            
            $folder_type = $parent === 0 ? 'chapter' : 'event';
            
            $output .= '
            <div class="ogp-folder-card ' . $folder_type . '" data-folder-id="' . esc_attr($term->term_id) . '" data-folder-name="' . esc_attr($term->name) . '">
                <div class="folder-card-image">
                    ' . ($cover_image ? '<img src="' . esc_url($cover_image) . '" alt="' . esc_attr($term->name) . '">' : '<div class="folder-placeholder">' . ($folder_type === 'chapter' ? '📁' : '📂') . '</div>') . '
                    <div class="folder-overlay">
                        <button class="open-folder-btn">Open</button>
                    </div>
                </div>
                <div class="folder-card-info">
                    <h3 class="folder-title">' . esc_html($term->name) . '</h3>
                    <div class="folder-meta">';
            
            if ($subfolder_count > 0) {
                $output .= '<span class="meta-item">📂 ' . $subfolder_count . ' events</span>';
            }
            
            $output .= '<span class="meta-item">🖼️ ' . $image_count . ' images</span>
                    </div>
                </div>
            </div>';
        }
        
        $output .= '</div>';
        
        return $output;
    }
    
    private function get_folder_cover($folder_id) {
        $args = array(
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
            'orderby' => 'date',
            'order' => 'DESC',
        );
        
        $images = get_posts($args);
        
        if (!empty($images)) {
            return wp_get_attachment_image_url($images[0]->ID, 'medium');
        }
        
        // Check children folders
        $children = get_terms(array(
            'taxonomy' => 'gallery_folder',
            'parent' => $folder_id,
            'hide_empty' => false,
        ));
        
        foreach ($children as $child) {
            $cover = $this->get_folder_cover($child->term_id);
            if ($cover) return $cover;
        }
        
        return false;
    }
    
    private function get_folder_image_count($folder_id, $include_children = true) {
        $count = 0;
        
        $args = array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'tax_query' => array(
                array(
                    'taxonomy' => 'gallery_folder',
                    'field' => 'term_id',
                    'terms' => $folder_id,
                ),
            ),
        );
        
        $count += count(get_posts($args));
        
        if ($include_children) {
            $children = get_terms(array(
                'taxonomy' => 'gallery_folder',
                'parent' => $folder_id,
                'hide_empty' => false,
            ));
            
            foreach ($children as $child) {
                $count += $this->get_folder_image_count($child->term_id, true);
            }
        }
        
        return $count;
    }
}