<?php get_header();?>
<?php
if ( !is_home() && !is_front_page() && !is_singular() && have_posts() ){
    m_build_breadcrumb();
}
$have_posts = false;
?>
<div class="blog-container">
    <div class="post-list">
    <?php
    if ( have_posts() ) {
        $have_posts = true;
        while ( have_posts() ) {
            the_post();
            get_template_part( 'content/content', get_post_format() );
        }
        wp_reset_query();
    } else {
        get_template_part( 'content/content', '404' );
    }
    ?>
    </div>
</div>
<?php 
if ($have_posts) {
?>
<div class="post-pagers">
    <?php
    global $wp_query;
    $big = 99999999;
    echo paginate_links(array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var( 'paged' ) ),
        'total' => $wp_query->max_num_pages,
        'prev_next' => false
     ));
    ?>
</div>
<?php
}
?>
<?php get_footer();?>