<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, shrink-to-fit=no">

    <link rel="Shortcut Icon" href="{{ asset('images/favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Fun Note') }} - @yield('title')</title>

    <meta name="description" content="记录一些工作心得和笔记，做一些有趣好玩的小玩意儿。它既是我的笔记本，也是我的练兵场。生命不息，折腾不止(≧∇≦)" />
    <meta name="keywords" content="blog, chat, lucius, 博客, 聊天室, swoole, laravel" />

    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/semantic/dist/semantic.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/myapp.min.css') }}" />

    <!--banner-->
    @if(Route::is('index'))
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    @endif

    <link rel="stylesheet" type="text/css" href="{{ asset('css/markdown/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('editormd/css/editormd.css') }}">
</head>
<body>
<div class="container">
    @include('layouts.components.nav')
    @yield('content')
    @include('layouts.components.footer')
</div>
    @include('layouts.components.login')
</body>

<script src="{{ asset('js/site/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/site/init.js') }}"></script>
<script src="{{ asset('js/site/count_ws.js') }}"></script>
<script src="{{ asset('semantic/semantic/dist/semantic.min.js') }}"></script>
<script src="{{ asset('js/pager.min.js') }}"></script>
<script src="{{ asset('editormd/editormd.js') }}"></script>
@if(Route::is('index'))
    <script src="https://unpkg.com/swiper@6.5.4/swiper-bundle.min.js"></script>
@endif

@yield('js')

<script type="text/javascript">
    var user_id = {{ Auth::user()->id ?? 0 }}

    $('#weibo-share').click(function () {
        if(user_id !== 0){
            {{--window.location = '{{ route('weibo.share') }}'--}}
        }else{
            $('.ui.mini.modal').modal({
                blurring: true
            }).modal('show');
        }
    });

    $('.menu .item').tab();
    $('#error-div').dropdown();

    $("#pager").zPager({
        totalData: 50,
        htmlBox: $('#wraper'),
        btnShow: true,
        ajaxSetData: false
    });

    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL != undefined) {
            url = window.createObjectURL(file);
        } else if (window.URL != undefined) {
            url = window.URL.createObjectURL(file);
        } else if (window.webkitURL != undefined) {
            url = window.webkitURL.createObjectURL(file);
        }
        return url ;
    }

    function shareToWeibo(shareContent){
        $.ajax({
            url: "/api/weibo/share",
            type: 'POST',
            data: {
                shareContent: shareContent
            },
            success: function(data){
                if(data.results.result === 1){
                    $('#share-success-tip').attr('display', "block");
                }else{

                }
            }
        });
    }
</script>
</html>
