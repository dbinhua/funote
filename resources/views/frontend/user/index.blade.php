@extends('layouts.index')
@section('title', '个人中心')
@section('content')
    <div class="ui centered grid container stackable">
        <div class="twelve wide column stacked">
            <div class="ui segment" style="height: 300px;background-image: url({{ asset('images/personal.png') }});background-size: cover;border:0px;position:relative;">
                @if(Auth::check() && Auth::user()->id == $user_info->id)
                <a class="ui blue right ribbon label" href="{{ route('user.edit') }}"><i class="edit icon"></i>编辑资料</a>
                @endif
                <div style="position:absolute; top:30%; right:0; left:0;text-align: center;">
                    <div class="ui circular image" style="border: 2px solid beige;display: inline-block;">
                        @if(strpos($user_info->avatar, 'http') === false)
                            <img class="ui tiny circular centered image" src="{{ asset($user_info->avatar) }}" id="avatar" style="width: 80px;height: 80px;">
                        @else
                            <img class="ui tiny circular centered image" src="{{ $user_info->avatar }}" id="avatar" style="width: 80px;height: 80px;">
                        @endif

                    </div>
                    <h3 class="mb-4 mb-3" style="color: white;text-align: center">
                        {{ $user_info->name }}&nbsp;
                        @if($user_info->gender == 1)
                            <i class="circular tiny inverted blue mars icon"></i>
                        @elseif($user_info->gender == 2)
                            <i class="circular tiny inverted pink venus icon"></i>
                        @else
                            <i class="circular tiny inverted black genderless icon"></i>
                        @endif
                    </h3>
                </div>
            </div>
            <div class="ui segment">
                <div style="padding:14px;">
                    <div class="ui feed" style="padding: 0px 14px;">
                        <h3 class="mb-4 mb-3">
                            <i class="icon feed"></i>
                            @if(Auth::check() && Auth::user()->id == $user_info->id)
                                我的动态
                            @else
                                Ta 的动态
                            @endif
                        </h3>
                        <div class="event">
                            <div class="label">
                                <img src="../../../images/logo.png">
                            </div>
                            <div class="content">
                                <div class="summary"><a class="user"> Elliot Fu </a> added you as a friend <div class="date">1 小时前 </div>
                                </div>
                                <div class="meta">
                                    <a class="like"><i class="like icon"></i> 4 Likes </a>
                                </div>
                            </div>
                        </div>
                        <div class="ui divider"></div>
                        <div class="event">
                            <div class="label">
                                <img src="../../../images/logo.png">
                            </div>
                            <div class="content">
                                <div class="summary"><a>Helen Troy</a> 增加 <a>2 新的 illustrations</a> <div class="date">4 天前 </div>
                                </div>
                                <div class="extra images">
                                    <a><img src="../../../images/logo.png"></a>
                                    <a><img src="../../../images/logo.png"></a>
                                </div>
                                <div class="meta">
                                    <a class="like"><i class="like icon"></i> 1 Like </a>
                                </div>
                            </div>
                        </div>
                        <div class="ui divider"></div>
                        <div class="event">
                            <div class="label">
                                <img src="../../../images/logo.png">
                            </div>
                            <div class="content">
                                <div class="summary"><a class="user"> Jenny Hess </a> 将你加为好友 <div class="date">2 天前 </div>
                                </div>
                                <div class="meta">
                                    <a class="like"><i class="like icon"></i> 8 Likes </a>
                                </div>
                            </div>
                        </div>
                        <div class="ui divider"></div>
                        <div class="event">
                            <div class="label">
                                <img src="../../../images/logo.png">
                            </div>
                            <div class="content">
                                <div class="summary"><a>Joe Henderson</a> posted on his page <div class="date">3 天前 </div>
                                </div>
                                <div class="extra text">Ours is a life of constant reruns. We're always circling back to where we'd we started, then starting all over again. Even if we don't run extra laps that day, we surely will come back for more of the same another day soon. </div>
                                <div class="meta">
                                    <a class="like"><i class="like icon"></i> 5 Likes </a>
                                </div>
                            </div>
                        </div>
                        <div class="ui divider"></div>
                        <div class="event">
                            <div class="label">
                                <img src="../../../images/logo.png">
                            </div>
                            <div class="content">
                                <div class="summary"><a>Justen Kitsune</a> 上传 <a>2 张关于你的照片</a> <div class="date">4 天前 </div>
                                </div>
                                <div class="extra images">
                                    <a><img src="../../../images/logo.png"></a>
                                    <a><img src="../../../images/logo.png"></a>
                                </div>
                                <div class="meta">
                                    <a class="like"><i class="like icon"></i> 41 Likes </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
