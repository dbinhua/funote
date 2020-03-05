<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="Shortcut Icon" href="{{ asset('images/favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Site Properities -->
    <title>{{ config('app.name', 'Fun Note') }}</title>

    <meta name="description" content="记录一些工作心得和笔记，做一些有趣好玩的小玩意儿。它既是我的笔记本，也是我的练兵场。生命不息，折腾不止(≧∇≦)" />
    <meta name="keywords" content="blog, chat, lucius, 博客, 聊天室, swoole, laravel" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/semantic/semantic.min.css') }}">
</head>

<style>
    body {
        background: #6CC1F9;
    }
    .my-menu {
        color: #E0F2F1 !important;
    }
    .none-margin {
        margin: 0px !important;
    }
    .chat-active {
        background-color: rgb(229, 240, 250);
    }
    ::-webkit-scrollbar {display:none}
</style>
<body>
<div id="layout-container">
    <div id="layout-main">
        <div id="header">
            <div class="ui menu borderless secondary" style="position: absolute;height: 100%;width: 96%; left: 2%;">
                <a class="item my-menu" href="{{ route('index') }}"><i class="home icon"></i>首页</a>
                <div class="right menu">
                    @guest
                        <a class="ui item my-menu" onclick="login()"><i class="sign-in icon"></i>登录</a>
                    @else
                        <a class="ui item my-menu" onclick="logout()"><i class="sign-out icon"></i>登出</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
        <div id="body">
            <div id="menu-pannel">
                <div class="profile">
                    @auth
                        <img class="ui avatar rounded mini image" src="{{ Auth::user()->avatar }}">
                    @else
                        <img class="ui avatar rounded mini image" src="{{ asset('images/default_face.png') }}">
                    @endauth
                </div>
                <div class="ui vertical text menu" style="width: 80%;text-align: center">
                    <div style="height: 50px;margin-top: 20px;">

                        <a class="item active">
                            <i class="comments large icon none-margin"></i>
{{--                            <div class="floating ui mini red label circular">2</div>--}}
                        </a>
                    </div>
                    <div style="height: 50px;margin-top: 10px;">
                        <a class="item"><i class="address book large icon none-margin"></i></a>
                    </div>
                    <div style="position: absolute;left:0;bottom: 0;text-align: center;width: 100%">
                        <a class="item" href="{{ route('updatelog.chat',['chat']) }}" target="_blank">V0.4</a>
                    </div>
                </div>
            </div>

            <div id="menu-pannel-body">
                <div id="sub-menu-pannel" class="conv-list-pannel">
                    <div class="conv-lists-box" id="lists"></div>
                </div>
                <div id="content-pannel">
                    <div class="conv-detail-pannel">
                        <div class="content-pannel-body chat-box-new" id="chat-box">
                            <div class="main-chat chat-items" id="chat-lists">
                                <div class="msg-items" id="chatLineHolder"></div>
                            </div>
                        </div>

                        <div id="at-content" style="width: 135px;margin: 0px 0px 15px 15px;"></div>
                        <div class="faceDiv ui floated raised segment">
                            @foreach($emotion_data as $info)
                                <img value="{{ $info['title'] }}" src="{{ $info['path'] }}" />
                            @endforeach
                        </div>
                        <div class="send-msg-box-wrapper">
                            <div class="input-area">
                                <ul class="tool-bar">
                                    <li class="tool-item">
                                        <i class="iconfont tool-icon tipper-attached emotion_btn" title="表情"></i>
                                    </li>
{{--                                    <li class="tool-item">--}}
{{--                                        <i class="iconfont tool-icon icon-card tipper-attached" onclick="upload()" title="图片"></i>--}}
{{--                                    </li>--}}
                                </ul>
                                <span class="user-guide">Enter 发送 , Ctrl+Enter 换行</span>
                                <div class="msg-box" style="height:100%;">
                                    <textarea class="textarea input-msg-box" id="chattext"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="attach_lists"></div>
            </div>
        </div>
    </div>
</div>

<div class="ui basic modal">
    <div class="ui icon header">
        <i class="lightbulb icon"></i>
        友情提示
    </div>
    <div class="content">
        <p>登录用户可以体验更多功能哟，童鞋要不要登录试试呢？</p>
    </div>
    <div class="actions">
        <div class="ui red basic cancel inverted button">
            <i class="remove icon"></i>
            暂不
        </div>
        <div class="ui green ok inverted button" onclick="login()">
            <i class="checkmark icon"></i>
            登录
        </div>
    </div>
</div>

<input type="hidden" id="flag_login" value="@auth 1 @else 0 @endauth">
<input type="hidden" id="userinfo" value='@auth @json(Auth::user()) @endauth'>
@extends('layouts.components.login')
<script src="{{ asset('js/site/init.js?v=2') }}"></script>
<script src="{{ asset('js/site/tool.js') }}"></script>
<script src="{{ asset('js/site/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/site/dom.js') }}"></script>
<script src="{{ asset('js/site/chat.js') }}"></script>
<script src="{{ asset('js/site/semantic.min.js') }}"></script>
<script>
    var user_id = {{ Auth::user()->id ?? 0 }}
</script>
<script src="{{ asset('js/site/count_ws.js?v=2') }}"></script>
</body>
</html>
