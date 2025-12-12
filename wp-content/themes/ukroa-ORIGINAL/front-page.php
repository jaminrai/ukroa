<?php
/**
 * The template for displaying the front page
 *
 * @package ukroa
 */
get_header(); ?>

<main role="main" itemscope itemtype="https://schema.org/WebPage">

    <!-- Hero Section -->
    <section id="hero" class="hero-section" style="background-image: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/headerbanner.jpg'); ?>');">
        <div class="hero-overlay">
            <div class="hero-content">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/dholjhyamta.png'); ?>" 
                     alt="<?php esc_attr_e('UKROA Cultural Symbol', 'ukroa'); ?>" 
                     class="hero-logo" 
                     loading="lazy">
                <h1><?php _e('Welcome to United Kirat Rai Organization of America', 'ukroa'); ?></h1>
                <p><?php _e('Celebrating Kirat Rai culture, community, and heritage in the USA', 'ukroa'); ?></p>
                <a href="<?php echo esc_url(home_url('/membership/')); ?>" class="cta-button"><?php _e('Join UKROA', 'ukroa'); ?></a>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about-us" class="content-section">
        <div class="container">
            <h2><?php _e('About Us', 'ukroa'); ?></h2>
            <p><?php _e('UKROA is dedicated to preserving and promoting Kirat Rai culture, fostering community unity, and supporting sustainable development initiatives.', 'ukroa'); ?></p>
            <a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="read-more"><?php _e('Learn More', 'ukroa'); ?></a>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="content-section gallery-section">
        <div class="container">
            <h2><?php _e('Gallery', 'ukroa'); ?></h2>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/cultural-event.jpg'); ?>" 
                         alt="<?php esc_attr_e('Kirat Rai Sakela Dance', 'ukroa'); ?>" 
                         loading="lazy">
                </div>
                <div class="gallery-item">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/about-teaser.jpg'); ?>" 
                         alt="<?php esc_attr_e('Community Event', 'ukroa'); ?>" 
                         loading="lazy">
                </div>
                <!-- Add more dynamic images via custom post type or page -->
            </div>
            <a href="<?php echo esc_url(home_url('/gallery/')); ?>" class="read-more"><?php _e('View Gallery', 'ukroa'); ?></a>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="content-section">
        <div class="container">
            <h2><?php _e('Our Team', 'ukroa'); ?></h2>
            <p><?php _e('Meet the dedicated individuals leading UKROA’s mission to strengthen our community.', 'ukroa'); ?></p>
            <div class="team-grid">
                <!-- Example static team member; replace with dynamic WP_Query if using custom post type -->
                <div class="team-member">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" 
                         alt="<?php esc_attr_e('Team Member', 'ukroa'); ?>" 
                         loading="lazy">
                    <h3><?php _e('Team Member Name', 'ukroa'); ?></h3>
                    <p><?php _e('Role/Position', 'ukroa'); ?></p>
                </div>
            </div>
            <a href="<?php echo esc_url(home_url('/team/')); ?>" class="read-more"><?php _e('Meet the Team', 'ukroa'); ?></a>
        </div>
    </section>

    <!-- News & Events Section -->
    <section id="news-events" class="content-section">
        <div class="container">
            <h2><?php _e('News & Events', 'ukroa'); ?></h2>
            <div class="news-grid">
                <?php
                $news_query = new WP_Query(array(
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                ));
                if ($news_query->have_posts()) :
                    while ($news_query->have_posts()) : $news_query->the_post(); ?>
                        <article class="news-item">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', ['class' => 'news-image', 'alt' => get_the_title()]); ?>
                                </a>
                            <?php endif; ?>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            <span class="news-date"><?php echo get_the_date(); ?></span>
                        </article>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p><?php _e('No recent news or events found.', 'ukroa'); ?></p>
                <?php endif; ?>
            </div>
            <a href="<?php echo esc_url(home_url('/news-events/')); ?>" class="read-more"><?php _e('More News & Events', 'ukroa'); ?></a>
        </div>
    </section>

    <!-- Graduates Section -->
    <section id="graduates" class="content-section">
        <div class="container">
            <h2><?php _e('Graduates', 'ukroa'); ?></h2>
            <p><?php _e('Celebrating the academic achievements of our community members.', 'ukroa'); ?></p>
            <a href="<?php echo esc_url(home_url('/graduates/')); ?>" class="read-more"><?php _e('View Graduates', 'ukroa'); ?></a>
        </div>
    </section>

    <!-- Membership Section -->
    <section id="membership" class="content-section membership-section" style="background-color: var(--light-green); color: var(--white);">
        <div class="container">
            <h2><?php _e('Become a Member', 'ukroa'); ?></h2>
            <p><?php _e('Join UKROA to support our mission and connect with the Kirat Rai community.', 'ukroa'); ?></p>
            <a href="<?php echo esc_url(home_url('/membership/')); ?>" class="cta-button"><?php _e('Join Now', 'ukroa'); ?></a>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section id="contact-us" class="content-section">
        <div class="container">
            <h2><?php _e('Contact Us', 'ukroa'); ?></h2>
            <p><?php _e('Get in touch with us for inquiries, sponsorships, or community involvement.', 'ukroa'); ?></p>
            <p>
                <?php
                $address = get_theme_mod('address_setting', '2918 E 135 Place, Thornton, CO 80241');
                $email = get_theme_mod('email_setting', 'ukroa@gmail.com');
                echo esc_html($address) . '<br>';
                echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
                ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="read-more"><?php _e('Contact Form', 'ukroa'); ?></a>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="content-section">
        <div class="container">
            <h2><?php _e('Frequently Asked Questions', 'ukroa'); ?></h2>
            <div class="faq-item">
                <h3><?php _e('What is UKROA?', 'ukroa'); ?></h3>
                <p><?php _e('UKROA is a non-profit dedicated to preserving Kirat Rai culture and supporting our community in the USA.', 'ukroa'); ?></p>
            </div>
            <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="read-more"><?php _e('View All FAQs', 'ukroa'); ?></a>
        </div>
    </section>

    <!-- Condolences Section -->
    <section id="condolences" class="content-section">
        <div class="container">
            <h2><?php _e('Condolences', 'ukroa'); ?></h2>
            <p><?php _e('We honor and remember members of our community who have passed away.', 'ukroa'); ?></p>
            <a href="<?php echo esc_url(home_url('/condolences/')); ?>" class="read-more"><?php _e('View Condolences', 'ukroa'); ?></a>
        </div>
    </section>

</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>