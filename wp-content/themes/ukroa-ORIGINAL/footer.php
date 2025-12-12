<footer role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
    <div class="footer-head">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/footerhead.png'); ?>" alt="<?php esc_attr_e('UKROA Footer Banner', 'ukroa'); ?>" class="footer-banner" loading="lazy">
    </div>
    <div class="footer-widgets" style="background-color: #47663b;">
        <div class="footer-content">
            <div class="footer-section">
                <h3><?php _e('About UKROA', 'ukroa'); ?></h3>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="<?php esc_attr_e('UKROA Footer Logo', 'ukroa'); ?>" class="footer-logo" loading="lazy">
                <p><?php _e('Preserving Kirat Rai culture since 2007. Dedicated to promoting our heritage through events and education.', 'ukroa'); ?></p>
            </div>
<!--             <div class="footer-section">
                <h3><?php _e('Contact', 'ukroa'); ?></h3>
                <p><?php _e('Find us: 1010 Avenue, SW 54321', 'ukroa'); ?></p>
                <p><?php _e('Call us: +01 234 567 890', 'ukroa'); ?></p>
                <p><a href="mailto:mail@info.com" rel="nofollow"><?php _e('Mail us: mail@info.com', 'ukroa'); ?></a></p>
            </div> -->

            <?php
    $address = get_theme_mod('address_setting', '');
    $contact = get_theme_mod('contact_setting', '');
    $email = get_theme_mod('email_setting', '');
    if (!empty($address) || !empty($contact) || !empty($email)) :
    ?>
    <div class="footer-section">
        <h3><?php _e('Contact', 'ukroa'); ?></h3>
        <?php if (!empty($address)) : ?>
            <p><?php _e('Find us: ', 'ukroa'); ?><?php echo esc_html($address); ?></p>
        <?php endif; ?>
        <?php if (!empty($contact)) : ?>
            <p><?php _e('Call us: ', 'ukroa'); ?><?php echo esc_html($contact); ?></p>
        <?php endif; ?>
        <?php if (!empty($email)) : ?>
            <p><a href="mailto:<?php echo esc_attr($email); ?>" rel="nofollow"><?php _e('Mail us: ', 'ukroa'); ?><?php echo esc_html($email); ?></a></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
          <!--   <div class="footer-section">
                <h3><?php _e('Useful Links', 'ukroa'); ?></h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'items_wrap' => '<ul>%3$s</ul>',
                ));
                ?>
            </div> -->
            <div class="footer-section useful-links">
    <h3><?php _e('Useful Links', 'ukroa'); ?></h3>
    <div class="menu-container">
        <?php
        // Fetch the menu assigned to the 'primary' theme location
        $menu_locations = get_nav_menu_locations();
        $menu_id = isset($menu_locations['primary']) ? $menu_locations['primary'] : 0;
        $menu_items = $menu_id ? wp_get_nav_menu_items($menu_id) : [];

        if ($menu_items) {
            $total_items = count($menu_items);
            $half = ceil($total_items / 2);
            $first_half = array_slice($menu_items, 0, $half);
            $second_half = array_slice($menu_items, $half);
            ?>
            <div class="menu-column">
                <ul>
                    <?php
                    foreach ($first_half as $item) {
                        echo '<li><a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="menu-column">
                <ul>
                    <?php
                    foreach ($second_half as $item) {
                        echo '<li><a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <?php
        } else {
            echo '<p>' . __('No menu items found. Please assign a menu to the Primary Menu location.', 'ukroa') . '</p>';
        }
        ?>
    </div>
</div>

            <div class="footer-section">
                <h3><?php _e('Subscribe', 'ukroa'); ?></h3>
                <form class="subscribe-form" id="newsletter-form" method="post" action="#">
                    <input type="email" placeholder="<?php esc_attr_e('Your Email', 'ukroa'); ?>" required aria-label="<?php esc_attr_e('Newsletter Email', 'ukroa'); ?>">
                    <?php wp_nonce_field('subscribe_nonce', 'subscribe_nonce_field'); ?>
                    <button type="submit"><?php _e('SUBSCRIBE', 'ukroa'); ?></button>
                </form>
            </div>
            <div class="footer-section">
 <h3><?php _e('Follow Us', 'ukroa'); ?></h3>
        <?php
        $socials = array(
            'facebook' => 'facebook.png',
            'twitter' => 'twitter.png',
            'instagram' => 'instagram.png',
            'youtube' => 'youtube.png'
        );
        $has_socials = false;
        foreach ($socials as $social => $icon) {
            if (get_theme_mod("ukroa_social_$social")) {
                $has_socials = true;
                break;
            }
        }
        if ($has_socials) :
        ?>
            <ul class="social-links">
                <?php
                foreach ($socials as $social => $icon) {
                    $url = get_theme_mod("ukroa_social_$social");
                    if ($url) {
                        echo '<li><a href="' . esc_url($url) . '" target="_blank" rel="noopener"><img src="' . esc_url(get_template_directory_uri() . '/assets/images/' . $icon) . '" alt="' . esc_attr(ucfirst($social)) . ' Icon" class="social-icon" loading="lazy"></a></li>';
                    }
                }
                ?>
            </ul>
        <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="copyright" style="background-color: #2E4B26;">
        <p><?php echo wp_kses_post(get_theme_mod('ukroa_footer_text', __('&copy; 2025 UKROA. All rights reserved.', 'ukroa'))); ?> <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><?php _e('Privacy Policy', 'ukroa'); ?></a></p>
    </div>
    <div id="scroll-to-top" class="scroll-arrow">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/arrow1.png'); ?>" alt="<?php esc_attr_e('Scroll to Top', 'ukroa'); ?>" class="arrow-rest">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/arrow2.png'); ?>" alt="<?php esc_attr_e('Scroll to Top Stretched', 'ukroa'); ?>" class="arrow-stretched">
    </div>
    <?php wp_footer(); ?>
</footer>