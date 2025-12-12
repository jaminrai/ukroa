<?php get_header(); ?>

<main role="main" itemscope itemtype="https://schema.org/WebPage">
    <section id="welcome">
        <h2><?php _e('Welcome to UKROA', 'ukroa'); ?></h2>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; endif; ?>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/cultural-event.jpg'); ?>" alt="<?php esc_attr_e('Kirat Rai Sakela Dance Festival', 'ukroa'); ?>" loading="lazy" style="width:100%; max-width:600px; display:block; margin:20px auto;">
    </section>

    <section id="goals">
        <h2><?php _e('Our Goals (Inspired by Sustainable Development)', 'ukroa'); ?></h2>
        <ul>
            <li><?php _e('No Poverty: Supporting community members.', 'ukroa'); ?></li>
            <li><?php _e('Quality Education: Language classes.', 'ukroa'); ?></li>
            <li><?php _e('Gender Equality: Empowering women in culture.', 'ukroa'); ?></li>
        </ul>
    </section>

    <section id="activities">
        <h2><?php _e('Get Involved', 'ukroa'); ?></h2>
        <p><?php _e('Donate, subscribe, follow us, or comment on news.', 'ukroa'); ?></p>
        <a href="<?php echo esc_url(home_url('/donate/')); ?>" class="button"><?php _e('Donate Now', 'ukroa'); ?></a>
    </section>

    <section id="teasers">
        <h2><?php _e('Explore', 'ukroa'); ?></h2>
        <div class="projects-grid">
            <div><a href="<?php echo esc_url(home_url('/about-us/')); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/about-teaser.jpg'); ?>" alt="<?php esc_attr_e('About Teaser', 'ukroa'); ?>" loading="lazy"> <?php _e('About Us', 'ukroa'); ?></a></div>
            <!-- Add more dynamic links as needed -->
        </div>
    </section>

    <section id="sponsorship">
        <h2><?php _e('Business Sponsorship', 'ukroa'); ?></h2>
        <p><?php _e('Sponsor Grand Sakela for visibility in our community.', 'ukroa'); ?></p>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="button"><?php _e('Sponsor', 'ukroa'); ?></a>
    </section>

    <section id="media">
        <h2><?php _e('Media', 'ukroa'); ?></h2>
        <p><?php _e('Download press kit.', 'ukroa'); ?></p>
        <a href="<?php echo esc_url(get_template_directory_uri() . '/downloads/press-kit.pdf'); ?>" download class="button"><?php _e('Press Kit', 'ukroa'); ?></a>
    </section>

    <?php
    $recent_posts = wp_get_recent_posts(array('numberposts' => 3, 'post_status' => 'publish'));
    if ($recent_posts) {
        echo '<section id="recent-news"><h2>' . esc_html__('Recent News', 'ukroa') . '</h2><ul>';
        foreach ($recent_posts as $post) {
            echo '<li><a href="' . esc_url(get_permalink($post['ID'])) . '">' . esc_html($post['post_title']) . '</a></li>';
        }
        echo '</ul></section>';
    }
    ?>
</main>

<?php get_sidebar(); // Add sidebar if needed ?>
<?php get_footer(); ?>