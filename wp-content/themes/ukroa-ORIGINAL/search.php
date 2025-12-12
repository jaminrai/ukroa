```php
<?php
/**
 * The template for displaying search results pages
 *
 * @package ukroa
 */
get_header(); ?>

<div class="content-sidebar-wrapper">
    <main class="main-content archive-container" role="main">
        <header class="archive-header">
            <h1 class="archive-title"><?php printf(esc_html__('Search Results for: %s', 'ukroa'), '<span>' . esc_html(get_search_query()) . '</span>'); ?></h1>
        </header>

        <?php if (have_posts()) : ?>
            <div class="post-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                        <div class="post-thumbnail">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', ['class' => 'post-image', 'alt' => get_the_title()]); ?>
                                </a>
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                                <?php
                                $tags = get_the_tags();
                                if ($tags) :
                                    $first_tag = $tags[0];
                                ?>
                                    <span class="post-tag"><?php echo esc_html($first_tag->name); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="post-content">
                            <h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                            <div class="post-meta">
                                <span class="meta-item post-author"><?php echo esc_html__('By', 'ukroa') . ' ' . get_the_author(); ?></span>
                                <span class="meta-item"><?php echo get_the_date(); ?></span>
                            </div>
                            <div class="post-excerpt"><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More', 'ukroa'); ?></a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <div class="pagination">
                <?php
                the_posts_pagination([
                    'prev_text' => esc_html__('Previous', 'ukroa'),
                    'next_text' => esc_html__('Next', 'ukroa'),
                    'mid_size'  => 2,
                    'screen_reader_text' => esc_html__('Posts navigation', 'ukroa'),
                ]);
                ?>
            </div>
        <?php else : ?>
            <p class="no-posts"><?php esc_html_e('No results found.', 'ukroa'); ?></p>
        <?php endif; ?>
    </main>

    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
```