        <article id="post-<?php the_ID();?>" <?php post_class( 'post' );?>>
                <div class="post-type-icon"><i class="icon-images"></i></div>
<?php  
if (get_the_content()) {
?>
                <h3 class="post-title">
                    <a href="<?php the_permalink();?>"><?php the_title();?></a>
                </h3>
<?php
    if (!is_singular()) {
?>
                <div class="post-excerpt"><?php the_excerpt();?></div>
<?php
    } else {
?>
                <div class="post-content"><?php the_content();?></div>
<?php   
    }
} else {
?>
                <div class="post-quote">
                    <a href="<?php the_permalink();?>"><?php the_title();?></a>
                </div>
<?php
}
?>
            <div class="post-attachments">
                <?php echo m_get_post_gallery( $post->ID );?>
            </div>
            <?php m_get_post_metas( $post );?>
        </article>
