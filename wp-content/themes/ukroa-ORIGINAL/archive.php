<?php get_header(); ?>

<main role="main" id="main-content" class="archive-container">
    <?php if (is_category()) : ?>
        <header class="archive-header" itemprop="headline">
            <h1 class="archive-title"><?php single_cat_title('', true); ?></h1>
            <?php if (category_description()) : ?>
                <div class="archive-description" itemprop="description"><?php echo wp_kses_post(category_description()); ?></div>
            <?php endif; ?>
        </header>
    <?php elseif (is_tag()) : ?>
        <header class="archive-header" itemprop="headline">
            <h1 class="archive-title"><?php single_tag_title('', true); ?></h1>
            <?php if (tag_description()) : ?>
                <div class="archive-description" itemprop="description"><?php echo wp_kses_post(tag_description()); ?></div>
            <?php endif; ?>
        </header>
    <?php elseif (is_author()) : ?>
        <header class="archive-header" itemprop="headline">
            <h1 class="archive-title"><?php the_author(); ?></h1>
            <?php if (get_the_author_meta('description')) : ?>
                <div class="archive-description" itemprop="description"><?php the_author_meta('description'); ?></div>
            <?php endif; ?>
        </header>
    <?php else : ?>
        <header class="archive-header" itemprop="headline">
            <h1 class="archive-title"><?php the_archive_title(); ?></h1>
        </header>
    <?php endif; ?>

    <div class="content-sidebar-wrapper">
        <section class="archive-content" aria-label="<?php esc_attr_e('Archive Posts', 'ukroa'); ?>">
            <?php if (have_posts()) : ?>
                <div class="post-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?> itemscope itemtype="https://schema.org/BlogPosting">
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>" itemprop="url">
                                    <?php 
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('medium', array(
                                            'class' => 'post-image',
                                            'itemprop' => 'image',
                                            'alt' => the_title_attribute(array('echo' => false))
                                        ));
                                    } else {
                                        $default_images = array(
                                            'featured1.png',
                                            'featured2.png',
                                            'featured3.png',
                                            'featured4.png',
                                            'featured5.png'
                                        );
                                        $random_image = $default_images[array_rand($default_images)];
                                        $image_path = get_template_directory_uri() . '/assets/images/featured/' . $random_image;
                                        ?>
                                        <img src="<?php echo esc_url($image_path); ?>" class="post-image" itemprop="image" alt="<?php the_title_attribute(); ?>">
                                    <?php } ?>
                                    <span class="post-date"><?php echo esc_html(get_the_date('F j, Y')); ?></span>
                                    <?php 
                                    $tags = get_the_tags();
                                    if ($tags && !is_wp_error($tags)) {
                                        $first_tag = $tags[0];
                                        ?>
                                        <span class="post-tag"><?php echo esc_html($first_tag->name); ?></span>
                                    <?php } ?>
                                </a>
                            </div>
                            <div class="post-content">
                                <h2 class="post-title" itemprop="headline">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a>
                                </h2>
                                <meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date('c')); ?>">
                                <meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('c')); ?>">
                               <!--  <div class="post-meta" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                    <meta itemprop="name" content="<?php bloginfo('name'); ?>">
                                    <span class="post-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                        <meta itemprop="name" content="<?php the_author(); ?>">
                                    </span>
                                </div> -->
                                <div class="post-excerpt" itemprop="description"><?php the_excerpt(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="read-more" aria-label="<?php esc_attr_e('Read more about', 'ukroa'); ?> <?php the_title_attribute(); ?>"><?php _e('Read More', 'ukroa'); ?></a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <?php the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('Previous', 'ukroa'),
                    'next_text' => __('Next', 'ukroa'),
                    'type' => 'list',
                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'ukroa') . ' </span>',
                )); ?>
            <?php else : ?>
                <p class="no-posts"><?php _e('No posts found.', 'ukroa'); ?></p>
            <?php endif; ?>
        </section>

        <aside class="sidebar" role="complementary" aria-label="<?php esc_attr_e('Sidebar', 'ukroa'); ?>">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</main>

<?php get_footer(); ?>