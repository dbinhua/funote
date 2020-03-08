var upload_res = false;
$("#avatar").on('change',function(){
    var objUrl = getObjectURL(this.files[0]);
    if (objUrl) {
        upload_avatar();
        if (upload_res === true){
            $("#avatar_img").attr("src", objUrl);
        }
    }
});

function upload_avatar(){
    form = $('#avatar_form')[0];
    formdata = new FormData(form);
    $.ajax({
        url: "/api/user/uploadImg",
        type: 'POST',
        data: formdata,
        async: false,         //这个很重要！不设置后台无法收到file
        cache: false,         //上传文件不需要缓存
        contentType: false,   //form已经申明了，所以这里设置为false
        processData: false,   //data是formdata，不需要对数据做处理
        success: function(data){
            upload_res = data.results.result;
        }
    });
}

$('.ui.form').form({
    inline: true,
    on: 'blur',
    fields: {
        name: {
            rules: [
                {
                    type: 'empty',
                    prompt: '昵称不能为空'
                },
                {
                    type: 'regExp[/^[\u4e00-\u9fa5_a-zA-Z_]*$/]',
                    prompt: '只能包含中文、字母和"_"'
                },
                {
                    type: 'minLength[3]',
                    prompt: '至少输入3个字符'
                },
                {
                    type: 'maxLength[20]',
                    prompt: '昵称太长啦！不要超过20个字符哦'
                }
            ]
        }
    }
})

$('#info_button').api({
    serializeForm: true,
    url: '/api/user/update',
    method: 'POST',
    onSuccess: function (response) {
        if(response.results.result === true){
            $('#info_tip')[0].classList.add('positive');
            $('#info_tip')[0].innerHTML = '<p style="text-align: center">修改成功</p>';
        }else{
            $('#info_tip')[0].classList.add('negative');
            $('#info_tip')[0].innerHTML = '<p style="text-align: center">修改失败</p>';
        }
        $('#info_tip')[0].classList.remove('hidden');
        setTimeout(function () {
            $('#info_tip')[0].classList.add('hidden');
        }, 3000);
    }
});

$('#gender').dropdown();
$('#constellation').dropdown();
$('#profession').dropdown();
$('#email-tip').popup();
$('#avatar_div').dimmer({on: 'hover'});

function choose_img() {
    $('#avatar').click();
}
