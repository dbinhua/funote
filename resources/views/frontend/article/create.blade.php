@extends('layouts.index')
@section('title', '写作中心')
@section('content')
    <style>
        .editormd-preview-container blockquote, .editormd-html-preview blockquote {
            color: #666;
            border-left: none;
            background-color: #f5f8fc;
            padding: 1rem;
            margin-left: 0;
            font-size: 14px;
            font-style: italic;
        }
    </style>
<div class="ui centered grid container stackable">
    <div class="sixteen wide column stacked">
        <div class="ui segment">
            <div class="content">
                <div class="ui header gery" style="margin:40px auto;text-align: center;color: grey">
                    新建文章
                </div>

                <form class="ui form" method="POST" action="{{ route('article.create') }}" enctype="multipart/form-data" id="article_form" name="article_form">
                    @csrf
                    <div class="card" id="cover_div" style="float: right;">
                        <div class="blurring dimmable image">
                            <div class="ui dimmer">
                                <div class="content">
                                    <div class="center">
                                        <input type="file" style="display: none" id="cover_file" name="cover">
                                        <div class="ui inverted button" onclick="upload_cover()">上传封面</div>
                                    </div>
                                </div>
                            </div>
                            <img src="{{ asset('images/default_cover.png') }}" alt="" class="ui image rounded Medium" style="width: 300px;height: 175px" id="cover_img">
                        </div>
                    </div>

                    <div class="two fields">
                        <div class="field">
                            <label for="title">标题</label>
                            <input type="text" name="title" id="title" placeholder="标题">
                        </div>
                        <div class="field">
                            <label for="slug">别名</label>
                            <input type="text" name="slug" id="slug" placeholder="别名" onblur="checkSlug(this.value)">
                        </div>
                    </div>

                    <div class="two fields">
                        <div class="field">
                            <label>属性</label>
                            <div class="ui fluid search selection dropdown" id="attr">
                                <input type="hidden" name="attr">
                                <i class="dropdown icon"></i>
                                <div class="default text">选择属性</div>
                                <div class="menu">
                                    <div class="item" data-value=1>原创</div>
                                    <div class="item" data-value=2>转载</div>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label>分类</label>
                            <div class="ui fluid search selection dropdown" id="cates">
                                <input type="hidden" name="cate_id">
                                <i class="dropdown icon"></i>
                                <div class="default text">选择分类</div>
                                <div class="menu">
                                    <div class="item" data-value=1>技术博客</div>
                                    <div class="item" data-value=2>生活分享</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label>选择标签（Tab 键可创建新标签）</label>
                        <div class="ui search multiple selection dropdown" id="tags-div">
                            <input type="hidden" name="tags">
                            <i class="dropdown icon"></i>
                            <input type="text" class="search">
                            <div class="default text">请选择标签（选填）</div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="intros">摘要</label>
                        <textarea rows="2" name="intro" id="intros"></textarea>
                    </div>

                    <div class="field" id="editormd">
                        <label for="body-field"></label>
                        <textarea rows="15" id="body-field" name="content" style="display:none;"></textarea>
                    </div>

                    <div class="inline field">
                        <div class="ui toggle checkbox" id="is_top">
                            <input type="checkbox" class="hidden" name="top" id="top">
                            <label for="top">是否置顶</label>
                        </div>
                    </div>

                    <div contenteditable="true"></div>

                    <div class="ui message">
                        <button class="ui button primary" onclick="document.forms['article_form'].act.value='pub'">
                            <i class="icon send"></i>发布文章
                        </button>
                        &nbsp;&nbsp;or&nbsp;&nbsp;
                        <button class="ui button" onclick="document.forms['article_form'].act.value='draft'">
                            <i class="icon save"></i> 保存草稿
                        </button>
                    </div>

                    <input type="hidden" name='act' value="draft"/>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/create_article.js') }}"></script>
@endsection
