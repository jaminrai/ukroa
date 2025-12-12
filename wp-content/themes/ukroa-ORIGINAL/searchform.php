<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <input type="text" placeholder="<?php esc_attr_e('Search...', 'ukroa'); ?>" value="<?php echo get_search_query(); ?>" name="s" aria-label="<?php esc_attr_e('Site Search', 'ukroa'); ?>">
    <button type="submit" aria-label="<?php esc_attr_e('Submit Search', 'ukroa'); ?>"><i class="fas fa-search"></i></button>
</form>