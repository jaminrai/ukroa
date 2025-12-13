<?php
/**
 * The header for our theme
 *
 * @package Newscrunch
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head itemscope itemtype="http://schema.org/WebSite">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
		<?php if (is_singular() && pings_open(get_queried_object())) : 
	            echo '<link rel="pingback" href=" '.esc_url(get_bloginfo( 'pingback_url' )).' ">';
	        endif;
		wp_head(); ?>
		<?php if(is_front_page()): ?>
<style>
/* Default state: semi-transparent green when at top (scroll < 100px) */
.spnc-navbar .spnc-container {
    background: rgba(3, 63, 20, 0.68) !important;
    transition: background 0.4s ease;   /* smooth change */
}

/* When scrolled ≥ 100px: fully solid green */
.spnc-navbar .spnc-container.solid {
    background: rgb(53, 78, 43) !important;   /* same green, but 100% opaque */
    box-shadow: 0 2px 15px rgba(0,0,0,0.15); /* optional: nice shadow when solid */
}
.spnc-navbar{
    position: absolute !important;
}
.header-1 .spnc-custom .spnc-navbar{
  background: transparent !important;
}
/* Ensure no child element inherits unwanted transparency */
.spnc-navbar .spnc-container > * {
    position: relative;
    z-index: 2;
}

</style>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".spnc-navbar .spnc-container");

    if (!container) return; // safety check

    function updateNavbar() {
        if (window.scrollY >= 100) {
            container.classList.add("solid");
        } else {
            container.classList.remove("solid");
        }
    }

    // Run immediately on load
    updateNavbar();

    // Run on every scroll
    window.addEventListener("scroll", updateNavbar);
});
</script>

		<?php endif; ?>
	</head>

<?php do_action('newscrunch_wide_boxed_layout');
	  wp_body_open(); ?>
	  
<div class="spnc-wrapper spnc-btn-<?php echo esc_attr(get_theme_mod('heading_layout','1'));?>" id="wrapper">
	<div id="page" class="site <?php echo esc_attr(get_theme_mod('link_animate','a_effect1')). ' '. 'custom-'.esc_attr(get_theme_mod('img_animation','i_effect1'));?>">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'newscrunch' ); ?></a>
		<?php
		if ( class_exists('Newscrunch_Plus') ):
			if(get_theme_mod('progress_bar_enable',true)):echo '<div id="spnc_scroll_progressbar"></div>';endif;
			do_action('spncp_preloader_hook');
			do_action( 'spncp_header_variation' );
			if((get_theme_mod('ad_type','banner')=='popup')):do_action('newscrunch_plus_popup_ad');endif;
		else:
			do_action('newscrunch_preloader');
			do_action( 'newscrunch_header' ); 
		endif;