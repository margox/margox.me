        <div <?php post_class( 'post post-404' );?>>
            <i class="icon-404 icon-times-circle"></i>
<?php
if (is_search()) {
?>
            <h6 class="tip-404 search-404">你这都是搜的什么玩意儿？ <b><?php echo get_search_query();?></b>是个什么鬼？</h6>
<?php
} elseif (is_category()) {
?>
            <h6 class="tip-404 cat-404">此处没有你要找的东西，快走吧！</h6>
<?php
} else {
?>
            <h6 class="tip-404">啥也没有，快走吧！</h6>
<?php
}
?>
            <a href="javascript:history.go(-1);" class="btn-go-back">返回</a>
        </div>
