<?php

use BongosBooks\Lessons\PostTypes\Character;

if (post_password_required()) {
    return;
}
$has_comments = have_comments();
$closed_discussion = !comments_open() && post_type_supports(get_post_type(), 'comments');

global $post;
$character = $post->post_title;

$fields = array(
    'author',
);

function format_comment($comment)
{
    $current_page = get_post();

    // Check for character post link
    $character_meta_name = get_post_meta(get_the_ID(), '_bongos_books_lesson_metabox_character_link', true);

    // Check if the comment author is an adminstrator
    $author_is_admin = user_can($comment->user_id, 'administrator');

    // Default comment author and avatar
    $avatar_override = false;
    $comment_author_override = false;

    // If this is a character page and the comment author is an admin
    if (Character::is_a_character() && $author_is_admin) {
        $comment_author_override = $current_page->post_title;
        $character_image_id = get_post_meta($current_page->ID, '_bongosbooks_character_character_image', true);
        $avatar_override = wp_get_attachment_image($character_image_id, 'thumbnail');
    // If this is a lesson (or any post with a character link) and the comment author is an admin
    } elseif ($character_meta_name && $author_is_admin) {
        $character_page = get_post($character_meta_name);
        $comment_author_override = $character_page->post_title;
        $character_image_id = get_post_meta($character_page->ID, '_bongosbooks_character_character_image', true);
        $avatar_override = wp_get_attachment_image($character_image_id, 'thumbnail');
    }

?>
<div class="comment<?php if ($comment->comment_parent) echo ' nested' ?>">
    <div class="comment-wrap">
        <div class="comment-image">
            <?= $avatar_override ? $avatar_override : get_avatar($comment, 64); ?>
        </div>
        <div class="comment-content">
            <h4 class="comment-title">Posted by <?= $comment_author_override ? $comment_author_override : comment_author(); ?></h4>
            <?php comment_text(); ?>
            <p class="comment-detail">Posted on <?php comment_date(); ?> at <?php comment_time(); ?></p>
        </div>
    </div>
    <?php } ?>
    <?php if (comments_open() || $closed_discussion): ?>
        <section class="comments">
            <?php if ($has_comments) : ?>
                <?php wp_list_comments(['style' => 'div', 'short_ping' => true, 'callback' => 'format_comment']); ?>

                <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
                    <nav>
                        <ul class="pager">
                            <?php if (get_previous_comments_link()) : ?>
                                <li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'tmbase')); ?></li>
                            <?php endif; ?>
                            <?php if (get_next_comments_link()) : ?>
                                <li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'tmbase')); ?></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; // have_comments() ?>

            <?php if ($closed_discussion) : ?>
                <div class="flash-notice comments-closed">
                    <?php _e('Comments are closed.', 'tmbase'); ?>
                </div>
            <?php endif;

            if (Character::is_a_character()) {
                comment_form(array('title_reply' => 'Chat with ' . $character));
            } else {
                comment_form(array('title_reply' => 'Talk about ' . $post->post_title));
            }

            ?>
        </section>
    <?php endif; ?>
