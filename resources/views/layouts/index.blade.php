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

    <link rel="stylesheet" type="text/css" href="{{ asset('css/semantic/semantic.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/myapp.min.css') }}" />

    <!--banner-->
    @if(Route::is('index'))
        <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/Swiper/4.5.0/css/swiper.min.css" />
    @endif

    <link rel="stylesheet" type="text/css" href="{{ asset('css/markdown/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/markdown/simplemde.min.css') }}">
</head>
<body>
<div class="container">
    <!--nav start-->
    <nav class="ui borderless menu top stackable" style="margin-bottom: 40px;">
        <div class="ui container">
            <div class="ui inline dropdown nav">
                <a href="{{ route('index') }}">
                    <img class="ui avatar image"  src="{{ asset('images/logo.png') }}">
                    <span class="text"><b>Funote</b></span>
                </a>

            </div>

            <a href="{{ route('index') }}" class="item secondary">工作笔记</a>
            <a href="{{ route('chat') }}" class="item secondary">聊天室</a>
{{--                        <div class="ui simple item dropdown stackable secondary">--}}
{{--                            IT风向标  <i class="dropdown icon"></i>--}}

{{--                            <div class="ui menu stackable">--}}
{{--                                <a href="#" class="item">--}}
{{--                                    <i class="icon home"></i> 测试分类--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <form class="ui fluid search item secondary" action="#" method="GET">--}}
{{--                            <div class="ui icon input">--}}
{{--                                <input class="prompt" name="q" type="text" placeholder="搜索" autocomplete="off">--}}
{{--                                <i class="search icon"></i>--}}
{{--                            </div>--}}
{{--                            <div id="search-result"></div>--}}
{{--                        </form>--}}

            <div class="right menu stackable secondary">
                @auth
                    <div class="ui simple item dropdown stackable nav-dropdown">
                        @if(strpos($userInfo->avatar, 'http') === false)
                            <img class="ui avatar image" src="{{ asset($userInfo->avatar) }}">
                        @else
                            <img class="ui avatar image" src="{{ $userInfo->avatar }}">
                        @endif
                        {{ Auth::user()->name }}  <i class="dropdown icon"></i>
                        <div class="ui menu stackable">
                            <a href="{{ route('user', Auth::user()->id) }}" class="item">
                                <i class="icon user"></i> 个人中心
                            </a>

                            @if(Auth::user()->rank == \App\Models\User\UserRank::SUPERVISOR)
                                <a href="{{ route('article.edit') }}" class="item">
                                    <i class="icon pencil alternate"></i> 写作中心
                                </a>
                                <a href="{{ route('manager') }}" class="item">
                                    <i class="icon wrench"></i> 管理中心
                                </a>
                            @endif

                            <a  class="item no-pjax" onclick="logout()" data-method="POST">
                                <i class="icon sign out"></i> 退出登录
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @else
                    <div class="item">
                        <a onclick="login()" href="javascript:;"><i class="icon sign in"></i> 登录 </a>
                    </div>
                @endauth
            </div>

        </div>
    </nav>
    <!--nav end-->

    @yield('content')

    @extends('layouts.components.footer')
</div>
@extends('layouts.components.login')
</body>

<script src="{{ asset('js/site/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/site/init.js') }}"></script>
<script src="{{ asset('js/site/count_ws.js') }}"></script>
<script src="{{ asset('js/site/semantic.min.js') }}"></script>
<script src="{{ asset('js/pager.min.js') }}"></script>
@if(Route::is('index'))
    <script src="https://cdn.bootcss.com/Swiper/4.5.0/js/swiper.min.js"></script>
@endif


@yield('js')

<script type="text/javascript">
    var user_id = {{ Auth::user()->id ?? 0 }}

    $('#weibo-share').click(function () {
        if(user_id != 0){
            window.location = '{{ route('weibo.share') }}'
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
</script>
</html>
