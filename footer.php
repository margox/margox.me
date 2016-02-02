<footer class="blog-footer">
    <strong class="copyright">&copy; 2016 MARGOX.ME</strong>
    <span>Powered by WordPress / Designed by Margox.</span>
</footer>
<script src="<?php echo __ASSETS__;?>js/libs/jquery.js"></script>
<script src="<?php echo __ASSETS__;?>js/libs/lightbox.min.js"></script>
<script>
~function() {
    $('[data-lightbox]').Lightbox();
    $('[data-src]').Lightbox({
        srcAttr : 'data-src',
        single : true
    });
}();
</script>
<?php wp_footer(); ?>
</body>
</html>