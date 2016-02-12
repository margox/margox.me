<?php 
/**
 * Margox.Me
 * @author Margox
 * @version 1.0
 * @link https://margox.me/gettheme/
 */

define('__THEME__', get_template_directory_uri() . '/');
define('__ASSETS__', __THEME__ . 'assets/');
define('__ROOT__', get_template_directory() . '/');
define('__REQUIRES__', __ROOT__ . 'requires/');

$content_width = 1110;

if (!function_exists('m_setup')) {

    function m_setup() {

        add_theme_support('automatic-feed-links');
        add_theme_support('post-formats', array('video', 'image', 'audio', 'gallery', 'quote'));
        add_theme_support('nav-menus');
        register_nav_menus(array(
             'primary-menu' => '主要导航菜单',
       ));
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1296, '', true);
        add_image_size('m-lg', 1296, '', true);
        add_image_size('m-md', 640, 480, true);
        add_image_size('m-sm', 300, 300, true);
        add_filter('use_default_gallery_style', '__return_false');
        add_filter('show_admin_bar', '__return_false');
        remove_action('init', '_wp_admin_bar_init');

    }

    add_action('after_setup_theme', 'm_setup');
 
}

//function m_enqueue_assets() {
//
//    wp_enqueue_script('jquery');
//    wp_enqueue_script('lightbox', __ASSETS__ . 'js/libs/lightbox.min.js', false, '2.7.1', true);
//
//}

//add_action('wp_enqueue_scripts', 'm_enqueue_assets');

function m_wp_title($title){

    if ($title) {
        return $title . get_bloginfo('name');
    } else {
        return get_bloginfo('name');
    }

}

function m_excerpt_more($more) {
    return "……";
}

function m_post_class($class) {

    $class[] = "m-post";

    if (!has_post_thumbnail() && get_post_format() == '') {
        $class[] = 'no-thumbnail';
    }

    return $class;

}

function custom_excerpt_length($length) {
    return 115;
}

add_filter('wp_title', 'm_wp_title');
add_filter('excerpt_more', 'm_excerpt_more');
add_filter('post_class', 'm_post_class');
add_filter('excerpt_length', 'custom_excerpt_length', 999);


function m_build_breadcrumb() {

    global $post;

    $home_url = home_url();

?>
<div class="blog-breadcrumb-wrapper">
    <ul class="breadcrumb c">
        <li>
            <a href="<?php echo $home_url; ?>"><i class="icon-home"></i> <?php bloginfo('name');?></a>
        </li>
<?php

    if (is_category()) {

        $cat = get_category(get_query_var('cat'), false);
        if ($cat->parent != 0) {
            echo '<li>' . get_category_parents($cat->parent, TRUE, ' | ') . '</li>';
        }
        echo '<li class="active">' . single_cat_title('', false) . '</li>';

    } elseif (is_search()) {

        echo '<li class="active">' . sprintf('关键字 : <b>%s</b>', get_search_query()) . '</li>';

    } elseif (is_day()) {

        echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
        echo '<li><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a></li>';
        echo '<li class="active">' . get_the_time('d') . '</li>';

    } elseif (is_month()) {

        echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
        echo '<li class="active">' . get_the_time('F') . '</li>';

    } elseif (is_year()) {

        echo '<li class="active">' . get_the_time('Y') . '</li>';

    } elseif (is_tag()) {

        echo '<li class="active">' . sprintf('标签 : %s', get_query_var('tag')) . '</li>';

    } elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        echo '<li class="active">' . sprintf('作者 : %s', $userdata->display_name) . '</li>';

    }

?>
    </ul>
<?php
global $wp_query;
?>
    <span class="post-count">共 <?php echo $wp_query->found_posts;?> 条记录</span>
</div>
<?php

}

function m_get_post_image($argus = array()) {

    $argus = array_merge(array(
        'postid' => null,
        'alt' => null,
        'class' => null,
        'size' => 'm-sm',
        'data-src' => false
  ), $argus);

    if (!is_numeric($argus['postid'])) {
        $argus['postid'] = get_the_ID();
        $alt = get_the_title();
    } else {
        $alt = $argus['alt'];
    }

    $attrs = array(
        'class' => 'post-thumbnail' . $argus['class']
  );
    !empty($alt) && $attrs['alt'] = $alt;

    if ($argus['data-src']) {
        $img_id = get_post_thumbnail_id($argus['postid']);
        $data_rc = wp_get_attachment_image_src($img_id, $argus['data-src']);
        $attrs['data-src'] = $data_rc[0];
        $attrs['class'] .= ' single-lightbox';
    }

    return get_the_post_thumbnail($argus['postid'], $argus['size'], $attrs);

}

function m_get_post_gallery($postid = null) {

    !is_numeric($postid) && $postid = get_the_ID();
    $gallery = get_post_meta($postid, 'm_meta_gallery', true);
    $images = $gallery['images'];

    if (is_array($images['urls']) && count($images['urls']) > 0) {

        $html = '<ul class="post-gallery c" id="post-gallery-' . $postid . '">';
        $n = 0;

        foreach ($images['urls'] as $urls) {

            $image_a = explode("|", $urls);
            $image_id = $image_a[2];
            $image_url = wp_get_attachment_image_src($image_id, 'm-lg');
            $image_url = $image_url[0];
            $image_caption = get_the_title($image_id);
            empty($image_url) && $image_url = $image_a[1];

            if (!empty($image_url)) {
                $html .= '
                <li>
                    <a href="' . $image_url . '" data-lightbox="m-post-gallery-' . $postid . '">
                        <img src="' .$image_a[0] . '">
                    </a>
                </li>
                ';
            }

        }

        $html .= '
        </ul>
        ';
        return $html;

    }

    return false;

}

function m_get_post_metas($post = null) {

    !is_object($post) && $post = get_post();

    $post_link  = get_permalink($post->ID);
    $post_title = get_the_title($post->ID);

    $liked = get_post_meta($post->ID, 'liked', true);
    $liked = is_numeric($liked) ? $liked : 0;
    $post_title = urlencode($post_title);
    $post_link = urlencode($post_link);

?>
                <div class="post-footer">
                    <div class="post-cats">
                        <?php the_category(' / ', 'single');?>
                    </div>
                    <!--<div class="post-tags">
                        <?php //the_tags('<span> | </span>', '<span> ,</span>', '');?>
                    </div>-->
                    <div class="post-metas">
                        <span class="post-date" title="<?php the_time(get_option('date_format'));?>"><?php echo format_date(get_the_time("Y-m-d H:i:s"));?></span>
                        <a href="<?php the_permalink();?>#comments" class="post-comments-icon"><i class="icon-bubble2"></i> <?php echo $post->comment_count;?></a>
                        <!--<a href="javascript:void(0);" data-id="<?php the_ID();?>" class="post-like-btn<?php echo isset($_COOKIE['m_liked_post_' . $post->ID ]) ? ' liked' : '';?>"><i class="icon-heart"></i> <?php echo m_get_liked($post->ID);?></a>
                        <a href="javascript:void(0);" data-url="<?php echo $post_title;?>" data-text="<?php echo $post_link;?>" class="post-share-btn"><i class="icon-send-o"></i></a>-->
                    </div>
                </div>
<?php
}

function format_date ($timeInt, $format='Y年m月d日') {

    $timeInt = strtotime($timeInt);

    if ($timeInt === 0) {
        return '';
    }

    $d = time() - $timeInt + 28800;

    if ($d < 0) {
        return '';
    } else {
        if ($d < 60) {
            return $d . '秒前';
        } else {
            if ($d < 3600) {
                return floor($d / 60) . '分钟前';
            } else {
                if ($d < 86400) {
                    return floor($d / 3600) . '小时前';
                } else {
                    if ($d < 2592000) {//3天内
                        return floor($d / 86400) . '天前';
                    } else { 
                        return date($format , $timeInt);
                    }
                }
            }
        }
    }

}

function m_get_post_quote($postid = null) {

    !is_numeric($postid) && $postid = get_the_ID();
    $content = get_the_content($postid);

    if (empty($content)) {
        $content = get_the_title($postid);
    }

    $author = get_post_meta($postid, 'm_meta_quote', true);
    $quote['content'] = $content;
    $quote['author'] = $author;

    return $quote;
}

function m_get_post_audio($postid = null) {

    !is_numeric($postid) && $postid = get_the_ID();
    $audio = get_post_meta($postid, 'm_meta_audio', true);

    //if (stripos($audio, 'soundcloud') !== false) {
    //    $return['oembed'] = true;
    //    $return['url'] = $audio;
    //    $return['html'] = wp_oembed_get($audio, array(
    //         'height' => 200
    //  ));
    //} elseif (stripos($audio, 'mixcloud') !== false) {
    //    $return['oembed'] = true;
    //    $return['url'] = $audio;
    //    $return['html'] = '<iframe class="mixcloud-iframe" width="100%" src="//www.mixcloud.com/widget/iframe/?embed_type=widget_standard&hide_tracklist=1&hide_cover=1&feed=' . urlencode($audio) . '"></iframe>';
    //} elseif (stripos($audio, '<iframe') !== false || stripos($audio, '<embed') !== false) {
    //    $return['oembed'] = true;
    //    $return['html'] = $audio;
    //} else {
        $return['oembed'] = false;
        $return['url'] = $audio;
    //}

    return $return;

}

// Get Post Video
function m_get_post_video($postid = null) {

    !is_numeric($postid) && $postid = get_the_ID();
    $video = get_post_meta($postid, 'm_meta_video', true);

    if (strpos($video, '<') !== false && strpos($video, '>') !== false) {

        $return['embeded'] = true;
        $return['html'] = '<div class="m-video-wrapper">' . $video . '</div>';

    } else {

        $video_html = wp_oembed_get($video);

        if ($video_html) {

            $return['oembed'] = true;
            $return['html'] = '<div class="m-video-wrapper">' . $video_html . '</div>';

        } else {
            $return['url'] = $video;
        }

    }

    return $return;

}

function m_get_liked($id = null) {

    is_null($id) && $id = get_the_id();

    $liked = get_post_meta($id, 'liked', true);
    $liked = is_numeric($liked) ? $liked : 0;

    return $liked;

}

function m_get_qrcode($url) {

    if (is_null($url)) {
        return false;
    }

    return 'http://api.qrserver.com/v1/create-qr-code/?color=222222&bgcolor=FFFFFF&qzone=1&margin=0&size=400x400&ecc=L&data=' . $url;

}

// MetaBoxes Array
$m_metaboxes = array(
    'audio' => array(
        array(
            'name' => 'audio',
            'title' => '音频',
            'placeholder' => '粘贴音频文件地址，或从库中选择',
            'type' => 'audio',
            'html' => true
        )
    ),
    'video' => array(
        array(
            'name' => 'video',
            'title' => '视频',
            'placeholder' => '粘贴视频文件地址，或从库中选择',
            'type' => 'video',
            'html' => true
        )
    ),
    // 'quote' => array(
    //     array(
    //         'name' => 'quote',
    //         'title' => '引用段落',
    //         'placeholder' => '填写作者',
    //         'type' => 'text',
    //         'html' => false
    //     )
    // ),
    'gallery' => array(
        array(
            'name' => 'gallery',
            'title' => '选择需要加入相册的图片',
            'placeholder' => '',
            'type' => 'mulitmedia',
            'html' => true
        )
    )
);


// Add MetaBoxes
function m_add_metaboxes() {

    global $m_metaboxes;

    $screens = array(
        'post',
    );

    foreach ($m_metaboxes as $key => $fields) {
        foreach ($screens as $screen) {
            foreach ($fields as $field) {
                add_meta_box('m_format_' . $field['name'], $field['title'], 'm_create_metaboxes', $screen, 'advanced', 'default', array(
                    $key
              ));
            }
        }
    }

    if (in_array(m_current_screen(), array('post'))) {
        wp_enqueue_script('m-post-format-js', __ASSETS__ . 'js/admin-post-format.js');
        wp_enqueue_style('m-post-format-css', __ASSETS__ . 'css/admin-post-format.css');
    }

}

// Get Current Screen
function m_current_screen() {

    $screen = get_current_screen();
    return $screen->id;

}

// Create Metaboxes
function m_create_metaboxes($post, $args) {

    global $m_metaboxes;

    $m_metabox = $m_metaboxes[$args['args'][0]];

    foreach ($m_metabox as $m_meta) {

        $meta_value = get_post_meta($post->ID, 'm_meta_' . $m_meta['name'], true);

        if (!$m_meta['html']) {
            $meta_value = esc_attr($meta_value);
        }

        switch ($m_meta['type']) {
            case 'text':
                echo '<input type="text" placeholder="' . $m_meta['placeholder'] . '" class="m-text m-long-text m_meta_' . $args['args'][ 0 ] . '" name="m_meta_' . $m_meta['name'] . '" value="' . $meta_value . '" />';
                break;
            case 'textarea':
                echo '<textarea placeholder="' . $m_meta['placeholder'] . '" class="m-textarea m_meta_' . $args['args'][ 0 ] . '" name="m_meta_' . $m_meta['name'] . '">' . $meta_value . '</textarea>';
                break;
            case 'audio':
                echo '<textarea placeholder="' . $m_meta['placeholder'] . '" class="m-textarea m_meta_' . $args['args'][ 0 ] . '" id="m_meta_audio" name="m_meta_' . $m_meta['name'] . '">' . $meta_value . '</textarea><a class="button" id="m_add_audio">添加音频</a>';
                break;
            case 'video':
                echo '<textarea placeholder="' . $m_meta['placeholder'] . '" class="m-textarea m_meta_' . $args['args'][ 0 ] . '" id="m_meta_video" name="m_meta_' . $m_meta['name'] . '">' . $meta_value . '</textarea><a class="button" id="m_add_video">添加视频</a>';
                break;
            case 'mulitmedia':

                $checked[ $type ] = 'checked';
                echo '<div class="m-meta-gallery m-meta-gallery-' . $type . '">';
                echo '<div class="m-meta-gallery-wrapper">';
                $images = isset($meta_value['images']) ? $meta_value['images'] : null;

                if (is_array($images)) {
                    $n = 0;

                    foreach ($images['urls'] as $value) {

                        $thumbnail = explode("|", $value);
                        echo '<div class="m-meta-gallery-item">';
                        echo '<img src="' . $thumbnail[ 0 ] . '" width="100px" height="100px">';
                        echo '<input type="hidden" class="m-meta-gallery-fields" name="m_meta_' . $m_meta['name'] . '[images][urls][]" value="' . $value . '">';
                        echo '<select class="m-meta-gallery-size" name="m_meta_' . $m_meta['name'] . '[images][size][]">';
                        $size[1] = $size[2] = $size[3] = $size[4] = '';
                        $size[$images['size'][$n]] = 'selected';
                        echo '<option value="1" ' . $size[1] . '>Size 1</option>';
                        echo '<option value="2" ' . $size[2] . '>Size 2</option>';
                        echo '</select>';
                        echo '</div>';
                        $n++;

                    }

                }
                echo '</div><a href="javascript:void(0);" class="m-meta-gallery-add" data-name="' . $m_meta['name'] . '">+</a></div>';
                break;

        }
    }

}

// Save/Update Meta Values
function m_save_metas($post_id) {

    global $m_metaboxes;

    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    foreach ($m_metaboxes as $fields) {

        foreach ($fields as $field) {

            if (isset($_POST['m_meta_' . $field['name'] ])) {
                $new_meta_data = $field['html'] ? $_POST['m_meta_' . $field['name'] ] : sanitize_text_field($_POST['m_meta_' . $field['name'] ]);
                update_post_meta($post_id, 'm_meta_' . $field['name'], $new_meta_data);
            }

        }

    }

    $m_meta_sidebar = isset($_POST['m_meta_sidebar']) ? $_POST['m_meta_sidebar'] : '';
    update_post_meta($post_id, 'm_meta_sidebar', $m_meta_sidebar);
    isset($_POST['m_meta_thumbnail']) && update_post_meta($post_id, 'm_meta_thumbnail', $_POST['m_meta_thumbnail']);
    isset($_POST['m_meta_sections']) && update_post_meta($post_id, 'm_meta_sections', $_POST['m_meta_sections']);

    $m_meta_advertisement = isset($_POST['m_meta_advertisement']) ? $_POST['m_meta_advertisement'] : '0';
    update_post_meta($post_id, 'm_meta_advertisement', $m_meta_advertisement);

}

add_action('add_meta_boxes', 'm_add_metaboxes');
add_action('save_post', 'm_save_metas');

// Editor Buttons

function m_editor_buttons($buttons) {
    $buttons[] = 'fontselect';
    $buttons[] = 'fontsizeselect';
    $buttons[] = 'backcolor';
    $buttons[] = 'hr';
    $buttons[] = 'sub';
    $buttons[] = 'sup';
    $buttons[] = 'cut';
    $buttons[] = 'copy';
    $buttons[] = 'paste';
    $buttons[] = 'cleanup';
    $buttons[] = 'newdocument';
    $buttons[] = 'pagebreak';
    return $buttons;
}

add_filter("mce_buttons_3", "m_editor_buttons");

function m_like_post($id) {

    if (is_numeric($id) && !isset($_COOKIE['m_liked_post_' . $id ])) {
        $liked = get_post_meta($id, 'liked', true);
        $liked = $liked ? $liked : 0;
        update_post_meta($id, 'liked', $liked + 1);
        setcookie('m_liked_post_' . $id, 1);
        return $liked + 1;
    } else {
        return 0;
    }

}

if (isset($_REQUEST['ajax_like']) && $_REQUEST['ajax_like'] == 1 && isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    echo m_like_post($_REQUEST['id']);
    exit;
}

?>