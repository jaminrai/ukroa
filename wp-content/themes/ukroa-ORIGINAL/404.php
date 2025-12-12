<?php get_header(); ?>

<main role="main">
    <h1><?php _e('Page Not Found', 'ukroa'); ?></h1>
    <p><?php _e('Sorry, the page you are looking for does not exist.', 'ukroa'); ?></p>
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="search" placeholder="<?php esc_attr_e('Search...', 'ukroa'); ?>" name="s">
        <button type="submit"><?php _e('Search', 'ukroa'); ?></button>
    </form>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>