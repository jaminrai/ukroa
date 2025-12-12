<?php get_header(); ?>

<main role="main" id="main-content" class="single-container" itemprop="mainEntity" itemscope itemtype="https://schema.org/Article">
       <!-- Breadcrumbs for SEO -->
                        <nav class="breadcrumb" aria-label="<?php esc_attr_e('Breadcrumb', 'ukroa'); ?>">
                            <?php
                            if (function_exists('yoast_breadcrumb')) {
                                yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                            } else {
                                // Simple breadcrumb fallback
                                echo '<a href="' . esc_url(home_url()) . '">' . __('Home', 'ukroa') . '</a> &raquo; ';
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a> &raquo; ';
                                }
                                echo '<span class="current">' . get_the_title() . '</span>';
                            }
                            ?>
                        </nav>
    <div class="content-sidebar-wrapper">

        <section class="single-post" aria-label="<?php esc_attr_e('Single Post', 'ukroa'); ?>">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                    
                    <!-- Enhanced structured data -->
                    <meta itemprop="mainEntityOfPage" content="<?php the_permalink(); ?>">
                    <meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date('c')); ?>">
                    <meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('c')); ?>">
                    
                    <div class="single-header">
                     
                        
                        <h1 class="single-title" itemprop="headline"><?php the_title(); ?></h1>
                        
                        <!-- Enhanced post meta with schema -->
                        <div class="post-meta" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                            <meta itemprop="name" content="<?php bloginfo('name'); ?>">
                            <div class="meta-item" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                <span class="post-author">
                                    <?php _e('By', 'ukroa'); ?> 
                                    <span itemprop="name"><?php the_author(); ?></span>
                                </span>
                            </div>
                            <div class="meta-item">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished">
                                    <?php echo esc_html(get_the_date('F j, Y')); ?>
                                </time>
                            </div>
                            <div class="meta-item">
                                <span class="reading-time">
                                    <?php
                                    $content = get_the_content();
                                    $word_count = str_word_count(strip_tags($content));
                                    $reading_time = ceil($word_count / 200);
                                    printf(_n('%d min read', '%d min read', $reading_time, 'ukroa'), $reading_time);
                                    ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Enhanced featured image with lazy loading -->
                        <div class="post-thumbnail" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                            <?php 
                            if (has_post_thumbnail()) {
                                $thumbnail_id = get_post_thumbnail_id();
                                $alt_text = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) ?: the_title_attribute(array('echo' => false));
                                echo wp_get_attachment_image(
                                    $thumbnail_id,
                                    'large',
                                    false,
                                    array(
                                        'class' => 'post-image',
                                        'itemprop' => 'image',
                                        'alt' => esc_attr($alt_text),
                                        'loading' => 'lazy',
                                        'srcset' => wp_get_attachment_image_srcset($thumbnail_id, 'large'),
                                        'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 80vw, 1200px'
                                    )
                                );
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
                                <img src="<?php echo esc_url($image_path); ?>" 
                                     class="post-image" 
                                     itemprop="image" 
                                     alt="<?php the_title_attribute(); ?>"
                                     loading="lazy"
                                     width="800" height="400">
                            <?php } ?>
                            <meta itemprop="url" content="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>">
                        </div>
                    </div>
                    
                    <!-- Enhanced post content -->
                    <div class="post-content" itemprop="articleBody">
                        <?php 
                        the_content();
                        
                        // Enhanced pagination for multi-page posts
                        wp_link_pages(array(
                            'before' => '<div class="page-links" aria-label="' . esc_attr__('Post pages navigation', 'ukroa') . '"><span class="page-links-title">' . __('Pages:', 'ukroa') . '</span>',
                            'after' => '</div>',
                            'link_before' => '<span class="page-number">',
                            'link_after' => '</span>',
                            'pagelink' => '<span class="screen-reader-text">' . __('Page', 'ukroa') . ' </span>%',
                            'separator' => '<span class="screen-reader-text">, </span>',
                        ));
                        ?>
                    </div>
                    
                    <!-- Enhanced tags section -->
                    <?php 
                    $tags = get_the_tags();
                    if ($tags && !is_wp_error($tags)) : 
                    ?>
                        <div class="post-tags">
                            <h2 class="tags-title"><?php _e('Tags', 'ukroa'); ?></h2>
                            <ul class="tag-list" aria-label="<?php esc_attr_e('Post tags', 'ukroa'); ?>">
                                <?php foreach ($tags as $tag) : ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                                           rel="tag" 
                                           class="tag-link">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Enhanced share section with security -->
                    <div class="share-section">
                        <h2 class="share-title"><?php _e('Share This Post', 'ukroa'); ?></h2>
                        <ul class="share-links" aria-label="<?php esc_attr_e('Social sharing options', 'ukroa'); ?>">
                            <li>
                                <a href="<?php echo esc_url('https://twitter.com/intent/tweet?url=' . urlencode(get_permalink()) . '&text=' . urlencode(get_the_title())); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer nofollow" 
                                   aria-label="<?php esc_attr_e('Share on Twitter', 'ukroa'); ?>"
                                   class="share-link twitter">
                                    Twitter
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . urlencode(get_permalink())); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer nofollow" 
                                   aria-label="<?php esc_attr_e('Share on Facebook', 'ukroa'); ?>"
                                   class="share-link facebook">
                                    Facebook
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url('https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode(get_permalink()) . '&title=' . urlencode(get_the_title())); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer nofollow" 
                                   aria-label="<?php esc_attr_e('Share on LinkedIn', 'ukroa'); ?>"
                                   class="share-link linkedin">
                                    LinkedIn
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Author bio for SEO -->
                    <div class="author-bio" itemprop="author" itemscope itemtype="https://schema.org/Person">
                        <h2><?php _e('About the Author', 'ukroa'); ?></h2>
                        <div class="author-info">
                            <div class="author-avatar">
                                <?php echo get_avatar(get_the_author_meta('ID'), 80, '', get_the_author_meta('display_name')); ?>
                            </div>
                            <div class="author-details">
                                <h3 itemprop="name"><?php the_author(); ?></h3>
                                <p itemprop="description"><?php echo esc_html(get_the_author_meta('description')); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <?php 
                    // Enhanced comments with security
                    if (comments_open() || get_comments_number()) {
                        comments_template();
                    }
                    ?>
                    
                    <!-- Enhanced related posts -->
                    <div class="related-posts">
                        <h2 class="related-title"><?php _e('You Might Also Like', 'ukroa'); ?></h2>
                        <?php
                        $related = new WP_Query(array(
                            'post__not_in' => array(get_the_ID()),
                            'posts_per_page' => 4,
                            'tag__in' => wp_get_post_tags(get_the_ID(), array('fields' => 'ids')),
                            'ignore_sticky_posts' => 1,
                            'orderby' => 'rand',
                            'no_found_rows' => true, // Performance optimization
                        ));
                        
                        if ($related->have_posts()) : ?>
                            <div class="related-grid" role="list" aria-label="<?php esc_attr_e('Related posts', 'ukroa'); ?>">
                                <?php while ($related->have_posts()) : $related->the_post(); ?>
                                    <article class="related-item" role="listitem" itemscope itemtype="https://schema.org/Article">
                                        <div class="related-thumbnail">
                                            <a href="<?php the_permalink(); ?>" itemprop="url">
                                                <?php 
                                                if (has_post_thumbnail()) {
                                                    the_post_thumbnail('medium', array(
                                                        'class' => 'related-image',
                                                        'itemprop' => 'image',
                                                        'alt' => the_title_attribute(array('echo' => false)),
                                                        'loading' => 'lazy'
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
                                                    <img src="<?php echo esc_url($image_path); ?>" 
                                                         class="related-image" 
                                                         itemprop="image" 
                                                         alt="<?php the_title_attribute(); ?>"
                                                         loading="lazy"
                                                         width="300" height="200">
                                                <?php } ?>
                                            </a>
                                        </div>
                                        <h3 class="related-title" itemprop="headline">
                                            <a href="<?php the_permalink(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a>
                                        </h3>
                                        <time class="related-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished">
                                            <?php echo esc_html(get_the_date('M j, Y')); ?>
                                        </time>
                                    </article>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; 
                        wp_reset_postdata(); 
                        ?>
                    </div>
                    
                    <!-- Enhanced post navigation -->
                    <nav class="post-navigation" aria-label="<?php esc_attr_e('Post navigation', 'ukroa'); ?>">
                        <?php
                        the_post_navigation(array(
                            'prev_text' => '<span class="nav-subtitle">' . __('Previous:', 'ukroa') . '</span> <span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-subtitle">' . __('Next:', 'ukroa') . '</span> <span class="nav-title">%title</span>',
                            'screen_reader_text' => __('Post navigation', 'ukroa'),
                        ));
                        ?>
                    </nav>
                </article>
            <?php endwhile; endif; ?>
        </section>
        
        <aside class="sidebar" role="complementary" aria-label="<?php esc_attr_e('Sidebar', 'ukroa'); ?>">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</main>

<?php get_footer(); ?>