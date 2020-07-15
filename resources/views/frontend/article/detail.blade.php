@extends('layouts.index')
@section('title', $info['title'])
@section('content')
    <style>
         blockquote {
             color: #666;
             border-left: none;
             background-color: #f5f8fc;
             padding: 1rem;
             margin-left: 0;
             margin-right: 0;
             font-size: 14px;
             font-style: italic;
         }

        li {
            margin-bottom: 14px;
        }

        p > code, li > code {
            background: rgba(90,87,87,0);
            margin: 5px;
            color: #858080;
            border-radius: 4px;
            background-color: #f9fafa;
            border: 1px solid #e4e4e4;
            max-width: 740px;
            overflow-x: auto;
            font-size: 14px;
            padding: 1px 5px;
        }

        pre > code {
            white-space: pre-wrap !important;
            word-wrap:break-word !important;
            max-width: inherit !important;
            line-height: 28px !important;
        }
    </style>

    <div class="ui centered grid container stackable">
        <div class="twelve wide column stacked">
            <div class="ui segment">
                <div style="padding: 13px;">
                    <h1 class="ui header center aligned">{{ $info['title'] }}</h1>
                    <p style="margin-bottom: 10px;text-align: center;">
                        <a data-tooltip="{{ $info['created_at'] }}">
                            <i class="icon clock outline small"></i><span>{{ $info['tranTime'] }}</span>
                        </a>
{{--                        <span class="divider">&nbsp;&nbsp;/&nbsp;&nbsp;</span>--}}
{{--                        <span><i class="icon star outline small"></i> 16</span>--}}
                        <span class="divider">&nbsp;&nbsp;/&nbsp;&nbsp;</span>
                        <a data-tooltip="本文有n个赞">
                            <span><i class="thumbs up outline icon"></i>23</span>
                        </a>
{{--                        <span class="divider">&nbsp;&nbsp;/&nbsp;&nbsp;</span>--}}
{{--                        <span><i class="icon comments outline small"></i> 4</span>--}}
                    </p>
                    <div class="ui divider"></div>
                    {!! $info['html'] !!}
                    @if($tags)
                    <div class="meta" style="margin: 35px 0px;">
                        <i class="icon tags"></i>
                        @foreach($tags as $tag)
                            <a class="ui label small blue" href="#">{{ $tag['name'] }}</a>
                        @endforeach
                    </div>
                    @endif

                    <div class="ui horizontal list">
                        <a class="popover item ui" data-content="关注主题，当评论和附言创建时将会被通知" href="javascript:void(0);" data-url="#" data-id="">
                            <div class="top aligned content">
                                <i class="icon star"></i> <span class="state">收藏</span>
                            </div>
                        </a>

                        <a class="popover item ui" href="#" title="分享本文到你的其他平台">
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

                    @if(count($recommend_articles))
                    <div class="ui middle aligned divided list">
                        @foreach($recommend_articles as $item)
                        <div class="item" style="height: 60px;">
                            <img class="ui avatar image" src="{{ asset('imgs/logo.png') }}">
                            <div class="content" style="width: 80%;">
                                    <span class="header" style="line-height: 57px;">
                                        <span class="ui label red">置顶</span>
                                        <a href="{{ route('detail', $item['slug']) }}">{{ $item['title'] }}</a>
                                    </span>
                            </div>
                            <div class="content" style="width: 16%;float: right;text-align: right;font-size: 10px;line-height: 57px;color: #C1C1C2">
                                    <span>
                                        <i class="heart outline icon"></i>15
                                        <span>&nbsp;|&nbsp;刚刚</span>
                                    </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- right sidebar start-->
        <div class="four wide column stackable">
            <div class="item header sidebar">
                <div class="ui card">
                    <div class="content">
                        @if(strpos($user_info['avatar'], 'http') === false)
                            <a href="#"><img class="ui avatar big image right floated" src="{{ asset($user_info['avatar']) }}"></a>
                        @else
                            <a href="#"><img class="ui avatar big image right floated" src="{{ $user_info['avatar'] }}"></a>
                        @endif

                        <div class="header" style="line-height: 2em;margin: 0 auto;">
                            <a href="#">{{ $user_info['name'] }}</a>
                        </div>

                        <div class="meta" style="font-size: 13px;">
                            面朝大海，春暖花开
                        </div>
                    </div>

                    <div class="statistics" style="border-top: 1px solid rgba(0, 0, 0, 0.05);padding-bottom: 15px;padding-top: 10px;">
                        <div class="ui three statistics">
                            <div class="statistic ui my-popup" data-content="发布了 16 篇文章" data-position="top center">
                                <div class="label" style="font-weight: normal;margin-bottom: 0.5em">
                                    文章
                                </div>
                                <div class="value" style="font-size: 1em!important;font-weight: bold;">
                                    16
                                </div>
                            </div>

                            <div class="statistic ui my-popup" data-content="收到了 566 个点赞" data-position="top center">
                                <div class="label" style="font-weight: normal;margin-bottom: 0.5em">
                                    喜欢
                                </div>
                                <div class="value" style="font-size: 1em!important;font-weight: bold;">
                                    566
                                </div>
                            </div>

                            <div class="statistic ui my-popup" data-content="所有文章被收藏了 5 次" data-position="top center">
                                <div class="label" style="font-weight: normal;margin-bottom: 0.5em">
                                    收藏
                                </div>
                                <div class="value" style="font-size: 1em!important;font-weight: bold;">
                                    5
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>

{{--                    <div class="extra content">--}}
{{--                        <div class="ui two buttons">--}}
{{--                            <div class="ui basic green button">私信</div>--}}
{{--                            <div class="ui basic red button">关注</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>

                <div class="ui segment">
                    <div>
                        <div class="ui secondary menu">
                            <a class="item tiny active" data-tab="fourth"><i class="fire icon"></i>热度榜</a>
                            <a class="item" data-tab="fifth"><i class="heart icon"></i>好评榜</a>
                        </div>
                        <div class="ui divider"></div>
                        <div class="ui tab active " data-tab="fourth">
                            <div class="ui items">
                                <div class="item">
                                    <i class="circular inverted red fire icon tiny"></i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">一只狗的故事</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="eye icon grey tiny"></i>3414</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted orange fire icon tiny"></i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">健谈</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="eye icon grey tiny"></i>3201</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted yellow fire icon tiny"></i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">毛泽东语录</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="eye icon grey tiny"></i>2780</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">4</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">真实的欺骗</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="eye icon grey tiny"></i>2011</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">5</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">Redis分布式集群部署</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="eye icon grey tiny"></i>1441</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">6</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">Vue入门到放弃</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="eye icon grey tiny"></i>1224</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">7</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">钢铁是怎样练成的</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="eye icon grey tiny"></i>914</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">8</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">PHP7源码分析</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="eye icon grey tiny"></i>344</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">9</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">TCP/IP协议详解（二）</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="eye icon grey tiny"></i>304</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">10</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">Spring框架</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="eye icon grey tiny"></i>47</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui tab " data-tab="fifth">
                            <div class="ui items">
                                <div class="item">
                                    <i class="circular inverted red heart icon tiny"></i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">一只狗的故事</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="comments icon grey tiny"></i>3414</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted orange heart icon tiny"></i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">健谈</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="comments icon grey tiny"></i>3201</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted yellow heart icon tiny"></i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">毛泽东语录</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="comments icon grey tiny"></i>2780</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">4</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">真实的欺骗</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="comments icon grey tiny"></i>2011</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">5</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">Vue入门到放弃</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="comments icon grey tiny"></i>1224</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">6</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">Redis分布式集群部署</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="comments icon grey tiny"></i>1441</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">7</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">TCP/IP协议详解（二）</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="comments icon grey tiny"></i>304</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">8</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">钢铁是怎样练成的</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="comments icon grey tiny"></i>914</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">9</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">PHP7源码分析</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="comments icon grey tiny"></i>344</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="circular inverted grey icon tiny">10</i>
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <a class="">Spring框架</a>
                                        <span style="font-size: 12px;color: grey;display: block;float: right"><i class="comments icon grey tiny"></i>47</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ui card">
                    <div class="content">
                        <div class=" text-center">
                            <i class="tags tiny icon"></i>热门标签
                        </div>
                    </div>

                    <div class="content" style="">
                        <a href="#" class="ui label blue" style="margin-top: 4px">ThinkPHP(32)</a>
                        <a href="#" class="ui label green" style="margin-top: 4px">Yii2(8)</a>
                        <a href="#" class="ui label orange" style="margin-top: 4px">Blog(2)</a>
                        <a href="#" class="ui label teal" style="margin-top: 4px">漏洞s(1)</a>
                        <a href="#" class="ui label yellow" style="margin-top: 4px">Sql注入</a>
                        <a href="#" class="ui label olive" style="margin-top: 4px">DDOS</a>
                        <a href="#" class="ui label violet" style="margin-top: 4px">VUE</a>
                        <a href="#" class="ui label red" style="margin-top: 4px">Semantic</a>
                        <a href="#" class="ui label teal" style="margin-top: 4px">Swift</a>
                        <a href="#" class="ui label green" style="margin-top: 4px">Xcode</a>
                        <a href="#" class="ui label yellow" style="margin-top: 4px">技巧</a>
                        <a href="#" class="ui label orange" style="margin-top: 4px">方式</a>
                        <a href="#" class="ui label blue" style="margin-top: 4px">队列</a>
                    </div>
                </div>

                <div class="ui card">
                    <div class="content">
                        <div class="text-center">
                            <i class="bug tiny icon"></i>报个BUG
                        </div>
                    </div>

                    <div class="content" style="">


                        <form class="ui form">
                            <div class="field">
                                <label>错误类别</label>
                                <div class="ui selection dropdown" id="error-div">
                                    <input type="hidden" name="error_type">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">功能异常</div>
                                    <div class="menu">
                                        <div class="item" data-value="1">功能异常</div>
                                        <div class="item" data-value="1">数据错误</div>
                                        <div class="item" data-value="0">UI错乱</div>
                                        <div class="item" data-value="0">优化与建议</div>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <label>问题描述</label>
                                <textarea rows="2"></textarea>
                            </div>

                            <div class="field">
                                <label>QQ/微信</label>
                                <input type="text" placeholder="QQ/微信">
                            </div>

                            <div class="ui fluid button blue" tabindex="0">提交</div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <!-- right sidebar end-->
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/prism.js?v=4.1') }}"></script>
    <script type="text/javascript">
        $('.my-popup').popup();
    </script>
@endsection
