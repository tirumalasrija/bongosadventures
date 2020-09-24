<style>
	.lock_div_over ~ .lock{
	text-align: center;
position: absolute;
top: 20%;
z-index: 5;
transform: translate(-50%, -50%);
left: 50%;
}
.page-wrap{
	position: relative;
}
	.page-wrap .comments .lock{
		position: absolute;
z-index: 99;
left: 50%;
top: 20%;
transform: translateX(-50%);
	}
	.comments, .comment-respond{ position: relative;}
	</style>
<?php



use BongosBooks\Lessons\PostTypes\Character;

if (post_password_required()) {
    return;
}
$has_comments = have_comments();
$closed_discussion = !comments_open() && post_type_supports(get_post_type(), 'comments');

global $post;
$a='';
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
	
    <?php  if ((comments_open() || $closed_discussion)): ?>
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
				$a= 'Chat with '.$character;
            } else {
                comment_form(array('title_reply' => 'Talk about ' . $post->post_title));
				$a= 'Talk about '.$post->post_title;
            }

            ?>
        </section>
    <?php  endif; ?>
	
	<?php  $has_sub1 = wcs_user_has_subscription( get_current_user_id(), 389, 'active' );  
			$has_sub2 = wcs_user_has_subscription( get_current_user_id(), 361, 'active' );  
	
	?>
	 <?php if (empty($has_sub1)&&empty($has_sub2)  ) { ?>
	
	<style>
		#commentform{
			filter: blur(5px);
			pointer-events: none;
		}
	</style>
	<script>
	jQuery(".comments").click(function(){
		
		 modal.style.display = "block";
	document.body.style.overflow = "hidden"; 
	 
	//window.location.href ='http://universitiesconnect.com/shop';
	
});
			
	</script>
	<?php } ?>
	
	<?php if ( !is_user_logged_in() ) { 
	$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);


	?>
	<script>
		var a="<?php echo $a; ?>";
			
		content='<div class="lock"><img src="https://bongosbooks.com/wp-content/themes/bongosbooks/dist/images/utility-icons/lock.png"></div><div id="respond" class="comment-respond">	<h3 id="reply-title" class="comment-reply-title">'+a+' <small><a rel="nofollow" id="cancel-comment-reply-link" href="/character/bella/#respond" style="display:none;">Cancel reply</a></small></h3>			<form action="" method="post" id="commentform" class="comment-form" novalidate=""><p class="logged-in-as"><a href="" aria-label="Logged in as Shilpa Patel. Edit your profile.">Logged in as Shilpa Patel</a>. <a href="">Log out?</a></p><p class="comment-form-comment"><label for="comment">Comment</label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p><p class="form-submit"><input name="submit" id="submit" class="submit" value="Post Comment" type="submit"> <input name="comment_post_ID" value="312" id="comment_post_ID" type="hidden"><input name="comment_parent" id="comment_parent" value="0" type="hidden"></p><p style="display: none;"><input id="akismet_comment_nonce" name="akismet_comment_nonce" value="d0205d9ef5" type="hidden"></p><input id="_wp_unfiltered_html_comment_disabled" name="_wp_unfiltered_html_comment" value="796a74df41" type="hidden"><p style="display: none;"></p>			<input id="ak_js" name="ak_js" type="hidden"><input name="js-spam-prevention" value="f25e147e52cb7d6f4b7be5caf91b38b1" type="hidden"></form></div><div class="lock_div_over"></div>';
		
	jQuery(".comments").html(content);
		
	</script>
	<?php }else if (empty($has_sub1)&&empty($has_sub2)  )  { ?>
	<script>
	jQuery( ".comment-respond" ).prepend(function() {
  return '<div class="lock_div_over"></div><div class="lock"><img src="https://bongosbooks.com/wp-content/themes/bongosbooks/dist/images/utility-icons/lock.png"></div>';
});
	</script>
	<?php } ?>
<script>
	jQuery(".post .comments").html('');
	</script>