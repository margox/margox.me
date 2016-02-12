<?php get_header();?>
<div class="blog-container">
    <div class="post-list single-post">
<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part('content/content', get_post_format());
    }
    wp_reset_query();
} else {
    get_template_part('content/content', '404');
}
?>
<?php
if (comments_open() || get_comments_number()) {
?>
        <div class="post-comments-wrap">
		    <?php comments_template();?>
        </div>
<?php
}
?>
    </div>
</div>
<?php get_footer();?>