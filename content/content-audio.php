        <article id="post-<?php the_ID();?>" <?php post_class( 'post' );?>>
            <div class="post-type-icon"><i class="icon-music"></i></div>
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
            <div class="post-content markdown-body"><?php the_content();?></div>
<?php   
                }
} else {
?>
            <div class="post-quote">
                <a href="<?php the_permalink();?>"><?php the_title();?></a>
            </div>
<?php
}
$post_audio = m_get_post_audio( $post->ID );
if ( $post_audio['url'] ) {
    $post_audio = explode( '|', $post_audio['url'] );
?>
            <div class="post-attachments">
                <div class="post-audio" id="post-audio-<?php echo $post->ID;?>">
                    <audio class="post-audio-core" id="post-audio-core-<?php echo $post->ID;?>" src="<?php echo $post_audio[0];?>"></audio>
                    <div class="cover">
                        <a href="javascript:void(0);" class="btn-play-pause" data-id="<?php echo $post->ID;?>">
                            <i class="icon-play"></i>
                            <i class="icon-pause"></i>
                        </a>
<?php
    if ( has_post_thumbnail() ) {
?>
                        <?php echo m_get_post_image(array('size' => 'm-md'));?>
<?php
    }
?>
                    </div>
                    <h5 class="caption"><?php echo $post_audio[1] ? $post_audio[1] : '未知名称';?></h5>
                    <h6 class="sub-caption"><?php echo $post_audio[2] ? $post_audio[2] : '未知歌手';?> / <?php echo $post_audio[3] ? $post_audio[3] : '未知专辑';?></h6>
                    <div class="progress">
                        <span class="played-time">00:00</span>
                        <span class="progress-bar"></span>
                        <span class="total-time">00:00</span>
                    </div>
                </div>
            </div>
<?php
}
?>
            <?php m_get_post_metas( $post );?>
        </article>
