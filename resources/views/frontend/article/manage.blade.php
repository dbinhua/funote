@extends('layouts.index')
@section('title', '个人中心')
@section('content')
    <div class="ui centered grid container stackable">
        <div class="sixteen wide column stacked">
            @if(count($articles))
                <div class="ui segment" id="example1" style="border: 0;height: 1122px;position: relative;">

                    <div class="ui secondary menu" id="opt">
                        <a class="item active" data-tab="all">全部</a>
                        <a class="item" data-tab="up">已上架</a>
                        <a class="item" data-tab="df">提审中</a>
                        <a class="item" data-tab="gf">已驳回</a>
                        <a class="item" data-tab="aa">草稿</a>
                    </div>

                    <div class="ui divider"></div>
                    @include('layouts.components.left-rail-menu')
                    <div class="ui two column grid">
                        @foreach($articles as $book)
                            <div class="column">
                                <div class="ui card {{ $book['tipColor'] }}" style="width: 100%;flex-direction: row;">
                                    <div style="width: 100%;margin: 10px;padding: 15px">
                                        <h3 class="ui header">
                                            <div class="content"><a href="{{ route('detail', $book['slug']) }}">{{ $book['title'] }}</a>
                                            </div>
                                        </h3>
                                        <button class="ui primary basic mini button update-book" data-id="{{ $book['slug'] }}" style="margin: 8px">编辑文章</button>
                                        <button class="ui red basic mini button remove-book" data-id="{{ $book['slug'] }}" style="margin: 8px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;删除&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                    </div>

                                    <div class="image" style="margin: 10px;">
                                        <span class="ui right ribbon label {{ $book['tipColor'] }}">{{ $book['statusText'] }}</span>
                                        <a href="{{ route('detail', $book['slug']) }}">
                                            <img src="{{ asset($book['cover']) }}" style="width: 135px;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @include('layouts.components.pager')

                    <div class="ui mini modal" id="remove-tip">
                        <i class="close icon"></i>
                        <div class="header">
                            删除此作品
                        </div>
                        <div class="image content">
                            <div class="description">
                                作品删除后不可恢复，确认删除吗？
                            </div>
                        </div>
                        <div class="actions">
                            <div class="ui green button deny">取消</div>
                            <div class="ui red basic button approve">删除</div>
                        </div>
                    </div>

                    <div class="ui mini modal" id="remove-success">
                        <div class="ui success message" style="text-align: center;">
                            <span>删除成功</span>
                        </div>
                    </div>

                    <div class="ui mini modal" id="remove-faild">
                        <div class="ui negative message" style="text-align: center;">
                            <span>删除失败</span>
                        </div>
                    </div>

                </div>
            @else
                <div class="ui placeholder segment" style="background-color: #fff;height:70vh;" id="example1">
                    @include('layouts.components.left-rail-menu')
                    <div class="ui icon header" style="margin-top: -36px;"><i class="inbox icon"></i> 您还没有作品哦，快来写点东西吧 </div>
                    <a href="{{ route('center.create-book') }}">
                        <div class="ui primary button">创建作品</div>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/manage.js') }}"></script>
    <script src="{{ asset('js/create_article.js') }}"></script>
    <script>
        $('#gender-dropdown').dropdown();
        $('.ui.sticky').sticky({context: '#example1', offset: 20});
        $('.my-popup').popup();
        $('#opt .item').tab();
    </script>
@endsection
