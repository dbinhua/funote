$("#cover_file").on('change',function(){
    var objUrl = getObjectURL(this.files[0]);
    if (objUrl) {
        $("#cover_img").attr("src", objUrl);
    }
});

$('#article_form').form({
    inline: true,
    on: 'blur',
    fields: {
        title: {
            rules: [
                {
                    type: 'empty',
                    prompt: '文章标题不能为空'
                }
            ]
        },
        slug: {
            rules: [
                {
                    type: 'empty',
                    prompt: '别名不能为空'
                },
                {
                    type: 'regExp[/^[a-z0-9_-]*$/]',
                    prompt: '别名只能包含数字、字母和"-"、"_"'
                }
            ]
        },
        attr: {
            rules: [
                {
                    type: 'empty',
                    prompt: '文章属性不能为空'
                }
            ]
        },
        cate_id: {
            rules: [
                {
                    type: 'empty',
                    prompt: '文章分类不能为空'
                }
            ]
        },
        intro: {
            rules: [
                {
                    type: 'maxLength[75]',
                    prompt: '简介不得多于75个字符'
                }
            ]
        },
        content: {
            rules: [
                {
                    type: 'minLength[30]',
                    prompt: '内容不得少于30个字符'
                }
            ]
        }
    }
});

function checkSlug(slug, article_id = 0){
    if (slug){
        $.ajax({
            url: "/api/article/checkSlug",
            type: 'POST',
            data: {
                slug: slug,
                id: article_id
            },
            success: function(data){
                if(data.results.result === 1){
                    $('#article_form').form('add prompt', "slug", "当前别名已被占用");
                }
            }
        });
    }
}

$('#tags-div').dropdown({
    allowAdditions: true,
    apiSettings: {
        url: '/api/article/tags/{query}',
        throttle: 500    //请求间隔时间
    },
    fields: {
        value: 'slug'
    },
    filterRemoteData: true,
    saveRemoteData: false
});

$('#cates').dropdown();
$('#attr').dropdown();
$('#is_top').checkbox();
$('#cover_div .image').dimmer({on: 'hover'});

var editor = editormd("editormd", {
    height  : 600,
    path : '../editormd/lib/',
    toolbarIcons : function() {
        return editormd.toolbarModes['myeditor']
    },
});

function upload_cover() {
    $("#cover_file").click();
}
