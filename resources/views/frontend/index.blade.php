@extends('layouts.index')
@section('title', '首页')
@section('content')
    <!-- 推荐位start -->
    @if(count($recommend_data) > 2)
    <div class="swiper-container-solution">
        <div class="selected-solution">
            <div>
                <div class="swiper-container">
                    <div class="solution-cardlist swiper-wrapper">
                        @foreach($recommend_data as $item)
                            <div class="col-sm-4 swiper-slide">
                                <div class="solution-card">
                                    <img src="{{ asset($item['cover']) }}" width="100%" alt="{{ $item['title'] }}">
                                    <h3>{{ $item['title'] }}</h3>
                                    <p>{{ $item['intro'] }}</p>
                                    <span>
                                    <a href="{{ route('detail', $item['slug']) }}"><span class="arrow-more">了解详情</span><span class="arrow-f"></span></a>
                                </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination solution-pagination"></div>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>
    @endif
    <!-- 推荐位end -->
    <div class="ui centered grid container stackable">
        <div class="twelve wide column stacked">
            <div class="ui segment" style="padding: 0px 6px 10px 6px;">
                <div style="padding: 14px;">
                    <h2 class="ui header blue" style="margin-top: 14px;">
                        <i class="gem icon"></i>
                        <div class="content">今日推荐</div>
                    </h2>

                    <div class="ui hidden divider"></div>
                    <div class="ui divided items">
                        @foreach($recommend_data as $item)
                        <div class="item">
                            <div class="image">
{{--                                <a class="ui red left corner label">--}}
{{--                                    <i class="heart icon"></i>--}}
{{--                                </a>--}}
                                <img src="{{ $item['cover'] }}">
                            </div>
                            <div class="content">
                                <a class="header" href="{{ route('detail', $item['slug']) }}">{{ $item['title'] }}</a>
                                <div class="description" style="min-height: 38px">
                                    <p>{{ $item['intro'] }}</p>
                                </div>
                                <div class="extra">
                                    <div class="ui right floated primary mini button basic" onclick="redirect('{{ route('detail', $item['slug']) }}')">
                                        阅读详情 <i class="right chevron icon"></i>
                                    </div>
                                    <div class="ui label">Limited</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <div class="ui segment" style="padding: 0px 6px 10px 6px;">
                <div style="padding: 14px;">

                    <div class="ui two column relaxed grid">
                        <div class="column">
                            <h3 class="ui header blue" style="margin-top: 14px;">
                                <i class="book icon"></i>
                                <div class="content">运维日记</div>
                            </h3>
                            <div class="ui hidden divider"></div>

                            <div class="ui very relaxed items">
                                @foreach($recommend_data as $item)
                                <div class="item">
                                    <div class="ui tiny image">
                                        <img src="{{ $item['cover'] }}">
                                    </div>
                                    <div class="middle aligned content">
                                        <a class="header" onclick="redirect('{{ route('detail', $item['slug']) }}')">{{ $item['title'] }}</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="column">
                            <h3 class="ui header blue" style="margin-top: 14px;">
                                <i class="map signs icon"></i>
                                <div class="content">风向标</div>
                            </h3>
                            <div class="ui hidden divider"></div>

                            <div class="ui very relaxed items">
                                @foreach($recommend_data as $item)
                                    <div class="item">
                                        <div class="ui tiny image">
                                            <img src="{{ $item['cover'] }}">
                                        </div>
                                        <div class="middle aligned content">
                                            <a class="header" onclick="redirect('{{ route('detail', $item['slug']) }}')">{{ $item['title'] }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- right sidebar start-->
        <div class="four wide column stackable">
            <div class="item header sidebar">
                <div class="ui segment responsive">
                    <div id="context2">
                        <div class="ui secondary menu">
                            <a class="item tiny active" data-tab="fourth"><i class="fire icon"></i>热度榜</a>
                            <a class="item" data-tab="fifth"><i class="heart icon"></i>收藏榜</a>
                        </div>
                        <div class="ui divider"></div>
                        <div class="ui tab active " data-tab="fourth">
                            <div class="ui items">
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted red fire icon small"></i>
                                        <a class="">一只狗的故事</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="eye icon grey tiny"></i>&nbsp;&nbsp;3414</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted orange fire icon small"></i>
                                        <a class="">健谈</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="eye icon grey tiny"></i>&nbsp;&nbsp;33201</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted yellow fire icon small"></i>
                                        <a class="">毛泽东语录</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="eye icon grey tiny"></i>&nbsp;&nbsp;32780</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">4</i>
                                        <a class="">真实的欺骗</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="eye icon grey tiny"></i>&nbsp;&nbsp;32011</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">5</i>
                                        <a class="">Redis分布式集群部署</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="eye icon grey tiny"></i>&nbsp;&nbsp;31441</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">6</i>
                                        <a class="">Vue入门到放弃</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="eye icon grey tiny"></i>&nbsp;&nbsp;31224</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">7</i>
                                        <a class="">钢铁是怎样练成的</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="eye icon grey tiny"></i>&nbsp;&nbsp;3914</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">8</i>
                                        <a class="">PHP7源码分析</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="eye icon grey tiny"></i>&nbsp;&nbsp;3344</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">9</i>
                                        <a class="">TCP/IP协议详解（二）</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="eye icon grey tiny"></i>&nbsp;&nbsp;3304</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">10</i>
                                        <a class="">Spring框架</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="eye icon grey tiny"></i>&nbsp;&nbsp;347</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui tab " data-tab="fifth">
                            <div class="ui items">
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted red heart icon small"></i>
                                        <a class="">一只狗的故事</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="comments icon grey tiny"></i>&nbsp;&nbsp;3414</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted orange heart icon small"></i>
                                        <a class="">健谈</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="comments icon grey tiny"></i>&nbsp;&nbsp;33201</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted yellow heart icon small"></i>
                                        <a class="">毛泽东语录</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="comments icon grey tiny"></i>&nbsp;&nbsp;32780</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">4</i>
                                        <a class="">真实的欺骗</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="comments icon grey tiny"></i>&nbsp;&nbsp;32011</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">5</i>
                                        <a class="">Vue入门到放弃</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="comments icon grey tiny"></i>&nbsp;&nbsp;31224</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">6</i>
                                        <a class="">Redis分布式集群部署</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="comments icon grey tiny"></i>&nbsp;&nbsp;31441</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">7</i>
                                        <a class="">TCP/IP协议详解（二）</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="comments icon grey tiny"></i>&nbsp;&nbsp;3304</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">8</i>
                                        <a class="">钢铁是怎样练成的</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="comments icon grey tiny"></i>&nbsp;&nbsp;3914</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">9</i>
                                        <a class="">PHP7源码分析</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="comments icon grey tiny"></i>&nbsp;&nbsp;3344</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content" style="height: 25px;line-height: 25px;text-align: left;font-size: 14px;padding-left: 5px">
                                        <i class="circular inverted grey icon small">10</i>
                                        <a class="">Spring框架</a>
                                        <span style="font-size: 12px;display: block;float: right"><i class="comments icon grey tiny"></i>&nbsp;&nbsp;347</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


{{--                <div class="ui card responsive">--}}
{{--                    <div class="content" style="padding: 0px;">--}}
{{--                        <a class="" href="https://www.ucloud.cn/site/active/cdn-ufile.html?ytag=laravelcdn" target="_blank" style="display: block;border-top: 1px solid #d3e0e9;border-bottom: 1px solid #d3e0e9;">--}}
{{--                            <img src="../imgs/02.jpeg" class="ui popover" data-variation="inverted" data-content="服务器赞助商：UCloud" width="100%">--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="ui card responsive">
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

                <div class="ui card responsive">
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
    <script type="text/javascript">
        var mySwiper = new Swiper(".swiper-container", {

            autoplay: {
                delay: 6000, //6秒切换一次
            },
            speed: 300,
            slidesPerView: 3,
            spaceBetween: 10,
            slidesPerGroup: 3,
            loop: true,

            //分页索引
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },

            //分页按钮
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            }

        });

        $('.col-sm-4').mouseover(function(){
            mySwiper.autoplay.stop();
        });

        $('.col-sm-4').mouseout(function(){
            mySwiper.autoplay.start();
        });

        function redirect(url) {
            if(url){
                window.location.href = url;
            }
        }
    </script>
@endsection
