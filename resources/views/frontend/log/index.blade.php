@extends('layouts.index')
@section('title', '开发日志')
@section('content')

    <div class="ui centered grid container stackable">
        <div class="twelve wide column stacked">
            <div class="ui segment">
                <div style="padding: 13px;">
                    <h1 class="ui header center aligned">WebChat 更新日志</h1>
                    <p style="margin-bottom: 10px;text-align: center;">
                        <a data-tooltip="2019-12-07 06:40:36">
                            <i class="icon clock outline small"></i>  <span>7小时前</span>
                        </a>
                        <span class="divider">&nbsp;&nbsp;/&nbsp;&nbsp;</span>
                        <span><i class="icon star outline small"></i> 16</span>
                        <span class="divider">&nbsp;&nbsp;/&nbsp;&nbsp;</span>
                        <span><i class="thumbs up outline icon"></i> 23</span>
                        <span class="divider">&nbsp;&nbsp;/&nbsp;&nbsp;</span>
                        <span><i class="icon comments outline small"></i> 4</span>


                    </p>
                    <div class="ui divider"></div>
{{--                    {{ $html }}--}}
{{--                    <div class="meta" style="margin: 35px 0px;">--}}
{{--                        <i class="icon tags"></i>--}}
{{--                        <a class="ui label small blue" href="#">laravel</a>--}}
{{--                        <a class="ui label small blue" href="#">laradock</a>--}}
{{--                        <a class="ui label small blue" href="#">docker</a>--}}
{{--                    </div>--}}

                    <div class="ui horizontal list">
                        <a class="popover item ui" data-content="关注主题，当评论和附言创建时将会被通知" href="javascript:void(0);" data-url="#" data-id="">
                            <div class="top aligned content">
                                <i class="icon star"></i> <span class="state">收藏</span>
                            </div>
                        </a>

                        <a class="popover item ui" href="#" title="当你发现文章里有错误时，请点此给作者提交纠错建议">
                            <div class="top aligned content">
                                <i class="icon share alternate"></i> 分享
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="ui segment" style="padding: 0px 6px;">
                <div style="padding: 0px 14px 14px 14px;">
                    <h4 style="margin-top: 25px;">
                        <i class="icon check green"></i> 推荐文章：
                    </h4>

                    <div class="ui middle aligned divided list">
                        <div class="item" style="height: 60px;">
                            <img class="ui avatar image" src="{{ asset('imgs/logo.png') }}">
                            <div class="content" style="width: 80%;">
                                    <span class="header" style="line-height: 57px;">
                                        <span class="ui label red">置顶</span>
                                        <a>新课程发布：《Laravel 性能优化入门》</a>
                                    </span>
                            </div>
                            <div class="content" style="width: 16%;float: right;text-align: right;font-size: 10px;line-height: 57px;color: #C1C1C2">
                                    <span>
                                        <i class="heart outline icon"></i>15
                                        <span>&nbsp;|&nbsp;刚刚</span>
                                    </span>
                            </div>
                        </div>

                        <div class="item" style="height: 60px;">
                            <img class="ui avatar image" src="../imgs/logo.png">
                            <div class="content" style="width: 80%;">
                                    <span class="header" style="line-height: 53px;">
                                        <span class="ui label grey">转载</span>
                                        <a>短链的秘密 --来自掘金专栏</a>
                                    </span>
                            </div>
                            <div class="content" style="width: 16%;float: right;text-align: right;font-size: 10px;line-height: 57px;color: #C1C1C2">
                                    <span>
                                        <i class="heart outline icon"></i>15
                                        <span>&nbsp;|&nbsp;刚刚</span>
                                    </span>
                            </div>
                        </div>
                        <div class="item" style="height: 60px;">
                            <img class="ui avatar image" src="../imgs/logo.png">
                            <div class="content" style="width: 80%;">
                                    <span class="header" style="line-height: 53px;">
                                        <span class="ui label grey">转载</span>
                                        <a>短链的秘密 --来自掘金专栏</a>
                                    </span>
                            </div>
                            <div class="content" style="width: 16%;float: right;text-align: right;font-size: 10px;line-height: 57px;color: #C1C1C2">
                                    <span>
                                        <i class="heart outline icon"></i>15
                                        <span>&nbsp;|&nbsp;刚刚</span>
                                    </span>
                            </div>
                        </div>
                        <div class="item" style="height: 60px;">
                            <img class="ui avatar image" src="../imgs/logo.png">
                            <div class="content" style="width: 80%;">
                                    <span class="header" style="line-height: 53px;">
                                        <span class="ui label grey">转载</span>
                                        <a>短链的秘密 --来自掘金专栏</a>
                                    </span>
                            </div>
                            <div class="content" style="width: 16%;float: right;text-align: right;font-size: 10px;line-height: 57px;color: #C1C1C2">
                                    <span>
                                        <i class="heart outline icon"></i>15
                                        <span>&nbsp;|&nbsp;刚刚</span>
                                    </span>
                            </div>
                        </div>

                        <div class="item" style="height: 60px;">
                            <img class="ui avatar image" src="../imgs/02.jpeg">
                            <div class="content" style="width: 80%;">
                                    <span class="header" style="line-height: 57px;">
                                        <span class="ui label grey">转载</span>
                                        <a>短链的秘密 --来自掘金专栏</a>
                                    </span>
                            </div>
                            <div class="content" style="width: 16%;float: right;text-align: right;font-size: 10px;line-height: 57px;color: #C1C1C2">
                                    <span>
                                        <i class="heart outline icon"></i>15
                                        <span>&nbsp;|&nbsp;刚刚</span>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
