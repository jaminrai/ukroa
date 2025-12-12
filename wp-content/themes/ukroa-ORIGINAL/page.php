<?php get_header(); ?>

<!-- Breadcrumb Section -->
<section class="breadcrumb-section">
    <div class="breadcrumb-container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?php echo esc_url(home_url('/')); ?>">
                        <span itemprop="name"><?php _e('Home', 'ukroa'); ?></span>
                    </a>
                    <meta itemprop="position" content="1" />
                </li>
                <?php if (is_page() && $post->post_parent) : ?>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="<?php echo esc_url(get_permalink($post->post_parent)); ?>">
                            <span itemprop="name"><?php echo get_the_title($post->post_parent); ?></span>
                        </a>
                        <meta itemprop="position" content="2" />
                    </li>
                <?php endif; ?>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
                    <span itemprop="name"><?php the_title(); ?></span>
                    <meta itemprop="position" content="<?php echo ($post->post_parent) ? '3' : '2'; ?>" />
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content with Sidebar -->
<div class="content-sidebar-wrapper">
    <main role="main" class="main-content">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
                <header class="page-header">
                    <h1><?php the_title(); ?></h1>
                    <?php if (!is_front_page()) : ?>
                        <div class="page-meta">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </div>
                    <?php endif; ?>
                </header>
                
                <div class="page-content-inner">
                    <?php the_content(); ?>
                </div>
                
                <?php
                // Page links for paginated posts
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . __('Pages:', 'ukroa'),
                    'after'  => '</div>',
                ));
                ?>
                
                <?php if (comments_open() || get_comments_number()) : ?>
                    <section class="page-comments">
                        <?php comments_template(); ?>
                    </section>
                <?php endif; ?>
            </article>
        <?php endwhile; endif; ?>
    </main>

    <aside class="sidebar-wrapper" role="complementary" aria-label="<?php esc_attr_e('Page Sidebar', 'ukroa'); ?>">
        <?php get_sidebar(); ?>
    </aside>
</div>

<?php get_footer(); ?>