        <article id="post-<?php the_ID();?>" <?php post_class( 'post' );?>>
            <div class="post-type-icon"><i class="icon-image"></i></div>
            <h3 class="post-title">
                <a href="<?php the_permalink();?>"><?php the_title();?></a>
            </h3>
<?php
if ( has_post_thumbnail() ) {
?>
            <div class="post-attachments">
                <a href="<?php the_permalink();?>" class="post-image">
<?php
    if ( is_singular() ) {
?>
                    <?php echo m_get_post_image(array('size' => 'm-md', 'data-src' => 'm-lg'));?>
<?php
    } else {
?>
                    <?php echo m_get_post_image(array('size' => 'm-md'));?>
<?php        
    }
?>
                    
                </a>
            </div>
<?php
}
?>
            <?php m_get_post_metas( $post );?>
        </article>
