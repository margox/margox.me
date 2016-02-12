<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
<meta charset="UTF-8">
<title><?php wp_title('|', true, 'right'); ?></title>
<meta name="description" content="<?php
$blog_description = get_bloginfo('description');
if ($blog_description && (is_home() || is_front_page())) {
    echo $blog_description;
} else {
    wp_title();
}
?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url');?>">
<link rel="shortcut icon" href="<?php echo __ASSETS__;?>images/favicon.png">
<link rel="stylesheet" href="<?php echo __ASSETS__;?>css/styles.css">
<?php //wp_head(); ?>
</head>
<body>
    <header class="blog-header">
        <a href="<?php echo home_url();?>" class="logo">
            <img src="<?php echo __ASSETS__;?>images/logo.png" alt="">
        </a>
        <div class="searcher">
            <form action="<?php echo home_url();?>" method="get">
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
            $menu_HTML = wp_nav_menu($menu_parameters);
            echo $menu_HTML;
            ?>
        </ul>
    </header>
    <header class="blog-header-mobile">
        <a href="javascript:void(0);" class="btn-toggle-mobile-menu">
            <i></i>
        </a>
        <a href="javascript:void(0);" class="btn-toggle-mobile-searcher"><i class="icon-search"></i></a>
        <h5 class="title">Margox.Me</h5>
        <ul class="menu">
            <?php
            $menu_parameters = array(
                'theme_location' => 'primary-menu',
                'container' => false,
                'items_wrap' => '%3$s',
                'depth' => 0,
                'echo' => false,
           );
            $menu_HTML = wp_nav_menu($menu_parameters);
            echo str_replace('id="', 'id="mobile-', $menu_HTML);
            ?>
        </ul>
        <div class="searcher">
            <form action="<?php echo home_url();?>" method="get">
                <input type="text" name="s" placeholder="输入关键字">
            </form>
        </div>
    </header>
