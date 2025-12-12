<?php
// Exit if accessed directly
if (!defined('ABSPATH')) 
{
    die('Do not open this file directly.');
}

add_shortcode('spice_post_slider', 'sps_shortcode');
if ( !function_exists( 'sps_shortcode' ) ) {
    function sps_shortcode($id)
    {
        ob_start();
        $sps_post_id= !isset($id['id']) ? $sps_shortcodes_cpt_id=$id : $sps_shortcodes_cpt_id=$id['id'];
        //General
        $sps_video_banner=get_post_meta($sps_post_id,'sps_video_banner', true );
        $sps_cat=get_post_meta($sps_post_id,'sps_cat_query', true );
        $sps_orderby=get_post_meta($sps_post_id,'sps_orderby', true );
        $sps_navigation_style=get_post_meta($sps_post_id,'sps_navigation_style', true );
        $sps_loop=get_post_meta($sps_post_id,'sps_post_page', true );
        $sps_item=get_post_meta($sps_post_id,'sps_slide_item', true );
        $sps_img=get_post_meta($sps_post_id,'sps_slide_img', true );
        $sps_dt=get_post_meta($sps_post_id,'sps_dt_enable', true );
        $sps_cat_enable=get_post_meta($sps_post_id,'sps_cat_enable', true );
        $sps_auth=get_post_meta($sps_post_id,'sps_auth_enable', true );
        $sps_comments=get_post_meta($sps_post_id,'sps_comment_enable', true );
        $sps_read=get_post_meta($sps_post_id,'sps_read', true );
        $sps_loop = empty($sps_loop) ? $sps_loop='4' : $sps_loop;
        if(empty(get_post_meta( $sps_post_id, 'sps_slider_type', true ))) {
            $sps_slider_type ='blog_post_slider';
        }
        else {
            $sps_slider_type = get_post_meta( $sps_post_id, 'sps_slider_type', true );
        }
        $sps_title_enable = get_post_meta( $sps_post_id, 'sps_title_enable', true );
        $sps_desc_enable = get_post_meta( $sps_post_id, 'sps_desc_enable', true );
        $sps_banner_overlay_enable = get_post_meta( $sps_post_id, 'sps_banner_overlay_enable', true );
        $sps_banner_overlay_opacity = get_post_meta( $sps_post_id, 'sps_banner_overlay_opacity', true );
        $sps_banner_padding_top = get_post_meta( $sps_post_id, 'sps_banner_padding_top', true );
        $sps_banner_padding_bottom = get_post_meta( $sps_post_id, 'sps_banner_padding_bottom', true );
        $sps_banner_height = get_post_meta( $sps_post_id, 'sps_banner_height', true );
       
        //Slide
        $sps_speed=get_post_meta($sps_post_id,'sps_speed', true );

        //Typography
        $sps_title_ff=get_post_meta( $sps_post_id, 'sps_title_ff', true );
        $sps_title_fs=get_post_meta( $sps_post_id, 'sps_title_fs', true );
        $sps_title_lheight=get_post_meta( $sps_post_id, 'sps_title_lheight', true );
        $sps_title_fw=get_post_meta( $sps_post_id, 'sps_title_fw', true );
        $sps_title_fstyle=get_post_meta( $sps_post_id, 'sps_title_fstyle', true );
        $sps_title_trans=get_post_meta( $sps_post_id, 'sps_title_trans', true );
        $sps_content_ff=get_post_meta( $sps_post_id, 'sps_content_ff', true );
        $sps_content_fs=get_post_meta( $sps_post_id, 'sps_content_fs', true );
        $sps_content_lheight=get_post_meta( $sps_post_id, 'sps_content_lheight', true );
        $sps_content_fw=get_post_meta( $sps_post_id, 'sps_content_fw', true );
        $sps_content_fstyle=get_post_meta( $sps_post_id, 'sps_content_fstyle', true );
        $sps_content_trans=get_post_meta( $sps_post_id, 'sps_content_trans', true );
        $sps_meta_ff=get_post_meta( $sps_post_id, 'sps_meta_ff', true );
        $sps_meta_fs=get_post_meta( $sps_post_id, 'sps_meta_fs', true );
        $sps_meta_lheight=get_post_meta( $sps_post_id, 'sps_meta_lheight', true );
        $sps_meta_fw=get_post_meta( $sps_post_id, 'sps_meta_fw', true );
        $sps_meta_fstyle=get_post_meta( $sps_post_id, 'sps_meta_fstyle', true );
        $sps_meta_trans=get_post_meta( $sps_post_id, 'sps_meta_trans', true );
        $sps_read_ff=get_post_meta( $sps_post_id, 'sps_read_ff', true );
        $sps_read_fs=get_post_meta( $sps_post_id, 'sps_read_fs', true );
        $sps_read_lheight=get_post_meta( $sps_post_id, 'sps_read_lheight', true );
        $sps_read_fw=get_post_meta( $sps_post_id, 'sps_read_fw', true );
        $sps_read_fstyle=get_post_meta( $sps_post_id, 'sps_read_fstyle', true );
        $sps_read_trans=get_post_meta( $sps_post_id, 'sps_read_trans', true );

        //Color
        $sps_icon_clr=get_post_meta( $sps_post_id, 'sps_icon_clr', true );
        $sps_meta_clr=get_post_meta( $sps_post_id, 'sps_meta_clr', true );
        $sps_meta_hov_clr=get_post_meta( $sps_post_id, 'sps_meta_hov_clr', true );
        $sps_title_clr=get_post_meta( $sps_post_id, 'sps_title_clr', true );
        $sps_title_hov_clr=get_post_meta( $sps_post_id, 'sps_title_hov_clr', true );
        $sps_content_clr=get_post_meta( $sps_post_id, 'sps_content_clr', true );
        $sps_btn_bg_clr=get_post_meta( $sps_post_id, 'sps_btn_bg_clr', true );
        $sps_btn_txt_clr=get_post_meta( $sps_post_id, 'sps_btn_txt_clr', true );
        $sps_btn_bg_hov_clr=get_post_meta( $sps_post_id, 'sps_btn_bg_hov_clr', true );
        $sps_btn_txt_hov_clr=get_post_meta( $sps_post_id, 'sps_btn_txt_hov_clr', true );
        $sps_nav_clr=get_post_meta( $sps_post_id, 'sps_nav_clr', true );
        $sps_banner_overlay_clr= get_post_meta( $sps_post_id, 'sps_banner_overlay_clr', true );

        if(empty($sps_cat)) {
            $query_args = array('posts_per_page' =>$sps_loop,'order' => $sps_orderby,'ignore_sticky_posts' => 1); }
        else{
             $sps_cat_arr=explode(',',$sps_cat);
             $query_args = array( 'category__in'  => $sps_cat_arr, 'posts_per_page' =>$sps_loop,'order' => $sps_orderby,'ignore_sticky_posts' => 1); }
             if($sps_slider_type=="vdo_slider")
             {
                include('video-slider.php');
             } 
             else 
             { 
                include('banner-post-slider.php');
              } 
              ?> 
       <script type="text/javascript">
           jQuery(document).ready(function() {
            
            var sps_navigation = '<?php echo esc_html($sps_navigation_style); ?>';
            var sps_nav_style_nav = '';
            var sps_nav_style_dot = '';
            switch (sps_navigation) {

                case 'none':
                    sps_nav_style_nav = false;
                    sps_nav_style_dot = false;
                    break;
                case 'bullets':
                    sps_nav_style_nav = false;
                    sps_nav_style_dot = true;
                    break;
                case 'navigation':
                    sps_nav_style_nav = true;
                    sps_nav_style_dot = false;
                    break;
                default:
                    sps_nav_style_nav = true;
                    sps_nav_style_dot = true;
            }

            jQuery("#blog-carousel<?php echo intval($sps_post_id);?>").owlCarousel({
                navigation : true, // Show next and prev buttons        
                autoplay: true,
                autoplayTimeout: <?php echo intval($sps_speed);?> + 700,
                autoplayHoverPause: true,
                smartSpeed: <?php echo intval($sps_speed);?>,
                loop:true, // loop is true up to 1199px screen.
                nav:sps_nav_style_nav, // is true across all sizes
                margin:<?php if($sps_slider_type == 'banner_slider' || $sps_slider_type == 'vdo_slider') { echo '0'; } else { echo '30'; } ?>, // margin 10px till 960 breakpoint
                autoHeight: true,
                responsiveClass:true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
                dots: sps_nav_style_dot,
                navText: ["<i class='fas fa-chevron-left'></i>","<i class='fas fa-chevron-right'></i>"],
                responsive:{    
                    100:{ items:1 },
                    480:{ items:1 },
                    768:{ items:<?php if($sps_slider_type == 'banner_slider' || $sps_slider_type == 'vdo_slider') { echo '1'; } else { echo '3'; } ?> },
                    1000:{ items:<?php if($sps_slider_type == 'banner_slider' || $sps_slider_type == 'vdo_slider') { echo '1'; } else { echo intval($sps_item); } ?>  }            
                }
            }); 
        });
       </script>
       <style type="text/css">
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .post .post-content h3 a,
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .sps-post .sps-post-content h3 a
                {
                    font-family: '<?php echo esc_attr($sps_title_ff);?>';
                    font-size: <?php echo intval($sps_title_fs);?>px;
                    line-height: <?php echo intval($sps_title_lheight);?>px;
                    font-weight: <?php echo intval($sps_title_fw);?>;
                    font-style: <?php echo esc_attr($sps_title_fstyle);?>;
                    text-transform: <?php echo esc_attr($sps_title_trans);?>;
                }
            body .sps<?php echo intval($sps_post_id);?> .entry-content p, body .sps<?php echo intval($sps_post_id);?> .entry-content span,
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .sps-post .sps-post-content p
                {
                    font-family: '<?php echo esc_attr($sps_content_ff);?>';
                    font-size: <?php echo intval($sps_content_fs);?>px;
                    line-height: <?php echo intval($sps_content_lheight);?>px;
                    font-weight: <?php echo intval($sps_content_fw);?>;
                    font-style: <?php echo esc_attr($sps_content_fstyle);?>;
                    text-transform: <?php echo esc_attr($sps_content_trans);?>;
                }
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .post .post-content .entry-meta a,
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .sps-post .sps-post-content .sps-entry-meta a
                {
                    font-family: '<?php echo esc_attr($sps_meta_ff);?>';
                    font-size: <?php echo intval($sps_meta_fs);?>px;
                    line-height: <?php echo intval($sps_meta_lheight);?>px;
                    font-weight: <?php echo intval($sps_meta_fw);?>;
                    font-style: <?php echo esc_attr($sps_meta_fstyle);?>;
                    text-transform: <?php echo esc_attr($sps_meta_trans);?>;           
                }
            body .sps<?php echo intval($sps_post_id);?> .post .more-link,
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .sps-post .sps-post-content .sps-more-link
                {
                    font-family: '<?php echo esc_attr($sps_read_ff);?>';
                    font-size: <?php echo intval($sps_read_fs);?>px;
                    line-height: <?php echo intval($sps_read_lheight);?>px;
                    font-weight: <?php echo intval($sps_read_fw);?>;
                    font-style: <?php echo esc_attr($sps_read_fstyle);?>;
                    text-transform: <?php echo esc_attr($sps_read_trans);?>; 
                }    
            body .sps<?php echo intval($sps_post_id);?> .entry-meta i,
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .sps-entry-meta i {
                color: <?php echo esc_attr($sps_icon_clr);?>;
            }
            body .sps<?php echo intval($sps_post_id);?>.sps-bnr-video .sps-entry-meta .sps-cat-links a
            {
                    background-color: <?php echo esc_attr($sps_icon_clr);?>;
            }
            body .sps<?php echo intval($sps_post_id);?> .entry-meta a,
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .sps-entry-meta a
             {
                color:<?php echo esc_attr($sps_meta_clr);?> !important;
            }
            body .sps<?php echo intval($sps_post_id);?> .entry-meta a:hover,
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .sps-entry-meta a:hover {
                color: <?php echo esc_attr($sps_meta_hov_clr);?> !important;
            }
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .post .post-content h3 a,
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .sps-post .sps-post-content h3 a {
                color: <?php echo esc_attr($sps_title_clr);?>;
            }
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .post .post-content h3 a:hover,
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .sps-post .sps-post-content h3 a:hover{ 
                color: <?php echo esc_attr($sps_title_hov_clr);?>;
            }
            .sps-bnr-video .sps-post-wrapper
            {
                    border-left: 10px solid <?php echo esc_attr($sps_title_hov_clr);?>;
            }
            body .sps<?php echo intval($sps_post_id);?> .post .more-link,
            body .sps<?php echo intval($sps_post_id);?>.sps-bnr-video .sps-post .sps-more-link {
                background: <?php echo esc_attr($sps_btn_bg_clr);?>; 
                color: <?php echo esc_attr($sps_btn_txt_clr);?> !important;
            }
            body .sps<?php echo intval($sps_post_id);?>.sps-bnr-video .sps-post .sps-more-link
            {
                border: 1px solid <?php echo esc_attr($sps_btn_bg_clr);?>;
            }
            body .sps<?php echo intval($sps_post_id);?> .post .more-link i{
                color: <?php echo esc_attr($sps_btn_txt_clr);?> !important;
            }
            body .sps<?php echo intval($sps_post_id);?> .post .more-link:hover, body .sps<?php echo intval($sps_post_id);?>.sps-bnr-video .sps-post .sps-more-link:hover  {
                background: <?php echo esc_attr($sps_btn_bg_hov_clr);?>; 
                color: <?php echo esc_attr($sps_btn_txt_hov_clr);?> !important;
                border: 1px solid <?php echo esc_attr($sps_btn_bg_hov_clr);?>;
            }
            body .sps<?php echo intval($sps_post_id);?> .post .more-link:hover i{
                color: <?php echo esc_attr($sps_btn_txt_hov_clr);?> !important;
            }
            body .sps<?php echo intval($sps_post_id);?> .entry-content p,
            body .sps<?php echo intval($sps_post_id);?>.page-section-space.blog .sps-post .sps-post-content p {
                color: <?php echo esc_attr($sps_content_clr);?>;
            }
            body .sps<?php echo intval($sps_post_id);?> .owl-carousel .owl-prev:hover, body .sps<?php echo intval($sps_post_id);?> .owl-carousel .owl-prev:focus, body .sps<?php echo intval($sps_post_id);?> .owl-carousel .owl-next:hover, body .sps<?php echo intval($sps_post_id);?> .owl-carousel .owl-next:focus {
                background-color: <?php echo esc_attr($sps_nav_clr);?>;
            }
            body .sps<?php echo intval($sps_post_id);?> .owl-theme .owl-dots .owl-dot.active span {
                background-color: <?php echo esc_attr($sps_nav_clr);?>;
            }
            .sps.sps-banner-style .overlay,
            body .sps<?php echo intval($sps_post_id);?>.sps-bnr-video .sps-post-overlay {
                opacity: <?php echo esc_attr($sps_banner_overlay_opacity);?>;
                background-color: <?php echo esc_attr($sps_banner_overlay_clr); ?>;
            }
        </style>
        <?php if($sps_slider_type == 'banner_slider' || $sps_slider_type == 'vdo_slider') { ?>
            <style type="text/css">
                .sps.page-section-space.sps-banner-style {
                    padding: <?php echo esc_attr($sps_banner_padding_top);?>rem 0 <?php echo esc_attr($sps_banner_padding_bottom);?>rem;
                }
                body .page-section-space.video_slider.sps-bnr-video.sps<?php echo esc_attr($sps_post_id);?>
                {
                    padding: 0 0 0;
                    margin: <?php echo esc_attr($sps_banner_padding_top);?>px 0 <?php echo esc_attr($sps_banner_padding_bottom);?>px;
                } 
                .sps.page-section-space.blog.sps-banner-style .post .post-thumbnail,
                .sps.video_slider.sps<?php echo esc_attr($sps_post_id);?> .item
                 {
                    height: <?php echo esc_attr($sps_banner_height);?>vh;
                }
                .sps.page-section-space.blog.sps-banner-style .post {
                    margin-bottom: 0;
                }
                .sps.page-section-space.blog.sps-banner-style .post-thumbnail .wp-post-image {
                    height: 100% !important;
                    width: 100%;
                }
                .sps.blog.sps-banner-style .post:hover, .sps.blog.sps-banner-style .post:focus {
                    transform: unset;
                }
            </style>
        <?php }
        return ob_get_clean();
    }
}