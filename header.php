<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
<meta charset="UTF-8">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<meta name="description" content="<?php
$blog_description = get_bloginfo( 'description' );
if ( $blog_description && ( is_home() || is_front_page() ) ) {
    echo $blog_description;
} else {
    wp_title();
}
?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' );?>">
<link rel="shortcut icon" href="<?php echo __ASSETS__;?>images/favicon.png">
<link rel="stylesheet" href="<?php echo __ASSETS__;?>css/styles.css">
<?php wp_head(); ?>
</head>
<body>
    <header class="blog-header">
        <a class="logo">
            <img src="<?php echo __ASSETS__;?>images/logo.png" alt="">
        </a>
        <div class="searcher">
            <form action="<?php echo home_url();?>" method="post">
                <input type="text" name="s">
                <span class="btn-toggle-search"><i class="icon-search"></i></span>
            </form>
        </div>
        <ul class="menu">
            <?php
            $menu_parameters = array(
                'theme_location' => 'primary-menu',
                'container' => false,
                'items_wrap' => '%3$s',
                'depth' => 0,
                'echo' => false,
            );
            $menu_HTML = wp_nav_menu( $menu_parameters );
            echo $menu_HTML;
            ?>
        </ul>
    </header>
