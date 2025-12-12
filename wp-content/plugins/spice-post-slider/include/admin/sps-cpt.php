<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Register Post Type
 */
if ( ! class_exists( 'Spice_Post_Slider_Type' ) ) {
    class Spice_Post_Slider_Type {
        public function __construct() {
            //Register spice_post_slider CPT
            add_action('init', array( $this , 'sps_register' ));
            add_action( 'admin_enqueue_scripts', array( $this,'sps_load_admin_script'));
            add_action( 'wp_enqueue_scripts', array( $this,'sps_load_script'));
            add_action( 'add_meta_boxes', array( $this, 'sps_meta_fn'));
            add_action('save_post',array( $this, 'sps_meta_save'));
        }

        //Register spice_post_slider CPT callback function
        function sps_register() {
            $labels = array(
                'name'               => esc_html__( 'Post Slider', 'spice-post-slider' ),
                'singular_name'      => esc_html__( 'Post Slider', 'spice-post-slider' ),
                'add_new'            => esc_html__( 'Add New','spice-post-slider' ),
                'add_new_item'       => esc_html__( 'Add New Post Slider', 'spice-post-slider' ),
                'edit_item'          => esc_html__( 'Edit Post Slider', 'spice-post-slider' ),
                'new_item'           => esc_html__( 'New Post Slider', 'spice-post-slider' ),
                'all_items'          => esc_html__( 'All Post Slider', 'spice-post-slider' ),
                'view_item'          => esc_html__( 'View Post Slider', 'spice-post-slider' ),
                'search_items'       => esc_html__( 'Search Post Slider', 'spice-post-slider' ),
                'not_found'          => esc_html__( 'No posts slider found', 'spice-post-slider' ),
                'not_found_in_trash' => esc_html__( 'No posts slider found in the Trash', 'spice-post-slider' ), 
                'parent_item_colon'  =>  '',
                'menu_name'          => 'Post Slider'
            );
            $args = array(
                'labels'        => $labels,
                'public'        => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-slides',
                'supports'      => array( 'title'),
                'has_archive'   => false,
            );
            register_post_type( 'spice_post_slider', $args ); 
        }

        /**
         * Load Admin Script
         *
         * @since 1.0
        */
        public function sps_load_admin_script() {
            wp_enqueue_media();
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'sps-color-pic', SPS_URL.'assets/js/color-picker.js', array( 'wp-color-picker' ), SPS_PLUGIN_VERSION, true );
            wp_enqueue_style('sps-style', SPS_URL.'assets/css/style.css', array(), SPS_PLUGIN_VERSION);

            wp_enqueue_style('sps-jquery-ui', SPS_URL.'assets/css/jquery-ui.css', array(), '1.12.1'); 

            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_script('jquery-ui-slider');
            wp_enqueue_script('sps-custom-tabs', SPS_URL . 'assets/js/custom.js', array('jquery'), SPS_PLUGIN_VERSION, true);
            wp_enqueue_style('sps-font-awesome', SPS_URL.'assets/css/font-awesome/css/all.min.css', array(), '5.15.4');
            wp_enqueue_style('sps-admin-about', SPS_URL.'assets/css/about-page.css', array(), SPS_PLUGIN_VERSION);
            wp_enqueue_style('sps-select', SPS_URL.'assets/css/select2.min.css', array(), '4.1.0');
            wp_enqueue_script('sps-select', SPS_URL . 'assets/js/select.min.js', array('jquery'), '4.1.0', true);
        }

        /**
        * Load Front Script
        *
        * @since 1.0
        */
        public function sps_load_script() {
            wp_enqueue_style('sps-font-awesome', SPS_URL.'assets/css/font-awesome/css/all.min.css', array(), '5.15.4');
            wp_enqueue_style('sps-owl', SPS_URL.'assets/css/owl.carousel.css', array(), '2.2.1');
            wp_enqueue_style('sps-front', SPS_URL.'assets/css/front.css', array(), SPS_PLUGIN_VERSION);
            wp_enqueue_script('sps-owl', SPS_URL . 'assets/js/owl.carousel.min.js', array('jquery'), '2.2.1', true);
        }

        //Add Meta Box
        function sps_meta_fn() {
            add_meta_box( 'spice_post_slider_meta_id', esc_html__('Post Slider Settings','spice-post-slider'), array($this,'sps_meta_cb_fn'), 'spice_post_slider','normal','high' );
            add_meta_box( 'spice_post_slider_generator_id', esc_html__('Post Slider  Shortcode','spice-post-slider'), array($this,'sps_generator_fn'), 'spice_post_slider','side','low' );
            add_meta_box( 'spice_post_slider_review_box', esc_html__('Post Slider Review','spice-post-slider'), array($this,'sps_review_box_fn'), 'spice_post_slider','side','low' );
            add_meta_box( 'spice_post_slider_support_box', esc_html__('Post Slider Support','spice-post-slider'), array($this,'sps_support_box_fn'), 'spice_post_slider','side','low' );
            add_meta_box( 'spice_post_slider_docs_box', esc_html__('Post Slider Documentation','spice-post-slider'), array($this,'sps_docs_box_fn'), 'spice_post_slider','side','low' );
            add_meta_box( 'spice_post_slider_upgrade_pro_box', esc_html__('Post Slider Upgrade to Pro','spice-post-slider'), array($this,'sps_upgrade_pro_box_fn'), 'spice_post_slider','side','low' );
        }

        //Callback Meta Function
        function sps_meta_cb_fn() {
          require_once('sps-meta-box.php');
        }

        //Shortcode Generator Function
        function sps_generator_fn() {
          require_once('sps-shortcode-generator.php');
        }

        //Review Box Function
        function sps_review_box_fn() { 
            $attachment_id = sps_save_image_to_media_library(SPS_URL.'assets/img/review.jpg');
            $attributes = array(
                'max-width' => '100%',
                'height'    => 'auto'
            );
            echo wp_get_attachment_image(esc_attr($attachment_id), 'full', false, $attributes); ?> 
            <a href="<?php echo esc_url('https://wordpress.org/support/plugin/spice-post-slider/reviews/'); ?>" target="_blank" class="sps-meta-rate-btn "><?php esc_html_e('Rate Us','spice-post-slider');?><i class="fa fa-arrow-right"></i></a>
        <?php }

        //Support Box Function
        function sps_support_box_fn() { 
            $attachment_id = sps_save_image_to_media_library(SPS_URL.'assets/img/support.jpg');
            $attributes = array(
                'max-width' => '100%',
                'height'    => 'auto'
            );
            echo wp_get_attachment_image(esc_attr($attachment_id), 'full', false, $attributes); ?>
            <a href="<?php echo esc_url('https://wordpress.org/support/plugin/spice-post-slider/'); ?>" target="_blank" class="sps-meta-support-btn"><?php esc_html_e('Get Support','spice-post-slider');?><i class="fa fa-arrow-right"></i></a>
        <?php }

        //Documentation Box Function
        function sps_docs_box_fn() { 
            $attachment_id = sps_save_image_to_media_library(SPS_URL.'assets/img/docs.jpg');
            $attributes = array(
                'max-width' => '100%',
                'height'    => 'auto'
            );
            echo wp_get_attachment_image(esc_attr($attachment_id), 'full', false, $attributes); ?>
            <a href="<?php echo esc_url('https://helpdoc.spicethemes.com/category/spice-slider/spice-post-slider/'); ?>" target="_blank" class="sps-meta-doc-btn"><?php esc_html_e('Documentation','spice-post-slider');?><i class="fa fa-arrow-right"></i></a>
        <?php }

        //Upgrade to Pro Box Function
        function sps_upgrade_pro_box_fn() { 
            $attachment_id = sps_save_image_to_media_library(SPS_URL.'assets/img/upgrade-pro.jpg');
            $attributes = array(
                'max-width' => '100%',
                'height'    => 'auto'
            );
            echo wp_get_attachment_image(esc_attr($attachment_id), 'full', false, $attributes); ?>
            <a href="<?php echo esc_url('https://spicethemes.com/spice-slider-pro/'); ?>" target="_blank" class="sps-meta-upro-btn"><?php esc_html_e('Upgrade Now','spice-post-slider');?><i class="fa fa-arrow-right"></i></a> 
        <?php }

        //Save Meta Values
        function sps_meta_save($post_id) {  
            if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit'])){
              return;
            }

            // Verify nonce to ensure the request is valid.
            if (!isset($_POST['sps_nonce'])) {
                return;
            }

            // Unsanitize and sanitize the nonce value before verification.
            $sps_nonce = sanitize_text_field(wp_unslash($_POST['sps_nonce']));
            if (!wp_verify_nonce($sps_nonce, 'sps_meta_save_nonce')) {
                return;
            }
          
            if ( ! current_user_can( 'edit_page', $post_id ) ) {   return ;  } 
          
            if(isset( $_POST['post_ID'])) {   
                $post_ID = absint($_POST['post_ID']);       
                $post_type=get_post_type($post_ID);
          
                if($post_type=='spice_post_slider')
                { 
                    // Handle sps_orderby.
                    if (isset($_POST['sps_orderby'])) {
                       update_post_meta($post_ID, 'sps_orderby', sanitize_text_field(wp_unslash($_POST['sps_orderby'])));
                    }
                    // Handle sps_video_banner.
                    if (isset($_POST['sps_video_banner'])) {
                       update_post_meta($post_ID, 'sps_video_banner', sanitize_text_field(wp_unslash($_POST['sps_video_banner'])));
                    }
                    // Handle sps_video_bannery.
                    if (isset($_POST['sps_navigation_style'])) {
                       update_post_meta($post_ID, 'sps_navigation_style', sanitize_text_field(wp_unslash($_POST['sps_navigation_style'])));
                    }
                    // Handle sps_post_page.
                    if (isset($_POST['sps_post_page'])) {
                        update_post_meta($post_ID, 'sps_post_page', absint($_POST['sps_post_page']));
                    }
                    // Handle sps_slide_item.
                    if (isset($_POST['sps_slide_item'])) {
                        update_post_meta($post_ID, 'sps_slide_item', absint($_POST['sps_slide_item']));
                    }
                    // Handle sps_slide_img.
                    if (isset($_POST['sps_slide_img'])) {
                        update_post_meta($post_ID, 'sps_slide_img', sanitize_text_field(wp_unslash($_POST['sps_slide_img'])));
                    }
                    // Handle sps_dt_enable.
                    if (isset($_POST['sps_dt_enable'])) {
                        update_post_meta($post_ID, 'sps_dt_enable', sanitize_text_field(wp_unslash($_POST['sps_dt_enable'])));
                    }
                    // Handle sps_cat_enable.
                    if (isset($_POST['sps_cat_enable'])) {
                        update_post_meta($post_ID, 'sps_cat_enable', sanitize_text_field(wp_unslash($_POST['sps_cat_enable'])));
                    }
                    // Handle sps_comment_enable.
                    if (isset($_POST['sps_comment_enable'])) {
                        update_post_meta($post_ID, 'sps_comment_enable', sanitize_text_field(wp_unslash($_POST['sps_comment_enable'])));
                    }
                    // Handle sps_auth_enable.
                    if (isset($_POST['sps_auth_enable'])) {
                        update_post_meta($post_ID, 'sps_auth_enable', sanitize_text_field(wp_unslash($_POST['sps_auth_enable'])));
                    }
                    // Handle sps_slider_type.
                    if (isset($_POST['sps_slider_type'])) {
                        update_post_meta($post_ID, 'sps_slider_type', sanitize_text_field(wp_unslash($_POST['sps_slider_type'])));
                    }
                    // Handle sps_title_enable.
                    if (isset($_POST['sps_title_enable'])) {
                        update_post_meta($post_ID, 'sps_title_enable', sanitize_text_field(wp_unslash($_POST['sps_title_enable'])));
                    }
                    // Handle sps_desc_enable.
                    if (isset($_POST['sps_desc_enable'])) {
                        update_post_meta($post_ID, 'sps_desc_enable', sanitize_text_field(wp_unslash($_POST['sps_desc_enable'])));
                    }
                    // Handle sps_banner_overlay_enable.
                    if (isset($_POST['sps_banner_overlay_enable'])) {
                        update_post_meta($post_ID, 'sps_banner_overlay_enable', sanitize_text_field(wp_unslash($_POST['sps_banner_overlay_enable'])));
                    }
                    // Handle sps_banner_overlay_opacity.
                    if (isset($_POST['sps_banner_overlay_opacity'])) {
                        update_post_meta($post_ID, 'sps_banner_overlay_opacity', sanitize_text_field(wp_unslash($_POST['sps_banner_overlay_opacity'])));
                    }
                    // Handle sps_banner_padding_top.
                    if (isset($_POST['sps_banner_padding_top'])) {
                        update_post_meta($post_ID, 'sps_banner_padding_top', sanitize_text_field(wp_unslash($_POST['sps_banner_padding_top'])));
                    }
                    // Handle sps_banner_padding_bottom.
                    if (isset($_POST['sps_banner_padding_bottom'])) {
                        update_post_meta($post_ID, 'sps_banner_padding_bottom', sanitize_text_field(wp_unslash($_POST['sps_banner_padding_bottom'])));
                    }
                    // Handle sps_banner_height.
                    if (isset($_POST['sps_banner_height'])) {
                        update_post_meta($post_ID, 'sps_banner_height', sanitize_text_field(wp_unslash($_POST['sps_banner_height'])));
                    }
                    // Handle sps_read.
                    if(empty($_POST['sps_read'])) {
                        $sps_read='sps_blank';
                    }
                    else {
                        $sps_read = sanitize_text_field(wp_unslash($_POST['sps_read']));
                    }
                    update_post_meta($post_ID, 'sps_read', $sps_read);
                    // Handle sps_speed.
                    if (isset($_POST['sps_speed'])) {
                        update_post_meta($post_ID, 'sps_speed', absint($_POST['sps_speed']));
                    }
                    // Handle sps_title_ff.
                    if (isset($_POST['sps_title_ff'])) {
                        update_post_meta($post_ID, 'sps_title_ff', sanitize_text_field(wp_unslash($_POST['sps_title_ff'])));
                    }
                    // Handle sps_title_fs.
                    if (isset($_POST['sps_title_fs'])) {
                        update_post_meta($post_ID, 'sps_title_fs', absint($_POST['sps_title_fs']));
                    }
                    // Handle sps_title_lheight.
                    if (isset($_POST['sps_title_lheight'])) {
                        update_post_meta($post_ID, 'sps_title_lheight', absint($_POST['sps_title_lheight']));
                    }
                    // Handle sps_title_fw.
                    if (isset($_POST['sps_title_fw'])) {
                        update_post_meta($post_ID, 'sps_title_fw', absint($_POST['sps_title_fw']));
                    }
                    // Handle sps_title_fstyle.
                    if (isset($_POST['sps_title_fstyle'])) {
                        update_post_meta($post_ID, 'sps_title_fstyle', sanitize_text_field(wp_unslash($_POST['sps_title_fstyle'])));
                    }
                    // Handle sps_title_trans.
                    if (isset($_POST['sps_title_trans'])) {
                        update_post_meta($post_ID, 'sps_title_trans', sanitize_text_field(wp_unslash($_POST['sps_title_trans'])));
                    }
                    // Handle sps_content_ff.
                    if (isset($_POST['sps_content_ff'])) {
                        update_post_meta($post_ID, 'sps_content_ff', sanitize_text_field(wp_unslash($_POST['sps_content_ff'])));
                    }
                    // Handle sps_content_fs.
                    if (isset($_POST['sps_content_fs'])) {
                        update_post_meta($post_ID, 'sps_content_fs', absint($_POST['sps_content_fs']));
                    }
                    // Handle sps_content_lheight.
                    if (isset($_POST['sps_content_lheight'])) {
                        update_post_meta($post_ID, 'sps_content_lheight', absint($_POST['sps_content_lheight']));
                    }
                    // Handle sps_content_fw.
                    if (isset($_POST['sps_content_fw'])) {
                        update_post_meta($post_ID, 'sps_content_fw', absint($_POST['sps_content_fw']));
                    }
                    // Handle sps_content_fstyle.
                    if (isset($_POST['sps_content_fstyle'])) {
                        update_post_meta($post_ID, 'sps_content_fstyle', sanitize_text_field(wp_unslash($_POST['sps_content_fstyle'])));
                    }
                    // Handle sps_content_trans.
                    if (isset($_POST['sps_content_trans'])) {
                        update_post_meta($post_ID, 'sps_content_trans', sanitize_text_field(wp_unslash($_POST['sps_content_trans'])));
                    }
                    // Handle sps_meta_ff.
                    if (isset($_POST['sps_meta_ff'])) {
                        update_post_meta($post_ID, 'sps_meta_ff', sanitize_text_field(wp_unslash($_POST['sps_meta_ff'])));
                    }
                    // Handle sps_meta_fs.
                    if (isset($_POST['sps_meta_fs'])) {
                        update_post_meta($post_ID, 'sps_meta_fs', absint($_POST['sps_meta_fs']));
                    }
                    // Handle sps_meta_lheight.
                    if (isset($_POST['sps_meta_lheight'])) {
                        update_post_meta($post_ID, 'sps_meta_lheight', absint($_POST['sps_meta_lheight']));
                    }
                    // Handle sps_meta_fw.
                    if (isset($_POST['sps_meta_fw'])) {
                        update_post_meta($post_ID, 'sps_meta_fw', absint($_POST['sps_meta_fw']));
                    }
                    // Handle sps_meta_fstyle.
                    if (isset($_POST['sps_meta_fstyle'])) {
                        update_post_meta($post_ID, 'sps_meta_fstyle', sanitize_text_field(wp_unslash($_POST['sps_meta_fstyle'])));
                    }
                    // Handle sps_meta_trans.
                    if (isset($_POST['sps_meta_trans'])) {
                        update_post_meta($post_ID, 'sps_meta_trans', sanitize_text_field(wp_unslash($_POST['sps_meta_trans'])));
                    }
                    // Handle sps_read_ff.
                    if (isset($_POST['sps_read_ff'])) {
                        update_post_meta($post_ID, 'sps_read_ff', sanitize_text_field(wp_unslash($_POST['sps_read_ff'])));
                    }
                    // Handle sps_read_fs.
                    if (isset($_POST['sps_read_fs'])) {
                        update_post_meta($post_ID, 'sps_read_fs', absint($_POST['sps_read_fs']));
                    }
                    // Handle sps_read_lheight.
                    if (isset($_POST['sps_read_lheight'])) {
                        update_post_meta($post_ID, 'sps_read_lheight', absint($_POST['sps_read_lheight']));
                    }
                    // Handle sps_read_fw.
                    if (isset($_POST['sps_read_fw'])) {
                        update_post_meta($post_ID, 'sps_read_fw', absint($_POST['sps_read_fw']));
                    }
                    // Handle sps_read_fstyle.
                    if (isset($_POST['sps_read_fstyle'])) {
                        update_post_meta($post_ID, 'sps_read_fstyle', sanitize_text_field(wp_unslash($_POST['sps_read_fstyle'])));
                    }
                    // Handle sps_read_trans.
                    if (isset($_POST['sps_read_trans'])) {
                        update_post_meta($post_ID, 'sps_read_trans', sanitize_text_field(wp_unslash($_POST['sps_read_trans'])));
                    }
                    // Handle sps_icon_clr.
                    if (isset($_POST['sps_icon_clr'])) {
                        update_post_meta($post_ID, 'sps_icon_clr', sanitize_hex_color(wp_unslash($_POST['sps_icon_clr'])));
                    }
                    // Handle sps_meta_clr.
                    if (isset($_POST['sps_meta_clr'])) {
                        update_post_meta($post_ID, 'sps_meta_clr', sanitize_hex_color(wp_unslash($_POST['sps_meta_clr'])));
                    }
                    // Handle sps_meta_hov_clr.
                    if (isset($_POST['sps_meta_hov_clr'])) {
                        update_post_meta($post_ID, 'sps_meta_hov_clr', sanitize_hex_color(wp_unslash($_POST['sps_meta_hov_clr'])));
                    }
                    // Handle sps_title_clr.
                    if (isset($_POST['sps_title_clr'])) {
                        update_post_meta($post_ID, 'sps_title_clr', sanitize_hex_color(wp_unslash($_POST['sps_title_clr'])));
                    }
                    // Handle sps_title_hov_clr.
                    if (isset($_POST['sps_title_hov_clr'])) {
                        update_post_meta($post_ID, 'sps_title_hov_clr', sanitize_hex_color(wp_unslash($_POST['sps_title_hov_clr'])));
                    }
                    // Handle sps_content_clr.
                    if (isset($_POST['sps_content_clr'])) {
                        update_post_meta($post_ID, 'sps_content_clr', sanitize_hex_color(wp_unslash($_POST['sps_content_clr'])));
                    }
                    // Handle sps_btn_bg_clr.
                    if (isset($_POST['sps_btn_bg_clr'])) {
                        update_post_meta($post_ID, 'sps_btn_bg_clr', sanitize_hex_color(wp_unslash($_POST['sps_btn_bg_clr'])));
                    }
                    // Handle sps_btn_txt_clr.
                    if (isset($_POST['sps_btn_txt_clr'])) {
                        update_post_meta($post_ID, 'sps_btn_txt_clr', sanitize_hex_color(wp_unslash($_POST['sps_btn_txt_clr'])));
                    }
                    // Handle sps_btn_bg_hov_clr.
                    if (isset($_POST['sps_btn_bg_hov_clr'])) {
                        update_post_meta($post_ID, 'sps_btn_bg_hov_clr', sanitize_hex_color(wp_unslash($_POST['sps_btn_bg_hov_clr'])));
                    }
                    // Handle sps_btn_txt_hov_clr.
                    if (isset($_POST['sps_btn_txt_hov_clr'])) {
                        update_post_meta($post_ID, 'sps_btn_txt_hov_clr', sanitize_hex_color(wp_unslash($_POST['sps_btn_txt_hov_clr'])));
                    }
                    // Handle sps_nav_clr.
                    if (isset($_POST['sps_nav_clr'])) {
                        update_post_meta($post_ID, 'sps_nav_clr', sanitize_hex_color(wp_unslash($_POST['sps_nav_clr'])));
                    }
                    // Handle sps_banner_overlay_clr.
                    if (isset($_POST['sps_banner_overlay_clr'])) {
                        update_post_meta($post_ID, 'sps_banner_overlay_clr', sanitize_hex_color(wp_unslash($_POST['sps_banner_overlay_clr'])));
                    }

                    if(empty($_POST['sps_cat_query'])) { 
                        $sps_cat_query_cat = ''; 
                    }
                    else { 
                        if (is_array($_POST['sps_cat_query'])) {
                            // Ensure each value in the array is sanitized.
                            $sps_cat_query_cat = sanitize_text_field(implode(',', array_map('sanitize_text_field', wp_unslash($_POST['sps_cat_query']))));
                        } else {
                            // If not an array, sanitize the single value directly.
                            $sps_cat_query_cat = sanitize_text_field(wp_unslash($_POST['sps_cat_query']));
                        } 
                    }
                    update_post_meta($post_id, 'sps_cat_query', $sps_cat_query_cat);
                }     
            }       
        }
    }
}
new Spice_Post_Slider_Type();

// Add a nonce field in the form.
function sps_add_nonce_field() {
    wp_nonce_field('sps_meta_save_nonce', 'sps_nonce');
}
add_action('edit_form_advanced', 'sps_add_nonce_field');