<?php
if (post_password_required()) return;
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2><?php printf(_n('One thought on "%2$s"', '%1$s thoughts on "%2$s"', get_comments_number(), 'ukroa'), number_format_i18n(get_comments_number()), get_the_title()); ?></h2>
        <ol class="comment-list">
            <?php wp_list_comments(array('style' => 'ol', 'short_ping' => true, 'avatar_size' => 56)); ?>
        </ol>
        <?php the_comments_pagination(); ?>
    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p><?php _e('Comments are closed.', 'ukroa'); ?></p>
    <?php endif; ?>

    <?php comment_form(array(
        'title_reply' => __('Leave a Comment', 'ukroa'),
        'comment_notes_after' => '',
    )); ?>
</div>