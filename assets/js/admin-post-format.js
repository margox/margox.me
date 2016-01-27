jQuery(document).ready(function($){

    /*change meta box when post format has been changed*/

    var _m_post_formats = $("#post-formats-select").find("input[name=post_format]");
    var _m_post_format = $("#post-formats-select").find("input:checked")[0].id.replace("post-format-","");

    var _change_meta_box = function(id){

        $("#m_format_video").hide();
        $("#m_format_audio").hide();
        $("#m_format_quote").hide();
        $("#m_format_status").hide();
        $("#m_format_gallery").hide();
        $("#m_format_" + id).length && $("#m_format_" + id).show();

    }

    _change_meta_box(_m_post_format);
    _m_post_formats.change(function() {
        _m_post_format = this.id.replace("post-format-","");
        _change_meta_box(_m_post_format);
    });

    $("#m_add_audio").click(function() {
        var custom_uploader = wp.media({
            title: 'Select Audio',
            library: {
                type: 'audio'
            },
            button: {
                text: 'Select'
            },
            multiple: false
        }).on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $("#m_meta_audio").val(attachment.url);
        }).open();

    });

    $("#m_add_video").click(function() {

        var custom_uploader = wp.media({
            title: 'Select Video',
            library: {
                type: 'video'
            },
            button: {
                text: 'Select'
            },
            multiple: false
        }).on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $("#m_meta_video").val(attachment.url);
        }).open();

    });

    $(".m-meta-gallery").find(".m-meta-gallery-add").click(function() {

        var gallerys = $(this).prev('.m-meta-gallery-wrapper');
        var name = $(this).data('name');
        var custom_uploader = wp.media({
            title: 'Select Images',
            library: {
                type: 'image'
            },
            button: {
                text: '添加图片'
            },
            multiple: true
        }).on('select', function() {

            var selection = custom_uploader.state().get('selection');
            selection.each(function(attachment) {

                var html = '<div class="m-meta-gallery-item">';
                var m_thumbnail = attachment.attributes.sizes.thumbnail;

                if (typeof(m_thumbnail) == 'undefined') {
                    m_thumbnail = attachment.attributes;
                }

                html += '<img src="' + m_thumbnail.url + '" width="100px" height="100px"/>';
                html += '<input type="hidden" class="m_meta_gallery_fields" name="m_meta_' + name + '[images][urls][]" value="' + m_thumbnail.url + '|' + attachment.attributes.url + '|' + attachment.id + '" />';
                html += '</div>';
                $(html).on("click",function() {
                    m_gallery_delete(this);
                });
                $(html).appendTo(gallerys);

            });

        }).open();

    });

    $(".m-meta-gallery").on("click",'.m-meta-gallery-item img',function() {
        m_gallery_delete($(this).parent());
    });

    function m_gallery_delete(obj) {
        $(obj).remove();
    }

});