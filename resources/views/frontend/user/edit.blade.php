@extends('layouts.index')
@section('title', '个人中心-修改资料')
@section('content')
    <div class="ui centered grid container stackable">
        <div class="twelve wide column stacked">
            <div class="ui segment" style="height: 300px;background-image: url({{ asset('images/personal.png') }});background-size: cover;border:0px;position:relative;">
                <div style="position:absolute; top:30%; right:0; left:0;text-align: center;">
                    <div class="ui circular image" id="avatar_div" style="border: 2px solid beige;display: inline-block;">
                        <div class="ui dimmer">
                            <div class="content">
                                <form class="ui form" method="POST" action="{{ route('article.create') }}" enctype="multipart/form-data" id="avatar_form">
                                    <input type="file" style="display: none" id="avatar" name="avatar">
                                    <i class="image outline icon" onclick="choose_img()"></i>
                                </form>
                            </div>
                        </div>
                        @if(strpos($userInfo->avatar, 'http') === false)
                            <img class="ui tiny circular centered image" src="{{ asset($userInfo->avatar) }}" id="avatar_img" style="width: 80px;height: 80px;">
                        @else
                            <img class="ui tiny circular centered image" src="{{ $userInfo->avatar }}" id="avatar_img" style="width: 80px;height: 80px;">
                        @endif
                    </div>
                    <h3 class="mb-4 mb-3" style="color: white;text-align: center">
                        {{ $userInfo->name }}&nbsp;
                        @if($userInfo->gender == 1)
                            <i class="circular tiny inverted blue mars icon"></i>
                        @elseif($userInfo->gender == 2)
                            <i class="circular tiny inverted pink venus icon"></i>
                        @else
                            <i class="circular tiny inverted black genderless icon"></i>
                        @endif
                    </h3>
                </div>
            </div>
            <div class="ui segment">
                <div style="padding:14px;">
                    <div class="ui icon message">
                        <i class="id badge icon"></i>
                        <div class="content">
                            <div class="header">填写你的基本信息</div>
                            <p>完善信息让大家都能了解你</p>
                        </div>
                    </div>
                    <div class="ui message hidden" id="info_tip"></div>
                    <form class="ui form">
                        <div class="field">
                            <label for="name">昵称</label>
                            <input type="text" id="name" name="name" placeholder="{{ $userInfo->name }}">
                        </div>
                        <div class="two fields">
                            <div class="field">
                                <label>性别</label>
                                <div class="ui fluid search selection dropdown" id="gender">
                                    <input type="hidden" name="gender">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">无性向</div>
                                    <div class="menu">
                                        <div class="item" data-value=1>
                                            <i class="circular tiny inverted blue mars icon"></i>小哥哥
                                        </div>
                                        <div class="item" data-value=2>
                                            <i class="circular tiny inverted pink venus icon"></i>小姐姐
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <label>星座</label>
                                <div class="ui fluid search selection dropdown" id="constellation">
                                    <input type="hidden" name="constellation">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">选择星座</div>
                                    <div class="menu">
                                        @foreach(\App\Models\User\Constellations::MAP as $key => $item)
                                            <div class="item" data-value = '{{ $key }}'>{{ $item }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label>职业</label>
                            <div class="ui fluid search selection dropdown" id="profession">
                                <input type="hidden" name="profession">
                                <i class="dropdown icon"></i>
                                <div class="default text">选择职业</div>
                                <div class="menu">
                                    @foreach(\App\Models\User\Professions::MAP as $key => $item)
                                        <div class="item" data-value = '{{ $key }}'>{{ $item }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="ui right floated black button" id="info_button"><i class="icon save"></i>保存</button>
                        </div>
                    </form>
                    <div class="ui divider hidden" style="margin-top: 28px"></div>
                </div>
            </div>
            <div class="ui segment">
                <div style="padding: 14px;">
                    <div class="ui icon message">
                        <i class="id lock icon"></i>
                        <div class="content">
                            <div class="header">设置或修改你的密码</div>
                            <p>常改密码让你的账号更安全</p>
                        </div>
                    </div>
                    <form class="ui form">
                        @if(!$userInfo->password)
                            <div class="field">
                                <label for="psword">密码</label>
                                <input type="password" id="psword" name="psword" placeholder="请设置新密码">
                            </div>
                            <div class="field">
                                <label for="repsword">密码确认</label>
                                <input type="password" id="repsword" name="repsword" placeholder="请再次确认密码">
                            </div>
                        @else
                            <div class="field">
                                <label for="psword">原密码</label>
                                <input type="password" id="psword" name="psword" placeholder="请输入原密码">
                            </div>
                            <div class="field">
                                <label for="new_psword">新密码</label>
                                <input type="password" id="new_psword" name="new_psword" placeholder="请输入新密码">
                            </div>
                        @endif

                        <button class="ui right floated black button"><i class="icon save"></i>保存</button>
                    </form>
                    <div class="ui divider hidden" style="margin-top: 28px"></div>
                </div>
            </div>
            <div class="ui segment">
                <div style="padding: 14px;">
                    <div class="ui icon message">
                        <i class="id shield alternate icon"></i>
                        <div class="content">
                            <div class="header">绑定你的其他账号</div>
                            <p>想接收个性化推荐或者让别人瞧瞧你的微博？绑定就是了！</p>
                        </div>
                    </div>
                    <form class="ui form">
                        <div class="field">
                            <label for="email">邮箱
                                <i class="info icon link blue" id="email-tip" data-content="绑定后即可根据邮箱登录哦" data-variation="mini" data-position="right center"></i></label>
                            <input type="text" id="email" name="email" placeholder="{{ $userInfo->email }}" value="{{ $userInfo->email }}">
                        </div>

                        <button class="ui right floated black button" style="margin-bottom: 50px"><i class="icon save"></i>保存</button>
                    </form>
                    <div class="ui divider hidden" style="margin-top: 28px"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('js/edit_user.js') }}"></script>
<script type="text/javascript">
    $('.ui .form').form('set values', {
        name: '{{ $userInfo->name }}',
        gender: '{{ $userInfo->gender }}',
        constellation: '{{ $userInfo->constellation }}',
        profession: '{{ $userInfo->profession }}'
    });
</script>
@endsection
