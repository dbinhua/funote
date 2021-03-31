//替换url中的参数值
function changeURLArg(url, arg, arg_val){
    var pattern = arg + '=([^&]*)';
    var replaceText = arg + '=' + arg_val;
    if(url.match(pattern)){
        var tmp = '/(' + arg + '=)([^&]*)/gi';
        tmp = url.replace(eval(tmp), replaceText);
        return tmp;
    }else{
        if(url.match('[\?]')){
            return url + '&' + replaceText;
        }else{
            return url + '?' + replaceText;
        }
    }
}

//替换掉url中的page参数且跳转
$(".page-click").on('click',function(event){
    var page = $(event.target).attr('data-page');
    window.location = changeURLArg(window.location.href, 'page', page)
});

$('.update-book').on('click', function (event){
    var slug = $(event.target).attr('data-id');
    window.location = '/article/update/' + slug;
})
