<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="description" content="<?php 
        if (is_single() || is_page()) {
            echo esc_attr(wp_trim_words(get_the_excerpt(), 25));
        } else {
            echo esc_attr(get_bloginfo('description'));
        }
    ?>">
    <meta name="keywords" content="United Kirat Rai Organization of America, UKROA, Kirat Rai Yayokkha, Kirat Rai culture, Nepali community USA">
    <meta name="author" content="UKROA">

     <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo esc_url(home_url($wp->request)); ?>" />

   <!-- Enhanced Open Graph -->
    <meta property="og:locale" content="<?php echo esc_attr(get_locale()); ?>">
    <meta property="og:type" content="<?php echo (is_single()) ? 'article' : 'website'; ?>">
    <meta property="og:title" content="<?php 
        if (is_single() || is_page()) {
            echo esc_attr(get_the_title() . ' - ' . get_bloginfo('name'));
        } else {
            echo esc_attr(wp_get_document_title());
        }
    ?>">
    <meta property="og:description" content="<?php 
        if (is_single() || is_page()) {
            echo esc_attr(wp_trim_words(get_the_excerpt(), 25));
        } else {
            echo esc_attr(get_bloginfo('description'));
        }
    ?>">
    <meta property="og:url" content="<?php echo esc_url(home_url($wp->request)); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <meta property="og:image" content="<?php 
        if (is_single() && has_post_thumbnail()) {
            echo esc_url(get_the_post_thumbnail_url(null, 'large'));
        } else {
            echo esc_url(get_template_directory_uri() . '/assets/images/logo.png');
        }
    ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?php echo esc_attr(get_bloginfo('name')); ?>">


 <!-- Enhanced Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
    <meta name="twitter:description" content="<?php 
        if (is_single() || is_page()) {
            echo esc_attr(wp_trim_words(get_the_excerpt(), 25));
        } else {
            echo esc_attr(get_bloginfo('description'));
        }
    ?>">
    <meta name="twitter:image" content="<?php 
        if (is_single() && has_post_thumbnail()) {
            echo esc_url(get_the_post_thumbnail_url(null, 'large'));
        } else {
            echo esc_url(get_template_directory_uri() . '/assets/images/logo.png');
        }
    ?>">
    <meta name="twitter:site" content="@UKROA">

<!-- Structured Data -->
    <?php if (is_front_page()) : ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?php echo esc_js(get_bloginfo('name')); ?>",
        "url": "<?php echo esc_url(home_url()); ?>",
        "logo": "<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>",
        "description": "<?php echo esc_js(get_bloginfo('description')); ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "2918 E 135 Place",
            "addressLocality": "Thornton",
            "addressRegion": "CO",
            "postalCode": "80241"
        }
    }
    </script>
    <?php endif; ?>

    <title><?php wp_title('|', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

       <!-- Enhanced preload with accessibility -->
    <div id="preload-animation" class="preload-container" aria-live="polite" aria-label="<?php esc_attr_e('Loading animation', 'ukroa'); ?>">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/dholjhyamta.png'); ?>" 
             alt="<?php esc_attr_e('Welcome Logo', 'ukroa'); ?>" 
             class="welcome-logo"
             width="69" height="27">
        <div class="welcome-text">UKROA</div>
    </div>

<!--     <div id="preload-animation" class="preload-container">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/dholjhyamta.png'); ?>" alt="<?php esc_attr_e('Welcome Logo', 'ukroa'); ?>" class="welcome-logo">
        <div class="welcome-text">UKROA</div>
    </div> -->
 <header itemscope itemtype="https://schema.org/Organization">
    <?php the_custom_logo(); // Header logo ?>
    <h1 itemprop="name"><?php bloginfo('name'); ?></h1>
    <nav role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'ukroa'); ?>">
    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/leftlogo.png'); ?>" alt="<?php esc_attr_e('UKROA Logo', 'ukroa'); ?>" class="logo">
    <div class="hamburger" tabindex="0" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle Menu', 'ukroa'); ?>">&#9776;</div>
    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_class' => 'primary-menu',
        'container' => false,
        'fallback_cb' => false,
        'depth' => 2,
        'walker' => new UKROA_Walker_Nav_Menu(),
    ));
    ?>
<div id="search-box">
    <span class="search-icon" tabindex="0" role="button" aria-label="<?php esc_attr_e('Toggle Search', 'ukroa'); ?>" aria-expanded="false">&#128269;</span>
    <form id="search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="text" name="s" id="search-input" placeholder="<?php esc_attr_e('Search...', 'ukroa'); ?>" aria-label="<?php esc_attr_e('Site Search', 'ukroa'); ?>">
        <button type="submit" aria-label="<?php esc_attr_e('Submit Search', 'ukroa'); ?>"><?php _e('Go', 'ukroa'); ?></button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Close search when clicking outside
    document.addEventListener('click', function (e) {
        if (!searchForm.contains(e.target) && !searchIcon.contains(e.target)) {
            searchIcon.setAttribute('aria-expanded', 'false');
            searchInput.classList.remove('active');
        }
    });
});
</script>
</nav>
</header>